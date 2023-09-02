<!DOCTYPE html>
<html>

<head>
    <title>Instalasi Software Selesai</title>
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

    <p>Instalasi Software dengan ID Permintaan <strong>"{{ $id_permintaan_formatted }}"</strong> telah
        selesai.</p>
    <p>Silakan ambil unit di NOC.</p>
    <h4>Software yang telah diinstal:</h4>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Software</th>
                <th>Versi Software</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_software as $software)
                <?php $no = 1; ?>
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $software->nama_software }}</td>
                    <td>{{ $software->versi_software }}</td>
                    <td>{{ $software->notes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Data Unit Sesuai Permintaan:</h4>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>No.Aset/Inventaris/Serial Number</th>
                <th>Unit</th>
                <th>Prosesor</th>
                <th>RAM</th>
                <th>Penyimpanan</th>
                <th>Kebutuhan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_unit as $barang)
                <tr>
                    <td>1.</td>
                    <td>{{ $barang->kode_barang }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->prosesor }}</td>
                    <td>{{ $barang->ram }}</td>
                    <td>{{ $barang->penyimpanan }}</td>
                    <td>{{ $keluhan }}</td>
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
