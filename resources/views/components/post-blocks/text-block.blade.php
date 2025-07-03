<div
    class="mb-4"
    x-data="{ content: @entangle($attributes->wire('model')) }" {{-- Mengikat langsung ke properti Livewire --}}
>
    <flux:textarea
        id="text-block-{{ $blockId }}"
        x-model="content"
        placeholder="Please enter your text here..."
    />
</div>