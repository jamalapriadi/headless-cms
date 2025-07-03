<div>
    <flux:modal.trigger name="create-language-form">
        <flux:button icon="plus" variant="primary">Add New Language</flux:button>
    </flux:modal.trigger>

    <flux:modal name="create-language-form" variant="flyout">
        <div class="space-y-6">

            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('message') }}
                </div>
            @endif
            
            <flux:icon.loading wire:loading class="flex justify-center items-center mt-4 text-center" />

            <div>
                <flux:heading size="lg">Add new Language</flux:heading>
            </div>

            <flux:field>
                <flux:input label="Locale" wire:model="locale" placeholder="Locale" autofocus />
            </flux:field>

            <flux:field>
                <flux:input label="Name" wire:model="name" placeholder="Name" />
            </flux:field>

            <flux:field>
                <flux:switch wire:model.live="is_default" label="Is Default?" placeholder="Is Default?" />
            </flux:field>

            <flux:separator />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" wire:click="save" variant="primary">Save</flux:button>
            </div>
        </div>
    </flux:modal>
</div>