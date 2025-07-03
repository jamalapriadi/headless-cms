<div>
    <x-slot name="title">
        Media Library
    </x-slot>

    <div class="relative mb-6 w-full">
        <div class="flex justify-between items-center mt-1">
            <div>
                <flux:heading size="xl" class="mb-6">Media Library</flux:heading>
                <flux:subheading size="lg" class="mb-6">Manage your media files</flux:subheading>
            </div>
            <div>
                @can('upload media')
                    @if($showImageUpload == false)
                        <flux:button icon="photo" wire:click="addMediaFile()" variant="primary">Add Media File</flux:button>
                    @endif
                @endcan
            </div>
        </div>
    </div>
    <flux:separator variant="subtle" />

    @if($showImageUpload)
        <div class="mt-4 mb-4">
            <livewire:file-upload 
                class="mt-4"
                :multiple="false"
                label="Select file to Upload"
                :rules="['required', 'image', 'max:2048']"
                modelName="featured_image"
            />

            <div class="flex justify-center">
                <flux:button icon="x-mark" class="mt-3" wire:click="cancelMediaFile()" variant="danger">Cancel</flux:button>
            </div>
        </div>
    @endif

    <div class="p-4 bg-white rounded space-y-4">

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="flex justify-between items-center mt-1">
            <div>
                <div class="grid grid-cols-4 gap-4">
                    <flux:input size="sm" icon="magnifying-glass" wire:model.live.debounce.300ms="search" placeholder="Search Media..." />

                    <flux:select size="sm" wire:model.live="selectedDate">
                        <flux:select.option value="" selected>All Dates</flux:select.option>
                        @foreach ($allDates as $key=>$dates)
                            <flux:select.option value="{{$dates->year}}-{{ $dates->month}}">{{$dates->month_short}} {{ $dates->year }}</flux:select.option>    
                        @endforeach
                    </flux:select>
                    
                </div>
            </div>
            <div>
                <flux:select size="sm" wire:model.live="perPage" placeholder="Per Page...">
                    <flux:select.option value="12">12 per Page</flux:select.option>
                    <flux:select.option value="24">24 per Page</flux:select.option>
                    <flux:select.option value="48">48 per Page</flux:select.option>
                </flux:select>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
            @forelse ($mediaItems as $media)
                <div wire:click="showDetails('{{ $media->id }}')" class="border rounded-lg shadow-sm overflow-hidden cursor-pointer hover:shadow-lg transition-shadow duration-200 ease-in-out bg-white">
                    @if ($media->mime_type && Str::startsWith($media->mime_type, 'image/'))
                        <img src="{{ asset('storage/'.$media->path) }}" alt="{{ $media->name }}" class="object-cover">
                    @else
                        <div class="w-full h-32 flex items-center justify-center bg-gray-200 text-gray-600 text-center p-2">
                            <span class="text-xl">
                                @if (Str::contains($media->mime_type, 'pdf'))
                                    <i class="fa-solid fa-file-pdf text-red-500 text-5xl"></i>
                                @elseif (Str::contains($media->mime_type, ['word', 'doc']))
                                    <i class="fa-solid fa-file-word text-blue-500 text-5xl"></i>
                                @elseif (Str::contains($media->mime_type, ['excel', 'sheet']))
                                    <i class="fa-solid fa-file-excel text-green-500 text-5xl"></i>
                                @else
                                    <img src="{{ asset('storage/'.$media->path) }}" alt="{{ $media->name }}" class="object-cover">
                                @endif
                            </span>
                        </div>
                    @endif
                    <div class="p-2">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ $media->name ?: $media->file_name }}</p>
                        <p class="text-xs text-gray-500">{{ number_format($media->size / 1024, 2) }} KB</p>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500">Belum ada media yang diunggah.</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $mediaItems->links() }}
        </div>

    </div>

    {{-- Detail Modal --}}
    <flux:modal name="modal-detail-gallery" class="w-full" :dismissible="false">
        @if ($selectedMedia)
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Media # {{$selectedMedia->file_name}}</flux:heading>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        @if ($selectedMedia->mime_type && Str::startsWith($selectedMedia->mime_type, 'image/'))
                            <img src="{{ asset('storage/'.$selectedMedia->path) }}" alt="{{ $selectedMedia->name }}" class="max-w-full h-auto rounded-md border">
                        @else
                            <div class="w-full h-48 flex items-center justify-center bg-gray-100 rounded-md text-gray-600 text-center text-2xl">
                                <span class="text-center">
                                    @if (Str::contains($selectedMedia->mime_type, 'pdf'))
                                        <i class="fa-solid fa-file-pdf text-red-500 text-6xl"></i>
                                    @elseif (Str::contains($selectedMedia->mime_type, ['word', 'doc']))
                                        <i class="fa-solid fa-file-word text-blue-500 text-6xl"></i>
                                    @elseif (Str::contains($selectedMedia->mime_type, ['excel', 'sheet']))
                                        <i class="fa-solid fa-file-excel text-green-500 text-6xl"></i>
                                    @else
                                        <img src="{{ asset('storage/'.$selectedMedia->path) }}" alt="{{ $selectedMedia->name }}" class="max-w-full h-auto rounded-md border">
                                    @endif
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="space-y-2">
                        <p><span class="font-semibold text-gray-700">File Name:</span> {{ $selectedMedia->file_name }}</p>
                        <p><span class="font-semibold text-gray-700">MIME Type:</span> {{ $selectedMedia->mime_type }}</p>
                        <p><span class="font-semibold text-gray-700">Size:</span> {{ number_format($selectedMedia->size / 1024, 2) }} KB</p>
                        @if ($selectedMedia->width && $selectedMedia->height)
                            <p><span class="font-semibold text-gray-700">Dimensions:</span> {{ $selectedMedia->width }} x {{ $selectedMedia->height }} px</p>
                            <p><span class="font-semibold text-gray-700">Orientation:</span> {{ ucfirst($selectedMedia->orientation) }}</p>
                        @endif
                        <p><span class="font-semibold text-gray-700">Uploaded:</span> {{ $selectedMedia->created_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>

                <flux:separator />

                <div class="text-center">
                    <flux:button variant="danger" icon="trash" wire:click="confirmDelete('{{ $selectedMedia->id }}')">Delete</flux:button>
                </div>
            </div>
        @endif
    </flux:modal>

    {{-- Delete Confirmation Modal --}}
    <flux:modal name="modal-delete-media" class="min-w-[22rem]" :dismissible="false">
        @if ($showDeleteModal)
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Delete Media?</flux:heading>
                    <flux:text class="mt-2">
                        <p>You're about to delete this media.</p>
                        <p>This action cannot be reversed.</p>
                    </flux:text>
                </div>
                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:button wire:click="deleteMedia" type="submit" variant="danger">Delete</flux:button>
                </div>
            </div>
        @endif
    </flux:modal>
</div>