// Mendapatkan elemen dan link berdasarkan ID dan kelas
const home = document.getElementById("couple");
const homeLink = document.getElementsByClassName("couple");

const detail = document.getElementById("date");
const detailLink = document.getElementsByClassName("date");

const gallery = document.getElementById("gallery");
const galleryLink = document.getElementsByClassName("gallery");
const reservation = document.getElementById("location");
const reservationLink = document.getElementsByClassName("location");
const message = document.getElementById("wishes");
const messageLink = document.getElementsByClassName("wishes");

if (!gallery) {
    // Kalau gallery nggak ada, hapus juga semua link dengan class gallery dari DOM
    for (let i = galleryLink.length - 1; i >= 0; i--) {
        galleryLink[i].remove();
    }
}

// Fungsi untuk menambahkan class active pada link yang sesuai
function setActive(link) {
    const allLinks = document.getElementsByClassName("nav-link");

    // Menghapus class aktif dari semua link
    for (let i = 0; i < allLinks.length; i++) {
        const span = allLinks[i].querySelector("span");
        if (span) span.classList.add("hidden"); // Sembunyikan span
        allLinks[i].classList.remove(
            "bg-orange-200",
            "text-black",
            "rounded-full"
        ); // Hapus semua kelas aktif
    }

    // Menambahkan class aktif hanya pada link yang sedang aktif
    for (let i = 0; i < link.length; i++) {
        const currentSpan = link[i].querySelector("span");
        if (currentSpan) currentSpan.classList.remove("hidden"); // Tampilkan span
        link[i].classList.add("bg-orange-200", "text-black", "rounded-full"); // Tambahkan kelas aktif
        link[i].classList.remove("text-orange-200");
    }
}

function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return rect.top >= -5 && rect.bottom <= window.innerHeight;
}

// Event handler onscroll untuk window
function safeInViewport(element) {
    return element ? isInViewport(element) : false;
}

window.onscroll = function () {
    if (safeInViewport(home)) {
        setActive(homeLink);
    } else if (safeInViewport(detail)) {
        setActive(detailLink);
    } else if (safeInViewport(gallery)) {
        setActive(galleryLink);
    } else if (safeInViewport(reservation)) {
        setActive(reservationLink);
    } else if (safeInViewport(message)) {
        setActive(messageLink);
    }
};
