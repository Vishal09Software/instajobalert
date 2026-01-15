@extends('admin.layouts.master')
@section('title', 'Edit Job')
@section('main-container')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Edit Job</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Jobs</a></li>
                            <li class="breadcrumb-item active">Edit Job</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row mt-4">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Edit Job</h5>
                        <a href="{{ route('jobs.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                    <div class="card-body">
                        @include('admin.layouts.badge')

                        <form action="{{ route('jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <x-input type="text" name="title" id="title" :value="$job->title" required autofocus placeholder="Enter job title" />
                                    @error('title')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <x-input type="text" name="slug" id="slug" :value="$job->slug" placeholder="Auto-generated from title" />
                                    @error('slug')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="job_id" class="form-label">Job ID <span class="text-danger">*</span></label>
                                    <x-input type="text" name="job_id" id="job_id" :value="$job->job_id" required placeholder="Enter LinkedIn job ID" />
                                    @error('job_id')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select name="category_id" id="category_id" class="form-select">
                                        <option value="">-- Select Category --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $job->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="company" class="form-label">Company</label>
                                    <x-input type="text" name="company" id="company" :value="$job->company" placeholder="Enter company name" />
                                    @error('company')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <x-input type="text" name="location" id="location" :value="$job->location" placeholder="Enter job location" />
                                    @error('location')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="type" class="form-label">Type</label>
                                    <x-input type="text" name="type" id="type" :value="$job->type" placeholder="Enter job type" />
                                    @error('type')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="amount" class="form-label">Amount/Salary</label>
                                    <x-input type="text" name="amount" id="amount" :value="$job->amount" placeholder="Enter salary/amount" />
                                    @error('amount')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="employment_type" class="form-label">Employment Type</label>
                                    <select name="employment_type" id="employment_type" class="form-select">
                                        <option value="">-- Select Type --</option>
                                        <option value="full-time" {{ $job->employment_type == 'full-time' ? 'selected' : '' }}>Full-time</option>
                                        <option value="part-time" {{ $job->employment_type == 'part-time' ? 'selected' : '' }}>Part-time</option>
                                        <option value="contract" {{ $job->employment_type == 'contract' ? 'selected' : '' }}>Contract</option>
                                        <option value="temporary" {{ $job->employment_type == 'temporary' ? 'selected' : '' }}>Temporary</option>
                                        <option value="internship" {{ $job->employment_type == 'internship' ? 'selected' : '' }}>Internship</option>
                                    </select>
                                    @error('employment_type')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="seniority_level" class="form-label">Seniority Level</label>
                                    <select name="seniority_level" id="seniority_level" class="form-select">
                                        <option value="">-- Select Level --</option>
                                        <option value="internship" {{ $job->seniority_level == 'internship' ? 'selected' : '' }}>Internship</option>
                                        <option value="entry-level" {{ $job->seniority_level == 'entry-level' ? 'selected' : '' }}>Entry level</option>
                                        <option value="associate" {{ $job->seniority_level == 'associate' ? 'selected' : '' }}>Associate</option>
                                        <option value="mid-level" {{ $job->seniority_level == 'mid-level' ? 'selected' : '' }}>Mid-Level</option>
                                        <option value="director" {{ $job->seniority_level == 'director' ? 'selected' : '' }}>Director</option>
                                        <option value="executive" {{ $job->seniority_level == 'executive' ? 'selected' : '' }}>Executive</option>
                                        <option value="junior" {{ $job->seniority_level == 'junior' ? 'selected' : '' }}>Junior</option>
                                        <option value="senior" {{ $job->seniority_level == 'senior' ? 'selected' : '' }}>Senior</option>
                                        <option value="principal" {{ $job->seniority_level == 'principal' ? 'selected' : '' }}>Principal</option>
                                        <option value="manager" {{ $job->seniority_level == 'manager' ? 'selected' : '' }}>Manager</option>
                                    </select>
                                    @error('seniority_level')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="posted_at" class="form-label">Posted At</label>
                                    <x-input type="datetime-local" name="posted_at" id="posted_at" :value="$job->posted_at ? \Carbon\Carbon::parse($job->posted_at)->format('Y-m-d\TH:i') : ''" />
                                    @error('posted_at')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="expires_at" class="form-label">Expires At</label>
                                    <x-input type="datetime-local" name="expires_at" id="expires_at" :value="$job->expires_at ? \Carbon\Carbon::parse($job->expires_at)->format('Y-m-d\TH:i') : ''" />
                                    @error('expires_at')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="link" class="form-label">Job Link</label>
                                    <x-input type="url" name="link" id="link" :value="$job->link" placeholder="Enter LinkedIn job URL" />
                                    @error('link')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="5" placeholder="Enter job description">{{ $job->description }}</textarea>
                                    @error('description')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-start gap-2">
                                <button type="submit" class="btn btn-primary">Update Job</button>
                                <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- container-fluid -->
</div>

@endsection

