$("#form-giftpay").on("submit", function (event) {
    event.preventDefault();

    // Create FormData object to handle file upload
    var formData = new FormData(this);

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        url: urlGift,
        method: "POST",
        data: formData,
        contentType: false, // Prevent jQuery from overriding content type
        processData: false, // Prevent jQuery from converting the data
        success: function (response) {
            if (response.success) {
                $("#alert-container").html(
                    '<div class="alert alert-success">' +
                        response.message +
                        "</div>"
                );
                $("#form-data")[0].reset();
                $("#giftMessage").html("");
                $("#iconMessage").html("");
                appendToTable(response.data, response.count);
                $("#giftPayForm").modal("hide");
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
                $("#giftMessage").html("");
                $("#iconMessage").html("");
                if (errors.category) {
                    $("#giftMessage").html(
                        '<small class="text-danger">' +
                            errors.category[0] +
                            "</small>"
                    );
                }
                if (errors.icon) {
                    $("#giftMessage").html(
                        '<small class="text-danger">' +
                            errors.icon[0] +
                            "</small>"
                    );
                }
            }
            console.log(response);
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
                        <img src="/storage/${data.icon}" class="avatar avatar-ex-small rounded-circle shadow" alt="">
                        <span class="ms-2">${data.nama_pay}</span>
                    </div>
                </a>
            </td>
            <td class="text-end p-3 d-flex justify-content-end gap-2">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editCategory">Edit</button>
                
               <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                   
            </td>
        </tr>
    `;
    $("#gift-table tbody").append(newRow); // Tambahkan row baru ke tabel
}
