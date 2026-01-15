<?php

namespace App\Livewire\Admin;

use App\Models\Occupation;
use Livewire\Component;
use Livewire\WithPagination;

class JobDataTable extends Component
{
    use WithPagination;

    public $showDeleteModal = false;
    public $showBulkDeleteModal = false;
    public $jobId = null;
    public $selectedIds = [];
    public $selectAll = false;

    // Search and filter
    public $search = '';
    public $categoryFilter = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortDirection = 'desc';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function delete($id)
    {
        $job = Occupation::findOrFail($id);
        $job->delete();

        session()->flash('success', 'Job deleted successfully!');
        $this->showDeleteModal = false;
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->jobId = $id;
        $this->showDeleteModal = true;
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedIds = $this->getJobsQuery()->pluck('id')->toArray();
        } else {
            $this->selectedIds = [];
        }
    }

    public function updatedSelectedIds()
    {
        $this->selectAll = false;
    }

    public function confirmBulkDelete()
    {
        if (count($this->selectedIds) > 0) {
            $this->showBulkDeleteModal = true;
        } else {
            session()->flash('error', 'Please select at least one job to delete.');
        }
    }

    public function bulkDelete()
    {
        if (count($this->selectedIds) > 0) {
            $count = count($this->selectedIds);
            Occupation::whereIn('id', $this->selectedIds)->delete();
            $this->selectedIds = [];
            $this->selectAll = false;
            $this->showBulkDeleteModal = false;
            $this->resetPage();
            session()->flash('success', $count . ' jobs deleted successfully.');
        }
    }

    public function getJobsQuery()
    {
        $query = Occupation::with('category');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%')
                    ->orWhere('company', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%')
                    ->orWhere('job_id', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->categoryFilter !== '') {
            $query->where('category_id', $this->categoryFilter);
        }

        // Apply sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        return $query;
    }

    public function render()
    {
        $jobs = $this->getJobsQuery()->paginate($this->perPage);
        $categories = \App\Models\JobCategory::where('status', true)->orderBy('title')->get();

        return view('livewire.admin.job-datatable', [
            'jobs' => $jobs,
            'categories' => $categories,
        ]);
    }
}

