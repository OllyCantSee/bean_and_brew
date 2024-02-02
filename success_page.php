<?php

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

    if (isset($_GET['checkout_type']) && isset($_GET['date']) && !isset($_GET['time'])) {
        if ($_GET['checkout_type'] == "preorder") {
            $title = "Pre-Order Confirmed";
            $sub_text = "Ready for pickup on ";
            $date = $_GET['date'];
        }
    } elseif (isset($_GET['checkout_type']) && isset($_GET['date']) && isset($_GET['time'])) {
        if ($_GET['checkout_type'] == "booking") {
            $title = "Seat Booking Confirmed";
            $sub_text = "Booked for: ";
            $date = $_GET['date'];
            $time = $_GET['time'];
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
            <div class="success_container">

            <div class="item_title_container">
                <h1 class="success_header"><?php echo $title ?></h1>
            </div>
            <h1 class="success_subheader"> <?php echo $sub_text . $date ?> <?php if (isset($_GET['time'])) {echo "at " . $time; } ?></h1>


            <svg width="248" height="248" viewBox="0 0 248 248" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="248" height="248" rx="124" fill="#2979FF"/>
                <rect x="156.243" y="75" width="22" height="101.544" rx="11" transform="rotate(35 156.243 75)" fill="white"/>
                <rect x="73" y="137.599" width="22" height="53" rx="11" transform="rotate(-49 73 137.599)" fill="white"/>
            </svg>

            <a href="home_page.php" class="success_leave_button">Back to home</a>

            </div>
        </div>
    </div>






    <?php include_once "components/footer.php"; ?> <!-- Including the footer -->

    <script src="shopping_list.js"></script> <!-- including the shopping cart script so you can use -->
    <script src="burger.js"></script>


</body>

</html>


