const container_one = document.getElementById("container_one");
const container_two = document.getElementById("container_two");
const show_bookings_button = document.getElementById("view_bookings_button");
const show_bookings_button_text = document.getElementById("view_bookings_button_text");
const booking_history_container = document.getElementById("booking_history_container");

const show_orders_button = document.getElementById("view_orders_button");
const show_orders_button_text = document.getElementById("view_orders_button_text");
const order_history_container = document.getElementById("order_history_container");

show_bookings_button.addEventListener("click", function() {

    container_one.classList.toggle("display_none");
    container_two.classList.toggle("display_none");

    show_orders_button_text.innerHTML = "View Orders";
    order_history_container.classList.add("display_none");

    if (container_one.classList.contains("display_none")) {
        show_bookings_button_text.innerHTML = "Close Bookings"
        booking_history_container.classList.remove("display_none");
    } else {
        show_bookings_button_text.innerHTML = "View Bookings"
        booking_history_container.classList.add("display_none");
    }

});

show_orders_button.addEventListener("click", function() {

    container_one.classList.toggle("display_none");
    container_two.classList.toggle("display_none");
    
    show_bookings_button_text.innerHTML = "View Bookings";
    booking_history_container.classList.add("display_none");

    if (container_one.classList.contains("display_none")) {
        show_orders_button_text.innerHTML = "Close Orders"
        order_history_container.classList.remove("display_none");
    } else {
        show_orders_button_text.innerHTML = "View Orders"
        order_history_container.classList.add("display_none");
    }

});
