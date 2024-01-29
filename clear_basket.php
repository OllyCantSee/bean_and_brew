<?php
    session_start();
    $_SESSION['item_basket'] = [];

    header("Location: menu.php");
