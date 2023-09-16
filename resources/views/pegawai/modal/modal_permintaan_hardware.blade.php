<!-- Modal permintaan instalasi software -->
<div class="modal fade" id="permintaan_hardware" tabindex="-1" role="dialog" aria-labelledby="permintaan_hardware-label"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="permintaan_hardware-label">Permintaan Pengecekan Hardware</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="signature-pad">
                <form action="/pegawai/simpan_hardware" method="POST" id="form-instalasi-software"
                    enctype="multipart/form-data">
                    {{-- Fungsi Input permintaan ada di PegawaiController dan PegawaiModel --}}
                    @csrf
                    <div hidden class="form-group">
                        <input class="form-control" id="kode_barang_table" name="kode_barang_table">
                        <input class="form-control" id="input_status_barang" name="input_status_barang">
                        <input class="form-control" id="no_tiket_table" name="no_tiket_table">
                    </div>

                    <div id="detail_barang">
                        <h5>Data Permintaan</h5>
                        <div class="form-group">
                            <label for="no_tiket">Nomor Tiket<span class="text-danger">*</span></label>
                            <input required type="text" class="form-control" id="no_tiket" name="no_tiket"
                                maxlength="7" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        </div>
                        <div hidden id="peringatan_no_tiket" class="alert alert-warning fade show small" role="alert">
                            <i class="fas fa-exclamation-triangle"> </i> Nomor Tiket sudah ada!
                        </div>

                        <div class="form-group">
                            <label for="kode_barang">No. Aset / Inventaris / Serial Number<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="kode_barang" name="kode_barang">
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang">
                        </div>

                        <div class="form-group">
                            <label for="uraian_keluhan">Uraian Keluhan<span class="text-danger">*</span></label>
                            <textarea class="form-control" id="uraian_keluhan" name="uraian_keluhan" rows="5"></textarea>
                        </div>

                        <div hidden id="peringatan_barang" class="alert alert-warning fade show small" role="alert">
                            <i class="fas fa-exclamation-triangle"> </i> Barang tersebut telah diinput dan sedang dalam
                            proses
                            pengajuan.
                        </div>
                        <div class="d-flex justify-content-end my-2" id="tombol_detail_barang">
                            <button type="button" class="btn btn-sm btn-primary" id="btn_lanjut_1">Lanjut <i
                                    class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>

                    <div id="detail_pegawai">
                        <h6>Diajukan Oleh</h6>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="nip">NIP<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nip_pegawai" name="nip"
                                    placeholder="Masukkan NIP" maxlength="5" required>
                            </div>

                            <div class="form-group col-sm-7">
                                <label for="nama">Nama<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_pegawai" name="nama"
                                    placeholder="Nama">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="bagian">Bagian<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="bagian_pegawai" name="bagian"
                                    placeholder="Bagian">
                            </div>

                            <div class="form-group col-sm-7">
                                <label for="jabatan">Jabatan<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="jabatan_pegawai" name="jabatan"
                                    placeholder="Jabatan">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="lokasi">Lokasi</label>
                            <input list="stasiun_list" class="form-control" id="lokasi_pegawai" name="lokasi"
                                placeholder="Pilih lokasi" value="{{ old('lokasi') }}">
                            <datalist id="stasiun_list">
                                @foreach ($data_stasiun as $stasiun)
                                    <option value="{{ $stasiun->nama_stasiun }}"></option>
                                @endforeach
                            </datalist>
                        </div>

                        <hr>

                        <div class="form-group text-center">
                            <label for="">Tanda Tangan Requestor<span class="text-danger">*</span></label>
                            <div>
                                <div id="note">Silakan tanda tangan di area kolom ini</div>
                                <canvas onmouseover="my_function();" class="form-ttd" id="the_canvas"
                                    class="isi-ttd" height="150px"></canvas>
                            </div>
                            <div style="margin:10px;">
                                <input type="hidden" id="signature" name="signature">
                                <button type="button" id="clear_btn" class="btn btn-danger"
                                    data-action="clear">Clear</button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end my-2" id="tombol_detail_pegawai">
                            <button type="button" class="btn btn-sm btn-danger mr-1" id="tombol_kembali"><i
                                    class="fas fa-arrow-left"></i> Kembali</button>
                        </div>
                    </div>

                    <div class="modal-footer p-0">
                        <button type="button" id="tombol_batal" class="btn btn-sm btn-secondary"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary" id="btn-simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script></script>

<script>
    $(function() {
        // disable tombol lanjut pada awalnya
        $('#btn_lanjut_1').prop('disabled', true);

        // Disable tombol lanjut pada awalnya
        $('#btn_lanjut_1').prop('disabled', true);

        var timeoutId;

        $('#detail_barang input, #detail_barang textarea').on('input', function() {
            clearTimeout(timeoutId);

            timeoutId = setTimeout(function() {
                // Cek apakah semua input diisi
                var isFilled = true;
                var status_barang = $('#input_status_barang').val();

                $('#detail_barang input, #detail_barang textarea').each(function() {
                    if ($(this).val() === '' || (status_barang !== 'dikembalikan' &&
                            status_barang !== '')) {
                        isFilled = false;
                        return false; // Keluar dari loop
                    }
                });

                // Aktifkan tombol lanjut jika semua input diisi
                if (isFilled) {
                    $('#btn_lanjut_1').prop('disabled', false);
                } else {
                    $('#btn_lanjut_1').prop('disabled', true);
                }

                var tidak_ada_barang = true;
                $('#detail_barang input, #detail_barang textarea').each(function() {
                    if (status_barang !== '' && status_barang !== 'dikembalikan') {
                        tidak_ada_barang = false;
                        return false; // Keluar dari loop
                    }
                });

                // Aktifkan peringatan jika ada data barang di tabel barang
                if (tidak_ada_barang) {
                    $('#peringatan_barang').prop('hidden', true);
                } else {
                    $('#peringatan_barang').prop('hidden', false);
                }

                var no_tiket_table = $('#no_tiket_table').val();

                var no_tiket = true;
                $('#detail_barang input, #detail_barang textarea').each(function() {
                    if (no_tiket_table !== '') {
                        no_tiket = false;
                        return false; // Keluar dari loop
                    }
                });

                // Aktifkan peringatan jika no_tiket telah ada di tabel permintaan
                if (no_tiket) {
                    $('#peringatan_no_tiket').prop('hidden', true);
                } else {
                    $('#peringatan_no_tiket').prop('hidden', false);
                    $('#btn_lanjut_1').prop('disabled', true);
                }

            }, 500);
        });

        // tampilan modal awal, sembunyikan form detail_permintaan dan detail_pegawai
        $('#detail_pegawai').hide();
        $('#btn-simpan').hide();
        $('#tombol_detail_pegawai').hide();

        // handler untuk tombol lanjut 1
        $('#btn_lanjut_1').click(function() {
            $('#detail_barang').hide();
            $('#tombol_detail_barang').hide();
            $('#detail_pegawai').show();
            $('#btn-simpan').show();
        });

        // handler untuk tombol kembali 2
        $('#tombol_kembali').click(function() {
            $('#detail_barang').show();
            $('#detail_pegawai').hide();
            $('#btn-simpan').hide();
            $('#tombol_detail_pegawai').hide();
        });
    });
</script>



<script>
    $(document).ready(function() {

        const uraianKeluhanTextarea = document.getElementById('uraian_keluhan');


        // Handler tombol Tutup
        $('#permintaan_hardware').on('hide.bs.modal', function() {
            $(this).find('input[type=text]').not('#detail_pegawai input[type=text]').val('');
            // $(this).find('button[type=submit]').prop('disabled', true);
            $('#detail_barang').show();
            $('#detail_permintaan').hide();
            $('#detail_pegawai').hide();

            // kosongkan textarea
            uraianKeluhanTextarea.value = '';

            $('#btn_lanjut_1').prop('disabled', true);
            $('#btn_lanjut_2').prop('disabled', true);
            $('#btn-simpan').hide();
        });
    });
</script>
