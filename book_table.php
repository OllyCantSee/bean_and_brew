<?php

session_start();

include_once "database_conn.php";
include_once "validation_functions/validation.php";
include_once "check_login_cookies.php";

if (!isset($_SESSION['user_id'])) {
    check_cookies($database_conn); // Checking if a user has remembered their account
}

if (!isset($_COOKIE['theme'])) { // Creating the cookies if they are not set
    $_COOKIE['theme'] = "light";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Book a Table | Bean and Brew</title> <!-- This is the title of the page -->
</head>

<script>

function get_seats(selectedRestaurant) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_seats.php?restaurant=' + selectedRestaurant, true);

    xhr.onreadystatechange = function () {
        console.log(xhr.readyState, xhr.status);
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
            document.getElementById('number_of_seats').innerText = xhr.responseText;
        }
    };


    xhr.send();
}


</script>

<body <?php if ($_COOKIE['theme'] == "dark" && isset($_SESSION['user_id'])) {
    echo "class='dark'";
} ?>>

    <?php include_once "components/top_navigation_bar.php"; ?>

    <?php include_once "components/basket_component.php"; ?>

    <?php include_once "components/burger_nav.php"; ?>

    


    <div class="page_container">
        <div class="small_background_container">

            <div class="column_one">
                <div class="column_one_top_box">
                    <h2 class="top_box_title">Seats available</h2>
                    <h1 class="top_box_main font_size_80" id="number_of_seats">
                    </h1>
                </div>

                <div class="column_one_bottom_box">
                    <div class="bottom_box_title_container">
                        <h1 class="bottom_box_title">Recommended for you</h1>
                    </div>
                </div>
            </div>

            <div class="column_two">
                <div class="personal_info_checkout">
                    <div class="item_title_container">
                        <h1 class="checkout_title">Where?</h1>
                    </div>
                    <form method="POST" class="checkout_form">
                        <select name="restaurant" id="restaurant" class="checkout_input_long" onchange="get_seats(this.value)">
                            <option value="Leeds">Leeds</option>
                            <option value="Knaresborough">Knaresborough</option>
                            <option value="Harrogate">Harrogate</option>
                        </select>
                    </form>
                </div>

                <div class="personal_info_checkout">
                    <div class="item_title_container">
                        <h1 class="checkout_title">General Info</h1>
                    </div>
                    <form method="POST" class="checkout_form">
                        <select name="" id="" class="checkout_input_long">
                            <option value="">Select the number of guests...</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                        <select name="" id="" class="checkout_input_long">
                            <option value="Yes">Any allergies?</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </form>
                </div>

                <div class="personal_info_checkout">
                    <div class="item_title_container">
                        <h1 class="checkout_title">When?</h1>
                    </div>
                    <form method="POST" class="checkout_form">
                        <input type="date" placeholder="Choose a date..." class="checkout_input_long"
                            name="number_of_people" maxlength="40">
                        <select name="time_of_booking" id="" class="checkout_input_long">
                            <option value="">Choose a time</option>
                            <option value="09.00">09.00</option>
                            <option value="09.30">09.30</option>
                            <option value="10.00">10.00</option>
                            <option value="11.00">11.00</option>
                            <option value="11.30">11.30</option>
                            <option value="12.00">12.00</option>
                            <option value="12.30">12.30</option>
                            <option value="13.00">13.00</option>
                            <option value="14.00">14.00</option>
                            <option value="14.30">14.30</option>
                            <option value="15.00">15.00</option>
                            <option value="15.30">15.30</option>
                            <option value="16.00">16.00</option>
                            <option value="16.30">16.30</option>
                            <option value="17.00">17.00</option>
                            <option value="17.30">17.30</option>
                            <option value="18.00">18.00</option>
                            <option value="18.30">18.30</option>
                            <option value="19.00">19.00</option>
                            <option value="19.30">19.30</option>
                            <option value="20.00">20.00</option>
                        </select>
                        <input method="POST" type="submit" class="change_value_button" name="submit_password_change"
                            value="Submit">
                    </form>
                </div>
            </div>

        </div>
    </div>


    <?php include_once "components/footer.php"; ?>



    <script src="shopping_list.js"></script>
    <script src="burger.js"></script>

</body>

</html>