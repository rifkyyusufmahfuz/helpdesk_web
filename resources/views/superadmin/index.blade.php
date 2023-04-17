@extends('layouts.main')

@section('contents')
    {{-- container --}}
    <div class="container">
        {{-- row 1 --}}
        <div class="row my-5">
            <div class="row col-12">
                <h5 class="mb-3">Informasi Jumlah Pengguna</h5><p class="mx-2 text-gray-600">Berdasarkan Role</p>
            </div>
            @foreach ($roleCounts as $roleCount)
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning">
                                        @if ($roleCount->nama_role == 'superadmin')
                                            <i class="fas fa-user-shield"></i>
                                        @elseif($roleCount->nama_role == 'admin')
                                            <i class="fas fa-user"></i>
                                        @elseif($roleCount->nama_role == 'manager')
                                            <i class="fas fa-user-tie"></i>
                                        @elseif($roleCount->nama_role == 'pegawai')
                                            <i class="fas fa-user-circle"></i>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category">{{ ucwords($roleCount->nama_role) }}</p>
                                        <p class="card-title font-weight-bold text-lg">{{ $roleCount->total }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- end row 1 --}}
        </div>


        {{-- row 2  --}}
        <div class="row my-5">
            <div class="row col-12">
                <h5 class="mb-3">Informasi Jumlah Pengguna</h5> <p class="mx-2 text-gray-600">Berdasarkan Status</p>
            </div>
            {{-- informasi user aktif --}}
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fas fa-user-check"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">User Aktif</p>
                                    <p class="card-title font-weight-bold text-lg">{{ $activeUser }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- informasi user nonaktif --}}
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fas fa-user-times"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">User Nonaktif</p>
                                    <p class="card-title font-weight-bold text-lg">{{ $inactiveUser }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- informasi total user --}}
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Total User</p>
                                    <p class="card-title font-weight-bold text-lg">{{ $totalUser }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end row 2  --}}
        </div>

        {{-- end container  --}}
    </div>
@endsection
