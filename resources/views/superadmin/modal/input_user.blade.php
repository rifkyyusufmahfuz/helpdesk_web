<div class="modal fade" id="modalTambahUser" tabindex="-1" role="dialog" aria-labelledby="modalTambahUserLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahUserLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <form action="/superadmin/crud" method="POST" id="form-tambah-user">
                            @csrf
                            <h5 class="text-center">Data user</h5>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="confirm_password"
                                    name="confirm_password" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="">Pilih Role</option>
                                    @foreach ($data_role as $role)
                                        <option value="{{ $role->id_role }}">{{ ucwords($role->nama_role) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form>
                            <h5 class="text-center">Data pegawai</h5>
                            <div class="form-group">
                                <label for="nip_pegawai">NIP</label>
                                <input type="text" class="form-control" id="nip_pegawai" name="nip_pegawai" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_pegawai">Nama Pegawai</label>
                                <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="bagian_pegawai">Bagian</label>
                                <input type="text" class="form-control" id="bagian_pegawai" name="bagian_pegawai"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="jabatan_pegawai">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan_pegawai" name="jabatan_pegawai"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="lokasi_pegawai">Lokasi</label>
                                <input type="text" class="form-control" id="lokasi_pegawai" name="lokasi_pegawai"
                                    readonly>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="form-tambah-user" class="btn btn-primary">Simpan</button>
            </div>

        </div>
    </div>
</div>

{{-- Perulangan untuk cek error --}}
<?php $listError = ['nip', 'nama', 'password', 'id_role']; ?>
@foreach ($listError as $err)
    @error($err)
        <script type="text/javascript">
            window.onload = function() {
                OpenBootstrapPopup();
            };

            function OpenBootstrapPopup() {
                $("#modalTambahUser").modal('show');
            }
        </script>
    @break
@enderror
@endforeach