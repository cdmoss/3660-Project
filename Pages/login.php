<?php

include "../data/db.php";

if (isset($_POST['submitLogin'])) {
  // put login stuff here
}

?>

<!doctype html>
<html lang="en">

<head>
  <title>Login</title>
</head>

<body id="page-top">
  <div class="form-group login center-screen">
  ` <img src="../images/logoblack.png" style="margin-left: 15%; margin-bottom: -50px;" alt="Group 2 Computer Repair logo" width="300" height="300"> 
    <h1 style="text-align:center;">Computer Repair Login</h1>
    <hr>
    <form method='POST'>
      <div class='form-group'><label for='loginUser'>Username:</label><input type='text' class='form-control' name='loginUser' /></div>
      <div class='form-group'><label for='loginPass'>Password:</label><input type='text' class='form-control' name='loginPass' /></div>
      <hr>
      <input type='submit' style='width: 100%' name='submitLogin' class='btn btn-primary' value='Login' />
    </div>
  </form>
</div>

</body>

</html>
<?php include "../Modules/linksandscripts.php" ?>
