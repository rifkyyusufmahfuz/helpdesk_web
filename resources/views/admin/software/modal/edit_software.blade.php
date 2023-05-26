<!-- Modal -->
@foreach ($software as $data2)
    <div class="modal fade" id="editModal{{ $data2->id_software }}" tabindex="-1" role="dialog"
        aria-labelledby="editModalLabel{{ $data2->id_software }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $data2->id_software }}">Edit Software</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-edit-{{ $data2->id_software }}" action="/admin/crud/{{ $data2->id_software }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Isi form edit software di sini -->

                        <!-- Tambahkan input fields untuk mengedit software -->
                        <div class="form-group">
                            <label for="nama_software">Nama Software</label>
                            <input type="text" class="form-control" id="nama_software" name="nama_software"
                                value="{{ $data2->nama_software }}" readonly>
                        </div>

                        <div class="form-group mt-3">
                            <label for="versi_software">Versi Software</label>
                            <input class="form-control @error('versi_software') is-invalid @enderror" type="text"
                                name="versi_software" id="versi_software" value="{{ $data2->versi_software }}">
                            @error('versi_software')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="notes">*Catatan</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" name="notes" id="notes" cols="20"
                                rows="5">{{ $data2->notes }}</textarea>
                            <span class="small">*Kosongkan apabila tidak ada catatan</span>
                            @error('notes')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endforeach
