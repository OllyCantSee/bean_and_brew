const navBar = document.querySelector(".burger_nav_bar");
const burgerIcon = document.querySelector(".burger_icon");

burgerIcon.addEventListener("click", function() {
    navBar.classList.toggle("nav_bar_select");
})