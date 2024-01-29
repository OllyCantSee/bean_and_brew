<?php

function check_cookies($database_conn) {

    include_once "database_conn.php";
    include_once "validation_functions/validation.php";

    if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
        $email = $_COOKIE['email'];
        $email = str_replace("%40", "@", $email);

        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($database_conn, $query);
        $result_array = $result->fetch_array();
        $stored_password = $result_array['password'];
        
        $password = $_COOKIE['password'];
        $password = str_replace("%24", "$", $password);


        if($result->num_rows > 0) {
            $email_exists = true;
        }

        if (($password == $stored_password) && ($email_exists == true)) {
            $_SESSION['user_id'] = $result_array['user_id'];
        }
    }
}

 