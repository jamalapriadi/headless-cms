<?php

namespace App\Livewire;

use Livewire\Component;

class EditorComponent extends Component
{
    public $content;
    public $editorId;
    public $plugins;
    public $toolbar;

    public function mount($editorId = 'tinymce-editor', $content = '', $plugins = 'lists link image table code', $toolbar = 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code')
    {
        $this->editorId = $editorId;
        $this->content = $content;
        $this->plugins = $plugins;
        $this->toolbar = $toolbar;
    }

    public function updatedContent($value)
    {
        $this->dispatch('tinymce-updated', ['content' => $value, 'editorId' => $this->editorId]);
    }

    public function render()
    {
        return view('livewire.editor-component');
    }
}
