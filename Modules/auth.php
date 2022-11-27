<?php
session_start();

function login($username, $password) {
    if ($username == "admin" && $password == "P@ssW0rd") {
        $_SESSION["loggedin"] = True;
        header('location: customer.php');
        
    }
    else {
        $_SESSION['loginerror'] = 'Invalid credentials, try again.';
    }
}

?>