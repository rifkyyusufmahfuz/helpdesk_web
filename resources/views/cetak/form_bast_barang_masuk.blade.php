<!DOCTYPE html>
<html>

<head>
    <title>Berita Acara Serah Terima Barang</title>
    <style>
        /* CSS untuk tampilan surat */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            /* text-align: center; */
            margin-bottom: 30px;
            border-bottom: 1px solid;
        }

        .header img {
            height: 80px;
        }

        .title {
            text-align: center;
            text-decoration: underline;
            margin-bottom: 20px;
        }

        .subtitle {
            margin-bottom: 10px;
        }

        .subtitle span {
            font-weight: bold;
        }

        .table-container {
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        p {
            text-indent: 50px;
            text-align: justify;
            line-height: 1.5;
        }

        .data-barang {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .signature-container {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }

        .signature {
            width: 40%;
        }

        .signature p {
            margin-bottom: 10px;
        }

        #alamat {
            line-height: 0.1;
            font-size: 10px;
            text-indent: 0px;
        }

        #nomor_bast {
            text-align: center !important;
            margin-top: -15px;
        }

        .tabel-data-pegawai {
            margin-left: 50px;
            border: hidden !important;
        }

        /* Cetak ke media A4 */

        @media print {
            @page {
                size: A4;
                margin: 7mm;
            }

            html,
            body {
                width: 210mm;
                height: 297mm;
                /* margin: 20mm 20mm 20mm 20mm; */
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ asset('img/logo_kci.png') }}" alt="Logo Perusahaan">
        <br>
        <p id="alamat">Kantor Pusat (Stasiun Juanda)</p>
        <p id="alamat">Jl. Ir. H. Djuanda I Kota Jakarta Pusat</p>
        <p id="alamat">Daerah Khusus Ibukota Jakarta 10120</p>
    </div>

    <div class="title">
        <h2>BERITA ACARA SERAH TERIMA BARANG</h2>
    </div>

    @foreach ($data_bast_masuk as $data)
        @php
            $nomorBast = str_replace('-', '/', $data->id_bast);
        @endphp
        <div>
            <p id="nomor_bast">Nomor: {{ $nomorBast }}</p>
        </div>


        <div>
            <p>Pada hari ini {{ $hari }}, tanggal {{ $tanggal }}, di Kantor Pusat Stasiun Juanda,
                kami yang
                bertanda
                tangan
                di bawah ini:</p>
        </div>
        <div class="subtitle">
            <span>Pihak Pertama:</span>
            <table class="tabel-data-pegawai">
                <tr>
                    <td>
                        Nama
                    </td>
                    <td>:</td>
                    <td>[Nama Pihak Pertama]</td>
                </tr>
                <tr>
                    <td>
                        NIP
                    </td>
                    <td>:</td>
                    <td>[NIP Pihak Pertama]</td>
                </tr>
                <tr>
                    <td>
                        Bagian/Divisi
                    </td>
                    <td>:</td>
                    <td>[Bagian/Divisi Pihak Pertama]</td>
                </tr>
                <tr>
                    <td>
                        Jabatan
                    </td>
                    <td>:</td>
                    <td>[Jabatan Pihak Pertama]</td>
                </tr>
                <tr>
                    <td>
                        Lokasi Kerja
                    </td>
                    <td>:</td>
                    <td>[Lokasi Kerja Pihak Pertama]</td>
                </tr>
            </table>
        </div>

        <div class="subtitle">
            <span>Pihak Kedua:</span>
            <table class="tabel-data-pegawai">
                <tr>
                    <td>
                        Nama
                    </td>
                    <td>:</td>
                    <td>[Nama Pihak Pertama]</td>
                </tr>
                <tr>
                    <td>
                        NIP
                    </td>
                    <td>:</td>
                    <td>[NIP Pihak Pertama]</td>
                </tr>
                <tr>
                    <td>
                        Bagian/Divisi
                    </td>
                    <td>:</td>
                    <td>[Bagian/Divisi Pihak Pertama]</td>
                </tr>
                <tr>
                    <td>
                        Jabatan
                    </td>
                    <td>:</td>
                    <td>[Jabatan Pihak Pertama]</td>
                </tr>
                <tr>
                    <td>
                        Lokasi Kerja
                    </td>
                    <td>:</td>
                    <td>[Lokasi Kerja Pihak Pertama]</td>
                </tr>
            </table>
        </div>

        <div>
            <p>Dengan ini menyatakan bahwa PIHAK PERTAMA telah menyerahkan barang kepada PIHAK KEDUA dengan detail
                berikut:
            </p>
        </div>

        <div class="table-container">
            <table>
                <tr>
                    <th class="data-barang">No.</th>
                    <th class="data-barang">Kode Barang</th>
                    <th class="data-barang">Nama Barang</th>
                    <th class="data-barang">Tipe Barang</th>
                    <th class="data-barang">Jumlah Barang</th>
                    <th class="data-barang">Keterangan</th>
                </tr>
                <tr>
                    <td class="data-barang">1</td>
                    <td class="data-barang">[Kode Barang]</td>
                    <td class="data-barang">[Nama Barang]</td>
                    <td class="data-barang">[Tipe Barang]</td>
                    <td class="data-barang">[Jumlah Barang]</td>
                    <td class="data-barang">[Keterangan tentang barang]</td>
                </tr>
            </table>
        </div>

        <div>
            <p>Pihak kedua telah menerima barang tersebut dalam kondisi baik, lengkap, dan
                sesuai dengan deskripsi yang tertera dalam tabel di atas. <br>
                Kedua belah pihak setuju bahwa barang yang diserahkan oleh pihak pertama telah diterima dengan baik oleh
                pihak kedua untuk keperluan Layanan IT <i>Helpdesk</i> instalasi <i>software</i>.</p>
            <p>Selanjutnya, pihak kedua bertanggung jawab atas penggunaan barang tersebut sesuai dengan keperluan yang
                telah
                disepakati dan akan dikembalikan segera setelah proses instalasi <i>software</i> selesai.</p>
        </div>

        <div class="signature-container">
            <div class="signature">
                <p>Yang Menyerahkan,</p>
                <p>[Nama Pihak Pertama]</p>
                <p>[Jabatan Pihak Pertama]</p>
            </div>

            <div class="signature">
                <p>Yang Menerima,</p>
                <p>Admin IT Support</p>
            </div>
        </div>
    @endforeach
</body>

</html>
