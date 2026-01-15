@extends('frontend.layouts.master')
@section('title', 'My Profile')
@section('main-container')
@section('meta_description', 'Manage your profile and account settings on ' . config('app.name', 'InstaJobPortal'))
@section('meta_keywords', 'profile, account settings, user profile, job portal profile')
@section('og_title', 'My Profile - ' . config('app.name', 'InstaJobPortal'))
@section('og_description', 'Manage your profile and account settings')
@section('og_image', asset('frontend/images/og-default.jpg'))
@section('twitter_title', 'My Profile - ' . config('app.name', 'InstaJobPortal'))
@section('twitter_description', 'Manage your profile and account settings')
@section('twitter_image', asset('frontend/images/og-default.jpg'))

@php
    $user = Auth::user();
    $fullName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
    $displayName = $fullName ?: $user->name;
    $avatarUrl = $user->avatar
        ? asset($user->avatar)
        : 'https://ui-avatars.com/api/?name=' .
            urlencode($displayName) .
            '&size=120&background=2563EB&color=fff&bold=true';
@endphp

<!-- Profile Header -->
<section class="profile-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-auto text-center text-md-start mb-3 mb-md-0">
                <div class="profile-avatar-wrapper">
                    <img src="{{ $avatarUrl }}" alt="Profile" class="profile-avatar" id="profileAvatar">

                </div>
            </div>
            <div class="col-md">
                <h2 class="mb-1">{{ $displayName }}</h2>
                <p class="text-muted mb-2">
                    @if ($user->professional_title)
                        <i class="bi bi-briefcase me-2"></i>{{ $user->professional_title }}
                    @endif
                </p>
                <p class="text-muted mb-0">
                    @if ($user->location)
                        <i class="bi bi-geo-alt me-2"></i>{{ $user->location }}
                    @endif
                </p>
            </div>
            <div class="col-md-auto mt-3 mt-md-0">
                <div class="d-flex gap-2 flex-wrap justify-content-center justify-content-md-end">
                    <span class="badge bg-success px-3 py-2"><i class="bi bi-check-circle me-1"></i>Profile
                        Complete</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Profile Content -->
<section class="py-5 bg-light-custom">
    <div class="container">
        @include('admin.layouts.badge')

        <div class="row">
            <!-- Vertical Tabs Navigation using Bootstrap -->
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="nav flex-column nav-pills vertical-tabs" id="profile-tabs" role="tablist"
                    aria-orientation="vertical">
                    <button class="nav-link tab-item active" id="personal-tab" data-bs-toggle="pill"
                        data-bs-target="#personal" type="button" role="tab" aria-controls="personal"
                        aria-selected="true">
                        <i class="bi bi-person-fill"></i>
                        <span>Personal Info</span>
                    </button>
                    <button class="nav-link tab-item" id="settings-tab" data-bs-toggle="pill" data-bs-target="#settings"
                        type="button" role="tab" aria-controls="settings" aria-selected="false">
                        <i class="bi bi-gear-fill"></i>
                        <span>Account Settings</span>
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="col-lg-9">
                <div class="tab-content" id="profile-tabs-content">

                    <!-- Personal Information Tab -->
                    <div class="tab-pane fade show active" id="personal" role="tabpanel"
                        aria-labelledby="personal-tab">
                        <div class="profile-card">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">Personal Information</h4>
                                <button class="btn btn-outline-custom btn-sm" id="editPersonalBtn">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </button>
                            </div>

                            <form id="personalForm" action="{{ route('profile.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">First Name</label>
                                        <input type="text" name="first_name" class="form-control"
                                            value="{{ $user->first_name ?? '' }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Last Name</label>
                                        <input type="text" name="last_name" class="form-control"
                                            value="{{ $user->last_name ?? '' }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Email Address</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ $user->email }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Phone Number</label>
                                        <input type="tel" name="phone" class="form-control"
                                            value="{{ $user->phone ?? '' }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Date of Birth</label>
                                        <input type="date" name="date_of_birth" class="form-control"
                                            value="{{ $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '' }}"
                                            disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Location</label>
                                        <input type="text" name="location" class="form-control"
                                            value="{{ $user->location ?? '' }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Professional Title</label>
                                        <input type="text" name="professional_title" class="form-control"
                                            value="{{ $user->professional_title ?? '' }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Avatar</label>
                                        <input type="file" name="avatar" class="form-control" accept="image/*"
                                            disabled>
                                        <small class="form-text text-muted">JPG, PNG, GIF up to 2MB</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Resume</label>
                                        <input type="file" name="resume" class="form-control"
                                            accept=".pdf,.doc,.docx" disabled>
                                        <small class="form-text text-muted">
                                            @if ($user->resume)
                                                Uploaded: <a href="{{ asset($user->resume) }}"
                                                    target="_blank">{{ basename($user->resume) }}</a>
                                            @else
                                                PDF, DOC, DOCX up to 5MB
                                            @endif
                                        </small>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">cover_letter</label>
                                        <textarea name="cover_letter" class="form-control" rows="4" disabled>{{ $user->cover_letter ?? '' }}</textarea>
                                    </div>
                                </div>

                                <div class="form-actions mt-4" style="display: none;">
                                    <button type="submit" class="btn btn-primary-custom">
                                        <i class="bi bi-check-lg me-1"></i>Save Changes
                                    </button>
                                    <button type="button" class="btn btn-outline-custom ms-2"
                                        id="cancelPersonalBtn">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Account Settings Tab -->
                    <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                        <!-- Password Section -->
                        <div class="profile-card mb-4">
                            <h4 class="mb-4">Change Password</h4>
                            <form id="passwordForm" action="{{ route('profile.changePassword') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Current Password</label>
                                        <input type="password" name="current_password" class="form-control"
                                            placeholder="Enter current password" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">New Password</label>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Enter new password" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Confirm New Password</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="Confirm new password" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary-custom mt-3">
                                    <i class="bi bi-shield-check me-1"></i>Update Password
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit Personal Info
        const editBtn = document.getElementById('editPersonalBtn');
        const cancelBtn = document.getElementById('cancelPersonalBtn');
        const personalForm = document.getElementById('personalForm');
        const formInputs = personalForm.querySelectorAll('input, textarea');
        const formActions = personalForm.querySelector('.form-actions');

        editBtn.addEventListener('click', function() {
            formInputs.forEach(input => {
                input.disabled = false;
            });
            editBtn.style.display = 'none';
            formActions.style.display = 'block';
        });

        cancelBtn.addEventListener('click', function() {
            formInputs.forEach(input => {
                input.disabled = true;
            });
            editBtn.style.display = 'block';
            formActions.style.display = 'none';
            personalForm.reset();
        });

        // Avatar Upload Preview
        const avatarUpload = document.getElementById('avatarUpload');
        const profileAvatar = document.getElementById('profileAvatar');

        avatarUpload.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileAvatar.src = e.target.result;
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Trigger avatar upload when clicking the camera icon
        document.querySelector('.avatar-upload-btn').addEventListener('click', function(e) {
            e.preventDefault();
            const personalInputs = personalForm.querySelectorAll(
                'input[type="text"], input[type="email"], input[type="tel"], input[type="date"], textarea'
                );
            const isFormDisabled = Array.from(personalInputs).every(input => input.disabled);

            if (isFormDisabled) {
                // Enable edit mode first
                formInputs.forEach(input => {
                    input.disabled = false;
                });
                editBtn.style.display = 'none';
                formActions.style.display = 'block';
            }
            avatarUpload.click();
        });
    });
</script>
@endsection
