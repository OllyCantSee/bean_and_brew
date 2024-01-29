<?php

    session_start();

    include_once "database_conn.php";
    include_once "validation_functions/validation.php";

    if (isset($_POST['open_lesson'])) {
        header("Location: baking_lesson_display.php?lesson_id=" . $_POST['baking_lesson_id'] .
        "&youtube_id=" . $_POST['baking_lesson_ytube_id']);
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
    <title>Baking Lessons | Bean and Brew</title> <!-- This is the title of the page -->
</head>
<body <?php if ($_COOKIE['theme'] == "dark" && isset($_SESSION['user_id'])) {echo "class='dark'";} ?>>

    <?php include_once "components/top_navigation_bar.php"; ?>

    <?php include_once "components/basket_component.php"; ?>

    <?php include_once "components/burger_nav.php"; ?>

    <section class="menu_container">
        <div class="search_filter">
            <div class="search_bar">
                <input type="text" class="search_bar_outline" placeholder="Search for anything...">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="30"
                viewBox="0 0 28 30" fill="none" class="search_icon">
                    <circle cx="11.5" cy="11.5" r="11" stroke="#868686"/>
                    <path d="M18.9999 19.4998L27.5 29" stroke="#868686"/>
                </svg>
            </div>

            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="34"
            viewBox="0 0 36 34" fill="none" class="filter_icon">
                <line y1="5.34375" x2="35.0625" y2="5.34375" stroke="#868686"/>
                <line y1="17.0312" x2="35.0625" y2="17.0312" stroke="#868686"/>
                <line y1="28.7188" x2="35.0625" y2="28.7188" stroke="#868686"/>
                <circle cx="22.3125" cy="5.3125" r="4.8125" fill="#F8F8F8" stroke="#868686"/>
                <circle cx="9.5625" cy="17" r="4.8125" fill="#F8F8F8" stroke="#868686"/>
                <circle cx="22.3125" cy="28.6875" r="4.8125" fill="#F8F8F8" stroke="#868686"/>
            </svg>
        </div>

        <div class="menu_items_container">
            <div class="menu_items_grid">
            <?php
            
                $query = "SELECT * FROM baking_lessons";
                $result = mysqli_query($database_conn, $query) or
                die("Could not connect: " . mysqli_error($database_conn));

                while ($row = mysqli_fetch_assoc($result)) {

                    $name = $row['baking_lesson_title'];
                    $description = $row['baking_lesson_description'];
                    $image = $row['baking_lesson_image'];

                    $item_id = $row['baking_lesson_id'];
                    $baking_lesson_level = $row['baking_lesson_level'];
                    $baking_lesson_ytube_id = $row['baking_lesson_ytube_id'];

                    echo '
                        <div class="menu_item">
                            <div class="button_container">
                                <form method="POST" class="button_container">
                                    <input type="hidden" value="'. $item_id .'" name="baking_lesson_id">
                                    <input type="hidden" value="'. $baking_lesson_ytube_id .'"
                                    name="baking_lesson_ytube_id">
                                    <input type="submit" class="item_button" value="Open Lesson" name="open_lesson">
                                </form>
                            </div>

                            <div class="menu_item_left">
                                <div class="item_title_container">
                                    <h1 class="item_title">' . $name . '</h1>
                                </div>
                                <h2 class="item_description">' . $description . '</h2>
                            </div>
                            <div class="menu_image_container">
                                <div class="black_cover"></div>
                                <img src="' . $image . '" class="menu_image" />
                            </div>
                        </div>';
                }
                

        ?>
            </div>

        </div>
    </section>

    <?php include_once "components/footer.php"; ?>

    <script src="shopping_list.js"></script>
    <script src="burger.js"></script>
    
</body>
</html>
