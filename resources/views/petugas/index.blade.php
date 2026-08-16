<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Petugas Loket - BPS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-slate-100 via-blue-50/30 to-slate-100 min-h-screen font-sans p-6 text-slate-800">

    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header Modern -->
        <div class="bg-gradient-to-r from-blue-900 via-blue-800 to-indigo-900 text-white rounded-3xl p-6 md:p-8 shadow-xl flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -left-10 -top-10 w-48 h-48 bg-blue-500/20 rounded-full blur-2xl pointer-events-none"></div>

            <div class="space-y-1.5 z-10 text-center md:text-left">
                <span class="bg-blue-600/50 border border-blue-400/30 text-blue-100 text-xs font-semibold px-4 py-1.5 rounded-full uppercase tracking-wider">
                    <i class="fas fa-shield-alt mr-1.5"></i> Panel Kontrol Petugas
                </span>
                <h1 class="text-2xl md:text-3xl font-black tracking-tight">DASHBOARD LOKET PELAYANAN</h1>
                <p class="text-blue-200 text-sm">Sistem Pemanggilan Antrean Terpadu BPS</p>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-4 z-10">
                <div class="bg-blue-950/60 backdrop-blur-md border border-blue-700/50 px-5 py-3 rounded-2xl text-right shadow-inner">
                    <div id="liveClock" class="text-xl font-mono font-bold tracking-wider text-amber-300">00:00:00 WIB</div>
                    <div id="liveDate" class="text-xs text-blue-200">...</div>
                </div>

                <a href="{{ route('kios.index') }}" target="_blank" class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-3.5 rounded-2xl text-sm font-bold transition-all shadow-lg hover:shadow-blue-500/30 flex items-center gap-2 active:scale-95">
                    <i class="fas fa-external-link-alt"></i> Kios Tiket
                </a>
            </div>
        </div>

        <!-- Alert Pesan Dynamic -->
        <div id="alertContainer"></div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Panel Tombol Panggil -->
            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xl space-y-6 lg:col-span-1 border border-slate-200/80 flex flex-col justify-between">
                <div class="space-y-6">
                    <h2 class="text-lg font-extrabold text-slate-800 border-b border-slate-100 pb-4 flex items-center">
                        <span class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mr-3 shadow-sm">
                            <i class="fas fa-bullhorn"></i>
                        </span>
                        Area Pemanggilan
                    </h2>
                    
                    <!-- Form Panggil Utama -->
                    <form id="formPanggil" action="{{ route('petugas.panggil') }}" method="POST" class="space-y-5">
                        @csrf
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Pilih Loket Anda:</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-blue-600">
                                    <i class="fas fa-desktop"></i>
                                </span>
                                <select name="loket" id="loketSelect" class="w-full bg-slate-50 border border-slate-300 rounded-2xl py-3.5 pl-12 pr-4 text-slate-700 font-semibold focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition">
                                    <option value="Meja Pelayanan Konsultasi Statistik">Meja Pelayanan Konsultasi Statistik</option>
                                    <option value="Meja Pelayanan Khusus Disabilitas">Meja Pelayanan Khusus Disabilitas</option>
                                    <option value="Meja Pelayanan PPID">Meja Pelayanan PPID</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Filter Layanan (Opsional):</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-blue-600">
                                    <i class="fas fa-filter"></i>
                                </span>
                                <select name="layanan_id" id="layananSelect" class="w-full bg-slate-50 border border-slate-300 rounded-2xl py-3.5 pl-12 pr-4 text-slate-700 font-semibold focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition">
                                    <option value="">-- Semua Layanan --</option>
                                    @foreach($layanans as $l)
                                        <option value="{{ $l->id }}">{{ $l->nama_layanan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button type="submit" id="btnPanggil" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-blue-600/30 hover:shadow-xl transition-all flex items-center justify-center gap-3 text-lg active:scale-95">
                            <i class="fas fa-volume-up text-xl"></i> PANGGIL ANTREAN
                        </button>
                    </form>
                </div>

                <!-- Tombol Tes Suara -->
                <div class="pt-4 border-t border-slate-100">
                    <button onclick="playVoiceTest()" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-3 rounded-xl text-xs transition flex items-center justify-center gap-2">
                        <i class="fas fa-vial text-blue-600"></i> Tes Suara Pemanggilan Speaker
                    </button>
                </div>
            </div>

            <!-- Panel Status Dipanggil & Sisa Antrean -->
            <div id="mainDashboard" class="lg:col-span-2 space-y-6">
                
                <!-- Terakhir Dipanggil -->
                <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xl border-l-8 border-blue-600 relative overflow-hidden">
                    
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                        <i class="fas fa-broadcast-tower text-blue-600"></i> Sedang Dilayani / Terakhir Dipanggil
                    </span>
                    
                    @if($antrianDipanggil)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mt-4">
                            <div>
                                <h3 class="text-5xl md:text-6xl font-black text-blue-600 tracking-wider font-mono">{{ $antrianDipanggil->nomor_antrian }}</h3>
                                <p class="text-slate-700 font-bold text-lg mt-2">{{ $antrianDipanggil->layanan->nama_layanan ?? '-' }}</p>
                            </div>
                            
                            <div class="flex flex-col items-start sm:items-end gap-3">
                                <span class="bg-blue-100 text-blue-800 font-extrabold px-5 py-2.5 rounded-xl text-base shadow-sm border border-blue-200">
                                    <i class="fas fa-map-marker-alt mr-1 text-blue-600"></i> {{ $antrianDipanggil->loket ?? 'Loket -' }}
                                </span>

                                <div class="flex flex-wrap items-center gap-2">
                                    <!-- Tombol Panggil Ulang (Memperbarui Meja Loket Terkini secara Server-Side) -->
                                    <button type="button" 
                                            onclick="prosesPanggilUlang('{{ route('petugas.panggilUlang', $antrianDipanggil->id) }}')" 
                                            class="bg-amber-500 hover:bg-amber-600 text-white font-bold px-5 py-3 rounded-xl text-sm transition shadow-lg shadow-amber-500/20 flex items-center gap-2 active:scale-95">
                                        <i class="fas fa-redo text-lg"></i> Panggil Ulang
                                    </button>

                                    <!-- Tombol Selesaikan Antrean -->
                                    <form action="{{ route('petugas.antrian.selesai', $antrianDipanggil->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-3 rounded-xl text-sm transition shadow-lg shadow-emerald-600/20 flex items-center gap-2 active:scale-95">
                                            <i class="fas fa-check-circle text-lg"></i> Selesaikan Antrean
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="py-8 text-center">
                            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-3 text-2xl">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <p class="text-slate-400 font-medium italic">Belum ada antrean yang dipanggil hari ini.</p>
                        </div>
                    @endif
                </div>

                <!-- Section Grid 2 Kolom: Menunggu & Selesai -->
                <div id="section-antrean" class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Daftar Antrean Menunggu -->
                    <div class="bg-white p-6 rounded-3xl shadow-xl border border-slate-200/80 space-y-4">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                            <h3 class="font-bold text-slate-800 flex items-center">
                                <i class="fas fa-clock text-amber-500 mr-2 text-lg"></i> Menunggu
                            </h3>
                            <span class="bg-amber-100 text-amber-800 text-xs px-3 py-1 rounded-full font-black">
                                {{ $antrianMenunggu->count() }} Antrean
                            </span>
                        </div>

                        <div class="overflow-x-auto max-h-72 overflow-y-auto pr-1">
                            <table class="w-full text-left text-sm text-slate-600">
                                <thead class="bg-slate-50 text-slate-700 uppercase text-[11px] sticky top-0 tracking-wider">
                                    <tr>
                                        <th class="p-3 rounded-l-xl">NO.</th>
                                        <th class="p-3">LAYANAN</th>
                                        <th class="p-3 rounded-r-xl">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($antrianMenunggu as $a)
                                        <tr class="hover:bg-slate-50/80 transition">
                                            <td class="p-3 font-extrabold text-blue-600 font-mono">{{ $a->nomor_antrian }}</td>
                                            <td class="p-3 text-xs font-medium">{{ $a->layanan->nama_layanan ?? '-' }}</td>
                                            <td class="p-3">
                                                <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2.5 py-1 rounded-lg">Menunggu</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="p-8 text-center text-slate-400 italic text-xs">Belum ada antrean menunggu</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Daftar Antrean Selesai -->
                    <div class="bg-white p-6 rounded-3xl shadow-xl border border-slate-200/80 space-y-4">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                            <h3 class="font-bold text-slate-800 flex items-center">
                                <i class="fas fa-check-circle text-emerald-500 mr-2 text-lg"></i> Selesai Dilayani
                            </h3>
                            <span class="bg-emerald-100 text-emerald-800 text-xs px-3 py-1 rounded-full font-black">
                                {{ isset($antrianSelesai) ? $antrianSelesai->count() : 0 }} Selesai
                            </span>
                        </div>

                        <div class="overflow-x-auto max-h-72 overflow-y-auto pr-1">
                            <table class="w-full text-left text-sm text-slate-600">
                                <thead class="bg-slate-50 text-slate-700 uppercase text-[11px] sticky top-0 tracking-wider">
                                    <tr>
                                        <th class="p-3 rounded-l-xl">NO.</th>
                                        <th class="p-3">LOKET</th>
                                        <th class="p-3 rounded-r-xl">WAKTU</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @if(isset($antrianSelesai))
                                        @forelse($antrianSelesai as $s)
                                            <tr class="hover:bg-slate-50/80 transition">
                                                <td class="p-3 font-extrabold text-emerald-600 font-mono line-through">{{ $s->nomor_antrian }}</td>
                                                <td class="p-3 text-xs">
                                                    <span class="bg-slate-100 text-slate-700 px-2 py-1 rounded-lg font-semibold">{{ $s->loket ?? '-' }}</span>
                                                </td>
                                                <td class="p-3 text-xs text-slate-500 font-mono">
                                                    {{ $s->updated_at->timezone('Asia/Jakarta')->format('H:i:s') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="p-8 text-center text-slate-400 italic text-xs">Belum ada yang selesai</td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="3" class="p-8 text-center text-slate-400 italic text-xs">Belum ada data</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Script Utama -->
    <script>
        // 1. Jam Digital Real-Time
        function updateLiveClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            
            document.getElementById('liveClock').innerText = `${hours}:${minutes}:${seconds} WIB`;
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('liveDate').innerText = now.toLocaleDateString('id-ID', options);
        }
        setInterval(updateLiveClock, 1000);
        updateLiveClock();

        // 2. Audio Engine
        let audioCtx = null;

        function unlockAudio() {
            if (!audioCtx) {
                audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
        }
        document.addEventListener('click', unlockAudio, { once: true });

        function playChime(callback) {
            unlockAudio();
            const now = audioCtx.currentTime;
            
            const masterGain = audioCtx.createGain();
            masterGain.gain.setValueAtTime(1.5, now);
            masterGain.connect(audioCtx.destination);

            // Ting
            const osc1 = audioCtx.createOscillator();
            const gain1 = audioCtx.createGain();
            osc1.type = 'sine';
            osc1.frequency.setValueAtTime(659.25, now);
            gain1.gain.setValueAtTime(0.5, now);
            gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.9);
            osc1.connect(gain1);
            gain1.connect(masterGain);
            osc1.start(now);
            osc1.stop(now + 0.9);

            // Tong
            const osc2 = audioCtx.createOscillator();
            const gain2 = audioCtx.createGain();
            osc2.type = 'sine';
            osc2.frequency.setValueAtTime(523.25, now + 0.4);
            gain2.gain.setValueAtTime(0.5, now + 0.4);
            gain2.gain.exponentialRampToValueAtTime(0.001, now + 1.8);
            osc2.connect(gain2);
            gain2.connect(masterGain);
            osc2.start(now + 0.4);
            osc2.stop(now + 1.8);

            setTimeout(() => {
                if (callback) callback();
            }, 1200);
        }

        function speakText(teks) {
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                const utterance = new SpeechSynthesisUtterance(teks);
                utterance.rate = 0.82;
                utterance.pitch = 1.05;
                utterance.volume = 1.0;
                utterance.lang = 'id-ID';

                const voices = window.speechSynthesis.getVoices();
                const idVoice = voices.find(v => v.lang.includes('id') || v.lang.includes('ID'));
                if (idVoice) utterance.voice = idVoice;

                window.speechSynthesis.speak(utterance);
            }
        }

        function playVoice(nomor, loket) {
            const parsedNomor = nomor.replace('-', ' '); 
            const mejaAktif = loket || document.getElementById('loketSelect').value;
            const teksPanggilan = `Nomor antrean, ${parsedNomor}, silakan menuju ke ${mejaAktif}`;
            
            playChime(() => speakText(teksPanggilan));
        }

        function playVoiceTest() {
            const loketSelected = document.getElementById('loketSelect').value;
            playVoice('A-001', loketSelected);
        }

        // 3. Panggil Baru via Form AJAX
        document.getElementById('formPanggil').addEventListener('submit', function(e) {
            e.preventDefault();
            unlockAudio();

            const form = this;
            const formData = new FormData(form);
            const btn = document.getElementById('btnPanggil');
            btn.disabled = true;

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;

                if (data.status === 'success') {
                    refreshDashboard();
                    showAlert('success', data.message);

                    setTimeout(() => {
                        playVoice(data.antrian.nomor_antrian, data.antrian.loket);
                    }, 800);

                } else {
                    showAlert('error', data.message || 'Tidak ada antrean tersisa.');
                }
            })
            .catch(err => {
                btn.disabled = false;
                console.error(err);
            });
        });

        // 4. Panggil Ulang via AJAX (Mengirimkan Meja Loket Terkini ke Server)
        function prosesPanggilUlang(url) {
            unlockAudio();
            const loketDipilih = document.getElementById('loketSelect').value;

            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('loket', loketDipilih);

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    refreshDashboard();
                    showAlert('success', data.message);

                    setTimeout(() => {
                        playVoice(data.antrian.nomor_antrian, data.antrian.loket);
                    }, 500);
                } else {
                    showAlert('error', data.message || 'Gagal memanggil ulang.');
                }
            })
            .catch(err => console.error(err));
        }

        function refreshDashboard() {
            fetch(window.location.href)
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newDashboard = doc.getElementById('mainDashboard');
                    if (newDashboard) {
                        document.getElementById('mainDashboard').innerHTML = newDashboard.innerHTML;
                    }
                });
        }

        function showAlert(type, text) {
            const container = document.getElementById('alertContainer');
            const isSuccess = type === 'success';
            
            const bgColor = isSuccess ? 'bg-emerald-100' : 'bg-rose-100';
            const borderColor = isSuccess ? 'border-emerald-500' : 'border-rose-500';
            const textColor = isSuccess ? 'text-emerald-800' : 'text-rose-800';
            const icon = isSuccess ? 'fa-check-circle' : 'fa-exclamation-triangle';
            
            container.innerHTML = `
                <div class="${bgColor} border-l-4 ${borderColor} ${textColor} p-4 rounded-2xl shadow-sm mb-4 flex items-center font-bold">
                    <i class="fas ${icon} mr-3 text-lg"></i>${text}
                </div>
            `;
            setTimeout(() => { container.innerHTML = ''; }, 4000);
        }

        // Auto Refresh Tabel tiap 4 detik
        setInterval(refreshDashboard, 4000);
    </script>
</body>
</html>