@extends('frontend.layouts.master')
@section('title', 'Job')
@section('main-container')
@section('meta_description', 'Find your dream job and build your future with ' . config('app.name', 'InstaJobPortal') . '. Thousands of verified listings.')
@section('meta_keywords', 'jobs, job portal, careers, employment, hiring, companies, openings, job search, recruitment, dream job, job board')
@section('og_title', 'InstaJobPortal - Find your dream job and build your future')
@section('og_description', 'Find your dream job and build your future with ' . config('app.name', 'InstaJobPortal') . '. Thousands of verified listings.')
@section('og_image', asset('frontend/images/og-default.jpg'))
@section('twitter_title', 'InstaJobPortal - Find your dream job and build your future')
@section('twitter_description', 'Find your dream job and build your future with ' . config('app.name', 'InstaJobPortal') . '. Thousands of verified listings.')
@section('twitter_image', asset('frontend/images/og-default.jpg'))

  <!-- Page Header -->
  <section class="bg-primary-custom py-5 mt-5">
    <div class="container text-center text-white pt-4">
        <h2 class="fw-bold text-white">Browse Jobs</h2>
        <p class="mb-0 text-white-50">Find the perfect role for you from over 25,000 listings.</p>
    </div>
</section>

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3 mb-4">
                <button class="btn btn-primary d-lg-none w-100 mb-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#filterCollapse">
                    <i class="bi bi-funnel me-2"></i> Filters
                </button>

                <div class="collapse d-lg-block" id="filterCollapse">
                    <form method="GET" action="{{ route('alljobView') }}" id="filterForm">
                        <div class="filter-sidebar">
                            <h5 class="mb-3 fw-bold">Filters</h5>

                            <div class="mb-4">
                                <label class="fw-bold mb-2 small text-uppercase text-muted">Keywords</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="bi bi-search"></i></span>
                                    <input type="text" name="q" class="form-control bg-light border-start-0"
                                        placeholder="Job title..." value="{{ $request->input('q') }}">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="fw-bold mb-2 small text-uppercase text-muted">Category</label>
                                <select name="category" class="form-select bg-light">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $request->input('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="fw-bold mb-2 small text-uppercase text-muted">Job Type</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jtype" value="" id="jtypeAny" {{ !$request->has('jtype') || $request->input('jtype') == '' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="jtypeAny">Any Type</label>
                                </div>
                                @foreach($jobTypes as $jobType)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jtype" value="{{ $jobType->slug }}" id="{{ $jobType->slug }}" {{ $request->input('jtype') == $jobType->slug ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $jobType->slug }}">{{ $jobType->title }}</label>
                                </div>
                                @endforeach
                            </div>

                            <div class="mb-4">
                                <label class="fw-bold mb-2 small text-uppercase text-muted">Experience Level</label>
                                <select name="seniority" class="form-select bg-light">
                                    <option value="">Any Experience</option>
                                    <option value="entry" {{ $request->input('seniority') == 'entry' ? 'selected' : '' }}>Entry Level</option>
                                    <option value="lead" {{ $request->input('seniority') == 'lead' ? 'selected' : '' }}>Lead</option>
                                    <option value="principal" {{ $request->input('seniority') == 'principal' ? 'selected' : '' }}>Principal</option>
                                    <option value="director" {{ $request->input('seniority') == 'director' ? 'selected' : '' }}>Director</option>
                                    <option value="manager" {{ $request->input('seniority') == 'manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="junior" {{ $request->input('seniority') == 'junior' ? 'selected' : '' }}>Junior</option>
                                    <option value="mid-level" {{ $request->input('seniority') == 'mid-level' ? 'selected' : '' }}>Mid Level</option>
                                    <option value="associate" {{ $request->input('seniority') == 'associate' ? 'selected' : '' }}>Associate</option>
                                    <option value="mid" {{ $request->input('seniority') == 'mid' ? 'selected' : '' }}>Mid Level</option>
                                    <option value="senior" {{ $request->input('seniority') == 'senior' ? 'selected' : '' }}>Senior Level</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary-custom w-100 mb-2">Apply Filter</button>
                            <a href="{{ route('alljobView') }}" class="btn btn-outline-secondary w-100">Clear Filters</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Job Listings -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="mb-0 text-muted">
                        Showing <strong>{{ $occupations->firstItem() ?? 0 }}-{{ $occupations->lastItem() ?? 0 }}</strong>
                        of <strong>{{ number_format($totalCount) }}</strong> jobs
                    </p>
                    <form method="GET" action="{{ route('alljobView') }}" class="d-inline">
                        @foreach($request->except('per_page') as $key => $value)
                            @if(is_array($value))
                                @foreach($value as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <select name="per_page" class="form-select w-auto" onchange="this.form.submit()">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 per page</option>
                            <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20 per page</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 per page</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 per page</option>
                        </select>
                    </form>
                </div>

                @forelse($occupations as $job)
                    <div class="job-card-list d-flex align-items-center p-3 mb-3 bg-white rounded-3 shadow-sm border" style="min-height:80px;">
                        <!-- Logo -->
                        <div class="me-3 flex-shrink-0 job-logo-container" data-company="{{ $job->company ?? 'Company Not Specified' }}">
                            @if($job->logo)
                                <img src="{{ $job->logo }}" alt="Logo" class="rounded bg-light job-logo-img" style="width:40px; height:40px; object-fit:contain;">
                            @else
                                <div class="company-avatar-placeholder d-flex align-items-center justify-content-center rounded" data-company="{{ $job->company ?? 'Company Not Specified' }}" style="width:40px; height:40px;">
                                    <span class="text-muted small">Logo</span>
                                </div>
                            @endif
                        </div>
                        <!-- Main Content -->
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-1">
                                <h6 class="mb-0 fw-bold" style="font-size:1.08rem;">
                                    <a href="{{ route('detail', ['slug' => $job->slug, 'job_id' => $job->job_id]) }}"
                                       class="text-dark text-decoration-none">
                                        {{ $job->title }}
                                    </a>
                                </h6>
                            </div>
                            <div class="text-muted small" style="line-height:1.3;">
                                {{ $job->company ?? 'Company Not Specified' }}
                                @if($job->location)
                                    &nbsp;&middot;&nbsp;{{ $job->location }}
                                @endif
                            </div>
                            <div class="d-flex gap-2 flex-wrap mt-2">
                                @if($job->employment_type)
                                    <span class="badge bg-white text-primary border-primary border rounded-pill px-3 py-1 small" style="background:#f2f8ff;">
                                        {{ ucfirst(str_replace('-', ' ', $job->employment_type)) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- Right: Button and Date -->
                        <div class="d-flex flex-column align-items-end ms-3" style="min-width:160px;">
                            <a href="{{route('detail', ['slug' => $job->slug, 'job_id' => $job->job_id]) }}"
                               class="btn btn-primary-custom rounded-pill fw-semibold px-4 py-2 mb-1"
                               style="font-size:1rem; min-width:100px;">
                               View Job
                            </a>
                            <span class="text-muted small mt-1">
                                @if($job->posted_at)
                                    {{ \Carbon\Carbon::parse($job->posted_at)->diffForHumans() }}
                                @endif
                            </span>
                        </div>
                    </div>
                @empty
                    <p>
                        <i class="bi bi-info-circle me-2"></i>
                        No jobs found matching your criteria. Try adjusting your filters.
                    </p>
                @endforelse

                <!-- Pagination -->
                @if($occupations->hasPages())
                    <nav aria-label="Page navigation" class="mt-5">
                        {{ $occupations->links() }}
                    </nav>
                @endif

            </div>
        </div>
    </div>
</section>

@endsection
