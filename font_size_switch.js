const change_fonts_switch = document.getElementById("change_fonts");
const sizes_array = ['small_fonts', 'medium_fonts', 'large_fonts']

change_fonts_switch.addEventListener("click", function() {
    
    if (document.body.classList.contains("small_fonts")) {
        document.body.classList.add(sizes_array[1]);
        document.body.classList.remove(sizes_array[2]);
        document.body.classList.remove(sizes_array[0]);
    } else if (document.body.classList.contains("medium_fonts")) {
        document.body.classList.add(sizes_array[2]);
        document.body.classList.remove(sizes_array[1]);
        document.body.classList.remove(sizes_array[0]);
    } else if (document.body.classList.contains("large_fonts")) {
        document.body.classList.add(sizes_array[0]);
        document.body.classList.remove(sizes_array[2]);
        document.body.classList.remove(sizes_array[1]);
    } else {
        document.body.classList.add(sizes_array[1]);
        document.body.classList.remove(sizes_array[2]);
        document.body.classList.remove(sizes_array[0]);
    }
})