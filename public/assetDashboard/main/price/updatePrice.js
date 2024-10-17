$("#update-price").on("submit", function (event) {
    event.preventDefault();

    // Create FormData object to handle file upload
    var formUpdate = new FormData(this);
    var deskArray = formUpdate.set(
        "deskripsiUp",
        JSON.stringify(tag.value.map((tag) => tag.value))
    );

    // console.log(tag.value.map((tag) => tag.value));
    $.ajax({
        url: updatePrice,
        method: "POST",
        data: formUpdate,
        contentType: false, // Prevent jQuery from overriding content type
        processData: false, // Prevent jQuery from converting the data
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // Sertakan CSRF token di header
        },
        success: function (response) {
            if (response.success) {
                console.log(response.data);
                if (response.success) {
                    // Simpan pesan ke localStorage
                    localStorage.setItem("alertMessage", response.message);
                    localStorage.setItem("alertType", "success"); // Menyimpan tipe alert
                    location.reload();
                } else {
                    $("#alert-container").html(
                        '<div class="alert alert-danger">' +
                            response.message +
                            "</div>"
                    );
                }
                $("#form-price")[0].reset();
                $("#namaPaketMessage").html("");
                $("#priceMessage").html("");
                $("#deskripsiMessage").html("");
                $("#keteranganMessage").html("");
            } else {
                $("#alert-container").html(
                    '<div class="alert alert-danger">' +
                        response.message +
                        "</div>"
                );
            }
        },
        error: function (response) {
            if (response.status === 422) {
                // Handle validation errors
                let errors = response.responseJSON.errors;
                $("#namaPaketMessage").html("");
                $("#priceMessage").html("");
                $("#deskripsiMessage").html("");
                $("#keteranganMessage").html("");
                if (errors.namaPaket) {
                    $("#namaPaketMessage").html(
                        '<small class="text-danger">' +
                            errors.namaPaket[0] +
                            "</small>"
                    );
                }
                if (errors.price) {
                    $("#priceMessage").html(
                        '<small class="text-danger">' +
                            errors.price[0] +
                            "</small>"
                    );
                }
                if (errors.deskripsi) {
                    $("#deskripsiMessage").html(
                        '<small class="text-danger">' +
                            errors.deskripsi[0] +
                            "</small>"
                    );
                }
                if (errors.diskon) {
                    $("#diskonMessage").html(
                        '<small class="text-danger">' +
                            errors.diskon[0] +
                            "</small>"
                    );
                }
                if (errors.keterangan) {
                    $("#keteranganMessage").html(
                        '<small class="text-danger">' +
                            errors.keterangan[0] +
                            "</small>"
                    );
                }
            }
            console.log(response);
            console.log(response.status);
        },
    });
});

$(document).ready(function () {
    // Cek apakah ada pesan alert di localStorage
    var alertMessage = localStorage.getItem("alertMessage");
    var alertType = localStorage.getItem("alertType");

    if (alertMessage) {
        $("#alert-container").html(
            '<div class="alert alert-' +
                alertType +
                '">' +
                alertMessage +
                "</div>"
        );
        // Hapus pesan dari localStorage setelah ditampilkan
        localStorage.removeItem("alertMessage");
        localStorage.removeItem("alertType");
    }

    // ... kode lain di sini
});
