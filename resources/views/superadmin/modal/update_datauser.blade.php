@foreach ($data_user as $user)
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
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ $user->email }}" required @error('email') is-invalid @enderror>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control" required>
                                @foreach ($data_role as $role)
                                    <option value="{{ $role->id_role }}"
                                        @if ($user->id_role == $role->id_role) selected @endif>
                                        {{ ucwords($role->nama_role) }}</option>
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

<?php $listError = ['email', 'nama', 'role']; ?>
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
