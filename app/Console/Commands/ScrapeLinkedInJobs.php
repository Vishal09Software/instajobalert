<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LinkedInJobScraperService;
use App\Models\Occupation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ScrapeLinkedInJobs extends Command
{
    protected $signature = 'scrape:linkedin-jobs';
    protected $description = 'Scrape remote LinkedIn job posts from all categories with batching and session resume.';

    protected $sessionFile = 'linkedin_scrape_session.txt';
    protected $batchSize = 100;

    public function handle(LinkedInJobScraperService $scraper)
    {
        $added = 0;
        $skipped = 0;
        $total = 0;
        $hasMorePages = true;

        $this->info("ℹ️ Starting LinkedIn job scraping with batching and session resume.");

        // Get last processed page from session
        $startPage = $this->getLastProcessedPage();
        $endPage = $startPage + $this->batchSize - 1;
        $this->info("Processing pages $startPage to $endPage (batch size: {$this->batchSize})");

        try {
            for ($page = $startPage; $page <= $endPage && $hasMorePages; $page++) {
                $this->info("🔄 Scraping page $page ...");
                Log::info("Scraping LinkedIn jobs page", ['page' => $page]);
                $jobs = $scraper->scrape($page - 1);
                if (empty($jobs)) {
                    $this->info("No jobs found on page $page. Stopping.");
                    Log::info("No jobs found on page $page. Stopping.");
                    $hasMorePages = false;
                    break;
                }

                $jobsOnPage = 0;

                foreach ($jobs as $jobData) {
                    $total++;

                    // Validate required fields
                    if (empty($jobData['title']) || empty($jobData['link']) || empty($jobData['job_id'])) {
                        $skipped++;
                        continue;
                    }

                    // Check for duplicates
                    $exists = Occupation::where(function($q) use ($jobData) {
                        $q->where('link', $jobData['link'])
                          ->orWhere('job_id', $jobData['job_id']);
                    })->exists();

                    if ($exists) {
                        $skipped++;
                        continue;
                    }

                    try {
                        Occupation::create($jobData);
                        $added++;
                        $jobsOnPage++;
                        $this->info("✅ Added: " . ($jobData['title'] ?? '[no title]'));
                    } catch (\Exception $e) {
                        $skipped++;
                        $this->error("⏩ Skipped (database error): " . ($jobData['title'] ?? '[no title]'));
                        Log::error("Database error creating job", [
                            'job' => $jobData,
                            'exception' => $e->getMessage()
                        ]);
                    }
                }
                if ($jobsOnPage === 0 || count($jobs) < $scraper->getPerPage()) {
                    $hasMorePages = false;
                }
                $this->setLastProcessedPage($page);
                sleep(2);
            }

            if ($hasMorePages) {
                $this->info("Batch completed. Next run will continue from page {$page}.");
            } else {
                $this->info("Scraping completed. All pages processed.");
                Storage::delete($this->sessionFile);
                \Artisan::call('optimize:clear');
                $this->info("Laravel caches cleared.");
            }

            $summary = "Summary: Total processed: $total, Added: $added, Skipped: $skipped";
            $this->info("\n" . $summary);
            Log::info($summary, [
                'total' => $total,
                'added' => $added,
                'skipped' => $skipped
            ]);
        } catch (\Throwable $e) {
            $this->error("❌ Error: " . $e->getMessage());
            Log::error("Error in ScrapeLinkedInJobs: " . $e->getMessage(), [
                'exception' => $e
            ]);
        }
    }

    protected function getLastProcessedPage()
    {
        if (Storage::exists($this->sessionFile)) {
            $page = (int)Storage::get($this->sessionFile);
            return max(1, $page + 1);
        }
        return 1;
    }

    protected function setLastProcessedPage($page)
    {
        Storage::put($this->sessionFile, $page);
    }
}
