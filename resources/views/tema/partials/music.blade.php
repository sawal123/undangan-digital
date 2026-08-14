{{-- Player musik bersama untuk theme Mahligai, Deep One, Deep One Pink, dan Logan Gold. --}}
{{-- Source YouTube -> iframe autoplay; URL http/https -> langsung; path lokal -> asset storage. --}}
@php
    use App\Services\YouTubeUrlParser;
    use Illuminate\Support\Str;

    $musicData = $data->sound ?? null;
    $musicActive = $musicData && $musicData->isActive && $musicData->sound && $musicData->sound !== 'null';
    $musicSource = $musicActive ? $musicData->sound : null;
    $musicStart = (int) ($musicData->start ?? 0);
    $musicEmbed = null;
    $musicAudioSrc = null;

    if ($musicSource) {
        if (Str::contains($musicSource, 'youtu')) {
            $musicEmbed = app(YouTubeUrlParser::class)->toEmbedUrl($musicSource, $musicStart);
        } elseif (Str::startsWith($musicSource, ['http://', 'https://'])) {
            $musicAudioSrc = $musicSource;
        } else {
            $musicAudioSrc = asset('storage/' . ltrim($musicSource, '/'));
        }
    }
@endphp

@if ($musicSource && ($musicEmbed || $musicAudioSrc))
    @if ($musicEmbed)
        <div id="youtubePlayer" aria-hidden="true"
            style="position:absolute; left:-9999px; top:0; width:1px; height:1px; overflow:hidden; pointer-events:none;">
            <iframe id="bgMusicFrame" data-embed="{{ $musicEmbed }}"
                src="{{ $musicEmbed }}{{ str_contains($musicEmbed, '?') ? '&' : '?' }}enablejsapi=1"
                title="Musik Undangan" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin">
            </iframe>
        </div>
    @else
        <audio id="bgMusic" loop preload="auto" src="{{ $musicAudioSrc }}" data-start="{{ $musicStart }}"></audio>
    @endif
    <script>
        (function() {
            const audio = document.getElementById('bgMusic');
            const frame = document.getElementById('bgMusicFrame');
            const toggleBtn = document.getElementById('musicToggle');
            const icon = toggleBtn ? toggleBtn.querySelector('i') : null;
            let playing = false;
            let frameLoaded = false;

            function setPlaying(state) {
                playing = state;
                if (!icon) return;
                if (state) {
                    icon.classList.remove('fa-music');
                    icon.classList.add('fa-pause');
                } else {
                    icon.classList.remove('fa-pause');
                    icon.classList.add('fa-music');
                }
            }

            function postCommand(func) {
                if (!frame || !frame.contentWindow) return;
                frame.contentWindow.postMessage(
                    JSON.stringify({
                        event: 'command',
                        func: func,
                        args: []
                    }),
                    '*'
                );
            }

            function play() {
                if (frame) {
                    if (!frameLoaded) {
                        frameLoaded = true;
                        const base = frame.getAttribute('data-embed');
                        frame.src = base + (base.indexOf('?') !== -1 ? '&' : '?') + 'autoplay=1&enablejsapi=1';
                    } else {
                        postCommand('playVideo');
                    }
                    setPlaying(true);
                    return;
                }
                if (!audio) return;
                const result = audio.play();
                if (result && typeof result.then === 'function') {
                    result.then(() => setPlaying(true)).catch(() => setPlaying(false));
                } else {
                    setPlaying(true);
                }
            }

            function pause() {
                if (frame) {
                    postCommand('pauseVideo');
                } else if (audio) {
                    audio.pause();
                }
                setPlaying(false);
            }

            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    if (playing) {
                        pause();
                    } else {
                        play();
                    }
                });
            }

            // Hormati nilai start: mulai dari detik yang dipilih dan pertahankan loop dari titik tersebut.
            if (audio) {
                const start = parseFloat(audio.getAttribute('data-start') || '0') || 0;
                if (start > 0) {
                    let seeked = false;
                    audio.addEventListener('loadedmetadata', () => {
                        if (!seeked && audio.duration > start) {
                            seeked = true;
                            audio.currentTime = start;
                        }
                    });
                    audio.addEventListener('timeupdate', () => {
                        if (audio.duration && audio.currentTime >= audio.duration - 0.4) {
                            audio.currentTime = start;
                        }
                    });
                }
            }

            window.musicPlayer = {
                play,
                pause
            };
        })();
    </script>
@endif
