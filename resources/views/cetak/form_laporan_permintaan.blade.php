<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form BAST Barang Masuk</title>
    <link href="{{ asset('custom_script/css/form-bast.css') }}" rel="stylesheet">
</head>

<body>
    <div class="header">
        <img src="{{ asset('custom_script/img/logo_kci.png') }}" alt="Logo Perusahaan">
        <br>
        <p id="alamat">Kantor Pusat (Stasiun Juanda)</p>
        <p id="alamat">Jl. Ir. H. Djuanda I Kota Jakarta Pusat</p>
        <p id="alamat">Daerah Khusus Ibukota Jakarta 10120</p>
    </div>

    @foreach ($data_laporan as $data)
        @php
            $tanggal_awal = \Carbon\Carbon::parse($data->tanggal_awal)->isoFormat('D MMMM Y');
            $tanggal_akhir = \Carbon\Carbon::parse($data->tanggal_akhir)->isoFormat('D MMMM Y');
            
            if ($data->jenis_laporan == 'software') {
                $jenis_laporan = 'instalasi software';
            } elseif ($data->jenis_laporan == 'hardware') {
                $jenis_laporan = 'pengecekan hardware';
            }
            
            if ($data->periode_laporan == 'harian') {
                $periode = 'HARIAN';
                $rentang_periode = $tanggal_awal;
            } elseif ($data->periode_laporan == 'mingguan') {
                $periode = 'MINGGUAN';
                $rentang_periode = $tanggal_awal . ' sampai ' . $tanggal_akhir;
            } elseif ($data->periode_laporan == 'bulanan') {
                $periode = 'BULANAN';
                $rentang_periode = '';
            } elseif ($data->periode_laporan == 'tahunan') {
                $periode = 'TAHUNAN';
                $rentang_periode = '';
            }
        @endphp

        <div class="title">
            <h2>LAPORAN PERMINTAAN PERIODE {{ $periode }}</h2>
        </div>
        <div>

            @php
                $nomorlaporan = str_replace('-', '/', $data->id_laporan);
            @endphp
            <div>
                <p id="nomor_bast">Nomor: {{ $nomorlaporan }}</p>
            </div>

            <div>
                <p class="text-indent">
                    Berikut ini disampaikan Laporan {{ ucwords($data->periode_laporan) }} untuk layanan
                    {{ $jenis_laporan }} dengan total {{ $totalPermintaanSoftware }} permintaan yang telah dilakukan
                    pada periode {{ $rentang_periode }} dengan detail sebagai
                    berikut:
                </p>
            </div>
            <div class="subtitle">
                <span>Total permintaan software:</span>
                <div class="table-data-barang">
                    <table>
                        <tr>
                            <th class="total-software">No.</th>
                            <th id="kode_barang">Nama Software</th>
                            <th id="nama_barang" class="total-software">Jumlah</th>

                        </tr>
                        @php
                            $no = 1;
                            $totalKeseluruhan = 0;
                        @endphp

                        @foreach ($softwareCounts as $software)
                            <tr>
                                <td width="5%" class="total-software">{{ $no++ }}</td>
                                <td width="80%">{{ $software->nama_software }}</td>
                                <td width="15%" class="total-software">{{ $software->total }}</td>
                            </tr>
                            @php
                                $totalKeseluruhan += $software->total;
                            @endphp
                        @endforeach
                        <tr>
                            <td colspan="2"><b>Total</b></td>
                            <td class="total-software">{{ $totalKeseluruhan }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div>
                <p class="text-indent">
                    Berdasarkan laporan tersebut, {{ $namaSoftwareTerbanyak }} adalah software dengan permintaan
                    tertinggi, yaitu {{ $totalPermintaanTerbanyak }} permintaan dari total keseluruhan
                    {{ $totalKeseluruhan }} software.
                </p>
                <p>Demikian Laporan {{ ucwords($data->periode_laporan) }} layanan {{ $jenis_laporan }} ini dibuat
                    untuk dipergunakan sebagaimana mestinya.</p>
            </div>


            @php
                $tanggal_laporan = \Carbon\Carbon::parse($data->updated_at)->isoFormat('D MMMM Y');
            @endphp

            <div>
                <p class="tanggal_ttd">Jakarta Pusat, {{ $tanggal_laporan }}</p>
            </div>

            <div class="signature-container">
                <div class="yang_menyerahkan">
                    @if (!empty($data->ttd_admin) && file_exists(public_path('/tandatangan/laporan_permintaan/admin/' . $data->ttd_admin)))
                        <div>
                            <div class="kotak-ttd">
                                <div class="isi-ttd">
                                    <figcaption>Dibuat oleh:</figcaption>
                                    <img class="gambar_ttd"
                                        src="{{ asset('tandatangan/laporan_permintaan/admin/' . $data->ttd_admin) }}"
                                        title="Tanda tangan {{ $data->nama_admin }}">
                                    <figcaption>{{ $data->nama_admin }}</figcaption>
                                </div>
                                <figcaption>{{ $data->jabatan_admin }}</figcaption>
                            </div>
                        </div>
                    @else
                        <div>
                            <div class="kotak-ttd">
                                <figcaption>Dibuat oleh:</figcaption>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="yang_menerima">
                    @if (
                        !empty($data->ttd_manager) &&
                            file_exists(public_path('/tandatangan/laporan_permintaan/manager/' . $data->ttd_manager)))
                        <div>
                            <div class="kotak-ttd">
                                <div class="isi-ttd">
                                    <figcaption>Mengetahui,</figcaption>
                                    <img class="gambar_ttd"
                                        src="{{ asset('tandatangan/laporan_permintaan/manager/' . $data->ttd_manager) }}"
                                        title="Tanda tangan {{ $data->nama_manager }}">
                                    <figcaption>{{ $data->nama_manager }}</figcaption>
                                </div>
                                <figcaption>Manager IT Support</figcaption>
                            </div>
                        </div>
                    @else
                        <div>
                            <div class="kotak-ttd">
                                <figcaption>Mengetahui,</figcaption>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
    @endforeach
    </div>

</body>

</html>
