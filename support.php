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

    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Support | Bean and Brew</title> <!-- This is the title of the page -->
</head>
<body <?php if ($_COOKIE['theme'] == "dark" && isset($_SESSION['user_id'])) {echo "class='dark'";} ?>>
    
    <?php include_once "components/top_navigation_bar.php"; ?>

    <?php include_once "components/basket_component.php"; ?>

    <?php include_once "components/burger_nav.php"; ?>

    <div class="page_container">
        <div class="small_background_container">
            <div class="faq_container">
                <div class="item_title_container">
                    <h1 class="lesson_name">Support/FAQ</h1>
                </div>
                <div class="faq_item">
                    <h1 class="faq_question">How do I activate dark mode?</h1>
                    <h1 class="faq_answer">Settings>Theme</h1>
                </div>
                <div class="faq_item">
                    <h1 class="faq_question">How do I sign out?</h1>
                    <h1 class="faq_answer">Settings>Sign out button</h1>
                </div>
                <div class="faq_item">
                    <h1 class="faq_question">Where are your restaurants?</h1>
                    <h1 class="faq_answer">Harrogate - Leeds</h1>
                </div>
                <div class="faq_item">
                    <h1 class="faq_question">How to find our social media?</h1>
                    <h1 class="faq_answer">Social media links are at the bottom of the page</h1>
                </div>

                <div class="question_section">
                    <div class="item_title_container">
                        <h1 class="lesson_name">Ask us a question</h1>
                    </div>
                    <form method="POST" class="question_form">
                        <textarea name="" id="" class="question_input">
                        </textarea>
                        <input type="submit" class="submit_question" value="Ask us now">
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
