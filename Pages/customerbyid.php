<?php include "../data/db.php" ?>

<?php

if (!empty($_POST)) {
  foreach ($_POST as $name => $val) {
    if (str_contains($name, 'del_invoice_id_')) {
      $invoice_id = explode('_', $name);
      $db = Db::getInstance();
      $result = $db->delete('invoices', $invoice_id[3]);
      if (count($result->errors) > 0) {
        foreach ($result->errors as $error) {
          include "../Modules/error.php";
        }
      }
      header('location: customerbyid.php?cus_id=' . $_POST['cus_id'] . '&cus_name=' . $_POST['cus_name'] . '');
    }
  }
}

if (isset($_POST['del_customer'])) {
  $db = Db::getInstance();
  $result = $db->delete('customers', $_GET['cus_id']);
  if (count($result->errors) > 0) {
    foreach ($result->errors as $error) {
      include "../Modules/error.php";
    }
  }
  header('location: customer.php');
}


if (isset($_POST['edit_customer'])) {
  $db = Db::getInstance();
  $result = $db->editCustomer($_POST['cus_id'], $_POST['cus_name'], $_POST['cus_email'], $_POST['cus_phone'], $_POST['cus_address']);
  if (count($result->errors) > 0) {
    foreach ($result->errors as $error) {
      include "../Modules/error.php";
    }
  }
  header('location: customerbyid.php?cus_id=' . $_POST['cus_id'] . '&cus_name=' . $_POST['cus_name'] . '');
}

?>

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
  echo "<div style='display:block;width:95%;margin-left:auto;margin-right:auto;'>";
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
        echo "<input type='submit' name='edit_customer' class='btn btn-warning' value='Save Changes' />";
        echo "<input type='submit' name='del_customer' class='btn btn-danger' value='Delete' />";
        echo "<a href='customer.php' class='btn btn-primary'>Go Back</a>";
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
          <table class='table mt-0'>
            <thead class='thead-dark'>
              <tr> 
                <th>ID</th>
                <th>Label</th>
                <th>Created</th>
                <th>Cleared</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>";
              while ($invoices = $result->data->fetch()) {
                echo "<tr>";
                  echo "<td>" . $invoices['id'] . "</td>";
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
<?php include "../Modules/linksandscripts.php" ?>