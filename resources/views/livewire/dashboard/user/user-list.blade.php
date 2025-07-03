<x-slot name="title">
    Users
</x-slot>

<section class="w-full">
    @include('partials.settings-rbac')

    <x-settings.rbac :heading="__('Users')" :subheading="__('Manage data User')">
        <div>

            <div class="p-4 bg-white rounded space-y-4">

                <div class="flex justify-between items-center mt-1">
                    <div>
                        <flux:input icon="magnifying-glass" wire:model.live.debounce.300ms="search" placeholder="Search User..." />
                    </div>
                    <div>
                        @can('create users')
                            <livewire:dashboard.user.user-create />
                        @endcan

                        @can('edit users')
                            <livewire:dashboard.user.user-edit />
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
                            <th class="p-2 text-left">Email</th>
                            <th class="p-2 text-left">Role</th>
                            <th class="p-2 text-left">Posts</th>
                            <th class="p-2 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $key=>$user)
                            <tr class="border-t">
                                <td class="p-2"><flux:text>{{ $loop->iteration }}</flux:text></td>
                                <td class="p-2"><flux:text>{{ $user->name }}</flux:text></td>
                                <td class="p-2"><flux:text>{{ $user->email }}</flux:text></td>
                                <td class="p-2">
                                    <flux:text>{{ $user->roles->pluck('name')->join(', ') }}</flux:text>
                                </td>
                                <td class="p-2 text-center">
                                    <flux:text>{{ $user->posts()->count() }}</flux:text>
                                </td>
                                <td class="p-2 text-center">
                                    @can('edit users')
                                        <flux:tooltip content="Edit" position="top">
                                            <flux:button
                                                size="sm"
                                                icon="pencil"
                                                variant="subtle"
                                                wire:loading.attr="disabled"
                                                wire:click="edit('{{ $user->id }}')">
                                            </flux:button>
                                        </flux:tooltip>
                                    @endcan

                                    @can('delete users')
                                        <flux:tooltip content="Delete" position="top">

                                            <flux:button
                                                size="sm"
                                                variant="subtle"
                                                icon="trash"
                                                wire:loading.attr="disabled"
                                                wire:click="confirmDelete('{{ $user->id }}')"
                                                class="ml-2">
                                            </flux:button>

                                        </flux:tooltip>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-2 text-center text-gray-500">No user found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>

                <flux:modal name="delete-user" class="min-w-[22rem]">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">
                                Delete User
                            </flux:heading>
                            <flux:text class="mt-2">
                                <p>Are you sure you want to delete this user? This action cannot be undone.</p>
                            </flux:text>
                        </div>
                        <div class="flex gap-2">
                            <flux:spacer />
                            <flux:modal.close>
                                <flux:button variant="ghost">Cancel</flux:button>
                            </flux:modal.close>
                            <flux:button type="submit" variant="danger" wire:click="deleteUser('{{ $userId }}')">Yes</flux:button>
                        </div>
                    </div>
                </flux:modal>
            </div>
        </div>
    </x-settings.rbac>

</section>