@props(['blockId', 'url', 'caption'])

<div
    class="bg-gray-50 p-4 border border-gray-200 rounded-lg shadow-sm mb-4"
    x-data="{ url: @entangle($attributes->wire('model.url')), caption: @entangle($attributes->wire('model.caption')) }"
>
    <div class="mb-4">
        <label for="image-block-url-{{ $blockId }}" class="block text-sm font-medium text-gray-700 mb-2">URL Gambar:</label>
        <input
            type="text"
            id="image-block-url-{{ $blockId }}"
            x-model="url"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            placeholder="Contoh: /storage/uploads/gambar.jpg atau https://example.com/gambar.png"
        >
    </div>

    <div class="mb-4">
        <label for="image-block-caption-{{ $blockId }}" class="block text-sm font-medium text-gray-700 mb-2">Caption Gambar (Opsional):</label>
        <input
            type="text"
            id="image-block-caption-{{ $blockId }}"
            x-model="caption"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            placeholder="Deskripsi singkat gambar"
        >
    </div>

    {{-- Pratinjau Gambar --}}
    <div x-show="url" class="mt-4 border border-gray-300 rounded-md overflow-hidden">
        <img :src="url" alt="Pratinjau Gambar" class="block w-full h-auto object-cover">
        <p x-show="caption" class="text-center text-sm text-gray-500 p-2" x-text="caption"></p>
    </div>
</div>