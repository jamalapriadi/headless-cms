<x-slot name="title">
    Languages
</x-slot>

<section class="w-full">
    @include('partials.settings-rbac')

    <x-settings.rbac :heading="__('Languages')" :subheading="__('Manage data Language')">
        <div>
            <x-slot name="title">
                Languages
            </x-slot>

            <div class="p-4 bg-white rounded space-y-4">

                <div class="flex justify-between items-center mt-1">
                    <div>
                        <flux:input icon="magnifying-glass" wire:model.live.debounce.300ms="search" placeholder="Search Language" />
                    </div>
                    <div>
                        @can('create languages')
                            <livewire:dashboard.language.language-create />
                        @endcan 

                        @can('edit languages')
                            <livewire:dashboard.language.language-edit />
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
                            <th class="p-2 text-left">Locale</th>
                            <th class="p-2 text-left">Name</th>
                            <th class="p-2 text-left">Default</th>
                            <th class="p-2 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($languages as $key=>$language)
                            <tr class="border-t">
                                <td class="p-2"><flux:text>{{ $loop->iteration }}</flux:text></td>
                                <td class="p-2"><flux:text>{{ $language->locale }}</flux:text></td>
                                <td class="p-2"><flux:text>{{ $language->name }}</flux:text></td>
                                <td class="p-2">
                                        <flux:switch :checked="$language->is_default ? true : false" :value="$language->is_default" wire:change="changeDefaultLanguage($event.target.value, '{{ $language->locale }}')" />
                                </td>
                                <td class="p-2 text-center">

                                    @can('delete languages')
                                        <flux:tooltip content="Delete" position="top">

                                            <flux:button
                                                size="sm"
                                                variant="subtle"
                                                icon="trash"
                                                wire:loading.attr="disabled"
                                                wire:click="confirmDelete('{{ $language->locale }}')"
                                                class="ml-2">
                                            </flux:button>

                                        </flux:tooltip>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-2 text-center text-gray-500">No language found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $languages->links() }}
                </div>

                <flux:modal name="delete-language" class="min-w-[22rem]">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">
                                Delete Language
                            </flux:heading>
                            <flux:text class="mt-2">
                                <p>Are you sure you want to delete this language? This action cannot be undone.</p>
                            </flux:text>
                        </div>
                        <div class="flex gap-2">
                            <flux:spacer />
                            <flux:modal.close>
                                <flux:button variant="ghost">Cancel</flux:button>
                            </flux:modal.close>
                            <flux:button type="submit" variant="danger" wire:click="deleteLanguage('{{ $languageId }}')">Yes</flux:button>
                        </div>
                    </div>
                </flux:modal>
            </div>
        </div>
    </x-settings.rbac>

</section>