<div>
    <div wire:ignore>
        <textarea wire:model.live="content" id="{{ $editorId }}"></textarea>
    </div>

    @push('scripts')
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            tinymce.init({
                selector: '#{{ $editorId }}',
                license_key: 'gpl',
                plugins: '{{ $plugins }}',
                toolbar: '{{ $toolbar }}',
                setup: (editor) => {
                    editor.on('input change keyup', () => {
                        const content = editor.getContent();
                        @this.set('content', content);
                        console.log('TinyMCE content updated:', content);
                    });
                }
            });

            Livewire.on('component.dehydrated', () => {
                tinymce.remove('#{{ $editorId }}');
            });
        });
    </script>
    @endpush
</div>