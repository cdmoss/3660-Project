<?php $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1); ?>

<div class='border-left-success alert alert-success alert-dismissible fade mt-3 <?= $page == 'login.php' ? 'ml-3 mr-3' : '' ?> show' role='alert'>
  <?php echo $_SESSION['alertmessage']; ?>
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>

<?php unset($_SESSION['alertmessage']); ?>