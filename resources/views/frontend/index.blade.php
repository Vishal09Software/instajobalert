@extends('frontend.layouts.master')
@section('title', 'Home')
@section('main-container')
@section('meta_description', 'Find your dream job and build your future with ' . config('app.name', 'InstaJobPortal') . '. Thousands of verified
    listings.')
@section('meta_keywords', 'jobs, job portal, careers, employment, hiring, companies, openings, job search, recruitment,
    dream job, job board')
@section('og_title', 'InstaJobPortal - Find your dream job and build your future')
@section('og_description', 'Find your dream job and build your future with ' . config('app.name', 'InstaJobPortal') . '. Thousands of verified listings.')
@section('og_image', asset('frontend/images/og-default.jpg'))
@section('twitter_title', 'InstaJobPortal - Find your dream job and build your future')
@section('twitter_description', 'Find your dream job and build your future with ' . config('app.name', 'InstaJobPortal') . '. Thousands of verified
    listings.')
@section('twitter_image', asset('frontend/images/og-default.jpg'))


<!-- Hero Section -->
<section class="hero-section d-flex align-items-center">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-lg-10">
                <h1 class="hero-title mb-3">Find Your Dream Remote Job.<br>Build Your Future.</h1>
                <p class="hero-subtitle mb-5">Discover thousands of verified remote jobs from trusted companies — tailored just
                    for you.</p>

                <form action="{{ route('alljobView') }}" method="GET" class="search-wrapper mx-auto"
                    style="max-width: 800px;" data-search-form>
                    <i class="bi bi-search text-muted ms-3"></i>
                    <input type="text" class="search-input" name="q"
                        placeholder="Job title, keywords, or company" value="{{ request('q') }}">
                    <button type="submit" class="btn btn-primary-custom px-5 ms-3">Find Jobs</button>
                </form>

                <div class="mt-4 text-muted small">
                    <strong>Popular Searches:</strong>
                    <a href="{{ route('alljobView', ['q' => 'Designer']) }}"
                        class="text-primary-custom ms-1">Designer</a>,
                    <a href="{{ route('alljobView', ['q' => 'Developer']) }}" class="text-primary-custom">Developer</a>,
                    <a href="{{ route('alljobView', ['q' => 'Marketing']) }}" class="text-primary-custom">Marketing</a>,
                    <a href="{{ route('alljobView', ['q' => 'Finance']) }}" class="text-primary-custom">Finance</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <div class="stats-number">25k+</div>
                    <div class="text-muted">Active Jobs</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <div class="stats-number">8k+</div>
                    <div class="text-muted">Companies</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <div class="stats-number">1M+</div>
                    <div class="text-muted">Candidates</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <div class="stats-number">100%</div>
                    <div class="text-muted">Verified Listings</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5 bg-light-custom">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="mb-2">Featured Job Categories</h2>
            <p class="text-muted">Explore jobs in the most popular industries</p>
        </div>

        <div class="row g-4">
            @forelse($categories as $category)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="{{ route('alljobView', ['category' => $category->slug]) }}">
                        <div class="category-card">
                            <i class="bi {{ $category->icon ?? 'bi-grid' }} category-icon"></i>
                            <h5>{{ $category->title }}</h5>
                            <p class="text-muted mb-0 small">{{ number_format($category->occupations_count) }}+ Jobs</p>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">No categories available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Featured Jobs -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="mb-1">Featured Jobs</h2>
                <p class="text-muted mb-0">Hand-picked jobs just for you</p>
            </div>
            <a href="{{ route('alljobView') }}" class="btn btn-outline-custom">View All Jobs</a>
        </div>

        <div class="row g-4">
            @forelse($featuredJobs as $job)
                <div class="col-md-6 col-lg-4">
                    <div class="job-card h-100 d-flex flex-column">
                        <div class="d-flex align-items-start mb-3">
                            <div>
                                <h6 class="mb-1 fw-bold">
                                    <a href="{{ route('detail', ['slug' => $job->slug, 'job_id' => $job->job_id]) }}"
                                        class="text-dark text-decoration-none">
                                        {{ $job->title }}
                                    </a>
                                </h6>
                                <p class="text-muted small mb-0">{{ $job->company ?? 'Company' }}</p>
                            </div>
                            <span class="ms-auto badge bg-light text-dark border"><i class="bi bi-bookmark"></i></span>
                        </div>
                        <div class="mb-3">
                            <div class="job-tags d-flex gap-2 flex-wrap">
                                @if ($job->location)
                                    <span><i class="bi bi-geo-alt-fill me-1"></i>{{ $job->location }}</span>
                                @endif
                                @if ($job->employment_type)
                                    <span><i
                                            class="bi bi-clock-fill me-1"></i>{{ ucfirst(str_replace('-', ' ', $job->employment_type)) }}</span>
                                @endif
                                @if ($job->salary_min || $job->salary_max)
                                    <span>
                                        {{ $job->salary_min ? '$' . number_format($job->salary_min) : '' }}
                                        {{ $job->salary_min && $job->salary_max ? ' - ' : '' }}
                                        {{ $job->salary_max ? '$' . number_format($job->salary_max) : '' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="mt-auto pt-3 border-top">
                            <a href="{{ route('detail', ['slug' => $job->slug, 'job_id' => $job->job_id]) }}"
                                class="btn btn-primary-custom w-100 py-2 rounded-3 text-center d-block">
                                Apply Now
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">No jobs found.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                    alt="Team" class="img-fluid rounded-4 shadow-lg">
            </div>
            <div class="col-lg-6 ps-lg-5">
                <h2 class="mb-4">Why Over 1 Million People Choose Us</h2>

                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-robot"></i>
                    </div>
                    <div>
                        <h5>AI-based Job Matching</h5>
                        <p class="text-muted">Our smart algorithm connects you with jobs that perfectly match your
                            skills and experience.</p>
                    </div>
                </div>

                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <h5>Verified Employers</h5>
                        <p class="text-muted">We strictly screen every company to ensure you are applying to legitimate
                            opportunities.</p>
                    </div>
                </div>

                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-rocket-takeoff"></i>
                    </div>
                    <div>
                        <h5>Career Growth Tools</h5>
                        <p class="text-muted">Access resume builders, salary estimators, and interview prep materials.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Section -->
{{-- <section class="py-5 bg-light-custom">
        <div class="container">
            <h2 class="text-center mb-5">Career Tips & Advice</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="blog-card h-100">
                        <img src="https://images.unsplash.com/photo-1586281380349-632531db7ed4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="blog-img" alt="Resume Tips">
                        <div class="blog-content">
                            <h5>5 Tips for a Perfect Resume</h5>
                            <p class="text-muted small">Learn how to make your resume stand out to recruiters with these simple tricks.</p>
                            <a href="#" class="text-primary fw-bold text-decoration-none">Read More <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="blog-card h-100">
                        <img src="https://images.unsplash.com/photo-1573497620053-ea5300f94f21?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="blog-img" alt="Interview">
                        <div class="blog-content">
                            <h5>Acing Your Next Interview</h5>
                            <p class="text-muted small">Key questions, body language tips, and how to negotiate your salary.</p>
                            <a href="#" class="text-primary fw-bold text-decoration-none">Read More <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="blog-card h-100">
                        <img src="https://images.unsplash.com/photo-1552581234-26160f608093?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="blog-img" alt="Growth">
                        <div class="blog-content">
                            <h5>Career Growth Strategies</h5>
                            <p class="text-muted small">How to upskill, network, and climb the corporate ladder quickly.</p>
                            <a href="#" class="text-primary fw-bold text-decoration-none">Read More <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

@endsection
