<?php
echo "<div class='border-left-success alert alert-success alert-dismissible fade mt-3 mr-3 ml-3 show' role='alert'>";
        echo $_SESSION['alertmessage'];
        echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
          echo "<span aria-hidden='true'>&times;</span>";
        echo "</button>
      </div>";

    $_SESSION['alertmessage'] = NULL;
?>