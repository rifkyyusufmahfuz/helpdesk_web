<!DOCTYPE html>
<html>

<head>
    <title>Pengecekan Hardware Selesai</title>
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

    <p>Pengecekan Hardware dengan ID Permintaan <strong>"{{ $id_permintaan_formatted }}"</strong> telah
        selesai.</p>
    <p>Silakan ambil unit di NOC.</p>
    <h4>Data Unit Sesuai Permintaan:</h4>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>No.Aset/Inventaris/Serial Number</th>
                <th>Unit</th>
                <th>Keluhan</th>
                <th>Rekomendasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_unit as $barang)
                <tr>
                    <td>1.</td>
                    <td>{{ $barang->kode_barang }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $keluhan }}</td>
                    @foreach ($tindak_lanjut as $rekomendasi)
                        <td>{{ $rekomendasi->rekomendasi }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <p>Terima kasih.</p>

    <div class="footer">
        <p>Tim IT Support - Layanan IT Helpdesk</p>
        <p>PT Kereta Commuter Indonesia</p>
        <p>Kantor Pusat - Stasiun Juanda</p>
    </div>
</body>

</html>
