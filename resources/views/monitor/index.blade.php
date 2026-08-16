<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor Antrean - BPS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-900 text-white min-h-screen flex flex-col justify-between font-sans relative">

    <!-- OVERLAY UNTUK MEMBUKA BLOKIR SUARA BROWSER -->
    <div id="start-overlay" class="fixed inset-0 bg-slate-950/90 z-50 flex flex-col items-center justify-center space-y-4">
        <div class="bg-blue-900 border border-blue-500 p-8 rounded-2xl shadow-2xl text-center max-w-md">
            <i class="fas fa-volume-up text-5xl text-yellow-400 mb-4 animate-bounce"></i>
            <h2 class="text-2xl font-bold mb-2">Monitor Antrean Siap</h2>
            <p class="text-sm text-blue-200 mb-6">Klik tombol di bawah ini untuk mengaktifkan suara dan menjalankan monitor.</p>
            <button onclick="mulaiMonitor()" class="bg-yellow-400 hover:bg-yellow-500 text-slate-950 font-extrabold px-6 py-3 rounded-xl shadow-lg transition transform hover:scale-105">
                <i class="fas fa-play mr-2"></i> Mulai Monitor & Aktifkan Suara
            </button>
        </div>
    </div>

    <!-- HEADER -->
    <header class="bg-blue-900 border-b border-blue-700 px-8 py-4 flex justify-between items-center shadow-lg">
        <div class="flex items-center space-x-4">
            <!-- LOGO BPS -->
            <img src="{{ asset('img/images.jfif') }}" alt="Logo BPS" class="h-12 w-auto object-contain">
            
            <div>
                <h1 class="text-2xl font-extrabold tracking-wide">BADAN PUSAT STATISTIK KOTA PRABUMULIH</h1>
                <p class="text-sm text-blue-200">Sistem Informasi Layanan Antrean Terpadu</p>
            </div>
        </div>
        <div class="text-right">
            <div id="clock" class="text-3xl font-mono font-bold text-yellow-400">00:00:00</div>
            <div id="date" class="text-sm text-blue-200">--</div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- PANGGILAN UTAMA & VIDEO (Kiri / 2 Kolom) -->
        <div class="lg:col-span-2 bg-slate-800 rounded-2xl border border-slate-700 p-8 flex flex-col justify-between shadow-2xl relative overflow-hidden min-h-[420px]">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 via-yellow-400 to-green-500 z-10"></div>
            
            <!-- TAMPILAN 1: PANGGILAN ANTREAN -->
            <div id="container-aktif" class="flex flex-col justify-between h-full space-y-6">
                <div class="text-center">
                    <span class="bg-blue-600/30 text-blue-400 border border-blue-500/30 px-4 py-1.5 rounded-full text-lg font-semibold uppercase tracking-wider">
                        Sedang Dipanggil
                    </span>
                    <h2 id="layanan-aktif" class="text-2xl font-bold text-slate-300 mt-4">Belum Ada Panggilan</h2>
                </div>

                <!-- Nomor Antrean Besar -->
                <div class="text-center my-6">
                    <div id="nomor-aktif" class="text-9xl font-black tracking-wider text-yellow-400 drop-shadow-[0_10px_10px_rgba(0,0,0,0.5)]">
                        ---
                    </div>
                </div>

                <!-- Loket / Pengunjung Tujuan -->
                <div class="bg-slate-900/80 rounded-xl p-6 border border-slate-700 text-center">
                    <p class="text-slate-400 text-lg uppercase tracking-wide">Pengunjung</p>
                    <h3 id="pengunjung-aktif" class="text-2xl font-extrabold text-green-400 mt-1">-</h3>
                </div>
            </div>

            <!-- TAMPILAN 2: MEDIA PLAYER (Video Lokal / YouTube / Gambar) -->
            <div id="container-video" class="hidden absolute object-contain inset-0 w-full h-full bg-black flex items-center justify-center overflow-hidden">
                <!-- Slot untuk Gambar -->
                <img id="image-player" class="w-full h-full object-contain bg-black hidden" alt="Slide Media">
                
                <!-- Slot untuk Video Lokal (object-cover atau object-contain agar tampilan penuh pas) -->
                <video id="video-player" class="w-full h-full object-contain bg-black hidden" playsinline loop></video>
                
                <!-- Slot untuk YouTube Iframe -->
                <div id="youtube-container" class="w-full h-full hidden">
                    <div id="yt-player" class="w-full h-full"></div>
                </div>
            </div>
        </div>

        <!-- DAFTAR ANTREAN SELANJUTNYA (Kanan / 1 Kolom) -->
        <div class="flex flex-col space-y-4">
            <h3 class="text-xl font-bold text-slate-300 mb-2 flex items-center gap-2">
                <i class="fas fa-list-ol text-blue-400"></i> Antrean Menunggu
            </h3>

            <div id="next-container" class="flex flex-col space-y-3">
                <div class="bg-slate-800 rounded-xl p-5 text-center text-slate-400">
                    Memuat data antrean...
                </div>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-blue-950 border-t border-blue-900 py-3 px-6 flex items-center overflow-hidden pointer-events-none">
        <div class="bg-blue-600 text-white text-xs font-bold uppercase px-3 py-1 rounded mr-4 whitespace-nowrap">
            Informasi
        </div>
        <marquee class="text-slate-300 text-sm">
            Selamat Datang di Badan Pusat Statistik. Jam Layanan Operasional: Senin - Kamis (08.00 - 15.00 WIB), Jumat (08.00 - 15.30 WIB).
        </marquee>
    </footer>

    <!-- SCRIPT -->
    <script>
        // Playlist: Gambar menggunakan duration (detik), Video Lokal & YouTube otomatis full sampai selesai
        const playlist = [
            //{ type: 'image', src: "{{ asset('img/dashboard.png') }}", duration: 5 }, 
           // { type: 'local', src: "{{ asset('img/contoh1.mp4') }}" }, 
            //{ type: 'youtube', id: 'VuZ3-du1LJc' },            
           // { type: 'local', src: "{{ asset('img/video.mp4') }}" },
            { type: 'local', src: "{{ asset('img/karin.mp4') }}" }
        ];

        let currentPlaylistIndex = 0;
        let mediaTimeout = null;
        let isStarted = false;

        // Load YouTube API Script secara dinamis
        const tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        const firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        let ytPlayer = null;
        function onYouTubeIframeAPIReady() {}

        function mulaiMonitor() {
            document.getElementById('start-overlay').style.display = 'none';
            isStarted = true;
            fetchAntrianData();
        }

        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;

            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('date').textContent = now.toLocaleDateString('id-ID', options);
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Fungsi bantu untuk menghentikan seluruh media (terutama audio YouTube yang sering tertinggal)
        function stopAllMedia() {
            const videoEl = document.getElementById('video-player');
            const ytContainer = document.getElementById('youtube-container');

            // Pause video lokal
            if (videoEl) {
                videoEl.pause();
                videoEl.currentTime = 0;
                videoEl.onended = null;
                videoEl.classList.add('hidden');
            }

            // Hentikan YouTube Player jika ada & aktif
            if (ytPlayer && typeof ytPlayer.stopVideo === 'function') {
                try {
                    ytPlayer.stopVideo();
                } catch (e) {
                    console.log("Gagal menghentikan YouTube player:", e);
                }
            }
            if (ytContainer) {
                ytContainer.classList.add('hidden');
            }

            document.getElementById('image-player').classList.add('hidden');
            if (mediaTimeout) clearTimeout(mediaTimeout);
        }

        function playCurrentMedia() {
            if (!isStarted || playlist.length === 0) return;

            // Bersihkan media sebelumnya terlebih dahulu agar tidak tumpang tindih
            stopAllMedia();

            const media = playlist[currentPlaylistIndex];
            const videoEl = document.getElementById('video-player');
            const imgEl = document.getElementById('image-player');
            const ytContainer = document.getElementById('youtube-container');

            // 1. Video Lokal
            if (media.type === 'local') {
                videoEl.classList.remove('hidden');
                videoEl.muted = false; 

                if (videoEl.getAttribute('data-src') !== media.src) {
                    videoEl.src = media.src;
                    videoEl.setAttribute('data-src', media.src);
                    videoEl.play().catch(err => console.log("Gagal putar video lokal:", err));
                } else {
                    videoEl.play().catch(err => console.log("Gagal lanjut putar video lokal:", err));
                }

                videoEl.onended = () => {
                    videoEl.removeAttribute('data-src');
                    nextMedia();
                };
            }
            // 2. Gambar
            else if (media.type === 'image') {
                imgEl.classList.remove('hidden');
                imgEl.src = media.src;

                mediaTimeout = setTimeout(() => {
                    nextMedia();
                }, (media.duration || 5) * 1000);
            } 
            // 3. YouTube
            else if (media.type === 'youtube') {
                ytContainer.classList.remove('hidden');
                
                if (!ytPlayer) {
                    ytPlayer = new YT.Player('yt-player', {
                        videoId: media.id,
                        playerVars: { 
                            'autoplay': 1, 
                            'controls': 0, 
                            'mute': 0,  
                            'modestbranding': 1,
                            'rel': 0, 
                            'iv_load_policy': 3, 
                            'fs': 0, 
                            'disablekb': 1 
                        },
                        events: {
                            'onReady': (event) => {
                                event.target.setPlaybackQuality('hd1080');
                                event.target.unMute();
                                event.target.playVideo();
                            },
                            'onStateChange': (event) => {
                                if (event.data === YT.PlayerState.ENDED) {
                                    nextMedia();
                                }
                            }
                        }
                    });
                } else {
                    ytPlayer.loadVideoById(media.id);
                    ytPlayer.unMute();
                    ytPlayer.playVideo();
                }
            }
        }

        function nextMedia() {
            currentPlaylistIndex = (currentPlaylistIndex + 1) % playlist.length;
            const containerVideo = document.getElementById('container-video');
            if (containerVideo && !containerVideo.classList.contains('hidden')) {
                playCurrentMedia();
            }
        }

        function tampilkanVideo() {
            if (!isStarted) return;
            const containerAktif = document.getElementById('container-aktif');
            const containerVideo = document.getElementById('container-video');

            if (containerAktif && containerVideo) {
                if (containerVideo.classList.contains('hidden')) {
                    containerAktif.classList.add('hidden');
                    containerVideo.classList.remove('hidden');
                    playCurrentMedia();
                }
            }
        }

        async function fetchAntrianData() {
            if (!isStarted) return;

            const containerAktif = document.getElementById('container-aktif');
            const containerVideo = document.getElementById('container-video');
            const nextContainer = document.getElementById('next-container');

            try {
                const response = await fetch("{{ route('monitor.data') }}");
                if (!response.ok) throw new Error(`HTTP Error! Status: ${response.status}`);

                const data = await response.json();

                if (data.aktif && data.aktif.nomor_antrian) {
                    // PANGGILAN MASUK: Matikan semua media/video/YouTube agar suara antrean/sistem bersih
                    stopAllMedia();
                    
                    containerVideo.classList.add('hidden');
                    containerAktif.classList.remove('hidden');

                    document.getElementById('layanan-aktif').textContent = data.aktif.layanan?.nama_layanan ?? 'Layanan';
                    document.getElementById('nomor-aktif').textContent = data.aktif.nomor_antrian ?? '---';
                    document.getElementById('pengunjung-aktif').textContent = data.aktif.pengunjung?.nama ?? 'Umum';
                } else {
                    // TIDAK ADA PANGGILAN: Putar video/playlist
                    tampilkanVideo();
                }

                nextContainer.innerHTML = '';
                if (data.next && data.next.length > 0) {
                    data.next.forEach(item => {
                        const card = document.createElement('div');
                        card.className = 'bg-slate-800 rounded-xl border border-slate-700 p-4 flex justify-between items-center shadow-md';
                        card.innerHTML = `
                            <div>
                                <span class="text-slate-300 font-bold">${item.layanan?.nama_layanan ?? 'Layanan'}</span>
                                <p class="text-xs text-slate-400">Status: Menunggu</p>
                            </div>
                            <div class="text-2xl font-bold text-slate-300">${item.nomor_antrian}</div>
                        `;
                        nextContainer.appendChild(card);
                    });
                } else {
                    nextContainer.innerHTML = `<div class="bg-slate-800 rounded-xl p-5 text-center text-slate-400">Tidak ada antrean menunggu</div>`;
                }

            } catch (error) {
                console.error("Gagal mengambil data antrean:", error);
                tampilkanVideo();
                nextContainer.innerHTML = `<div class="bg-slate-800 rounded-xl p-5 text-center text-slate-400">Tidak ada antrean menunggu</div>`;
            }
        }

        setInterval(() => {
            if (isStarted) fetchAntrianData();
        }, 3000);
    </script>
</body>
</html>