<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Antrean - {{ $antrian->nomor_antrian }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            text-align: center;
            width: 70mm;
            margin: 0 auto;
            padding: 10px 0;
            color: #000;
        }
        .header {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .subheader {
            font-size: 11px;
            margin-bottom: 10px;
        }
        .line {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }
        .nomor {
            font-size: 38px;
            font-weight: bold;
            margin: 10px 0;
        }
        .layanan {
            font-size: 14px;
            font-weight: bold;
        }
        .footer {
            font-size: 10px;
            margin-top: 15px;
        }
        .btn-print {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            font-family: sans-serif;
            font-size: 14px;
            cursor: pointer;
        }
        .btn-back {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-family: sans-serif;
            font-size: 12px;
        }
        .no-print {
            margin-top: 15px;
        }
    </style>
</head>
<body onload="printViaBluetooth();">

    <div class="header">BADAN PUSAT STATISTIK</div>
    <div class="subheader">Pelayanan Statistik Terpadu</div>
    
    <div class="line"></div>

    <div style="font-size: 12px;">NOMOR ANTREAN</div>
    <div class="nomor">{{ $antrian->nomor_antrian }}</div>
    <div class="layanan">{{ $antrian->layanan->nama_layanan ?? 'Layanan Umum' }}</div>

    <div class="line"></div>

    <div class="footer">
        Tanggal: {{ \Carbon\Carbon::parse($antrian->tanggal)->format('d-m-Y') }}<br>
        Jam: {{ \Carbon\Carbon::parse($antrian->created_at)->format('H:i') }} WIB<br><br>
        * Silakan menunggu nomor dipanggil *<br>
        Terima Kasih
    </div>

    <!-- Tombol aksi yang tersembunyi saat di-print -->
    <div class="no-print">
        <button onclick="printViaBluetooth()" class="btn-print">🖨️ Cetak Ulang Bluetooth</button><br>
        <a href="{{ route('kios.index') }}" class="btn-back">← Kembali ke Kios</a>
    </div>

    <script>
        function printViaBluetooth() {
            // Format data teks dengan perintah ESC/POS sederhana untuk printer thermal
            var textToPrint = "\x1B\x40" + // Inisialisasi printer
                              "\x1B\x61\x01" + // Rata tengah (Center)
                              "BADAN PUSAT STATISTIK\n" +
                              "Pelayanan Statistik Terpadu\n" +
                              "--------------------------------\n" +
                              "NOMOR ANTREAN\n\n" +
                              "{{ $antrian->nomor_antrian }}\n\n" +
                              "{{ $antrian->layanan->nama_layanan ?? 'Layanan Umum' }}\n" +
                              "--------------------------------\n" +
                              "Tanggal: {{ \Carbon\Carbon::parse($antrian->tanggal)->format('d-m-Y') }}\n" +
                              "Jam: {{ \Carbon\Carbon::parse($antrian->created_at)->format('H:i') }} WIB\n\n" +
                              "* Silakan menunggu nomor anda dipanggil *\n" +
                              "Terima Kasih\n\n\n\n";

            // Mengirim data teks ke aplikasi perantara RawBT secara otomatis saat halaman terbuka
            window.location.href = "rawbt:" + encodeURIComponent(textToPrint);
            // Opsional: Setelah memicu cetak, otomatis kembali ke halaman kios setelah beberapa detik
            setTimeout(function() {
                window.location.href = "{{ route('kios.index') }}";
            }, 2000);
        }
    </script>

</body>
</html>