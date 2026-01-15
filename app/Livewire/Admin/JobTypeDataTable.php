<?php

namespace App\Livewire\Admin;

use App\Models\JobType;
use Livewire\Component;
use Livewire\WithPagination;

class JobTypeDataTable extends Component
{
    use WithPagination;

    public $showDeleteModal = false;
    public $showBulkDeleteModal = false;
    public $jobTypeId = null;
    public $selectedIds = [];
    public $selectAll = false;

    // Search and filter
    public $search = '';
    public $statusFilter = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortDirection = 'asc';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
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
        $jobType = JobType::findOrFail($id);
        $jobType->delete();

        session()->flash('success', 'Job type deleted successfully!');
        $this->showDeleteModal = false;
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->jobTypeId = $id;
        $this->showDeleteModal = true;
    }

    public function updateStatus($id, $status)
    {
        $jobType = JobType::findOrFail($id);
        $jobType->status = $status;
        $jobType->save();

        session()->flash('success', 'Job type status updated successfully!');
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedIds = $this->getJobTypesQuery()->pluck('id')->toArray();
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
            session()->flash('error', 'Please select at least one job type to delete.');
        }
    }

    public function bulkDelete()
    {
        if (count($this->selectedIds) > 0) {
            $count = count($this->selectedIds);
            $jobTypes = JobType::whereIn('id', $this->selectedIds)->get();

            JobType::whereIn('id', $this->selectedIds)->delete();
            $this->selectedIds = [];
            $this->selectAll = false;
            $this->showBulkDeleteModal = false;
            $this->resetPage();
            session()->flash('error', $count . ' job types deleted successfully.');
        }
    }

    public function getJobTypesQuery()
    {
        $query = JobType::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter !== '') {
            $query->where('status', $this->statusFilter === '1');
        }

        // Apply sorting
        $query->orderBy('created_at', 'desc');
        $query->orderBy($this->sortField, $this->sortDirection);

        return $query;
    }

    public function render()
    {
        $jobTypes = $this->getJobTypesQuery()->paginate($this->perPage);

        return view('livewire.admin.job-type-datatable', [
            'jobTypes' => $jobTypes,
        ]);
    }
}

