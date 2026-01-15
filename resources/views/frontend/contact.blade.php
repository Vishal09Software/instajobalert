@extends('frontend.layouts.master')
@section('title', 'Contact Us')
@section('main-container')
@section('meta_description', 'Find your dream job and build your future with' . config('app.name', 'InstaJobPortal') . '. Thousands of verified listings.')
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
        <h2 class="fw-bold text-white">Contact Us</h2>
        <p class="mb-0 text-white-50">We'd love to hear from you. Get in touch with our team.</p>
    </div>
</section>

<!-- Contact Content -->
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="bg-white p-4 rounded-3 shadow-sm border h-100">
                    <h4 class="mb-4 fw-bold text-primary-custom">Send us a Message</h4>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" placeholder="john@example.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                                <select class="form-select @error('subject') is-invalid @enderror" id="subject" name="subject" required>
                                    <option value="">Select a subject</option>
                                    <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                    <option value="Support" {{ old('subject') == 'Support' ? 'selected' : '' }}>Support</option>
                                    <option value="Billing" {{ old('subject') == 'Billing' ? 'selected' : '' }}>Billing</option>
                                    <option value="Partnership" {{ old('subject') == 'Partnership' ? 'selected' : '' }}>Partnership</option>
                                </select>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('message') is-invalid @enderror"
                                    id="message" name="message" rows="5" placeholder="How can we help you?" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary-custom px-5 py-2 w-100 w-md-auto">Send
                                    Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-5">
                <div class="h-100">
                    <div class="mb-4">
                        <h4 class="fw-bold mb-3">Get in Touch</h4>
                        <p class="text-muted">Have specific questions or need assistance? Our support team is here
                            to help you navigate your career journey.</p>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-light p-3 rounded-circle text-primary me-3">
                            <i class="bi bi-geo-alt fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Office Address</h6>
                            <p class="text-muted mb-0">{{ config('services.contact.address') }}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-light p-3 rounded-circle text-primary me-3">
                            <i class="bi bi-envelope fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Email Support</h6>
                            <p class="text-muted mb-0">{{ config('services.contact.email') }}</p>
                        </div>
                    </div>

                    <!-- Map Placeholder -->
                    <div class="rounded-3 overflow-hidden shadow-sm mt-4">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7210.880860356552!2d74.62431214198305!3d25.356551560434447!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3968c236105d40fb%3A0xb848b6c6f5c36a32!2sTechnology%20Twist!5e0!3m2!1sen!2sin!4v1767767679614!5m2!1sen!2sin"
                            width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>
@endsection
