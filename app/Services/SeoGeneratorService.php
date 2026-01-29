<?php

namespace App\Services;

use App\Models\JobSeo;
use Illuminate\Support\Facades\Http;

class SeoGeneratorService
{
    private $apiKey;
    private $apiUrl = 'https://openrouter.ai/api/v1/chat/completions';
    private $model = 'allenai/molmo-2-8b:free';

    public function __construct()
    {
        $this->apiKey = config('services.openkey');
    }

    public function generateSeoContent(string $query, ?int $jobId = null): array
    {
        if (empty($this->apiKey)) {
            return $this->defaultResponse($query);
        }

        $response = Http::withToken($this->apiKey)
            ->acceptJson()
            ->timeout(15)
            ->post($this->apiUrl, [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'text',
                                'text' => "Generate SEO friendly title, description, keywords for: {$query}"
                            ]
                        ]
                    ]
                ]
            ]);
        $data = $response->json();
        $answer = $this->extractAnswer($data);

        $keywords = $this->generateSEOKeywords($query . ' ' . $answer);

        $seo = [
            'title' => $query . ' - AI Answer',
            'description' => substr(strip_tags($answer), 0, 160) ?: 'Get AI-powered answers',
            'keywords' => $keywords,
        ];

        return [
            'answer' => $answer,
            'seo' => $seo,
        ];
    }

    private function extractAnswer($data): string
    {
        if (!isset($data['choices'][0]['message']['content'])) return '';
        $c = $data['choices'][0]['message']['content'];
        if (is_array($c)) {
            foreach ($c as $i)
                if (($i['type'] ?? null) === 'text' && !empty($i['text']))
                    return $i['text'];
            return '';
        }
        return (string) $c;
    }

    private function generateSEOKeywords($text): string
    {
        $stop = ['the','and','are','for','with','that','this','from','have','been','will','would','could','should','what','when','where','which','who','why','how'];
        $words = preg_split('/\s+/', strtolower($text));
        $words = array_filter($words, fn($w) => (strlen($w=preg_replace('/[^a-z0-9]/','',$w))>3 && !in_array($w, $stop)));
        return implode(', ', array_slice(array_unique($words), 0, 10));
    }

    private function defaultResponse(string $query): array
    {
        return [
            'answer' => '',
            'seo' => [
                'title' => $query . ' - AI Answer',
                'description' => 'Get AI-powered answers',
                'keywords' => $this->generateSEOKeywords($query),
            ]
        ];
    }
}
