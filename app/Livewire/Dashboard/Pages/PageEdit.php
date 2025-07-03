<?php

namespace App\Livewire\Dashboard\Pages;

use Livewire\Component;
use App\Models\Page;
use Str;

class PageEdit extends Component
{
    public $pageId, $title, $content ='', $status = 'draft';

    protected $listeners = [
        'tinymce-updated' => 'updatePostContent',
    ];

    public function updatePostContent($data)
    {
        $this->content = $data['content'];
    }

    public function mount($pageId)
    {
        $this->pageId = $pageId;
        $page = Page::findOrFail($this->pageId);

        // Initialize properties with page data
        $this->title = $page->title;
        $this->content = $page->body;
        $this->status = $page->status;
    }

    protected $rules = [
        'title' => 'required|string|min:2|max:255|unique:posts,title',
        'content' => 'required|string|min:10',
    ];

    public function update()
    {
        $this->validate();

        $page = Page::findOrFail($this->pageId);
        $page->update([
            'title' => $this->title,
            'body' => $this->content,
            'status'=>$this->status,
            'user_id'=>auth()->user()->id
        ]);

        $this->reset(['title', 'content', 'status']);

        session()->flash('success', 'Page has been updated successfully.');

        return $this->redirect(route('dashboard.pages'), navigate: true);
    }

    public function render()
    {
        return view('livewire.dashboard.pages.page-edit');
    }
}
