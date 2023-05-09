$(document).ready(function() {
    // Inisialisasi data awal
    var nip = $('#nip_pegawai').val();
    $.ajax({
        type: 'GET',
        url: '/getpegawaidata/' + nip,
        dataType: 'json',
        success: function(response) {
            $('#nama_pegawai').val(response.nama);
            $('#bagian_pegawai').val(response.bagian);
            $('#jabatan_pegawai').val(response.jabatan);
            $('#lokasi_pegawai').val(response.lokasi);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });

    $('#nip_pegawai').on('input', function() {
        var nip = $(this).val();
        $.ajax({
            type: 'GET',
            url: '/getpegawaidata/' + nip,
            dataType: 'json',
            success: function(response) {
                $('#nama_pegawai').val(response.nama);
                $('#bagian_pegawai').val(response.bagian);
                $('#jabatan_pegawai').val(response.jabatan);
                $('#lokasi_pegawai').val(response.lokasi);

                // if ($('#nip_pegawai').val() == '') {
                //     $('#nama_pegawai').attr('readonly', true);
                //     $('#bagian_pegawai').attr('readonly', true);
                //     $('#jabatan_pegawai').attr('readonly', true);
                //     $('#lokasi_pegawai').attr('readonly', true);
                // }
            },
            // error: function(xhr, status, error) {
            //     console.log(xhr.responseText);
            //     $('#nama_pegawai').val('').attr('readonly', true);
            //     $('#bagian_pegawai').val('').attr('readonly', true);
            //     $('#jabatan_pegawai').val('').attr('readonly', true);
            //     $('#lokasi_pegawai').val('').attr('readonly', true);
            // }
        });
    });
});