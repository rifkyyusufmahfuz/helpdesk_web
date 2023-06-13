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
                                    <button class="btn btn-sm btn-warning rounded text-white mx-1" data-toggle="modal"
                                        data-target="#detail_permintaan_software_{{ $data->id_permintaan }}"
                                        title="Lihat Permintaan"><i class="fas fa-eye"></i>
                                    </button>
                                    {{-- <a href="{{ route('lihat_form', ['id' => $data->id_permintaan]) }}" target="_blank"
                                        class="btn btn-sm bg-warning text-white">
                                        <i class="fa fa-eye"></i>
                                    </a> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('pegawai.modal.modal_permintaan_software')

    @if (isset($data))
        @include('pegawai.modal.lihat_permintaan_software')
    @endif
@endsection
