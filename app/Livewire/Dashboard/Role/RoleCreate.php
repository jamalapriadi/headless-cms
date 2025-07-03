<?php

namespace App\Livewire\Dashboard\Role;

use Livewire\Component;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Str;
use Flux\Flux;

class RoleCreate extends Component
{
    public $name, $permissions=[];

    public function save()
    {
        \DB::beginTransaction();

        try {
            $validated = $this->validate([
                'name' => 'required|string|max:255|unique:roles,name',
            ]);

            $role = Role::create([
                'name' => $validated['name'],
            ]);
            
            $role->syncPermissions($this->permissions);

            \DB::commit();

            $this->resetForm();
            
            $this->dispatch('roleUpdated', ['success'=>true,'message'=>'Role created successfully.']);

            Flux::modal('create-role-form')->close();

        } catch (\Throwable $e) {
            \DB::rollBack();

            $this->dispatch('roleUpdated', ['success'=>false,'message'=>'Failed to create role.']);
            
            throw $e;
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->permissions = [];
    }

    public function getPermissionProperty()
    {
        return Permission::latest()->get();
    }

    public function render()
    {
        return view('livewire.dashboard.role.role-create',[
            'perms'=>$this->getPermissionProperty()
        ]);
    }
}
