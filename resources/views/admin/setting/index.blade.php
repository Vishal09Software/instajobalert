@extends('admin.layouts.master')
@section('title', 'Setting')
@section('main-container')

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Settings</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">Settings</a></li>
                                <li class="breadcrumb-item active">Settings</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end page title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @include('admin.layouts.badge')
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="nav flex-column nav-pills text-center" id="v-pills-tab" role="tablist"
                                        aria-orientation="vertical">
                                        <a class="nav-link mb-2 active" id="v-pills-logo-tab" data-bs-toggle="pill"
                                            href="#v-pills-logo" role="tab" aria-controls="v-pills-logo"
                                            aria-selected="true">Logo & Branding</a>
                                        <a class="nav-link mb-2" id="v-pills-mail-tab" data-bs-toggle="pill"
                                            href="#v-pills-mail" role="tab" aria-controls="v-pills-mail"
                                            aria-selected="false">Mail Settings</a>
                                        <a class="nav-link mb-2" id="v-pills-footer-tab" data-bs-toggle="pill"
                                            href="#v-pills-footer" role="tab" aria-controls="v-pills-footer"
                                            aria-selected="false">Footer</a>
                                        <a class="nav-link mb-2" id="v-pills-social-tab" data-bs-toggle="pill"
                                            href="#v-pills-social" role="tab" aria-controls="v-pills-social"
                                            aria-selected="false">Social Media</a>
                                        <a class="nav-link" id="v-pills-contact-tab" data-bs-toggle="pill"
                                            href="#v-pills-contact" role="tab" aria-controls="v-pills-contact"
                                            aria-selected="false">Contact</a>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-md-10">
                                    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                                            <!-- Logo & Branding Tab -->
                                            <div class="tab-pane fade show active" id="v-pills-logo" role="tabpanel"
                                                aria-labelledby="v-pills-logo-tab">
                                                <h5 class="mb-3">Logo & Branding</h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">App Name</label>
                                                            <x-input type="text" name="app_name"
                                                                value="{{ $settingsArray['app_name'] ?? '' }}"
                                                                placeholder="App Name" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">App URL</label>
                                                            <x-input type="text" name="app_url"
                                                                value="{{ $settingsArray['app_url'] ?? '' }}"
                                                                placeholder="https://yourappurl.com" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Logo</label>
                                                            <x-input type="file" name="logo" accept="image/*" />
                                                            @if(isset($settingsArray['logo']) && $settingsArray['logo'])
                                                                <div class="mt-2">
                                                                    <img src="{{ asset($settingsArray['logo']) }}" alt="Current Logo" class="img-thumbnail" style="max-width: 200px; max-height: 100px;">
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Favicon</label>
                                                            <x-input type="file" name="favicon" accept="image/*" />
                                                            @if(isset($settingsArray['favicon']) && $settingsArray['favicon'])
                                                                <div class="mt-2">
                                                                    <img src="{{ asset($settingsArray['favicon']) }}" alt="Current Favicon" class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Mail Settings Tab -->
                                            <div class="tab-pane fade" id="v-pills-mail" role="tabpanel"
                                                aria-labelledby="v-pills-mail-tab">
                                                <h5 class="mb-3">Mail Settings</h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Mail Mailer</label>
                                                            <x-input type="text" name="mail_mailer"
                                                                value="{{ $settingsArray['mail_mailer'] ?? 'smtp' }}"
                                                                placeholder="smtp" />
                                                                <small class="text-muted">smtp, mail, sendmail, log, array</small>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Mail Host</label>
                                                            <x-input type="text" name="mail_host"
                                                                value="{{ $settingsArray['mail_host'] ?? '' }}"
                                                                placeholder="smtp.example.com" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Mail Port</label>
                                                            <x-input type="number" name="mail_port"
                                                                value="{{ $settingsArray['mail_port'] ?? '' }}"
                                                                placeholder="587" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Mail Username</label>
                                                            <x-input type="text" name="mail_username"
                                                                value="{{ $settingsArray['mail_username'] ?? '' }}"
                                                                placeholder="username" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Mail Password</label>
                                                            <x-input type="password" name="mail_password"
                                                                placeholder="Leave blank to keep current password" autocomplete="new-password" />
                                                            <small class="text-muted">Leave blank to keep current password</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Mail Encryption</label>
                                                            <select class="form-select" name="mail_encryption">
                                                                <option value="tls" {{ ($settingsArray['mail_encryption'] ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                                                                <option value="ssl" {{ ($settingsArray['mail_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Mail From Address</label>
                                                            <x-input type="email" name="mail_from_address"
                                                                value="{{ $settingsArray['mail_from_address'] ?? '' }}"
                                                                placeholder="no-reply@example.com" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Mail From Name</label>
                                                            <x-input type="text" name="mail_from_name"
                                                                value="{{ $settingsArray['mail_from_name'] ?? '' }}"
                                                                placeholder="Example" />
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                            <!-- Footer Tab -->
                                            <div class="tab-pane fade" id="v-pills-footer" role="tabpanel"
                                                aria-labelledby="v-pills-footer-tab">
                                                <h5 class="mb-3">Footer</h5>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Footer Logo</label>
                                                            <input class="form-control" type="file" name="footer_logo"
                                                                accept="image/*" />
                                                            @if(isset($settingsArray['footer_logo']) && $settingsArray['footer_logo'])
                                                                <div class="mt-2">
                                                                    <img src="{{ asset($settingsArray['footer_logo']) }}" alt="Current Footer Logo" class="img-thumbnail" style="max-width: 200px; max-height: 100px;">
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Footer Description</label>
                                                            <x-textarea name="footer_desc"
                                                                value="{{ $settingsArray['footer_desc'] ?? '' }}"
                                                                placeholder="Footer short description..." />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Social Media Tab -->
                                            <div class="tab-pane fade" id="v-pills-social" role="tabpanel"
                                                aria-labelledby="v-pills-social-tab">
                                                <h5 class="mb-3">Social Media</h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Facebook</label>
                                                            <x-input type="url" name="facebook"
                                                                value="{{ $settingsArray['facebook'] ?? '' }}"
                                                                placeholder="https://facebook.com/yourpage" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Twitter (X)</label>
                                                            <x-input type="url" name="twitter"
                                                                value="{{ $settingsArray['twitter'] ?? '' }}"
                                                                placeholder="https://twitter.com/yourhandle" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Instagram</label>
                                                            <x-input type="url" name="instagram"
                                                                value="{{ $settingsArray['instagram'] ?? '' }}"
                                                                placeholder="https://instagram.com/yourprofile" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">LinkedIn</label>
                                                            <x-input type="url" name="linkedin"
                                                                value="{{ $settingsArray['linkedin'] ?? '' }}"
                                                                placeholder="https://linkedin.com/in/yourprofile" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">YouTube</label>
                                                            <x-input type="url" name="youtube"
                                                                value="{{ $settingsArray['youtube'] ?? '' }}"
                                                                placeholder="https://youtube.com/yourchannel" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Contact Tab -->
                                            <div class="tab-pane fade" id="v-pills-contact" role="tabpanel"
                                                aria-labelledby="v-pills-contact-tab">
                                                <h5 class="mb-3">Contact</h5>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Contact Email</label>
                                                            <x-input type="email" name="contact_email"
                                                                value="{{ $settingsArray['contact_email'] ?? '' }}"
                                                                placeholder="contact@yourdomain.com" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Phone Number</label>
                                                            <x-input type="text" name="contact_phone"
                                                                value="{{ $settingsArray['contact_phone'] ?? '' }}"
                                                                placeholder="+1 234 567 8900" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Address</label>
                                                            <x-input type="text" name="contact_address"
                                                                value="{{ $settingsArray['contact_address'] ?? '' }}"
                                                                placeholder="123 Your Street, City, Country" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Location Map Url</label>
                                                            <x-input type="url" name="location_map_url" id="location_map_url"
                                                                value="{{ $settingsArray['location_map_url'] ?? '' }}"
                                                                placeholder="Enter location map url" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary">Save Settings</button>
                                        </div>
                                    </form>
                                </div><!-- end col -->
                            </div>
                            <!--end row-->
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div>
            </div>
            <!--end row-->
        </div>
        <!-- container-fluid -->
    </div>

@endsection
