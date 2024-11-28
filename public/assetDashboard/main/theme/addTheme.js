$("#form-data").on("submit", function (event) {
    event.preventDefault();

    // Create FormData object to handle file upload
    var formData = new FormData(this);

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        url: urlAddTheme,
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
                $("#namaMessage").html("");
                $("#pathMessage").html("");
                $("#thumbnailMessage").html("");
                console.log(response.data);
                // appendToTable(response.data , response.count);
                localStorage.setItem("alertMessage", response.message);
                localStorage.setItem("alertType", "success"); // Menyimpan tipe alert
                location.reload(); // Reload halaman
                $("#themeForm").modal("hide");
                $(document).ready(function() {
                    $("#empty").css({
                        "display": "none"
                    });
                });
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
                $("#namaMessage").html("");
                $("#pathMessage").html("");
                $("#thumbnailMessage").html("");
                if (errors.nama) {
                    $("#namaMessage").html(
                        '<small class="text-danger">' +
                            errors.category[0] +
                            "</small>"
                    );
                }
                if (errors.path) {
                    $("#pathMessage").html(
                        '<small class="text-danger">' +
                            errors.category[0] +
                            "</small>"
                    );
                }
                if (errors.thumbnail) {
                    $("#thumbnailMessage").html(
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

// function appendToTable(data, count) {
//     var newRow = `
//         <tr>
//             <th class="p-3">${count}</th>
//             <td class="p-3">
//                 <a href="#" class="text-primary">
//                     <div class="d-flex align-items-center">
//                         <img src="/storage/${data.thumbnail}" class="avatar avatar-ex-small rounded-circle shadow" alt="">
//                         <span class="ms-2">${data.nama}</span>
//                     </div>
//                 </a>
//             </td>
//             <td>${data.category.category}</td>
//             <td>${data.path}</td>
//             <td class="text-end p-3 d-flex justify-content-end gap-2">
//                 <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#edittheme${data.id}">Edit</button>
//                 <button type="button" class="btn btn-sm btn-danger deletetheme" data-url="/admin/categories/destroy/${data.id}">Delete</button>
//             </td>
//         </tr>
//     `;

//     $("#category-table tbody").append(newRow);
// }
