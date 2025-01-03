<div>
    <script src="https://cdn.tiny.cloud/1/8ajhj6553pjvtqe51q18yw99liopcb5d99ogcqnsrfj29i3y/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        document.addEventListener('tiny', function() {
            console.log('Initializing TinyMCE');
            tinymce.remove();
            console.log('Yeay');
            setTimeout(function() {
                tinymce.init({
                    selector: '#textarea',
                    setup: function(editor) {

                        Livewire.on('syncTinyMCE', (content) => {
                            var content = tinymce.activeEditor.setContent(content || '');
                            Livewire.dispatch('updateDeskripsi', {
                                content: content
                            });
                        });
                    },
                    plugins: [
                        // Core editing features
                        'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image',
                        'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks',
                        'wordcount',
                        // Your account includes a free trial of TinyMCE premium features
                        // Try the most popular premium features until Jan 16, 2025:
                        'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter',
                        'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen',
                        'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai',
                        'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags',
                        'autocorrect', 'typography', 'inlinecss', 'markdown', 'importword',
                        'exportword', 'exportpdf'
                    ],
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                    tinycomments_mode: 'embedded',
                    tinycomments_author: 'Author name',
                    mergetags_list: [{
                            value: 'First.Name',
                            title: 'First Name'
                        },
                        {
                            value: 'Email',
                            title: 'Email'
                        },
                    ],
                    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject(
                        'See docs to implement AI Assistant')),
                });
            }, 100); // Menunggu sedikit sebelum menginisialisasi
        });
    </script>
</div>
