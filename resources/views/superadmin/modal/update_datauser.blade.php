@foreach ($users as $user)
    <div class="modal fade" id="modalEditUser{{ $user->id }}" tabindex="-1" role="dialog"
        aria-labelledby="modalEditUser{{ $user->id }}Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditUser{{ $user->id }}Title">Update Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/superadmin/crud/{{ $user->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        {{-- <input type="hidden" name="jenis_update" value="update_data"> --}}
                        <div class="form-group">
                            <label for="nip">NIPP</label>
                            <input type="text" name="nip" id="nip" class="form-control"
                                value="{{ $user->nip }}" required @error('nip') is-invalid @enderror>
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                value="{{ $user->nama }}" required @error('nama') is-invalid @enderror>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        @if ($user->role_id == $role->id) selected @endif>
                                        {{ ucwords($role->role_name) }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<?php $listError = ['nip', 'nama', 'role']; ?>
@foreach ($listError as $err)
    @error($err)
        <script type="text/javascript">
            window.onload = function() {
                OpenBootstrapPopup();
            };

            function OpenBootstrapPopup() {
                $("#modalEditUser{{ $user->id }}").modal('show');
            }
        </script>
    @break
@enderror
@endforeach
