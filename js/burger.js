const menuIcon = document.querySelector ('.hamburger_menu');
const navbar = document.querySelector('.navbar');
const bodyburger = document.querySelector('.bodyburger')


menuIcon.addEventListener('click', () => {
    navbar.classList.toggle("change") ;
    bodyburger.classList.toggle("lock");
})


