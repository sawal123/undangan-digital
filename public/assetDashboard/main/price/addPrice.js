$("#form-price").on("submit", function (event) {
    event.preventDefault();

    // Create FormData object to handle file upload
    var formData = new FormData(this);

    var deskripsiArray = tagify.value.map((tag) => tag.value); // Ambil nilai tag
    formData.set("deskripsi", JSON.stringify(deskripsiArray)); // Kirim sebagai string J

    console.log(deskripsiArray);
    $.ajax({
        url: urlPrice,
        method: "POST",
        data: formData,
        contentType: false, // Prevent jQuery from overriding content type
        processData: false, // Prevent jQuery from converting the data
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // Sertakan CSRF token di header
        },
        success: function (response) {
            if (response.success) {
                $("#alert-container").html(
                    '<div class="alert alert-success">' +
                        response.message +
                        "</div>"
                );
                $("#form-price")[0].reset();
                $("#namaPaketMessage").html("");
                $("#priceMessage").html("");
                $("#deskripsiMessage").html("");
                $("#keteranganMessage").html("");
                appendToTable(response.data, response.count);
                $("#priceForm").modal("hide");
                console.log("Modal closed");
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
function appendToTable(data, count) {
    var newRow = `
                <tr>
            <th class="p-3">${count}</th>
            <td class="p-3">
                <a href="#" class="text-primary">
                    <div class="d-flex align-items-center">
                        <img src="/storage/${data.nama_packet}"
                            class="avatar avatar-ex-small rounded-circle shadow" alt="">
                        <span class="ms-2">${data.category}</span>
                    </div>
                </a>
            </td>
            <td class="text-end p-3 d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-sm btn-primary">Edit</button>
                <form id="categoryDelete">
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>

        `;
    $("#category-table tbody").append(newRow); // Tambahkan row baru ke tabel
}
