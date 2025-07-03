<?php

namespace App\Livewire\Dashboard\Posts;

use Livewire\Component;
use App\Models\Post;
use App\Models\Language;
use Str;
use Flux\Flux;

use App\Models\PostTranslation as Translation;

class PostTranslation extends Component
{
    public $postId;
    public $postTranslations = [];

    protected $listeners = [
        'tinymce-updated' => 'updatePostContent',
    ];

    public function mount($postId)
    {
        $this->postId = $postId;

        $allLanguages = $this->getLanguage();
        foreach($allLanguages as $key=>$val){
            $locale = Translation::firstOrCreate(
                [
                    'post_id' => $postId,
                    'locale' => $val->locale,
                ],
                [
                    'title' => '', 
                    'short_description' =>'',
                    'content' => ''

                ]
            );

            $this->postTranslations[$val->locale]['id'] = $locale->id;
            $this->postTranslations[$val->locale]['locale'] = $locale->locale;
            $this->postTranslations[$val->locale]['post_id'] = $locale->post_id;
            $this->postTranslations[$val->locale]['title'] = $locale->title;
            $this->postTranslations[$val->locale]['short_description'] = $locale->short_description;
            $this->postTranslations[$val->locale]['content'] = $locale->content ? $locale->content : '<p></p>';
        }
    }

    public function getLanguage(){
        return Language::latest()->get();
    }

    public function render()
    {
        $post = Post::findOrFail($this->postId);

        return view('livewire.dashboard.posts.post-translation',[
            'post'=>$post,
            'languages'=>$this->getLanguage()
        ]);
    }

    public function inputTitleLanguage($value = '', $locale){
        $this->postTranslations[$locale]['title'] = $value;
    }

    public function inputShortDescriptionLanguage($value = '', $locale){

        $this->postTranslations[$locale]['short_description'] = $value;
    }

    public function updatePostContent($data)
    {
        $editorParts = explode('-', $data['editorId']);
        
        $this->postTranslations[$editorParts[2]]['content'] = $data['content'];
    }

    public function updateTranslations(){
        foreach($this->postTranslations as $key=>$val){
            Translation::where('post_id', $this->postId)
                ->where('locale', $val['locale'])
                ->update(
                    [
                        'title'=>$val['title'],
                        'short_description'=>$val['short_description'],
                        'content'=>$val['content'],
                    ]
                );
        }

        Flux::modal('confirmation-update-translation')->close();
        session()->flash('success', 'Translation successfully updated!');
        return redirect(request()->header('Referer'));
    }
}
