<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Antrean Terpadu BPS Kota Prabumulih</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-100 min-h-screen flex flex-col justify-between font-sans selection:bg-blue-500 selection:text-white">

    <!-- ================= BACKGROUND FOTO GEDUNG BPS TRANSPARAN ================= -->
    <div class="fixed inset-0 z-0 bg-cover bg-center bg-no-repeat opacity-15 pointer-events-none"
         style="background-image: url('{{ asset('img/overlay.png') }}');">
    </div>
    <!-- ========================================================================= -->

    <!-- Container Utama -->
    <div class="max-w-6xl w-full mx-auto p-6 md:p-8 my-auto space-y-8 relative z-10">

        <!-- Banner Selamat Datang -->
        <div class="bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700 text-white p-8 md:p-10 rounded-3xl shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">

            <div class="space-y-4 text-center md:text-left z-10 max-w-2xl">
                <!-- Badge dengan Logo BPS & Tulisan Satker -->
                <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/20 text-white text-xs md:text-sm font-semibold px-4 py-2 rounded-full uppercase tracking-wider shadow-sm">
                    <img src="{{ asset('img/logo-bps.png') }}" alt="Logo BPS" class="h-9 md:h-10 w-auto object-contain shrink-0">
                    <span class="border-l border-white/30 pl-3">Badan Pusat Statistik Kota Prabumulih</span>
                </div>

                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight leading-tight">
                    Selamat Datang di Layanan Kami
                </h1>
                <p class="text-blue-100 text-sm md:text-base leading-relaxed">
                    Silakan pilih jenis layanan di bawah ini untuk mengambil nomor antrean secara mandiri dengan cepat dan mudah.
                </p>
            </div>

            <!-- Jam / Ikon Akses Cepat -->
            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-4 rounded-2xl flex items-center gap-4 z-10 shadow-inner shrink-0">
                <div class="w-12 h-12 bg-white text-blue-600 rounded-xl flex items-center justify-center text-2xl shadow-md">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <div class="text-left">
                    <p class="text-xs text-blue-200 font-medium">Butuh Bantuan?</p>
                    <p class="text-sm font-bold">Silakan Hubungi Petugas</p>
                </div>
            </div>
        </div>

        <!-- Notifikasi Pesan -->
        @if(session('success'))
            <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl shadow-sm font-bold text-center animate-bounce">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        <!-- Grid Card Layanan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- 1. Layanan PST -->
            <form action="{{ route('kios.store') }}" method="POST" class="w-full h-full">
                @csrf
                <input type="hidden" name="layanan_id" value="1">
                <button type="submit" class="w-full h-full bg-white hover:bg-slate-50 border-2 border-blue-500 rounded-3xl p-6 shadow-md hover:shadow-xl transition-all duration-300 flex items-center justify-between text-left group relative overflow-hidden">
                    <div class="space-y-3 z-10 relative">
                        <span class="inline-block bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                            KODE: A
                        </span>
                        
                        <h2 class="text-xl md:text-2xl font-bold text-slate-800 group-hover:text-blue-600 transition">
                            Layanan PST
                        </h2>
                        <p class="text-slate-400 text-sm">Klik untuk mengambil nomor antrean</p>
                    </div>
                    
                    <div class="w-14 h-14 bg-blue-600 group-hover:bg-blue-700 text-white rounded-2xl flex items-center justify-center text-xl shadow-md transition-all duration-300 group-hover:scale-105 shrink-0 ml-4 z-10 relative">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                </button>
            </form>

            <!-- 2. Layanan Khusus Disabilitas -->
            <form action="{{ route('kios.store') }}" method="POST" class="w-full h-full">
                @csrf
                <input type="hidden" name="layanan_id" value="2">
                <button type="submit" class="w-full h-full bg-white hover:bg-slate-50 border-2 border-purple-500 rounded-3xl p-6 shadow-md hover:shadow-xl transition-all duration-300 flex items-center justify-between text-left group relative overflow-hidden">
                    <div class="space-y-3 z-10 relative">
                        <span class="inline-block bg-purple-100 text-purple-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                            KODE: B
                        </span>
                        <h2 class="text-xl md:text-2xl font-bold text-slate-800 group-hover:text-purple-600 transition">
                            Layanan Khusus Disabilitas
                        </h2>
                        <p class="text-slate-400 text-sm">Klik untuk mengambil nomor antrean</p>
                    </div>
                    <div class="w-14 h-14 bg-purple-600 group-hover:bg-purple-700 text-white rounded-2xl flex items-center justify-center text-xl shadow-md transition-all duration-300 group-hover:scale-105 shrink-0 ml-4 z-10 relative">
                        <i class="fas fa-wheelchair"></i>
                    </div>
                </button>
            </form>

            <!-- 3. Layanan Pengaduan -->
            <form action="{{ route('kios.store') }}" method="POST" class="w-full h-full">
                @csrf
                <input type="hidden" name="layanan_id" value="3">
                <button type="submit" class="w-full h-full bg-white hover:bg-slate-50 border-2 border-amber-500 rounded-3xl p-6 shadow-md hover:shadow-xl transition-all duration-300 flex items-center justify-between text-left group relative overflow-hidden">
                    <div class="space-y-3 z-10 relative">
                        <span class="inline-block bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                            KODE: C
                        </span>
                        <h2 class="text-xl md:text-2xl font-bold text-slate-800 group-hover:text-amber-600 transition">
                            Layanan Pengaduan
                        </h2>
                        <p class="text-slate-400 text-sm">Klik untuk mengambil nomor antrean</p>
                    </div>
                    <div class="w-14 h-14 bg-amber-500 group-hover:bg-amber-600 text-white rounded-2xl flex items-center justify-center text-xl shadow-md transition-all duration-300 group-hover:scale-105 shrink-0 ml-4 z-10 relative">
                        <i class="fas fa-headset"></i>
                    </div>
                </button>
            </form>

            <!-- 4. Layanan PPID -->
            <form action="{{ route('kios.store') }}" method="POST" class="w-full h-full">
                @csrf
                <input type="hidden" name="layanan_id" value="4">
                <button type="submit" class="w-full h-full bg-white hover:bg-slate-50 border-2 border-emerald-500 rounded-3xl p-6 shadow-md hover:shadow-xl transition-all duration-300 flex items-center justify-between text-left group relative overflow-hidden">
                    <div class="space-y-3 z-10 relative">
                        <span class="inline-block bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                            KODE: D
                        </span>

                        <h2 class="text-xl md:text-2xl font-bold text-slate-800 group-hover:text-emerald-600 transition">
                            Layanan PPID
                        </h2>
                        <p class="text-slate-400 text-sm">Klik untuk mengambil nomor antrean</p>
                    </div>

                    <div class="w-14 h-14 bg-emerald-600 group-hover:bg-emerald-700 text-white rounded-2xl flex items-center justify-center text-xl shadow-md transition-all duration-300 group-hover:scale-105 shrink-0 ml-4 z-10 relative">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </button>
            </form>

        </div>

    </div>

    <!-- Footer -->
    <footer class="py-4 text-center text-sm text-slate-500">
        Sistem Antrean Terpadu BPS &copy; {{ date('Y') }}
    </footer>

</body>
</html>