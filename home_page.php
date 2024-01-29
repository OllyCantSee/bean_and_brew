<?php

    session_start();

    include_once "database_conn.php";
    include_once "validation_functions/validation.php";
    include_once "check_login_cookies.php";

    if (!isset($_SESSION['user_id'])) {
        check_cookies($database_conn);
    }

    if (!isset($_SESSION['item_basket'])) {
        $_SESSION['item_basket'] = [];
    }

    if (!isset($_COOKIE['theme'])) {
        $_COOKIE['theme'] = "light";
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

    <section class="home_background">
        <div class="darken_overlay"></div>
        <img src="images/home_background_img.png" alt="Picture of a coffe mug,
        glasses and a book set down on a table ready for someone to start reading"
        class="home_image"><!-- ALT TAG for accessibility -->

        <div class="home_title_container"> <!-- This is the container that holds the main text -->
            <h1 class="home_title">Grab a cup</h1>
        </div>
    </section>

    <section class="home_buttons">
        <div class="home_buttons_container"> <!-- This is the container that holds all the home page buttons -->
            <a href="baking_lessons.php"><button class="home_button">Baking<br>Lessons</button></a>
            <a href="menu.php"><button class="home_button">Pre-Order<br>Coffee</button></a>
            <a href="book_table.php"><button class="home_button">Book a<br>Table</button></a>
        </div>
    </section>
    
    <section class="where_home_section">
        <h1 class="where_title">Where are we?</h1>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2821.8434579424193!2d-1.5411120674792207!3d53.
            99517240042383!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487953e71affdc87%3A0xb6cc5342aff13372!2s
            Bean%20%26%20Bud!5e1!3m2!1sen!2suk!4v1706271615970!5m2!1sen!2suk" width="1200" height="750" style="border-radius:
            30px; border: none;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>


    <?php include_once "components/footer.php"; ?> <!-- Including the footer -->

    <script src="shopping_list.js"></script> <!-- including the shopping cart script so you can use -->
    <script src="burger.js"></script>
</body>
</html>
