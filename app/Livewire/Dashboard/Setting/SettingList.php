<?php

namespace App\Livewire\Dashboard\Setting;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class SettingList extends Component
{
    public function render()
    {
        $usersCount = User::count();
        $rolesCount = Role::count();
        $permissionsCount = Permission::count();

        return view('livewire.dashboard.setting.setting-list', [
            'usersCount' => $usersCount,
            'rolesCount' => $rolesCount,
            'permissionsCount' => $permissionsCount,
        ]);
    }
}
