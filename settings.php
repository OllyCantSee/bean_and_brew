<?php

    // ^^ = The line above is what I am talking about

    session_start();

    include_once "database_conn.php";
    include_once "validation_functions/validation.php";
    include_once "check_login_cookies.php";

    if (!isset($_SESSION['user_id'])) {
        check_cookies($database_conn);
    }

    if (!isset($_COOKIE['theme'])) {
        $_COOKIE['theme'] = "light";
    }

    if (isset($_SESSION['user_id'])) {

        if (!isset($_SESSION['item_basket'])) {
        $_SESSION['item_basket'] = [];
        }
        
        if(isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $query = "SELECT * FROM users WHERE user_id = $user_id";
            $result = mysqli_query($database_conn, $query);
            $result_array = mysqli_fetch_array($result);
            $username = $result_array['user_name'];
            $email = $result_array['email'];
        }

        if (isset($_POST['submit_username_change'])) {
            $new_username = santatize_input($_POST['change_username'], false);

            if(strlen($new_username) > 5) {
                $template_query = "UPDATE users SET user_name = ? WHERE user_id = $user_id";
                $statement = $database_conn->prepare($template_query);
                $statement->bind_param("s", $new_username);
                $statement->execute();
                $statement->close();
                header("Location: settings.php");
            }


        }
        if (isset($_POST['submit_password_change']) && !empty($_POST['old_password'])
        && !empty($_POST['new_password'])) { // Ensuring that all inputs have been filled
        // before attempting to run any more script

            $password = $result_array['password']; // Getting the stored password
            $password_salt = $result_array['password_salt']; // Getting the stored salt

            $old_password = santatize_input($_POST['old_password'], false);
            // ^^Getting the old password from the user input
            if (password_verify($old_password . $password_salt, $password)) {
                // ^^Checking if the user got their old password correct
                $new_password = santatize_input($_POST['new_password'], false);
                // ^^Getting and santatising the new password - Preventing SQL Injections
                $new_password = password_hash($new_password . $password_salt, PASSWORD_BCRYPT);
                // ^^Creating the encrypted version of the neww password

                $template_query = "UPDATE users SET password = ? WHERE user_id = $user_id";
                $statement = $database_conn->prepare($template_query);
                $statement->bind_param("s", $new_password);
                $statement->execute();
                $statement->close();
                // ^^Initialising the query that adds the new password to the 
                header("Location: settings.php");
            }

        }
    } else {
        header("Location: home_page.php");
    }

 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Bean and Brew | Home</title> <!-- This is the title of the page -->
</head>
<body <?php if ($_COOKIE['theme'] == "dark" && isset($_SESSION['user_id'])) {echo "class='dark'";} ?>>


    <?php include_once "components/top_navigation_bar.php"; ?>

    <?php include_once "components/basket_component.php"; ?>

    <?php include_once "components/burger_nav.php"; ?>

    <div class="page_container">
        <div class="small_background_container">

            <div class="column_one">
                <div class="column_one_top_box">
                    <h2 class="top_box_title">Username</h2>
                    <h1 class="top_box_main"><?php echo $username ?></h1>
                </div>

                <div class="column_one_bottom_box">
                    <div class="bottom_box_title_container">
                        <h1 class="bottom_box_title">Quick actions</h1>
                    </div>

                    <div class="quick_action red_background">
                        <div class="item_title_container">
                            <a href="sign_out_script.php" class="sign_out_overlay"></a>
                            <h1 class="quick_action_title">Sign Out</h1>
                        </div>
                    </div>
                    <div class="quick_action grey_background" id="change_username_hover">
                        <div class="item_title_container" id="username_title_container">
                            <h1 class="quick_action_title">Change Username</h1>
                        </div>
                        <div class="change_username" id="change_username_box">
                        <h1 class="settings_form_label">Change Username</h1>
                            <form method="POST" class="change_username_form">
                                <input type="text" class="form_input" name="change_username"
                                placeholder="Enter your new username..." maxlength="11">
                                <input type="submit" class="change_value_button"
                                name="submit_username_change" value="Submit">
                            </form>
                        </div>
                    </div>
                    <div class="quick_action grey_background">
                        <div class="item_title_container" id="password_title_container">
                            <h1 class="quick_action_title">Change Password</h1>
                        </div>
                        <div class="change_password" id="change_password_box">
                        <h1 class="settings_form_label">Change Password</h1>
                            <form method="POST" class="change_password_form">
                                <input type="password" class="form_input" name="old_password"
                                placeholder="Enter your current password..." maxlength="30">
                                <input type="password" class="form_input" name="new_password"
                                placeholder="Enter your new password..." maxlength="30">
                                <input type="submit" class="change_value_button"
                                name="submit_password_change" value="Submit">
                            </form>
                        </div>
                    </div>
                    <div class="quick_action grey_background">
                    <div class="sign_out_overlay" id="view_bookings_button"></div>
                        <div class="item_title_container">
                            <h1 class="quick_action_title" id="view_bookings_button_text">View Bookings</h1>
                        </div>
                    </div>
                    <div class="quick_action grey_background">
                    <div class="sign_out_overlay" id="view_orders_button"></div>
                        <div class="item_title_container">
                            <h1 class="quick_action_title" id="view_orders_button_text">View Orders</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="column_two">
                <div class="personal_info_checkout" id="container_one">
                        <div class="item_title_container">
                            <h1 class="checkout_title">Your Info</h1>
                        </div>
                        <form method="POST" class="checkout_form">
                            <div class="settings_text_box">
                                <h1 class="settings_display"><?php echo $username?></h1>
                                <h1 class="settings_display_label">Username</h1>
                            </div>
                            <div class="settings_text_box">
                                <h1 class="settings_display"><?php echo $email?></h1>
                                <h1 class="settings_display_label">Email</h1>
                            </div>
                        </form>
                    </div>

    
                    <div class="accessibility_section" id="container_two">
                        <div class="item_title_container">
                            <h1 class="checkout_title">Accessibility</h1>
                        </div>
                        <form method="POST" class="checkout_form">
                            <div class="settings_text_box" id="change_theme">
                                <h1 class="settings_display" id="change_theme_text">
                                    <?php if ($_COOKIE['theme'] == "dark") {echo "Dark Mode";}
                                    else {echo "Light Mode";} ?></h1>
                                <h1 class="settings_display_label">Theme</h1>
                            </div>
                        </form>
                    </div>

                    <div class="history_container display_none" id="booking_history_container">
                        <div class="history_section_title">Booking History</div>
                        <div class="history_scroll_section">
                            
                            <?php
                                $user_id = $_SESSION['user_id'];
                                $query = "SELECT * FROM users_booking WHERE user_id = $user_id";
                                $result = mysqli_query($database_conn, $query);

                                while ($item = mysqli_fetch_assoc($result)) {
                                    $location = $item['booking_location'];
                                    $date = $item['date_of_booking'];
                                    $number_of_guests = $item['number_of_guests'];
                                    $time_of_booking = $item['time_of_booking'];

                                    if ($time_of_booking < 12.00) {
                                        $hour = "am";
                                    } else {
                                        $hour = "pm";
                                    }
                                
                                    echo '<div class="history_item">
                                    <div class="booking_top">
                                        <h1 class="booking_title">' . $location . '</h1>
                                        <h1 class="booking_date">' . $date  . '</h1>
                                    </div>
                                    <div class="booking_bottom">
                                        <h1 class="booked_for_text">Booked for</h1>
                                        <h1 class="booking_for_number">' . $number_of_guests . '</h1>
                                    </div>
                                    <div class="time_section">
                                        <h1 class="booking_time">' . $time_of_booking . $hour . '</h1>
                                    </div>
                                </div>';
                                }

                            ?>

                        </div>
                    </div>

                    <div class="history_container display_none" id="order_history_container">
                        <div class="history_section_title">Pre-Order History</div>
                        <div class="history_scroll_section">
                            <?php
                                    $user_id = $_SESSION['user_id'];
                                    $query = "SELECT * FROM user_pre_order WHERE user_id = $user_id";
                                    $result = mysqli_query($database_conn, $query);

                                    while ($item = mysqli_fetch_assoc($result)) {
                                        $ordered_items = $item['pre_order_items'];
                                        $ordered_items = json_decode($ordered_items);
                                        $pre_order_date = $item['pre_order_date'];
                                        $pre_order_full_name = $item['pre_order_full_name'];
                                        $total_price = $item['pre_order_price'];
                                    
                                        echo '<div class="history_item">
                                        <div class="booking_top">
                                            <h1 class="booking_title">' . "Knaresborough" . '</h1>
                                            <h1 class="booking_date">' . $pre_order_date  . '</h1>
                                        </div>
                                        <div class="booking_bottom">
                                            <h1 class="booked_for_text">' . $pre_order_full_name .'</h1>
                                        </div>
                                        <div class="price_section">
                                            <h1 class="total_price">' . "£" . $total_price . '</h1>
                                        </div>
                                        <div class="item_list">';
                                         
                                        foreach ($ordered_items as $item) {
                                            $item = intval($item);
                                            $query = "SELECT * FROM menu WHERE item_id = $item";
                                            $items_result = mysqli_query($database_conn, $query);
                                            
                                            while ($menu_item = mysqli_fetch_assoc($items_result)) {
                                                $menu_item_image = $menu_item['item_image'];
                                                echo '<img class="small_history_image" src="'  . $menu_item_image . '" alt="">';
                                            }

                                            
                                        }
                                        
                                        echo '</div>
                                    </div>';
                                    }
                            ?>
                        </div>
                    </div>

            </div>

        </div>
    </div>


    <?php include_once "components/footer.php"; ?> <!-- Including the footer -->


<script src="shopping_list.js"></script> <!-- including the shopping cart script so you can use -->
<script src="burger.js"></script>
<script src="change_details.js"></script>
<script src="theme.js"></script>
<script src="font_size_switch.js"></script>
<script src="view_bookings.js"></script>

    
</body>
</html>
