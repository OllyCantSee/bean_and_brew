const change_username_text = document.getElementById('username_title_container');
const change_username_input = document.getElementById('change_username_box');

const change_password_text = document.getElementById('password_title_container');
const change_password_input = document.getElementById('change_password_box');


change_username_text.addEventListener("click", function() {
    change_username_text.classList.add("display_none");
    change_username_input.classList.add("display_block");

    change_password_text.classList.remove("display_none");
    change_password_input.classList.remove("display_block");
})
change_password_text.addEventListener("click", function() {
    change_username_text.classList.remove("display_none");
    change_username_input.classList.remove("display_block");

    change_password_text.classList.add("display_none");
    change_password_input.classList.add("display_block");
})