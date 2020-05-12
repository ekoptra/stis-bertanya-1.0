// Alert

const alertToggle = document.querySelector('.alert');
const toggle = document.querySelector('.toggle');

toggle.addEventListener('click', function () {
    alertToggle.classList.toggle('hidden');
})