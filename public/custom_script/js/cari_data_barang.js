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
            $('#input_status_barang').val(response.status_barang);
            $('#kode_barang_table').val(response.kode_barang_table);

            // Set select box berdasarkan nilai status_barang
            $('#status_barang').val(response.status_barang);

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
                $('#penyimpanan').val(response.penyimpanan);
                $('#input_status_barang').val(response.status_barang);
                $('#kode_barang_table').val(response.kode_barang_table);

                // Set select box berdasarkan nilai status_barang
                $('#status_barang').val(response.status_barang);

            },
        });
    });

});

// untuk cari id permintaan 
$(document).ready(function() {
    // Inisialisasi data awal
    var no_tiket = $('#no_tiket').val();
    $.ajax({
        type: 'GET',
        url: '/get_no_tiket/' + no_tiket,
        dataType: 'json',
        success: function(response) {
            $('#no_tiket_table').val(response.no_tiket_table);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });

    $('#no_tiket').on('input', function() {
        var no_tiket = $(this).val();
        $.ajax({
            type: 'GET',
            url: '/get_no_tiket/' + no_tiket,
            dataType: 'json',
            success: function(response) {
                $('#no_tiket_table').val(response.no_tiket_table);

            },
        });
    });

});