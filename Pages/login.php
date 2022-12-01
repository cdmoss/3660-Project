<?php

include "../Modules/auth.php";

if (isset($_SESSION['loggedin'])) {
  header('location: customer.php');
}

if (isset($_POST['submitLogin'])) {
  login($_POST['loginUser'], $_POST['loginPassword']);
}

if (!empty($_SESSION['loginerror'])) {
  $error = $_SESSION['loginerror'];
  include "../Modules/error.php";
  $_SESSION['loginerror'] = NULL;
}

if (!empty($_SESSION['alertmessage'])) {
  include "../Modules/info.php";
}

?>

<script>
  function password_show_hide() {
  var x = document.getElementById("loginPassword");
  var show_eye = document.getElementById("show_eye");
  var hide_eye = document.getElementById("hide_eye");
  hide_eye.classList.remove("d-none");
  if (x.type === "password") {
    x.type = "text";
    show_eye.style.display = "none";
    hide_eye.style.display = "block";
  } else {
    x.type = "password";
    show_eye.style.display = "block";
    hide_eye.style.display = "none";
  }
}
</script>

<!doctype html>
<html lang="en">

<head>
  <title>Computer Repair - Login</title>
</head>

<body id="page-top">
  <div class="form-group login center-screen">
    <img src="../images/logoblack.png" style="margin-left: 15%; margin-bottom: -50px;" alt="Group 2 Computer Repair logo" width="300" height="300"> 
    <h1 style="text-align:center;">Computer Repair Login</h1>
    <hr>
    <form method='POST'>
      <span>Username:</span>
      <div class='input-group'><input type='text' class='form-control mb-2 mt-2' name='loginUser' /></div>
      <span>Password:</span>
      <div class="input-group mt-2">
        <input type="password" name="loginPassword" id="loginPassword" class="form-control" required="true" />
        <div class="input-group-append">
          <span class="input-group-text" onclick="password_show_hide();">
            <i class="fas fa-eye" id="show_eye"></i>
            <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
          </span>
        </div>
      </div>
      <hr>
      <input type='submit' style='width: 100%' name='submitLogin' class='btn btn-primary' value='Login' />
    </div>
  </form>
</div>

</body>

</html>
<?php include "../Modules/linksandscripts.php" ?>
