<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserDataTable extends Component
{
    use WithPagination;

    public $showDeleteModal = false;
    public $showBulkDeleteModal = false;
    public $userId = null;
    public $selectedIds = [];
    public $selectAll = false;

    // Search and filter
    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortDirection = 'desc';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
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
        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('success', 'User deleted successfully!');
        $this->showDeleteModal = false;
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->userId = $id;
        $this->showDeleteModal = true;
    }

    public function updateStatus($id, $status = null)
    {
        if ($status === null) {
            return;
        }
        
        $user = User::findOrFail($id);
        $user->status = $status;
        $user->save();

        session()->flash('success', 'User status updated successfully!');
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedIds = $this->getUsersQuery()->pluck('id')->toArray();
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
            session()->flash('error', 'Please select at least one user to delete.');
        }
    }

    public function bulkDelete()
    {
        if (count($this->selectedIds) > 0) {
            $count = count($this->selectedIds);
            User::whereIn('id', $this->selectedIds)->delete();
            $this->selectedIds = [];
            $this->selectAll = false;
            $this->showBulkDeleteModal = false;
            $this->resetPage();
            session()->flash('success', $count . ' users deleted successfully.');
        }
    }

    public function getUsersQuery()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->roleFilter !== '') {
            $query->where('role', $this->roleFilter);
        }

        if ($this->statusFilter !== '') {
            $query->where('status', $this->statusFilter);
        }

        // Apply sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        return $query;
    }

    public function render()
    {
        $users = $this->getUsersQuery()->paginate($this->perPage);

        return view('livewire.admin.user-datatable', [
            'users' => $users,
        ]);
    }
}

