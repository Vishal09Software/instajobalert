<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use App\Models\Occupation;
use App\Models\JobType;
use App\Models\Skill;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Register admin components path for x-admin.* syntax
        Blade::anonymousComponentPath(
            resource_path('views/admin/components'),
            'admin'
        );

        // Route model binding for jobs
        Route::bind('job', function ($value) {
            return Occupation::findOrFail($value);
        });

        // Route model binding for job types
        Route::bind('job_type', function ($value) {
            return JobType::findOrFail($value);
        });

        // Route model binding for skills
        Route::bind('skill', function ($value) {
            return Skill::findOrFail($value);
        });

        // Route model binding for users
        Route::bind('user', function ($value) {
            return \App\Models\User::findOrFail($value);
        });
    }
}
