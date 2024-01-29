<?php

    session_start();

    include_once "database_conn.php";
    include_once "validation_functions/validation.php";

    $youtube_id = $_GET['youtube_id'];
    $lesson_id = $_GET['lesson_id'];

    $query = "SELECT * FROM baking_lessons WHERE baking_lesson_id = $lesson_id";
    $result = mysqli_query($database_conn, $query);
    $result_array = mysqli_fetch_array($result);
    
    $lesson_name = $result_array['baking_lesson_title'];
    $lesson_description = $result_array['baking_lesson_description'];

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

    
    <div class="page_container">
        <div class="small_background_container">
            <div class="baking_lesson">
            <div class="item_title_container">
                <h1 class="lesson_name"><?php echo $lesson_name ?></h1>
            </div>
            <h1 class="lesson_description"><?php echo $lesson_description ?></h1>

            <iframe width="1120" height="630" src=<?php echo "https://www.youtube.com/embed/" . $youtube_id ?>
                title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write;
                encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen style="border-radius: 30px"></iframe>
            </div>

            <a href="baking_lessons.php" class="text_decoration_none"><button class="back_button">Go Back</button></a>
            
        </div>
    </div>


    <?php include_once "components/footer.php"; ?>

    <script src="shopping_list.js"></script>
    <script src="burger.js"></script>
    
</body>
</html>
