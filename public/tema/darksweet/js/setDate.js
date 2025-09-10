function startCountdown() {
    const countdownElement = document.querySelector(".date.countdown");
    const targetDate = new Date(
        countdownElement.getAttribute("data-date")
    ).getTime();
    const interval = setInterval(() => {
        const now = new Date().getTime();
        const difference = targetDate - now;
        if (difference < 0) {
            clearInterval(interval);
            document.getElementById("countdown").innerHTML =
                "<p class='text-white bg-gray-900 px-2 py-1 rounded-md text-lg'>Acara Telah Berlangsung</p>";
            return;
        }
        const days = Math.floor(difference / (1000 * 60 * 60 * 24));
        const hours = Math.floor(
            (difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        const minutes = Math.floor(
            (difference % (1000 * 60 * 60)) / (1000 * 60)
        );
        const seconds = Math.floor((difference % (1000 * 60)) / 1000);
        document.getElementById("days").textContent = days;
        document.getElementById("hours").textContent = hours;
        document.getElementById("minutes").textContent = minutes;
        document.getElementById("seconds").textContent = seconds;
    }, 1000);
}
startCountdown();
