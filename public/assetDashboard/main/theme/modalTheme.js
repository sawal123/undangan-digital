$(document).on("show.bs.modal", "#editTheme", function (e) {
    var button = $(e.relatedTarget);
    var id = button.data("id");
    var nama = button.data("nama");
    var path = button.data("path");
    var demo = button.data("demo");
    var thumbnail = button.data("thumbnail");
    var category = button.data("category");

    $("#nama").val(nama);
    $("#path").val(path);
    $("#demo").val(demo);
    $("#thumbnail").attr("src", thumbnail);
    $("#update-theme").attr("data-themeid", id);

    // Pilih option yang sesuai dengan category_id
    $("#category").val(null).trigger("change"); // Reset dropdown category
    $("#category option").each(function () {
        if ($(this).val() == category) {
            $(this).prop("selected", true);
        }
    });
});