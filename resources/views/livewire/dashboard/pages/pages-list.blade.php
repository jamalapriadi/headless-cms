<div>
    <x-slot name="title">
        Pages
    </x-slot>

    <div class="relative mb-6 w-full">
        <div class="flex justify-between items-center mt-1">
            <div>
                <flux:heading size="xl" class="mb-6">Pages</flux:heading>
                <flux:subheading size="lg" class="mb-6">Manage data Page</flux:heading>
            </div>
            <div>
                @can('create pages')
                    <flux:button icon="plus" href="{{ route('dashboard.pages.create') }}" variant="primary">Add New Page</flux:button>
                @endcan
            </div>
        </div>
    </div>
    <flux:separator variant="subtle" />

    <div class="p-4 bg-white rounded space-y-4">

        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="flex flex-row items-center space-x-2 mt-1">
            <flux:link
                size="sm"
                href="#"
                variant="subtle"
                wire:loading.attr="disabled"
                wire:click="changeStatus('all')"
                style="cursor: pointer;">
                <flux:text :variant="$statusPage === 'all' ? 'strong' : 'subtle'">All ({{ $allPages }})</flux:text>
            </flux:link>

            <flux:separator vertical variant="subtle" class="my-2" />
            
            <flux:button
                size="sm"
                variant="subtle"
                wire:loading.attr="disabled"
                wire:click="changeStatus('published')"
                style="cursor: pointer;">
                <flux:text :variant="$statusPage === 'published' ? 'strong' : 'subtle'">Published ({{ $publishedPages }})</flux:text>
            </flux:button>

            <flux:separator vertical variant="subtle" class="my-2" />
            
            <flux:button
                size="sm"
                variant="subtle"
                wire:loading.attr="disabled"
                wire:click="changeStatus('draft')"
                style="cursor: pointer;">
                <flux:text :variant="$statusPage === 'draft' ? 'strong' : 'subtle'">Drafts ({{ $draftPages}})</flux:text>
            </flux:button>
        </div>

        <div class="grid grid-cols-5 gap-4">
            <flux:input size="sm" icon="magnifying-glass" wire:model="search" placeholder="Search Page" />

            <flux:select size="sm" wire:model="selectedDate">
                <flux:select.option value="" selected>All Dates</flux:select.option>
                @foreach ($allDates as $key=>$dates)
                    <flux:select.option value="{{$dates->year}}-{{ $dates->month}}">{{$dates->month_short}} {{ $dates->year }}</flux:select.option>    
                @endforeach
            </flux:select>
            <flux:button
                size="sm"
                icon="funnel"
                wire:loading.attr="disabled"
                style="cursor: pointer;"
                wire:click="filterPages">
                Filter
            </flux:button>
            <flux:button
                size="sm"
                icon="arrow-path"
                wire:loading.attr="disabled"
                style="cursor: pointer;"
                wire:click="resetFilters">
                Reset
            </flux:button>
        </div>

        <table class="w-full border mt-2">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left">#</th>
                    <th class="py-2 px-4 border-b text-left">Title</th>
                    <th class="py-2 px-4 border-b text-left">Author</th>
                    <th class="py-2 px-4 border-b text-left">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pages as $key=>$post)
                    <tr>
                        <td class="py-2 px-4 border-b">
                            {{ $loop->iteration }}
                        </td>
                        <td class="py-2 px-4 border-b post-title">
                            <flux:heading class="post-item hover:cursor-pointer">
                                {{ $post->title }}
                                @if($post->status === 'draft')
                                    <span class="text-yellow-500 text-xs">(Draft)</span>
                                @endif
                            </flux:heading>
                            <div class="flex flex-row items-center space-x-2 mt-1 detail-action-post hidden">
                                @can('edit pages')
                                    <flux:link
                                        size="sm"
                                        href="{{ route('dashboard.pages.edit', $post->id) }}"
                                        variant="subtle"
                                        wire:loading.attr="disabled"
                                        wire:click="confirmDelete('{{ $post->id }}')" style="cursor: pointer;">
                                        <flux:text class="text-xs">Edit</flux:text>
                                    </flux:link>
                                @endcan

                                @can('delete pages')
                                    <flux:separator vertical variant="subtle" class="my-2" />
                                    
                                    <flux:button
                                        size="sm"
                                        variant="subtle"
                                        wire:loading.attr="disabled"
                                        wire:click="confirmDelete('{{ $post->id }}')" style="cursor: pointer;">
                                        <flux:text color="red" class="text-xs" wire:click="confirmDelete('{{ $post->id }}')">Trash</flux:text>
                                    </flux:button>
                                @endcan
                            </div>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <flux:text class="text-xs">{{ $post->user ? $post->user->name : '-' }}</flux:text>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <flux:text class="text-xs">Last Modified</flux:text>
                            <flux:text class="text-xs text-gray-500">{{ date('d F Y', strtotime($post->updated_at)) }} at {{ date('H:i', strtotime($post->updated_at)) }}</flux:text>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-500">No pages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $pages->links() }}
        </div>

        <flux:modal name="delete-page" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">
                        Delete Page
                    </flux:heading>
                    <flux:text class="mt-2">
                        <p>Are you sure you want to delete this page? This action cannot be undone.</p>
                    </flux:text>
                </div>
                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="danger" wire:click="deletePage('{{ $pageId }}')">Yes</flux:button>
                </div>
            </div>
        </flux:modal>
    </div>
</div>
