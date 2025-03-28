$(document).ready(function() {
    // Menggunakan event delegation karena mungkin tombol delete dibuat secara dinamis
    $(document).on('click', '.deleteCategory', function(e) {
        e.preventDefault();
        let url = $(this).data('url'); // Misalnya, ambil URL dari atribut data-url
        let row = $(this).closest('tr'); // Mendapatkan baris terkait tombol
        console.log(url)
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Lakukan penghapusan data dengan AJAX
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content'), // Sertakan CSRF token di header
                    },
                    success: function(response) {
                        // Swal.fire(
                        //     'Deleted!',
                        //     'Your category has been deleted.',
                        //     'success'
                        // );
                        $("#alert-container").html(
                            '<div class="alert alert-success">' +
                                response.message +
                                "</div>"
                        );
                        console.log(response.data)
                        // Hapus baris data dari tabel jika sukses
                        row.remove(); // Menghapus baris
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'There was an error deleting the category.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
