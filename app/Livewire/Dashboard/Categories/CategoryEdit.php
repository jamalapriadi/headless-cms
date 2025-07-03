<?php

namespace App\Livewire\Dashboard\Categories;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Category;
use Flux\Flux;

class CategoryEdit extends Component
{
    public $categoryId, $name, $slug;

    protected $listeners = [
        'editCategory' => 'editCategory',
    ];

    public function render()
    {
        return view('livewire.dashboard.categories.category-edit');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $id;
        $this->name = $category->name;
        $this->slug = $category->slug;

        Flux::modal('edit-category-form')->show();
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $this->categoryId,
        ]);


        $category = Category::findOrFail($this->categoryId);
        $category->update([
            'name' => $this->name,
            'slug' => $validated['slug'] ?: Str::slug($validated['name']),
        ]);

        $this->reset(['name', 'slug']);
        $this->dispatch('categoryUpdated', ['success' => true, 'message' => 'Category updated successfully.']);

        Flux::modal('edit-category-form')->close();
    }
}
