<!-- Modal -->
<div class="modal fade" id="modal_input_barang{{ $data->id_permintaan }}" tabindex="-1" role="dialog"
    aria-labelledby="modal_input_barang_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_input_barang_label">Form Input Barang</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="yang_menyerahkan">
                        <h6>Bagian Yang Menyerahkan</h6>
                        <div class="form-group">
                            <label for="nama_pengirim">Nama Pengirim</label>
                            <input type="text" class="form-control" id="nama_pengirim" name="nama_pengirim" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat_pengirim">Alamat Pengirim</label>
                            <input type="text" class="form-control" id="alamat_pengirim" name="alamat_pengirim"
                                required>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-sm btn-primary" id="next-btn">Lanjut</button>
                        </div>
                    </div>

                    <div id="yang_menerima">
                        <h6>Bagian Yang Menerima</h6>
                        <div class="form-group">
                            <label for="nama_penerima">Nama Penerima</label>
                            <input type="text" class="form-control" id="nama_penerima" name="nama_penerima" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat_penerima">Alamat Penerima</label>
                            <input type="text" class="form-control" id="alamat_penerima" name="alamat_penerima"
                                required>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-sm btn-primary" id="back-btn">Kembali</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        // disable tombol lanjut pada awalnya
        $('#next-btn').prop('disabled', true);

        // cek input setiap kali nilai input berubah
        $('#yang_menyerahkan input').on('input', function() {
            // cek apakah semua input diisi
            var isFilled = true;
            $('#yang_menyerahkan input').each(function() {
                if ($(this).val() === '') {
                    isFilled = false;
                    return false; // keluar dari loop
                }
            });

            // aktifkan tombol lanjut jika semua input diisi
            if (isFilled) {
                $('#next-btn').prop('disabled', false);
            } else {
                $('#next-btn').prop('disabled', true);
            }
        });

        // disable tombol simpan pada awalnya
        $('#btn-simpan').prop('disabled', true);

        // cek input setiap kali nilai input berubah
        $('#modal_input_barang{{ $data->id_permintaan }} input').on('input', function() {
            // cek apakah semua input diisi
            var isFilled = true;
            $('#modal_input_barang{{ $data->id_permintaan }} input').each(function() {
                if ($(this).val() === '') {
                    isFilled = false;
                    return false; // keluar dari loop
                }
            });

            // aktifkan tombol simpan jika semua input diisi
            if (isFilled) {
                $('#btn-simpan').prop('disabled', false);
            } else {
                $('#btn-simpan').prop('disabled', true);
            }
        });

        // hide the "Bagian Yang Menerima" section initially
        $('#yang_menerima').hide();

        // handler for the Next button
        $('#next-btn').click(function() {
            // hide the "Bagian Yang Menyerahkan" section
            $('#yang_menyerahkan').hide();
            // show the "Bagian Yang Menerima" section
            $('#yang_menerima').show();
        });

        // handler for the Next button
        $('#back-btn').click(function() {
            // hide the "Bagian Yang Menyerahkan" section
            $('#yang_menyerahkan').show();
            // show the "Bagian Yang Menerima" section
            $('#yang_menerima').hide();
        });

        // Handler tombol Close
        $('#modal_input_barang{{ $data->id_permintaan }}').on('hidden.bs.modal', function() {
            $(this).find('input[type=text]').val('');
            $(this).find('button[type=submit]').prop('disabled', true);
            // hide the "Bagian Yang Menyerahkan" section
            $('#yang_menyerahkan').show();
            // show the "Bagian Yang Menerima" section
            $('#yang_menerima').hide();
        });

    });
</script>
