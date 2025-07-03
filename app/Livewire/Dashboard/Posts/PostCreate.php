<?php

namespace App\Livewire\Dashboard\Posts;

use Livewire\Component;
use App\Models\Post;
use App\Models\Category;
use Str;

class PostCreate extends Component
{
    public $title, $content ='', $short_description, $image, $status = 'draft', $published_at, $categories = [];

    protected $rules = [
        'title' => 'required|string|min:5|max:255',
        'content' => 'required|string|min:10',
        'short_description' => 'nullable|string|max:255',
        'image' => 'nullable',
        'status' => 'required|in:draft,published',
        'published_at' => 'nullable|date',
    ];

    protected $listeners = [
        'tinymce-updated' => 'updatePostContent',
        'file-uploaded' => 'handleFileUpload',
        'files-uploaded' => 'handleMultipleFilesUpload',
        'file-removed' => 'handleFileRemoved'
    ];

    public function updatePostContent($data)
    {
        $this->content = $data['content'];
    }


    public function store()
    {
        $this->validate();

        \DB::beginTransaction();

        try {
            Post::create([
                'title' => $this->title,
                'content' => $this->content,
                'short_description' => $this->short_description,
                'image' => $this->image ? $this->image : null,
                'status' => $this->status,
                'published_at' => $this->status === 'published' ? $this->published_at : null,
                'user_id' => auth()->user()->id,
            ])->categories()->sync($this->categories);

            \DB::commit();

            session()->flash('success', 'New post has been successfully added!');

            // Redirect ke halaman daftar postingan setelah berhasil
            return $this->redirect(route('dashboard.posts'), navigate: true);
        } catch (\Exception $e) {
            \DB::rollBack();
            session()->flash('error', 'An error occurred while adding the post: ' . $e->getMessage());
            
            return;
        }
    }

    public function changeStatus($value)
    {
        $this->status = $value; // Update status
        if ($value === 'published' && !$this->published_at) {
            $this->published_at = now()->format('Y-m-d\TH:i');
        }elseif ($value !== 'published') {
            $this->published_at = null;
        }

        $this->validateOnly('status');
    }

    public function handleFileUpload($data)
    {
        if ($data['model'] === 'featured_image') {
            $this->image = $data['file']['path'];
        }
    }

    public function handleFileRemoved($data)
    {
        $this->image = null;
    }

    public function handleMultipleFilesUpload($data)
    {
        if ($data['model'] === 'documents') {
            $this->attachments = $data['files'];
            session()->flash('message', 'Lampiran berhasil diunggah (sementara)!');
        }
    }

    public function render()
    {
        $allCategories = Category::all();
        return view('livewire.dashboard.posts.post-create',[
            'allCategories' => $allCategories,
        ]);
    }
}
