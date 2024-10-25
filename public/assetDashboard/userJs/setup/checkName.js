$(document).ready(function () {
    // Fungsi untuk mengecek status input dan mengatur tombol
    function checkInputs() {
        var title = $("#title").val().trim();
        var name = $("#basic-url").val().trim();

        // Aktifkan tombol jika kedua input tidak kosong
        if (title !== "" && name !== "") {
            $("#next").prop("disabled", false);
        } else {
            $("#next").prop("disabled", true);
        }
    }

    // Event listener untuk #title dan #basic-url
    $("#title, #basic-url").on("input", function () {
        checkInputs(); // Panggil fungsi pengecekan setiap kali input berubah
    });

    // Event listener khusus untuk #basic-url untuk validasi nama
    $("#basic-url").on("input", function () {
        var name = $(this).val().trim();

        if (name === "") {
            // Kosongkan pesan validasi jika input kosong
            $("#nameValidationMessage").html("");
            return; // Hentikan eksekusi AJAX jika nama kosong
        }

        // Jalankan AJAX jika input nama tidak kosong
        $.ajax({
            url: checkNameUrl,
            method: "POST",
            data: { name: name },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content'), // Sertakan CSRF token di header
            },
            success: function (response) {
                if (response.success) {
                    $("#nameValidationMessage").html(
                        '<small class="text-success">' + response.message + '</small>'
                    );
                } else {
                    $("#nameValidationMessage").html(
                        '<small class="text-danger">' + response.message + '</small>'
                    );
                }
            },
            error: function (response) {
                console.log(response);
            }
        });
    });
});
