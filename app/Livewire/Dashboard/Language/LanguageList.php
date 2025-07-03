<?php

namespace App\Livewire\Dashboard\Language;

use Livewire\Component;
use App\Models\Language;
use Livewire\WithPagination;
use Flux\Flux;

class LanguageList extends Component
{
    use WithPagination;

    public $search = '';
    public $languageId;

    protected $listeners = [
        'languageUpdated' => '$refresh',
    ];
    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage(); // reset to page 1 if search changes
    }

    public function onLanguageUpdated($data = null)
    {
        if($data){
            if($data['success']){
                session()->flash('success', $data['message']);
            }else{
                session()->flash('error', 'Language creation failed.');
            }
        }

        $this->resetPage();
    }

    public function getLanguageProperty()
    {
        $query = Language::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        return $query->latest()->paginate(10);
    }

    public function render()
    {

        return view('livewire.dashboard.language.language-list',[
            'languages'=>$this->getLanguageProperty()
        ]);
    }

    public function edit($id)
    {
        $this->dispatch('editLanguage', $id);
    }

    public function confirmDelete($id)
    {
        $this->languageId = $id;
        Flux::modal('delete-language')->show();
    }

    public function deleteLanguage()
    {
        $language = Language::find($this->languageId);
        if ($language) {
            $language->delete();

            session()->flash('success', 'Language deleted successfully.');

            Flux::modal('delete-language')->close();
            $this->resetPage();
        }
    }

    public function changeDefaultLanguage($value, $id){
        if($value == false){
            Language::where('is_default', true)
                ->update(
                    [
                        'is_default'=>false
                    ]
                );

            Language::where('locale', $id)
                ->update(
                    [
                        'is_default'=>true
                    ]
                );
            

            return redirect(request()->header('Referer'));
        }
    }
}
