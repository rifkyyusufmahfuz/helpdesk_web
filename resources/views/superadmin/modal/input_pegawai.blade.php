<div class="modal fade" id="modalTambahPegawai" tabindex="-1" role="dialog" aria-labelledby="modalTambahUserLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahUserLabel">Tambah Data Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/superadmin/crud" method="POST" id="form-tambah-user">
                    @csrf
                    <input type="hidden" id="jenis_input" name="jenis_input" value="data_pegawai">
                    <div class="form-group">
                        <label for="nip_pegawai">NIP</label>
                        <input type="text" class="form-control" id="nip_pegawai" name="nip_pegawai" required
                            value="{{ old('nip_pegawai') }}">
                        @error('nip_pegawai')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama_pegawai">Nama Pegawai</label>
                        <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai" readonly
                            value="{{ old('nama_pegawai') }}">
                        @error('nama_pegawai')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bagian_pegawai">Bagian</label>
                        <input type="text" class="form-control" id="bagian_pegawai" name="bagian_pegawai" readonly
                            value="{{ old('bagian_pegawai') }}">
                        @error('bagian_pegawai')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jabatan_pegawai">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan_pegawai" name="jabatan_pegawai" readonly
                            value="{{ old('jabatan_pegawai') }}">
                        @error('jabatan_pegawai')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="lokasi_pegawai">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi_pegawai" name="lokasi_pegawai" readonly
                            value="{{ old('lokasi_pegawai') }}">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" form="form-tambah-user" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Perulangan untuk cek error --}}
<?php $listError = ['nip_pegawai', 'nama_pegawai', 'bagian_pegawai', 'jabatan_pegawai', 'lokasi_pegawai']; ?>
@foreach ($listError as $err)
    @error($err)
        <script type="text/javascript">
            window.onload = function() {
                OpenBootstrapPopup();
            };

            function OpenBootstrapPopup() {
                $("#modalTambahPegawai").modal('show');
            }
        </script>
    @break
@enderror
@endforeach
