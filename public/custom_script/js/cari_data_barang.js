$(document).ready(function() {
    // Inisialisasi data awal
    var kodebarang = $('#kode_barang').val();
    $.ajax({
        type: 'GET',
        url: '/getdatabarang/' + kodebarang,
        dataType: 'json',
        success: function(response) {
            $('#nama_barang').val(response.nama_barang);
            $('#prosesor').val(response.prosesor);
            $('#ram').val(response.ram);
            $('#penyimpanan').val(response.penyimpanan);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });

    $('#kode_barang').on('input', function() {
        var kodebarang = $(this).val();
        $.ajax({
            type: 'GET',
            url: '/getdatabarang/' + kodebarang,
            dataType: 'json',
            success: function(response) {
                $('#nama_barang').val(response.nama_barang);
                $('#prosesor').val(response.prosesor);
                $('#ram').val(response.ram);
                $('#penyimpanan').val(response.penyimpanan);


            },

        });
    });
});