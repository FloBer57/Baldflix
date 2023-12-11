const menuIcon = document.querySelector ('.hamburger-menu');
const navbar = document.querySelector('.navbar');
const body = document.querySelector('.bodyburger')

menuIcon.addEventListener('click', () => {
    navbar.classList.toggle("change") 
    body.classList.toggle("lock");
})
