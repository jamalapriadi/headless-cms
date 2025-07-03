<script src="{{asset('tinymce/tinymce.min.js')}}"></script>
<script>
    tinymce.init({
        selector: 'textarea#editor', // Replace this CSS selector to match the placeholder element for TinyMCE
        plugins: 'code table lists',
        toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
    });
</script>
