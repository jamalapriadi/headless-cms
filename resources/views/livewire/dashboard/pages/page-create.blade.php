<div>
    <x-slot name="title">
        Create new Page
    </x-slot>

    <div class="relative mb-6 w-full">
        <flux:heading size="xl" class="mb-6">Pages</flux:heading>
        <flux:subheading size="lg" class="mb-6">Create new Page</flux:subheading>
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

                <!-- Content -->
                <flux:field>
                    <flux:label>Content</flux:label>

                    <livewire:editor-component
                        wire:key="editor-page-create"
                        editor-id="editor-page-create" 
                        :content="$content ?? ''" 
                        wire:model="content"
                        plugins="lists link image table code" 
                        toolbar="undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code" />

                    <flux:error name="content" />
                </flux:field>

                
            </div>
            <!-- Sidebar -->
            <div class="w-full md:w-80 space-y-6">
                <flux:callout style="border-radius:5px" variant="secondary">
                    <flux:callout.heading>
                        Status
                    </flux:callout.heading>

                    <x-slot name="actions">
                        <flux:select wire:model="status">
                            <flux:select.option value="draft">Draft</flux:select.option>
                            <flux:select.option value="published">Publish</flux:select.option>
                        </flux:select>
                    </x-slot>
                </flux:callout>
            </div>
        </div>

        <flux:separator class="mt-6"/>
        <div class="mt-4 flex justify-between items-center">
            <flux:link href="{{ route('dashboard.pages') }}" variant="ghost">Back</flux:link>
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</div>
