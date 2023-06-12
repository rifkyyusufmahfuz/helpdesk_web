@extends('layouts.main')
@section('contents')
    <!-- HTML -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <div class="row px-3">
                <h4 class="card-title">Serah Terima Barang</h4>
                <p class="small text-gray-800 px-1">Permintaan instalasi software</p>
            </div>
            <div class="row px-3">
                <p>Serah terima barang untuk :</p>
            </div>
            @foreach ($permintaan as $data_permintaan)
                <div class="row">
                    <div class="form-group px-3">
                        <div><b>ID Permintaan</b></div>
                        <div>{{ $data_permintaan->id_permintaan }}</div>
                    </div>

                    <div class="form-group px-3">
                        <div><b>Tanggal Permintaan</b></div>
                        <div>{{ $data_permintaan->tanggal_permintaan }}</div>
                    </div>

                    <div class="form-group px-3">
                        <div><b>Requestor</b></div>
                        <div>{{ $data_permintaan->nama }}</div>
                    </div>

                    <div class="form-group px-3">
                        <div><b>Lokasi</b></div>
                        <div>{{ $data_permintaan->nama_stasiun }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card-body">

            @foreach ($barang as $data_barang)
                <div class="overlay" id="overlay">
                    <div class="iframe-container">
                        <a id="tombol-print" href="/cetak_bast/barang_masuk/{{ $data_barang->id_permintaan }}"
                            target="_blank" class="btn btn-sm bg-primary text-white" title="Cetak BAST Barang Masuk"
                            onclick="cetakPDF(event, this.href)">
                            <i class="fas fa-file-pdf"></i> Cetak Dokumen
                        </a>
                        <button id="tutup_bast_masuk" class="btn btn-sm bg-danger text-white" title="Tutup Iframe">
                            <i class="fas fa-times"></i>
                        </button>
                        <iframe id="myIframe" src="/cetak_bast/barang_masuk/{{ $data_barang->id_permintaan }}"></iframe>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>ID Barang</th>
                                <th>Nama Barang</th>
                                <th>Status Barang</th>
                                <th>Diserahkan Oleh</th>
                                <th>Diterima Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        {{-- PERMINTAAN SOFTWARE VIEW ADMIN --}}
                        <tbody>
                            <?php $no = 1; ?>
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data_barang->kode_barang }}</td>
                                <td>{{ $data_barang->nama_barang }}</td>
                                {{-- <td>{{ $data_barang->perihal }}</td> --}}
                                <td>
                                    @if ($data_barang->status_barang == 'belum diterima')
                                        <span class="badge badge-secondary">Belum Diterima</span>
                                    @elseif ($data_barang->status_barang == 'diterima')
                                        <span class="badge badge-success">Diterima</span>
                                    @elseif ($data_barang->status_barang == 'siap diambil')
                                        <span class="badge badge-warning">Siap Diambil</span>
                                    @elseif ($data_barang->status_barang == 'dikembalikan')
                                        <span class="badge badge-success">Telah Dikembalikan</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ $data_barang->nama_menyerahkan != null ? $data_barang->nama_menyerahkan : '-' }}
                                </td>
                                <td class="text-center">
                                    {{ $data_barang->nama_menerima != null ? $data_barang->nama_menerima : '-' }}
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal"
                                        data-bs-target="#detail_barang_{{ $data_barang->kode_barang }}"
                                        title="Detail barang">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    @if ($data_barang->status_barang != 'belum diterima')
                                        {{-- <a href="/cetak_bast/barang_masuk/{{ $data_barang->id_bast }}" target="_blank"
                                            class="btn btn-sm bg-primary text-white" title="Cetak BAST Barang Masuk">
                                            <i class="fa fa-print"></i>
                                        </a> --}}
                                        <button id="view_bast_masuk" class="btn btn-sm bg-primary text-white"
                                            title="Cetak BAST Barang Masuk"><i class="fa fa-print"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-primary text-white" data-bs-toggle="modal"
                                            data-bs-target="#modal_input_bast_masuk{{ $data_barang->id_permintaan }}"
                                            title="Terima barang">
                                            <i class="fas fa-arrow-down"></i>
                                        </button>
                                    @endif
                                    {{-- <button {{ $data_barang->status_barang != '1' ? 'disabled' : '' }}
                                        class="btn btn-sm btn-primary text-white" data-bs-toggle="modal"
                                        data-bs-target="#modal_input_bast_masuk{{ $data_barang->id_permintaan }}"
                                        title="Terima barang">
                                        <i class="fas fa-arrow-down"></i>
                                    </button> --}}


                                    @if ($data_barang->status_barang != 'dikembalikan')
                                        <button {{ $data_barang->status_barang != 'siap diambil' ? 'disabled' : '' }}
                                            class="btn btn-sm btn-danger text-white" data-toggle="modal"
                                            data-target="#modal_input_bast{{ $data_barang->kode_barang }}"
                                            title="Serahkan barang"><i class="fas fa-arrow-up"></i>
                                        </button>
                                    @else
                                        <button id="view_bast_masuk" class="btn btn-sm bg-primary text-white"
                                            title="Cetak BAST Barang Masuk"><i class="fa fa-print"></i>
                                        </button>
                                    @endif

                                </td>

                            </tr>
                        </tbody>

                    </table>
                    <iframe id="myIframe" src="/cetak_bast/barang_masuk/{{ $data_barang->id_permintaan }}"
                        style="display: none;"></iframe>
            @endforeach
        </div>
    </div>
    </div>

    <script>
        function cetakPDF(event, url) {
            event.preventDefault(); // Mencegah tautan terbuka di tab baru

            // Buat elemen <iframe> dengan URL tujuan cetak
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = url;

            // Tambahkan elemen <iframe> ke dalam dokumen
            document.body.appendChild(iframe);

            // Setelah elemen <iframe> selesai dimuat, lakukan aksi cetak
            iframe.onload = function() {
                iframe.contentWindow.print();
            };

            // Hapus elemen <iframe> setelah cetak selesai
            iframe.onafterprint = function() {
                document.body.removeChild(iframe);
            };
        }
    </script>

    <script>
        // Tangani klik tombol Tampilkan Iframe
        document.getElementById('view_bast_masuk').addEventListener('click', function() {
            // Tampilkan overlay
            document.getElementById('overlay').style.display = 'block';
        });

        // Tangani klik tombol Tutup Iframe
        document.getElementById('tutup_bast_masuk').addEventListener('click', function() {
            // Sembunyikan overlay
            document.getElementById('overlay').style.display = 'none';
        });
    </script>

    @include('admin.software.modal.input_barang_masuk')
    @include('admin.software.modal.detail_barang')
@endsection
