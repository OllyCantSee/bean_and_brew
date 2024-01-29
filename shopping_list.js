const basketContainer = document.querySelector('.basket_container');
const basketDisplay = document.querySelector('.basket_display');

basketContainer.addEventListener("click", function() {
    basketDisplay.classList.toggle("display_block");
})