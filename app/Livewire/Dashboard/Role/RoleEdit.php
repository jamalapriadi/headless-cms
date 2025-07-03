<?php

namespace App\Livewire\Dashboard\Role;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Flux\Flux;

class RoleEdit extends Component
{
    public $roleId, $name, $permissions=[];

    protected $listeners = [
        'editRole' => 'editRole',
    ];

    public function editRole($id)
    {
        $role = Role::findOrFail($id);
        $this->roleId = $id;
        $this->name = $role->name;

        $this->permissions = $role->permissions->pluck('name')->toArray();

        Flux::modal('edit-role-form')->show();
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'nullable|string|max:255|unique:roles,name,' . $this->roleId,
        ]);


        $role = Role::findOrFail($this->roleId);
        $role->update([
            'name' => $this->name,
        ]);

        $role->syncPermissions($this->permissions);

        $this->reset(['name']);

        $this->dispatch('roleUpdated', ['success' => true, 'message' => 'Role updated successfully.']);

        Flux::modal('edit-role-form')->close();
    }

    public function getPermissionProperty()
    {
        return Permission::latest()->get();
    }

    public function render()
    {
        return view('livewire.dashboard.role.role-edit',[
            'perms'=>$this->getPermissionProperty()
        ]);
    }
}
