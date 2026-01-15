@extends('admin.layouts.master')
@section('title', 'Edit Job Type')
@section('main-container')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Edit Job Type</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('job-types.index') }}">Job Types</a></li>
                            <li class="breadcrumb-item active">Edit Job Type</li>
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
                        <h5 class="card-title mb-0">Edit Job Type</h5>
                        <a href="{{ route('job-types.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                    <div class="card-body">
                        @include('admin.layouts.badge')

                        <form action="{{ route('job-types.update', $jobType->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <x-input type="text" name="title" id="title" :value="$jobType->title" required autofocus placeholder="Enter job type title" />
                                    @error('title')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                    <x-input type="text" name="slug" id="slug" :value="$jobType->slug" required placeholder="Enter job type slug" />
                                    @error('slug')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                                <div class="form-check form-switch form-switch-md mb-3">
                                    <input class="form-check-input code-switcher" type="checkbox" id="9"
                                        name="status" value="1" {{ $jobType->status ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2" for="status">Status</label>
                                </div>
                                @error('status')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror

                            <div class="d-flex justify-content-start gap-2">
                                <button type="submit" class="btn btn-primary">Update Job Type</button>
                                <a href="{{ route('job-types.index') }}" class="btn btn-secondary">Cancel</a>
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

