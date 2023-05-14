function getNotifications() {
    fetch('/notifications')
        .then(response => response.json())
        .then(data => {
            if (data.notifikasi && data.notifikasi.length > 0) {
                // update notification count
                let notifCounter = document.querySelector('#alertsDropdown .badge-counter');
                notifCounter.textContent = data.notifikasi.length;

                // remove existing notification items
                let notifList = document.querySelector('#notifications');
                notifList.innerHTML = '';

                // add new notification items
                data.notifikasi.forEach((notif, index) => {
                    // create notification item
                    let item = document.createElement('li');
                    item.classList.add('dropdown-item', 'd-flex', 'align-items-center');
                    item.setAttribute('data-id', notif.id);
                    let icon = document.createElement('div');
                    icon.classList.add('mr-3');
                    let circle = document.createElement('div');
                    circle.classList.add('icon-circle', 'bg-primary');
                    let iconText = document.createElement('i');
                    iconText.classList.add('fas', 'fa-file-alt', 'text-white');
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
                    contentBold.textContent = notif.pesan;
                    content.appendChild(contentBold);
                    item.appendChild(content);

                    // add click event listener to remove the notification
                    item.addEventListener('click', function(e) {
                        e.preventDefault();
                        removeNotification(notif.id);
                        item.remove();
                    });

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

function removeNotification(id) {
    fetch(`/notifications/${id}`, {
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




// call getNotifications function when the page loads
document.addEventListener('DOMContentLoaded', getNotifications);
// document.addEventListener('DOMContentLoaded', removeNotification);

// call getNotifications function every 10 seconds
setInterval(getNotifications, 2000);
// setInterval(removeNotification, 10000);