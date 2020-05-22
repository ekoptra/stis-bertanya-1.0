var src = '';
var srcRubah = '';
// Efek Dropdown
const menuToggle = document.querySelector('.menu-toggle input');
const dropdown = document.querySelector('.dropdown');

menuToggle.addEventListener('click', function () {
    dropdown.classList.toggle('slide')
})



//  Ubah Kotak Edit
const tombolSave = document.getElementById('tombol-save');
const tombolRubah = document.getElementById('tombol-rubah');
const formDetail = document.getElementById('rubah-detail');
const formPass = document.getElementById('rubah-password');
const hoverImg = document.getElementById('img-hover');
const span = document.querySelector('#img-hover span');


tombolRubah.addEventListener('click', function () {
    if (formPass.classList.contains('hidden')) {
        if (src != '') {
            image.setAttribute('src', src);
        }
        tombolRubah.innerHTML = 'Rubah Detail';
        tombolSave.setAttribute('form', 'rubah-password');
    } else {
        if (srcRubah != '') {
            image.setAttribute('src', srcRubah);
        }
        tombolRubah.innerHTML = 'Rubah Password';
        tombolSave.setAttribute('form', 'rubah-detail');
    }
    hoverImg.classList.toggle('hover');
    span.classList.toggle('hidden');
    formDetail.classList.toggle('hidden');
    formPass.classList.toggle('hidden');
})

// Pilih Foto Profile
const select = document.getElementById('foto-profile');
const fotoProfile = document.querySelector('.img-thumnail.hover');

fotoProfile.addEventListener('click', function () {
    if (formPass.classList.contains('hidden'))
        select.click();
});

// Previw Picture

const input = document.getElementById('foto-profile');
const image = document.querySelector('.img-profile');

input.addEventListener('change', readURL);

function readURL() {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            src = image.getAttribute('src');
            srcRubah = e.target.result;
            image.setAttribute('src', srcRubah);
        }
        reader.readAsDataURL(input.files[0]);
    }
}