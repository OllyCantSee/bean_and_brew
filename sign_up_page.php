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
        header ("Location: logged_in.php");
    } else {
        if (empty($_SESSION['save_inputs'])) {
            $_SESSION['save_inputs'] = ["", "", ""];
        }
        if (empty($_SESSION['form_error'])) {
            $_SESSION['form_error'] = "";
        }

        $username = "";
        $email = "";
        $password = "";
        $confirm_password = "";

        if (isset($_POST['submit_form'])) {
            $username = santatize_input($_POST['user_name'], false);
            $email = santatize_input($_POST['email'], true);
            $password = santatize_input($_POST['password'], false);
            $confirm_password = santatize_input($_POST['confirm_password'], false);

            $prepared_statement = "SELECT * FROM users WHERE email = ?";
            $statement = $database_conn->prepare($prepared_statement);
            $statement-> bind_param("s", $email);
            $statement->execute();
            $result = $statement->get_result();

            $_SESSION['save_inputs'] = [$username, $email, $password];

            if (empty($username) && empty($email) && empty($password) && empty($confirm_password)) {
                $_SESSION['form_error'] = "Please fill out all the fields";
            } elseif (empty($username)) {
                $_SESSION['form_error'] = "Please fill out the username field";
            } elseif (strlen($username) < 6 || strlen($username) > 18) {
                $_SESSION['form_error'] = "Please ensure your username is less that 18 characters and more than 6";
            } elseif (empty($email)) {
                $_SESSION['form_error'] = "Please fill out the email field";
            } elseif ($result->num_rows > 0) {
                $_SESSION['log_in_error'] = "Email already in use";
                header("Location: log_in_page.php");
            } elseif (empty($password)) {
                $_SESSION['form_error'] = "Please fill out the password field";
            } elseif (strlen($password) < 12 || strlen($password) > 30) {
                $_SESSION['form_error'] = "Please ensure your password is greater than 12 chracters and less than 30";
            } elseif (empty($confirm_password)) {
                $_SESSION['form_error'] = "Please fill out the confirm password field";
            } elseif ($password != $confirm_password) {
                $_SESSION['form_error'] = "Please ensure the passwords match";
            } else {

                $password_salt = password_hash(uniqid(rand(), true), PASSWORD_BCRYPT);
                $password = password_hash($password . $password_salt, PASSWORD_BCRYPT);

                $prepared_statement = "INSERT INTO users(user_name, email, password, password_salt) VALUES(?,?,?,?)";
                $statement = $database_conn->prepare($prepared_statement);
                $statement-> bind_param("ssss", $username, $email, $password, $password_salt);
                $statement->execute();
                $statement->close();

                session_destroy();
                session_start();

                $prepared_statement = "SELECT * FROM users WHERE email = ? AND password = ?";
                $statement = $database_conn->prepare($prepared_statement);
                $statement-> bind_param("ss", $email, $password);
                $statement->execute();
                $result = $statement->get_result();
                $result = $result->fetch_array();
                $_SESSION['user_id'] = $result['user_id'];
                header("Location: home_page.php");
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
    <title>Sign Up | Bean and Brew</title> <!-- This is the title of the page -->
</head>
<body <?php if ($_COOKIE['theme'] == "dark" && isset($_SESSION['user_id'])) {echo "class='dark'";} ?>>
    
    <section class="page_header_container">
        <a href="home_page.php" class="text_decoration_none"><h1 class="page_header">Bean and Brew</h1></a>
    </section>


    <section class="form_section">
        <?php echo $_SESSION['form_error'] ?>
        <form method="POST" class="entry_form"> <!-- Creating a form where I can create the inputs -->
        <div class="form_title_container"> <!-- This is usually not needed but the font we are using is strange.. -->
            <h1 class="form_title light_text">Sign Up</h1>
        </div>

            <input type="text" placeholder="Username..." name="user_name" class="form_input" autofocus="true"
            value="<?php echo $_SESSION['save_inputs'][0]?>"> <!-- User name input -->
            
            <input type="email" placeholder="Email..." name="email" class="form_input"
            value="<?php echo $_SESSION['save_inputs'][1]?>">  <!-- Email input -->

            <input type="password" placeholder="Password..." name="password" class="form_input"
            value="<?php echo $_SESSION['save_inputs'][2]?>"> <!-- Password input -->

            <input type="password" placeholder="Confirm your password..." name="confirm_password"
            class="form_input"> <!-- Confirm Password input -->

            <input type="submit" value="Submit" class="form_submit" name="submit_form"> <!-- Submit form button -->
        </form>

        <div class="form_link">
            <a href="log_in_page.php" class="text_decoration_none font_weight_500">
            Already have an account? <u>Log in here</u></a>
        </div>
    </section>

    <?php include_once "components/footer.php"; ?>
    

</body>
</html>