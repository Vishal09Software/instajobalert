@extends('frontend.layouts.master')
@section('title', $job->title ?? 'Job View')
@section('main-container')

@section('meta_description', $job->title . ' at ' . ($job->company ?? 'Company') . ' - Job details, requirements, and career opportunities. Find your ideal job on ' . config('app.name', 'InstaJobPortal') . '.')
@section('meta_keywords', $job->title . ', ' . ($job->company ?? '') . ', jobs, job portal, careers, employment, hiring, companies, openings, job search, recruitment, dream job, job board')
@section('og_title', $job->title . ' at ' . ($job->company ?? 'Company') . ' | ' . config('app.name', 'InstaJobPortal'))
@section('og_description', 'Explore ' . $job->title . ' opportunities at ' . ($job->company ?? 'Company') . '. Job details, requirements and more. Your career starts here at ' . config('app.name', 'InstaJobPortal') . '.')
@section('og_image', $job->company_logo ?? asset('frontend/images/og-default.jpg'))
@section('twitter_title', $job->title . ' at ' . ($job->company ?? 'Company') . ' | ' . config('app.name', 'InstaJobPortal'))
@section('twitter_description', 'Explore ' . $job->title . ' opportunities at ' . ($job->company ?? 'Company') . '. Job details, requirements and more. Your career starts here at ' . config('app.name', 'InstaJobPortal') . '.')
@section('twitter_image', $job->company_logo ?? asset('frontend/images/og-default.jpg'))

<!-- Job Header -->
<section class="job-header mt-5 bg-white sticky-top-md"
    style="z-index: 1010; box-shadow: 0 1px 4px 0 rgba(30,41,59,.10);">
    <div class="container pt-2">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center mb-3">
                    <div>
                        <h2 class="fw-bold mb-1">{{ $job->title }}</h2>
                        <p class="text-muted mb-0 fs-5">
                            {{ $job->company ?? 'Company Not Specified' }}
                            @if ($job->location)
                                • <span class="text-primary"><i
                                        class="bi bi-geo-alt-fill me-1"></i>{{ $job->location }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="d-flex gap-3 text-muted mb-4 mb-md-0 flex-wrap">
                    @if ($job->employment_type)
                        <span><i class="bi bi-briefcase me-1"></i>
                            {{ ucfirst(str_replace('-', ' ', $job->employment_type)) }}</span>
                    @endif
                    @if ($job->posted_at)
                        <span>
                            <i class="bi bi-clock me-1"></i>
                            {{ \Carbon\Carbon::parse($job->posted_at)->format('M d, Y') }}
                            ({{ \Carbon\Carbon::parse($job->posted_at)->diffForHumans() }})
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-md-4 text-md-end desktop-apply">
                @auth
                    <a href="{{ $job->link }}" target="_blank" class="btn btn-primary-custom px-3 py-2 mt-3 mt-md-0">
                        Apply Now <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                @else
                    <button type="button" class="btn btn-primary-custom px-3 py-2 mt-3 mt-md-0" data-bs-toggle="modal" data-bs-target="#jobApplicationModal">
                        Apply Now <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                @endauth
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        @include('admin.layouts.badge')

        <div class="row">
            <!-- Left Content -->
            <div class="col-lg-8">
                <div class="bg-white p-4 rounded-3 border mb-4">
                    <h4 class="mb-3">Job Description</h4>
                    @if ($job->description)
                        <div class="text-muted">
                            {!! $job->description !!}
                        </div>
                    @else
                        <p class="text-muted">No description available for this job.</p>
                    @endif
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="sidebar-card">
                    <h5 class="fw-bold mb-3">Job Overview</h5>
                    @if ($job->posted_at)
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-calendar-event text-primary fs-4 me-3"></i>
                            <div>
                                <small class="text-muted text-uppercase fw-bold">Posted</small>
                                <div class="fw-bold">
                                    {{ \Carbon\Carbon::parse($job->posted_at)->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($job->location)
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-geo-alt text-primary fs-4 me-3"></i>
                            <div>
                                <small class="text-muted text-uppercase fw-bold">Location</small>
                                <div class="fw-bold">{{ $job->location }}</div>
                            </div>
                        </div>
                    @endif
                    <div class="d-flex align-items-start mb-3">
                        <i class="bi bi-people text-primary fs-4 me-3"></i>
                        <div>
                            <small class="text-muted text-uppercase fw-bold">Job Title</small>
                            <div class="fw-bold">{{ $job->title }}</div>
                        </div>
                    </div>
                    @if ($job->employment_type)
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-briefcase text-primary fs-4 me-3"></i>
                            <div>
                                <small class="text-muted text-uppercase fw-bold">Employment Type</small>
                                <div class="fw-bold">{{ ucfirst(str_replace('-', ' ', $job->employment_type)) }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                @if (isset($relatedJobs) && $relatedJobs->count() > 0)
                    <h5 class="fw-bold mb-3">Similar Jobs</h5>
                    @foreach ($relatedJobs as $relatedJob)
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title fw-bold">
                                    <a href="{{ route('detail', ['slug' => $relatedJob->slug, 'job_id' => $relatedJob->job_id]) }}"
                                        class="text-dark text-decoration-none">
                                        {{ $relatedJob->title }}
                                    </a>
                                </h6>
                                <p class="card-subtitle text-muted small mb-2">
                                    {{ $relatedJob->company ?? 'Company' }}
                                    @if ($relatedJob->location)
                                        • {{ $relatedJob->location }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</section>

<!-- Job Application Modal -->
<div class="modal fade" id="jobApplicationModal" tabindex="-1" aria-labelledby="jobApplicationModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold" id="jobApplicationModalLabel">
                    <i class="bi bi-briefcase-fill me-2 text-primary"></i>Apply for {{ $job->title }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('job.apply') }}" method="POST" enctype="multipart/form-data" id="jobApplicationForm">
                @csrf
                <input type="hidden" name="job_id" value="{{ $job->id }}">
                <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="bi bi-exclamation-triangle me-2"></i>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Location</label>
                            <input type="text" name="location" class="form-control" value="{{ old('location') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Professional Title</label>
                            <input type="text" name="professional_title" class="form-control" value="{{ old('professional_title') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Avatar</label>
                            <input type="file" name="avatar" class="form-control" accept="image/*">
                            <small class="form-text text-muted">JPG, PNG, GIF up to 2MB</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Resume <span class="text-danger">*</span></label>
                            <input type="file" name="resume" class="form-control" accept=".pdf,.doc,.docx" required>
                            <small class="form-text text-muted">PDF, DOC, DOCX up to 5MB</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Cover Letter</label>
                            <textarea name="cover_letter" class="form-control" rows="5" placeholder="Write your cover letter here...">{{ old('cover_letter') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Close
                    </button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-send me-1"></i>Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
