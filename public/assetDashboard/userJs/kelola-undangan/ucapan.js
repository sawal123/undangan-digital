document.addEventListener("DOMContentLoaded", function () {
    window.addEventListener("openDelModal", () => {
        const editModal = new bootstrap.Modal(document.getElementById("hapusUcapan"));
        editModal.show();
    });

    window.addEventListener("closeDelModal", () => {
        const editModal = bootstrap.Modal.getInstance(document.getElementById("hapusUcapan"));
        if (editModal) {
            editModal.hide();
        }
    });
});
