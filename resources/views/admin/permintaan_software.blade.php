@extends('layouts.main')

@section('contents')
    <!-- HTML -->
    <div class="card shadow mb-4">
        <div class="card-header row">
            <h4 class="card-title mx-2">Permintaan Instalasi Software</h4> <p class="small text-gray-800">Daftar permintaan instalasi software</p>
        </div>
        <div class="card-body">
            {{-- <button type="button" class="btn btn-primary mb-3 btn-sm float-left" data-toggle="modal"
                data-target="#modal-instalasi-software">
                <i class="fa fa-user-plus"></i> Ajukan Permintaan
            </button> --}}
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Waktu Pengajuan</th>
                            <th>Status Permintaan</th>
                            <th>Status Otorisasi</th>
                            <th>Nama Pegawai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    {{-- PERMINTAAN SOFTWARE VIEW ADMIN --}}
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($permintaan as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>{{ ucwords($data->status_permintaan) }}</td>
                                <td>{{ ucwords($data->status_approval) }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>
                                    <a href="" class="btn btn-sm bg-warning text-white">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('pegawai.modal.modal_permintaan_software')
@endsection
