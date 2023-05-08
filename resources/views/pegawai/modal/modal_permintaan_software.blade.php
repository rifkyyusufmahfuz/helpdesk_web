<!-- Modal permintaan instalasi software -->
<div class="modal fade" id="modal_instalasi_software" tabindex="-1" role="dialog"
    aria-labelledby="modal_instalasi_software-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_instalasi_software-label">Permintaan Instalasi Software</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="signature-pad">
                <form action="/pegawai/simpan_software" method="POST" id="form-instalasi-software"
                    enctype="multipart/form-data">
                    @csrf
                    <div id="detail_barang">
                        <h6>Spesifikasi PC / Laptop</h6>
                        <div class="form-group">
                            <label for="no_aset">No. Aset / Inventaris / Serial Number</label>
                            <input type="text" class="form-control" id="no_aset" name="no_aset"
                                placeholder="Nomor aset / inventaris / serial number">
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                placeholder="Laptop/PC, merk, dan tipe">
                        </div>
                        <div class="form-group">
                            <label for="prosesor">Prosesor</label>
                            <input type="text" class="form-control" id="prosesor" name="prosesor"
                                placeholder="Intel... / AMD...">
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="ram">RAM</label>
                                <input type="text" class="form-control" id="ram" name="ram"
                                    placeholder="...GB">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="penyimpanan">Penyimpanan</label>
                                <input type="text" class="form-control" id="penyimpanan" name="penyimpanan"
                                    placeholder="...GB">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end my-2" id="tombol_detail_barang">
                            <button type="button" class="btn btn-sm btn-primary" id="btn_lanjut_1">Lanjut <i
                                    class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>

                    <div id="detail_permintaan">
                        <h6>Detail Permintaan</h6>
                        <div class="form-group mb-0">
                            <label>Kategori Software</label>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" name="os" type="checkbox" id="os"
                                            value="1">
                                        <label class="form-check-label" for="os">Operating System</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="mo" type="checkbox" id="mo"
                                            value="2">
                                        <label class="form-check-label" for="mo">Microsoft Office</label>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" name="sd" type="checkbox" id="sd"
                                            value="3">
                                        <label class="form-check-label" for="sd">Software Design</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="sl" type="checkbox" id="sl"
                                            value="4">
                                        <label class="form-check-label" for="sl">Software Lainnya</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id="informasi_software" tabindex="0">
                            <div class="accordion" id="accordionExample">
                                <div class="card border-0 rounded">
                                    <div id="informasi_software_header" class="card-header collapsed bg-white p-1"
                                        data-toggle="collapse" data-target="#collapseThree" aria-expanded="false">
                                        <span class="title text-info">Informasi Software</span>
                                    </div>
                                    <div id="collapseThree" class="collapse" data-parent="#accordionExample">
                                        <div class="border rounded">
                                            <div class="card-body">
                                                <div class="row small">
                                                    <div class="col-sm-6">
                                                        <dl>
                                                            <dt>Operating System</dt>
                                                            <dd>- Microsoft Windows</dd>
                                                            <dd>- Linux OS</dd>
                                                            <dd>- Mac OS</dd>
                                                        </dl>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <dl>
                                                            <dt>Microsoft Office</dt>
                                                            <dd>- Word</dd>
                                                            <dd>- Excel</dd>
                                                            <dd>- Power Point</dd>
                                                        </dl>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <dl>
                                                            <dt>Software Design</dt>
                                                            <dd>- Microsoft Project</dd>
                                                            <dd>- Microsoft Visio</dd>
                                                            <dd>- Autocad</dd>
                                                            <dd>- Corel Draw</dd>
                                                            <dd>- Adobe Photoshop</dd>
                                                            <dd>- Adobe Premiere</dd>
                                                            <dd>- Adobe Ilustrator</dd>
                                                            <dd>- Sketch UP Pro</dd>
                                                            <dd>- Vray fr Sketchup</dd>
                                                        </dl>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <dl>
                                                            <dt>Software Lainnya</dt>
                                                            <dd>- Antivirus</dd>
                                                            <dd>- Open Office</dd>
                                                            <dd>- SAP</dd>
                                                        </dl>
                                                    </div>

                                                    <span class="text-danger mx-2">*Untuk software yang tidak ada di
                                                        list,
                                                        silakan pilih software lainnya
                                                        dan tulis di uraian
                                                        kebutuhan.</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="uraian_kebutuhan">Uraian Kebutuhan</label>
                            <textarea class="form-control" id="uraian_kebutuhan" name="uraian_kebutuhan" rows="2"></textarea>
                        </div>
                        <div class="d-flex justify-content-end my-2" id="tombol_detail_permintaan">
                            <button type="button" class="btn btn-sm btn-danger mr-1" id="tombol_kembali"><i
                                    class="fas fa-arrow-left"></i> Kembali</button>
                            <button type="button" class="btn btn-sm btn-primary" id="btn_lanjut_2">Lanjut <i
                                    class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>

                    <div id="detail_pegawai">
                        <h6>Pengajuan Permintaan</h6>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="nip">NIP</label>
                                <input disabled type="text" class="form-control" id="nip_pegawai" name="nip"
                                    placeholder="Masukkan NIP" maxlength="5" required
                                    value="{{ Auth::user()->pegawai->nip }}">
                            </div>

                            <div class="form-group col-sm-7">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama_pegawai" name="nama"
                                    placeholder="Nama" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="bagian">Bagian</label>
                                <input type="text" class="form-control" id="bagian_pegawai" name="bagian"
                                    placeholder="Bagian" disabled>
                            </div>

                            <div class="form-group col-sm-7">
                                <label for="jabatan">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan_pegawai" name="jabatan"
                                    placeholder="Jabatan" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi_pegawai" name="lokasi"
                                placeholder="Lokasi" disabled>
                        </div>
                        <hr>

                        <div class="form-group">
                            <label for="">Signature</label>
                            <div class="form-ttd" onmouseover="my_function();">
                                <div id="note">Silakan tanda tangan di area kolom ini</div>
                                <canvas id="the_canvas" class="isi-ttd" height="150px"></canvas>
                            </div>
                            <div style="margin:10px;">
                                <input type="hidden" id="signature" name="signature">
                                <button type="button" id="clear_btn" class="btn btn-danger"
                                    data-action="clear">Clear</button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end my-2" id="tombol_detail_pegawai">
                            <button type="button" class="btn btn-sm btn-danger mr-1" id="tombol_kembali_2"><i
                                    class="fas fa-arrow-left"></i> Kembali</button>
                        </div>
                    </div>

                    <div class="modal-footer p-0">
                        <button type="reset" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary" id="btn-simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        // disable tombol lanjut pada awalnya
        $('#btn_lanjut_1').prop('disabled', true);

        // cek input setiap kali nilai input berubah
        $('#detail_barang input').on('input', function() {
            // cek apakah semua input diisi
            var isFilled = true;
            $('#detail_barang input').each(function() {
                if ($(this).val() === '') {
                    isFilled = false;
                    return false; // keluar dari loop
                }
            });

            // aktifkan tombol lanjut jika semua input diisi
            if (isFilled) {
                $('#btn_lanjut_1').prop('disabled', false);
            } else {
                $('#btn_lanjut_1').prop('disabled', true);
            }
        });

        // tampilan modal awal, sembunyikan form detail_permintaan dan detail_pegawai
        $('#detail_permintaan').hide();
        $('#detail_pegawai').hide();
        $('#btn-simpan').hide();

        $('#tombol_detail_permintaan').hide();
        $('#tombol_detail_pegawai').hide();


        // handler untuk tombol lanjut 1
        $('#btn_lanjut_1').click(function() {
            $('#detail_barang').hide();
            $('#tombol_detail_barang').hide();

            $('#detail_permintaan').show();
            $('#tombol_detail_permintaan').show();
        });

        // handler untuk tombol kembali 1
        $('#tombol_kembali').click(function() {
            $('#detail_barang').show();
            $('#detail_permintaan').hide();
            $('#detail_pegawai').hide();

            $('#tombol_detail_barang').show();
            $('#tombol_detail_permintaan').hide();
        });

        // handler untuk tombol lanjut 2
        $('#btn_lanjut_2').click(function() {
            $('#detail_barang').hide();
            $('#detail_permintaan').hide();
            $('#detail_pegawai').show();
            $('#btn-simpan').show();

            $('#tombol_detail_pegawai').show();
        });

        // handler untuk tombol kembali 2
        $('#tombol_kembali_2').click(function() {
            $('#detail_barang').hide();
            $('#detail_permintaan').show();
            $('#detail_pegawai').hide();

            $('#btn-simpan').hide();

            $('#tombol_detail_permintaan').show();

            $('#tombol_detail_pegawai').hide();

        });
    });
</script>



<script>
    // disable tombol lanjut pada awalnya
    $('#btn_lanjut_2').prop('disabled', true);
    // dapatkan elemen checkbox dan textarea
    const osCheckbox = document.getElementById('os');
    const moCheckbox = document.getElementById('mo');
    const sdCheckbox = document.getElementById('sd');
    const slCheckbox = document.getElementById('sl');
    const uraianKebutuhanTextarea = document.getElementById('uraian_kebutuhan');

    // dapatkan elemen tombol lanjut 2
    const lanjutBtn = document.getElementById('btn_lanjut_2');

    // tambahkan listener untuk setiap perubahan pada checkbox dan textarea
    osCheckbox.addEventListener('change', validateForm);
    moCheckbox.addEventListener('change', validateForm);
    sdCheckbox.addEventListener('change', validateForm);
    slCheckbox.addEventListener('change', validateForm);
    uraianKebutuhanTextarea.addEventListener('input', validateForm);

    // fungsi untuk mengecek apakah form sudah terisi atau belum
    function validateForm() {
        // dapatkan nilai dari setiap checkbox dan textarea
        const osCheckboxValue = osCheckbox.checked;
        const moCheckboxValue = moCheckbox.checked;
        const sdCheckboxValue = sdCheckbox.checked;
        const slCheckboxValue = slCheckbox.checked;
        const uraianKebutuhanTextareaValue = uraianKebutuhanTextarea.value;

        // cek apakah setidaknya satu checkbox sudah dicentang dan textarea diisi
        if (
            (osCheckboxValue || moCheckboxValue || sdCheckboxValue || slCheckboxValue) &&
            uraianKebutuhanTextareaValue.trim().length > 0
        ) {
            // jika sudah terisi, maka aktifkan tombol lanjut 2
            lanjutBtn.disabled = false;
        } else {
            // jika belum terisi, maka nonaktifkan tombol lanjut 2
            lanjutBtn.disabled = true;
        }
    }

    // Handler tombol Close
    $('#modal_instalasi_software').on('hidden.bs.modal', function() {
        $(this).find('input[type=text]').not('#detail_pegawai input[type=text]').val('');
        // $(this).find('button[type=submit]').prop('disabled', true);
        $('#detail_barang').show();
        $('#detail_permintaan').hide();
        $('#detail_pegawai').hide();

        // hapus centang pada setiap checkbox
        osCheckbox.checked = false;
        moCheckbox.checked = false;
        sdCheckbox.checked = false;
        slCheckbox.checked = false;
        //kosongkan text area
        uraianKebutuhanTextarea.value = '';

        $('#btn_lanjut_1').prop('disabled', true);
        $('#btn_lanjut_2').prop('disabled', true);
        $('#btn-simpan').hide();

    });
</script>

{{-- untuk animasi expand --}}
<script>
    $(document).ready(function() {
        $('#collapseThree').on('show.bs.collapse', function() {
            $(this).prev('#informasi_software_header').addClass('active');
            $(this).slideDown();
        });
        $('#collapseThree').on('hide.bs.collapse', function() {
            $(this).prev('#informasi_software_header').removeClass('active');
            $(this).slideUp();
        });
    });
</script>
