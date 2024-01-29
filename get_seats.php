<?php
include_once "database_conn.php";

    $restaurantName = $_GET['restaurant'];
    $query = "SELECT * FROM restaurant_seating WHERE restaurant_name = '$restaurantName'";
    $result = mysqli_query($database_conn, $query);
    $resultArray = $result->fetch_array();
    $seats = $resultArray['restaurant_seats'];
    echo $seats;

