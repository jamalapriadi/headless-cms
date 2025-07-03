<?php

namespace App\Livewire\Dashboard\Posts;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;
use Flux\Flux;

class PostsList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedDate = null;
    public $selectedCategory = null;
    public $statusPost = 'all'; // 'all', 'published', 'draft'
    public $postId;

    protected $paginationTheme = 'tailwind';

    protected $listeners = [
        'deletePost' => 'deletePost',
    ];

    public function updatingSearch()
    {
        $this->resetPage(); // Reset to page 1 if search changes
    }

    public function mount()
    {
        // Initialize any necessary data here, but avoid setting $posts
    }

    public function getPostsProperty()
    {
        $query = Post::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->selectedDate) {
            // Expected format: 'YYYY-MM'
            [$year, $month] = explode('-', $this->selectedDate);
            $query->whereYear('published_at', $year)
                  ->whereMonth('published_at', $month);
        }

        if ($this->selectedCategory) {
            $query->whereHas('categories', function ($q) {
                $q->where('id', $this->selectedCategory);
            });
        }

        if ($this->statusPost === 'published') {
            $query->where('status', 'published');
        } elseif ($this->statusPost === 'draft') {
            $query->where('status', 'draft');
        }

        return $query->latest()->paginate(10);
    }

    public function render()
    {
        $allPosts = Post::count();
        $publishedPosts = Post::where('status', 'published')->count();
        $draftPosts = Post::where('status', 'draft')->count();
        $allDates = Post::selectRaw('YEAR(published_at) as year, DATE_FORMAT(published_at,"%m") as month, DATE_FORMAT(published_at, "%b") as month_short')
            ->distinct()
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        $allCategories = Post::with('categories')
            ->get()
            ->pluck('categories')
            ->flatten()
            ->unique('id')
            ->values();

        return view('livewire.dashboard.posts.posts-list', [
            'posts' => $this->getPostsProperty(), // Use computed property
            'allPosts' => $allPosts,
            'publishedPosts' => $publishedPosts,
            'draftPosts' => $draftPosts,
            'allDates' => $allDates,
            'allCategories' => $allCategories,
        ]);
    }

    public function filterPosts()
    {
        $this->resetPage(); // Reset pagination when filters are applied
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->selectedDate = null;
        $this->selectedCategory = null;
        $this->statusPost = 'all';
        $this->resetPage();
    }

    public function changeStatus($status)
    {
        $this->statusPost = $status;
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->postId = $id;
        Flux::modal('delete-post')->show();
    }

    public function deletePost()
    {
        $post = Post::find($this->postId);
        if ($post) {
            $post->delete();
            session()->flash('success', 'Post deleted successfully.');
            Flux::modal('delete-post')->close();
        }
    }
}