<?php
    session_start();

    include_once "database_conn.php";
    include_once "validation_functions/validation.php";
    include_once "check_login_cookies.php";

    if(!isset($_COOKIE['changeitem'])) { setcookie('changeitem', 0); header("Location: menu.php"); }
    
    if (!isset($_SESSION['user_id'])) {
        check_cookies($database_conn);
    }

    if (!isset($_COOKIE['theme'])) {
        $_COOKIE['theme'] = "light";
    }

    if (!isset($_SESSION['item_basket'])) {
        $_SESSION['item_basket'] = [];
    }

    if(isset($_POST['add_item'])) {

        if (isset($_POST['add_item'])) {

            if (isset($_POST['add_item_value'])) {
                if (count($_SESSION['item_basket']) < 99) {
                    array_push($_SESSION['item_basket'], $_POST['add_item_value']);
                }
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
    <title>Our Menu | Bean and Brew</title> <!-- This is the title of the page -->

    
</head>

<script>

    function changeItems(selectedValue) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'change_item.php?item=' + selectedValue, true);
        
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                document.cookie = "changeitem=" + xhr.responseText;
                console.log(xhr.responseText);
                location.reload();
            } else {
                console.error('Request failed with status ' + xhr.status);
            }
        };

        xhr.send();

    }



</script>

<body <?php if ($_COOKIE['theme'] == "dark" && isset($_SESSION['user_id'])) {echo "class='dark'";} ?> id="menu_page">
        
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

            <div class="items_filter">
                    <form action="" method="post" class="items_filter_form">
                    <select name="item_choice" id="" class="items_filter_select" onchange="changeItems(this.value)">
                        <option value="0" <?php echo ($_COOKIE['changeitem'] == '0') ? 'selected' : ''; ?>>Cafe Items</option>
                        <option value="1" <?php echo ($_COOKIE['changeitem'] == '1') ? 'selected' : ''; ?>>Coffee</option>
                    </select>

                    </form>
            </div>
        </div>

        <div class="menu_items_container">
            <div class="menu_items_grid">
            <?php

                if (isset($_COOKIE['changeitem']) && $_COOKIE['changeitem'] == 1) {
                    $query = "SELECT * FROM menu WHERE is_coffee = 1";
                } else {
                    $query = "SELECT * FROM menu WHERE is_coffee = 0";
                }

                
                $result = mysqli_query($database_conn, $query) or
                die("Could not connect: " . mysqli_error($database_conn));

                while ($row = mysqli_fetch_assoc($result)) {

                    $name = $row['item_name'];
                    $description = $row['item_description'];
                    $price = $row['item_price'];

                    $price = sprintf("%.2f", $price);

                    $image = $row['item_image'];
                    $item_id = $row['item_id'];

                    echo '
                        <div class="menu_item">
                            <div class="button_container">
                                <form method="POST" class="button_container">
                                    <input type="hidden" value="'. $item_id .'" name="add_item_value">
                                    <input type="submit" class="item_button" value="Add Item" name="add_item">
                                </form>
                            </div>

                            <div class="menu_item_left">
                                <div class="item_title_container">
                                    <h1 class="item_title">' . $name . '</h1>
                                </div>
                                <h2 class="item_description">' . $description . '</h2>
                                <h2 class="item_price">' . "£" . $price . '</h2>
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
    <script src="page_locator.js"></script>
    <script src="theme.js"></script>

</body>
</html>
