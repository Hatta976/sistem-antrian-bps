<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Antrean Terpadu BPS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-100 min-h-screen flex flex-col justify-between font-sans">

    <!-- Container Utama -->
    <div class="max-w-6xl w-full mx-auto p-8 my-auto space-y-6">

        <!-- Notifikasi Pesan -->
        @if(session('success'))
            <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl shadow-sm font-bold text-center">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        <!-- Grid Card Layanan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($layanans as $index => $layanan)
                @php
                    // Ambil kode dari DB, atau fallback berdasarkan urutan/ID (0=A, 1=B, 2=C, 3=D, dst.)
                    $kode = strtoupper($layanan->kode_layanan ?? $layanan->kode ?? chr(65 + $index));
                @endphp

                <form action="{{ route('kios.store') }}" method="POST" class="w-full">
                    @csrf
                    <!-- Kirim ID Layanan secara dinamis -->
                    <input type="hidden" name="layanan_id" value="{{ $layanan->id }}">

                    <button type="submit" class="w-full bg-white hover:bg-slate-50 border-2 border-blue-500 rounded-3xl p-6 shadow-md hover:shadow-xl transition-all duration-200 flex items-center justify-between text-left group">
                        
                        <!-- Info Layanan -->
                        <div class="space-y-2">
                            <!-- Badge Kode Dinamis (A, B, C, dst) -->
                            <span class="inline-block bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                KODE: {{ $kode }}
                            </span>
                            
                            <h2 class="text-2xl font-bold text-slate-800 group-hover:text-blue-600 transition">
                                {{ $layanan->nama_layanan }}
                            </h2>
                            
                            <p class="text-slate-400 text-sm">
                                Klik untuk mengambil nomor antrean
                            </p>
                        </div>

                        <!-- Icon Tombol Biru -->
                        <div class="w-14 h-14 bg-blue-600 group-hover:bg-blue-700 text-white rounded-2xl flex items-center justify-center text-xl shadow-md transition-all group-hover:scale-105">
                            <i class="fas fa-ticket-alt"></i>
                        </div>

                    </button>
                </form>
            @empty
                <div class="col-span-2 text-center py-12 text-slate-400">
                    Belum ada data layanan di database.
                </div>
            @endforelse
        </div>

    </div>

    <!-- Footer -->
    <footer class="py-4 text-center text-sm text-slate-500">
        Sistem Antrean Terpadu BPS &copy; {{ date('Y') }}
    </footer>

</body>
</html>