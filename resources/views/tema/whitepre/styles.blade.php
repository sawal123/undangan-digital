<style>
    :root {
        --whitepre-cream: #fff8ef;
        --whitepre-cream-deep: #f8eadc;
        --whitepre-rose: #8f3f62;
        --whitepre-rose-deep: #642844;
        --whitepre-ink: #30232b;
        --whitepre-muted: #735c67;
        --whitepre-line: rgba(143, 63, 98, 0.16);
        --whitepre-shadow: 0 18px 50px rgba(88, 42, 63, 0.12);
    }

    html {
        scroll-behavior: smooth;
        background: var(--whitepre-cream);
    }

    body.whitepre-page {
        min-width: 0;
        overflow-x: hidden;
        background: var(--whitepre-cream);
        color: var(--whitepre-ink);
    }

    .whitepre-page *,
    .whitepre-page *::before,
    .whitepre-page *::after {
        box-sizing: border-box;
    }

    .whitepre-shell {
        position: relative;
        display: flex;
        min-height: 100dvh;
        width: 100%;
    }

    .whitepre-left-panel {
        position: fixed;
        inset: 0 auto 0 0;
        z-index: 20;
        width: 60%;
        height: 100dvh;
        overflow: hidden;
        background: #231b20;
    }

    .whitepre-content-panel {
        width: 40%;
        min-width: 0;
        min-height: 100dvh;
        margin-left: 60%;
        overflow: hidden;
        background: var(--whitepre-cream);
    }

    .whitepre-left-image {
        position: absolute;
        inset: 0;
        background-position: center;
        background-size: cover;
        filter: brightness(0.58) saturate(0.9);
    }

    .whitepre-left-image::after {
        position: absolute;
        inset: 0;
        content: "";
        background: linear-gradient(180deg, rgba(18, 12, 17, 0.08), rgba(18, 12, 17, 0.45));
    }

    .whitepre-left-title {
        position: absolute;
        right: 3rem;
        bottom: 3rem;
        z-index: 2;
        color: #fff9f4;
        font-size: clamp(2.5rem, 4vw, 4.5rem) !important;
        line-height: 1;
        text-shadow: 0 8px 28px rgba(0, 0, 0, 0.5);
    }

    .whitepre-side-nav {
        position: absolute !important;
        top: 50% !important;
        right: 1.5rem !important;
        z-index: 40 !important;
        width: auto !important;
        transform: translateY(-50%);
        border: 1px solid rgba(255, 255, 255, 0.34);
        border-radius: 999px !important;
        background: linear-gradient(145deg, #5d2a49 0%, #8d4967 52%, #642a4c 100%) !important;
        box-shadow: 0 12px 32px rgba(29, 12, 21, 0.2);
        backdrop-filter: blur(14px);
    }

    .whitepre-side-nav > div {
        padding: 0.6rem !important;
    }

    .whitepre-side-nav .nav-link {
        display: flex;
        width: 2.45rem;
        height: 2.45rem;
        align-items: center;
        justify-content: center;
        color: var(--whitepre-rose) !important;
        border-radius: 999px;
        transition: background-color 180ms ease, color 180ms ease, transform 180ms ease;
    }

    .whitepre-side-nav .nav-link:hover {
        color: #fff !important;
        background: var(--whitepre-rose) !important;
        transform: translateY(-2px);
    }

    .whitepre-side-nav .nav-link.bg-orange-200 {
        color: var(--whitepre-rose-deep) !important;
        background: #ffe8d5 !important;
        box-shadow: 0 5px 14px rgba(40, 15, 28, 0.18);
        transform: translateY(-2px);
    }

    .whitepre-side-nav .nav-link span,
    .whitepre-mobile-nav .nav-link span {
        display: none !important;
    }

    .whitepre-float-control {
        border: 1px solid rgba(255, 255, 255, 0.5) !important;
        box-shadow: 0 12px 28px rgba(43, 24, 34, 0.2) !important;
        backdrop-filter: blur(12px);
    }

    .whitepre-float-control--music {
        background: rgba(112, 131, 163, 0.88) !important;
    }

    .whitepre-float-control--gift {
        background: rgba(35, 195, 180, 0.92) !important;
    }

    .whitepre-hero {
        position: relative;
        min-height: 100svh;
        overflow: hidden;
        color: #fff;
        background: #241820;
    }

    .whitepre-hero-media {
        position: absolute;
        inset: 0;
        background-position: center;
        background-size: cover;
        filter: saturate(0.92) contrast(1.02);
        transform: scale(1.02);
    }

    .whitepre-hero-media::after {
        position: absolute;
        inset: 0;
        content: "";
        background:
            linear-gradient(180deg, rgba(15, 10, 17, 0.2) 0%, rgba(15, 10, 17, 0.08) 28%, rgba(15, 10, 17, 0.36) 62%, rgba(15, 10, 17, 0.82) 100%),
            radial-gradient(circle at 50% 24%, rgba(255, 255, 255, 0.2), transparent 34%);
    }

    .whitepre-hero-content {
        position: relative;
        z-index: 2;
        display: flex;
        min-height: 100svh;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        padding: clamp(3.5rem, 10vh, 7rem) 1.25rem 10rem;
        text-align: center;
        text-shadow: 0 4px 18px rgba(0, 0, 0, 0.65);
    }

    .whitepre-hero-eyebrow {
        padding: 0.55rem 1.15rem;
        border: 1px solid rgba(255, 255, 255, 0.48);
        border-radius: 999px;
        background: rgba(26, 17, 24, 0.28);
        letter-spacing: 0.1em;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .whitepre-hero-title {
        max-width: 92%;
        margin: 1.5rem 0 0;
        color: #fffaf4;
        font-size: clamp(2.7rem, 5vw, 4.7rem) !important;
        line-height: 1.08;
        text-shadow: 0 5px 24px rgba(0, 0, 0, 0.75);
    }

    .whitepre-hero-date {
        margin-top: 1rem;
        padding: 0.4rem 1.25rem;
        border-top: 1px solid rgba(255, 255, 255, 0.6);
        border-bottom: 1px solid rgba(255, 255, 255, 0.6);
        letter-spacing: 0.16em;
        font-size: 1.15rem;
        font-weight: 600;
    }

    .whitepre-scroll-cue {
        position: absolute;
        bottom: 5.4rem;
        left: 50%;
        z-index: 3;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.65rem;
        color: #fff;
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        transform: translateX(-50%);
    }

    .whitepre-scroll-mouse {
        position: relative;
        width: 1.8rem;
        height: 3rem;
        border: 2px solid rgba(255, 255, 255, 0.9);
        border-radius: 999px;
    }

    .whitepre-scroll-mouse::after {
        position: absolute;
        top: 0.5rem;
        left: 50%;
        width: 0.3rem;
        height: 0.55rem;
        content: "";
        border-radius: 999px;
        background: #fff;
        transform: translateX(-50%);
        animation: whitepre-scroll 1.7s ease-in-out infinite;
    }

    .whitepre-wave {
        position: absolute;
        right: 0;
        bottom: -1px;
        left: 0;
        z-index: 2;
        display: block;
        width: 100%;
        height: auto;
    }

    .whitepre-section,
    .whitepre-divider {
        position: relative;
        width: 100%;
        overflow: hidden;
        background: var(--whitepre-cream);
        color: var(--whitepre-rose-deep);
    }

    .whitepre-section {
        padding: clamp(2.75rem, 6vw, 5rem) clamp(1.15rem, 4vw, 2.75rem);
    }

    .whitepre-divider {
        display: flex;
        justify-content: center;
        padding: 1.2rem 1rem;
    }

    .whitepre-divider img {
        width: min(100%, 13rem);
        max-height: 6rem;
        object-fit: contain;
        opacity: 0.82;
    }

    .whitepre-section-heading {
        position: relative;
        z-index: 1;
        margin: 0 0 1.25rem;
        color: var(--whitepre-rose-deep);
        font-size: clamp(2rem, 6vw, 3.2rem) !important;
        line-height: 1.1;
        text-align: center;
    }

    .whitepre-section-lead {
        max-width: 36rem;
        margin: 0 auto 1.75rem;
        color: var(--whitepre-muted);
        font-size: 0.9rem;
        line-height: 1.8;
        text-align: center;
    }

    .whitepre-quote-card,
    .whitepre-event-card,
    .whitepre-couple-card,
    .whitepre-message-card {
        border: 1px solid var(--whitepre-line);
        border-radius: 1.5rem;
        box-shadow: var(--whitepre-shadow);
    }

    .whitepre-quote-card {
        max-width: 34rem;
        margin: 0 auto;
        padding: clamp(1.5rem, 5vw, 2.75rem);
        color: #fff9f4;
        background: linear-gradient(145deg, var(--whitepre-rose) 0%, var(--whitepre-rose-deep) 100%);
        font-style: italic;
        line-height: 1.8;
        text-align: center;
    }

    .whitepre-quote-card p {
        margin: 0;
    }

    .whitepre-quote-card span {
        display: block;
        margin-top: 1rem;
        color: #f9ddca;
        font-size: 0.8rem;
        font-style: normal;
        letter-spacing: 0.04em;
    }

    .whitepre-couple-section {
        background-position: center;
        background-size: contain;
    }

    .whitepre-couple-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
        max-width: 44rem;
        margin: 0 auto;
    }

    .whitepre-couple-card {
        padding: 1.5rem 1rem;
        background: rgba(255, 250, 245, 0.7);
        text-align: center;
    }

    .whitepre-couple-card img {
        width: min(65vw, 15rem);
        aspect-ratio: 1;
        margin: 0 auto;
        border: 0.45rem solid rgba(255, 255, 255, 0.82);
        border-radius: 999px;
        box-shadow: 0 14px 35px rgba(100, 40, 68, 0.18);
        object-fit: cover;
    }

    .whitepre-couple-name {
        margin: 1rem 0 0.7rem;
        color: var(--whitepre-rose-deep);
        font-size: clamp(1.65rem, 5vw, 2.5rem) !important;
        line-height: 1.15;
    }

    .whitepre-couple-bio {
        color: var(--whitepre-muted);
        font-size: 0.8rem;
        line-height: 1.8;
    }

    .whitepre-couple-ampersand {
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--whitepre-rose);
        font-family: serif;
        font-size: 2.5rem;
    }

    .whitepre-story-section .swiper,
    .whitepre-story-section .swiperStory {
        width: 100%;
        height: auto;
        min-height: 27rem;
        padding: 0.25rem 0.25rem 2.75rem;
        overflow: hidden;
    }

    .whitepre-story-slide {
        display: flex;
        width: 100%;
        min-height: 24rem;
        box-sizing: border-box;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1.15rem;
        padding: 0.75rem 0.5rem 1.25rem;
        text-align: center;
    }

    .whitepre-story-slide img {
        width: min(82vw, 19rem);
        max-width: 100%;
        height: 15rem;
        border: 4px solid rgba(143, 63, 98, 0.48);
        border-radius: 1.5rem;
        box-shadow: var(--whitepre-shadow);
        object-fit: cover;
    }

    .whitepre-story-line {
        width: min(72%, 13rem);
        height: 2px;
        flex: 0 0 auto;
        border-radius: 999px;
        background: linear-gradient(90deg, transparent, rgba(143, 63, 98, 0.58), transparent);
    }

    .whitepre-story-copy {
        width: min(100%, 24rem);
        box-sizing: border-box;
        min-height: 7rem;
        max-height: 9.5rem;
        overflow-y: auto;
        padding: 1rem 1.1rem;
        border: 1px solid rgba(143, 63, 98, 0.18);
        border-radius: 1.25rem;
        background: linear-gradient(145deg, rgba(255, 248, 239, 0.96), rgba(248, 222, 225, 0.9));
        box-shadow: 0 12px 26px rgba(88, 42, 63, 0.12);
        overflow-wrap: anywhere;
        scrollbar-width: thin;
        scrollbar-color: rgba(143, 63, 98, 0.45) transparent;
    }

    .whitepre-story-copy h3,
    .whitepre-story-copy p {
        max-width: 100%;
        margin-inline: auto;
        overflow-wrap: anywhere;
        word-break: normal;
    }

    .whitepre-story-copy h3 {
        color: var(--whitepre-rose-deep);
        font-size: 1.05rem;
        line-height: 1.35;
    }

    .whitepre-story-copy p {
        color: var(--whitepre-muted);
        font-size: 0.78rem;
        font-weight: 400;
        line-height: 1.65;
    }

    .whitepre-story-slide > p.whitepre-story-copy {
        margin: 0;
    }

    .whitepre-gallery-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.7rem;
    }

    .whitepre-gallery-grid button {
        padding: 0;
        border: 0;
        background: transparent;
        cursor: pointer;
    }

    .whitepre-gallery-grid img {
        display: block;
        width: 100%;
        aspect-ratio: 0.82;
        border: 1px solid rgba(143, 63, 98, 0.12);
        border-radius: 1rem;
        box-shadow: 0 10px 24px rgba(88, 42, 63, 0.12);
        object-fit: cover;
        transition: transform 220ms ease, box-shadow 220ms ease;
    }

    .whitepre-gallery-grid img:hover {
        box-shadow: 0 16px 30px rgba(88, 42, 63, 0.2);
        transform: translateY(-3px);
    }

    .whitepre-countdown {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0.55rem;
        max-width: 30rem;
        margin: 1.75rem auto;
    }

    .whitepre-countdown-item {
        padding: 0.85rem 0.35rem;
        border: 1px solid var(--whitepre-line);
        border-radius: 1rem;
        background: rgba(255, 255, 255, 0.62);
        box-shadow: 0 8px 22px rgba(88, 42, 63, 0.08);
        text-align: center;
    }

    .whitepre-countdown-value {
        color: var(--whitepre-rose);
        font-size: clamp(1.5rem, 6vw, 2.3rem);
        font-weight: 700;
        line-height: 1;
    }

    .whitepre-countdown-label {
        display: block;
        margin-top: 0.45rem;
        color: var(--whitepre-muted);
        font-size: 0.65rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .whitepre-date-line {
        color: var(--whitepre-muted);
        font-size: 0.85rem;
        line-height: 1.7;
        text-align: center;
    }

    .whitepre-action,
    .whitepre-calendar-button,
    .whitepre-map-button,
    .whitepre-submit-button,
    .whitepre-copy-button,
    .whitepre-close-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
        border: 1px solid transparent;
        border-radius: 999px;
        transition: transform 180ms ease, box-shadow 180ms ease, background-color 180ms ease;
    }

    .whitepre-calendar-button,
    .whitepre-map-button,
    .whitepre-submit-button {
        width: auto !important;
        min-width: 14rem;
        white-space: nowrap;
        padding: 0.7rem 1.15rem;
        color: #fff !important;
        background: var(--whitepre-rose);
        box-shadow: 0 10px 22px rgba(143, 63, 98, 0.2);
    }

    .whitepre-calendar-button:hover,
    .whitepre-map-button:hover,
    .whitepre-submit-button:hover {
        background: var(--whitepre-rose-deep);
        box-shadow: 0 14px 26px rgba(143, 63, 98, 0.3);
        transform: translateY(-2px);
    }

    @media (max-width: 380px) {
        .whitepre-calendar-button {
            min-width: 0;
            width: 100% !important;
        }
    }

    .whitepre-event-list {
        display: grid;
        gap: 1rem;
        max-width: 34rem;
        margin: 0 auto;
    }

    .whitepre-event-card {
        padding: 1.35rem;
        background: rgba(255, 255, 255, 0.58);
        text-align: center;
    }

    .whitepre-event-card h2 {
        margin: 0 0 0.75rem;
        color: var(--whitepre-rose-deep);
        font-size: clamp(1.85rem, 6vw, 2.8rem) !important;
    }

    .whitepre-event-details {
        display: grid;
        gap: 0.3rem;
        color: var(--whitepre-muted);
        font-size: 0.8rem;
        line-height: 1.6;
    }

    .whitepre-invitation-note {
        color: var(--whitepre-muted);
        font-size: 0.82rem;
        line-height: 1.8;
        text-align: center;
    }

    .whitepre-guest-list {
        max-width: 30rem;
        margin: 1.25rem auto 0;
        color: var(--whitepre-muted);
        line-height: 1.8;
        text-align: center;
        white-space: pre-line;
    }

    .whitepre-wishes-section {
        background: var(--whitepre-cream-deep);
    }

    .whitepre-form-card {
        position: relative;
        max-width: 34rem;
        margin: 0 auto;
        overflow: hidden;
        padding: clamp(1.35rem, 5vw, 2.25rem);
        border: 1px solid rgba(143, 63, 98, 0.18);
        border-radius: 1.75rem;
        background: linear-gradient(135deg, #fff3e6 0%, #f8dfe0 48%, #e8c9df 100%);
        box-shadow: 0 22px 45px rgba(111, 53, 79, 0.18);
    }

    .whitepre-form-card::before {
        position: absolute;
        top: -6rem;
        right: -5rem;
        width: 15rem;
        height: 15rem;
        content: "";
        border-radius: 999px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.78) 0%, rgba(255, 255, 255, 0) 70%);
        pointer-events: none;
    }

    .whitepre-form-card::after {
        position: absolute;
        bottom: -8rem;
        left: -6rem;
        width: 18rem;
        height: 18rem;
        content: "";
        border-radius: 999px;
        background: radial-gradient(circle, rgba(255, 210, 224, 0.48) 0%, rgba(255, 210, 224, 0) 68%);
        pointer-events: none;
    }

    .whitepre-form-title,
    .whitepre-form-intro,
    .whitepre-form-card form,
    .whitepre-form-alert,
    .whitepre-form-decoration {
        position: relative;
        z-index: 1;
    }

    .whitepre-form-title {
        margin: 0 0 0.45rem;
        color: var(--whitepre-rose-deep);
        font-size: clamp(1.8rem, 6vw, 2.55rem) !important;
        line-height: 1.1;
    }

    .whitepre-form-intro {
        margin: 0 0 1.35rem;
        color: var(--whitepre-muted);
        font-size: 0.78rem;
        line-height: 1.7;
    }

    .whitepre-form-decoration {
        position: absolute;
        top: 0.25rem;
        right: -0.5rem;
        width: 7rem;
        opacity: 0.35;
        pointer-events: none;
    }

    .whitepre-form-decoration img {
        width: 100%;
        height: auto;
    }

    .whitepre-form-field {
        position: relative;
        z-index: 1;
    }

    .whitepre-form-input {
        width: 100%;
        min-height: 3.25rem;
        border: 1px solid rgba(143, 63, 98, 0.18) !important;
        border-radius: 1rem !important;
        background: rgba(255, 253, 249, 0.86) !important;
        color: var(--whitepre-ink) !important;
        outline: none;
        box-shadow: inset 0 1px rgba(255, 255, 255, 0.8);
        transition: border-color 180ms ease, box-shadow 180ms ease, background-color 180ms ease;
    }

    .whitepre-form-input::placeholder {
        color: #6f5962;
        opacity: 1;
    }

    .whitepre-form-input:focus {
        border-color: var(--whitepre-rose) !important;
        background: #fffdfa !important;
        box-shadow: 0 0 0 4px rgba(143, 63, 98, 0.12), inset 0 1px rgba(255, 255, 255, 0.8);
    }

    textarea.whitepre-form-input {
        min-height: 9rem;
        resize: vertical;
    }

    select.whitepre-form-input {
        appearance: auto;
        padding-right: 2.5rem;
    }

    .whitepre-form-error {
        margin-top: 0.35rem;
        color: #a3284d;
        font-size: 0.72rem;
    }

    .whitepre-form-alert {
        margin-bottom: 1rem;
        border: 1px solid rgba(46, 125, 82, 0.2);
        border-radius: 0.85rem;
        padding: 0.7rem 0.85rem;
        background: rgba(229, 247, 236, 0.82);
        color: #24633f;
        font-size: 0.78rem;
        text-align: center;
    }

    .whitepre-form-alert--error {
        border-color: rgba(163, 40, 77, 0.2);
        background: rgba(255, 234, 239, 0.86);
        color: #a3284d;
    }

    .whitepre-message-list {
        display: grid;
        max-height: 20rem;
        gap: 0.75rem;
        overflow-y: auto;
        padding: 0.25rem;
    }

    .whitepre-message-card {
        padding: 1rem;
        background: rgba(255, 255, 255, 0.72);
    }

    .whitepre-wish-form {
        display: grid;
        gap: 0.85rem;
        margin-top: 1.5rem;
    }

    .whitepre-wish-form input,
    .whitepre-wish-form textarea,
    .whitepre-wish-form select {
        width: 100%;
        border: 1px solid var(--whitepre-line);
        border-radius: 0.9rem;
        background: rgba(255, 255, 255, 0.75);
        color: var(--whitepre-ink);
        outline: none;
    }

    .whitepre-wish-form input:focus,
    .whitepre-wish-form textarea:focus,
    .whitepre-wish-form select:focus {
        border-color: var(--whitepre-rose);
        box-shadow: 0 0 0 3px rgba(143, 63, 98, 0.14);
    }

    .whitepre-footer {
        padding: 2rem 1rem 6rem;
        color: var(--whitepre-muted);
        background: var(--whitepre-cream);
        text-align: center;
    }

    .whitepre-mobile-nav {
        position: fixed !important;
        right: 0.75rem !important;
        bottom: 0.75rem !important;
        left: 0.75rem !important;
        z-index: 50 !important;
        width: auto !important;
        border: 1px solid rgba(255, 255, 255, 0.42);
        border-radius: 1.4rem !important;
        display: flex !important;
        align-items: center;
        background: linear-gradient(145deg, #5d2a49 0%, #8d4967 52%, #642a4c 100%) !important;
        box-shadow: 0 16px 34px rgba(43, 24, 34, 0.24) !important;
        backdrop-filter: blur(16px);
    }

    .whitepre-mobile-nav > div {
        width: 100%;
        padding: 0.65rem !important;
    }

    .whitepre-mobile-nav > div > div {
        display: flex;
        align-items: center;
        justify-content: center !important;
        gap: 0.5rem !important;
    }

    .whitepre-mobile-nav .nav-link {
        display: flex;
        flex: 0 0 2.85rem;
        align-items: center;
        justify-content: center !important;
        width: 2.85rem;
        max-width: 2.85rem;
        height: 2.5rem;
        margin: 0;
        color: #ffe8d5 !important;
        border-radius: 0.9rem;
        font-size: 1.05rem;
        line-height: 1;
        text-align: center;
        transition: background-color 180ms ease, color 180ms ease, transform 180ms ease;
    }

    .whitepre-mobile-nav .nav-link:hover,
    .whitepre-mobile-nav .nav-link.bg-orange-200 {
        color: var(--whitepre-rose-deep) !important;
        background: #ffe8d5 !important;
        box-shadow: 0 5px 14px rgba(40, 15, 28, 0.18);
        transform: translateY(-2px);
    }

    #infoModal {
        padding: 1rem;
        background: rgba(24, 13, 20, 0.7) !important;
        backdrop-filter: blur(8px);
    }

    #infoModal > div {
        max-height: min(88dvh, 46rem);
        overflow-y: auto;
        border: 1px solid rgba(255, 255, 255, 0.5);
        background: var(--whitepre-cream) !important;
    }

    #imageModal {
        padding: 1rem;
        background: rgba(24, 13, 20, 0.82) !important;
        backdrop-filter: blur(6px);
    }

    #modalImageContent {
        max-height: 84dvh;
        object-fit: contain;
    }

    @keyframes whitepre-scroll {
        0% { opacity: 0; transform: translate(-50%, 0); }
        25% { opacity: 1; }
        100% { opacity: 0; transform: translate(-50%, 1rem); }
    }

    @media (min-width: 768px) {
        .whitepre-couple-grid {
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
        }

        .whitepre-couple-ampersand {
            padding: 0 0.5rem;
        }

        .whitepre-mobile-nav {
            display: none !important;
        }
    }

    @media (max-width: 1023px) {
        .whitepre-left-panel {
            display: none;
        }

        .whitepre-content-panel {
            width: 100%;
            margin-left: 0;
        }

        .whitepre-side-nav {
            display: none !important;
        }
    }

    @media (max-width: 380px) {
        .whitepre-countdown {
            gap: 0.3rem;
        }

        .whitepre-countdown-item {
            padding-inline: 0.15rem;
        }

        .whitepre-countdown-label {
            font-size: 0.55rem;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        html { scroll-behavior: auto; }
        .whitepre-scroll-mouse::after { animation: none; }
        .whitepre-gallery-grid img,
        .whitepre-side-nav .nav-link,
        .whitepre-calendar-button,
        .whitepre-map-button,
        .whitepre-submit-button { transition: none; }
    }
</style>
