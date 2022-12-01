<?php 
  include "../data/db.php";
  session_start();

  include "../Modules/authcheck.php";

  if (!empty($_POST)) {
    foreach ($_POST as $name => $val) {
      if (str_contains($name, 'del_invoice_id_')) {
        $invoice_id = explode('_', $name);
        $db = Db::getInstance();
        $result = $db->delete('invoices', $invoice_id[3]);
        if (count($result->errors) > 0) {
          $_SESSION['errors_del_inv'] = $result->errors;
        } else {
          header('location: customerbyid.php?cus_id=' . $_SESSION['cus_id'] . '&cus_name=' . $_SESSION['cus_name'] . '');
        }
      }
    }
  }
  
  if (isset($_POST['del_customer'])) {
    $db = Db::getInstance();
    $result = $db->delete('customers', $_GET['cus_id']);
    if (count($result->errors) > 0) {
      $_SESSION['errors_del'] = $result->errors;
    } else {
      header('location: customer.php');
    }
  }
  
  
  if (isset($_POST['edit_customer'])) {
    $db = Db::getInstance();
    $result = $db->editCustomer($_POST['cus_id'], $_POST['cus_name'], $_POST['cus_email'], $_POST['cus_phone'], $_POST['cus_address']);
    if (count($result->errors) > 0) {
      $_SESSION['errors_edit'] = $result->errors;
    } else {
      header('location: customerbyid.php?cus_id=' . $_POST['cus_id'] . '&cus_name=' . $_POST['cus_name'] . '');
    }
  }
?>

<!doctype html>
<html lang="en">

<head>
  <title>Computer Repair - Customer Information</title>
</head>

<body id="page-top">

<!-- Sidebar -->
<?php include "../Modules/sidebar.php" ?>

<?php
$db = Db::getInstance();
$result = $db->getSingleById('customers', $_GET['cus_id']);

if (count($result->errors) > 0) {
  foreach ($result->errors as $error) {
    include "../Modules/error.php";
  }
} else {
  while ($customer = $result->data->fetch()) {
    $_SESSION['cus_name'] = $customer['name'];
    $_SESSION['cus_id'] = $customer['id'];
  echo "<div style='display:block;width:95%;margin-left:auto;margin-right:auto;'>";
  
  //Display errors
  if(!empty($_SESSION['errors_edit'])) {
    foreach ($_SESSION['errors_edit'] as $error) {
      include "../Modules/error.php";
    }
    unset($_SESSION['errors_edit']);
  }
  if(!empty($_SESSION['errors_del'])) {
    foreach ($_SESSION['errors_del'] as $error) {
      include "../Modules/error.php";
    }
    unset($_SESSION['errors_del']);
  }
  if(!empty($_SESSION['errors_del_inv'])) {
    foreach ($_SESSION['errors_del_inv'] as $error) {
      include "../Modules/error.php";
    }
    unset($_SESSION['errors_del_inv']);
  }
  if(!empty($_SESSION['alertmessage'])) {
      include "../Modules/info.php";
      unset($_SESSION['alertmessage']);
    }

    echo "<div id='customer_information' style='width:25%;float:left;'>";
      echo "<form method='POST'>";
        echo "<h5>Customer Information</h5>";
        echo "<hr>";
        echo "<div class='form-group cusById'><label for='cus_id'>Customer ID</label><input type='text' class='form-control' name='cus_id' value='" . $customer['id'] . "' readonly /></div>";
        echo "<div class='form-group cusById'><label for='cus_name'>Name</label><input type='text' class='form-control' name='cus_name' value='" . $customer['name'] . "' /></div>";
        echo "<div class='form-group cusById'><label for='cus_phone'>Phone Number</label><input type='text' class='form-control' name='cus_phone' value='" . $customer['phone'] . "' /></div>";
        echo "<div class='form-group cusById'><label for='cus_email'>Email Address</label><input type='email' class='form-control' name='cus_email' value='" . $customer['email'] . "' /></div>";
        echo "<div class='form-group cusById'><label for='cus_address'>Address</label><input type='text' class='form-control' name='cus_address' value='" . $customer['address'] . "' /></div>";
        echo "<div class='btn-group cusById' role='group'>";
        echo "<input type='submit' name='edit_customer' class='btn btn-outline-dark' value='Save Changes' />";
        echo "<input type='submit' name='del_customer' class='btn btn-outline-danger' value='Delete' />";
        echo "<a href='customer.php' class='btn btn-outline-primary'>Go Back</a>";
      echo "</form>";
    echo "</div>";
    echo "</div>";

    echo "<div id='invoice_information' style='width:75%;float:left;'>";
      $db = Db::getInstance();
      $result = $db->getInvoicesByCustomer($_GET['cus_id']);

      if (count($result->errors) > 0) {
        foreach ($result->errors as $error) {
          include "../Modules/error.php";
        }
      } else {
        echo "<form method='POST'>
          <h5>Customer Invoices</h5>
          <hr>
          <table class='table mt-3 table-striped table-bordered'>
            <thead class='thead-dark'>
              <tr> 
                <th scope='col'>ID</th>
                <th scope='col'>Label</th>
                <th scope='col'>Created</th>
                <th scope='col'>Cleared</th>
                <th scope='col'>Actions</th>
              </tr>
            </thead>
            <tbody>";
              while ($invoices = $result->data->fetch()) {
                echo "<tr>";
                  echo "<th scope='row'>" . $invoices['id'] . "</th>";
                  echo "<td>" . $invoices['label'] . "</td>";
                  echo "<td>" . $invoices['created'] . "</td>";
                  if ($invoices['cleared'] == 1) {
                    echo "<td><i class='fa-solid fa-check'></i></td>";
                  } elseif ($invoices['cleared'] == 0) {
                    echo "<td><i class='fa-solid fa-x'></i></td>";
                  }
                  echo "<td><div class='btn-group' role='group'>";
                  echo "<a href='invoicebyid.php?invoice_id=" . $invoices['id'] . "' class='btn btn-primary'>View/Edit</a>";
                  echo "<input type='submit' name='del_invoice_id_" . $invoices['id'] . "' class='btn btn-danger' value='Delete' />";
                echo "</tr>";
                echo "</div>";
              }
    echo "</div>";
      
      echo "</tbody>
        </table>
      </form>";
    }
  echo "</div>";
  }
}
?>

</body>
</html>
<?php include "../Modules/linksandscripts.php" ?>