<?php

namespace App\Livewire\Dashboard\Permission;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Flux\Flux;

class PermissionCreate extends Component
{
    public $name;

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        Permission::Create([
            'name' => $validated['name'],
        ]);

        $this->resetForm();
        
        $this->dispatch('permissionUpdated', ['success'=>true,'message'=>'Permission created successfully.']);

        Flux::modal('create-permission-form')->close();
    }

    public function resetForm()
    {
        $this->name = '';
    }

    public function render()
    {
        return view('livewire.dashboard.permission.permission-create');
    }
}
