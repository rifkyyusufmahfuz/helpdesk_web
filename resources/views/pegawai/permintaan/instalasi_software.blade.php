@extends('layouts.main')

@section('contents')
    <!-- HTML -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Permintaan Instalasi Software</h6>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-primary mb-3 btn-sm float-left" data-toggle="modal"
                data-target="#modal-instalasi-software">
                <i class="fa fa-user-plus"></i> Ajukan Permintaan
            </button>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Permintaan</th>
                            <th>Status Permintaan</th>
                            <th>Status Otorisasi</th>
                            <th>Waktu Pengajuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permintaan as $p)
                            <tr>
                                <td>{{ $p->id_permintaan }}</td>
                                <td>{{ $p->status_permintaan }}</td>
                                <td>{{ $p->id_otorisasi }}</td>
                                <td>{{ $p->created_at }}</td>
                                <td>
                                    <a href="{{ route('lihat_form', ['id' => $p->id_permintaan]) }}"
                                        class="btn btn-sm bg-warning text-white">
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
