@extends('layouts.main')

@section('contents')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Pegawai</h4>
                </div>
                <div class="row ml-2 mt-2">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-success btn-sm float-left" data-toggle="modal"
                            data-target="#modalTambahPegawai">
                            <i class="fa fa-user-plus"></i> Tambah Data Pegawai
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIPP</th>
                                    <th>Nama</th>
                                    <th>Bagian</th>
                                    <th>Jabatan</th>
                                    <th>Lokasi</th>
                                    <th class="text-center">Akses Sistem</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($data_pegawai as $pegawai)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $pegawai->nip }}</td>
                                        <td>{{ $pegawai->nama }}</td>
                                        <td>{{ $pegawai->bagian }}</td>
                                        <td>{{ $pegawai->jabatan }}</td>
                                        <td>{{ $pegawai->nama_stasiun }}</td>
                                        <td class="text-center">
                                            @if ($pegawai->id != null)
                                                <i class="fas fa-check text-success"></i>
                                            @else
                                                <i class="fas fa-times text-danger"></i>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <button class="btn btn-sm btn-warning" data-toggle="modal"
                                                data-target="#modalEditUser{{ $pegawai->nip }}"><i class="fa fa-edit"></i>
                                            </button>
                                            <form id="form-delete-{{ $pegawai->nip }}"
                                                action="/superadmin/crud/{{ $pegawai->nip }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete('{{ $pegawai->nip }}')">
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
        </div>
    </div>

    @include('superadmin.modal.input_pegawai')
@endsection
