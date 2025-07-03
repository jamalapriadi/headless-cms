<div>
    <x-slot name="title">
        Edit Post
    </x-slot>

    <div class="relative mb-6 w-full">
        <flux:heading size="xl" class="mb-6 mt-3">Posts</flux:heading>
        <flux:subheading size="lg" class="mb-6">Edit the post details below. Make changes as needed and click "Save" to update the post.</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @if(session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <form wire:submit.prevent="store" class="">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Main Content -->
            <div class="flex-1 space-y-6">
                <!-- Title -->
                <flux:input label="Title" wire:model="title" placeholder="Please input the title..." />

                <flux:textarea label="Short Description" wire:model="short_description" placeholder="Please input the short description.." />

                <!-- Content -->
                <livewire:editor-component
                    editor-id="my-editor" 
                    :content="$content ?? ''" 
                    wire:model="content"
                    plugins="lists link image table code" 
                    toolbar="undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code" />

                <flux:error name="content" />

                
            </div>
            <!-- Sidebar -->
            <div class="w-full md:w-80 space-y-6">
                <flux:callout style="border-radius:5px" variant="secondary">
                    <flux:callout.heading>
                        Status
                    </flux:callout.heading>

                    <x-slot name="actions">
                        <flux:select wire:model="status" wire:change="changeStatus($event.target.value)">
                            <flux:select.option value="draft">Draft</flux:select.option>
                            <flux:select.option value="published">Publish</flux:select.option>
                        </flux:select>
                    </x-slot>
                </flux:callout>
                
                @if($status === 'published')
                    <flux:callout style="border-radius:5px" variant="secondary">
                        <flux:callout.heading>
                            Publish Date
                        </flux:callout.heading>

                        <x-slot name="actions">
                            <flux:input type="datetime-local" wire:model="published_at" />
                        </x-slot>
                    </flux:callout>
                @endif

                <flux:callout style="border-radius:5px" variant="secondary">
                    <flux:callout.heading>
                        Featured Image
                    </flux:callout.heading>

                    <x-slot name="actions">

                        @if($image)
                            <div class="mt-2 flex flex-col items-start space-y-2">
                                <img src="{{ asset('storage/'.$image) }}" class="object-cover rounded-md border border-gray-300">

                                <flux:button size="sm" icon="trash" wire:click="removeFile()" variant="danger">Delete</flux:button>
                            </div>
                        @else
                            <livewire:file-upload 
                                class="mt-4"
                                :multiple="false"
                                label="Set Featured Image"
                                :rules="['required', 'image', 'max:2048']"
                                modelName="featured_image"
                            />
                            
                            @error('image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        @endif
                    </x-slot>
                </flux:callout>

                <flux:callout style="border-radius:5px" variant="secondary">
                    <flux:callout.heading>
                        Categories
                    </flux:callout.heading>

                    <x-slot name="actions">
                        <flux:checkbox.group wire:model="categories">
                            @foreach ($allCategories as $category)
                                <flux:checkbox 
                                    label="{{ $category->name }}" 
                                    value="{{ $category->id }}" 
                                    :checked="in_array($category->id, $categories)" 
                                />    
                            @endforeach
                        </flux:checkbox.group>
                    </x-slot>
                </flux:callout>
            </div>
        </div>

        <flux:separator class="mt-6"/>
        <div class="mt-4 flex justify-between items-center">
            <flux:link href="{{ route('dashboard.posts') }}" variant="ghost">Back</flux:link>
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</div>
