<?php 
  include "../data/db.php"; 
  session_start();

  if (isset($_POST['del_stock'])) {
    $db = Db::getInstance();
    $result = $db->delete('stock', $_GET['stock_id']);
    if (count($result->errors) > 0) {
      $_SESSION['errors_del'] = $result->errors;
    } else {
      header('location: stock.php');
    }
  }
  
  
  if (isset($_POST['edit_stock'])) {
    $db = Db::getInstance();
    $result = $db->editStockItem($_POST['stock_id'], $_POST['stock_name'], $_POST['stock_cur_price'], $_POST['stock_qty']);
    if (count($result->errors) > 0) {
      $_SESSION['errors_edit'] = $result->errors;
    } else {
      header('location: stockbyid.php?stock_id=' . $_POST['stock_id'] . '&stock_name=' . $_POST['stock_name'] . '');
    }
  }
?>

<!doctype html>
<html lang="en">

<head>
  <title>Computer Repair - Stock Information</title>
</head>

<body id="page-top">

<!-- Sidebar -->
<?php include "../Modules/sidebar.php" ?>

<?php
$db = Db::getInstance();
$result = $db->getSingleById('stock', $_GET['stock_id']);

if (count($result->errors) > 0) {
  foreach ($result->errors as $error) {
    include "../Modules/error.php";
  }
} else {
  while ($stock = $result->data->fetch()) {
    echo "<div style='display:block;width:95%;margin-left:auto;margin-right:auto;'>";
    if(!empty($_SESSION['errors_edit'])) {
      foreach($_SESSION['errors_edit'] as $error) {
        include "../Modules/error.php";
      }
      session_unset();
    }
    if (!empty($_SESSION['errors_del'])) {
      foreach($_SESSION['errors_del'] as $error) {
        include "../Modules/error.php";
      }
      session_unset();
    }
    echo "<h5>Stock Item Information</h5>";
    echo "<hr>";
    echo "<form method='POST'>";
    echo "<div class='form-group stockById'><label for='stock_id'>Stock ID</label><input type='text' class='form-control' name='stock_id' value='" . $stock['id'] . "' readonly /></div>";
    echo "<div class='form-group stockById'><label for='stock_name'>Name</label><input type='text' class='form-control' name='stock_name' value='" . $stock['name'] . "' /></div>";
    echo "<div class='form-group stockById'><label for='stock_cur_price'>Current Price</label><input type='text' class='form-control' name='stock_cur_price' value='" . $stock['current_price'] . "' /></div>";
    echo "<div class='form-group stockById'><label for='stock_qty'>Quantity</label><input type='text' class='form-control' name='stock_qty' value='" . $stock['qty'] . "' /></div>";
    echo "<div class='btn-group stockById' role='group'>";
    echo "<input type='submit' name='edit_stock' class='btn btn-outline-dark' value='Save Changes' />";
    echo "<input type='submit' name='del_stock' class='btn btn-outline-danger' value='Delete' />";
    echo "<a href='stock.php' class='btn btn-outline-primary'>Go Back</a>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
  }
}
?>
</body>
</html>
<?php include "../Modules/linksandscripts.php" ?>