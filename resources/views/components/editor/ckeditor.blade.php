<div>
    <div wire:ignore>
        <textarea id="ckeditor" wire:model="deskripsi" ></textarea>
    </div>

    <script>
        document.addEventListener('livewire:init', function() {
            console.log('editor')
            ClassicEditor
                .create(document.querySelector('#ckeditor'))
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('deskripsi', editor.getData());
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
    

</div>
