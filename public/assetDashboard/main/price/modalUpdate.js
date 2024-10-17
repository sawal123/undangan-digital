$(document).ready(function () {
    // Inisialisasi Tagify hanya sekali
    

    $(document).on("show.bs.modal", "#editharga", function (e) {
        // Mendapatkan tombol yang memicu modal
        var button = $(e.relatedTarget);

        // Ambil data dari atribut data- pada tombol yang diklik
        var id = button.data("id");
        var name = button.data("name");
        var price = button.data("price");
        var type = button.data("type");
        var diskon = button.data("diskon");
        var keterangan = button.data("keterangan");
        var deskripsi = button.data("deskripsi");
        // Isi data ke dalam form modal
        $("#id").val(id);
        $("#namaPaket").val(name);
        $("#price").val(price);
        $("#diskon").val(diskon);
        $("#keterangan").val(keterangan);
        // Set radio button sesuai dengan type (rupiah atau persen)
        if (type === "rupiah") {
            $("#flexRadioDefault1").prop("checked", true);
        } else if (type === "persen") {
            $("#flexRadioDefault2").prop("checked", true);
        }
        tag.removeAllTags();
        tag.addTags(deskripsi);
    });
});
