const baseURL = 'http://localhost/my_php/Web-Project/stis-bertanya';

const kotakSearch = document.querySelector('.cari-user');
const hasilSearch = document.getElementById('ajax');

kotakSearch.addEventListener('keyup', startAjax);

function startAjax() {
    const xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            hasilSearch.innerHTML = xhr.responseText;
        }
    }

    // Eksekusi Ajax
    xhr.open('GET', baseURL + '/user/search/' + kotakSearch.value, true);
    xhr.send();
}