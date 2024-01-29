<?php

session_start();

setcookie('email', "", 1);
setcookie('password', "", 1);

session_destroy();

header("Location: home_page.php");

