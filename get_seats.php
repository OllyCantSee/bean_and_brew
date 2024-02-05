<?php
    include_once "database_conn.php";
    include_once "validation_functions/validation.php";


    $restaurantName = santatize_input($_GET['restaurant'], false);
    $query = "SELECT * FROM restaurant_seating WHERE restaurant_name = '$restaurantName'";
    $result = mysqli_query($database_conn, $query);
    $resultArray = $result->fetch_array();
    $seats = $resultArray['restaurant_seats'];
    echo $seats;

