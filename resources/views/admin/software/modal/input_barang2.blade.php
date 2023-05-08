<!-- Modal add Software -->
<div class="modal fade" id="modal_input_barang{{ $data->id_permintaan }}" tabindex="-1" aria-labelledby="modal_input_barang"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="card-title">Form Serah Terima Barang</h4>
                    <button type="button red" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form action="/admin/crud" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <h6 class="mt-2">Data Barang</h6>

                    <div class="card p-2">
                        <input type="text" name="id_permintaan" id="id_permintaan"
                            value="{{ $data->id_permintaan }}">
                        <div class="form-group">
                            <label for="kode_barang">ID Barang</label>
                            <input required type="text" class="form-control" id="kode_barang" name="kode_barang"
                                value="{{ old('kode_barang') }}">
                            @error('kode_barang')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <label for="nama_barang">Nama Barang</label>
                            <input required type="text" class="form-control" id="nama_barang" name="nama_barang"
                                value="{{ old('nama_barang') }}">
                            @error('nama_barang')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            {{-- <label for="jumlah_barang">Jumlah Barang</label>
                            <input type="text" class="form-control" id="jumlah_barang" name="jumlah_barang"
                                value="1" disabled>
                            @error('jumlah_barang')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror --}}

                            <label for="perihal">Perihal</label>
                            <textarea id="perihal" name="perihal" class="form-control" cols="30" rows="2"></textarea>
                            @error('perihal')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- <h6 class="mt-2">Data yang menyerahkan</h6>
                    <div class="card p-2">
                        <div class="form-group">
                            <label for="nip_giver">NIPP</label>
                            <input class="form-control @error('nip_giver') is-invalid @enderror" type="text"
                                name="nip_giver" id="nip_giver" value="{{ old('nip_giver') }}">
                            @error('nip_giver')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama_giver">Nama</label>
                            <input class="form-control @error('nama_giver') is-invalid @enderror" type="text"
                                name="nama_giver" id="nama_giver" value="{{ old('nama_giver') }}">
                            @error('nama_giver')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="inline row">
                            <div class="form-group mt-3 col-sm">
                                <label for="bagian_giver">Unit/Bagian</label>
                                <input required type="text" class="form-control" id="bagian_giver"
                                    name="bagian_giver" value="{{ old('bagian_giver') }}">
                                @error('bagian_giver')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3 col">
                                <label for="jabatan_giver">Jabatan</label>
                                <input required type="text" class="form-control" id="jabatan_giver"
                                    name="jabatan_giver" value="{{ old('jabatan_giver') }}">
                                @error('jabatan_giver')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div> --}}


                </div>
                <div class="modal-footer p-2">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- Perulangan untuk cek error --}}
<?php $listError = ['kode_barang', 'nama_barang', 'jumlah_barang', 'perihal']; ?>
@foreach ($listError as $err)
    @error($err)
        <script type="text/javascript">
            window.onload = function() {
                OpenBootstrapPopup();
            };

            function OpenBootstrapPopup() {
                $("#modal_input_bast").modal('show');
            }
        </script>
    @break
@enderror
@endforeach
