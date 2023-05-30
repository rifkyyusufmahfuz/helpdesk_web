@extends('layouts.main')

@section('contents')
    <!-- HTML -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <div class="row px-3">
                <h4 class="card-title">Serah Terima Barang</h4>
                <p class="small text-gray-800 px-1">Permintaan instalasi software</p>
            </div>
            <div class="row px-3">
                <p>Serah terima barang untuk :</p>
            </div>
            @foreach ($permintaan as $data)
                <div class="row">
                    <div class="form-group px-3">
                        <div><b>ID Permintaan</b></div>
                        <div>{{ $data->id_permintaan }}</div>
                    </div>

                    <div class="form-group px-3">
                        <div><b>Tanggal Permintaan</b></div>
                        <div>{{ $data->tanggal_permintaan }}</div>
                    </div>

                    <div class="form-group px-3">
                        <div><b>Requestor</b></div>
                        <div>{{ $data->nama }}</div>
                    </div>

                    <div class="form-group px-3">
                        <div><b>Lokasi</b></div>
                        <div>{{ $data->nama_stasiun }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Status Barang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    {{-- PERMINTAAN SOFTWARE VIEW ADMIN --}}
                    @foreach ($barang as $data)
                        <tbody>
                            <?php $no = 1; ?>
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->kode_barang }}</td>
                                <td>{{ $data->nama_barang }}</td>
                                {{-- <td>{{ $data->perihal }}</td> --}}
                                <td>
                                    @if ($data->status_barang == 1)
                                        <span>Belum Diterima</span>
                                    @elseif ($data->status_barang == 2)
                                        <span>Diterima</span>
                                    @elseif ($data->status_barang == 3)
                                        <span>Dikembalikan</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal"
                                        data-bs-target="#detail_barang_{{ $data->kode_barang }}" title="Detail barang">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button {{ $data->status_barang != '1' ? 'disabled' : '' }}
                                        class="btn btn-sm btn-primary text-white" data-bs-toggle="modal"
                                        data-bs-target="#modal_input_bast{{ $data->id_permintaan }}" title="Terima barang">
                                        <i class="fas fa-arrow-down"></i>
                                    </button>
                                    <button {{ $data->status_barang != '2' ? 'disabled' : '' }}
                                        class="btn btn-sm btn-danger text-white" data-toggle="modal"
                                        data-target="#modal_input_bast{{ $data->kode_barang }}" title="Serahkan barang">
                                        <i class="fas fa-arrow-up"></i>
                                    </button>
                                </td>

                            </tr>
                        </tbody>
                    @endforeach

                </table>
            </div>
        </div>
    </div>
    @include('admin.software.modal.input_barang_masuk')
    @include('admin.software.modal.detail_barang')
@endsection
