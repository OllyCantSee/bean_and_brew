<?php

function santatize_input($input, bool $is_email) {
    if ($input === null) {
        return null;
    }

    $input = htmlspecialchars($input);
    $input = strip_tags($input);
    $input = stripslashes($input);
    $input = trim($input);

    if ($is_email == true) {
        $input = filter_var($input, FILTER_SANITIZE_EMAIL);
    }

    return $input;
}
function santatize_input_no_spaces($input, bool $is_email) {
    if ($input === null) {
        return null;
    }

    $input = htmlspecialchars($input);
    $input = strip_tags($input);
    $input = stripslashes($input);

    if ($is_email == true) {
        $input = filter_var($input, FILTER_SANITIZE_EMAIL);
    }

    return $input;
}
