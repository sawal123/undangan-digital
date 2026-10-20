<style>
    @font-face {
        font-family: 'Darkpre Poppins';
        src: url('{{ asset('tema/darkpre/assets/font/Poppins/Poppins-Regular.ttf') }}') format('truetype');
        font-display: swap;
    }

    @font-face {
        font-family: 'Darkpre Corinthia';
        src: url('{{ asset('tema/darkpre/assets/font/Corinthia/Corinthia-Regular.ttf') }}') format('truetype');
        font-display: swap;
    }

    :root {
        --darkpre-bg: #080808;
        --darkpre-surface: #11100f;
        --darkpre-surface-soft: #181512;
        --darkpre-gold: #f5cfa0;
        --darkpre-gold-strong: #ffdcae;
        --darkpre-muted: #c6b8ab;
        --darkpre-line: rgba(245, 207, 160, 0.3);
        --darkpre-shadow: 0 18px 42px rgba(0, 0, 0, 0.38);
    }

    html {
        scroll-behavior: smooth;
        background: var(--darkpre-bg);
    }

    body.darkpre-page {
        min-width: 320px;
        margin: 0;
        overflow-x: hidden;
        background: var(--darkpre-bg);
        color: var(--darkpre-gold);
        font-family: 'Darkpre Poppins', Poppins, sans-serif;
    }

    .darkpre-shell {
        position: relative;
        min-height: 100vh;
        background: var(--darkpre-bg);
    }

    .darkpre-left-panel {
        display: none;
    }

    .darkpre-content-panel {
        width: 100%;
        min-width: 0;
        background: var(--darkpre-bg);
    }

    .darkpre-left-image {
        position: absolute;
        inset: 0;
        background-position: center;
        background-size: cover;
        filter: brightness(0.48) saturate(0.78);
    }

    .darkpre-left-title {
        position: absolute;
        right: 2rem;
        bottom: 3rem;
        left: 2rem;
        z-index: 2;
        color: #fff8ee;
        font-family: 'Darkpre Corinthia', cursive;
        font-size: clamp(3rem, 5vw, 5rem);
        line-height: 0.9;
        text-align: center;
        text-shadow: 0 5px 24px rgba(0, 0, 0, 0.7);
    }

    .darkpre-mobile-cover {
        isolation: isolate;
        overflow: hidden;
        background-color: #17100c;
    }

    .darkpre-mobile-cover::before {
        position: absolute;
        inset: 0;
        z-index: 0;
        content: '';
        background:
            linear-gradient(180deg, rgba(8, 6, 5, 0.28) 0%, rgba(8, 6, 5, 0.12) 34%, rgba(8, 6, 5, 0.64) 76%, rgba(8, 6, 5, 0.96) 100%),
            radial-gradient(circle at 50% 18%, rgba(255, 224, 183, 0.18), transparent 38%);
    }

    .darkpre-mobile-cover #open-cover {
        position: absolute;
        right: 1.25rem;
        bottom: clamp(5rem, 13vh, 8rem);
        left: 1.25rem;
        width: auto !important;
        margin: 0;
    }

    .darkpre-float-control {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255, 255, 255, 0.24);
        box-shadow: 0 16px 30px rgba(0, 0, 0, 0.28);
        transition: transform 180ms ease, filter 180ms ease;
    }

    .darkpre-float-control:hover,
    .darkpre-float-control:focus-visible {
        transform: translateY(-3px);
        filter: brightness(1.08);
    }

    .darkpre-float-control--music {
        color: #fff;
        background: #91a2bc;
    }

    .darkpre-float-control--gift {
        color: #fff;
        background: #21cdbb;
    }

    .darkpre-hero {
        position: relative;
        min-height: 100svh;
        overflow: hidden;
        isolation: isolate;
        background: #17100c;
    }

    .darkpre-hero-media {
        position: absolute;
        inset: 0;
        z-index: -2;
        background-position: center;
        background-size: cover;
        filter: saturate(0.78) contrast(1.06);
        transform: scale(1.02);
    }

    .darkpre-hero-media::after {
        position: absolute;
        inset: 0;
        content: '';
        background:
            linear-gradient(180deg, rgba(8, 6, 5, 0.34) 0%, rgba(8, 6, 5, 0.16) 32%, rgba(8, 6, 5, 0.48) 72%, rgba(8, 6, 5, 0.94) 100%),
            radial-gradient(circle at 50% 22%, rgba(255, 224, 183, 0.2), transparent 38%);
    }

    .darkpre-hero-content {
        position: relative;
        z-index: 2;
        display: flex;
        min-height: 100svh;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        padding: clamp(3.5rem, 10vh, 7rem) 1.25rem 10rem;
        text-align: center;
        text-shadow: 0 4px 18px rgba(0, 0, 0, 0.72);
    }

    .darkpre-hero-eyebrow {
        padding: 0.55rem 1.2rem;
        border: 1px solid rgba(255, 220, 174, 0.52);
        border-radius: 999px;
        background: rgba(13, 10, 8, 0.35);
        color: #fff1dd;
        letter-spacing: 0.08em;
        font-size: clamp(0.85rem, 3.5vw, 1.25rem);
        font-weight: 600;
        text-transform: uppercase;
    }

    .darkpre-script {
        font-family: 'Darkpre Corinthia', cursive !important;
    }

    .darkpre-hero-title {
        max-width: 100%;
        margin-top: 1.4rem;
        color: #fff7ec;
        font-family: 'Darkpre Corinthia', cursive !important;
        font-size: clamp(3.2rem, 12vw, 5.5rem) !important;
        font-weight: 400;
        line-height: 0.95;
        text-shadow: 0 5px 24px rgba(0, 0, 0, 0.76);
    }

    .darkpre-hero-date {
        margin-top: 1.1rem;
        padding: 0.4rem 1.2rem;
        border-top: 1px solid rgba(255, 231, 201, 0.65);
        border-bottom: 1px solid rgba(255, 231, 201, 0.65);
        color: #fff3df;
        letter-spacing: 0.16em;
        font-size: clamp(1rem, 4.5vw, 1.4rem);
        font-weight: 600;
    }

    .darkpre-scroll-cue {
        position: absolute;
        bottom: 4.75rem;
        left: 50%;
        z-index: 3;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.6rem;
        color: #fff5e6;
        font-size: 0.8rem;
        letter-spacing: 0.04em;
        transform: translateX(-50%);
    }

    .darkpre-scroll-mouse {
        position: relative;
        width: 2rem;
        height: 3.4rem;
        border: 2px solid rgba(255, 243, 223, 0.92);
        border-radius: 999px;
        box-shadow: 0 0 0 5px rgba(255, 220, 174, 0.08);
    }

    .darkpre-scroll-mouse::after {
        position: absolute;
        top: 0.55rem;
        left: 50%;
        width: 0.35rem;
        height: 0.65rem;
        content: '';
        border-radius: 999px;
        background: #fff3df;
        transform: translateX(-50%);
        animation: darkpre-scroll 1.7s ease-in-out infinite;
    }

    @keyframes darkpre-scroll {
        0%, 100% { opacity: 0.35; transform: translate(-50%, 0); }
        50% { opacity: 1; transform: translate(-50%, 0.8rem); }
    }

    .darkpre-wave {
        position: absolute;
        right: 0;
        bottom: -1px;
        left: 0;
        z-index: 1;
        display: block;
        width: 100%;
        height: auto;
    }

    .darkpre-section,
    .darkpre-divider {
        position: relative;
        width: 100%;
        overflow: hidden;
        background: var(--darkpre-bg);
        color: var(--darkpre-gold);
    }

    .darkpre-section {
        padding: clamp(2.75rem, 6vw, 5rem) clamp(1.15rem, 4vw, 2.75rem);
    }

    .darkpre-divider {
        display: flex;
        justify-content: center;
        padding: 1rem 1rem 0;
    }

    .darkpre-divider img {
        width: min(100%, 20rem);
        max-height: 7rem;
        object-fit: contain;
        opacity: 0.88;
    }

    .darkpre-section-heading {
        position: relative;
        z-index: 2;
        margin: 0 0 1.25rem;
        color: var(--darkpre-gold-strong);
        font-family: 'Darkpre Corinthia', cursive !important;
        font-size: clamp(2.7rem, 9vw, 4.2rem);
        font-weight: 400;
        line-height: 0.95;
        text-align: center;
    }

    .darkpre-section-lead {
        max-width: 34rem;
        margin: 0 auto 2rem;
        color: var(--darkpre-muted);
        font-size: 0.9rem;
        line-height: 1.75;
        text-align: center;
    }

    .darkpre-quote-card {
        position: relative;
        max-width: 38rem;
        margin: 0 auto;
        padding: clamp(1.5rem, 5vw, 2.75rem);
        border: 1px solid var(--darkpre-line);
        border-radius: 1.5rem;
        background: linear-gradient(145deg, rgba(31, 25, 20, 0.96), rgba(12, 11, 10, 0.98));
        box-shadow: var(--darkpre-shadow), inset 0 1px rgba(255, 226, 186, 0.08);
        color: #f9dfbd;
        font-size: clamp(0.9rem, 3.2vw, 1.08rem);
        font-style: italic;
        line-height: 1.9;
        text-align: center;
    }

    .darkpre-quote-card::before,
    .darkpre-quote-card::after {
        position: absolute;
        color: rgba(245, 207, 160, 0.5);
        font-family: Georgia, serif;
        font-size: 3rem;
        line-height: 1;
    }

    .darkpre-quote-card::before { top: 0.55rem; left: 1rem; content: '“'; }
    .darkpre-quote-card::after { right: 1rem; bottom: -0.25rem; content: '”'; }

    .darkpre-couple-section {
        background-image: radial-gradient(circle at 50% 42%, rgba(110, 74, 41, 0.12), transparent 55%);
    }

    .darkpre-couple-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.25rem;
        max-width: 38rem;
        margin: 0 auto;
    }

    .darkpre-couple-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 0;
        padding: 1.25rem 1rem 1.5rem;
        border: 1px solid rgba(245, 207, 160, 0.18);
        border-radius: 1.5rem;
        background: linear-gradient(145deg, rgba(27, 22, 18, 0.96), rgba(13, 12, 11, 0.96));
        box-shadow: var(--darkpre-shadow);
        text-align: center;
    }

    .darkpre-couple-card img {
        width: min(52vw, 12rem);
        aspect-ratio: 1;
        border: 3px solid rgba(245, 207, 160, 0.62);
        border-radius: 50%;
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.45);
        object-fit: cover;
    }

    .darkpre-couple-name {
        margin: 1rem 0 0.5rem;
        color: var(--darkpre-gold-strong);
        font-family: 'Darkpre Corinthia', cursive !important;
        font-size: clamp(2.2rem, 8vw, 3.5rem);
        font-weight: 400;
        line-height: 0.95;
    }

    .darkpre-couple-bio {
        max-width: 24rem;
        margin: 0;
        color: var(--darkpre-muted);
        font-size: 0.78rem;
        line-height: 1.7;
    }

    .darkpre-couple-ampersand {
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--darkpre-gold-strong);
        font-family: 'Darkpre Corinthia', cursive;
        font-size: 3.5rem;
    }

    .darkpre-event-section {
        background-image: radial-gradient(circle at 50% 18%, rgba(125, 84, 42, 0.15), transparent 44%);
    }

    .darkpre-countdown {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0.55rem;
        max-width: 38rem;
        margin: 2rem auto;
    }

    .darkpre-countdown-item {
        min-width: 0;
        padding: 1rem 0.45rem;
        border: 1px solid rgba(245, 207, 160, 0.28);
        border-radius: 1rem;
        background: rgba(28, 22, 18, 0.88);
        text-align: center;
    }

    .darkpre-countdown-value {
        display: block;
        color: var(--darkpre-gold-strong);
        font-size: clamp(1.5rem, 6vw, 2.5rem);
        font-weight: 700;
        line-height: 1;
    }

    .darkpre-countdown-label {
        display: block;
        margin-top: 0.5rem;
        color: var(--darkpre-muted);
        font-size: 0.65rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .darkpre-date-line {
        color: var(--darkpre-muted);
        font-size: 0.86rem;
        text-align: center;
    }

    .darkpre-calendar-button,
    .darkpre-map-button,
    .darkpre-submit-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.55rem;
        min-height: 2.8rem;
        border: 1px solid rgba(255, 220, 174, 0.52);
        border-radius: 999px;
        background: linear-gradient(135deg, #f8d5aa, #b77943);
        color: #21150d;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.26);
        font-weight: 700;
        text-decoration: none;
        transition: transform 180ms ease, filter 180ms ease;
    }

    .darkpre-calendar-button,
    .darkpre-map-button {
        padding: 0.72rem 1.1rem;
    }

    .darkpre-calendar-button:hover,
    .darkpre-map-button:hover,
    .darkpre-submit-button:hover,
    .darkpre-calendar-button:focus-visible,
    .darkpre-map-button:focus-visible,
    .darkpre-submit-button:focus-visible {
        transform: translateY(-2px);
        filter: brightness(1.08);
    }

    .darkpre-event-list {
        display: grid;
        gap: 1rem;
        max-width: 38rem;
        margin: 2rem auto 0;
    }

    .darkpre-event-card {
        padding: 1.4rem 1.1rem;
        border: 1px solid rgba(245, 207, 160, 0.28);
        border-radius: 1.35rem;
        background: linear-gradient(145deg, rgba(29, 23, 18, 0.98), rgba(12, 11, 10, 0.98));
        box-shadow: var(--darkpre-shadow);
        color: var(--darkpre-muted);
        text-align: center;
    }

    .darkpre-event-card h3 {
        margin: 0 0 0.8rem;
        color: var(--darkpre-gold-strong);
        font-family: 'Darkpre Corinthia', cursive !important;
        font-size: 2.7rem;
        font-weight: 400;
        line-height: 0.95;
    }

    .darkpre-event-details {
        display: grid;
        gap: 0.35rem;
        font-size: 0.8rem;
        line-height: 1.6;
    }

    .darkpre-guest-section {
        text-align: center;
    }

    .darkpre-guest-list {
        display: grid;
        gap: 0.45rem;
        max-width: 28rem;
        margin: 1.5rem auto 0;
        color: var(--darkpre-muted);
        font-size: 0.82rem;
        line-height: 1.65;
    }

    .darkpre-guest-list strong {
        color: var(--darkpre-gold-strong);
        font-size: 1.05rem;
    }

    .darkpre-story-section .swiper,
    .darkpre-story-section .swiperStory {
        width: 100%;
        height: auto;
        min-height: 29rem;
        padding: 0.25rem 0.25rem 2.8rem;
        overflow: hidden;
    }

    .darkpre-story-slide {
        display: flex;
        box-sizing: border-box;
        width: 100%;
        min-width: 0;
        min-height: 25rem;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1.1rem;
        padding: 0.75rem 0.5rem 1.25rem;
        color: var(--darkpre-muted);
        text-align: center;
    }

    .darkpre-story-slide img {
        width: min(82vw, 19rem);
        max-width: 100%;
        height: 15rem;
        border: 3px solid rgba(245, 207, 160, 0.62);
        border-radius: 1.5rem;
        box-shadow: var(--darkpre-shadow);
        object-fit: cover;
    }

    .darkpre-story-line {
        width: min(72%, 13rem);
        height: 2px;
        flex: 0 0 auto;
        border-radius: 999px;
        background: linear-gradient(90deg, transparent, rgba(245, 207, 160, 0.7), transparent);
    }

    .darkpre-story-copy {
        width: min(100%, 24rem);
        box-sizing: border-box;
        min-height: 5rem;
        padding: 1rem 1.1rem;
        border: 1px solid rgba(245, 207, 160, 0.22);
        border-radius: 1.2rem;
        background: linear-gradient(145deg, rgba(34, 26, 20, 0.96), rgba(16, 14, 12, 0.96));
        box-shadow: 0 12px 26px rgba(0, 0, 0, 0.22);
        color: var(--darkpre-gold-strong);
        font-size: 0.9rem;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .darkpre-gallery-grid {
        width: 100%;
        max-width: 38rem;
        margin: 0 auto;
    }

    .darkpre-gallery-grid .swiper,
    .darkpre-gallery-grid .mySwiper {
        height: 24rem;
        min-height: 18rem;
        overflow: hidden;
        border-radius: 1.5rem;
        box-shadow: var(--darkpre-shadow);
    }

    .darkpre-gallery-grid .swiper-slide {
        height: 24rem;
        background: #17120e;
    }

    .darkpre-gallery-grid .swiper-slide img {
        display: block;
        width: 100%;
        height: 100%;
        cursor: pointer;
        object-fit: cover;
    }

    .darkpre-message-panel,
    .darkpre-wishes-section {
        position: relative;
        background: var(--darkpre-bg);
    }

    .darkpre-message-list {
        display: grid;
        gap: 0.8rem;
        max-height: 22rem;
        margin: 1.5rem auto 2rem;
        padding: 0.25rem;
        overflow-y: auto;
    }

    .darkpre-message-card {
        padding: 1rem;
        border: 1px solid rgba(245, 207, 160, 0.2);
        border-radius: 1.1rem;
        background: linear-gradient(145deg, rgba(31, 24, 19, 0.98), rgba(15, 13, 12, 0.98));
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.22);
        color: var(--darkpre-muted);
    }

    .darkpre-form-card {
        position: relative;
        max-width: 38rem;
        margin: 0 auto;
        padding: 1.4rem;
        border: 1px solid rgba(245, 207, 160, 0.24);
        border-radius: 1.5rem;
        background: linear-gradient(145deg, rgba(31, 24, 19, 0.98), rgba(14, 12, 11, 0.98));
        box-shadow: var(--darkpre-shadow);
    }

    .darkpre-form-title {
        margin: 0;
        color: var(--darkpre-gold-strong);
        font-family: 'Darkpre Corinthia', cursive !important;
        font-size: 2.9rem;
        font-weight: 400;
        line-height: 1;
    }

    .darkpre-form-intro {
        margin: 0.5rem 0 1.25rem;
        color: var(--darkpre-muted);
        font-size: 0.78rem;
        line-height: 1.6;
    }

    .darkpre-wish-form {
        display: grid;
        gap: 0.9rem;
    }

    .darkpre-form-input {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid rgba(245, 207, 160, 0.25);
        border-radius: 0.9rem;
        background: rgba(9, 8, 7, 0.9);
        color: #fff4e5;
        outline: none;
        transition: border-color 180ms ease, box-shadow 180ms ease;
    }

    .darkpre-form-input::placeholder {
        color: rgba(245, 207, 160, 0.62);
    }

    .darkpre-form-input:focus {
        border-color: var(--darkpre-gold-strong);
        box-shadow: 0 0 0 3px rgba(245, 207, 160, 0.12);
    }

    .darkpre-submit-button {
        width: 100%;
        padding: 0.85rem 1rem;
        cursor: pointer;
    }

    .darkpre-form-alert {
        margin: 0.75rem 0;
        padding: 0.75rem 1rem;
        border: 1px solid rgba(245, 207, 160, 0.35);
        border-radius: 0.85rem;
        background: rgba(32, 24, 17, 0.96);
        color: var(--darkpre-gold-strong);
        font-size: 0.82rem;
    }

    .darkpre-form-alert--error {
        border-color: rgba(248, 113, 113, 0.48);
        color: #fecaca;
    }

    .darkpre-form-error {
        margin-top: 0.3rem;
        color: #fca5a5;
        font-size: 0.72rem;
    }

    .darkpre-footer {
        padding: 2rem 1rem 6rem;
        background: var(--darkpre-bg);
        color: var(--darkpre-muted);
        font-size: 0.7rem;
        text-align: center;
    }

    .darkpre-mobile-nav,
    .darkpre-side-nav {
        position: fixed;
        z-index: 50;
        border: 1px solid rgba(255, 255, 255, 0.72);
        background: rgba(9, 8, 7, 0.84);
        box-shadow: 0 16px 34px rgba(0, 0, 0, 0.38);
        backdrop-filter: blur(14px);
    }

    .darkpre-mobile-nav {
        right: 0.75rem;
        bottom: 0.75rem;
        left: 0.75rem;
        min-height: 4.45rem;
        border-radius: 1.15rem;
    }

    .darkpre-mobile-nav > div {
        width: 100%;
        padding: 0.65rem !important;
    }

    .darkpre-mobile-nav > div > div {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.2rem;
    }

    .darkpre-mobile-nav .nav-link,
    .darkpre-side-nav .nav-link {
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--darkpre-gold-strong) !important;
        border-radius: 999px;
        transition: background 180ms ease, color 180ms ease, transform 180ms ease;
    }

    .darkpre-mobile-nav .nav-link {
        flex: 1 1 0;
        width: auto;
        max-width: none;
        min-width: 0;
        min-height: 3.2rem;
        flex-direction: column;
        gap: 0.25rem;
        padding: 0.35rem 0.15rem;
        font-size: 0.95rem;
    }

    .darkpre-mobile-nav .nav-link span {
        display: block !important;
        margin: 0 !important;
        color: inherit;
        font-size: 0.58rem;
        line-height: 1;
        white-space: nowrap;
    }

    .darkpre-side-nav {
        top: 45%;
        right: 1.5rem;
        border-radius: 999px;
    }

    .darkpre-side-nav > div {
        padding: 0.65rem 0.35rem;
    }

    .darkpre-side-nav > div > div {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
    }

    .darkpre-side-nav .nav-link {
        width: 2rem;
        min-height: 2rem;
        font-size: 0.85rem;
    }

    .darkpre-mobile-nav .nav-link.bg-orange-200,
    .darkpre-mobile-nav .nav-link.is-active,
    .darkpre-side-nav .nav-link.bg-orange-200,
    .darkpre-side-nav .nav-link.is-active {
        color: #25170d !important;
        background: var(--darkpre-gold-strong) !important;
        box-shadow: 0 5px 14px rgba(0, 0, 0, 0.28);
        transform: translateY(-2px);
    }

    .darkpre-mobile-nav .nav-link:hover:not(.is-active):not(.bg-orange-200),
    .darkpre-side-nav .nav-link:hover:not(.is-active):not(.bg-orange-200) {
        color: var(--darkpre-gold-strong) !important;
        background: rgba(245, 207, 160, 0.12) !important;
    }

    #infoModal {
        z-index: 70;
        padding: 1rem;
        background: rgba(0, 0, 0, 0.76) !important;
        backdrop-filter: blur(8px);
    }

    #infoModal > div {
        max-height: min(88dvh, 46rem);
        overflow-y: auto;
        border: 1px solid rgba(245, 207, 160, 0.3);
        background: #f5eadb !important;
    }

    @media (min-width: 1024px) {
        .darkpre-left-panel {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 20;
            display: block;
            width: 60%;
            height: 100vh;
            overflow: hidden;
            background: #15100d;
        }

        .darkpre-content-panel {
            width: 40%;
            margin-left: auto;
        }

        .darkpre-mobile-nav {
            display: none;
        }

        .darkpre-couple-grid {
            gap: 0.75rem;
        }
    }

    @media (max-width: 400px) {
        .darkpre-mobile-nav {
            right: 0.45rem;
            bottom: 0.45rem;
            left: 0.45rem;
        }

        .darkpre-mobile-nav .nav-link span {
            font-size: 0.52rem;
        }
    }

    @media (max-width: 767px) {
        .darkpre-story-slide {
            width: 100% !important;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            scroll-behavior: auto !important;
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>
