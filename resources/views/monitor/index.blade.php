<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor Antrean - BPS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-900 text-white min-h-screen flex flex-col justify-between font-sans">

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
            
            <!-- TAMPILAN 1: PANGGILAN ANTREAN (Aktif jika data.aktif ada) -->
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

            <!-- TAMPILAN 2: VIDEO PLAYER (Aktif jika data.aktif kosong atau error) -->
            <div id="container-video" class="hidden absolute inset-0 w-full h-full bg-black flex items-center justify-center">
                <video id="video-player" class="w-full h-full object-cover" autoplay loop playsinline>
                    <source src="{{ asset('img/video.mp4') }}" type="video/mp4">
                    Browser Anda tidak mendukung pemutar video.
                </video>
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
    <footer class="bg-blue-950 border-t border-blue-900 py-3 px-6 flex items-center overflow-hidden">
        <div class="bg-blue-600 text-white text-xs font-bold uppercase px-3 py-1 rounded mr-4 whitespace-nowrap">
            Informasi
        </div>
        <marquee class="text-slate-300 text-sm">
            Selamat Datang di Badan Pusat Statistik. Jam Layanan Operasional: Senin - Kamis (08.00 - 15.00 WIB), Jumat (08.00 - 15.30 WIB).
        </marquee>
    </footer>

    <!-- SCRIPT JAM & REALTIME FETCHING -->
    <script>
        // 1. Update Jam Digital
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

        // Helper Function untuk Menampilkan Video
        function tampilkanVideo() {
            const containerAktif = document.getElementById('container-aktif');
            const containerVideo = document.getElementById('container-video');
            const videoPlayer = document.getElementById('video-player');

            if (containerAktif && containerVideo) {
                containerAktif.classList.add('hidden');
                containerVideo.classList.remove('hidden');

                if (videoPlayer && videoPlayer.paused) {
                    videoPlayer.play().catch(err => console.log("Autoplay video ditahan browser:", err));
                }
            }
        }

        // 2. Fetch Data dari MonitorController@getData
        async function fetchAntrianData() {
            const containerAktif = document.getElementById('container-aktif');
            const containerVideo = document.getElementById('container-video');
            const videoPlayer = document.getElementById('video-player');
            const nextContainer = document.getElementById('next-container');

            try {
                const response = await fetch("{{ route('monitor.data') }}");
                
                if (!response.ok) {
                    throw new Error(`HTTP Error! Status: ${response.status}`);
                }

                const data = await response.json();

                // KONDISI 1: ADA ANTREAN DIPANGGIL
                if (data.aktif && data.aktif.nomor_antrian) {
                    containerVideo.classList.add('hidden');
                    containerAktif.classList.remove('hidden');
                    
                    if (videoPlayer) {
                        videoPlayer.pause();
                    }

                    document.getElementById('layanan-aktif').textContent = data.aktif.layanan?.nama_layanan ?? 'Layanan';
                    document.getElementById('nomor-aktif').textContent = data.aktif.nomor_antrian ?? '---';
                    document.getElementById('pengunjung-aktif').textContent = data.aktif.pengunjung?.nama ?? 'Umum';
                } 
                // KONDISI 2: TIDAK ADA ANTREAN DIPANGGIL
                else {
                    tampilkanVideo();
                }

                // UPDATE LIST ANTREAN MENUNGGU
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
                // JIKA FETCH ERROR -> TAMPILKAN VIDEO AGAR TAMPILAN TIDAK STUCK
                tampilkanVideo();
                nextContainer.innerHTML = `<div class="bg-slate-800 rounded-xl p-5 text-center text-slate-400">Tidak ada antrean menunggu</div>`;
            }
        }

        // Auto-refresh data tiap 3 detik
        setInterval(fetchAntrianData, 3000);
        fetchAntrianData();
    </script>
</body>
</html>