<?php include "../data/db.php" ?>

<?php
if (isset($_POST['del_invoice'])) {
    $db = Db::getInstance();
    $result = $db->delete('invoices', $_GET['invoice_id']);
    if (count($result->errors) > 0) {
        foreach ($result->errors as $error) {
            include "../Modules/error.php";
        }
    }
    header('location: invoice.php');
}


if (isset($_POST['edit_invoice'])) {
    if (empty($_POST['invoice_cleared'])) {
        $_POST['invoice_cleared'] = 0;
    } else if ($_POST['invoice_cleared'] == 'on') {
        $_POST['invoice_cleared'] = 1;
    }
    $db = Db::getInstance();
    $result = $db->editInvoice($_POST['invoice_id'], $_POST['invoice_lbl'], $_POST['invoice_cleared'], $_POST['invoice_cus_id']);
    if (count($result->errors) > 0) {
        foreach ($result->errors as $error) {
            include "../Modules/error.php";
        }
    }
    header('location: invoicebyid.php?invoice_id=' . $_POST['invoice_id'] . '');
}

if (isset($_POST['add_lineitem'])) {
  $db = Db::getInstance();
  $result = $db->addLineItem($_POST['add_li_sto'], $_GET['invoice_id'], $_POST['add_li_notes'], intval($_POST['add_li_qty']), floatval($_POST['add_li_price']));
  if (count($result->errors) > 0) {
    foreach ($result->errors as $error) {
      include "../Modules/error.php";
    }
  }
}

if (!empty($_POST)) {
  foreach ($_POST as $name => $val) {
    if (str_contains($name, 'del_lineitem_id_')) {
      $lineitem_id = explode('_', $name);
      $db = Db::getInstance();
      $result = $db->deleteLineItem($lineitem_id[3][0], $lineitem_id[3][1]);
      if (count($result->errors) > 0) {
        foreach ($result->errors as $error) {
          include "../Modules/error.php";
        }
      }
    }
  }
}

?>

<!-- Sidebar -->
<?php include "../Modules/sidebar.php" ?>

<?php
$db = Db::getInstance();
$result = $db->getSingleById('invoices', $_GET['invoice_id']);

if (count($result->errors) > 0) {
    foreach ($result->errors as $error) {
        include "../Modules/error.php";
    }
} else {
    while ($invoice = $result->data->fetch()) {
        echo "<div style='display:block;width:95%;margin-left:auto;margin-right:auto;'>";

        echo "<div id='invoice_information' style='width:25%;float:left;'>";
            echo "<h5>Invoice Information</h5>";
            echo "<hr>";
            echo "<form method='POST'>";
            echo "<div class='form-group invoiceById'><label for='invoice_id'>Invoice ID</label><input type='text' class='form-control' name='invoice_id' value='" . $invoice['id'] . "' readonly /></div>";
            echo "<div class='form-group invoiceById'><label for='invoice_lbl'>Label</label><input type='text' class='form-control' name='invoice_lbl' value='" . $invoice['label'] . "' /></div>";
            echo "<div class='form-group invoiceById'><label for='invoice_created'>Created</label><input type='text' class='form-control' name='invoice_created' value='" . $invoice['created'] . "' readonly /></div>";
            echo "<div class='form-group invoiceById'><label for='name='invoice_cus_id'>Select Customer for Invoice</label>";
            echo "<select class='form-control invoiceById' style='width:100%;margin-left:0%;' name='invoice_cus_id' aria-label='Default select example'>";
            $db = Db::getInstance();
            $result = $db->getSingleById('customers', $invoice['customer_id']);

            if (count($result->errors) > 0) {
                foreach ($result->errors as $error) {
                    include "../Modules/error.php";
                }
            } else {
                while ($customer = $result->data->fetch()) {
                    echo "<option value='" . $customer['id'] . "' selected>(Current) Name: " . $customer['name'] . ' - Email: ' . $customer['email'] . "</option>";
                }
            }

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
            if ($invoice['cleared'] == 1) {
                echo "<div class='form-group invoiceById'><label for='invoice_cleared'>Cleared</label><input type='checkbox' style='width:9%;' class='form-control' name='invoice_cleared' checked /></div>";
            } else {
                echo "<div class='form-group invoiceById'><label for='invoice_cleared'>Cleared</label><input type='checkbox' style='width:9%;' class='form-control' name='invoice_cleared' /></div>";
            }
            echo "<div class='btn-group invoiceById' role='group'>";
            echo "<input type='submit' name='edit_invoice' class='btn btn-warning' value='Save Changes' />";
            echo "<input type='submit' name='del_invoice' class='btn btn-danger' value='Delete' />";
            echo "<a href='invoice.php' class='btn btn-primary'>Go Back</a>";
            echo "</div>";
            echo "</form>";
        echo "</div>";

        echo "<div id='lineitem_information' style='width:75%;float:left;'>";
            $db = Db::getInstance();
            $result = $db->getLineItemByInvoice($_GET['invoice_id']);

            if (count($result->errors) > 0) {
                foreach ($result->errors as $error) {
                    include "../Modules/error.php";
                }
            } else {
            echo "<h5>Invoice Line Items</h5>";
            echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addLineItemModal'>
                  <i class='fa-solid fa-plus'></i><span class='ml-1'>Add a Line Item</span>
                </button>";
            echo "<hr>";
            echo "<form method='POST'>
            <table class='table mt-'>
            <thead class='thead-dark'>
            <tr>
                <th>Stock ID</th>
                <th>Invoice ID</th>
                <th>Label</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>";
                while ($lineitems = $result->data->fetch()) {
                    echo "<tr>";
                    echo "<td>" . $lineitems['stock_id'] . "</td>";
                    echo "<td>" . $lineitems['invoice_id'] . "</td>";
                    echo "<td>" . $lineitems['label'] . "</td>";
                    echo "<td>" . $lineitems['qty'] . "</td>";
                    echo "<td>" . $lineitems['price'] . "</td>";
                    echo "<td><div class='btn-group' role='group'>";
                    echo "<a href='invoicebyid.php?invoice_id=" . $lineitems['invoice_id'] . "' class='btn btn-primary'>View/Edit</a>";
                    echo "<input type='submit' name='del_lineitem_id_" . $lineitems['stock_id'] . $lineitems['invoice_id'] . "' class='btn btn-danger' value='Delete' />";
                    echo "</tr>";
                    echo "</div>";
                }
        echo "</div>";

        echo "</div>";
        echo "</div>";
        echo "</div>";



            echo "</tbody>
        </table>
      </form>";
        }
        echo "</div>";
    }
}
?>
  <!-- Add Line Item Modal -->
  <div class='modal fade' id='addLineItemModal' tabindex='-1' role='dialog' aria-labelledby='addLineItemModalLabel' aria-hidden='true'>
    <div class='modal-dialog' role='document'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h5 class='modal-title' id='addInvoiceModalLabel'>Add Invoice</h5>
          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>
        <div class='modal-body'>
          <form method='POST'>
            <div class='form-group'>
              <label for='add_li_lbl'>Select a Stock item</label>
              <select class='form-control' style='width: 100%;' name='add_li_sto' aria-label='Default select example'>
                <option selected>...</option>
                <?php
                  $db = Db::getInstance();
                  $result = $db->getAll('stock');

                  if (count($result->errors) < 0) {
                    foreach ($result->errors as $error) {
                      include "../Modules/error.php";
                    }
                  } else {
                    while ($stock = $result->data->fetch()) {
                      echo "<option value='" . $stock['id'] . "'>Name: " . $stock['name'] . ' - Current Price: ' . $stock['current_price'] . "</option>";
                    }
                  }
                 ?>
               </select>
             </div>
            <div class='form-group add-stock-modal'><label for='add_li_price'>Price</label><input type='text' class='form-control' name='add_li_price' /></div>
            <div class='form-group add-stock-modal'><label for='add_li_qty'>Quantity</label><input type='text' class='form-control' name='add_li_qty' /></div>
            <div class='form-group add-stock-modal'><label for='add_li_notes'>Notes</label><input type='text' class='form-control' name='add_li_notes' /></div>
            <div class='modal-footer'>
              <div class='btn-group add-modal-footer mb-0'>
                <input type='submit' class='btn btn-primary' name='add_lineitem' value='Submit'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

<?php include "../Modules/linksandscripts.php" ?>
