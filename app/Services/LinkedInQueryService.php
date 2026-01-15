<?php

namespace App\Services;

use App\Models\Occupation;
use App\Models\JobType;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class LinkedInQueryService
{
    /**
     * Build the LinkedIn jobs query with filters and paginate.
     */
    public function getLinkedInJobs(Request $request): LengthAwarePaginator
    {
        $allowedPerPageOptions = [10, 20, 50, 100];
        $requestedPerPage = (int) $request->input('per_page', 10);
        $perPage = in_array($requestedPerPage, $allowedPerPageOptions, true) ? $requestedPerPage : 10;

        $query = Occupation::query();

        // Keyword search across common text fields
        if ($request->filled('q')) {
            $keyword = trim((string) $request->input('q'));
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('company', 'like', "%{$keyword}%")
                  ->orWhere('location', 'like', "%{$keyword}%")
                  ->orWhere('job_id', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        // Location filter
        if ($request->filled('location')) {
            $location = trim((string) $request->input('location'));
            $query->where('location', 'like', "%{$location}%");
        }

        // Job type filter (uses `type` column as used by the view)
        if ($request->filled('jtype')) {
            $jobType = JobType::where('slug', $request->input('jtype'))->first();
            $query->where('employment_type_id', $jobType->id);
        }

        // Category filter
        if ($request->filled('category')) {
            $categoryId = (int) $request->input('category');
            if ($categoryId > 0) {
                $query->where('category_id', $categoryId);
            }
        }

        // Employment type filter
        if ($request->filled('type')) {
            $type = (string) $request->input('type');
            $query->where('type', $type);
        }

        // Seniority level filter
        if ($request->filled('seniority')) {
            $seniority = (string) $request->input('seniority');
            $query->where('seniority_level', $seniority);
        }

        // Posted date window filter based on `posted_at`
        if ($request->filled('posted')) {
            $now = Carbon::now();
            $posted = (string) $request->input('posted');
            $fromDate = match ($posted) {
                'hour' => $now->copy()->subHour(),
                'day', '24h' => $now->copy()->subDay(),
                'week' => $now->copy()->subDays(7),
                'month' => $now->copy()->subDays(30),
                default => null,
            };

            if ($fromDate !== null) {
                $query->where('posted_at', '>=', $fromDate);
            }
        }

        // Filter out expired jobs
        $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', Carbon::now());
        });

        // Default ordering: newest first by posted date, then id
        $query->orderByDesc('posted_at')->orderByDesc('id');

        return $query->paginate($perPage)->withQueryString();
    }
}

