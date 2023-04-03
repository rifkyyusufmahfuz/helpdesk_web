@extends('layouts.main')

@section('contents')
    <div class="container">
        <h2>Selamat Datang Superadmin</h2>

        <div class="row">
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
                                        <p class="card-title">{{ $roleCount->total }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
