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

tombolRubah.addEventListener('click', function () {
    if (formPass.classList.contains('hidden')) {
        tombolRubah.innerHTML = 'Rubah Detail';
        tombolSave.setAttribute('form', 'rubah-password');
    } else {
        tombolRubah.innerHTML = 'Rubah Password';
        tombolSave.setAttribute('form', 'rubah-detail');
    }
    hoverImg.classList.toggle('hover');
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