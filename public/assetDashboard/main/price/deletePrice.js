$(document).ready(function () {
    $(document).on("click", ".deleteharga", function (e) {
        e.preventDefault();
        let url = $(this).data("delete");
        let row = $(this).closest("tr"); 
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                // Lakukan penghapusan data dengan AJAX
                $.ajax({
                    url: url,
                    type: "DELETE",
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ), // Sertakan CSRF token di header
                    },
                    success: function (response) {
                        $("#alert-container").html(
                            '<div class="alert alert-success">' +
                                response.message +
                                "</div>"
                        );
                        row.remove(); // Menghapus baris
                    },
                    error: function (xhr, status, error) {
                        Swal.fire(
                            "Error!",
                            "There was an error deleting the category.",
                            "error"
                        );
                    },
                });
            }
        });
    });
});
