const theme_switch = document.getElementById("change_theme");
const change_theme_text = document.getElementById("change_theme_text");
const days = 30;

theme_switch.addEventListener("click", function() {
    const date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    const expires = "; expires=" + date.toUTCString();

    if(document.body.classList.contains("dark")) {
        document.cookie = "theme" + "=" + "light" + expires + "path=/";
        document.body.classList.add("light");
        document.body.classList.remove("dark");
        change_theme_text.innerText = "Light Mode";
    } else {
        document.cookie = "theme" + "=" + "dark" + expires + "path=/";
        document.body.classList.add("dark");
        document.body.classList.remove("light");
        change_theme_text.innerHTML = "Dark Mode";
    }

})
