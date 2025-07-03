<div>
    <flux:modal.trigger name="create-permission-form">
        <flux:button icon="plus" variant="primary">Add New Permission</flux:button>
    </flux:modal.trigger>

    <flux:modal name="create-permission-form" variant="flyout">
        <div class="space-y-6">

            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('message') }}
                </div>
            @endif
            
            <flux:icon.loading wire:loading class="flex justify-center items-center mt-4 text-center" />

            <div>
                <flux:heading size="lg">Add new Permission</flux:heading>
            </div>

            <flux:field>
                <flux:input label="Name" wire:model="name" placeholder="Name" autofocus/>
            </flux:field>

            <flux:separator />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" wire:click="save" variant="primary">Save</flux:button>
            </div>
        </div>
    </flux:modal>
</div>