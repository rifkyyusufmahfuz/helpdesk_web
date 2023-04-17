@extends('layouts.main')

@section('contents')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header row">
                    <h4 class="card-title mx-2">Data User Nonaktif</h4>
                    <p class="small text-gray-800">Daftar user tidak aktif</p>
                </div>
                <div class="row ml-2 mt-2">
                    <div class="col-md-12">
                        <div class="">

                            <form id="aktivasi_semua_user_form" action="/superadmin/aktivasi_semua_user" method="POST"
                                style="display: inline-block;">
                                @csrf
                                <button id="btnAktivasiSemuaUser" type="button"
                                    class="btn btn-primary btn-sm float-left mr-2" onclick="aktivasi_semua_user()">
                                    <i class="fa fa-user-check"></i> Aktivasi semua user
                                </button>
                            </form>

                        </div>
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

                                <?php
                                $no = 1;
                                $isAllActive = true;
                                ?>
                                @foreach ($data_user as $user)
                                    <?php
                                    if (!$user->status) {
                                        $isAllActive = false;
                                    }
                                    ?>

                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ucwords($user->nama_role) }}</td>
                                        <td>{{ $user->nip }}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td class="text-center">
                                            @if ($user->status != false)
                                                <i class="fas fa-check text-success"></i>
                                            @else
                                                <i class="fas fa-times text-danger"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <form id="aktivasi_user-{{ $user->id }}"
                                                action="/superadmin/crud/{{ $user->id }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="aktivasi" value="1">
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    onclick="aktivasi_user('{{ $user->id }}')">
                                                    <i class="fas fa-user-check"></i>
                                                </button>
                                            </form>

                                            <button class="btn btn-sm bg-warning text-white" data-bs-toggle="modal"
                                                data-bs-target="#modalEditPassword{{ $user->id }}">
                                                <i class="fa fa-eye"></i>
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
                                @if ($isAllActive)
                                    <script>
                                        document.querySelector('#aktivasi_semua_user_form button').setAttribute('disabled', 'disabled');
                                    </script>
                                @endif

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