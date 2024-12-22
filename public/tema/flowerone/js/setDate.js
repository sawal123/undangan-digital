document.addEventListener("DOMContentLoaded", function () {
        // Ambil tanggal dari elemen HTML
        const countdownElement = document.querySelector('.date.countdown');
        const eventDate = new Date(countdownElement.getAttribute('data-date')).getTime();

        // Fungsi untuk memperbarui countdown setiap detik
        const updateCountdown = () => {
            const now = new Date().getTime();
            const distance = eventDate - now;

            if (distance < 0) {
                // Jika waktu habis
                document.getElementById('countdown').innerHTML = `<p>Acara Sudah Dimulai!</p>`;
                return;
            }

            // Hitung hari, jam, menit, dan detik
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Tampilkan hasil di HTML
            document.getElementById('days').textContent = days;
            document.getElementById('hours').textContent = hours;
            document.getElementById('minutes').textContent = minutes;
            document.getElementById('seconds').textContent = seconds;
        };

        // Jalankan fungsi pertama kali
        updateCountdown();

        // Perbarui setiap detik
        setInterval(updateCountdown, 1000);
    });

