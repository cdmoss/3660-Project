<?php 
  include "../data/db.php";
  session_start();

  if (!empty($_POST)) {
    foreach ($_POST as $name => $val) {
      if (str_contains($name, 'del_invoice_id_')) {
        $invoice_id = explode('_', $name);
        $db = Db::getInstance();
        $result = $db->delete('invoices', $invoice_id[3]);
        if (count($result->errors) > 0) {
          $_SESSION['errors_del'] = $result->errors;
        } else {
          header('location: invoice.php');
        }
      }
    }
  }

  if (isset($_POST['add_invoice'])) {
    if (empty($_POST['add_inv_cleared'])) {
      $_POST['add_inv_cleared'] = 0;
    } else if ($_POST['add_inv_cleared'] == 'on') {
      $_POST['add_inv_cleared'] = 1;
    }
    $db = Db::getInstance();
    $result = $db->addInvoice($_POST['add_inv_lbl'], $_POST['add_inv_cus'], $_POST['add_inv_cleared']);
    if (count($result->errors) > 0) {
      $_SESSION['errors_add'] = $result->errors;
    } else {
      header('location: invoice.php');
    } 
  }
?>

<!doctype html>
<html lang="en">

<head>
  <title>Computer Repair - Invoices</title>
</head>

<body>

  <!-- Sidebar -->
  <?php include "../Modules/sidebar.php" ?>

  <div class="container-fluid">
    <?php 
      if(!empty($_SESSION['errors_del'])) {
        foreach ($_SESSION['errors_del'] as $error) {
          include "../Modules/error.php";
        }
        session_unset();
      }
      if(!empty($_SESSION['errors_add'])) {
        foreach ($_SESSION['errors_add'] as $error) {
          include "../Modules/error.php";
        }
        session_unset();
      }
    ?>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addInvoiceModal">
      <i class='fa-solid fa-plus'></i><span class='ml-1'>Add an Invoice</span>
    </button>
    <!-- Table -->
    <form method="POST">
      <table class="table mt-3 table-striped table-bordered">
        <thead class="thead-dark">
          <tr>
            <th scope='col'>ID</th>
            <th scope='col'>Label</th>
            <th scope='col'>Created</th>
            <th scope='col'>Cleared</th>
            <th scope='col'>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $db = Db::getInstance();
          $result = $db->getAll('invoices');

          if (count($result->errors) > 0) {
            foreach ($result->errors as $error) {
              include "../Modules/error.php";
            }
          } else {
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
          }
          ?>
        </tbody>
      </table>
    </form>
  </div>

  <?php
  echo "<!-- Add Invoice Modal -->";
  echo "<div class='modal fade' id='addInvoiceModal' tabindex='-1' role='dialog' aria-labelledby='addInvoiceModalLabel' aria-hidden='true'>";
  echo "<div class='modal-dialog' role='document'>";
  echo "<div class='modal-content'>";
  echo "<div class='modal-header'>";
  echo "<h5 class='modal-title' id='addInvoiceModalLabel'>Add Invoice</h5>";
  echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
  echo "<span aria-hidden='true'>&times;</span>";
  echo "</button>";
  echo "</div>";
  echo "<div class='modal-body'>";
  echo "<form method='POST'>";
  echo "<div class='form-group add-stock-modal'><label for='add_inv_lbl'>Label</label><input type='text' class='form-control' name='add_inv_lbl' /></div>";
  echo "<div class='form-group'>";
  echo "<label for='name='add_inv_cus'>Select Customer for Invoice</label></br>";
  echo "<select class='form-control' style='width: 100%;' name='add_inv_cus' aria-label='Default select example'>";
  echo "<option selected>...</option>";

  $db = Db::getInstance();
  $result = $db->getAll('customers');

  if (count($result->errors) > 0) {
    foreach ($result->errors as $error) {
      include "../Modules/error.php";
    }
  } else {
    while ($customers = $result->data->fetch()) {
      echo "<option value='" . $customers['id'] . "'>Name: " . $customers['name'] . ' - Email: ' . $customers['email'] . "</option>";
    }
  }
  echo "</select></div>";
  echo "<div class='form-group add-stock-modal'><label for='add_inv_cleared'>Cleared</label><input type='checkbox' style='width:9%;' class='form-control' name='add_inv_cleared' /></div>";
  echo "</div>";
  echo "<hr'>";
  echo "<div class='modal-footer'>";
  echo "<div class='btn-group add-modal-footer mb-0'>";
  echo "<input type='submit' class='btn btn-primary' name='add_invoice' value='Submit'>";
  echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
  echo "</div>";
  echo "</form>";
  echo "</div>
        </div>
      </div>
    </div>";
  ?>

</body>

</html>

<?php include "../Modules/linksandscripts.php" ?>