<div>
    <x-slot name="title">
        Categories
    </x-slot>

    <div class="relative mb-6 w-full">
        <div class="flex justify-between items-center mt-1">
            <div>
                <flux:heading size="xl" class="mb-6">Categories</flux:heading>
            <flux:subheading size="lg" class="mb-6">Manage data Categories</flux:heading>
            </div>
            <div>
                @can('create categories')
                    <livewire:dashboard.categories.category-create />
                @endcan 

                @can('edit categories')
                    <livewire:dashboard.categories.category-edit />
                @endcan
            </div>
        </div>
    </div>
    <flux:separator variant="subtle" />

    <div class="p-4 bg-white rounded space-y-4">

        <div class="flex justify-between items-center mt-1">
            <div>
                
            </div>
            <div>
                <flux:input icon="magnifying-glass" wire:model.live.debounce.300ms="search" placeholder="Search Categories" />
            </div>
        </div>

        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <table class="w-full border mt-2">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">#</th>
                    <th class="p-2 text-left">Name</th>
                    <th class="p-2 text-left">Slug</th>
                    <th class="p-2 text-right">Count</th>
                    <th class="p-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $key=>$category)
                    <tr class="border-t">
                        <td class="p-2"><flux:text>{{ $loop->iteration }}</flux:text></td>
                        <td class="p-2"><flux:text>{{ $category->name }}</flux:text></td>
                        <td class="p-2"><flux:text>{{ $category->slug }}</flux:text></td>
                        <td class="p-2 text-right"><flux:text>{{ $category->posts->count() }}</flux:text></td>
                        <td class="p-2 text-center">
                            @can('edit categories')
                                <flux:tooltip content="Edit" position="top">
                                    <flux:button
                                        size="sm"
                                        icon="pencil"
                                        variant="subtle"
                                        wire:loading.attr="disabled"
                                        wire:click="edit('{{ $category->id }}')">
                                    </flux:button>
                                </flux:tooltip>
                            @endcan

                            @can('delete categories')
                                <flux:tooltip content="Delete" position="top">

                                    <flux:button
                                        size="sm"
                                        variant="subtle"
                                        icon="trash"
                                        wire:loading.attr="disabled"
                                        wire:click="confirmDelete('{{ $category->id }}')"
                                        class="ml-2">
                                    </flux:button>

                                </flux:tooltip>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-2 text-center text-gray-500">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>

        <flux:modal name="delete-category" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">
                        Delete Category
                    </flux:heading>
                    <flux:text class="mt-2">
                        <p>Are you sure you want to delete this category? This action cannot be undone.</p>
                    </flux:text>
                </div>
                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="danger" wire:click="deleteCategory('{{ $categoryId }}')">Yes</flux:button>
                </div>
            </div>
        </flux:modal>
    </div>
</div>