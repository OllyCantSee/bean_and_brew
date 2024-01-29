<?php

    session_start();

    include_once "database_conn.php";
    include_once "validation_functions/validation.php";
    include_once "check_login_cookies.php";

    if (!isset($_SESSION['user_id'])) {
        check_cookies($database_conn); // Checking if a user has remembered their account
    }

    if (!isset($_COOKIE['theme'])) { // Creating the cookies if they are not set
        $_COOKIE['theme'] = "light";
    }

    if (!isset($_SESSION['log_in_error'])) {
        $_SESSION['log_in_error'] = ""; // Setting the log in error to nothing before we add its values
    }

    if (isset($_SESSION['user_id'])) {
        header ("Location: logged_in.php");
    } else {
        if (empty($_SESSION['save_login_inputs'])) {
            $_SESSION['save_login_inputs'] = "";
        }
        if (empty($_SESSION['form_error'])) {
            $_SESSION['form_error'] = "";
        }

        if (isset($_POST['submit_form'])) {

            if(empty($_POST['email']) && empty($_POST['password'])) {
                $_SESSION['log_in_error'] = "Please fill out the fields...";
            } elseif (empty($_POST['email'])) {
                $_SESSION['log_in_error'] = "Please fill out the email field...";
            } elseif (empty($_POST['password'])) {
                $_SESSION['log_in_error'] = "Please fill out the password field...";
            } else {
                $email = santatize_input($_POST['email'], true);
                $password = santatize_input($_POST['password'], false);
    
                $prepared_statement = "SELECT * FROM users WHERE email = ?";
                $statement = $database_conn->prepare($prepared_statement);
                $statement-> bind_param("s", $email);
                $statement->execute();
                $result = $statement->get_result();
                $result = $result->fetch_array();
    
                $password_salt = $result['password_salt'];
                $stored_password = $result['password'];
                $user_id = $result['user_id'];
            
                if (password_verify($password . $password_salt, $stored_password)) {
                    session_destroy();
                    session_start();
    
                    $_SESSION['user_id'] = $user_id;

                    if($_POST['remember_me'] == "remember") {
                        setcookie("email", $email, time() + 30 * 30 * 24);
                        setcookie("password", $stored_password, time() + 30 * 30 * 24);
                    }
    
                    header("Location: home_page.php");
                } else {
                    $_SESSION['log_in_error'] = "Incorrect password, try again...";
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
    <title>Log In | Bean and Brew</title> <!-- This is the title of the page -->
</head>
<body <?php if ($_COOKIE['theme'] == "dark" && isset($_SESSION['user_id'])) {echo "class='dark'";} ?>>

    <section class="page_header_container">
        <a href="home_page.php" class="text_decoration_none"><h1 class="page_header">Bean and Brew</h1></a>
    </section>


    <section class="form_section">
        <h1 class="form_error"><?php echo $_SESSION['log_in_error'] ?></h1>
        <form method="POST" class="entry_form"> <!-- Creating a form where I can create the inputs -->
        <div class="form_title_container"> <!-- This is usually not needed but the font we are using is strange.. -->
            <h1 class="form_title light_text">Log In</h1>
        </div>
            
            <input type="email" placeholder="Email..." name="email" class="form_input"
            autofocus="true"> <!-- Email input -->

            <input type="password" placeholder="Password..." name="password" class="form_input"> <!-- Password input -->

            <input type="hidden" id="remember_me_value" name="remember_me" value="not">
            <h1 class="remember_me" id="remember_me">Not Remembering You | Click to toggle</h1>

            <input type="submit" value="Submit" class="form_submit" name="submit_form"> <!-- Submit form button -->

        </form>

        <div class="form_link">
            <a href="sign_up_page.php" class="text_decoration_none">Don't have an account? <u>Sign up here</u></a> <!-- Link to sign up page -->
        </div>
    </section>

    <?php include_once "components/footer.php"; ?> <!-- Including the footer -->

    <script src="theme.js"></script>
    <script src="remember_me.js"></script>

</body>
</html>
