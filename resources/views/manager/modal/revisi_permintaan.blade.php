@foreach ($permintaan as $data)
    <div class="modal fade" id="modal_revisi_permintaan_{{ $data->id_permintaan }}" tabindex="-1" role="dialog"
        aria-labelledby="modal_revisi_permintaan_Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_revisi_permintaan_Label">Ajukan Revisi Permintaan</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Revisi Permintaan</h6>
                    <span>Ajukan revisi permintaan <b>{{ $data->id_permintaan }}</b> ke Admin dengan mengisi catatan
                        revisi pada kolom berikut:</span>
                    <hr>
                    <form action="/manager/crud/{{ $data->id_permintaan }}" method="POST" id="form-tambah-pegawai">
                        @csrf
                        @method('PUT')
                        <input hidden id="revisi" name="revisi">
                        <input type="hidden" id="id_otorisasi" name="id_otorisasi" value="{{ $data->id_otorisasi }}">
                        <input type="hidden" id="id_permintaan" name="id_permintaan"
                            value="{{ $data->id_permintaan }}">

                        <div class="form-group">
                            <label for="catatan_manager">Catatan Revisi</label>
                            <textarea class="form-control" name="catatan_manager" id="catatan_manager" cols="30" rows="5"></textarea>
                        </div>


                        <div class="modal-footer py-2">
                            <button type="reset" class="btn btn-sm btn-secondary"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-sm btn-primary"
                                id="form-tambah-pegawai">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
