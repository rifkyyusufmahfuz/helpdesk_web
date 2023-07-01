@extends('layouts.main')

@section('contents')
    <!-- HTML -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <h4 class="card-title mx-2">Laporan Permintaan Periodik</h4>
                <p class="small text-gray-800">Daftar laporan permintaan</p>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID Laporan</th>
                            <th>Tanggal Laporan</th>
                            <th class="text-center">Permintaan</th>
                            <th class="text-center">Periode</th>
                            <th class="text-center">Status Laporan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    {{-- PERMINTAAN SOFTWARE VIEW ADMIN --}}
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($laporan_permintaan as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->id_laporan }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td class="text-center">{{ ucwords($data->jenis_laporan) }}</td>
                                <td class="text-center">{{ ucwords($data->periode_laporan) }}</td>
                                <td class="text-center">{{ ucwords($data->status_laporan) }}</td>


                                <td class="text-center">
                                    {{-- TAMPILKAN TIGA TOMBOL BERIKUT --}}
                                    <div class="btn-group" role="group">


                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- @if (isset($data))
        @include('admin.software.modal.proses_software')
        @include('admin.software.modal.detail_permintaan_software')
        @include('admin.software.modal.cetak_laporan_permintaan_software')
    @endif --}}
@endsection
