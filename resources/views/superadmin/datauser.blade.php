@extends('layouts.main')

@section('contents')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header row">
                    <h4 class="card-title mx-2">Data User Aktif</h4> <p class="small text-gray-800">Daftar user aktif</p>
                </div>
                <div class="row ml-2 mt-2">
                    <div class="col-md-12">
                        <div class="1">
                            <button type="button" class="btn btn-primary btn-sm float-left mr-2" data-toggle="modal"
                                data-target="#modalTambahUser">
                                <i class="fa fa-user-plus"></i> Tambah User
                            </button>
                        </div>
                        {{-- <div class="">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                data-target="#modalTambahUser">
                                <i class="fa fa-user-plus"></i> Aktivasi User
                            </button>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>NIPP</th>
                                    <th>Nama</th>
                                    <th class="text-center">Akses Sistem</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($data_user as $user)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ucwords($user->nama_role) }}</td>
                                        <td>{{$user->nip}}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td class="text-center">
                                            @if ($user->status != false)
                                                <i class="fas fa-check text-success"></i>
                                            @else
                                                <i class="fas fa-times text-danger"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-warning text-white" data-toggle="modal"
                                                data-target="#modalEditUser{{ $user->id }}"><i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm bg-primary text-white" data-bs-toggle="modal"
                                                data-bs-target="#modalEditPassword{{ $user->id }}">
                                                <i class="fa fa-key"></i>
                                            </button>
                                            <form id="form-delete-{{ $user->id }}"
                                                action="/superadmin/crud/{{ $user->id }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete('{{ $user->id }}')">
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

    @include('superadmin.modal.update_password_user')
    @include('superadmin.modal.update_datauser')
    @include('superadmin.modal.input_user')
@endsection
