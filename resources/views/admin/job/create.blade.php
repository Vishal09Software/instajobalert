@extends('admin.layouts.master')
@section('title', 'Job')
@section('main-container')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Add Job</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Jobs</a></li>
                            <li class="breadcrumb-item active">Add Job</li>
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
                        <h5 class="card-title mb-0">Create Job</h5>
                        <a href="{{ route('jobs.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                    <div class="card-body">
                        @include('admin.layouts.badge')

                        <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <x-input type="text" name="title" id="title" :value="old('title')" required autofocus placeholder="Enter job title" />
                                    @error('title')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <x-input type="text" name="slug" id="slug" :value="old('slug')" placeholder="Auto-generated from title" />
                                    @error('slug')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="job_id" class="form-label">Job ID <span class="text-danger">*</span></label>
                                    <x-input type="text" name="job_id" id="job_id" :value="old('job_id')" required placeholder="Enter LinkedIn job ID" />
                                    @error('job_id')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select name="category_id" id="category_id" class="form-select">
                                        <option value="">-- Select Category --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="company" class="form-label">Company</label>
                                    <x-input type="text" name="company" id="company" :value="old('company')" placeholder="Enter company name" />
                                    @error('company')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <x-input type="text" name="location" id="location" :value="old('location')" placeholder="Enter job location" />
                                    @error('location')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="type" class="form-label">Type</label>
                                    <x-input type="text" name="type" id="type" :value="old('type')" placeholder="Enter job type" />
                                    @error('type')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="amount" class="form-label">Amount/Salary</label>
                                    <x-input type="text" name="amount" id="amount" :value="old('amount')" placeholder="Enter salary/amount" />
                                    @error('amount')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="employment_type" class="form-label">Employment Type</label>
                                    <select name="employment_type_id" id="employment_type_id" class="form-select">
                                        <option value="">-- Select Type --</option>
                                        @foreach($employmentTypes as $employmentType)
                                            <option value="{{ $employmentType->id }}" {{ old('employment_type_id') == $employmentType->id ? 'selected' : '' }}>
                                                {{ $employmentType->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('employment_type_id')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="seniority_level" class="form-label">Seniority Level</label>
                                    <select name="seniority_level" id="seniority_level" class="form-select">
                                        <option value="">-- Select Level --</option>
                                        <option value="Internship" {{ old('seniority_level') == 'Internship' ? 'selected' : '' }}>Internship</option>
                                        <option value="Entry level" {{ old('seniority_level') == 'Entry level' ? 'selected' : '' }}>Entry level</option>
                                        <option value="Associate" {{ old('seniority_level') == 'Associate' ? 'selected' : '' }}>Associate</option>
                                        <option value="Mid-Senior level" {{ old('seniority_level') == 'Mid-Senior level' ? 'selected' : '' }}>Mid-Senior level</option>
                                        <option value="Director" {{ old('seniority_level') == 'Director' ? 'selected' : '' }}>Director</option>
                                        <option value="Executive" {{ old('seniority_level') == 'Executive' ? 'selected' : '' }}>Executive</option>
                                    </select>
                                    @error('seniority_level')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="posted_at" class="form-label">Posted At</label>
                                    <x-input type="datetime-local" name="posted_at" id="posted_at" :value="old('posted_at')" />
                                    @error('posted_at')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="expires_at" class="form-label">Expires At</label>
                                    <x-input type="datetime-local" name="expires_at" id="expires_at" :value="old('expires_at')" />
                                    @error('expires_at')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="link" class="form-label">Job Link</label>
                                    <x-input type="url" name="link" id="link" :value="old('link')" placeholder="Enter LinkedIn job URL" />
                                    @error('link')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <x-rich-editor name="description" id="editor" :value="old('description')" placeholder="Enter job description" />
                                    @error('description')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-start gap-2">
                                <button type="submit" class="btn btn-primary">Create Job</button>
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

