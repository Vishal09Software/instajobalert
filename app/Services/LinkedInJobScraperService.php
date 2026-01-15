<?php

namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Str;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Models\JobCategory;
use App\Models\JobType;

class LinkedInJobScraperService
{
    protected $client;
    protected $perPage = 25;

    private const REMOTE_FILTER_CODE = '2';
    private const DEFAULT_LOCATION = 'Worldwide';
    private const DESCRIPTION_SELECTORS = [
        '.description__text',
        '.show-more-less-html__markup',
        '.job-details__content-left',
        '.jobs-description-content__text',
        '.jobs-box__html-content',
        '.decorated-job-posting__details',
    ];

    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (compatible; LinkedInJobScraper/1.0; +https://yourdomain.com/bot)',
                'Accept-Language' => 'en-US,en;q=0.9',
            ],
            'allow_redirects' => true,
            'timeout' => 30,
        ]);
    }

    public function scrape($page = 0, $keywords = '')
    {
        $url = 'https://www.linkedin.com/jobs-guest/jobs/api/seeMoreJobPostings/search?' . http_build_query([
            'keywords' => $keywords,
            'location' => self::DEFAULT_LOCATION,
            'f_WT' => self::REMOTE_FILTER_CODE,
            'trk' => 'public_jobs_jobs-search-bar_search-submit',
            'start' => $page * $this->perPage,
        ]);

        $html = $this->fetchPage($url);
        if (!$html) {
            return [];
        }

        $crawler = new Crawler($html);
        $jobNodes = $crawler->filter('li[data-entity-urn]')->count() > 0
            ? $crawler->filter('li[data-entity-urn]')
            : $crawler->filter('li');

        if ($jobNodes->count() === 0) {
            return [];
        }

        $jobs = [];
        foreach ($jobNodes as $node) {
            try {
                $jobData = $this->extractJobData(new Crawler($node));
                if ($jobData && !empty($jobData['job_id']) && !empty($jobData['title'])) {
                    $jobs[] = $jobData;
                }
            } catch (\Exception $e) {
                Log::error("Error parsing job node", ['exception' => $e->getMessage()]);
                continue;
            }
        }

        return $jobs;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    private function extractJobData(Crawler $node)
    {
        if ($node->filter('h3')->count() === 0 || $node->filter('a')->count() === 0) {
            return null;
        }

        $title = trim($node->filter('h3')->text(''));
        if (empty($title)) {
            return null;
        }

        $link = $node->filter('a')->first()->attr('href');
        if (empty($link)) {
            return null;
        }

        if (!str_starts_with($link, 'http')) {
            $link = 'https://www.linkedin.com' . $link;
        }

        $job_id = $this->extractJobId($link);
        if (!$job_id) {
            return null;
        }

        $posted_at = Carbon::now();
        if ($node->filter('time')->count() > 0) {
            $datetime = $node->filter('time')->attr('datetime');
            if ($datetime) {
                $posted_at = Carbon::parse($datetime);
            }
        }

        $description = $this->extractDescription($link);
        $text = strtolower($title . ' ' . strip_tags($description ?? ''));

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'company' => $this->getText($node, '.base-search-card__subtitle'),
            'location' => $this->getText($node, '.job-search-card__location'),
            'link' => $link,
            'posted_at' => $posted_at,
            'expires_at' => $posted_at->copy()->addMonth(),
            'job_id' => $job_id,
            'description' => $description,
            'type' => 'remote',
            'amount' => $this->extractSalaryRange($node, $description),
            'employment_type_id' => $this->extractEmploymentType($node, $title, $description),
            'seniority_level' => $this->extractSeniorityLevel($title, $description),
            'category_id' => $this->extractCategoryId($title, $description),
        ];
    }

    private function getText(Crawler $node, $selector)
    {
        return $node->filter($selector)->count() > 0
            ? trim($node->filter($selector)->text(''))
            : '';
    }

    private function fetchPage($url)
    {
        try {
            $response = $this->client->get($url, ['http_errors' => false]);

            if ($response->getStatusCode() !== 200) {
                if ($response->getStatusCode() === 429) {
                    sleep(5);
                }
                return null;
            }

            return (string) $response->getBody();
        } catch (\Exception $e) {
            Log::error("Error fetching page", ['url' => $url, 'exception' => $e->getMessage()]);
            return null;
        }
    }

    private function extractJobId($link)
    {
        $patterns = [
            '/\/jobs\/view\/(\d+)/',
            '/[?&]jobId=(\d+)/',
            '/currentJobId=(\d+)/',
            '/\/jobs\/view\/[^\/]+-(\d+)(?:\?|$)/',
            '/-(\d+)(?:\?|$)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $link, $matches)) {
                return trim($matches[1]);
            }
        }

        return null;
    }

    private function extractDescription($link)
    {
        try {
            usleep(500000);

            $html = $this->fetchPage($link);
            if ($html) {
                $description = $this->extractDescriptionFromHtml($html);
                if (!empty($description)) {
                    return $description;
                }
            }

            $jobId = $this->extractJobId($link);
            if ($jobId) {
                $apiUrl = "https://www.linkedin.com/jobs-guest/jobs/api/jobPosting/{$jobId}";
                $html = $this->fetchPage($apiUrl);
                if ($html) {
                    return $this->extractDescriptionFromHtml($html);
                }
            }

            return '';
        } catch (\Exception $e) {
            Log::error("Error extracting description", ['link' => $link, 'exception' => $e->getMessage()]);
            return '';
        }
    }

    private function extractDescriptionFromHtml($html)
    {
        $crawler = new Crawler($html);

        foreach (self::DESCRIPTION_SELECTORS as $selector) {
            if ($crawler->filter($selector)->count() > 0) {
                $parts = $crawler->filter($selector)->each(function (Crawler $n) {
                    return trim($n->html(''));
                });
                $desc = trim(implode("\n", array_filter($parts)));
                if (!empty($desc)) {
                    return $desc;
                }
            }
        }

        return '';
    }

    private function extractSalaryRange(Crawler $node, $description)
    {
        if ($node->filter('.job-search-card__salary-info')->count() > 0) {
            $salary = trim($node->filter('.job-search-card__salary-info')->text(''));
            if (!empty($salary)) {
                return $salary;
            }
        }

        if ($description) {
            $text = strip_tags($description);
            $patterns = [
                '/(\$|₹|€|£)?\s?[\d,]+[kK]?\s*-\s*(\$|₹|€|£)?\s?[\d,]+[kK]?/u',
                '/(salary|compensation)[^\d]{0,10}(\$|₹|€|£)?\s?[\d,]+[kK]?/iu',
            ];

            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $text, $matches)) {
                    return $matches[0];
                }
            }
        }

        return null;
    }

    private function extractEmploymentType(Crawler $node, $title, $description)
    {
        $text = strtolower($node->text('') . ' ' . $title . ' ' . strip_tags($description ?? ''));
        $matchedSlug = $this->matchEmploymentType($text) ?: 'full-time';
        return $this->findOrCreateJobType($matchedSlug);
    }

    private function matchEmploymentType($text)
    {
        $types = [
            'full-time' => ['full-time', 'full time', 'fulltime'],
            'part-time' => ['part-time', 'part time', 'parttime'],
            'contract' => ['contract', 'contractor', 'contracting'],
            'internship' => ['internship', 'intern', 'interns'],
            'freelance' => ['freelance', 'freelancer', 'freelancing'],
            'temporary' => ['temporary', 'temp', 'temporary position'],
        ];

        foreach ($types as $type => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos($text, $keyword) !== false) {
                    return $type;
                }
            }
        }

        return null;
    }

    private function findOrCreateJobType($slug)
    {
        $slug = Str::slug($slug) ?: 'full-time';

        $jobType = JobType::where('slug', $slug)->first();
        if ($jobType) {
            if (!$jobType->status) {
                $jobType->update(['status' => true]);
            }
            return $jobType->id;
        }

        $titleMap = [
            'full-time' => 'Full-time',
            'part-time' => 'Part-time',
            'contract' => 'Contract',
            'internship' => 'Internship',
            'freelance' => 'Freelance',
            'temporary' => 'Temporary',
        ];

        $title = $titleMap[$slug] ?? ucfirst(str_replace('-', ' ', $slug));

        try {
            $existing = JobType::whereRaw('LOWER(title) = ?', [strtolower($title)])->first();
            if ($existing) {
                $existing->update(['slug' => $slug, 'status' => true]);
                return $existing->id;
            }

            $jobType = JobType::create(['title' => $title, 'slug' => $slug, 'status' => true]);
            return $jobType->id;
        } catch (\Exception $e) {
            $default = JobType::where('slug', 'full-time')->first();
            return $default ? $default->id : JobType::where('status', true)->first()?->id;
        }
    }

    private function extractSeniorityLevel($title, $description)
    {
        $text = strtolower($title . ' ' . strip_tags($description ?? ''));

        $levels = [
            'senior' => ['senior'],
            'lead' => ['lead', 'team lead'],
            'principal' => ['principal'],
            'director' => ['director', 'head of'],
            'manager' => ['manager'],
            'junior' => ['junior', 'entry level', 'entry-level'],
            'mid-level' => ['mid-level', 'mid level'],
            'associate' => ['associate'],
        ];

        foreach ($levels as $level => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos($text, $keyword) !== false) {
                    return $level;
                }
            }
        }

        return 'mid-level';
    }

    private function extractCategoryId($title, $description)
    {
        $text = strtolower($title . ' ' . strip_tags($description ?? ''));

        $categoryKeywords = [
            'engineering' => ['engineer', 'engineering', 'developer', 'programmer', 'software', 'frontend', 'backend', 'fullstack', 'devops', 'qa', 'testing', 'automation'],
            'business-development' => ['business development', 'biz dev', 'partnership', 'strategic', 'growth', 'expansion'],
            'finance' => ['finance', 'financial', 'accounting', 'bookkeeping', 'audit', 'tax', 'investment', 'banking'],
            'administrative-assistant' => ['administrative assistant', 'admin assistant', 'executive assistant', 'personal assistant', 'secretary'],
            'retail-associate' => ['retail', 'sales associate', 'cashier', 'store', 'shop', 'merchandise'],
            'customer-service' => ['customer service', 'customer support', 'help desk', 'support', 'client service'],
            'operations' => ['operations', 'operational', 'logistics', 'supply chain', 'procurement'],
            'information-technology' => ['it', 'information technology', 'system administrator', 'network', 'infrastructure', 'database'],
            'marketing' => ['marketing', 'digital marketing', 'social media', 'content', 'seo', 'ppc', 'advertising'],
            'human-resources' => ['hr', 'human resources', 'recruitment', 'talent', 'personnel', 'employee relations'],
            'healthcare-service' => ['healthcare', 'medical', 'nursing', 'doctor', 'physician', 'health', 'clinical'],
            'sales' => ['sales', 'account executive', 'business development', 'revenue', 'commission'],
            'program-and-project-management' => ['project manager', 'program manager', 'pmp', 'agile', 'scrum', 'project management'],
            'accounting' => ['accountant', 'accounting', 'bookkeeper', 'auditor', 'cpa', 'financial reporting'],
            'arts-and-design' => ['designer', 'graphic design', 'ui/ux', 'creative', 'artist', 'illustrator'],
            'community-and-social-services' => ['social worker', 'community', 'nonprofit', 'advocacy', 'social services'],
            'consulting' => ['consultant', 'consulting', 'advisor', 'strategic', 'management consulting'],
            'education' => ['teacher', 'educator', 'professor', 'instructor', 'academic', 'education'],
            'entrepreneurship' => ['entrepreneur', 'startup', 'founder', 'co-founder', 'business owner'],
            'legal' => ['lawyer', 'attorney', 'legal', 'paralegal', 'law', 'compliance'],
            'media-and-communications' => ['journalist', 'reporter', 'editor', 'content', 'media', 'communications'],
            'military-and-protective-services' => ['security', 'guard', 'military', 'police', 'law enforcement'],
            'product-management' => ['product manager', 'product owner', 'product management', 'pm'],
            'purchasing' => ['purchasing', 'procurement', 'buyer', 'sourcing', 'vendor management'],
            'quality-assurance' => ['qa', 'quality assurance', 'testing', 'test engineer', 'quality control'],
            'real-estate' => ['real estate', 'realtor', 'property', 'broker', 'leasing'],
            'research' => ['researcher', 'research', 'analyst', 'data scientist', 'scientist'],
            'support' => ['support', 'help desk', 'technical support', 'customer support'],
            'administrative' => ['administrative', 'admin', 'office manager', 'coordinator'],
        ];

        $categoryScores = [];
        foreach ($categoryKeywords as $categorySlug => $keywords) {
            $score = 0;
            foreach ($keywords as $keyword) {
                if (strpos($text, $keyword) !== false) {
                    $score++;
                    if (strpos(strtolower($title), $keyword) !== false) {
                        $score += 2;
                    }
                }
            }
            if ($score > 0) {
                $categoryScores[$categorySlug] = $score;
            }
        }

        if (!empty($categoryScores)) {
            $bestCategory = array_keys($categoryScores, max($categoryScores))[0];
            $category = JobCategory::where('slug', $bestCategory)->where('status', true)->first();
            if ($category) {
                return $category->id;
            }
        }

        $otherCategory = JobCategory::where('slug', 'other')->where('status', true)->first();
        return $otherCategory ? $otherCategory->id : JobCategory::where('status', true)->first()?->id;
    }
}
