<nav class="burger_nav_bar">
        <div class="burger_nav_button_container">
            <a href="sign_up_page.php"><button class="nav_button burger_button">Sign Up</button></a>
            <a href="menu.php"><button class="nav_button fill_brown burger_button">Our Menu</button></a>
        </div>
        <div class="burger_nav_links">
            <a href="baking_lessons.php" class="text_decoration_none burger_text">Baking Lessons</a>
            <a href="support.php" class="text_decoration_none burger_text">Support</a>
            <a href="book_table.php" class="text_decoration_none burger_text">Book a space</a>
            <a href="settings.php" class="text_decoration_none burger_text">Settings</a>
            <a href="checkout.php" class="text_decoration_none burger_text">Checkout</a>
        </div>

        <div class="burger_basket_display">
            <div class="burger_basket_buttons">
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


                ?></h1>
                <a href="checkout.php"><button class="checkout_button">Checkout</button></a>

                </div>

                    <a href="clear_basket.php" class="clear_basket"><button
                class="clear_basket_button">Clear Basket</button></a>
            </div>

            <div class="burger_scroll_section">
                <div class="basket_display_flex">


                    <?php

                        $item_basket = $_SESSION['item_basket'];
                        $item_count = array_count_values($item_basket);

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
                                    <h1 class="basket_price">' . "£" . $item_price_rounded . '</h1>
                                </div>

                            </div>';
                        
                        }
                    ?>

            </div>
            </div>

        </div>

    </nav>