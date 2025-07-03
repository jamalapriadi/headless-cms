<div>
    <x-slot name="title">
        Post {{  $post->title }}
    </x-slot>

    {{-- <div class="relative mb-6 w-full">
        <flux:heading size="xl" class="mb-6">Posts</flux:heading>
        <flux:subheading size="lg" class="mb-6">Create Translate for post : {{$post->title }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div> --}}
    
    <table class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg overflow-hidden">
        <tbody class="bg-white divide-y divide-gray-200">
            @if (session()->has('success'))
                <tr>
                    <td colspan="{{ 1 + count($languages) }}" class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800 pt-10 pb-10">
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    </td>
                </tr>
            @endif

            <tr>
                <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800 pt-10 pb-10" colspan="{{ count($languages)+1 }}">
                    <span class="flex items-center space-x-2">
                        <span class="font-bold text-blue-700">TRANSLATION # {{$post->title}}</span><br>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800 pt-10 pb-10" colspan="{{ count($languages)+1 }}">
                    <span class="flex items-center space-x-2">
                        <span class="font-bold text-blue-700">Title:</span><br>
                    </span>
                    <div class="mt-3">
                        <span class="italic text-gray-900">{{ $post->title }}</span>
                    </div>
                </td>
            </tr>
            @foreach ($languages as $key=>$language)
                <tr class="bg-gray-100">
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700" width="2% !important"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700" width="5% !important">{{ $language->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                        <flux:input 
                            placeholder="Input title for language {{ $language->name }}" 
                            wire:model="postTranslations.{{ $language->locale }}.title"
                            wire:change="inputTitleLanguage($event.target.value,'{{ $language->locale }}')" />
                    </td>
                </tr>
            @endforeach

            <tr>
                <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800 pt-10 pb-10" colspan="{{ count($languages)+1 }}">
                    <span class="flex items-center space-x-2">
                        <span class="font-bold text-blue-700">Short Description:</span><br>
                    </span>
                    <div class="mt-3">
                        <span class="italic text-gray-900">{{ $post->short_description }}</span>
                    </div>
                </td>
            </tr>
            @foreach ($languages as $key=>$language)
                <tr class="bg-gray-100">
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700" width="2% !important"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700" width="5% !important">{{ $language->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                        <flux:textarea 
                            placeholder="Input short description for language {{ $language->name }}"  
                            wire:model="postTranslations.{{ $language->locale }}.short_description"
                            wire:change="inputShortDescriptionLanguage($event.target.value,'{{ $language->locale }}')" />
                    </td>
                </tr>
            @endforeach

            <tr>
                <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800 pt-10 pb-10" colspan="{{ count($languages)+1 }}">
                    <span class="flex items-center space-x-2">
                        <span class="font-bold text-blue-700">Content:</span><br>
                    </span>
                    <div class="mt-3">
                        <span class="italic text-gray-900">{!! \Illuminate\Support\Str::limit(strip_tags($post->content), 300) !!}</span>
                    </div>
                </td>
            </tr>
            @foreach ($languages as $key=>$language)
                <tr class="bg-gray-100">
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700" width="2% !important"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700" width="5% !important">{{ $language->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                        <div>
                            <livewire:editor-component
                                wire:key="editor-{{ $language->locale }}"
                                editor-id="my-editor-{{ $language->locale }}" 
                                :content="$postTranslations[$language->locale]['content'] ?? ''"
                                wire:model="postTranslations.{{ $language->locale }}.content"
                                plugins="lists link image table code" 
                                toolbar="undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code" />
                        </div>
                    </td>
                </tr>
            @endforeach
            
            
        </tbody>
        <tfoot>
            @if (session()->has('success'))
                <tr>
                    <td colspan="{{ 1 + count($languages) }}" class="px-6 py-4 bg-gray-50 pt-10 pb-10">
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    </td>
                </tr>
            @endif

            <tr>
                <td colspan="{{ 1 + count($languages) }}" class="px-6 py-4 bg-gray-50 text-right pt-10 pb-10">
                    <flux:button variant="primary" x-on:click="$flux.modal('confirmation-update-translation').show()" color="primary" type="submit">
                        Update Translations
                    </flux:button>
                </td>
            </tr>
        </tfoot>
    </table>

    <flux:modal name="confirmation-update-translation" class="min-w-[22rem]" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">
                    Update Translation
                </flux:heading>
                <flux:text class="mt-2">
                    <p>Are you sure you want to update the translations for this post? Your changes will overwrite the existing translations and cannot be undone.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="danger" wire:click="updateTranslations()">Yes</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
