<?php

namespace App\Livewire\Dashboard\User;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Flux\Flux;

class UserCreate extends Component
{
    public $name, $email, $password, $password_confirmation, $role;

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = '';
    }

    public function getRoleProperty(){
        return Role::latest()->paginate(10);
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        $this->resetForm();
        
        $this->dispatch('userUpdated', ['success'=>true,'message'=>'User created successfully.']);

        Flux::modal('create-user-form')->close();
    }

    public function render()
    {
        return view('livewire.dashboard.user.user-create',[
            'roles'=>$this->getRoleProperty()
        ]);
    }
}
