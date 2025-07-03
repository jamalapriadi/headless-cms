<?php

namespace App\Livewire\Dashboard\Role;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use Flux\Flux;

class RoleList extends Component
{
    use WithPagination;

    public $search = '';
    public $roleId;

    protected $listeners = [
        'roleUpdated' => 'onRoleUpdated',
    ];
    
    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage(); // reset to page 1 if search changes
    }

    public function onRoleUpdated($data = null)
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

    public function getRoleProperty()
    {
        $query = Role::withCount(['users', 'permissions']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        return $query->latest()->paginate(10);
    }

    public function render()
    {
        return view('livewire.dashboard.role.role-list',[
            'roles'=>$this->getRoleProperty()
        ]);
    }

    public function edit($id)
    {
        $this->dispatch('editRole', $id);
    }

    public function confirmDelete($id)
    {
        $this->roleId = $id;
        Flux::modal('delete-role')->show();
    }

    public function deleteRole()
    {
        $role = Role::find($this->roleId);
        if ($role) {
            $role->delete();

            session()->flash('success', 'Role deleted successfully.');

            Flux::modal('delete-role')->close();
            $this->resetPage();
        }
    }
}
