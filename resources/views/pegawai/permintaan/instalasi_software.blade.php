@extends('layouts.main')

@section('contents')
    <!-- HTML -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Permintaan Instalasi Software</h6><br>

            {{-- Menambahkan prosedur --}}
            <div class="form-group" id="informasi_software" tabindex="0">
                <div class="accordion" id="accordionExample">
                    <div class="card border-0 rounded">
                        <div id="informasi_software_header" class="card-header collapsed bg-white p-1" data-toggle="collapse"
                            data-target="#collapseThree" aria-expanded="false">
                            <span class="title text-info">Prosedur Permintaan Instalasi Software</span>
                        </div>
                        <div id="collapseThree" class="collapse" data-parent="#accordionExample">
                            <div class="border rounded">
                                <div class="card-body">
                                    <div class="small">
                                        <h6>Prosedur Permintaan Instalasi Software</h6><br>
                                        <span>Pengajuan Permintaan Instalasi Software</span>
                                        <ol>
                                            <li>Pegawai Mengajukan Permintaan Instalasi Software Melalui Menu Permintaan
                                                Layanan > Instalasi Software > Tombol Ajukan Permintaan.</li>
                                            <li>Melengkapi Form Spesifikasi PC atau Laptop yang akan dilakukan instalasi
                                                software.</li>
                                            <li>Melengkapi detail permintaan dengan memilih kategori software sesuai
                                                kebutuhan.</li>
                                            <li>Menandatangani form secara digital pada kolom input tanda tangan yang telah
                                                disediakan.</li>
                                            <li>Setelah ditandatangani, klik tombol simpan untuk mengajukan permintaan
                                                instalasi software.</li>
                                        </ol>
                                        <span>Proses Permintaan Instalasi Software</span>
                                        <ol>
                                            <li>Menunggu admin memproses permintaan, dapat dicek pada kolom status
                                                permintaan
                                                untuk memantau progres permintaan.</li>
                                            <li>Admin akan memilih software yang sesuai dengan permintaan dan spesifikasi PC
                                                atau Laptop yang Anda ajukan.</li>
                                            <li>Admin akan mengajukan terlebih dahulu permintaan Anda ke Manajer untuk
                                                mendapatkan persetujuan instalasi software yang diminta</li>
                                        </ol>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            {{-- end of informasi prosedur --}}
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-primary mb-3 btn-sm float-left" data-toggle="modal"
                data-target="#modal_instalasi_software">
                <i class="fa fa-user-plus"></i> Ajukan Permintaan
            </button>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Permintaan</th>
                            <th>Waktu Pengajuan</th>
                            <th>Status Permintaan</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permintaan as $data)
                            <tr>
                                <td>{{ $data->id_permintaan }}</td>
                                <td>{{ $data->created_at }}</td>
                                {{-- kolom status permintaan --}}

                                {{-- status pada saat permintaan diajukan --}}
                                @if ($data->status_permintaan == '1')
                                    <td>Pending</td>

                                    {{-- status permintaan pada saat admin mengajukan permintaan ke manajer --}}
                                @elseif ($data->status_permintaan == '2')
                                    <td>Menunggu Persetujuan</td>

                                    {{-- status permintaan ketika manajer menerima permintaan --}}
                                @elseif ($data->status_permintaan == '3')
                                    <td>Diterima</td>

                                    {{-- status permintaan ketika admin menerima barang --}}
                                @elseif ($data->status_permintaan == '4')
                                    <td>Diproses</td>

                                    {{-- status ketika instalasi selesai --}}
                                @elseif ($data->status_permintaan == '5')
                                    <td>Instalasi selesai</td>
                                    {{-- status ketika permintaan telah selesai --}}
                                @elseif ($data->status_permintaan == '6')
                                    <td>Selesai</td>
                                    {{-- status ketika permintaan ditolak --}}
                                @elseif ($data->status_permintaan == '0')
                                    <td>Ditolak</td>
                                @endif
                                {{-- kolom keterangan diambil dari status permintaan --}}
                                @if ($data->status_permintaan == '1')
                                    <td class="text-center">-</td>
                                @elseif($data->status_permintaan == '2')
                                    <td>Sedang diajukan ke manajer</td>
                                @elseif ($data->status_permintaan == '3')
                                    <td>Menunggu PC / Laptop diserahkan ke NOC</td>
                                @elseif ($data->status_permintaan == '4')
                                    <td>Unit sudah diterima, dan sedang diproses oleh admin</td>
                                @elseif ($data->status_permintaan == '5')
                                    <td>Unit siap diambil</td>
                                @elseif ($data->status_permintaan == '6')
                                    <td>Selesai</td>
                                @elseif ($data->status_permintaan == '0')
                                    <td>Permintaan ditolak karena tidak memenuhi persyaratan</td>
                                @endif
                                {{-- kolom aksi --}}
                                <td class="text-center">
                                    {{-- UNTUK MENAMPILKAN VIEW CETAK FORM INSTALASI SOFTWARE --}}
                                    <div class="overlay" id="overlay_{{ $data->id_permintaan }}">
                                        <div class="iframe-container">
                                            <a id="tombol_print_{{ $data->id_permintaan }}" href="#" target="_blank"
                                                class="btn btn-sm bg-primary text-white tombol-print"
                                                title="Cetak Form Pengecekan Hardware"
                                                onclick="cetakPDF(event, '/form_instalasi_software/{{ $data->id_permintaan }}')">
                                                <i class="fas fa-file-pdf"></i> Cetak Dokumen
                                            </a>
                                            <button id="tutup_form_software_{{ $data->id_permintaan }}"
                                                class="btn btn-sm bg-danger text-white tutup-form-software"
                                                title="Tutup Iframe">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <iframe id="myIframe_{{ $data->id_permintaan }}" src=""
                                                style="display: none;"></iframe>
                                        </div>
                                    </div>
                                    {{-- END OF OVERLAY --}}

                                    <div class="btn-group" role="group" aria-label="Tombol Aksi">
                                        <button class="btn btn-sm btn-warning rounded text-white mx-1" data-toggle="modal"
                                            data-target="#detail_permintaan_software_{{ $data->id_permintaan }}"
                                            title="Detail Permintaan"><i class="fas fa-eye"></i>
                                        </button>
                                        <button id="view_form_software_{{ $data->id_permintaan }}"
                                            class="btn btn-sm bg-primary text-white rounded print-software"
                                            title="Cetak Form Permintaan Instalasi Software"
                                            onclick="loadIframe({{ $data->id_permintaan }})"><i class="fa fa-print"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            {{-- script untuk mencegah iframe diload untuk meringankan halaman pada saat load --}}
                            <script>
                                function loadIframe(id_permintaan) {
                                    var iframe = document.getElementById("myIframe_" + id_permintaan);
                                    var iframeSrc = "/form_instalasi_software/" + id_permintaan;
                                    iframe.src = iframeSrc;
                                    iframe.style.display = "block";
                                }

                                // Event listener untuk tombol "Form Pengecekan Hardware"
                                var viewFormSoftwareButtons = document.getElementsByClassName("print-software");
                                for (var i = 0; i < viewFormSoftwareButtons.length; i++) {
                                    viewFormSoftwareButtons[i].addEventListener("click", function() {
                                        var id_permintaan = this.id.split("_")[3];
                                        loadIframe(id_permintaan);
                                    });
                                }
                            </script>



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
                                document.getElementById('view_form_software_{{ $data->id_permintaan }}').addEventListener('click', function() {
                                    // Tampilkan overlay
                                    document.getElementById('overlay_{{ $data->id_permintaan }}').style.display = 'block';
                                });

                                // Tangani klik tombol Tutup Iframe
                                document.getElementById('tutup_form_software_{{ $data->id_permintaan }}').addEventListener('click', function() {
                                    // Sembunyikan overlay_{{ $data->id_permintaan }}
                                    document.getElementById('overlay_{{ $data->id_permintaan }}').style.display = 'none';
                                });
                            </script>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- untuk animasi expand --}}
    <script>
        $(document).ready(function() {
            $('#collapseThree').on('show.bs.collapse', function() {
                $(this).prev('#informasi_software_header').addClass('active');
                $(this).slideDown();
            });
            $('#collapseThree').on('hide.bs.collapse', function() {
                $(this).prev('#informasi_software_header').removeClass('active');
                $(this).slideUp();
            });
        });
    </script>

    @include('pegawai.modal.modal_permintaan_software')

    @if (isset($data))
        @include('pegawai.modal.lihat_permintaan_software')
    @endif
@endsection
