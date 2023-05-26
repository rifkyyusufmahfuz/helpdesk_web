@extends('layouts.main')

@section('contents')
    <!-- HTML -->
    <div class="card shadow">
        <div class="card-header pb-0">
            @foreach ($permintaan as $data)
                Tambah software untuk :
                <div class="row">
                    <div class="form-group px-3">
                        <div><b>ID Permintaan</b></div>
                        <div>{{ $data->id_permintaan }}</div>
                    </div>

                    <div class="form-group px-4">
                        <div><b>Tanggal Permintaan</b></div>
                        <div>{{ $data->tanggal_permintaan }}</div>
                    </div>

                    <div class="form-group px-4">
                        <div><b>Requestor</b></div>
                        <div>{{ $data->nama }}</div>
                    </div>

                    <div class="form-group px-4">
                        <div><b>Lokasi</b></div>
                        <div>{{ $data->nama_stasiun }}</div>
                    </div>

                    <div class="form-group px-4">
                        <div><b>Kategori</b></div>
                        <div>
                            @if ($data->operating_system == 1)
                                <span>Sistem Operasi</span>
                            @endif
                            @if ($data->microsoft_office == 1)
                                <span>Microsoft Office</span>
                            @endif
                            @if ($data->software_design == 1)
                                <span>Software Design</span>
                            @endif
                            @if ($data->software_lainnya == 1)
                                <span>Lainnya</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group px-4">
                        <div><b>Kebutuhan</b></div>
                        <div>{{ $data->keluhan_kebutuhan }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card-body">
            <div class="tombol-aksi-hardsoft">
                <p class="text-danger small">*Tambah software yang akan diinstal, setelah itu ajukan ke manager</p>
                <button class="btn btn-md btn-success  mb-3" data-bs-toggle="modal" data-bs-target="#tambah_software"><i
                        class="fas fa-plus fa-sm mr-2"></i>Tambah Software</button>

                {{-- <button class="btn btn-md btn-info  mb-3" data-toggle="modal" data-target="#forwardToManager"><i
                        class="fas fa-forward fa-sm mr-2"></i>Ajukan ke Manager</button> --}}
                @foreach ($permintaan as $data)
                    <button class="btn btn-md btn-info mb-3" data-toggle="modal"
                        data-target="#ajukan_ke_manager_{{ $data->id_permintaan }}"
                        {{ !$isSoftwareFilled ? 'disabled' : '' }}>
                        <i class="fas fa-forward fa-sm mr-2"></i>Ajukan ke Manager
                    </button>
                @endforeach



            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Software</th>
                            <th>Versi</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    {{-- PERMINTAAN SOFTWARE VIEW ADMIN --}}
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($software as $data2)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data2->nama_software }}</td>
                                <td>{{ $data2->versi_software }}</td>
                                <td>{{ $data2->notes }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                        data-target="#editModal{{ $data2->id_software }}">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                    <form id="form-delete-{{ $data2->id_software }}"
                                        action="/admin/crud/{{ $data2->id_software }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirm_delete_software('{{ $data2->id_software }}')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('admin.software.modal.tambah_software')
    @include('admin.software.modal.ajukan_ke_manager')
    @include('admin.software.modal.edit_software')
@endsection
