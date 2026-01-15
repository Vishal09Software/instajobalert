@extends('admin.layouts.master')
@section('title', 'User')
@section('main-container')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div
                            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                            <div>
                                <h4 class="card-title mb-0">User Management</h4>
                                <p class="card-description mb-0">Manage users here.</p>
                            </div>
                            <div class="mt-3 mt-md-0">
                                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    Add New
                                </a>
                            </div>
                        </div>

                        @livewire('admin.user-datatable')
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- container-fluid -->
</div>
<!-- End Page-content -->
@endsection

