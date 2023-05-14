function getNotifications() {
    fetch('/notifications')
        .then(response => response.json())
        .then(data => {
            if (data.notifikasi) {
                // update notification count
                let notifCounter = document.querySelector('#alertsDropdown .badge-counter');
                if (data.totalnotifikasi === 0) {
                    // hide notification count
                    notifCounter.style.display = 'none';
                } else {
                    // show notification count
                    notifCounter.textContent = data.totalnotifikasi;
                    notifCounter.style.display = 'block';
                }

                // remove existing notification items
                let notifList = document.querySelector('#notifications');
                notifList.innerHTML = '';

                // add new notification items
                data.notifikasi.forEach((notif, index) => {
                    // create notification item
                    let item = document.createElement('a');
                    item.classList.add('dropdown-item', 'd-flex', 'align-items-center');
                    item.setAttribute('data-id', notif.id);
                    item.href = notif.id;
                    // add click event listener to remove notification
                    item.addEventListener('click', function(e) {
                        e.preventDefault();
                        read_notifikasi(notif.id);
                        // item.remove();
                    });

                    let icon = document.createElement('div');
                    icon.classList.add('mr-3');
                    let circle = document.createElement('div');
                    circle.classList.add('icon-circle', 'bg-primary');
                    let iconText = document.createElement('i');
                    iconText.classList.add('fas', 'fa-exclamation', 'text-white');
                    circle.appendChild(iconText);
                    icon.appendChild(circle);
                    item.appendChild(icon);

                    // create notification content
                    let content = document.createElement('div');
                    let contentSmall = document.createElement('div');
                    contentSmall.classList.add('small', 'text-gray-500');
                    let date = new Date(notif.created_at);
                    contentSmall.textContent = date.toLocaleString('id-ID');
                    content.appendChild(contentSmall);
                    let contentBold = document.createElement('span');
                    contentBold.classList.add('font-weight-bold');


                    if (notif.read_at === null) {
                        // hide notification count
                        contentBold.classList.add('font-weight-bold');
                    } else {
                        // show notification count
                        contentBold.classList.remove('font-weight-bold');
                    }

                    contentBold.textContent = notif.pesan;
                    content.appendChild(contentBold);
                    item.appendChild(content);


                    // add delete button
                    let deleteButton = document.createElement('button');
                    deleteButton.classList.add('btn', 'btn-link', 'text-danger', 'ml-auto', 'p-0');
                    deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
                    deleteButton.addEventListener('click', function(e) {
                        e.preventDefault();

                        const KonfirmasiHapus = Swal.mixin({
                            toast: true,
                            position: 'top',
                            showConfirmButton: true,

                            timerProgressBar: true,
                            onOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });

                        // menampilkan sweetalert sebagai konfirmasi hapus
                        const Alert_hapus = Swal.mixin({
                            toast: true,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });

                        KonfirmasiHapus.fire({
                            icon: 'warning',
                            title: 'Hapus notifikasi ini ?',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, hapus',
                            cancelButtonText: 'Batal',
                            reverseButtons: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                //TAMBAHKAN FUNGSI UNTUK MENAMPILKAN DROPDOWN MENU YANG TERTUTUP

                                item.remove();
                                HapusNotifikasi(notif.id);

                                // menampilkan toast sebagai konfirmasi hapus
                                Alert_hapus.fire({
                                    icon: 'success',
                                    title: 'Notifikasi dihapus!'
                                });
                            } else {
                                // TAMBAHKAN FUNGSI UNTUK MENAMPILKAN DROPDOWN MENU YANG TERTUTUP

                                // tampilkan pesan bahwa penghapusan dibatalkan
                                Alert_hapus.fire({
                                    icon: 'info',
                                    title: 'Penghapusan dibatalkan!'
                                });
                            }
                        });
                    });

                    item.appendChild(deleteButton);

                    notifList.appendChild(item);
                });
            } else {
                // if there are no notifications, remove existing items
                let notifCounter = document.querySelector('#alertsDropdown .badge-counter');
                notifCounter.textContent = '';
                let notifList = document.querySelector('#notifications');
                notifList.innerHTML =
                    '<div class="dropdown-item py-3 text-center">Tidak ada notifikasi baru</div>';
            }
        })
        .catch(error => console.log(error));
}

function HapusNotifikasi(id) {
    fetch(`/notifikasi/hapus/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
        })
        .catch(error => console.log(error));
}

function read_notifikasi(id) {
    fetch(`/notifikasi/read/${id}`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
        })
        .catch(error => console.log(error));
}


$(document).ready(function() {
    // ketika item dropdown di klik
    $('.dropdown-list').on('click', function(e) {
        // hindari dropdown tertutup
        e.stopPropagation();
    });

    //hindari dropdown tertutup selain klik tombol dropdown itu sendiri
    $('#menu_dropdown').on('hide.bs.dropdown', function(e) {
        if (e.clickEvent && e.clickEvent.target.className != "dropdown-toggle") {
            e.preventDefault();
        }
    });
});
// call getNotifications function when the page loads
document.addEventListener('DOMContentLoaded', getNotifications);

// call getNotifications function every 10 seconds
setInterval(getNotifications, 2000);