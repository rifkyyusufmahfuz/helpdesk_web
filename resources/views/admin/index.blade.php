@extends('layouts.main')

@section('contents')
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">Status Permintaan Pengecekan Hardware</div>
                    <div class="card-body">
                        <p class="card-text">Jumlah Permintaan Keseluruhan: {{ $hardware_total }}</p>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold">Pending</span>
                                <span class="badge badge-primary badge-pill">{{ $hardware_pending }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold">Proses</span>
                                <span class="badge badge-primary badge-pill">{{ $hardware_proses }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold">Selesai</span>
                                <span class="badge badge-primary badge-pill">{{ $hardware_selesai }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">Status Permintaan Instalasi Software</div>
                    <div class="card-body">
                        <p class="card-text">Jumlah Permintaan Keseluruhan: {{ $software_total }}</p>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold">Pending</span>
                                <span class="badge badge-primary badge-pill">{{ $software_pending }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold">Revisi</span>
                                <span class="badge badge-primary badge-pill">{{ $software_revisi }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold">Diterima</span>
                                <span class="badge badge-primary badge-pill">{{ $software_diterima }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold">Ditolak</span>
                                <span class="badge badge-primary badge-pill">{{ $software_ditolak }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">Status Keseluruhan</div>
                    <div class="card-body">
                        <p class="card-text">Jumlah Permintaan Keseluruhan: {{ $total }}</p>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold">Pending</span>
                                <span class="badge badge-primary badge-pill">{{ $pending }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold">Proses</span>
                                <span class="badge badge-primary badge-pill">{{ $diproses }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold">Revisi</span>
                                <span class="badge badge-primary badge-pill">{{ $revisi }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold">Diterima</span>
                                <span class="badge badge-primary badge-pill">{{ $diterima }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold">Ditolak</span>
                                <span class="badge badge-primary badge-pill">{{ $ditolak }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
