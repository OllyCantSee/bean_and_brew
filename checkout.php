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


    if (isset($_SESSION['user_id'])) {

        if (!isset($_SESSION['item_basket'])) {
            $_SESSION['item_basket'] = [];
        
        }

        if(isset($_POST['pre_order'])) {

            if(!empty($_POST['full_name_checkout']) && !empty($_POST['email_address']) && !empty($_POST['date'])) {

                $full_name = santatize_input($_POST['full_name_checkout'], true);
                $email_address = santatize_input($_POST['email_address'], true);
                $items = json_encode($_SESSION['item_basket']);
                $total_price = 0;
    
                foreach($_SESSION['item_basket'] as $item_id) {
                    $query = "SELECT * FROM menu WHERE item_id = $item_id";
                    $result = mysqli_query($database_conn, $query) or
                    die("Could not connect: " . mysqli_error($database_conn));
                    $result_array = mysqli_fetch_array($result);
    
                    $total_price += $result_array['item_price'];
                }
                $total_price = sprintf("%.2f", $total_price);
    
    
                $date = $_POST['date'];
                
                $template_query = "INSERT INTO user_pre_order(pre_order_items, pre_order_price, pre_order_date,
                pre_order_full_name, pre_order_email) VALUES (?,?,?,?,?)";
                $statement = $database_conn->prepare($template_query);
                $statement->bind_param("sssss", $items, $total_price, $date, $full_name, $email_address);
                $statement->execute();
                $statement->close();
                $_SESSION['item_basket'] = [];
    

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
    <title>Bean and Brew | Home</title> <!-- This is the title of the page -->
</head>

<body <?php if ($_COOKIE['theme'] == "dark" && isset($_SESSION['user_id'])) {echo "class='dark'";} ?>>

    <?php include_once "components/top_navigation_bar.php"; ?>

    <?php include_once "components/basket_component.php"; ?>

    <?php include_once "components/burger_nav.php"; ?>


    <div class="page_container">
        <div class="small_background_container">
            <div class="column_one">

                <div class="column_one_top_box blue_box">
                    <h2 class="checkout_total_sub">Basket Total:</h2>
                    <h1 class="checkout_total">
                        <?php

                        $total_price = 0;

                        foreach ($_SESSION['item_basket'] as $item_id) {
                            $query = "SELECT * FROM menu WHERE item_id = $item_id";
                            $result = mysqli_query($database_conn, $query) or
                                die("Could not connect: " . mysqli_error($database_conn));
                            $result_array = mysqli_fetch_array($result);

                            $total_price += $result_array['item_price'];
                        }

                        $total_price = sprintf("%.2f", $total_price);
                        $total_price_vat = $total_price;
                        $total_price_vat = $total_price + sprintf("%.2f", $total_price * 0.2);
                        $total_price_vat = sprintf("%.2f", $total_price_vat);
                        echo "£" . $total_price_vat;


                        ?>
                    </h1>
                <h1 class="vat"><?php echo "+ (20%) VAT applied: £" . sprintf("%.2f", $total_price * 0.2); ?></h1>
                </div>

                <div class="column_one_bottom_box">
                    <div class="scroll_section long no_background">
                        <div class="basket_display_flex">


                            <?php

                            $item_basket = $_SESSION['item_basket'];
                            $item_count = array_count_values($item_basket);

                            foreach ($item_count as $item_id => $quanity) {
                                $query = "SELECT * FROM menu WHERE item_id = $item_id";
                                $result = mysqli_query($database_conn, $query) or
                                    die("Could not connect: " . mysqli_error($database_conn));
                                $result_array = mysqli_fetch_array($result);

                                $name = $result_array['item_name'];
                                $image = $result_array['item_image'];
                                $item_price = $result_array['item_price'];
                                $item_price = $item_price * $quanity;
                                $item_price_rounded = sprintf("%.2f", $item_price);

                                echo '
                                <div class="basket_item">
                                    <img src="' . $image . '" alt="" class="basket_image">
                                    <div class="basket_details">
                                        <div class="basket_title_container">
                                            <h1 class="basket_title">' . $name . '</h1>
                                        </div>
                                        <h1 class="basket_quantity">' . "x" . $quanity . '</h1>
                                        <h1 class="basket_price">' . "£" .  $item_price_rounded . '</h1>
                                    </div>

                                </div>';

                            }
                            ?>

                        </div>
                    </div>
                </div>

            </div>

            <div class="column_two">
                <div class="personal_info_checkout">
                    <div class="item_title_container">
                        <h1 class="checkout_title">Personal Info</h1>
                    </div>
                    <form method="POST" class="checkout_form">
                        <input type="text" placeholder="Full Name..."
                        class="checkout_input_long" name="full_name_checkout" maxlength="40">
                        <input type="email" placeholder="Email Adress..."
                        class="checkout_input_long" name="email_address" maxlength="60">
                </div>

                <div class="payment_checkout">
                    <div class="item_title_container">
                        <h1 class="checkout_title">Payment Details</h1>
                    </div>
                    <div class="payment_details">
                        <input type="text" placeholder="Card number..." class="checkout_input_long" maxlength="19" name="card_number">
                        <input type="text" placeholder="Name on card..." class="checkout_input_long" maxlength="60">
                        <div class="payment_sub_section">
                            <input type="text" placeholder="Expiration Date..." class="checkout_input_long">
                            <input type="text" placeholder="Security Code..."
                            class="checkout_input_long" maxlength="3">
                        </div>
                    </div>
                </div>

                <div class="when_checkout">
                    <div class="item_title_container">
                        <h1 class="checkout_title">When?</h1>
                    </div>
                        <input type="date" class="checkout_input_long" name="date">
                        <input type="submit" value="Pre-Order Now" name="pre_order" class="checkout_form_button">
                    </form>
                </div>
            </div>
        </div>
    </div>






    <?php include_once "components/footer.php"; ?> <!-- Including the footer -->

    <script src="shopping_list.js"></script> <!-- including the shopping cart script so you can use -->
    <script src="burger.js"></script>


</body>

</html>
