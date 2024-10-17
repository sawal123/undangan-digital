$(document).ready(function () {
    // Event listener untuk form submit
    $("#update-theme").on("submit", function (e) {
        e.preventDefault();  // Mencegah form dari submit standar

        var themeid = $(this).data("themeid");  // Ambil themeid dari form
        var formData = new FormData(this);  // Mengambil form data

        console.log(urlUpdateTheme + "/" + themeid);

        $.ajax({
            url: urlUpdateTheme + "/" + themeid,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),  // Sertakan CSRF token di header
            },
            success: function (response) {
                console.log(response);
                if (response.success) {
                    localStorage.setItem("alertMessage", response.message);
                    localStorage.setItem("alertType", "success");
                    location.reload();
                } else {
                    $("#alert-container").html(
                        '<div class="alert alert-danger">' +
                            response.message +
                            "</div>"
                    );
                }
            },
            error: function (xhr, status, error) {
                $("#alert-container").html(
                    '<div class="alert alert-danger">' +
                        xhr.responseText +
                        "</div>"
                );
            }
        });
    });

    // Cek apakah ada pesan alert di localStorage dan tampilkan
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
        localStorage.removeItem("alertMessage");
        localStorage.removeItem("alertType");
    }

    // Ketika modal ditampilkan, isi data form
   
});
