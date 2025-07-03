<?php

namespace App\Livewire\Dashboard\Permission;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Flux\Flux;

class PermissionEdit extends Component
{
    public $permissionId,$name;

    protected $listeners = [
        'editPermission' => 'editPermission',
    ];

    public function editPermission($id)
    {
        $permission = Permission::findOrFail($id);
        $this->permissionId = $id;
        $this->name = $permission->name;

        Flux::modal('edit-permission-form')->show();
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'nullable|string|max:255|unique:permissions,name,' . $this->permissionId,
        ]);

        $permission = Permission::findOrFail($this->permissionId);
        $permission->update([
            'name' => $this->name,
        ]);

        $this->reset(['name']);

        $this->dispatch('permissionUpdated', ['success' => true, 'message' => 'Permission updated successfully.']);

        Flux::modal('edit-permission-form')->close();
    }

    public function render()
    {
        return view('livewire.dashboard.permission.permission-edit');
    }
}
