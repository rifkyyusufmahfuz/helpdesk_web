<!DOCTYPE html>
<html>

<head>
    <title>Permintaan Instalasi Software Ditolak</title>
    <style>
        /* Tambahkan gaya CSS untuk footer */
        .footer {
            /* font-size: 10px; */
            opacity: 0.7;
            /* Atur tingkat transparansi */
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
    </style>
</head>

<body>
    <h3>Layanan IT Helpdesk</h3>
    <h4>Sistem Informasi IT Helpdesk - PT KCI</h4>

    <p>Permintaan Instalasi Software dengan ID Permintaan <strong>"{{ $id_permintaan_formatted }}"</strong> belum dapat
        dilanjutkan.</p>
    <p>Catatan:</p>
    @foreach ($otorisasi_data as $otorisasi)
        <p>{{ $otorisasi->catatan }}.</p>
    @endforeach

    <br>
    <p>Terima kasih.</p>

    <div class="footer">
        <p>Tim IT Support - Layanan IT Helpdesk</p>
        <p>PT Kereta Commuter Indonesia</p>
        <p>Kantor Pusat - Stasiun Juanda</p>
    </div>
</body>

</html>
