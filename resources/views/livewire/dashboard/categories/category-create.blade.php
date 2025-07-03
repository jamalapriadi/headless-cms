<div>
    <flux:modal.trigger name="create-category-form">
        <flux:button icon="plus" variant="primary">Add New Category</flux:button>
    </flux:modal.trigger>

    <flux:modal name="create-category-form" variant="flyout">
        <div class="space-y-6">

            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('message') }}
                </div>
            @endif
            
            <flux:icon.loading wire:loading class="flex justify-center items-center mt-4 text-center" />

            <div>
                <flux:heading size="lg">Add new Category</flux:heading>
                {{-- <flux:text class="mt-2">Make changes to your personal details.</flux:text> --}}
            </div>

            <flux:field>
                <flux:input label="Name" wire:model="name" placeholder="Category name" autofocus />
                <flux:description>The name is how it appears on your site.</flux:description>
            </flux:field>

            <flux:field>
                <flux:input label="Slug" wire:model="slug" placeholder="Slug" />
                <flux:description>
                    The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.
                </flux:description>
            </flux:field>

            <flux:separator />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" wire:click="save" variant="primary">Save</flux:button>
            </div>
        </div>
    </flux:modal>
</div>