<?php

namespace App\Livewire\Dashboard\Categories;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Flux\Flux;

class CategoryCreate extends Component
{
    public $name, $slug;

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
        ]);

        Category::Create([
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?: Str::slug($validated['name']),
        ]);

        $this->resetForm();
        $this->dispatch('categoryUpdated', ['success'=>true,'message'=>'Category created successfully.']);

        Flux::modal('create-category-form')->close();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->slug = '';
    }

    public function render()
    {
        return view('livewire.dashboard.categories.category-create');
    }
}
