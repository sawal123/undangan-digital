$(document).ready(function() {
    // Menggunakan event delegation karena mungkin tombol delete dibuat secara dinamis
    $(document).on('click', '.deleteGiftPay', function(e) {
        e.preventDefault();
        let del = $(this).data('delete'); // Misalnya, ambil URL dari atribut data-url
        let row = $(this).closest('tr'); // Mendapatkan baris terkait tombol
        console.log(del)
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
                    url: del,
                    type: 'DELETE',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content'), // Sertakan CSRF token di header
                    },
                    success: function(response) {
                        $("#alert-container").html(
                            '<div class="alert alert-success">' +
                                response.message +
                                "</div>"
                        );
                        console.log(response)
                        // Hapus baris data dari tabel jika sukses
                        row.remove(); // Menghapus baris
                    },
                    error: function(xhr, status, error) {
                        console.log(status)
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
