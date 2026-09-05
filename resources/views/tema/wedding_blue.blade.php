<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    @php
        use Carbon\Carbon;

        Carbon::setLocale('id');

        $pria = $data->pria;
        $wanita = $data->wanita;
        $firstEvent = $acara ?? $data->acara->first();
        $eventDate = $firstEvent?->date ? Carbon::parse($firstEvent->date) : null;
        $eventTime = $firstEvent?->jam_start ?: '00:00';
        $eventDateText = $eventDate ? $eventDate->translatedFormat('l, d F Y') : 'Tanggal acara';
        $eventDayMonth = $eventDate ? $eventDate->translatedFormat('d F Y') : '';
        $countdownDate = $eventDate
            ? Carbon::parse($firstEvent->date . ' ' . $eventTime)->format('Y-m-d\TH:i:s')
            : now()->format('Y-m-d\TH:i:s');
        $storageUrl = fn($path) => $path ? asset('storage/' . ltrim($path, '/')) : null;
        $coverImage =
            $storageUrl($data->coverUndangan?->cover_satu) ??
            ((count($poto ?? []) ? $storageUrl($poto[0]) : null) ?? asset('tema/wedding_blue/assets/hero-couple.png'));
        $heroImage =
            $storageUrl($data->coverUndangan?->cover_dua) ??
            ((count($poto ?? []) > 1 ? $storageUrl($poto[1]) : null) ?? $coverImage);
        $priaImage = $storageUrl($pria?->image) ?? asset('tema/wedding_blue/assets/gallery-1.png');
        $wanitaImage = $storageUrl($wanita?->image) ?? asset('tema/wedding_blue/assets/gallery-2.png');
        $coupleNames = ($pria?->nama_panggilan ?? 'Mempelai') . ' & ' . ($wanita?->nama_panggilan ?? 'Mempelai');
        $pageTitle = ($data->setting?->acara ?? 'The Wedding Of') . ' ' . $coupleNames;
    @endphp
    <title>{{ $pageTitle }}</title>
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#edf1f7">
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
            --navy: #2d466f;
            --navy2: #3c5989;
            --blue: #9fb4d9;
            --blue2: #dce6f7;
            --gold: #c6ab73;
            --ink: #334052;
            --muted: #6f7f92;
            --paper: #f8fbff;
            --paper2: #eef3fb;
            --white: #ffffff;
            --shadow: 0 24px 50px rgba(46, 67, 108, .15);
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
            color: var(--ink);
            overflow-x: hidden;
            font-family: var(--serif);
            background:
                radial-gradient(circle at 15% 10%, rgba(255, 255, 255, .9), transparent 24rem),
                radial-gradient(circle at 86% 85%, rgba(210, 223, 245, .72), transparent 20rem),
                linear-gradient(160deg, #dfe8f5 0%, #f6f8fc 38%, #eef3fb 100%);
        }

        body.lock {
            overflow: hidden;
        }

        a {
            color: inherit;
        }

        .site {
            position: relative;
            max-width: 580px;
            margin: 0 auto;
            min-height: 100vh;
            overflow: hidden;
            background: linear-gradient(rgba(248, 251, 255, .985), rgba(245, 248, 252, .985));
            box-shadow: 0 0 80px rgba(52, 69, 105, .16);
        }

        .progress {
            position: fixed;
            z-index: 120;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: min(580px, 100%);
            height: 4px;
            background: rgba(255, 255, 255, .6);
        }

        .progress span {
            display: block;
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, var(--gold), var(--navy2));
        }

        .cover {
            position: fixed;
            z-index: 150;
            inset: 0;
            display: grid;
            place-items: center;
            padding: 20px;
            background: linear-gradient(180deg, #e9eff9, #d5e0f0);
            transition: .8s cubic-bezier(.2, .8, .2, 1);
        }

        .cover.hide {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-4%);
        }

        .cover-card {
            position: relative;
            width: min(460px, 100%);
            padding: 26px;
            border-radius: 34px;
            background: linear-gradient(180deg, #ffffff, #f5f8fd);
            box-shadow: 0 30px 90px rgba(45, 70, 111, .25);
            overflow: hidden;
        }

        .cover-card:before,
        .cover-card:after {
            content: "";
            position: absolute;
            pointer-events: none;
            background: url("{{ asset('tema/wedding_blue/assets/floral-corner.svg') }}") center/contain no-repeat;
            opacity: .95;
        }

        .cover-card:before {
            width: 230px;
            height: 230px;
            left: -55px;
            bottom: -30px;
        }

        .cover-card:after {
            width: 205px;
            height: 205px;
            right: -50px;
            top: -28px;
            transform: rotate(180deg);
        }

        .cover-inner {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 24px 14px 6px;
        }

        .kicker {
            font: 600 11px/1.4 var(--sans);
            letter-spacing: .3em;
            text-transform: uppercase;
            color: var(--navy2);
        }

        .cover h1,
        .hero h1,
        .closing h2 {
            font: 400 clamp(48px, 14vw, 84px)/.9 var(--script);
            color: var(--navy);
            margin: 16px 0 8px;
        }

        .cover .date,
        .hero .date {
            font: 600 13px var(--sans);
            letter-spacing: .18em;
            color: var(--gold);
            text-transform: uppercase;
        }

        .cover .guest {
            font: 600 12px/1.6 var(--sans);
            color: var(--ink);
            margin-top: 14px;
        }

        .cover .hint {
            font-size: 16px;
            max-width: 320px;
            margin: 12px auto 18px;
            color: var(--muted);
        }

        .monogram {
            width: 86px;
            margin: 0 auto 12px;
            display: block;
            filter: drop-shadow(0 8px 16px rgba(62, 89, 137, .12));
        }

        .envelope-box {
            position: relative;
            width: min(320px, 90%);
            margin: 12px auto 22px;
            padding-top: 18px;
        }

        .seal {
            position: absolute;
            z-index: 4;
            left: 50%;
            transform: translateX(-50%);
            bottom: 32px;
            width: 54px;
            height: 54px;
        }

        .envelope {
            position: relative;
            height: 188px;
            filter: drop-shadow(0 18px 26px rgba(46, 67, 108, .15));
        }

        .envelope .back {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, #f7f0e1, #efe7d5);
            border-radius: 18px;
        }

        .envelope .liner {
            position: absolute;
            left: 18px;
            right: 18px;
            top: 14px;
            height: 92px;
            border-radius: 14px 14px 4px 4px;
            background: linear-gradient(180deg, #f8fbff, #ebf2fd);
        }

        .envelope .liner:before,
        .envelope .liner:after {
            content: "";
            position: absolute;
            background: url("{{ asset('tema/wedding_blue/assets/floral-corner.svg') }}") center/contain no-repeat;
            opacity: .6;
        }

        .envelope .liner:before {
            width: 88px;
            height: 88px;
            left: -18px;
            top: -8px;
        }

        .envelope .liner:after {
            width: 82px;
            height: 82px;
            right: -18px;
            top: -12px;
            transform: rotate(180deg);
        }

        .envelope .letter {
            position: absolute;
            left: 28px;
            right: 28px;
            bottom: 50px;
            height: 118px;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 12px 26px rgba(45, 70, 111, .12);
            padding: 20px 18px 12px;
            display: grid;
            place-items: center;
            text-align: center;
            transition: .8s cubic-bezier(.22, 1, .36, 1);
        }

        .envelope .letter b {
            display: block;
            font: 400 38px var(--script);
            color: var(--navy);
            margin-top: 6px;
        }

        .envelope .letter span {
            font: 600 11px var(--sans);
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--gold);
        }

        .envelope .flap {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 112px;
            background: linear-gradient(180deg, #f0e8d8, #e8dfcf);
            clip-path: polygon(0 0, 50% 78%, 100% 0, 100% 100%, 0 100%);
            border-radius: 0 0 18px 18px;
            transform-origin: top;
            transition: .9s cubic-bezier(.22, 1, .36, 1);
        }

        .envelope .ribbon {
            position: absolute;
            left: 16px;
            right: 16px;
            bottom: 18px;
            height: 10px;
            background: linear-gradient(90deg, #5575a6, #304970);
            border-radius: 999px;
            opacity: .95;
        }

        .cover.opened .envelope .flap {
            transform: rotateX(180deg);
        }

        .cover.opened .envelope .letter {
            transform: translateY(-48px);
        }

        .btn {
            border: 0;
            cursor: pointer;
            border-radius: 999px;
            padding: 15px 24px;
            background: linear-gradient(135deg, var(--navy2), var(--navy));
            color: #fff;
            font: 600 12px var(--sans);
            letter-spacing: .05em;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 12px 24px rgba(45, 70, 111, .2);
            transition: .25s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 28px rgba(45, 70, 111, .24);
        }

        .btn.alt {
            background: #fff;
            color: var(--navy);
            border: 1px solid rgba(45, 70, 111, .16);
            box-shadow: none;
        }

        .music {
            position: fixed;
            z-index: 115;
            right: max(calc((100vw - 580px)/2 + 14px), 14px);
            top: 16px;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .85);
            display: grid;
            place-items: center;
            background: rgba(255, 255, 255, .8);
            backdrop-filter: blur(12px);
            box-shadow: 0 10px 22px rgba(45, 70, 111, .12);
            cursor: pointer;
            color: var(--navy);
        }

        .music svg {
            width: 18px;
        }

        .music.playing {
            animation: pulse 1.8s infinite;
        }

        @keyframes pulse {
            50% {
                box-shadow: 0 0 0 8px rgba(95, 126, 180, .1), 0 10px 22px rgba(45, 70, 111, .14);
            }
        }

        .hero {
            position: relative;
            min-height: 100svh;
            padding: 102px 26px 60px;
            display: grid;
            align-content: center;
            text-align: center;
            background:
                linear-gradient(180deg, rgba(248, 251, 255, .88), rgba(248, 251, 255, .18) 38%, rgba(248, 251, 255, .98) 100%),
                url("{{ $heroImage }}") center 18%/cover no-repeat;
        }

        .hero:after {
            content: "";
            position: absolute;
            inset: auto 0 0;
            height: 150px;
            background: linear-gradient(transparent, var(--paper));
        }

        .hero-floral {
            position: absolute;
            width: 180px;
            opacity: .9;
            pointer-events: none;
            z-index: 1;
        }

        .hero-floral.left {
            left: -64px;
            top: 68px;
        }

        .hero-floral.right {
            right: -64px;
            bottom: 80px;
            transform: rotate(180deg);
        }

        .hero-copy {
            position: relative;
            z-index: 2;
            text-shadow:
                0 1px 2px rgba(255, 255, 255, .98),
                0 0 10px rgba(255, 255, 255, .88),
                0 0 22px rgba(255, 255, 255, .72);
        }

        .hero p {
            font-size: 20px;
            max-width: 390px;
            margin: 12px auto 20px;
        }

        .hero h1 {
            font-size: 86px;
        }

        .couple-line {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            font: 600 14px var(--sans);
            letter-spacing: .08em;
            color: var(--navy2);
            text-transform: uppercase;
            flex-wrap: wrap;
        }

        .couple-line:before,
        .couple-line:after {
            content: "";
            width: 38px;
            height: 1px;
            background: var(--gold);
        }

        .scroll-note {
            font: 600 10px var(--sans);
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--muted);
            margin-top: 34px;
        }

        section {
            position: relative;
            padding: 86px 24px;
        }

        .soft {
            background: linear-gradient(180deg, #f8fbff, #edf3fb);
        }

        .section-title {
            text-align: center;
            margin-bottom: 34px;
        }

        .section-title .small {
            font: 600 10px var(--sans);
            letter-spacing: .24em;
            text-transform: uppercase;
            color: var(--gold);
        }

        .section-title h2 {
            font: 400 52px/1 var(--script);
            color: var(--navy);
            margin: 7px 0 4px;
        }

        .section-title p {
            margin: 0;
            color: var(--muted);
            font-size: 16px;
        }

        .divider {
            width: 220px;
            margin: 8px auto 0;
            display: block;
        }

        .card {
            position: relative;
            background: rgba(255, 255, 255, .86);
            border: 1px solid rgba(90, 118, 165, .16);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .card.glow:before {
            content: "";
            position: absolute;
            inset: -40% auto auto -30%;
            width: 180px;
            height: 180px;
            background: radial-gradient(circle, rgba(210, 223, 245, .7), transparent 70%);
            pointer-events: none;
        }

        .countdown {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-top: 20px;
        }

        .timebox {
            padding: 16px 8px;
            background: rgba(255, 255, 255, .92);
            border: 1px solid rgba(198, 171, 115, .3);
            border-radius: 16px;
            text-align: center;
        }

        .timebox strong {
            display: block;
            color: var(--navy);
            font: 600 30px var(--serif);
        }

        .timebox span {
            font: 600 8px var(--sans);
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .intro-card {
            padding: 20px;
            text-align: center;
        }

        .intro-photos {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            max-width: 390px;
            margin: 0 auto;
        }

        .intro-photo {
            width: 100%;
            aspect-ratio: 1;
            border-radius: 50%;
            object-fit: cover;
            border: 7px solid #fff;
            box-shadow: 0 14px 28px rgba(45, 70, 111, .12);
            outline: 1px solid rgba(198, 171, 115, .45);
        }

        .intro-card h3 {
            font: 400 44px var(--script);
            color: var(--navy);
            margin: 14px 0 0;
        }

        .intro-card p {
            max-width: 390px;
            margin: 8px auto 12px;
            font-size: 18px;
            line-height: 1.55;
        }

        .names {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 8px;
            align-items: center;
            margin-top: 18px;
        }

        .names .person {
            padding: 16px 10px;
            border-radius: 18px;
            background: linear-gradient(180deg, #fff, #f6f9ff);
            border: 1px solid rgba(159, 180, 217, .25);
        }

        .names .label {
            font: 600 10px var(--sans);
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--gold);
        }

        .names .person b {
            display: block;
            font-size: 26px;
            color: var(--navy);
            margin-top: 6px;
        }

        .names .person span {
            display: block;
            font-size: 15px;
            color: var(--muted);
            margin-top: 5px;
        }

        .names .amp {
            font: 400 36px var(--script);
            color: var(--navy2);
        }

        .story-list {
            display: grid;
            gap: 14px;
        }

        .story-item {
            display: grid;
            grid-template-columns: 82px 1fr;
            gap: 14px;
            align-items: center;
            padding: 14px;
        }

        .story-item img {
            width: 82px;
            height: 82px;
            object-fit: cover;
            border-radius: 18px;
        }

        .story-item .year {
            font: 700 11px var(--sans);
            letter-spacing: .12em;
            color: var(--gold);
            text-transform: uppercase;
        }

        .story-item h4 {
            margin: 3px 0 4px;
            font-size: 28px;
            color: var(--navy);
        }

        .story-item p {
            margin: 0;
            font-size: 16px;
            color: var(--muted);
            line-height: 1.45;
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
            background: #f0f5fd;
            color: var(--navy);
            border: 1px solid rgba(159, 180, 217, .35);
        }

        .event-icon svg {
            width: 28px;
        }

        .event h3 {
            font: 400 38px var(--script);
            color: var(--navy);
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

        .gallery {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .gallery figure {
            margin: 0;
            border-radius: 24px;
            overflow: hidden;
            min-height: 190px;
            box-shadow: 0 10px 25px rgba(45, 70, 111, .1);
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
            transition: .6s;
            cursor: pointer;
        }

        .gallery figure:hover img {
            transform: scale(1.04);
        }

        .gift,
        .rsvp,
        .share {
            padding: 28px;
            text-align: center;
        }

        .gift h3,
        .share h3 {
            font: 400 44px var(--script);
            color: var(--navy);
            margin: 0 0 6px;
        }

        .gift .big {
            font-size: 46px;
        }

        .bank {
            margin: 18px 0 0;
            padding: 16px;
            border: 1px dashed rgba(198, 171, 115, .58);
            border-radius: 18px;
            background: #fbfdff;
        }

        .bank b {
            display: block;
            font: 700 12px var(--sans);
            color: var(--navy2);
        }

        .bank .num {
            font: 600 24px var(--serif);
            letter-spacing: .08em;
            margin: 5px 0;
            color: var(--navy);
        }

        .bank small {
            color: var(--muted);
        }

        .form {
            display: grid;
            gap: 12px;
            text-align: left;
        }

        .field {
            display: grid;
            gap: 6px;
        }

        .field label {
            font: 600 10px var(--sans);
            text-transform: uppercase;
            letter-spacing: .12em;
            color: var(--navy2);
        }

        .field input,
        .field select,
        .field textarea {
            width: 100%;
            border: 1px solid rgba(90, 118, 165, .18);
            background: #fff;
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
            border-color: rgba(95, 126, 180, .7);
            box-shadow: 0 0 0 4px rgba(159, 180, 217, .18);
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
            padding: 16px 18px;
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
            background: #dce6f7;
            color: var(--navy);
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

        .share-actions {
            display: flex;
            justify-content: center;
            gap: 9px;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .closing {
            text-align: center;
            padding: 104px 24px 124px;
            background: linear-gradient(180deg, #edf3fb, #dde8f6);
        }

        .closing p {
            font-size: 18px;
            color: var(--muted);
            max-width: 360px;
            margin: 10px auto 18px;
            line-height: 1.6;
        }

        .footer-note {
            font: 600 11px var(--sans);
            letter-spacing: .16em;
            color: var(--navy2);
            text-transform: uppercase;
        }

        .floral-side {
            position: absolute;
            width: 180px;
            opacity: .72;
            pointer-events: none;
            z-index: 0;
        }

        .floral-side.left {
            left: -62px;
            top: 26px;
        }

        .floral-side.right {
            right: -62px;
            top: 18px;
            transform: rotate(90deg);
        }

        .leaf-layer {
            position: fixed;
            inset: 0;
            pointer-events: none;
            max-width: 580px;
            margin: auto;
            overflow: hidden;
            z-index: 80;
        }

        .leaf {
            position: absolute;
            top: -30px;
            width: 12px;
            height: 18px;
            border-radius: 70% 30% 70% 30%;
            background: linear-gradient(135deg, #dce6f7, #9fb4d9);
            opacity: .62;
            animation: fall linear infinite;
        }

        .spark {
            position: absolute;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 0 0 1px rgba(198, 171, 115, .4), 0 0 12px rgba(255, 255, 255, .9);
            animation: twinkle 2.8s ease-in-out infinite;
        }

        @keyframes fall {
            to {
                transform: translate3d(var(--drift), 110vh, 0) rotate(540deg);
            }
        }

        @keyframes twinkle {
            50% {
                opacity: .2;
                transform: scale(.45);
            }
        }

        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity .8s ease, transform .8s cubic-bezier(.2, .8, .2, 1);
        }

        .reveal-left {
            opacity: 0;
            transform: translateX(-34px);
            transition: .85s ease;
        }

        .reveal-right {
            opacity: 0;
            transform: translateX(34px);
            transition: .85s ease;
        }

        .zoom {
            opacity: 0;
            transform: scale(.94);
            transition: .85s ease;
        }

        .show {
            opacity: 1;
            transform: none;
        }

        .toast {
            position: fixed;
            z-index: 160;
            left: 50%;
            bottom: 86px;
            transform: translate(-50%, 20px);
            background: #2d466f;
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
            z-index: 110;
            left: 50%;
            bottom: 14px;
            transform: translateX(-50%);
            display: flex;
            gap: 6px;
            padding: 7px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .82);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, .82);
            box-shadow: 0 10px 28px rgba(45, 70, 111, .15);
        }

        .bottom-nav a {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            text-decoration: none;
            color: var(--navy);
            font-size: 17px;
        }

        .bottom-nav a:hover {
            background: #edf3fb;
        }

        .lightbox {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 200;
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

            .hero h1 {
                font-size: 74px;
            }

            .countdown {
                gap: 6px;
            }

            .timebox strong {
                font-size: 26px;
            }

            .cover-card {
                padding: 20px;
            }

            .envelope {
                height: 178px;
            }

            .names {
                grid-template-columns: 1fr;
            }

            .names .amp {
                display: none;
            }

            .intro-photos {
                gap: 12px;
            }

            .intro-photo {
                border-width: 5px;
            }
        }

        @media (prefers-reduced-motion:reduce) {
            html {
                scroll-behavior: auto;
            }

            .reveal,
            .reveal-left,
            .reveal-right,
            .zoom {
                opacity: 1;
                transform: none;
                transition: none;
            }

            .leaf,
            .spark,
            .music {
                animation: none !important;
            }
        }
    </style>
</head>

<body class="lock">
    <div class="progress"><span id="progressBar"></span></div>
    <div class="leaf-layer" id="leafLayer"></div>
    <div class="toast" id="toast">Tersalin</div>

    <div class="cover" id="cover">
        <div class="cover-card">
            <div class="cover-inner">
                <img class="monogram" src="{{ asset('tema/wedding_blue/assets/monogram.svg') }}" alt="Monogram">
                <div class="kicker">{{ $data->setting?->acara ?? 'The Wedding Of' }}</div>
                <h1>{{ $coupleNames }}</h1>
                <div class="date">{{ $eventDateText }}</div>
                <div class="envelope-box">
                    <img class="seal" src="{{ asset('tema/wedding_blue/assets/seal.svg') }}" alt="Seal">
                    <div class="envelope">
                        <div class="back"></div>
                        <div class="liner"></div>
                        <div class="letter">
                            <div><span>You are invited</span><b>{{ $coupleNames }}</b></div>
                        </div>
                        <div class="ribbon"></div>
                        <div class="flap"></div>
                    </div>
                </div>
                <div class="guest">Kepada Yth.<br><strong id="guestName">{{ $tamu }}</strong></div>
                <p class="hint">Dengan penuh sukacita kami mengundang Anda untuk hadir dalam hari bahagia pernikahan
                    kami.</p>
                <button class="btn" id="openInvitation">✉ Buka Undangan</button>
            </div>
        </div>
    </div>

    <div class="site">
        @if ($data->sound?->isActive && $data->sound?->sound && $data->sound?->sound !== 'null')
            <button class="music" id="musicToggle" aria-label="Putar musik" title="Musik">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M9 18V5l10-2v13" />
                    <circle cx="6" cy="18" r="3" />
                    <circle cx="16" cy="16" r="3" />
                </svg>
            </button>
            @include('tema.partials.music', ['data' => $data])
        @endif

        <header class="hero" id="home">
            <img class="hero-floral left" src="{{ asset('tema/wedding_blue/assets/floral-corner.svg') }}"
                alt="">
            <img class="hero-floral right" src="{{ asset('tema/wedding_blue/assets/floral-corner.svg') }}"
                alt="">
            <div class="hero-copy reveal">
                <div class="kicker">{{ $data->teksUndangan?->pembuka ?? 'Our Forever Begins' }}</div>
                <h1>{{ $coupleNames }}</h1>
                <div class="date">{{ $eventDateText }}</div>
                <p>{{ $data->qoute?->qoute ?? 'Two hearts, one promise, and a beautiful journey that leads us to forever.' }}
                </p>
                <div class="couple-line"><span>Are Getting Married</span></div>
                <div class="scroll-note">Scroll untuk melihat detail ↓</div>
            </div>
        </header>

        <main>
            <section class="soft" id="countdown-section">
                <div class="section-title reveal">
                    <span class="small">Save the date</span>
                    <h2>Hitung Mundur</h2>
                    <p>Kami menantikan kehadiran Anda di hari spesial kami.</p>
                    <img class="divider" src="{{ asset('tema/wedding_blue/assets/divider.svg') }}" alt="Divider">
                </div>
                <div class="countdown reveal" id="countdown" data-target="{{ $countdownDate }}">
                    <div class="timebox"><strong id="days">00</strong><span>Hari</span></div>
                    <div class="timebox"><strong id="hours">00</strong><span>Jam</span></div>
                    <div class="timebox"><strong id="minutes">00</strong><span>Menit</span></div>
                    <div class="timebox"><strong id="seconds">00</strong><span>Detik</span></div>
                </div>
            </section>

            <section id="couple">
                <img class="floral-side left" src="{{ asset('tema/wedding_blue/assets/floral-corner.svg') }}"
                    alt="">
                <img class="floral-side right" src="{{ asset('tema/wedding_blue/assets/floral-corner.svg') }}"
                    alt="">
                <div class="section-title reveal">
                    <span class="small">Couple Intro</span>
                    <h2>Pengantin</h2>
                    <p>{{ $data->teksUndangan?->acara ?? 'Dengan restu keluarga, kami memohon doa untuk langkah baru kami.' }}
                    </p>
                    <img class="divider" src="{{ asset('tema/wedding_blue/assets/divider.svg') }}" alt="Divider">
                </div>
                <div class="card intro-card glow zoom">
                    <div class="intro-photos">
                        <img class="intro-photo" src="{{ $priaImage }}"
                            alt="{{ $pria?->nama_lengkap ?? 'Mempelai Pria' }}">
                        <img class="intro-photo" src="{{ $wanitaImage }}"
                            alt="{{ $wanita?->nama_lengkap ?? 'Mempelai Wanita' }}">
                    </div>
                    <h3>{{ $coupleNames }}</h3>
                    <p>{{ $data->qoute?->subtitle ?? 'Love is not just looking at each other, but looking together in the same direction.' }}
                    </p>
                    <div class="names">
                        <div class="person">
                            <div class="label">Mempelai Pria</div>
                            <b>{{ $pria?->nama_lengkap ?? 'Mempelai Pria' }}</b><span>{{ $pria?->deskripsi ?? '' }}</span>
                        </div>
                        <div class="amp">&</div>
                        <div class="person">
                            <div class="label">Mempelai Wanita</div>
                            <b>{{ $wanita?->nama_lengkap ?? 'Mempelai Wanita' }}</b><span>{{ $wanita?->deskripsi ?? '' }}</span>
                        </div>
                    </div>
                </div>
            </section>

            @if ($data->acara->isNotEmpty())
                <section class="soft" id="events">
                    <div class="section-title reveal">
                        <span class="small">The Big Day</span>
                        <h2>Rangkaian Acara</h2>
                        <p>Waktu dan tempat perayaan kami.</p>
                        <img class="divider" src="{{ asset('tema/wedding_blue/assets/divider.svg') }}"
                            alt="Divider">
                    </div>
                    <div class="events">
                        @foreach ($data->acara as $index => $item)
                            <article class="card event {{ $loop->even ? 'reveal-left' : 'reveal-right' }}">
                                <div class="event-icon"><svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.7">
                                        <path d="M3 21h18M5 21V10l7-6 7 6v11M9 21v-6h6v6M9 10h6" />
                                    </svg></div>
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
                                    <a class="btn" href="{{ $item->maps }}" target="_blank" rel="noopener">⌖
                                        Lihat Lokasi</a>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($data->kisah?->isNotEmpty())
                <section id="story">
                    <div class="section-title reveal">
                        <span class="small">Our Love Story</span>
                        <h2>Perjalanan Kami</h2>
                        <p>Setiap momen membawa kami menuju hari ini.</p>
                        <img class="divider" src="{{ asset('tema/wedding_blue/assets/divider.svg') }}"
                            alt="Divider">
                    </div>
                    <div class="story-list">
                        @foreach ($data->kisah as $kisah)
                            <article class="card story-item {{ $loop->even ? 'reveal-left' : 'reveal-right' }}">
                                <img src="{{ $storageUrl($kisah->image?->image) ?? $heroImage }}"
                                    alt="{{ $kisah->title }}">
                                <div>
                                    <div class="year">{{ $kisah->created_at?->format('Y') ?? 'Kisah' }}</div>
                                    <h4>{{ $kisah->title }}</h4>
                                    <p>{{ $kisah->deskripsi }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($poto || $video)
                <section class="soft" id="gallery">
                    <div class="section-title reveal">
                        <span class="small">Gallery</span>
                        <h2>Galeri Foto</h2>
                        <p>Beberapa momen pilihan untuk mengabadikan kisah kami.</p>
                        <img class="divider" src="{{ asset('tema/wedding_blue/assets/divider.svg') }}"
                            alt="Divider">
                    </div>
                    @if ($video)
                        <div class="card event reveal" style="padding:12px;">
                            <iframe src="{{ $video[0] }}"
                                style="width:100%; height:240px; border:0; border-radius:18px;"
                                title="Video Galeri"></iframe>
                        </div>
                    @endif
                    <div class="gallery" style="margin-top:{{ $video ? '14px' : '0' }}">
                        @foreach ($poto as $po)
                            <figure class="reveal"><img src="{{ $storageUrl($po) }}" class="gallery-img"
                                    alt="Galeri" loading="lazy"></figure>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($data->streaming?->isActive && $data->streaming?->link)
                <section id="streaming">
                    <div class="section-title reveal">
                        <span class="small">Live Streaming</span>
                        <h2>Siaran Langsung</h2>
                        <p>Turut hadir secara virtual melalui siaran langsung kami.</p>
                    </div>
                    <div class="card gift zoom">
                        <div class="big">📺</div>
                        <h3>Live Streaming</h3>
                        <p>Tonton momen spesial kami secara langsung.</p>
                        <div class="share-actions">
                            <a class="btn" href="{{ $data->streaming->link }}" target="_blank" rel="noopener">▶
                                Tonton Streaming</a>
                        </div>
                    </div>
                </section>
            @endif

            @if ($data->fiturKado?->isActive && $data->kado?->isNotEmpty())
                <section id="gift">
                    <div class="section-title reveal">
                        <span class="small">Wedding Gift</span>
                        <h2>Gift</h2>
                        <p>Doa dan kehadiran Anda adalah hadiah terbaik bagi kami.</p>
                    </div>
                    <div class="card gift zoom">
                        <div class="big">🎁</div>
                        <h3>Hadiah Digital</h3>
                        <p>Apabila ingin memberikan tanda kasih, Anda dapat menggunakan informasi berikut.</p>
                        @foreach ($data->kado as $gift)
                            <div class="bank">
                                <b>{{ $gift->giftPay?->nama_pay ?? 'Transfer Bank' }}</b>
                                <div class="num">{{ $gift->nomorPay }}</div>
                                <small>a.n. {{ $gift->namaPay }}</small><br><br>
                                @if ($gift->nomorPay)
                                    <button class="btn alt copy-btn" data-copy="{{ $gift->nomorPay }}">Salin Nomor
                                        Rekening</button>
                                @endif
                                @if ($gift->qris)
                                    <img src="{{ $storageUrl($gift->qris) }}" alt="QRIS"
                                        style="display:block; max-width:180px; width:100%; margin:14px auto 0; border-radius:20px;">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($data->FiturUcapan?->isActive)
                <section class="soft" id="rsvp">
                    <div class="section-title reveal">
                        <span class="small">RSVP</span>
                        <h2>Konfirmasi Kehadiran</h2>
                        <p>Mohon konfirmasi kehadiran dan tinggalkan doa terbaik Anda.</p>
                        <img class="divider" src="{{ asset('tema/wedding_blue/assets/divider.svg') }}"
                            alt="Divider">
                    </div>
                    <div class="card rsvp reveal">
                        <div id="wishAlert" class="wish-alert"></div>
                        @if ($data->FiturUcapan?->publicIsActive || $kode)
                            <form class="form" id="rsvpForm" action="{{ route('savedoa') }}" method="post">
                                @csrf
                                <input type="hidden" name="dataId" value="{{ $data->id }}">
                                <input type="hidden" name="kode" value="{{ $kode }}">
                                <div class="field"><label>Nama</label><input type="text" name="nama" required
                                        placeholder="Nama Anda" value="{{ old('nama', $tamu) }}"></div>
                                <div class="field"><label>Kehadiran</label><select name="status" required>
                                        <option value="hadir" @selected(old('status') === 'hadir')>Hadir</option>
                                        <option value="tidak_hadir" @selected(old('status') === 'tidak_hadir')>Tidak dapat hadir
                                        </option>
                                        <option value="ragu" @selected(old('status') === 'ragu')>Masih tentatif</option>
                                    </select></div>
                                <div class="field"><label>Ucapan</label>
                                    <textarea name="ucapan" required placeholder="Tulis doa atau ucapan...">{{ old('ucapan') }}</textarea>
                                </div>
                                <button class="btn" type="submit">♡ Kirim Konfirmasi</button>
                            </form>
                        @else
                            <p style="color:var(--muted)">Form ucapan hanya tersedia untuk tamu yang menerima tautan
                                undangan.</p>
                        @endif
                    </div>
                    @if ($data->FiturUcapan?->viewIsActive)
                        <div class="section-title reveal" style="margin-top:28px">
                            <span class="small">Wishes</span>
                            <h2>Ucapan</h2>
                        </div>
                        <div class="messages" id="wishList">
                            @forelse ($ucapan as $item)
                                <article class="card message reveal">
                                    <div class="top">
                                        <div class="avatar">{{ strtoupper(substr($item->tamu?->nama ?? 'T', 0, 1)) }}
                                        </div>
                                        <div><b>{{ $item->tamu?->nama ?? 'Tamu' }}</b><small>{{ $item->status }} ·
                                                {{ $item->created_at?->diffForHumans() }}</small></div>
                                    </div>
                                    <p>{{ $item->ucapan }}</p>
                                    @if ($item->balas)
                                        <div
                                            style="margin-top:10px; background:#f6f9ff; border-radius:16px; padding:10px; font-size:0.9rem;">
                                            <strong>Balasan:</strong> {{ $item->balas }}</div>
                                    @endif
                                </article>
                            @empty
                                <article class="card message reveal">
                                    <p style="text-align:center; color:var(--muted)">Belum ada ucapan yang dikirim.</p>
                                </article>
                            @endforelse
                        </div>
                    @endif
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
                <div class="card share zoom">
                    <h3>Bagikan Undangan</h3>
                    <p>Kirimi keluarga dan sahabat agar mereka juga dapat ikut merayakan.</p>
                    <div class="share-actions">
                        <button class="btn alt" id="copyLink">⛓ Salin Link</button>
                        <a class="btn"
                            href="https://wa.me/?text={{ urlencode($pageTitle . ' - ' . url()->current()) }}"
                            target="_blank" rel="noopener">WhatsApp</a>
                    </div>
                </div>
            </section>

            <section class="closing" id="closing">
                <div class="reveal">
                    <div class="kicker">Thank You</div>
                    <h2>With Love,</h2>
                    <p>{!! nl2br(
                        e(
                            $data->teksUndangan?->penutup ??
                                'Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Anda berkenan hadir dan memberikan doa restu.',
                        ),
                    ) !!}</p>
                    <div class="footer-note">{{ $coupleNames }} · {{ $eventDayMonth }}</div>
                </div>
            </section>
        </main>
    </div>

    <nav class="bottom-nav" aria-label="Navigasi cepat">
        <a href="#home" title="Home">⌂</a>
        @if ($data->acara->isNotEmpty())
            <a href="#events" title="Acara">✦</a>
        @endif
        @if ($poto || $video)
            <a href="#gallery" title="Galeri">▣</a>
        @endif
        @if ($data->FiturUcapan?->isActive)
            <a href="#rsvp" title="RSVP">♡</a>
        @endif
    </nav>

    <div class="lightbox" id="lightbox"><img id="lightboxImg" src="" alt="Galeri"><span
            style="position:absolute; top:20px; right:30px; color:white; font-size:32px; cursor:pointer"
            id="closeLightbox">&times;</span></div>

    <script>
        (function() {
            const body = document.body;
            const cover = document.getElementById('cover');
            const openBtn = document.getElementById('openInvitation');
            const toast = document.getElementById('toast');
            const leafLayer = document.getElementById('leafLayer');
            const progressBar = document.getElementById('progressBar');

            function showToast(text) {
                toast.textContent = text;
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 1800);
            }

            function openInvitation() {
                cover.classList.add('opened');
                setTimeout(() => {
                    cover.classList.add('hide');
                    body.classList.remove('lock');
                }, 800);
                if (window.musicPlayer) window.musicPlayer.play();
            }
            if (openBtn) openBtn.addEventListener('click', openInvitation);
            if (cover) cover.addEventListener('click', (e) => {
                if (e.target === cover) openInvitation();
            });

            window.addEventListener('scroll', () => {
                const scrollTop = window.scrollY;
                const height = document.documentElement.scrollHeight - innerHeight;
                progressBar.style.width = (height > 0 ? (scrollTop / height) * 100 : 0) + '%';
            }, {
                passive: true
            });

            const io = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) entry.target.classList.add('show');
                });
            }, {
                threshold: .16
            });
            document.querySelectorAll('.reveal,.reveal-left,.reveal-right,.zoom').forEach(el => io.observe(el));

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
            if (countdown) {
                updateCountdown();
                setInterval(updateCountdown, 1000);
            }

            document.querySelectorAll('.copy-btn').forEach(btn => {
                btn.addEventListener('click', async () => {
                    try {
                        await navigator.clipboard.writeText(btn.dataset.copy);
                        showToast('Nomor rekening tersalin');
                    } catch (e) {
                        showToast('Gagal menyalin');
                    }
                });
            });

            const copyLink = document.getElementById('copyLink');
            if (copyLink) copyLink.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(location.href);
                    showToast('Link undangan tersalin');
                } catch (e) {
                    showToast('Gagal menyalin link');
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
            if (lightbox) lightbox.addEventListener('click', (event) => {
                if (event.target === lightbox) lightbox.classList.remove('active');
            });

            function escapeHtml(value) {
                return String(value ?? '').replace(/[&<>"']/g, (char) => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
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
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.textContent = 'Mengirim...';
                    }
                    try {
                        const response = await fetch(rsvpForm.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
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
                        const wishList = document.getElementById('wishList');
                        if (wishList && result.doa) {
                            const emptyCard = wishList.querySelector('.card.message');
                            if (emptyCard && emptyCard.textContent.includes('Belum ada ucapan')) emptyCard
                                .remove();
                            const initials = (result.doa.nama || 'T').slice(0, 1).toUpperCase();
                            const article = document.createElement('article');
                            article.className = 'card message reveal show';
                            article.innerHTML = '<div class="top"><div class="avatar">' + escapeHtml(
                                    initials) + '</div><div><b>' + escapeHtml(result.doa.nama) +
                                '</b><small>' + escapeHtml(result.doa.status) +
                                ' · Baru saja</small></div></div><p>' + escapeHtml(result.doa.ucapan) +
                                '</p>';
                            wishList.prepend(article);
                        }
                    } catch (error) {
                        showWishAlert('error', 'Ucapan gagal dikirim. Silakan coba lagi.');
                    } finally {
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.textContent = originalText;
                        }
                    }
                });
            }

            function addLeaves() {
                for (let i = 0; i < 18; i++) {
                    const leaf = document.createElement('span');
                    leaf.className = 'leaf';
                    leaf.style.left = Math.random() * 100 + '%';
                    leaf.style.setProperty('--drift', (Math.random() * 120 - 60) + 'px');
                    leaf.style.animationDuration = (10 + Math.random() * 12) + 's';
                    leaf.style.animationDelay = (-Math.random() * 12) + 's';
                    leaf.style.opacity = 0.18 + Math.random() * 0.45;
                    leafLayer.appendChild(leaf);
                }
                for (let i = 0; i < 12; i++) {
                    const spark = document.createElement('span');
                    spark.className = 'spark';
                    spark.style.left = Math.random() * 100 + '%';
                    spark.style.top = Math.random() * 100 + '%';
                    spark.style.animationDelay = (Math.random() * 3) + 's';
                    spark.style.opacity = 0.2 + Math.random() * 0.7;
                    leafLayer.appendChild(spark);
                }
            }
            if (leafLayer) addLeaves();
        })();
    </script>
</body>

</html>
