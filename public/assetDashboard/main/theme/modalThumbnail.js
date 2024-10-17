$(document).ready(function () {
    // Ketika modal dibuka, ambil data src gambar
    $('#zoomImageModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Tombol yang diklik
        var imageSrc = button.data('img-src'); // Ambil src gambar dari data-img-src

        // Setel gambar pada modal agar bisa di-zoom
        var modal = $(this);
        modal.find('#zoomedImage').attr('src', imageSrc);
    });
});
