$(document).ready(function () {
    $(".update-category").on("click", function (e) {
        e.preventDefault();

        var categoryId = $(this).data("id");
        var form = $("#dataCategory" + categoryId)[0];

        var formData = new FormData(form);
        console.log(urlCategory + "/" + categoryId);
        console.log(form);

        $.ajax({
            url: urlCategory + "/" + categoryId,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // Sertakan CSRF token di header
            },
            success: function (response) {
                if (response.success) {
                    // Simpan pesan ke localStorage
                    localStorage.setItem("alertMessage", response.message);
                    localStorage.setItem("alertType", "success"); // Menyimpan tipe alert
                    location.reload(); // Reload halaman
                } else
                    $("#alert-container").html(
                        '<div class="alert alert-danger">' +
                            response.message +
                            "</div>"
                    );
            },
            error: function (xhr, status, error) {
                // Tangani error
                $("#alert-container").html(
                    '<div class="alert alert-danger">' +
                        xhr.responseText +
                        "</div>"
                );
                // alert('Error updating category: ' + xhr.responseText);
            },
        });
    });
});

$(document).ready(function () {
    // Cek apakah ada pesan alert di localStorage
    var alertMessage = localStorage.getItem('alertMessage');
    var alertType = localStorage.getItem('alertType');

    if (alertMessage) {
        $("#alert-container").html(
            '<div class="alert alert-' + alertType + '">' +
                alertMessage +
                "</div>"
        );
        // Hapus pesan dari localStorage setelah ditampilkan
        localStorage.removeItem('alertMessage');
        localStorage.removeItem('alertType');
    }

    // ... kode lain di sini
});
