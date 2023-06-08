@foreach ($permintaan as $data)
    <!-- Modal permintaan instalasi software -->
    <div class="modal fade" id="setujui_permintaan_{{ $data->id_permintaan }}" tabindex="-1" role="dialog"
        aria-labelledby="setujui_permintaan_label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="setujui_permintaan_label">Setujui Permintaan Instalasi Software</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="signature_pad_manager_{{ $data->id_permintaan }}">
                    <form action="/manager/crud/{{ $data->id_permintaan }}" method="POST"
                        id="setujui_{{ $data->id_permintaan }}" enctype="multipart/form-data">
                        @csrf

                        <h5>Setujui Permintaan</h5>

                        <p class="text-center">Nomor Permintaan: <b>{{ $data->id_permintaan }}</b></p>
                        <hr>
                        <div class="form-group text-center">
                            <label for="">Tanda tangan Manager</label>
                            <div>
                                <div id="catatan_ttd_manager_{{ $data->id_permintaan }}">Silakan tanda tangan di area
                                    kolom ini</div>
                                <canvas onmouseover="my_function3('{{ $data->id_permintaan }}')"
                                    class="form-ttd isi-ttd" id="the_canvas_manager_{{ $data->id_permintaan }}"
                                    height="150px"></canvas>
                            </div>
                            <div style="margin:10px;">
                                <input type="hidden" id="ttd_manager_{{ $data->id_permintaan }}"
                                    name="ttd_manager_{{ $data->id_permintaan }}">
                                {{-- <button type="button" id="clear_btn2_{{ $data->id_permintaan }}"
                                    class="btn btn-danger"
                                    onclick="clearSignature('{{ $data->id_permintaan }}')">Clear</button> --}}
                                <button type="button" class="btn btn-danger clear-btn"
                                    data-id="{{ $data->id_permintaan }}">Clear</button>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                    id="konfirmasi_penerima_{{ $data->id_permintaan }}">
                                <label class="form-check-label text-justify"
                                    for="konfirmasi_penerima_{{ $data->id_permintaan }}">
                                    Setujui permintaan <b>{{ $data->id_permintaan }}</b> dan akan diteruskan ke Admin
                                    untuk melanjutkan proses instalasi.
                                </label>
                            </div>
                        </div>

                        <div class="modal-footer p-0">
                            <button type="reset" class="btn btn-sm btn-secondary"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-sm btn-primary" id="btn-simpan">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- OK OK OK --}}
    <script>
        var wrapper = document.getElementById("signature_pad_manager_{{ $data->id_permintaan }}");
        var clearButtons = document.getElementsByClassName("clear-btn");

        var canvas = wrapper.querySelector("#the_canvas_manager_{{ $data->id_permintaan }}");
        var catatan_ttd = document.getElementById("catatan_ttd_manager_{{ $data->id_permintaan }}");
        var signaturePad;
        signaturePad = new SignaturePad(canvas, {
            minWidth: 1,
            maxWidth: 1,
        });

        for (var i = 0; i < clearButtons.length; i++) {
            clearButtons[i].addEventListener('click', function() {
                var id_permintaan = this.getAttribute('data-id');
                clearSignature(id_permintaan);
            });
        }

        function clearSignature(id_permintaan) {
            var canvas = document.getElementById('the_canvas_manager_' + id_permintaan);
            var signaturePad = new SignaturePad(canvas, {
                minWidth: 0.5,
                maxWidth: 0.5,
            });
            signaturePad.clear();
        }

        document.getElementById("setujui_{{ $data->id_permintaan }}").addEventListener('submit', function(event) {
            if (signaturePad.isEmpty()) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Isi tanda tangan penerima terlebih dahulu!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            } else {
                var canvas = document.getElementById('the_canvas_manager_{{ $data->id_permintaan }}')
                var dataUrl3 = canvas.toDataURL();
                document.getElementById("ttd_manager_{{ $data->id_permintaan }}").value = dataUrl3;
            }
        });

        function my_function3(id_permintaan) {
            var el_note = document.getElementById("catatan_ttd_manager_" + id_permintaan);
            el_note.innerHTML = "";
        }
    </script>
@endforeach
