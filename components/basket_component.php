

<div class="basket_display">
    <div class="basket_buttons_container">
        <div class="purchase_section">
            <h1 class="total_basket_price"><?php

        $total_price = 0;

        foreach($_SESSION['item_basket'] as $item_id) {
            $query = "SELECT * FROM menu WHERE item_id = $item_id";
            $result = mysqli_query($database_conn, $query) or
            die("Could not connect: " . mysqli_error($database_conn));
            $result_array = mysqli_fetch_array($result);

            $total_price += $result_array['item_price'];
        }
        $total_price = sprintf("%.2f", $total_price);
        echo "Total: " . "£". $total_price;

        if (isset($_POST['delete_item'])) {
            $_SESSION['item_basket'] = array_diff($_SESSION['item_basket'], array($_POST['delete_item_value']));
        }


        ?></h1>
        <a href="checkout.php"><button class="checkout_button">Checkout</button></a>

        </div>
            <a href="clear_basket.php" class="clear_basket"><button
            class="clear_basket_button">Clear Basket</button></a>
    </div>

    <div class="scroll_section">
        <div class="basket_display_flex">

            <?php

                $item_basket = $_SESSION['item_basket'];
                $item_count = array_count_values($item_basket);

                if (count($item_basket) < 1) {
                    echo "<h1 class='no_items_in_basket'>There are no items in your basket | <a href='menu.php'>Menu</a></h1>";
                }

                foreach($item_count as $item_id => $quanity) {
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
                            <h1 class="basket_quantity">' . "x" . $quanity .'</h1>
                            <div class="basket_commands">
                                <h1 class="basket_price">' . "£" . $item_price_rounded . '</h1>
                                <form action="" method="post">
                                    <input type="hidden" value="' . $item_id . '" name="delete_item_value">
                                    <input type="submit" value="Remove" name="delete_item" class="delete_item">
                                </form>
                            </div>

                        </div>

                    </div>';
                
                }
            ?>

    </div>
    </div>

</div>
