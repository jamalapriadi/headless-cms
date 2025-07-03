<div>
    <flux:modal.trigger name="create-role-form">
        <flux:button icon="plus" variant="primary">Add New Role</flux:button>
    </flux:modal.trigger>

    <flux:modal name="create-role-form" variant="flyout">
        <div class="space-y-6">

            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('message') }}
                </div>
            @endif
            
            <flux:icon.loading wire:loading class="flex justify-center items-center mt-4 text-center" />

            <div>
                <flux:heading size="lg">Add new Role</flux:heading>
            </div>

            <flux:field>
                <flux:input class="mb-3" label="Name" wire:model="name" placeholder="Name" autofocus/>

                <flux:checkbox.group wire:model="permissions">
                    <flux:checkbox.all label="Permissions"/>
                    <flux:separator class="mb-3 mt-3"/>
                    @foreach($perms as $key=>$perm)
                        <flux:checkbox label="{{ $perm->name }}" value="{{ $perm->name }}" :checked="in_array($perm->name, $permissions)" />
                    @endforeach
                </flux:checkbox.group>
            </flux:field>

            <flux:separator />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" wire:click="save" variant="primary">Save</flux:button>
            </div>
        </div>
    </flux:modal>
</div>