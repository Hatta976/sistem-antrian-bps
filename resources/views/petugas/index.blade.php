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
<body class="bg-slate-100 min-h-screen font-sans p-6">

    <div class="max-w-6xl mx-auto space-y-6">
        
        <!-- Header -->
        <div class="bg-blue-900 text-white rounded-2xl p-6 shadow-lg flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">DASHBOARD PETUGAS LOKET</h1>
                <p class="text-blue-200 text-sm">Sistem Pemanggilan Antrean BPS</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="bg-blue-800/80 border border-blue-700 px-4 py-2 rounded-xl text-right">
                    <div id="liveClock" class="text-xl font-mono font-bold tracking-wider text-amber-300">00:00:00 WIB</div>
                    <div id="liveDate" class="text-[11px] text-blue-200">...</div>
                </div>

                <a href="{{ route('kios.index') }}" target="_blank" class="bg-blue-700 hover:bg-blue-600 px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                    <i class="fas fa-external-link-alt"></i> Buka Kios Tiket
                </a>
            </div>
        </div>

        <!-- Alert Pesan Dynamic -->
        <div id="alertContainer"></div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Panel Tombol Panggil -->
            <div class="bg-white p-6 rounded-2xl shadow-md space-y-6 md:col-span-1 border border-slate-200">
                <h2 class="text-lg font-bold text-slate-800 border-b pb-3">
                    <i class="fas fa-bullhorn text-blue-600 mr-2"></i> Area Pemanggilan
                </h2>
                
                <!-- Form AJAX (Dipanggil via JS) -->
                <form id="formPanggil" action="{{ route('petugas.panggil') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Pilih Loket Anda:</label>
                        <select name="loket" id="loketSelect" class="w-full border-slate-300 rounded-lg p-3 border focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="Loket 1">Loket 1</option>
                            <option value="Loket 2">Loket 2</option>
                            <option value="Loket 3">Loket 3</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Filter Layanan (Opsional):</label>
                        <select name="layanan_id" id="layananSelect" class="w-full border-slate-300 rounded-lg p-3 border focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">-- Semua Layanan --</option>
                            @foreach($layanans as $l)
                                <option value="{{ $l->id }}">{{ $l->nama_layanan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" id="btnPanggil" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-xl shadow-lg hover:shadow-xl transition flex items-center justify-center gap-2 text-lg active:scale-95">
                        <i class="fas fa-volume-up"></i> PANGGIL ANTREAN
                    </button>
                </form>

                <!-- Tombol Tes Suara -->
                <button onclick="playVoice('A-001', 'Loket 1')" class="w-full border border-slate-300 text-slate-600 hover:bg-slate-50 font-bold py-2 rounded-lg text-xs transition flex items-center justify-center gap-2">
                    <i class="fas fa-vial"></i> Tes Suara Pemanggilan
                </button>
            </div>

            <!-- Panel Status Dipanggil & Sisa Antrean -->
            <div id="mainDashboard" class="md:col-span-2 space-y-6">
                
                <!-- Terakhir Dipanggil -->
                <div class="bg-white p-6 rounded-2xl shadow-md border-l-8 border-blue-600">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Terakhir Dipanggil</span>
                    @if($antrianDipanggil)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-2">
                            <div>
                                <h3 class="text-5xl font-black text-blue-600 tracking-wider">{{ $antrianDipanggil->nomor_antrian }}</h3>
                                <p class="text-slate-600 font-semibold mt-1">{{ $antrianDipanggil->layanan->nama_layanan ?? '-' }}</p>
                            </div>
                            
                            <div class="flex flex-col items-start sm:items-end gap-2">
                                <span class="bg-blue-100 text-blue-800 font-bold px-4 py-2 rounded-lg text-lg">
                                    {{ $antrianDipanggil->loket ?? 'Loket -' }}
                                </span>

                                <form action="{{ route('petugas.antrian.selesai', $antrianDipanggil->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-2 rounded-lg text-sm transition flex items-center gap-2 shadow">
                                        <i class="fas fa-check-circle"></i> Selesaikan
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <p class="text-slate-400 my-4 italic">Belum ada antrean yang dipanggil hari ini.</p>
                    @endif
                </div>

                <!-- Section Grid 2 Kolom: Menunggu & Selesai -->
                <div id="section-antrean" class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Daftar Antrean Menunggu -->
                    <div class="bg-white p-5 rounded-2xl shadow-md border border-slate-200">
                        <h3 class="text-md font-bold text-slate-800 mb-4 flex justify-between items-center">
                            <span><i class="fas fa-clock text-amber-500 mr-2"></i> Menunggu</span>
                            <span class="bg-amber-100 text-amber-800 text-xs px-2.5 py-1 rounded-full font-bold">
                                {{ $antrianMenunggu->count() }}
                            </span>
                        </h3>

                        <div class="overflow-x-auto max-h-80 overflow-y-auto">
                            <table class="w-full text-left text-sm text-slate-600">
                                <thead class="bg-slate-50 text-slate-700 uppercase text-xs sticky top-0">
                                    <tr>
                                        <th class="p-2">NO.</th>
                                        <th class="p-2">LAYANAN</th>
                                        <th class="p-2">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @forelse($antrianMenunggu as $a)
                                        <tr>
                                            <td class="p-2 font-bold text-blue-600">{{ $a->nomor_antrian }}</td>
                                            <td class="p-2 text-xs">{{ $a->layanan->nama_layanan ?? '-' }}</td>
                                            <td class="p-2">
                                                <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2 py-0.5 rounded">Menunggu</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="p-4 text-center text-slate-400 italic text-xs">Kosong</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Daftar Antrean Selesai -->
                    <div class="bg-white p-5 rounded-2xl shadow-md border border-slate-200">
                        <h3 class="text-md font-bold text-slate-800 mb-4 flex justify-between items-center">
                            <span><i class="fas fa-check-circle text-emerald-500 mr-2"></i> Selesai</span>
                            <span class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-full font-bold">
                                {{ isset($antrianSelesai) ? $antrianSelesai->count() : 0 }}
                            </span>
                        </h3>

                        <div class="overflow-x-auto max-h-80 overflow-y-auto">
                            <table class="w-full text-left text-sm text-slate-600">
                                <thead class="bg-slate-50 text-slate-700 uppercase text-xs sticky top-0">
                                    <tr>
                                        <th class="p-2">NO.</th>
                                        <th class="p-2">LOKET</th>
                                        <th class="p-2">WAKTU SELESAI</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @if(isset($antrianSelesai))
                                        @forelse($antrianSelesai as $s)
                                            <tr>
                                                <td class="p-2 font-bold text-emerald-600 line-through">{{ $s->nomor_antrian }}</td>
                                                <td class="p-2 text-xs">
                                                    <span class="bg-slate-100 text-slate-700 px-1.5 py-0.5 rounded font-semibold">{{ $s->loket ?? '-' }}</span>
                                                </td>
                                                <td class="p-2 text-xs text-slate-500 font-mono">
                                                    {{ $s->updated_at->timezone('Asia/Jakarta')->format('H:i:s') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="p-4 text-center text-slate-400 italic text-xs">Belum ada yang selesai</td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="3" class="p-4 text-center text-slate-400 italic text-xs">Belum ada data</td>
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

        // 2. Modul Audio Engine
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
            
            // Ting
            const osc1 = audioCtx.createOscillator();
            const gain1 = audioCtx.createGain();
            osc1.type = 'sine';
            osc1.frequency.setValueAtTime(659.25, now);
            gain1.gain.setValueAtTime(0.3, now);
            gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.8);
            osc1.connect(gain1);
            gain1.connect(audioCtx.destination);
            osc1.start(now);
            osc1.stop(now + 0.8);

            // Tong
            const osc2 = audioCtx.createOscillator();
            const gain2 = audioCtx.createGain();
            osc2.type = 'sine';
            osc2.frequency.setValueAtTime(523.25, now + 0.4);
            gain2.gain.setValueAtTime(0.3, now + 0.4);
            gain2.gain.exponentialRampToValueAtTime(0.001, now + 1.6);
            osc2.connect(gain2);
            gain2.connect(audioCtx.destination);
            osc2.start(now + 0.4);
            osc2.stop(now + 1.6);

            setTimeout(() => {
                if (callback) callback();
            }, 1200);
        }

        function speakText(teks) {
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                const utterance = new SpeechSynthesisUtterance(teks);
                utterance.rate = 0.85;
                utterance.pitch = 1;
                utterance.lang = 'id-ID';

                const voices = window.speechSynthesis.getVoices();
                const idVoice = voices.find(v => v.lang.includes('id') || v.lang.includes('ID'));
                if (idVoice) utterance.voice = idVoice;

                window.speechSynthesis.speak(utterance);
            }
        }

        function playVoice(nomor, loket) {
            const parsedNomor = nomor.replace('-', ' '); 
            const teksPanggilan = `Nomor antrean ${parsedNomor}, silakan menuju ke ${loket}.`;
            playChime(() => speakText(teksPanggilan));
        }

        // 3. Proses Panggil via AJAX (Bebas Reload & Suara Langsung Bunyi)
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
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;

                if (data.status === 'success') {
                    // Refresh tampilan panel kanan
                    refreshDashboard();
                    
                    // Bunyikan Suara Pemanggilan!
                    playVoice(data.antrian.nomor_antrian, data.antrian.loket);

                    // Tampilkan Notifikasi
                    showAlert('success', data.message);
                } else {
                    showAlert('error', data.message || 'Tidak ada antrean tersisa.');
                }
            })
            .catch(err => {
                btn.disabled = false;
                console.error(err);
            });
        });

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
            const color = type === 'success' ? 'emerald' : 'rose';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
            
            container.innerHTML = `
                <div class="bg-${color}-100 border-l-4 border-${color}-500 text-${color}-800 p-4 rounded shadow-sm mb-4">
                    <i class="fas ${icon} mr-2"></i>${text}
                </div>
            `;
            setTimeout(() => { container.innerHTML = ''; }, 4000);
        }

        // Auto Refresh Tabel tiap 4 detik
        setInterval(refreshDashboard, 4000);
    </script>
</body>
</html>