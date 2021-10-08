let menuToggle = document.querySelector('.header__menu-toggle');
let sideMenu = document.querySelector('.menu-options');

menuToggle.onclick = function(){
  sideMenu.classList.toggle('active');
}