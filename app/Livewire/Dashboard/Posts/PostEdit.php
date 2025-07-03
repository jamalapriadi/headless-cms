<?php

namespace App\Livewire\Dashboard\Posts;

use Livewire\Component;
use App\Models\Post;
use App\Models\Category;
use Str;

class PostEdit extends Component
{
    public $postId; // ID of the post to edit
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

    public function mount($postId)
    {
        $this->postId = $postId;
        $post = Post::findOrFail($this->postId);

        // Initialize properties with post data
        $this->title = $post->title;
        $this->content = $post->content;
        $this->short_description = $post->short_description;
        $this->image = $post->image; // Reset image to allow new upload
        $this->status = $post->status;
        $this->published_at = $post->published_at
            ? (\Carbon\Carbon::parse($post->published_at))->format('Y-m-d\TH:i')
            : null;
        $this->categories = $post->categories()->pluck('id')->toArray();
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

    public function removeFile(){
        $this->image = null;
    }

    public function handleMultipleFilesUpload($data)
    {
        if ($data['model'] === 'documents') {
            $this->attachments = $data['files'];
            session()->flash('message', 'Lampiran berhasil diunggah (sementara)!');
        }
    }

    public function store()
    {
        $this->validate();

        \DB::beginTransaction();

        try {
            $post = Post::findOrFail($this->postId);
            $post->title = $this->title;
            $post->content = $this->content;
            $post->short_description = $this->short_description;
            $post->image = $this->image;

            $post->status = $this->status;
            $post->published_at = $this->status === 'published' ? $this->published_at : null;
            $post->user_id = auth()->user()->id;
            $post->save();
            
            // Sync categories
            $post->categories()->sync($this->categories);

            \DB::commit();

            session()->flash('success', 'Post has been successfully updated!');

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

    public function render()
    {
        $allCategories = Category::all();

        return view('livewire.dashboard.posts.post-edit',[
            'allCategories' => $allCategories,
        ]);
    }
}
