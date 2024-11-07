document.addEventListener("DOMContentLoaded", function () {
    const removeBackdrop = () => {
        const backdrop = document.querySelector(".modal-backdrop");
        if (backdrop) {
            backdrop.remove();
        }
        document.body.classList.remove("modal-open"); // Menghilangkan class `modal-open` dari body
        document.body.style.overflow = "auto";
    };
    window.addEventListener("close-modal", () => {
        const addModalElement = document.getElementById("AddPoto");
        const addModalInstance = bootstrap.Modal.getInstance(addModalElement);
        if (addModalInstance) {
            addModalInstance.hide();
        }

        removeBackdrop();
        const previewContainer = document.getElementById("preview-container");
        const previewImage = document.getElementById("preview-image");
        previewImage.src = "";
        previewContainer.style.display = "none";
    });

    window.addEventListener("openModalPoto", () => {
        const editModal = new bootstrap.Modal(
            document.getElementById("AddPoto")
        );
        editModal.show();
    });
    window.addEventListener("openModalVideo", () => {
        const editModal = new bootstrap.Modal(
            document.getElementById("AddVideo")
        );
        editModal.show();
    });

    window.addEventListener("openDeleteModal", () => {
        const editModal = new bootstrap.Modal(
            document.getElementById("hapusGalery")
        );
        editModal.show();
    });
    window.addEventListener("close-hapus", () => {
        const editModalElement = document.getElementById("hapusAcara");
        const editModalInstance = bootstrap.Modal.getInstance(editModalElement);
        if (editModalInstance) {
            editModalInstance.hide();
        }
        removeBackdrop();
    });
});

function previewImage(event) {
    const previewContainer = document.getElementById("preview-container");
    const previewImage = document.getElementById("preview-image");

    // Tampilkan elemen preview container
    previewContainer.style.display = "block";

    // Ambil file dari input
    const file = event.target.files[0];

    // Cek jika file ada dan merupakan gambar
    if (file && file.type.startsWith("image/")) {
        // Buat URL sementara untuk gambar dan tampilkan di img tag
        previewImage.src = URL.createObjectURL(file);
    }
    // openDeleteModal
}

document.addEventListener("DOMContentLoaded", function () {
    // Close the modal after the deletion
    window.livewire.on("close-modal", () => {
        $("#deleteModal").modal("hide");
    });

    // Confirm delete button click event
    document
        .getElementById("confirmDelete")
        .addEventListener("click", function () {
            window.livewire.emit("delete"); // Call the delete method
        });
});

document.addEventListener("DOMContentLoaded", function () {
    // Event listener untuk semua link preview
    document.querySelectorAll(".lightbox").forEach((item) => {
        item.addEventListener("click", function (event) {
            event.preventDefault();
            const mediaUrl = String(this.getAttribute("href"));
            const isImage = mediaUrl
                ? mediaUrl.toLowerCase().match(/(jpeg|jpg|svg|png|webp)/)
                : null;

            let previewContent = "";
            if (isImage) {
                previewContent = `<img src="${mediaUrl}" class="img-fluid w-100" alt="Preview Image">`;
            } else {
                previewContent = `<iframe src="${mediaUrl}" frameborder="0" allowfullscreen class="w-100" style="height: 100vh;"></iframe>`;
            }
            document.getElementById("previewContent").innerHTML =
                previewContent;
            new bootstrap.Modal(document.getElementById("previewModal")).show();
        });
    });
});
