<?php 
function validTable($table) {
    return TABLE::tryFrom($table) != null;
}

function validEmail($email) {
    return preg_match('/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email) == 1;
}

function validPhone($phone) {
    return preg_match('/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/', $phone) == 1;
}

function validateCustomer(&$result, $name, $email, $phone, $address) {
    if (is_null($name)) {
        $result->errors[] = 'A name was not provided.';
    }

    if (!validEmail($email) || is_null($email)) {
        $result->errors[] = 'A valid email was not provided.';
    }

    if (!validPhone($phone) || is_null($phone)) {
        $result->errors[] = 'A valid phone number was not provided.';
    }

    if (strlen($address) > 100) {
        $result->errors[] = 'The provided address exceeded maximum length.';
    }
}
?>