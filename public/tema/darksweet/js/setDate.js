(function () {
    const countdown = document.querySelector('.date.countdown');
    if (!countdown) return;

    const targetValue = countdown.dataset.date;
    const values = {
        days: document.getElementById('days'),
        hours: document.getElementById('hours'),
        minutes: document.getElementById('minutes'),
        seconds: document.getElementById('seconds'),
    };

    if (!targetValue) return;

    const targetDate = new Date(targetValue).getTime();
    if (Number.isNaN(targetDate)) return;

    function updateCountdown() {
        const distance = targetDate - Date.now();
        const remaining = Math.max(0, distance);
        const days = Math.floor(remaining / 86400000);
        const hours = Math.floor((remaining % 86400000) / 3600000);
        const minutes = Math.floor((remaining % 3600000) / 60000);
        const seconds = Math.floor((remaining % 60000) / 1000);

        if (values.days) values.days.textContent = String(days).padStart(2, '0');
        if (values.hours) values.hours.textContent = String(hours).padStart(2, '0');
        if (values.minutes) values.minutes.textContent = String(minutes).padStart(2, '0');
        if (values.seconds) values.seconds.textContent = String(seconds).padStart(2, '0');

        return distance > 0;
    }

    updateCountdown();
    const interval = window.setInterval(() => {
        if (!updateCountdown()) window.clearInterval(interval);
    }, 1000);
})();
