// tombol aksi hapus user
function confirmDelete(id) {
    Swal.fire({
        title: 'Anda yakin ingin menghapus user ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit form jika user menekan tombol "Ya, hapus"
            document.querySelector('#form-delete-' + id).submit();
        }
    });
}

// tombol aksi hapus data pegawai
function confirm_delete_pegawai(id) {
    Swal.fire({
        title: 'Anda yakin ingin menghapus data pegawai ini?',
        text: 'Menghapus data pegawai juga akan menghapus akun user dan data yang terkait pada akun tersebut!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit form jika user menekan tombol "Ya, hapus"
            document.querySelector('#form-delete-' + id).submit();
        }
    });
}

// tombol aksi aktivasi user
function aktivasi_user(id) {
    Swal.fire({
        title: 'Aktivasi user ini?',
        text: 'User bisa melakukan login apabila diaktivasi!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit form jika user menekan tombol "Ya, hapus"
            document.querySelector('#aktivasi_user-' + id).submit();
        }
    });
}


// tombol aktivasi semua user
function aktivasi_semua_user() {
    Swal.fire({
        title: 'Aktivasi semua user?',
        text: 'Aksi ini akan mengaktivasi semua user nonaktif!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit form jika user menekan tombol "Ya, aktivasi"
            document.querySelector('#aktivasi_semua_user_form').submit();
        }
    });
}


// tombol aksi untuk nonaktifkan user
function disable_user(id) {
    Swal.fire({
        title: 'Nonaktifkan user ini?',
        text: 'User tidak bisa melakukan login apabila dinonaktifkan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, nonaktifkan',
        cancelButtonText: 'Tidak, batalkan',
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit form jika user menekan tombol "Ya, hapus"
            document.querySelector('#disable_user-' + id).submit();
        }
    });
}

// tombol untuk lihat data / view 
$(document).ready(function() {
    $(".tombol_lihat_data").click(function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var url = '/superadmin/lihatdatauser/' + id;
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $("#nip").val(response.nip);
                $("#nama").val(response.nama);
                $("#bagian").val(response.bagian);
                $("#jabatan").val(response.jabatan);
                $("#nama_stasiun").val(response.nama_stasiun);
                $("#modal_lihat_data").modal("show");
            }
        });
    });
});


// tombol aksi hapus software
function confirm_delete_software(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus software?',
        text: 'Membatalkan software yang akan diinstal pada permintaan ini.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit form jika user menekan tombol "Ya, hapus"
            document.querySelector('#form-delete-' + id).submit();
        }
    });
}

//untuk admin
function instalasi_selesai(id) {
    Swal.fire({
        title: 'Instalasi selesai',
        text: 'Proses instalasi software selesai, status permintaan akan diubah dan requestor akan mendapatkan notifikasi untuk mengambil PC / Laptop.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit form jika user menekan tombol "Ya, hapus"
            document.querySelector('#instalasi_selesai-' + id).submit();
        }
    });
}

function terima_permintaan(id) {
    Swal.fire({
        title: 'Terima Permintaan',
        // text: 'Terima permintaan pengecekan hardware, status permintaan akan diubah dan requestor akan mendapatkan notifikasi untuk menyerahkan unit yang akan dicek ke NOC.',
        html: '<div style="text-align: center;">Terima permintaan pengecekan hardware. <br> Status permintaan akan diubah dan requestor akan mendapatkan notifikasi untuk menyerahkan unit yang akan dicek ke NOC.</div>',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit form jika user menekan tombol "Ya, hapus"
            document.querySelector('#terima_permintaan-' + id).submit();
        }
    });
}

// tombol aksi hapus software
function confirm_delete_hardware(id) {
    Swal.fire({
        title: 'Hapus komponen hardware ini?',
        text: 'Hapus komponen hardware yang dicek pada permintaan ini.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit form jika user menekan tombol "Ya, hapus"
            document.querySelector('#form-delete-' + id).submit();
        }
    });
}