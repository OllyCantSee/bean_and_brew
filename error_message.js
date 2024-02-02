const page_error = document.getElementById('page_error');
const close_error = document.getElementById('close_error');

close_error.addEventListener('click', function() {
    page_error.classList.add("display_none");
})