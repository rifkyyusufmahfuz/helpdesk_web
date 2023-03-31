@extends('layouts.main')

@section('contents')
    <div class="container">
        <h2>Selamat Datang Superadmin</h2>

        <div class="row">

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Superadmin</p>
                                    <p class="card-title">{{ $roleCounts['superadmin'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Admin</p>
                                    <p class="card-title">{{ $roleCounts['admin'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Manager</p>
                                    <p class="card-title">{{ $roleCounts['manager'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Pegawai</p>
                                    <p class="card-title">{{ $roleCounts['pegawai'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Daftar User</h4>
                    </div>
                    <div class="row ml-2 mt-2">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal"
                                data-target="#modalTambahUser">
                                <i class="fa fa-user-plus"></i> Tambah User
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
                                        <th>Role</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $user->nip }}</td>
                                            <td>{{ $user->nama }}</td>
                                            <td>{{ ucwords($user->role->role_name) }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-warning" data-toggle="modal"
                                                    data-target="#modalEditUser{{ $user->id }}"><i
                                                        class="fa fa-edit"></i>
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

    </div>

    @include('superadmin.modal.update_password_user')
    @include('superadmin.modal.update_datauser')
    @include('superadmin.modal.input_user')
@endsection
