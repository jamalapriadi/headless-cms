<?php

namespace App\Livewire\Dashboard\Pages;

use Livewire\Component;
use App\Models\Page;
use Str;

class PageCreate extends Component
{
    public $title, $content ='', $status = 'draft';

    protected $listeners = [
        'tinymce-updated' => 'updatePostContent',
    ];

    protected $rules = [
        'title' => 'required|string|min:2|max:255|unique:posts,title',
        'content' => 'required|string|min:10',
    ];

    public function store()
    {
        $this->validate();

        Page::create([
            'title' => $this->title,
            'body' => $this->content,
            'status'=>$this->status,
            'user_id'=>auth()->user()->id
        ]);

        session()->flash('success', 'Page has been created successfully.');

        // Redirect ke halaman daftar postingan setelah berhasil
        return $this->redirect(route('dashboard.pages'), navigate: true);
    }

    public function render()
    {
        return view('livewire.dashboard.pages.page-create');
    }
}
