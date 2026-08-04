<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Antrean - BPS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-800 min-h-screen flex items-center justify-center p-4">

    <!-- Card Struk Tiket -->
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full text-center border-t-8 border-blue-600">
        <h2 class="font-extrabold text-xl text-slate-800">BADAN PUSAT STATISTIK</h2>
        <p class="text-xs text-slate-500 uppercase tracking-widest mt-1">Tiket Antrean Layanan</p>
        
        <hr class="my-4 border-dashed border-slate-300">

        <p class="text-sm font-semibold text-slate-600">{{ $antrian->layanan->nama_layanan }}</p>
        
        <!-- Nomor Antrean -->
        <div class="my-6">
            <span class="text-xs text-slate-400 block mb-1">Nomor Antrean Anda</span>
            <span class="text-6xl font-black text-blue-600 tracking-wider">{{ $antrian->nomor_antrian }}</span>
        </div>

        <p class="text-xs text-slate-500">Tanggal: {{ $antrian->tanggal }}</p>
        <p class="text-xs text-slate-400 mt-1">Harap menunggu nomor Anda dipanggil pada layar monitor.</p>

        <div class="mt-6 flex flex-col gap-2">
            <button onclick="window.print()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow transition">
                Cetak Tiket
            </button>
            <a href="{{ route('kios.index') }}" class="w-full bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold py-2 px-4 rounded-lg transition block">
                Kembali
            </a>
        </div>
    </div>

</body>
</html>