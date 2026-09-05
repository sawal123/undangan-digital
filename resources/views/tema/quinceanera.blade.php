<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    @php
        use Carbon\Carbon;

        Carbon::setLocale('id');

        $birthday = $data->birthdayProfile;
        $birthdayName = $birthday?->name ?? $data->title ?? 'Quinceañera';
        $birthdayNickname = $birthday?->nickname ?? $birthdayName;
        $birthdayAge = $birthday?->age;
        $birthdayPhoto = $storageUrl = null;
        $storageUrl = fn($path) => $path ? asset('storage/' . ltrim($path, '/')) : null;
        $birthdayPhoto = $storageUrl($birthday?->photo) ?? asset('tema/quinceanera/assets/profile-abigail.jpg');
        $firstEvent = $acara ?? $data->acara->first();
        $eventDate = $firstEvent?->date ? Carbon::parse($firstEvent->date) : null;
        $eventTime = $firstEvent?->jam_start ?: '00:00';
        $eventDateText = $eventDate ? $eventDate->translatedFormat('l, d F Y') : 'Tanggal acara';
        $eventDayMonth = $eventDate ? $eventDate->translatedFormat('d F Y') : '';
        $countdownDate = $eventDate
            ? Carbon::parse($firstEvent->date . ' ' . $eventTime)->format('Y-m-d\TH:i:s')
            : now()->format('Y-m-d\TH:i:s');
        $coverImage =
            $storageUrl($data->coverUndangan?->cover_satu) ??
            ((count($poto ?? []) ? $storageUrl($poto[0]) : null) ??
                asset('tema/quinceanera/assets/hero-abigail.jpg'));
        $heroImage =
            $storageUrl($data->coverUndangan?->cover_dua) ??
            ((count($poto ?? []) > 1 ? $storageUrl($poto[1]) : null) ??
                $coverImage);
        $pageTitle = ($data->eventDetail?->headline ?? 'Mis Quince Años') . ' ' . $birthdayNickname;
        $dressCode = $data->eventDetail?->dress_code;
    @endphp
    <title>{{ $pageTitle }}</title>
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#f7e6e4">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:site_name" content="Wayae Nikah">
    <meta property="og:title" content="{{ $data->title ?? $pageTitle }}">
    <meta property="og:description" content="Acara akan dilaksanakan pada {{ $eventDateText }}.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    @include('components.social-preview-meta', ['data' => $data, 'title' => $data->title ?? $pageTitle])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Great+Vibes&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --pink: #df747a;
            --pink-2: #ef9ca0;
            --pink-3: #f8d7d7;
            --rose: #b85c63;
            --paper: #fffaf6;
            --paper-2: #faeeeb;
            --gold: #c6a052;
            --ink: #5b4042;
            --muted: #8b7172;
            --shadow: 0 20px 45px rgba(101, 54, 59, .16);
            --radius: 28px;
            --script: "Great Vibes", cursive;
            --serif: "Cormorant Garamond", serif;
            --sans: "Montserrat", sans-serif;
        }
        * {
            box-sizing: border-box;
        }
        html {
            scroll-behavior: smooth;
        }
        body {
            margin: 0;
            background:
                radial-gradient(circle at 15% 12%, rgba(255, 255, 255, .7), transparent 24rem),
                linear-gradient(135deg, #e6c7c5, #f1ddda 46%, #d9b8b6);
            color: var(--ink);
            font-family: var(--serif);
            overflow-x: hidden;
        }
        body.lock {
            overflow: hidden;
        }
        a {
            color: inherit;
        }
        .site {
            position: relative;
            max-width: 560px;
            margin: 0 auto;
            background:
                linear-gradient(rgba(255, 250, 246, .96), rgba(255, 247, 243, .98)),
                repeating-linear-gradient(105deg, rgba(169, 96, 100, .035) 0 1px, transparent 1px 5px);
            min-height: 100vh;
            overflow: hidden;
            box-shadow: 0 0 75px rgba(91, 64, 66, .25);
        }
        .progress {
            position: fixed;
            z-index: 99;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: min(560px, 100%);
            height: 4px;
            background: rgba(255, 255, 255, .48);
        }
        .progress span {
            display: block;
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, var(--gold), var(--pink));
        }
        .cover {
            position: fixed;
            z-index: 120;
            inset: 0;
            display: grid;
            place-items: center;
            padding: 20px;
            background: linear-gradient(180deg, #f1d9d6, #d7b6b3);
            transition: .8s cubic-bezier(.2, .8, .2, 1);
        }
        .cover.hide {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-4%);
        }
        .cover-card {
            position: relative;
            width: min(450px, 100%);
            min-height: 720px;
            border-radius: 34px;
            overflow: hidden;
            box-shadow: 0 35px 90px rgba(66, 33, 36, .32);
            background: #fff7f4;
            display: flex;
            align-items: flex-end;
        }
        .cover-card:before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(255, 247, 244, .03), rgba(255, 247, 244, .18) 45%, rgba(255, 247, 244, .94) 74%),
                url("{{ $coverImage }}") center 22%/cover no-repeat;
            transform: scale(1.03);
        }
        .cover-floral {
            position: absolute;
            width: 250px;
            z-index: 2;
            pointer-events: none;
        }
        .cover-floral.a {
            left: -55px;
            bottom: -38px;
        }
        .cover-floral.b {
            right: -58px;
            top: -38px;
            transform: rotate(180deg);
        }
        .cover-content {
            position: relative;
            z-index: 3;
            text-align: center;
            width: 100%;
            padding: 44px 32px 42px;
        }
        .kicker {
            font: 600 11px/1.4 var(--sans);
            letter-spacing: .26em;
            text-transform: uppercase;
            color: var(--rose);
        }
        .cover h1,
        .hero h1,
        .closing h2 {
            font: 400 clamp(58px, 15vw, 88px)/.85 var(--script);
            color: #d95e66;
            margin: 14px 0;
        }
        .cover .guest {
            font: 600 13px var(--sans);
            letter-spacing: .04em;
            color: var(--ink);
        }
        .btn {
            border: 0;
            cursor: pointer;
            border-radius: 999px;
            padding: 15px 24px;
            background: linear-gradient(135deg, #df747a, #cc5e68);
            color: white;
            font: 600 12px var(--sans);
            letter-spacing: .04em;
            box-shadow: 0 10px 20px rgba(200, 83, 94, .25);
            transition: .25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            text-decoration: none;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 26px rgba(200, 83, 94, .3);
        }
        .btn.alt {
            background: #fff;
            color: var(--rose);
            border: 1px solid rgba(201, 111, 117, .35);
            box-shadow: none;
        }
        .music {
            position: fixed;
            z-index: 90;
            right: max(calc((100vw - 560px)/2 + 14px), 14px);
            top: 18px;
            width: 43px;
            height: 43px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .9);
            background: rgba(255, 250, 246, .82);
            backdrop-filter: blur(12px);
            color: var(--rose);
            display: grid;
            place-items: center;
            box-shadow: 0 8px 20px rgba(91, 64, 66, .13);
            cursor: pointer;
        }
        .music.playing {
            animation: pulse 1.8s infinite;
        }
        .music svg {
            width: 18px;
        }
        @keyframes pulse {
            50% {
                box-shadow: 0 0 0 8px rgba(223, 116, 122, .11), 0 8px 20px rgba(91, 64, 66, .13);
            }
        }
        .hero {
            position: relative;
            min-height: 100svh;
            display: grid;
            align-content: center;
            text-align: center;
            padding: 90px 28px 60px;
            background:
                linear-gradient(180deg, rgba(255, 250, 246, .92), rgba(255, 247, 243, .62) 48%, rgba(255, 250, 246, .98)),
                url("{{ $heroImage }}") center/cover no-repeat;
        }
        .hero:after {
            content: "";
            position: absolute;
            inset: auto 0 0;
            height: 150px;
            background: linear-gradient(transparent, #fffaf6);
        }
        .tiara {
            width: 108px;
            margin: 0 auto -8px;
            filter: drop-shadow(0 7px 12px rgba(184, 92, 99, .13));
        }
        .hero-copy {
            position: relative;
            z-index: 2;
        }
        .hero h1 {
            font-size: 82px;
        }
        .hero .date {
            font: 600 13px var(--sans);
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--gold);
        }
        .hero p {
            font-size: 20px;
            margin: 12px auto 20px;
            max-width: 360px;
        }
        .heart-date {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
            font: 600 14px var(--sans);
            color: var(--rose);
        }
        .heart-date b {
            width: 42px;
            height: 42px;
            border: 1px solid rgba(223, 116, 122, .45);
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: #fff8f4;
        }
        .scroll-note {
            font: 500 10px var(--sans);
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--muted);
            margin-top: 34px;
        }
        section {
            position: relative;
            padding: 84px 24px;
        }
        .soft {
            background: linear-gradient(180deg, #fffaf6, #f9ebe8);
        }
        .section-title {
            text-align: center;
            margin-bottom: 34px;
        }
        .section-title .small {
            font: 600 10px var(--sans);
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--gold);
        }
        .section-title h2 {
            font: 400 52px/1 var(--script);
            color: var(--rose);
            margin: 7px 0 4px;
        }
        .section-title p {
            margin: 0;
            color: var(--muted);
            font-size: 16px;
        }
        .divider {
            width: 210px;
            margin: 8px auto 0;
            display: block;
        }
        .card {
            background: rgba(255, 253, 250, .91);
            border: 1px solid rgba(198, 160, 82, .38);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        .profile-card {
            padding: 20px;
            text-align: center;
        }
        .profile-img {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 8px solid #fff;
            outline: 1px solid rgba(198, 160, 82, .48);
            box-shadow: 0 14px 28px rgba(91, 64, 66, .16);
        }
        .profile-card h3 {
            font: 400 44px var(--script);
            color: var(--rose);
            margin: 14px 0 0;
        }
        .profile-card p {
            max-width: 370px;
            margin: 8px auto 12px;
            font-size: 17px;
            line-height: 1.55;
        }
        .parents {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 18px;
        }
        .parent {
            padding: 15px 10px;
            border-radius: 18px;
            background: #fff7f4;
            border: 1px solid rgba(223, 116, 122, .18);
        }
        .parent .icon {
            font-size: 24px;
        }
        .parent b {
            display: block;
            font-family: var(--sans);
            font-size: 11px;
            margin-top: 8px;
        }
        .parent span {
            font-size: 15px;
        }
        .countdown {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-top: 20px;
        }
        .timebox {
            padding: 15px 6px;
            background: rgba(255, 251, 247, .92);
            border: 1px solid rgba(198, 160, 82, .42);
            border-radius: 14px;
        }
        .timebox strong {
            display: block;
            color: #b68e32;
            font: 500 28px var(--serif);
        }
        .timebox span {
            font: 500 8px var(--sans);
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--muted);
        }
        .events {
            display: grid;
            gap: 18px;
        }
        .event {
            padding: 26px 22px;
            text-align: center;
        }
        .event-icon {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            margin: 0 auto 12px;
            display: grid;
            place-items: center;
            background: #fff1ee;
            color: var(--rose);
            border: 1px solid rgba(223, 116, 122, .24);
        }
        .event-icon svg {
            width: 28px;
        }
        .event h3 {
            font: 400 38px var(--script);
            color: var(--rose);
            margin: 0;
        }
        .event .meta {
            font: 600 11px var(--sans);
            line-height: 1.8;
            color: var(--ink);
            margin: 10px 0 14px;
        }
        .event address {
            font-style: normal;
            color: var(--muted);
            font-size: 16px;
            line-height: 1.45;
            margin-bottom: 16px;
        }
        .dress {
            padding: 28px;
            text-align: center;
        }
        .dress-figure {
            display: flex;
            justify-content: center;
            gap: 24px;
            font-size: 74px;
            filter: saturate(.65);
        }
        .dress h3 {
            font: 400 44px var(--script);
            color: var(--rose);
            margin: 4px 0;
        }
        .swatches {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 18px;
        }
        .swatches i {
            width: 31px;
            height: 31px;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0 0 1px rgba(80, 50, 52, .13);
        }
        .gallery {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .gallery figure {
            margin: 0;
            border-radius: 22px;
            overflow: hidden;
            min-height: 180px;
            box-shadow: 0 10px 25px rgba(91, 64, 66, .12);
        }
        .gallery figure:first-child,
        .gallery figure:last-child {
            grid-column: 1/-1;
        }
        .gallery img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: .6s ease;
            cursor: pointer;
        }
        .gallery figure:hover img {
            transform: scale(1.045);
        }
        .gift {
            padding: 28px;
            text-align: center;
        }
        .gift .big-icon {
            font-size: 46px;
        }
        .gift h3 {
            font: 400 43px var(--script);
            color: var(--rose);
            margin: 6px 0;
        }
        .bank {
            margin: 18px 0 0;
            padding: 16px;
            border: 1px dashed rgba(198, 160, 82, .58);
            border-radius: 17px;
            background: #fff9f4;
        }
        .bank b {
            font: 700 12px var(--sans);
            display: block;
            color: var(--rose);
        }
        .bank .num {
            font: 600 22px var(--serif);
            letter-spacing: .08em;
            margin: 5px 0;
        }
        .bank small {
            color: var(--muted);
        }
        .rsvp {
            padding: 28px;
        }
        .form {
            display: grid;
            gap: 12px;
        }
        .field {
            display: grid;
            gap: 6px;
        }
        .field label {
            font: 600 10px var(--sans);
            text-transform: uppercase;
            letter-spacing: .12em;
            color: var(--rose);
        }
        .field input,
        .field select,
        .field textarea {
            width: 100%;
            border: 1px solid rgba(184, 92, 99, .2);
            background: #fffaf7;
            border-radius: 14px;
            padding: 14px 15px;
            font: 500 13px var(--sans);
            outline: none;
            color: var(--ink);
        }
        .field textarea {
            min-height: 100px;
            resize: vertical;
        }
        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            border-color: rgba(223, 116, 122, .7);
            box-shadow: 0 0 0 4px rgba(223, 116, 122, .08);
        }
        .wish-alert {
            border-radius: 22px;
            padding: 12px 14px;
            margin-bottom: 14px;
            display: none;
            font-size: 0.9rem;
            text-align: left;
        }
        .wish-alert.success {
            background: #eef8ed;
            border: 1px solid #a9d8a2;
            color: #2f6b2f;
        }
        .wish-alert.error {
            background: #fff0ee;
            border: 1px solid #e7a59b;
            color: #a33d2f;
        }
        .messages {
            display: grid;
            gap: 12px;
        }
        .message {
            padding: 17px 18px;
        }
        .message .top {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: #f6d5d4;
            color: var(--rose);
            font: 700 13px var(--sans);
        }
        .message b {
            font: 700 11px var(--sans);
        }
        .message small {
            display: block;
            color: var(--muted);
            font: 500 9px var(--sans);
            margin-top: 2px;
        }
        .message p {
            font-size: 15px;
            line-height: 1.5;
            margin: 10px 0 0;
        }
        .share {
            padding: 26px;
            text-align: center;
        }
        .share h3 {
            font: 400 40px var(--script);
            color: var(--rose);
            margin: 0 0 8px;
        }
        .share-actions {
            display: flex;
            justify-content: center;
            gap: 9px;
            flex-wrap: wrap;
        }
        .closing {
            text-align: center;
            padding: 100px 24px 120px;
            background:
                linear-gradient(180deg, rgba(255, 250, 246, .97), rgba(251, 236, 232, .85)),
                url("{{ $heroImage }}") center/cover no-repeat;
        }
        .closing h2 {
            font-size: 78px;
        }
        .closing p {
            font-size: 18px;
        }
        .mini-tiara {
            width: 70px;
        }
        .floral {
            position: absolute;
            width: 190px;
            opacity: .75;
            pointer-events: none;
            z-index: 0;
        }
        .floral.left {
            left: -72px;
            top: 20px;
        }
        .floral.right {
            right: -72px;
            top: 18px;
            transform: rotate(90deg);
        }
        .butterfly {
            position: absolute;
            width: 58px;
            pointer-events: none;
            filter: drop-shadow(0 5px 10px rgba(184, 92, 99, .14));
        }
        .butterfly.one {
            right: 22px;
            top: 62px;
            animation: floaty 5s ease-in-out infinite;
        }
        .butterfly.two {
            left: 20px;
            bottom: 70px;
            animation: floaty 6s ease-in-out infinite reverse;
        }
        @keyframes floaty {
            50% {
                transform: translateY(-12px) rotate(5deg);
            }
        }
        .petals {
            position: fixed;
            z-index: 70;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            max-width: 560px;
            margin: auto;
        }
        .petal {
            position: absolute;
            top: -30px;
            width: 12px;
            height: 18px;
            border-radius: 70% 30% 70% 30%;
            background: linear-gradient(135deg, #f3b9bd, #e6858c);
            opacity: .6;
            animation: fall linear infinite;
        }
        @keyframes fall {
            to {
                transform: translate3d(var(--drift), 110vh, 0) rotate(540deg);
            }
        }
        .reveal {
            opacity: 0;
            transform: translateY(26px);
            transition: opacity .8s ease, transform .8s cubic-bezier(.2, .8, .2, 1);
        }
        .reveal.show {
            opacity: 1;
            transform: none;
        }
        .reveal-left {
            opacity: 0;
            transform: translateX(-34px);
            transition: .85s ease;
        }
        .reveal-left.show {
            opacity: 1;
            transform: none;
        }
        .reveal-right {
            opacity: 0;
            transform: translateX(34px);
            transition: .85s ease;
        }
        .reveal-right.show {
            opacity: 1;
            transform: none;
        }
        .zoom {
            opacity: 0;
            transform: scale(.93);
            transition: .85s ease;
        }
        .zoom.show {
            opacity: 1;
            transform: none;
        }
        .toast {
            position: fixed;
            z-index: 150;
            left: 50%;
            bottom: 86px;
            transform: translate(-50%, 20px);
            background: #5f4043;
            color: #fff;
            border-radius: 999px;
            padding: 11px 17px;
            font: 600 10px var(--sans);
            opacity: 0;
            pointer-events: none;
            transition: .25s;
        }
        .toast.show {
            opacity: 1;
            transform: translate(-50%, 0);
        }
        .bottom-nav {
            position: fixed;
            z-index: 80;
            left: 50%;
            bottom: 14px;
            transform: translateX(-50%);
            display: flex;
            gap: 6px;
            padding: 7px;
            border-radius: 999px;
            background: rgba(255, 250, 246, .82);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, .8);
            box-shadow: 0 10px 28px rgba(91, 64, 66, .18);
        }
        .bottom-nav a {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            text-decoration: none;
            color: var(--rose);
            font-size: 17px;
        }
        .bottom-nav a:hover {
            background: #f6ddda;
        }
        .lightbox {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 180;
            visibility: hidden;
            opacity: 0;
            transition: .25s;
        }
        .lightbox.active {
            visibility: visible;
            opacity: 1;
        }
        .lightbox img {
            max-width: 90%;
            max-height: 80%;
            border-radius: 16px;
        }
        @media (min-width:780px) {
            body {
                padding: 30px 0;
            }
            .site {
                border-radius: 34px;
                min-height: calc(100vh - 60px);
            }
            .progress {
                top: 30px;
                border-radius: 999px;
            }
            .music {
                top: 48px;
            }
            .bottom-nav {
                bottom: 28px;
            }
        }
        @media (max-width:390px) {
            section {
                padding-left: 18px;
                padding-right: 18px;
            }
            .countdown {
                gap: 5px;
            }
            .timebox strong {
                font-size: 24px;
            }
            .hero h1 {
                font-size: 70px;
            }
            .cover-card {
                min-height: 660px;
            }
        }
        @media (prefers-reduced-motion:reduce) {
            * {
                scroll-behavior: auto !important;
            }
            .reveal,
            .reveal-left,
            .reveal-right,
            .zoom {
                opacity: 1;
                transform: none;
                transition: none;
            }
            .petal,
            .butterfly {
                animation: none !important;
            }
        }
    </style>
</head>

<body class="lock">
    <div class="progress"><span id="progressBar"></span></div>
    <div class="petals" id="petalLayer"></div>
    <div class="toast" id="toast">Berhasil</div>

    <div class="cover" id="cover">
        <div class="cover-card">
            <img class="cover-floral a" src="{{ asset('tema/quinceanera/assets/floral-corner.svg') }}" alt="">
            <img class="cover-floral b" src="{{ asset('tema/quinceanera/assets/floral-corner.svg') }}" alt="">
            <div class="cover-content">
                <div class="kicker">{{ $data->eventDetail?->headline ?? 'Mis Quince Años' }}</div>
                <h1>{{ $birthdayNickname }}</h1>
                <div class="guest">Kepada Yth.<br><strong id="guestName">{{ $tamu }}</strong></div>
                <p>{{ $data->eventDetail?->description ?? 'Dengan penuh sukacita, kami mengundang Anda untuk merayakan hari istimewa bersama kami.' }}</p>
                <button class="btn" id="openInvitation">✉ Buka Undangan</button>
            </div>
        </div>
    </div>

    <div class="site">
        @if ($data->sound?->isActive && $data->sound?->sound && $data->sound?->sound !== 'null')
            <button class="music" id="musicToggle" aria-label="Putar musik" title="Musik">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 18V5l10-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="16" cy="16" r="3"/></svg>
            </button>
            @include('tema.partials.music', ['data' => $data])
        @endif

        <header class="hero" id="home">
            <img class="floral left" src="{{ asset('tema/quinceanera/assets/floral-corner.svg') }}" alt="">
            <img class="floral right" src="{{ asset('tema/quinceanera/assets/floral-corner.svg') }}" alt="">
            <img class="butterfly one" src="{{ asset('tema/quinceanera/assets/butterfly.svg') }}" alt="">
            <div class="hero-copy reveal">
                <img class="tiara" src="{{ asset('tema/quinceanera/assets/tiara.svg') }}" alt="">
                <div class="kicker">{{ $data->teksUndangan?->pembuka ?? 'Aku mengundangmu ke' }}</div>
                <h1>{{ $birthdayNickname }}</h1>
                <div class="date">{{ $data->eventDetail?->headline ?? 'Mis Quince Años' }} · Sweet Fifteen</div>
                <p>{{ $data->eventDetail?->description ?? 'Datang dan rayakan babak baru yang penuh sukacita, keluarga, persahabatan, dan kenangan indah.' }}</p>
                <div class="heart-date"><span>{{ $eventDate?->translatedFormat('l') ?? 'Sabtu' }}</span><b>{{ $eventDate?->format('d') ?? '23' }}</b><span>{{ $eventDate?->translatedFormat('F Y') ?? 'September 2028' }}</span></div>
                <div class="scroll-note">Scroll untuk melihat detail ↓</div>
            </div>
        </header>

        <main>
            <section class="soft" id="story">
                <img class="butterfly two" src="{{ asset('tema/quinceanera/assets/butterfly.svg') }}" alt="">
                <div class="section-title reveal">
                    <span class="small">Hello!</span>
                    <h2>Hari Istimewaku</h2>
                    <p>{{ $data->eventDetail?->description ?? 'Satu hari untuk merayakan tumbuh, bermimpi, dan bersyukur.' }}</p>
                    <img class="divider" src="{{ asset('tema/quinceanera/assets/divider.svg') }}" alt="">
                </div>
                <div class="card profile-card zoom">
                    <img class="profile-img" src="{{ $birthdayPhoto }}" alt="Foto {{ $birthdayNickname }}">
                    <h3>{{ $birthdayNickname }}</h3>
                    <p>{{ $birthday?->description ?? ($data->teksUndangan?->acara ?? 'Hari ini aku meninggalkan masa kecil untuk memulai babak baru. Terima kasih telah menjadi bagian dari perjalanan dan kenangan yang akan selalu aku simpan.') }}</p>
                    <div class="parents">
                        <div class="parent"><div class="icon">🎩</div><b>PAPA</b><span>{{ $birthday?->parent_name ? explode(',', $birthday->parent_name)[0] ?? $birthday->parent_name : 'Keluarga' }}</span></div>
                        <div class="parent"><div class="icon">🌷</div><b>MAMA</b><span>{{ $birthday?->parent_name ? (explode(',', $birthday->parent_name)[1] ?? explode(',', $birthday->parent_name)[0]) : 'Keluarga' }}</span></div>
                    </div>
                </div>
                <div class="countdown reveal" id="countdown" data-target="{{ $countdownDate }}">
                    <div class="timebox"><strong id="days">00</strong><span>Hari</span></div>
                    <div class="timebox"><strong id="hours">00</strong><span>Jam</span></div>
                    <div class="timebox"><strong id="minutes">00</strong><span>Menit</span></div>
                    <div class="timebox"><strong id="seconds">00</strong><span>Detik</span></div>
                </div>
            </section>

            @if ($data->acara->isNotEmpty())
                <section id="event">
                    <div class="section-title reveal">
                        <span class="small">Save the date</span>
                        <h2>Detail Acara</h2>
                        <p>Kehadiran Anda akan membuat hari ini semakin berarti.</p>
                        <img class="divider" src="{{ asset('tema/quinceanera/assets/divider.svg') }}" alt="">
                    </div>
                    <div class="events">
                        @foreach ($data->acara as $item)
                            <article class="card event {{ $loop->even ? 'reveal-left' : 'reveal-right' }}">
                                <div class="event-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 21h18M5 21V10l7-6 7 6v11M9 21v-6h6v6M9 10h6"/></svg></div>
                                <h3>{{ $item->nama_acara }}</h3>
                                <div class="meta">
                                    {{ $item->date ? Carbon::parse($item->date)->translatedFormat('l, d F Y') : 'Tanggal belum ditentukan' }}
                                    <br>{{ $item->jam_start }} {{ $item->zona_waktu }}
                                    @if ($item->jam_end === 'Selesai')
                                        s/d Selesai
                                    @else
                                        s/d {{ $item->jam_end }} {{ $item->zona_waktu }}
                                    @endif
                                </div>
                                <address>{{ $item->vanue }}<br>{{ $item->alamat }}</address>
                                @if ($item->maps)
                                    <a class="btn" href="{{ $item->maps }}" target="_blank" rel="noopener">⌖ Lihat Lokasi</a>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($dressCode)
                <section class="soft" id="dresscode">
                    <div class="section-title reveal">
                        <span class="small">Dress code</span>
                        <h2>Formal & Elegant</h2>
                        <p>Kenakan pakaian terbaik Anda dengan sentuhan warna lembut.</p>
                    </div>
                    <div class="card dress zoom">
                        <div class="dress-figure"><span>🤵🏻</span><span>👗</span></div>
                        <h3>Formal</h3>
                        <p>{{ $dressCode }}</p>
                    </div>
                </section>
            @endif

            @if ($poto || $video)
                <section id="gallery">
                    <div class="section-title reveal">
                        <span class="small">Memories</span>
                        <h2>Galeri Foto</h2>
                        <p>Beberapa potret untuk mengabadikan momen istimewa.</p>
                        <img class="divider" src="{{ asset('tema/quinceanera/assets/divider.svg') }}" alt="">
                    </div>
                    @if ($video)
                        <div class="card event reveal" style="padding:12px;">
                            <iframe src="{{ $video[0] }}" style="width:100%; height:240px; border:0; border-radius:18px;" title="Video Galeri"></iframe>
                        </div>
                    @endif
                    <div class="gallery" style="margin-top:{{ $video ? '14px' : '0' }}">
                        @foreach ($poto as $po)
                            <figure class="reveal"><img src="{{ $storageUrl($po) }}" class="gallery-img" alt="Galeri" loading="lazy"></figure>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($data->streaming?->isActive && $data->streaming?->link)
                <section class="soft" id="streaming">
                    <div class="section-title reveal">
                        <span class="small">Live Streaming</span>
                        <h2>Siaran Langsung</h2>
                        <p>Turut hadir secara virtual melalui siaran langsung kami.</p>
                    </div>
                    <div class="card gift zoom">
                        <div class="big-icon">📺</div>
                        <h3>Live Streaming</h3>
                        <p>Tonton momen spesial kami secara langsung.</p>
                        <div class="share-actions">
                            <a class="btn" href="{{ $data->streaming->link }}" target="_blank" rel="noopener">▶ Tonton Streaming</a>
                        </div>
                    </div>
                </section>
            @endif

            @if ($data->fiturKado?->isActive && $data->kado?->isNotEmpty())
                <section id="gift">
                    <div class="section-title reveal">
                        <span class="small">Optional</span>
                        <h2>Gift</h2>
                        <p>Doa dan kehadiran Anda adalah hadiah terbaik.</p>
                    </div>
                    <div class="card gift zoom">
                        <div class="big-icon">🎁</div>
                        <h3>Hadiah Digital</h3>
                        <p>Bila ingin memberikan tanda kasih, Anda dapat menggunakan informasi berikut.</p>
                        @foreach ($data->kado as $gift)
                            <div class="bank">
                                <b>{{ $gift->giftPay?->nama_pay ?? 'Transfer Bank' }}</b>
                                <div class="num">{{ $gift->nomorPay }}</div>
                                <small>a.n. {{ $gift->namaPay }}</small><br><br>
                                @if ($gift->nomorPay)
                                    <button class="btn alt copy-btn" data-copy="{{ $gift->nomorPay }}">Salin Nomor Rekening</button>
                                @endif
                                @if ($gift->qris)
                                    <img src="{{ $storageUrl($gift->qris) }}" alt="QRIS" style="display:block; max-width:180px; width:100%; margin:14px auto 0; border-radius:20px;">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($data->FiturUcapan?->isActive)
                <section class="soft" id="rsvp">
                    <div class="section-title reveal">
                        <span class="small">RSVP & wishes</span>
                        <h2>Konfirmasi Kehadiran</h2>
                        <p>Mohon konfirmasi dan tinggalkan ucapan terbaik Anda.</p>
                        <img class="divider" src="{{ asset('tema/quinceanera/assets/divider.svg') }}" alt="">
                    </div>
                    <div class="card rsvp reveal">
                        <div id="wishAlert" class="wish-alert"></div>
                        @if ($data->FiturUcapan?->publicIsActive || $kode)
                            <form class="form" id="rsvpForm" action="{{ route('savedoa') }}" method="post">
                                @csrf
                                <input type="hidden" name="dataId" value="{{ $data->id }}">
                                <input type="hidden" name="kode" value="{{ $kode }}">
                                <div class="field"><label>Nama</label><input type="text" name="nama" required placeholder="Nama Anda" value="{{ old('nama', $tamu) }}"></div>
                                <div class="field"><label>Kehadiran</label><select name="status" required>
                                    <option value="hadir" @selected(old('status') === 'hadir')>Hadir</option>
                                    <option value="tidak_hadir" @selected(old('status') === 'tidak_hadir')>Tidak dapat hadir</option>
                                    <option value="ragu" @selected(old('status') === 'ragu')>Masih tentatif</option>
                                </select></div>
                                <div class="field"><label>Ucapan</label><textarea name="ucapan" required placeholder="Tulis doa atau ucapan...">{{ old('ucapan') }}</textarea></div>
                                <button class="btn" type="submit">♡ Kirim Konfirmasi</button>
                            </form>
                        @else
                            <p style="color:var(--muted); text-align:center;">Form ucapan hanya tersedia untuk tamu yang menerima tautan undangan.</p>
                        @endif
                    </div>
                </section>
            @endif

            @if ($data->FiturUcapan?->isActive && $data->FiturUcapan?->viewIsActive)
                <section class="soft" id="messages">
                    <div class="section-title reveal"><span class="small">Guest book</span><h2>Ucapan Terbaru</h2></div>
                    <div class="messages" id="messageList">
                        @forelse ($ucapan as $item)
                            <article class="card message reveal">
                                <div class="top"><div class="avatar">{{ strtoupper(substr($item->tamu?->nama ?? 'T', 0, 1)) }}</div><div><b>{{ $item->tamu?->nama ?? 'Tamu' }}</b><small>{{ $item->status }} · {{ $item->created_at?->diffForHumans() }}</small></div></div>
                                <p>{{ $item->ucapan }}</p>
                                @if ($item->balas)
                                    <div style="margin-top:10px; background:#fff; border-radius:18px; padding:10px; font-size:0.9rem;"><strong>Balasan:</strong> {{ $item->balas }}</div>
                                @endif
                            </article>
                        @empty
                            <article class="card message reveal"><p style="text-align:center; color:var(--muted)">Belum ada ucapan yang dikirim.</p></article>
                        @endforelse
                    </div>
                </section>
            @endif

            @if ($data->teksPenutup?->mengundang)
                <section id="turut-mengundang">
                    <div class="section-title reveal">
                        <span class="small">Turut Mengundang</span>
                        <h2>Keluarga Besar</h2>
                    </div>
                    <div class="card gift zoom">
                        <p style="font-size:18px; line-height:1.6; margin:0">{!! nl2br(e($data->teksPenutup->mengundang)) !!}</p>
                    </div>
                </section>
            @endif

            <section id="share">
                <div class="card share reveal">
                    <h3>Bagikan Undangan</h3>
                    <p>Kirimkan tautan undangan ini kepada keluarga dan sahabat.</p>
                    <div class="share-actions">
                        <button class="btn" id="shareBtn">↗ Bagikan</button>
                        <button class="btn alt" id="copyLink">🔗 Salin Link</button>
                    </div>
                </div>
            </section>

            <section class="closing">
                <img class="mini-tiara reveal" src="{{ asset('tema/quinceanera/assets/tiara.svg') }}" alt="">
                <div class="kicker reveal">{{ $data->teksUndangan?->penutup ?? 'Dengan penuh cinta' }}</div>
                <h2 class="reveal">{{ $birthdayNickname }}</h2>
                <p class="reveal">{{ $data->eventDetail?->host_name ? 'Terima kasih telah menjadi bagian dari hari spesial ' . $birthdayNickname . ' yang dipersembahkan oleh ' . $data->eventDetail->host_name . '.' : 'Terima kasih telah menjadi bagian dari hari yang tak terlupakan ini.' }}</p>
                <div class="footer-note" style="font:600 11px var(--sans); letter-spacing:.16em; color:var(--rose); text-transform:uppercase;">{{ $birthdayNickname }} · {{ $eventDayMonth }}</div>
            </section>
        </main>
    </div>

    <nav class="bottom-nav" aria-label="Navigasi cepat">
        <a href="#home" title="Beranda">⌂</a>
        @if ($data->acara->isNotEmpty())
            <a href="#event" title="Acara">◷</a>
        @endif
        @if ($poto || $video)
            <a href="#gallery" title="Galeri">▣</a>
        @endif
        @if ($data->FiturUcapan?->isActive)
            <a href="#rsvp" title="RSVP">✉</a>
        @endif
    </nav>

    <div class="lightbox" id="lightbox"><img id="lightboxImg" src="" alt="Galeri"><span style="position:absolute; top:20px; right:30px; color:white; font-size:32px; cursor:pointer" id="closeLightbox">&times;</span></div>

    <script>
        (function() {
            const body = document.body;
            const cover = document.getElementById('cover');
            const openBtn = document.getElementById('openInvitation');
            const toast = document.getElementById('toast');
            const petalLayer = document.getElementById('petalLayer');
            const progressBar = document.getElementById('progressBar');

            function showToast(msg) {
                toast.textContent = msg;
                toast.classList.add('show');
                clearTimeout(window.__toast);
                window.__toast = setTimeout(() => toast.classList.remove('show'), 1800);
            }

            function openInvitation() {
                cover.classList.add('hide');
                body.classList.remove('lock');
                if (window.musicPlayer) window.musicPlayer.play();
                setTimeout(() => cover.remove(), 900);
            }
            if (openBtn) openBtn.addEventListener('click', openInvitation);

            window.addEventListener('scroll', () => {
                const doc = document.documentElement;
                const max = doc.scrollHeight - innerHeight;
                progressBar.style.width = (max ? (scrollY / max) * 100 : 0) + '%';
                document.querySelectorAll('.floral').forEach((el, i) => {
                    el.style.translate = '0 ' + (scrollY * (i ? -0.025 : 0.018)) + 'px';
                });
            }, { passive: true });

            const io = new IntersectionObserver((entries) => {
                entries.forEach((e, i) => {
                    if (e.isIntersecting) {
                        e.target.style.transitionDelay = Math.min(i * 50, 180) + 'ms';
                        e.target.classList.add('show');
                        io.unobserve(e.target);
                    }
                });
            }, { threshold: .12, rootMargin: '0px 0px -40px' });
            document.querySelectorAll('.reveal,.reveal-left,.reveal-right,.zoom').forEach(el => io.observe(el));

            for (let i = 0; i < 15; i++) {
                const p = document.createElement('span');
                p.className = 'petal';
                p.style.left = Math.random() * 100 + '%';
                p.style.animationDuration = 8 + Math.random() * 10 + 's';
                p.style.animationDelay = -Math.random() * 16 + 's';
                p.style.setProperty('--drift', (Math.random() * 140 - 70) + 'px');
                p.style.transform = 'scale(' + (0.55 + Math.random() * 0.75) + ')';
                petalLayer.appendChild(p);
            }

            const countdown = document.getElementById('countdown');
            const targetDate = countdown ? new Date(countdown.dataset.target).getTime() : 0;
            function setText(id, value) {
                const el = document.getElementById(id);
                if (el) el.textContent = String(value).padStart(2, '0');
            }
            function updateCountdown() {
                const diff = Math.max(0, targetDate - Date.now());
                setText('days', Math.floor(diff / 86400000));
                setText('hours', Math.floor((diff % 86400000) / 3600000));
                setText('minutes', Math.floor((diff % 3600000) / 60000));
                setText('seconds', Math.floor((diff % 60000) / 1000));
            }
            if (countdown) { updateCountdown(); setInterval(updateCountdown, 1000); }

            document.querySelectorAll('.copy-btn').forEach(btn => btn.addEventListener('click', async () => {
                await navigator.clipboard.writeText(btn.dataset.copy);
                showToast('Nomor rekening disalin');
            }));

            const copyLink = document.getElementById('copyLink');
            if (copyLink) copyLink.addEventListener('click', async () => {
                await navigator.clipboard.writeText(location.href);
                showToast('Link undangan disalin');
            });
            const shareBtn = document.getElementById('shareBtn');
            if (shareBtn) shareBtn.addEventListener('click', async () => {
                if (navigator.share) {
                    await navigator.share({ title: document.title, text: 'Undangan ' + document.title, url: location.href });
                } else {
                    await navigator.clipboard.writeText(location.href);
                    showToast('Link undangan disalin');
                }
            });

            const lightbox = document.getElementById('lightbox');
            document.querySelectorAll('.gallery-img').forEach(img => {
                img.addEventListener('click', (event) => {
                    document.getElementById('lightboxImg').src = event.target.src;
                    lightbox.classList.add('active');
                });
            });
            const closeLightbox = document.getElementById('closeLightbox');
            if (closeLightbox) closeLightbox.addEventListener('click', () => lightbox.classList.remove('active'));
            if (lightbox) lightbox.addEventListener('click', (event) => { if (event.target === lightbox) lightbox.classList.remove('active'); });

            function escapeHtml(value) {
                return String(value ?? '').replace(/[&<>"']/g, (char) => ({
                    '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
                } [char]));
            }

            const rsvpForm = document.getElementById('rsvpForm');
            const wishAlert = document.getElementById('wishAlert');
            function showWishAlert(type, message) {
                if (!wishAlert) return;
                wishAlert.className = 'wish-alert ' + type;
                wishAlert.textContent = message;
                wishAlert.style.display = 'block';
            }
            if (rsvpForm) {
                rsvpForm.addEventListener('submit', async (event) => {
                    event.preventDefault();
                    const submitButton = rsvpForm.querySelector('button[type="submit"]');
                    const originalText = submitButton ? submitButton.textContent : '';
                    const formData = new FormData(rsvpForm);
                    if (submitButton) { submitButton.disabled = true; submitButton.textContent = 'Mengirim...'; }
                    try {
                        const response = await fetch(rsvpForm.action, {
                            method: 'POST',
                            body: formData,
                            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        const result = await response.json();
                        if (!response.ok) {
                            const errors = result.errors ? Object.values(result.errors).flat() : [];
                            showWishAlert('error', errors[0] || result.message || 'Ucapan gagal dikirim.');
                            return;
                        }
                        showWishAlert('success', result.message || 'Ucapan doa berhasil dikirim');
                        const textarea = rsvpForm.querySelector('textarea[name="ucapan"]');
                        if (textarea) textarea.value = '';
                        const messageList = document.getElementById('messageList');
                        if (messageList && result.doa) {
                            const emptyCard = messageList.querySelector('.card.message');
                            if (emptyCard && emptyCard.textContent.includes('Belum ada ucapan')) emptyCard.remove();
                            const initials = (result.doa.nama || 'T').slice(0, 1).toUpperCase();
                            const article = document.createElement('article');
                            article.className = 'card message reveal show';
                            article.innerHTML = '<div class="top"><div class="avatar">' + escapeHtml(initials) + '</div><div><b>' + escapeHtml(result.doa.nama) + '</b><small>' + escapeHtml(result.doa.status) + ' · baru saja</small></div></div><p>' + escapeHtml(result.doa.ucapan) + '</p>';
                            messageList.prepend(article);
                        }
                    } catch (error) {
                        showWishAlert('error', 'Ucapan gagal dikirim. Silakan coba lagi.');
                    } finally {
                        if (submitButton) { submitButton.disabled = false; submitButton.textContent = originalText; }
                    }
                });
            }
        })();
    </script>
</body>

</html>
