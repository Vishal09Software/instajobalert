<div>
   @include('admin.layouts.badge')
    <!-- Top Controls: Show entries and Search -->
    <div class="row mb-3">
        <div class="col-sm-12 col-md-4">
            <div class="dataTables_length">
                <label>
                    Show
                    <select wire:model.live="perPage" class="form-select form-select-sm d-inline-block" style="width: auto;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    entries
                </label>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="dataTables_filter">
                <label>
                    Search:
                    <input type="search"
                        wire:model.live.debounce.300ms="search"
                        class="form-control form-control-sm ms-2 d-inline-block"
                        placeholder=""
                        style="width: auto;">
                </label>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="dataTables_filter text-md-end">
                <label>
                    Category:
                    <select wire:model.live="categoryFilter" class="form-select form-select-sm ms-2 d-inline-block" style="width: auto;">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    @if (count($selectedIds) > 0)
        <div class="mb-3">
            <button wire:click="confirmBulkDelete" class="btn btn-danger btn-sm">
                <i class="bi bi-trash me-1"></i>
                Delete Selected ({{ count($selectedIds) }})
            </button>
        </div>
    @endif

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 50px;">
                        <input type="checkbox"
                            wire:model.live="selectAll"
                            wire:click="toggleSelectAll"
                            class="form-check-input">
                    </th>
                    <th wire:click="sortBy('id')" style="cursor: pointer;" class="user-select-none">
                        ID
                        @if ($sortField === 'id')
                            <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-short"></i>
                        @endif
                    </th>
                    <th wire:click="sortBy('title')" style="cursor: pointer;" class="user-select-none">
                        Title
                        @if ($sortField === 'title')
                            <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-short"></i>
                        @endif
                    </th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Category</th>
                    <th wire:click="sortBy('posted_at')" style="cursor: pointer;" class="user-select-none">
                        Posted At
                        @if ($sortField === 'posted_at')
                            <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-short"></i>
                        @endif
                    </th>
                    <th style="width: 120px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jobs as $job)
                    <tr>
                        <td>
                            <input type="checkbox"
                                wire:model.live="selectedIds"
                                value="{{ $job->id }}"
                                class="form-check-input">
                        </td>
                        <td>{{ $loop->iteration + ($jobs->currentPage() - 1) * $jobs->perPage() }}</td>
                        <td>
                            <strong>{{ Str::limit($job->title, 50) }}</strong>
                            @if($job->slug)
                                <br><code class="text-muted small">{{ Str::limit($job->slug, 40) }}</code>
                            @endif
                        </td>
                        <td>{{ $job->company ?? '-' }}</td>
                        <td>{{ $job->location ?? '-' }}</td>
                        <td>
                            @if($job->category)
                                <span class="badge bg-info">{{ $job->category->title }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($job->posted_at)
                                {{ \Carbon\Carbon::parse($job->posted_at)->format('M d, Y') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">

                                <a href="{{ route('detail', ['slug' => $job->slug, 'job_id' => $job->job_id]) }}"
                                    class="btn btn-outline-info"
                                    title="View"
                                    target="_blank"
                                    style="padding: 0.25rem 0.5rem;">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('jobs.edit', $job->id) }}"
                                    class="btn btn-outline-success"
                                    title="Edit"
                                    style="padding: 0.25rem 0.5rem;">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button wire:click="confirmDelete({{ $job->id }})"
                                    class="btn btn-outline-danger"
                                    title="Delete"
                                    style="padding: 0.25rem 0.5rem;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                            <p class="text-muted mb-0">No jobs found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Info and Controls -->
    <div class="row mt-3">
        <div class="col-sm-12 col-md-12">
            <div class="dataTables_paginate paging_simple_numbers">
                <x-pagination :items="$jobs" livewire="true" />
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if ($showDeleteModal)
        <x-modal
            id="deleteModal"
            title="Delete Job"
            :show="$showDeleteModal"
            :wireIgnore="true"
            backdrop='$set("showDeleteModal", false)'
            closeAction='$set("showDeleteModal", false)'>
            <p>Are you sure you want to delete this job? This action cannot be undone.</p>

            <x-slot name="footer">
                <button type="button" class="btn btn-secondary" wire:click="$set('showDeleteModal', false)">Cancel</button>
                <button type="button" class="btn btn-danger" wire:click="delete({{ $jobId }})">
                    <span wire:loading.remove wire:target="delete">Delete</span>
                    <span wire:loading wire:target="delete">
                        <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                        Deleting...
                    </span>
                </button>
            </x-slot>
        </x-modal>
    @endif

    <!-- Bulk Delete Confirmation Modal -->
    @if ($showBulkDeleteModal)
        <x-modal
            id="bulkDeleteModal"
            title="Delete Jobs"
            :show="$showBulkDeleteModal"
            :wireIgnore="true"
            backdrop='$set("showBulkDeleteModal", false)'
            closeAction='$set("showBulkDeleteModal", false)'>
            <p>Are you sure you want to delete <strong>{{ count($selectedIds) }}</strong> selected job(s)? This action cannot be undone.</p>

            <x-slot name="footer">
                <button type="button" class="btn btn-secondary" wire:click="$set('showBulkDeleteModal', false)">Cancel</button>
                <button type="button" class="btn btn-danger" wire:click="bulkDelete">
                    <span wire:loading.remove wire:target="bulkDelete">Delete All</span>
                    <span wire:loading wire:target="bulkDelete">
                        <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                        Deleting...
                    </span>
                </button>
            </x-slot>
        </x-modal>
    @endif

</div>

