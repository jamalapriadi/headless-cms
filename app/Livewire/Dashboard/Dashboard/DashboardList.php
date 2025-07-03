<?php

namespace App\Livewire\Dashboard\Dashboard;

use Livewire\Component;
use App\Models\Post;
use App\Models\Category;
use App\Models\Page;

class DashboardList extends Component
{
    public function render()
    {
        $totalCategories = Category::count();

        $totalPosts = Post::count();
        $totalPostsPublished = Post::where('status', 'published')->count();
        $totalPostsDraft = Post::where('status', 'draft')->count();

        $totalPages = Page::count();
        $totalPagesPublished = Page::where('status', 'published')->count();
        $totalPagesDraft = Page::where('status', 'draft')->count();

        return view('livewire.dashboard.dashboard.dashboard-list',[
            'totalCategories' => $totalCategories,
            'totalPages' => $totalPages,
            'totalPagesPublished' => $totalPagesPublished,
            'totalPagesDraft' => $totalPagesDraft,
            'totalPosts' => $totalPosts,
            'totalPostsPublished' => $totalPostsPublished,
            'totalPostsDraft' => $totalPostsDraft
        ]);
    }
}
