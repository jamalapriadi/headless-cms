<?php

namespace App\Livewire\Dashboard\User;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Flux\Flux;

class UserEdit extends Component
{
    public $userId, $name, $email, $password, $password_confirmation, $role;

    protected $listeners = [
        'editUser' => 'editUser',
    ];

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;

        $this->role = $user->roles->pluck('name')->first();

        Flux::modal('edit-user-form')->show();
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|max:255|unique:users,email,' . $this->userId,
        ]);

        $user = User::findOrFail($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email
        ]);

        if ($this->role) {
            $user->syncRoles([$this->role]);
        }

        $this->reset(['name','email','role']);

        $this->dispatch('userUpdated', ['success' => true, 'message' => 'User updated successfully.']);

        Flux::modal('edit-user-form')->close();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->role = '';
    }

    public function getRoleProperty(){
        return Role::latest()->paginate(10);
    }

    public function render()
    {
        return view('livewire.dashboard.user.user-edit',[
            'roles'=>$this->getRoleProperty()
        ]);
    }
}
