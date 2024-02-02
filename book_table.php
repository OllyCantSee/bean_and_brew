<?php

session_start();

include_once "database_conn.php";
include_once "validation_functions/validation.php";
include_once "check_login_cookies.php";

if (!isset($_SESSION['user_id'])) {
    check_cookies($database_conn); // Checking if a user has remembered their account
}

if (!isset($_SESSION['book_table_error'])) {
    $_SESSION['book_table_error'] = "Please fill out all of the fields";
}

if (!isset($_COOKIE['theme'])) { // Creating the cookies if they are not set
    $_COOKIE['theme'] = "light";
}

if (isset($_POST['submit_booking'])) {
    $restaurant_location = $_POST['restaurant'];
    $number_of_guests = $_POST['number_of_guests'];
    $alergies_boolean = $_POST['alergies_boolean'];
    $date_of_booking = $_POST['date_of_booking'];
    $time_of_booking = $_POST['time_of_booking'];

    $time_of_booking = strtotime($time_of_booking);
    $time_of_booking = date('Y-m-d', $time_of_booking);



    if (
        empty($restaurant_location) || empty($number_of_guests)
        || empty($alergies_boolean) || empty($date_of_booking) || empty($time_of_booking)
    ) {
        $_SESSION['book_table_error'] = "Please fill out all of the fields";
    } else if ($time_of_booking < date('Y-m-d')) {
        $_SESSION['book_table_error'] = "Please choose a date in the future";
    } else {
        $query1 = "SELECT * FROM restaurant_seating WHERE restaurant_name = '$restaurant_location'";
        $result = mysqli_query($database_conn, $query1);
        $result_array = $result->fetch_array();
        $number_of_available_seats = $result_array['restaurant_seats'];

        $total_seats_after_booking = (intval($number_of_available_seats) - intval($number_of_guests));

        if ($total_seats_after_booking < 0) {
            $_SESSION['booking_error'] = "Sorry, there is not enough room for that number of guests";
            echo "<script> display_error_message() </script>";
        } else {
            $query2 = "UPDATE restaurant_seating SET restaurant_seats = $total_seats_after_booking
            WHERE restaurant_name = '$restaurant_location'";
            mysqli_query($database_conn, $query2);

            $_SESSION['book_table_error'] = "";

            $query3 = "INSERT INTO users_booking(booking_location,number_of_guests, allergies_boolean, date_of_booking, time_of_booking)
            VALUES('$restaurant_location', $number_of_guests, $alergies_boolean, $date_of_booking, $time_of_booking)";
            mysqli_query($database_conn, $query3);
        }
    }

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

    get_seats();

    function get_seats(selectedRestaurant) {

        if (document.getElementById('number_of_seats') == null || document.getElementById('number_of_seats') == "") {
            selectedRestaurant = "Leeds";
        }
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_seats.php?restaurant=' + selectedRestaurant, true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('number_of_seats').innerText = xhr.responseText;
                if (xhr.responseText == "0") {
                    document.getElementById('number_of_seats').innerText = "None"
                }
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
                        <select name="restaurant" id="restaurant" class="checkout_input_long"
                            onchange="get_seats(this.value)">
                            <option value="Leeds" selected="selected">Leeds</option>
                            <option value="Knaresborough">Knaresborough</option>
                            <option value="Harrogate">Harrogate</option>
                        </select>
                </div>

                <div class="personal_info_checkout">
                    <div class="item_title_container">
                        <h1 class="checkout_title">General Info</h1>
                    </div>
                    <div class="display_flex_column">
                        <select name="number_of_guests" id="" class="checkout_input_long">
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
                        <select name="alergies_boolean" id="" class="checkout_input_long">
                            <option value="">Any allergies?</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>

                <div class="personal_info_checkout">
                    <div class="item_title_container">
                        <h1 class="checkout_title">When?</h1>
                    </div>
                    <div class="display_flex_column">
                        <input type="date" placeholder="Choose a date..." class="checkout_input_long"
                            name="date_of_booking" maxlength="40">
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
                        <input method="POST" type="submit" class="change_value_button" name="submit_booking"
                            value="Submit">
                    </div>

                    </form>
                    <?php 
                    if (isset($_SESSION['book_table_error']) || $_SESSION['book_table_error'] != "") {
                        $form_error = $_SESSION['book_table_error'];
                        echo "<div class='page_error' id='page_error'>
                                <div class='page_error_content'>
                                    $form_error
                                </div>
                        </div>";
                    }

                    ?>


                </div>
            </div>

        </div>
    </div>


    <?php include_once "components/footer.php"; ?>



    <script src="shopping_list.js"></script>
    <script src="burger.js"></script>
    <script src="error_message.js"></script>

</body>

</html>