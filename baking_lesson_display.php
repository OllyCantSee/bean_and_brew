<?php

    session_start();

    include_once "database_conn.php";
    include_once "validation_functions/validation.php";

    $youtube_id = $_GET['youtube_id']; // Getting the youtube ID from the URL
    $lesson_id = $_GET['lesson_id']; // Getting the lesson ID from the URL

    $query = "SELECT * FROM baking_lessons WHERE baking_lesson_id = $lesson_id"; 
    // Using the lesson ID to get the lesson that has been clicked
    $result = mysqli_query($database_conn, $query);
    $result_array = mysqli_fetch_array($result);
    // Fetching the results and turning the results into an array
    
    $lesson_name = $result_array['baking_lesson_title']; // Getting the lesson name from the results array
    $lesson_description = $result_array['baking_lesson_description'];
    // Getting the lesson description from the results array

    if (!isset($_COOKIE['theme'])) {
        $_COOKIE['theme'] = "light";
    }
    // If the cookie "theme" is not set, it is going to set it to light mode.



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

    <!-- ^^ Including all of the components for the site ^^ -->

    
    <div class="page_container">
        <div class="small_background_container">
            <div class="baking_lesson">
            <div class="item_title_container">
                <h1 class="lesson_name"><?php echo $lesson_name ?></h1> <!-- Echoing the lesson name and description that we got in php-->
            </div>
            <h1 class="lesson_description"><?php echo $lesson_description ?></h1> <!-- Echoing the lesson name and description that we got in php-->

            <iframe width="1120" height="630" src=<?php echo "https://www.youtube.com/embed/" . $youtube_id ?>
                title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write;
                encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen style="border-radius: 30px"></iframe>
            </div> <!-- Iframe which holds the embedded youtube video -->

            <a href="baking_lessons.php" class="text_decoration_none"><button class="back_button">Go Back</button></a>
            
        </div>
    </div>


    <?php include_once "components/footer.php"; ?>

    <script src="shopping_list.js"></script>
    <script src="burger.js"></script>
    
</body>
</html>
