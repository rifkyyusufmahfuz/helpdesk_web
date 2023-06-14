@extends('layouts.main')

@section('contents')
    <!-- HTML -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <h4 class="card-title mx-2">Permintaan Instalasi Software</h4>
                <p class="small text-gray-800">Daftar permintaan instalasi software</p>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID Permintaan</th>
                            <th>Waktu Pengajuan</th>
                            <th>Kategori Software</th>
                            <th>Nama Pegawai</th>
                            <th>Status Otorisasi</th>
                            <th class="text-center">Status Permintaan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    {{-- PERMINTAAN SOFTWARE VIEW ADMIN --}}
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($permintaan as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->id_permintaan }}</td>
                                <td>{{ $data->permintaan_created_at }}</td>
                                <td>
                                    @if ($data->operating_system)
                                        <span>Sistem Operasi</span>
                                    @elseif($data->microsoft_office)
                                        <span>Microsoft Office</span>
                                    @elseif ($data->software_design)
                                        <span>Software Design</span>
                                    @elseif ($data->software_lainnya)
                                        <span>Software Lainnya</span>
                                    @endif
                                </td>
                                {{-- <td>{{ $data->keluhan_kebutuhan }}</td> --}}
                                <td>{{ $data->nama }}</td>
                                <td>{{ ucwords($data->status_approval) }}</td>


                                <td class="text-center">
                                    <span
                                        class="badge badge-{{ $data->status_permintaan == '1'
                                            ? 'danger'
                                            : ($data->status_permintaan == '2'
                                                ? 'warning'
                                                : ($data->status_permintaan == '3'
                                                    ? 'success'
                                                    : ($data->status_permintaan == '4'
                                                        ? 'primary'
                                                        : ($data->status_permintaan == '5'
                                                            ? 'info'
                                                            : ($data->status_permintaan == '0'
                                                                ? 'danger'
                                                                : ($data->status_permintaan == '6'
                                                                    ? 'secondary'
                                                                    : 'secondary')))))) }} p-2">

                                        {{ $data->status_permintaan == '1'
                                            ? 'Pending'
                                            : ($data->status_permintaan == '2'
                                                ? 'Menunggu persetujuan'
                                                : ($data->status_permintaan == '3'
                                                    ? 'Diterima'
                                                    : ($data->status_permintaan == '4'
                                                        ? 'Diproses'
                                                        : ($data->status_permintaan == '5'
                                                            ? 'Instalasi selesai'
                                                            : ($data->status_permintaan == '0'
                                                                ? 'Ditolak'
                                                                : ($data->status_permintaan == '6'
                                                                    ? 'Selesai'
                                                                    : 'Selesai')))))) }}
                                    </span>
                                </td>


                                <td class="text-center">
                                    {{-- TAMPILKAN TIGA TOMBOL BERIKUT --}}
                                    <div class="btn-group" role="group">
                    
                                        <form id="instalasi_selesai-{{ $data->id_permintaan }}"
                                            action="/admin/crud/{{ $data->id_permintaan }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('PUT')
                                            <input hidden name="status_permintaan" value="5">
                                            <input hidden name="id_permintaan" value="{{ $data->id_permintaan }}">
                                            <input hidden name="kode_barang" value="{{ $data->kode_barang }}">
                                            <button {{ $data->status_permintaan != '4' ? 'disabled' : '' }}
                                                title="Instalasi selesai" type="button" class="btn btn-sm btn-success"
                                                onclick="instalasi_selesai('{{ $data->id_permintaan }}')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>

                                        <button class="btn btn-sm btn-warning rounded text-white mx-1" data-toggle="modal"
                                            data-target="#detail_permintaan_software_{{ $data->id_permintaan }}"
                                            title="Lihat Permintaan"><i class="fas fa-eye"></i>
                                        </button>

                                        <form
                                            action="/admin/permintaan_software/tambah_software/{{ $data->id_permintaan }}"
                                            method="GET" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary text-white mr-1"
                                                title="Pengajuan Software"
                                                {{ $data->status_permintaan != '1' && $data->status_approval != 'revision' ? 'disabled' : '' }}>
                                                <i class="fas fa-cogs"></i>
                                            </button>
                                        </form>

                                        <form action="/admin/permintaan_software/bast_software/{{ $data->id_permintaan }}"
                                            method="GET" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success text-white" title="BAST"
                                                {{ $data->status_permintaan != '1' && $data->status_permintaan != '2' && $data->status_permintaan != '0' ? '' : 'disabled' }}>
                                                <i class="fas fa-receipt"></i>
                                            </button>
                                        </form>
                                    </div>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if (isset($data))
        @include('admin.software.modal.proses_software')
        {{-- @include('admin.software.modal.input_barang') --}}
        @include('admin.software.modal.detail_permintaan_software')
    @endif
@endsection
