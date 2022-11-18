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
  <?php include "../Modules/sidebar.php" ?>

  <div class="form-group login">
    <h1 style="text-align:center;">Login</h1>
    <hr>
    <form method='POST'>
      <div class='form-group'><label for='loginUser'>Username</label><input type='text' class='form-control' name='loginUser' /></div>
      <div class='form-group'><label for='loginPass'>Password</label><input type='text' class='form-control' name='loginPass' /></div>
      <hr>
      <input type='submit' name='submitLogin' class='btn btn-primary' value='Login' />
    </div>
  </form>
</div>

</body>

</html>
<?php include "../Modules/linksandscripts.php" ?>
