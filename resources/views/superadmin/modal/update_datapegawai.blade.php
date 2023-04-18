@foreach ($data_pegawai as $pegawai)
    <div class="modal fade" id="modal_update_pegawai{{ $pegawai->nip }}" tabindex="-1" role="dialog"
        aria-labelledby="modal_update_pegawaiLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_update_pegawaiLabel">Update Data Pegawai</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/superadmin/crud/{{ $pegawai->nip }}" method="POST" id="form-tambah-pegawai">
                        @csrf
                        @method('PUT')
                        {{-- <input type="hidden" id="update_pegawai" name="update_pegawai" value=""> --}}
                        <div class="form-group">
                            <label for="nip_pegawai">NIP</label>
                            <input maxlength="5" type="text" class="form-control" id="nip_pegawai"
                                name="nip_pegawai" required value="{{ $pegawai->nip }}">
                            @error('nip_pegawai')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama_pegawai">Nama Pegawai</label>
                            <input required type="text" class="form-control" id="nama_pegawai" name="nama_pegawai"
                                value="{{ $pegawai->nama }}">
                            @error('nama_pegawai')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="bagian_pegawai">Unit/Bagian</label>
                            <input required type="text" class="form-control" id="bagian_pegawai"
                                name="bagian_pegawai" value="{{ $pegawai->bagian }}">
                            @error('bagian_pegawai')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jabatan_pegawai">Jabatan</label>
                            <input required type="text" class="form-control" id="jabatan_pegawai"
                                name="jabatan_pegawai" value="{{ $pegawai->jabatan }}">
                            @error('jabatan_pegawai')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- lokasi --}}


                        {{-- OPSI LOKASI DENGAN DATALIST --}}
                        <div class="form-group">
                            <label for="lokasi_pegawai">Lokasi</label>
                            <input list="stasiun_list" class="form-control" placeholder="-Pilih Lokasi-" required
                                id="lokasi_pegawai" name="lokasi_pegawai" value="{{ $pegawai->nama_stasiun }}">
                            <datalist id="stasiun_list">
                                @foreach ($data_stasiun as $stasiun)
                                    <option value="{{ $stasiun->nama_stasiun }}">
                                    </option>
                                @endforeach
                            </datalist>
                        </div>

                        {{-- OPSI LOKASI DENGAN SELECTBOX --}}
                        {{-- <div class="form-group">
                            <label for="lokasi_pegawai">Lokasi</label>
                            <select class="form-control" id="lokasi_pegawai" name="lokasi_pegawai" required>
                                <option value="">-Pilih Lokasi-</option>
                                @foreach ($data_stasiun as $stasiun)
                                    <option value="{{ $stasiun->nama_stasiun }}"
                                        {{ $pegawai->id_stasiun == $stasiun->id_stasiun ? 'selected' : '' }}>
                                        {{ $stasiun->nama_stasiun }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="modal-footer py-2">
                            <button type="reset" class="btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn-sm btn-primary" id="form-tambah-pegawai">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- Perulangan untuk cek error --}}
<?php $listError = ['nip_pegawai', 'nama_pegawai', 'bagian_pegawai', 'jabatan_pegawai', 'lokasi_pegawai']; ?>
@foreach ($listError as $err)
    @error($err)
        <script type="text/javascript">
            window.onload = function() {
                OpenBootstrapPopup();
            };

            function OpenBootstrapPopup() {
                $("#modal_update_pegawai").modal('show');
            }
        </script>
    @break
@enderror
@endforeach
