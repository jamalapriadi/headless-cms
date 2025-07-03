<?php

namespace App\Livewire\Dashboard\User;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use Flux\Flux;

class UserList extends Component
{
    use WithPagination;

    public $search = '';
    public $userId;

    protected $listeners = [
        'userUpdated' => 'onUserUpdated',
    ];
    
    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage(); // reset to page 1 if search changes
    }

    public function onUserUpdated($data = null)
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

    public function getUserProperty()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        return $query->latest()->paginate(10);
    }

    public function render()
    {
        return view('livewire.dashboard.user.user-list',[
            'users'=>$this->getUserProperty()
        ]);
    }

    public function edit($id)
    {
        $this->dispatch('editUser', $id);
    }

    public function confirmDelete($id)
    {
        $this->userId = $id;
        Flux::modal('delete-user')->show();
    }

    public function deleteUser()
    {
        $user = User::find($this->userId);
        if ($user) {
            $user->delete();

            session()->flash('success', 'User deleted successfully.');

            Flux::modal('delete-user')->close();
            $this->resetPage();
        }
    }
}
