@extends('admin.layouts.master')
@section('title', 'Edit Category')
@section('main-container')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Edit Category</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
                            <li class="breadcrumb-item active">Edit Category</li>
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
                        <h5 class="card-title mb-0">Edit Category</h5>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                    <div class="card-body">
                        @include('admin.layouts.badge')

                        <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">

                                <div class="col-md-4 mb-3">
                                    <label for="parent_id" class="form-label">Parent Category</label>
                                    <select name="parent_id" id="parent_id" class="form-select">
                                        <option value="">-- None (This is a parent) --</option>
                                        @foreach($parentCategories as $parentCategory)
                                            <option value="{{ $parentCategory->id }}" {{ $category->parent_id == $parentCategory->id ? 'selected' : '' }}>
                                                {{ $parentCategory->title }}
                                            </option>
                                </div>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                                <div class="col-md-4 mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <x-input type="text" name="title" id="title" :value="$category->title" required autofocus placeholder="Enter category title" />
                                    @error('title')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                    <x-input type="text" name="slug" id="slug" :value="$category->slug" required placeholder="Enter category slug" />
                                    @error('slug')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="icon" class="form-label">Icon</label>
                                    <x-input type="text" name="icon" id="icon" :value="$category->icon" placeholder="Enter icon class e.g. bi bi-folder" />
                                    @error('icon')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                                <div class="form-check form-switch form-switch-md mb-3">
                                    <input class="form-check-input code-switcher" type="checkbox" id="9"
                                        name="status"{{ $category->status ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2" for="status">Status</label>
                                </div>
                                @error('status')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror

                            <div class="d-flex justify-content-start gap-2">
                                <button type="submit" class="btn btn-primary">Update Category</button>
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
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
