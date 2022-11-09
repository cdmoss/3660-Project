<?php include "../data/db.php" ?>

<?php
  if (isset($_POST['add_invoice'])) {
      $db = Db::getInstance();
      $result = $db->addInvoice($_POST['add_sto_name'], $_POST['add_sto_price']);
      if (count($result->errors) > 0) {
        foreach ($result->errors as $error) {
          echo "$error";
        }
    }
    //header('location: stock.php');
  }
?>

<!doctype html>
<html lang="en">
  <head>
  </head>
  <body>

    <!-- Sidebar -->
    <?php include "../Modules/sidebar.php" ?>

    <div class="container-fluid">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addInvoiceModal">
        <i class='fa-solid fa-plus'></i><span class='ml-1'>Add an Invoice</span>
    </button>
    <!-- Table -->
    <table class="table mt-3">
    <thead class="thead-dark">
      <tr> 
        <th>ID</th>
        <th>Label</th>
        <th>Created</th>
        <th>Cleared</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $db = Db::getInstance();
        $result = $db->getAll('invoices');

        if (count($result->errors) > 0) {
          foreach ($result->errors as $error) {
            echo "$error";
          }
        }
        else {
          while ($invoices = $result->data->fetch()) {
            echo "<tr>";
            echo "<td>" . $invoices['id'] ."</td>";
            echo "<td>" . $invoices['label'] . "</td>";
            echo "<td>" . $invoices['created'] . "</td>";
            echo "<td>" . $invoices['cleared'] . "</td>";
            echo "<td><div class='btn-group' role='group'>";
            echo "<a href='customerbyid.php?inv_id=" . $invoices['id'] . "' class='btn btn-primary'>View/Edit</a>";
            echo "<input type='submit' name='delCustomer' class='btn btn-danger' value='Delete' />";
            echo "</tr>";
            echo "</div>";
          }
        }
      ?>
    </tbody>
    </table>
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
            echo "<div class='form-group'><label for='name='add_inv_cus'>Select Customer for Invoice</label></br><select class='form-control' style='width: 100%;' name='add_inv_cus' aria-label='Default select example'>
            <option selected>...</option>
            <option value='1'>One</option>
          </select></div>";
            echo "<div class='form-group add-stock-modal'><label for='add_inv_cleared'>Cleared</label><input type='checkbox' class='form-control' name='add_inv_cleared' /></div>";
          echo "</div>";
          echo "<hr'>";
          echo "<div class='modal-footer'>";
            echo "<div class='btn-group add-stock-modal-footer mb-0'>";
              echo "<input type='submit' class='btn btn-primary' name='invoiceAdd' value='Submit'>";
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
