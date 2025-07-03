<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Livewire\Dashboard\Dashboard\DashboardList;
use App\Livewire\Dashboard\Categories\CategoriesList;

use App\Livewire\Dashboard\Posts\PostsList;
use App\Livewire\Dashboard\Posts\PostCreate;
use App\Livewire\Dashboard\Posts\PostEdit;
use App\Livewire\Dashboard\Posts\PostTranslation;

use App\Livewire\Dashboard\Pages\PagesList;
use App\Livewire\Dashboard\Pages\PageCreate;
use App\Livewire\Dashboard\Pages\PageEdit;

use App\Livewire\Dashboard\Language\LanguageList;

use App\Livewire\Dashboard\Media\MediaList;

use App\Livewire\Dashboard\Setting\SettingList;

use App\Livewire\Dashboard\Role\RoleList;
use App\Livewire\Dashboard\Permission\PermissionList;
use App\Livewire\Dashboard\User\UserList;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::group(['prefix'=>'dashboard'], function () {
        Route::get('/',DashboardList::class)->name('dashboard');

        Route::middleware(['permission:view categories'])->get('/categories', CategoriesList::class)->name('dashboard.categories');

        Route::middleware(['permission:view posts'])->get('/posts', PostsList::class)->name('dashboard.posts');
        Route::middleware(['permission:create posts'])->get('/posts/create', PostCreate::class)->name('dashboard.posts.create');
        Route::middleware(['permission:edit posts'])->get('/posts/{postId}/edit', PostEdit::class)->name('dashboard.posts.edit');
        Route::middleware(['permission:translation posts'])->get('/posts/{postId}/translation', PostTranslation::class)->name('dashboard.posts.translation');

        Route::middleware(['permission:view pages'])->get('/pages', PagesList::class)->name('dashboard.pages');
        Route::middleware(['permission:create pages'])->get('/pages/create', PageCreate::class)->name('dashboard.pages.create');
        Route::middleware(['permission:edit pages'])->get('/pages/{pageId}/edit', PageEdit::class)->name('dashboard.pages.edit');

        Route::middleware(['permission:view media'])->get('/media', MediaList::class)->name('dashboard.media');

        Route::middleware(['permission:view settings'])->get('/settings',SettingList::class)->name('dashboard.settings');

        Route::middleware(['permission:view languages'])->get('/languages',LanguageList::class)->name('dashboard.languages');
        Route::middleware(['permission:view roles'])->get('/settings/role',RoleList::class)->name('dashboard.settings.roles');
        Route::middleware(['permission:view users'])->get('/settings/users',UserList::class)->name('dashboard.settings.users');

        Route::middleware(['permission:view permissions'])->get('/settings/permissions',PermissionList::class)->name('dashboard.settings.permissions');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
