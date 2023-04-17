// tombol aksi hapus user
function confirmDelete(id) {
    Swal.fire({
        title: 'Anda yakin ingin menghapus user ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Tidak, batalkan',
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
        confirmButtonText: 'Ya, aktivasi',
        cancelButtonText: 'Tidak, batalkan',
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
        confirmButtonText: 'Ya, aktivasi',
        cancelButtonText: 'Tidak, batalkan',
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit form jika user menekan tombol "Ya, aktivasi"
            document.querySelector('#aktivasi_semua_user_form').submit();
        }
    });
}