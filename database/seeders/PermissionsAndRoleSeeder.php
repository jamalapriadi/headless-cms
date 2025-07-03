<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsAndRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            'translation posts',
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'view pages',
            'create pages',
            'edit pages',
            'delete pages',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',
            'view languages',
            'create languages',
            'edit languages',
            'delete languages',
            'view media',
            'upload media',
            'view settings'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = ['Administrator', 'Editor', 'Author', 'Contributor', 'Subscriber'];

        foreach($roles as $role){
            Role::firstOrCreate(['name'=>$role]);
        }

        //USER ADMINISTRATOR
        $user = User::firstOrCreate(
            ['email' => 'jamal.apriadi@gmail.com'],
            [
                'name' => 'jamal apriadi',
                'password' => bcrypt('JulyCode2015!'),
            ]
        );

        $adminRole = Role::firstOrCreate(['name' => 'Administrator']);
        $adminRole->syncPermissions($permissions);
        $user->assignRole($adminRole);
    }
}
