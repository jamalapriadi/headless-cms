<?php

namespace App\Livewire\Dashboard\Language;

use Livewire\Component;

use App\Models\Language;
use Illuminate\Support\Str;
use Flux\Flux;

class LanguageCreate extends Component
{ 
    public $locale, $name, $is_default = false;

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'locale' => 'required|string|max:255|unique:languages,locale',
            'is_default' => 'boolean',
        ]);

        if($validated['is_default'] == true){
            Language::where('is_default', true)
                ->update(
                    [
                        'is_default'=>false
                    ]
                );
        }

        Language::Create([
            'name' => $validated['name'],
            'locale' => $validated['locale'],
            'is_default' => $validated['is_default']
        ]);

        $this->resetForm();
        
        $this->dispatch('languageUpdated', ['success'=>true,'message'=>'Language created successfully.']);

        Flux::modal('create-language-form')->close();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->locale = '';
        $this->is_default = false;
    }

    public function render()
    {
        return view('livewire.dashboard.language.language-create');
    }
}
