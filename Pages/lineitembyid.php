<?php 
  include "../data/db.php";
  session_start();
  include "../Modules/authcheck.php";

  if (isset($_POST['del_lineitem'])) {
    $db = Db::getInstance();
    $result = $db->deleteLineItem($_GET['stock_id'], $_GET['invoice_id']);
    if (count($result->errors) > 0) {
      $_SESSION['errors_del'] = $result->errors;
    } else {
      header('location: invoicebyid.php?invoice_id=' . $_GET['invoice_id'] . '');
    }
  }
  
  if (isset($_POST['edit_lineitem'])) {
    $db = Db::getInstance();
    $result = $db->editLineItem($_GET['stock_id'], $_GET['invoice_id'], $_POST['lineitem_qty'], $_POST['lineitem_price'], $_POST['lineitem_label']);
    if (count($result->errors) > 0) {
      $_SESSION['errors_edit'] = $result->errors;
    } else {
      header('location: lineitembyid.php?stock_id=' . $_GET['stock_id'] . '&invoice_id=' . $_GET['invoice_id']);
    }
  }
?>

<!doctype html>
<html lang="en">

<head>
  <title>Computer Repair - Line Item Information</title>
</head>

<body id="page-top">

<!-- Sidebar -->
<?php include "../Modules/sidebar.php" ?>

<?php
$db = Db::getInstance();
$result = $db->getSingleLineItemByIds($_GET['stock_id'], $_GET['invoice_id']);

if (count($result->errors) > 0) {
  foreach ($result->errors as $error) {
    include "../Modules/error.php";
  }
} else {
  while ($lineitem = $result->data->fetch()) {
    echo "<div style='display:block;width:95%;margin-left:auto;margin-right:auto;'>";
    if (!empty($_SESSION['errors_del'])) {
      foreach($_SESSION['errors_del'] as $error) {
        include "../Modules/error.php";
      }
      session_unset();
    }
    if (!empty($_SESSION['errors_edit'])) {
      foreach($_SESSION['errors_edit'] as $error) {
        include "../Modules/error.php";
      }
      session_unset();
    }
    echo "<h5>Line Item Information</h5>";
    echo "<hr>";
    echo "<form method='POST'>";
    echo "<div class='form-group stockById'><label for='lineitem_stock_id'>Stock ID</label><input type='text' class='form-control' name='lineitem_stock_id' value='" . $lineitem['stock_id'] . "' readonly /></div>";
    echo "<div class='form-group stockById'><label for='lineitem_invoice_id'>Invoice ID</label><input type='text' class='form-control' name='lineitem_invoice_id' value='" . $lineitem['invoice_id'] . "' readonly /></div>";
    echo "<div class='form-group stockById'><label for='lineitem_qty'>Quantity</label><input type='text' class='form-control' name='lineitem_qty' value='" . $lineitem['qty'] . "' /></div>";
    echo "<div class='form-group stockById'><label for='lineitem_price'>Price</label><input type='text' class='form-control' name='lineitem_price' value='" . $lineitem['price'] . "' /></div>";
    echo "<div class='form-group stockById'><label for='lineitem_label'>Label</label><input type='text' class='form-control' name='lineitem_label' value='" . $lineitem['label'] . "' /></div>";
    echo "<div class='btn-group stockById' role='group'>";
    echo "<input type='submit' name='edit_lineitem' class='btn btn-outline-dark' value='Save Changes' />";
    echo "<input type='submit' name='del_lineitem' class='btn btn-outline-danger' value='Delete' />";
    echo "<a href='invoicebyid.php?invoice_id=" . $_GET['invoice_id'] . "' class='btn btn-outline-primary'>Go Back</a>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
  }
}
?>

</body>
</html>
<?php include "../Modules/linksandscripts.php" ?>
