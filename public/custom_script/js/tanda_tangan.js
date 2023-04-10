// var wrapper = document.querySelector(".form-ttd");
// var clearButton = document.getElementById("clear_btn");
// var savePNGButton = wrapper.querySelector("[data-action=save-png]");
// var canvas = wrapper.querySelector("canvas");
// var el_note = document.getElementById("note");
// var signaturePad;
// signaturePad = new SignaturePad(canvas);
// clearButton.addEventListener("click", function(event) {
//     document.getElementById("note").innerHTML = "Silakan tanda tangan di area kolom ini";
//     signaturePad.clear();
// });
// savePNGButton.addEventListener("click", function(event) {
//     if (signaturePad.isEmpty()) {
//         alert("Silakan tanda tangan terlebih dahulu!");
//         event.preventDefault();
//     } else {
//         var signatureData = signaturePad.toDataURL();
//         document.getElementById("signature").value = signatureData;
//         // var canvas = document.getElementById("the_canvas");
//         // var dataUrl = canvas.toDataURL();
//         // document.getElementById("signature").value = dataUrl;
//     }
// });

// function hilangkan_note_ttd() {
//     console.log("Function called");
//     document.getElementById("note").innerHTML = "";
// }

//Fungsi ttd baru

var sig = $('#sig').signature({
    syncField: '#signature64',
    syncFormat: 'PNG'
});
$('#clear').click(function(e) {
    e.preventDefault();
    sig.signature('clear');
    document.getElementById("note").innerHTML = "Silakan tanda tangan di area kolom ini";
    $("#signature64").val('');
    signaturePad.clear();
    sig.signature('resizeCanvas');
});

function hilangkan_note_ttd() {
    console.log("Function called");
    document.getElementById("note").innerHTML = "";
}
