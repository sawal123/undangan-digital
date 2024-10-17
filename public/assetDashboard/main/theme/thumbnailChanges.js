$(document).ready(function () {
    // Ketika input file thumbnail diubah
    $("#thumbnail-input").on("change", function (e) {
        var input = this;

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                // Menampilkan gambar yang dipilih ke dalam tag <img>
                $("#thumbnail").attr("src", e.target.result);
            };

            reader.readAsDataURL(input.files[0]); // Membaca file gambar sebagai URL data
        }
    });

    // Menangani ketika modal edit dibuka
    $(document).on("show.bs.modal", "#editTheme", function (e) {
        var button = $(e.relatedTarget);

        // Ambil data dari atribut data- pada tombol yang diklik
        var thumbnail = button.data("thumbnail");

        // Mengisi src pada elemen img thumbnail
        $("#thumbnail").attr("src", thumbnail);
    });
});
