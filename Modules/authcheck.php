<?php 

if (!isset($_SESSION['loggedin'])) {
    $_SESSION['alertmessage'] = 'You must login to access that page.';
    header('location: login.php');
}

?>