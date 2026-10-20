document.addEventListener("DOMContentLoaded", function () {
        const countdownElement = document.querySelector('.date.countdown');
        const countdown = document.getElementById('countdown');
        if (!countdownElement || !countdown) return;

        const eventDate = new Date(countdownElement.getAttribute('data-date')).getTime();
        if (Number.isNaN(eventDate)) return;

        // Fungsi untuk memperbarui countdown setiap detik
        const updateCountdown = () => {
            const now = new Date().getTime();
            const distance = eventDate - now;

            if (distance < 0) {
                // Jika waktu habis
                countdown.innerHTML = `<p class="countdown-finished">Acara sudah dimulai</p>`;
                return;
            }

            // Hitung hari, jam, menit, dan detik
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Tampilkan hasil di HTML
            countdown.querySelector('#days').textContent = days;
            countdown.querySelector('#hours').textContent = hours;
            countdown.querySelector('#minutes').textContent = minutes;
            countdown.querySelector('#seconds').textContent = seconds;
        };

        // Jalankan fungsi pertama kali
        updateCountdown();

        // Perbarui setiap detik
        setInterval(updateCountdown, 1000);
    });

