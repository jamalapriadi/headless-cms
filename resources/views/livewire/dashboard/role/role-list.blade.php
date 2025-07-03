<x-slot name="title">
    Role
</x-slot>

<section class="w-full">
    @include('partials.settings-rbac')

    <x-settings.rbac :heading="__('Roles')" :subheading="__('Manage data Role')">
        <div>

            <div class="p-4 bg-white rounded space-y-4">

                <div class="flex justify-between items-center mt-1">
                    <div>
                        <flux:input icon="magnifying-glass" wire:model.live.debounce.300ms="search" placeholder="Search Role..." />
                    </div>
                    <div>
                        @can('create roles')
                            <livewire:dashboard.role.role-create />
                        @endcan 

                        @can('edit roles')
                            <livewire:dashboard.role.role-edit />
                        @endcan
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
                            <th class="p-2 text-center">Users</th>
                            <th class="p-2 text-center">Permissions</th>
                            <th class="p-2 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $key=>$role)
                            <tr class="border-t">
                                <td class="p-2"><flux:text>{{ $loop->iteration }}</flux:text></td>
                                <td class="p-2"><flux:text>{{ $role->name }}</flux:text></td>
                                <td class="p-2 text-center"><flux:text>{{ $role->users_count }}</flux:text></td>
                                <td class="p-2 text-center"><flux:text>{{ $role->permissions_count }}</flux:text></td>
                                <td class="p-2 text-center">
                                    @can('edit roles')
                                        <flux:tooltip content="Edit" position="top">
                                            <flux:button
                                                size="sm"
                                                icon="pencil"
                                                variant="subtle"
                                                wire:loading.attr="disabled"
                                                wire:click="edit('{{ $role->id }}')">
                                            </flux:button>
                                        </flux:tooltip>
                                    @endcan

                                    @can('delete roles')
                                        <flux:tooltip content="Delete" position="top">

                                            <flux:button
                                                size="sm"
                                                variant="subtle"
                                                icon="trash"
                                                wire:loading.attr="disabled"
                                                wire:click="confirmDelete('{{ $role->id }}')"
                                                class="ml-2">
                                            </flux:button>

                                        </flux:tooltip>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-2 text-center text-gray-500">No role found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $roles->links() }}
                </div>

                <flux:modal name="delete-role" class="min-w-[22rem]">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">
                                Delete Role
                            </flux:heading>
                            <flux:text class="mt-2">
                                <p>Are you sure you want to delete this role? This action cannot be undone.</p>
                            </flux:text>
                        </div>
                        <div class="flex gap-2">
                            <flux:spacer />
                            <flux:modal.close>
                                <flux:button variant="ghost">Cancel</flux:button>
                            </flux:modal.close>
                            <flux:button type="submit" variant="danger" wire:click="deleteRole('{{ $roleId }}')">Yes</flux:button>
                        </div>
                    </div>
                </flux:modal>
            </div>
        </div>
    </x-settings.rbac>

</section>