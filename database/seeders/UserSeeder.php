<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //USER EDITOR
        $userEditor = User::firstOrCreate(
            ['email' => 'editor@gmail.com'],
            [
                'name' => 'Editor',
                'password' => bcrypt('JulyCode2015!'),
            ]
        );
        $editor = Role::firstOrCreate(['name' => 'Editor']);
        $editor->syncPermissions([
            // Post management
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            'translation posts',

            // Category management
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',

            // Page management
            'view pages',
            'create pages',
            'edit pages',
            'delete pages',

            // Media
            'view media',
            'upload media'
        ]);
        $userEditor->assignRole($editor);

        //USER AUTHOR
        $userAuthor = User::firstOrCreate(
            ['email' => 'author@gmail.com'],
            [
                'name' => 'Author',
                'password' => bcrypt('JulyCode2015!'),
            ]
        );
        $editor = Role::firstOrCreate(['name' => 'Author']);
        $editor->syncPermissions([
            // Post management (hanya post sendiri secara logika, tapi permission-nya tetap sama)
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            'translation posts',

            // Media
            'view media',
            'upload media'
        ]);
        $userAuthor->assignRole($editor);

        //USER Contributor
        $userContributor = User::firstOrCreate(
            ['email' => 'contributor@gmail.com'],
            [
                'name' => 'Contributor',
                'password' => bcrypt('JulyCode2015!'),
            ]
        );
        $editor = Role::firstOrCreate(['name' => 'Contributor']);
        $editor->syncPermissions([
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            'translation posts',
        ]);
        $userContributor->assignRole($editor);
    }
}
