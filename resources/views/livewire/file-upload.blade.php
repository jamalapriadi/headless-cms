<div x-data="{}"
     x-on:open-file-dialog.window="if ($refs.fileUploadInput) $refs.fileUploadInput.click()">
    {{-- Trigger area (button-like div) --}}

    @if($showImage == false)
        <div class="w-full" onclick="document.getElementById('{{ $modelName ? $modelName . '-file-input' : 'file-input' }}').click()">
            <div class="card border-dashed border-2 px-16 p-5 w-full cursor-pointer flex items-center justify-center text-center p-5">
                <flux:icon.photo /> &nbsp;
                {{ $label }}
            </div>
        </div>
    @endif

    {{-- The actual file input --}}
    {{-- Pastikan x-ref="fileUploadInput" selalu ada di input file yang benar --}}
    @if($multiple)
        <input type="file"
               x-ref="fileUploadInput" {{-- Pastikan ini ada di elemen yang aktif --}}
               class="hidden"
               id="{{ $modelName ? $modelName . '-file-input' : 'file-input' }}"
               wire:model="files"
               multiple />
    @else
        <input type="file"
               x-ref="fileUploadInput" {{-- Pastikan ini ada di elemen yang aktif --}}
               class="hidden"
               id="{{ $modelName ? $modelName . '-file-input' : 'file-input' }}"
               wire:model="file" />
    @endif

    {{-- Error messages --}}
    @error('file') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    @error('files') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    @error('files.*') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror

    {{-- Preview section (unchanged from your original) --}}
    @if ($showImage)
        {{-- Pratinjau untuk single file --}}
        @if ($file && $file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile && in_array($file->extension(), ['jpg', 'jpeg', 'png', 'gif']))
            <div class="mt-2 flex flex-col items-start space-y-2">
                <img src="{{ asset('storage/'.$uploadedFile['path']) }}" class="object-cover rounded-md border border-gray-300">
                <flux:button size="sm" icon="trash" wire:click="removeFile('{{$uploadedFile['id']}}')" variant="danger">Delete</flux:button>
            </div>
        @endif

        {{-- Pratinjau untuk multiple files --}}
        @if ($multiple && count($files) > 0)
            <div class="mt-2">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 mt-1">
                    @foreach ($files as $tempFile)
                        @if ($tempFile instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile && in_array($tempFile->extension(), ['jpg', 'jpeg', 'png', 'gif']))
                            <img src="{{ $tempFile->temporaryUrl() }}" class="w-24 h-24 object-cover rounded-md border border-gray-300">
                        @else
                            <div class="w-24 h-24 flex items-center justify-center bg-gray-100 rounded-md border border-gray-300 text-xs text-gray-500">
                                {{ $tempFile->getClientOriginalName() }}
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    @endif
</div>