<div class="modal fade" id="modalTambahUser" tabindex="-1" role="dialog" aria-labelledby="modalTambahUserLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahUserLabel">Tambah User</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Isi form untuk menambahkan user -->
                <div class="modal-body">
                    <form action="/superadmin/crud" method="POST" id="form-tambah-user">
                        @csrf
                        <div class="form-group">
                            <label for="nip">NIPP</label>
                            <input type="text" name="nip"
                                class="form-control @error('nip') is-invalid @enderror">
                            @error('nip')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama"
                                class="form-control @error('nama') is-invalid @enderror">
                            @error('nama')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror">
                            @error('password_confirmation')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role_name">Role</label>
                            <select name="role_id" class="form-control @error('role_id') is-invalid @enderror">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ ucfirst($role->role_name) }}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Perulangan untuk cek error --}}
<?php $listError = ['nip', 'nama', 'password', 'role_id']; ?>
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
