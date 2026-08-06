<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Antrean - {{ $antrian->nomor_antrian }}</title>
    <style>
        @media print {
            @page {
                margin: 0;
                size: 80mm auto; /* Ukuran lebar kertas printer kasir/thermal */
            }
            body {
                margin: 5mm;
            }
            .no-print {
                display: none;
            }
        }
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
        .btn-back {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 15px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-family: sans-serif;
            font-size: 12px;
        }
    </style>
</head>
<body onload="window.print();">

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

    <!-- Tombol kembali yang tersembunyi saat di-print -->
    <div class="no-print">
        <a href="{{ route('kios.index') }}" class="btn-back">← Kembali ke Kios</a>
    </div>

</body>
</html>