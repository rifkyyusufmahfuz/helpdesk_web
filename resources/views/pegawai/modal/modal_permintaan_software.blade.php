<!-- Modal permintaan instalasi software -->
<div class="modal fade" id="modal-instalasi-software" tabindex="-1" role="dialog"
    aria-labelledby="modal-instalasi-software-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-instalasi-software-label">Permintaan Instalasi Software</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/pegawai/simpan_software" method="POST" id="form-instalasi-software"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input disabled type="text" class="form-control" id="nip_pegawai" name="nip"
                            placeholder="Masukkan NIP" maxlength="5" required value="{{ Auth::user()->pegawai->nip }}">
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama_pegawai" name="nama" placeholder="Nama"
                            disabled>
                    </div>

                    <div class="form-group">
                        <label for="bagian">Bagian</label>
                        <input type="text" class="form-control" id="bagian_pegawai" name="bagian"
                            placeholder="Bagian" disabled>
                    </div>

                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan_pegawai" name="jabatan"
                            placeholder="Jabatan" disabled>
                    </div>

                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi_pegawai" name="lokasi"
                            placeholder="Lokasi" disabled>
                    </div>

                    <div class="form-group">
                        <label>Kategori Software</label> <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="os" type="checkbox" id="os"
                                value="1">
                            <label class="form-check-label" for="os">Operating System</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="mo" type="checkbox" id="mo"
                                value="2">
                            <label class="form-check-label" for="mo">Microsoft Office</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="sd" type="checkbox" id="sd"
                                value="3">
                            <label class="form-check-label" for="sd">Software Design</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="sl" type="checkbox" id="sl"
                                value="4">
                            <label class="form-check-label" for="sl">Lainnya</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="no-aset">No. Asset</label>
                        <input type="text" class="form-control" id="no-aset" name="no_aset"
                            placeholder="Masukkan No. Asset">
                    </div>

                    <div class="form-group">
                        <label for="uraian-kebutuhan">Uraian Kebutuhan</label>
                        <textarea class="form-control" id="uraian-kebutuhan" name="uraian_kebutuhan" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="ttd_requestor">Tanda Tangan</label>
                        <div onmouseover="hilangkan_note_ttd()">
                            <div id="sig">
                                <div id="note">
                                    Silakan tanda tangan di area kolom ini
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button id="clear" class="btn btn-danger btn-sm">Clear</button>
                        <textarea id="signature64" name="signed" style="display: none"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var sig = $('#sig').signature({
        syncField: '#signature64',
        syncFormat: 'PNG'
    });
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        document.getElementById("note").innerHTML = "Silakan tanda tangan di area kolom ini";
        $("#signature64").val('');
    });
</script>
