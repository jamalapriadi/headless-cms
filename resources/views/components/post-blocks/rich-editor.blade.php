<div>
    <div x-data="setupEditor(
    $wire.entangle('{{ $attributes->wire('model')->value() }}')
)" x-init="() => init($refs.editor)" wire:ignore {{ $attributes->whereDoesntStartWith('wire:model') }}>
    <div class="flex w-full border-b divide-x  dark:bg-slate-900 divide-slate-700 border-slate-700 rounded-t-md">
        <button type="button" class="flex justify-center p-2 transition dark:hover:bg-slate-700 w-14 rounded-tl-md"
            @click="toggleBold();">
            <i class="w-3 h-auto">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-bold"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 5h6a3.5 3.5 0 0 1 0 7h-6z" /><path d="M13 12h1a3.5 3.5 0 0 1 0 7h-7v-7" /></svg>
            </i>
        </button>
        <button type="button" class="flex justify-center p-2 transition dark:hover:bg-slate-700 w-14 dark:bg-slate-900"
            @click="toggleItalic()">
            {{-- <x-svg class="w-5 h-auto" svg="italic" /> --}}
            <i class="w-5 h-auto">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-italic"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 5l6 0" /><path d="M7 19l6 0" /><path d="M14 5l-4 14" /></svg>
            </i>
        </button>
        <button type="button" class="flex justify-center p-2 transition dark:hover:bg-slate-700 w-14 dark:bg-slate-900"
            @click="toggleH2()">
            <i class="w-5 h-auto">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-h-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 12a2 2 0 1 1 4 0c0 .591 -.417 1.318 -.816 1.858l-3.184 4.143l4 0" /><path d="M4 6v12" /><path d="M12 6v12" /><path d="M11 18h2" /><path d="M3 18h2" /><path d="M4 12h8" /><path d="M3 6h2" /><path d="M11 6h2" /></svg>
            </i>
        </button>
        <button type="button" class="flex justify-center p-2 transition dark:hover:bg-slate-700 w-14 dark:bg-slate-900"
            @click="toggleH3()">
            <i class="w-5 h-auto">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-h-3"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 14a2 2 0 1 0 -2 -2" /><path d="M17 16a2 2 0 1 0 2 -2" /><path d="M4 6v12" /><path d="M12 6v12" /><path d="M11 18h2" /><path d="M3 18h2" /><path d="M4 12h8" /><path d="M3 6h2" /><path d="M11 6h2" /></svg>
            </i>
        </button>
        <button type="button" class="flex justify-center p-2 transition dark:hover:bg-slate-700 w-14 dark:bg-slate-900"
            @click="toggleH4()">
            <i class="w-5 h-auto">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-h-4"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 18v-8l-4 6h5" /><path d="M4 6v12" /><path d="M12 6v12" /><path d="M11 18h2" /><path d="M3 18h2" /><path d="M4 12h8" /><path d="M3 6h2" /><path d="M11 6h2" /></svg>
            </i>
        </button>
        <button type="button" class="flex justify-center p-2 transition dark:hover:bg-slate-700 w-14 dark:bg-slate-900"
            @click="toggleOrderedList()">
            <i class="w-5 h-auto">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-numbers"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 6h9" /><path d="M11 12h9" /><path d="M12 18h8" /><path d="M4 16a2 2 0 1 1 4 0c0 .591 -.5 1 -1 1.5l-3 2.5h4" /><path d="M6 10v-6l-2 2" /></svg>
            </i>
        </button>
        <button type="button" class="flex justify-center p-2 transition dark:hover:bg-slate-700 w-14 dark:bg-slate-900"
            @click="toggleBulletList()">
            <i class="w-5 h-auto">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l11 0" /><path d="M9 12l11 0" /><path d="M9 18l11 0" /><path d="M5 6l0 .01" /><path d="M5 12l0 .01" /><path d="M5 18l0 .01" /></svg>
            </i>
        </button>
    </div>
    <div class="border-gray-300 shadow-sm rounded-b-md dark:border-gray-700 dark:bg-slate-900 dark:text-gray-300"
        x-ref="editor">
    </div>
</div>


</div>