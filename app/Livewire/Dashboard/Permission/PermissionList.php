<?php

namespace App\Livewire\Dashboard\Permission;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;
use Flux\Flux;

class PermissionList extends Component
{
    use WithPagination;

    public $search = '';
    public $permissionId;

    protected $listeners = [
        'permissionUpdated' => 'onPermissionUpdated',
    ];
    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage(); // reset to page 1 if search changes
    }

    public function onPermissionUpdated($data = null)
    {
        if($data){
            if($data['success']){
                session()->flash('success', $data['message']);
            }else{
                session()->flash('error', 'Role creation failed.');
            }
        }

        $this->resetPage();
    }

    public function getPermissionProperty()
    {
        $query = Permission::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        return $query->latest()->paginate(10);
    }

    public function render()
    {
        return view('livewire.dashboard.permission.permission-list',[
            'permissions'=>$this->getPermissionProperty()
        ]);
    }

    public function edit($id)
    {
        $this->dispatch('editPermission', $id);
    }

    public function confirmDelete($id)
    {
        $this->permissionId = $id;
        Flux::modal('delete-permission')->show();
    }

    public function deletePermission()
    {
        $permission = Permission::find($this->permissionId);
        if ($permission) {
            $permission->delete();

            session()->flash('success', 'Permission deleted successfully.');

            Flux::modal('delete-permission')->close();
            $this->resetPage();
        }
    }
}
