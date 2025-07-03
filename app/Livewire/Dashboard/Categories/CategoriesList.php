<?php

namespace App\Livewire\Dashboard\Categories;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Flux\Flux;

class CategoriesList extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryId;

    protected $listeners = [
        'categoryUpdated' => 'onCategoryUpdated',
    ];
    
    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage(); // reset to page 1 if search changes
    }

    public function onCategoryUpdated($data = null)
    {
        if($data){
            if($data['success']){
                session()->flash('success', $data['message']);
            }else{
                session()->flash('error', 'Category creation failed.');
            }
        }

        $this->resetPage();
    }

    public function getCategoriesProperty()
    {
        $query = Category::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            });
        }

        return $query->latest()->paginate(10);
    }

    public function render()
    {
        return view('livewire.dashboard.categories.categories-list',[
            'categories'=>$this->getCategoriesProperty()
        ]);
    }

    public function edit($id)
    {
        $this->dispatch('editCategory', $id);
    }

    public function confirmDelete($id)
    {
        $this->categoryId = $id;
        Flux::modal('delete-category')->show();
    }

    public function deleteCategory()
    {
        $category = Category::find($this->categoryId);
        if ($category) {
            $category->delete();

            session()->flash('success', 'Category deleted successfully.');

            Flux::modal('delete-category')->close();
            $this->resetPage();
        }
    }
}
