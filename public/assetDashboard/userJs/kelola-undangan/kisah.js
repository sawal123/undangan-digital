// function previewImage(event, itemId) {
//     const file = event.target.files[0];
//     if (file) {
//         const reader = new FileReader();
//         reader.onload = function(e) {
//             const previewElement = document.getElementById(`imagePreview-${itemId}`);
//             previewElement.src = e.target.result;
//         };
//         reader.readAsDataURL(file);
//     }
// }

// function previewImage(event, itemId) {
//     const file = event.target.files[0];
//     console.log(file)
//     if (file) {
//         const reader = new FileReader();
//         reader.onload = function(e) {
//             const previewElement = document.getElementById(`imagePreview-${itemId}`);
//             console.log(previewElement)
//             previewElement.src = e.target.result;
//         };
//         reader.readAsDataURL(file);
//     }
// }

document.addEventListener('triggerFileInput', event => {
    const itemId = event.detail.itemId;
    const fileInput = document.getElementById(`fileInput-${itemId}`);
    if (fileInput) {
        fileInput.click(); // Trigger the file input dialog
    }
});

function previewImage(event, itemId) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewElement = document.getElementById(`imagePreview-${itemId}`);
            if (previewElement) {
                previewElement.src = e.target.result; // Set the preview image source
            }
        };
        reader.readAsDataURL(file); // Read the file as Data URL
    }
}



window.addEventListener("AddKisah", () => {
    const editModal = new bootstrap.Modal(document.getElementById("AddKisah"));
    editModal.show();
});
window.addEventListener("closeAddKisah", () => {
    const editModal = bootstrap.Modal.getInstance(
        document.getElementById("AddKisah")
    );
    if (editModal) {
        editModal.hide();
    }
    const backdrop = document.querySelector(".modal-backdrop");
    if (backdrop) {
        backdrop.remove();
    }
    document.body.classList.remove("modal-open");
});
