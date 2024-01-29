const remember_me = document.getElementById("remember_me");
const form_value = document.getElementById("remember_me_value");

remember_me.addEventListener("click", function() {
    if (remember_me.innerHTML == "Not Remembering You | Click to toggle") {
        remember_me.innerHTML = "Remembering You | Click to toggle";
        form_value.value = "remember"
    } else {
        remember_me.innerHTML = "Not Remembering You | Click to toggle";
        form_value.value = "not"
    }
})