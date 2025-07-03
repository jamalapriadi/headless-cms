<?php

namespace App\Livewire\Dashboard\Pages;

use Livewire\Component;
use App\Models\Page;
use Livewire\WithPagination;
use Flux\Flux;

class PagesList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedDate = null;
    public $statusPage = 'all'; // 'all', 'published', 'draft'
    public $pageId;

    protected $paginationTheme = 'tailwind';

    protected $listeners = [
        'deletePage' => 'deletePage',
    ];

    public function updatingSearch()
    {
        $this->resetPage(); // reset to page 1 if search changes
    }

    public function mount()
    {
        // Initialize any necessary data here, but avoid setting $posts
    }

    public function getPagesProperty()
    {
        $query = Page::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('body', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->selectedDate) {
            // Expected format: 'YYYY-MM'
            [$year, $month] = explode('-', $this->selectedDate);
            $query->whereYear('created_at', $year)
                  ->whereMonth('created_at', $month);
        }

        if ($this->statusPage === 'published') {
            $query->where('status', 'published');
        } elseif ($this->statusPage === 'draft') {
            $query->where('status', 'draft');
        }

        return $query->latest()->paginate(10);
    }

    public function render()
    {
        $allPages = Page::count();
        $publishedPages = Page::where('status', 'published')->count();
        $draftPages = Page::where('status', 'draft')->count();

        $allDates = Page::selectRaw('YEAR(created_at) as year, DATE_FORMAT(created_at,"%m") as month, DATE_FORMAT(created_at, "%b") as month_short')
            ->distinct()
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        return view('livewire.dashboard.pages.pages-list', [
            'pages' => $this->getPagesProperty(),
            'allPages' => $allPages,
            'publishedPages' => $publishedPages,
            'draftPages' => $draftPages,
            'allDates' => $allDates,
        ]);
    }

    public function filterPages()
    {
        $this->resetPage(); // Reset pagination when filters are applied
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->selectedDate = null;
        $this->statusPage = 'all';
        $this->resetPage();
    }

    public function changeStatus($status)
    {
        $this->statusPage = $status;
        $this->filterPages();
    }

    public function confirmDelete($id)
    {
        $this->pageId = $id;
        Flux::modal('delete-page')->show();
    }

    public function deletePage()
    {
        $page = Page::find($this->pageId);
        if ($page) {
            $page->delete();

            session()->flash('success', 'Page deleted successfully.');

            Flux::modal('delete-page')->close();
        }
    }
}
