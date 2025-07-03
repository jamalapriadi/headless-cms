<div>
    <flux:modal.trigger name="create-user-form">
        <flux:button icon="plus" variant="primary">Add New User</flux:button>
    </flux:modal.trigger>

    <flux:modal name="create-user-form" variant="flyout" :dismissible="false">
        <div class="space-y-6">

            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('message') }}
                </div>
            @endif
            
            <flux:icon.loading wire:loading class="flex justify-center items-center mt-4 text-center" />

            <div>
                <flux:heading size="lg">Add new User</flux:heading>
            </div>

            <flux:separator />

            <flux:field>
                <flux:input class="mb-4" label="Name" wire:model="name" placeholder="Name" autofocus/>

                <flux:input class="mb-4" type="email" label="Email" wire:model="email" placeholder="Email"/>

                <flux:input class="mb-4" type="password" label="Password" wire:model="password" placeholder="Password"/>

                <flux:input class="mb-4" type="password" label="Password Confirmation" wire:model="password_confirmation" placeholder="Password Confirmation"/>

                <flux:select wire:model="role" label="Role" placeholder="Select Role">
                    <flux:select.option value="">Select Role</flux:select.option>
                    @foreach($roles as $key=>$r)
                        <flux:select.option value="{{ $r->name }}">{{$r->name}}</flux:select.option>
                    @endforeach
                </flux:select>
            </flux:field>

            <flux:separator />

            <div class="flex">

                <div class="flex text-start">
                    <flux:modal.close>
                        <flux:button variant="ghost" class="">Cancel</flux:button>
                    </flux:modal.close>
                </div>
                <div class="flex-1 text-right">
                    <flux:button type="submit" wire:click="save" variant="primary">Save</flux:button>
                </div>
            </div>
        </div>
    </flux:modal>
</div>