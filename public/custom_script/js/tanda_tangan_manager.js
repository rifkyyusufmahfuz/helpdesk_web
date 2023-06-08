var wrapper = document.getElementById("signature_pad_manager_" + id_permintaan);
var clearButton_ttd_manager = wrapper.querySelector("clear_btn2_" + id_permintaan);
var canvas = wrapper.querySelector("the_canvas_manager_" + id_permintaan);
var catatan_ttd = document.getElementById("catatan_ttd_manager_" + id_permintaan);
var signaturePad2 = new SignaturePad(canvas, {
    minWidth: 1,
    maxWidth: 1,
});

form.addEventListener('submit', function(event) {
    if (signaturePad2.isEmpty()) {
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
        var canvas = document.getElementById('the_canvas_manager_' + id_permintaan)
        var dataUrl3 = canvas.toDataURL();
        document.getElementById("ttd_manager_" + id_permintaan).value = dataUrl3;
    }
});

function my_function3(id_permintaan) {
    var el_note = document.getElementById("catatan_ttd_manager_" + id_permintaan);
    el_note.innerHTML = "";
}

function clearSignature(id_permintaan) {
    var el_note = document.getElementById("catatan_ttd_manager_" + id_permintaan);
    el_note.innerHTML = "Silakan tanda tangan di area kolom ini";
    signaturePad2.clear();
}