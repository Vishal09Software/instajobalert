<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// Schedule the LinkedIn job scraper to run every 5 minutes
app(Schedule::class)->command('scrape:linkedin-jobs')->everyFiveMinutes();
