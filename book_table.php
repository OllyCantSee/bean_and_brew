<?php

    session_start();

    include_once "database_conn.php";
    include_once "validation_functions/validation.php";

    if (!isset($_COOKIE['theme'])) {
        $_COOKIE['theme'] = "light";
    }

    if (isset($_POST['restaurant'])) {
        $restauraunt_name = $_POST['restaurant'];
        $query = "SELECT * FROM restaurant_seating WHERE restaurant_name = $restaurant_name";
        $result = mysqli_query($database_conn, $query);
        $result_array = $result->fetch_array();
        $seats = $result_array['restaurant_seats'];
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
<body <?php if ($_COOKIE['theme'] == "dark" && isset($_SESSION['user_id'])) {echo "class='dark'";} ?>>
    
    <?php include_once "components/top_navigation_bar.php"; ?>

    <?php include_once "components/basket_component.php"; ?>

    <?php include_once "components/burger_nav.php"; ?>


    <div class="page_container">
        <div class="small_background_container">

            <div class="column_one">
                <div class="column_one_top_box">
                    <h2 class="top_box_title">Seats available</h2>
                    <h1 class="top_box_main font_size_80">20</h1>
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
                        <select name="restaurant" id="" class="checkout_input_long">
                            <option value="">Leeds</option>
                            <option value="">Knaresborough</option>
                            <option value="">Harrogate</option>
                        </select>
                    </form>
                </div>

                <div class="personal_info_checkout">
                    <div class="item_title_container">
                        <h1 class="checkout_title">General Info</h1>
                    </div>
                    <form method="POST" class="checkout_form">
                        <input type="text" placeholder="How many?"
                        class="checkout_input_long" name="number_of_people" maxlength="40">
                        <input type="text" placeholder="Any allergies?"
                        class="checkout_input_long" name="alergies_bool" maxlength="60">
                    </form>
                </div>

                <div class="personal_info_checkout">
                    <div class="item_title_container">
                        <h1 class="checkout_title">When?</h1>
                    </div>
                    <form method="POST" class="checkout_form">
                        <input type="date" placeholder="Choose a date..."
                        class="checkout_input_long" name="number_of_people" maxlength="40">
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
                        <input type="submit" class="change_value_button"
                        name="submit_password_change" value="Submit">
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
