<?php include "../data/db.php" ?>

<?php 
    if(isset($_POST['del_invoice'])) {
        $db = Db::getInstance();
        $result = $db->deleteInvoice($_GET['invoice_id']);
        if (count($result->errors) > 0) {
            foreach ($result->errors as $error) {
              echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
              echo "$error";
              echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                echo "<span aria-hidden='true'>&times;</span>";
              echo "</button>
            </div>";
            }
        }
        header('location: invoice.php');
    }


    if(isset($_POST['edit_invoice'])) {
        if (empty($_POST['invoice_cleared'])) {
            $_POST['invoice_cleared'] = 0;
          } else if ($_POST['invoice_cleared'] == 'on') {
            $_POST['invoice_cleared'] = 1;
          }
        $db = Db::getInstance();
        $result = $db->editInvoice($_POST['invoice_id'], $_POST['invoice_lbl'], $_POST['invoice_cleared'], $_POST['invoice_cus_id']);
        if (count($result->errors) > 0) {
            foreach ($result->errors as $error) {
              echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
              echo "$error";
              echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                echo "<span aria-hidden='true'>&times;</span>";
              echo "</button>
            </div>";
            }
        }
        header('location: invoicebyid.php?invoice_id=' . $_POST['invoice_id'] . '');
    }

?>

<!-- Sidebar -->
<?php include "../Modules/sidebar.php" ?>

<?php 
$db = Db::getInstance();
$result = $db->getSingleById('invoices', $_GET['invoice_id']);

if (count($result->errors) > 0) {
    foreach ($result->errors as $error) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
        echo "$error";
        echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
          echo "<span aria-hidden='true'>&times;</span>";
        echo "</button>
      </div>";
    }
}
else {
    while ($invoice = $result->data->fetch()) {
        echo "<div style='display:block;width:95%;margin-left:auto;margin-right:auto;'>";
        echo "<div class='card'>
        <div class='card-header' id='headingOne'>
          <h5 class='mb-0'>
            <button class='btn btn-link' data-toggle='' data-target='' aria-expanded='true' aria-controls='collapseOne'>
              Invoice Information
            </button>
          </h5>
        </div>";
    
        echo "<div id='collapseOne' class='collapse show' aria-labelledby='headingOne'>";
        echo "<div class='card-body'>";
        echo "<form method='POST'>";
            echo "<div class='form-group inputById'><label for='invoice_id'>Invoice ID</label><input type='text' class='form-control' name='invoice_id' value='" . $invoice['id'] . "' readonly /></div>";
            echo "<div class='form-group inputById'><label for='invoice_lbl'>Label</label><input type='text' class='form-control' name='invoice_lbl' value='" . $invoice['label'] . "' /></div>";
            //echo "<div class='form-group inputById'><label for='invoice_created'>Created</label><input type='text' class='form-control' name='invoice_created' value='" . $invoice['created'] . "' /></div>";
            echo "<div class='form-group inputById'><label for='name='invoice_cus_id'>Select Customer for Invoice</label>";
            echo "<select class='form-control inputById' style='width:100%;margin-left:0%;' name='invoice_cus_id' aria-label='Default select example'>";
            $db = Db::getInstance();
            $result = $db->getSingleById('customers', $invoice['customer_id']);
            
            if (count($result->errors) > 0) {
                foreach ($result->errors as $error) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
                    echo "$error";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                      echo "<span aria-hidden='true'>&times;</span>";
                    echo "</button>
                  </div>";
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
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
                echo "$error";
                echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                  echo "<span aria-hidden='true'>&times;</span>";
                echo "</button>
              </div>";
              }
            }
            else {
              while ($customers = $result->data->fetch()) {
                echo "<option value='" . $customers['id'] . "'>Name: " . $customers['name'] . ' - Email: ' . $customers['email'] . "</option>";
              }
            }
            echo "</select></div>";
            if($invoice['cleared'] == 1) {
                echo "<div class='form-group inputById'><label for='invoice_cleared'>Cleared</label><input type='checkbox' style='width:9%;' class='form-control' name='invoice_cleared' checked /></div>";
            } else {
                echo "<div class='form-group inputById'><label for='invoice_cleared'>Cleared</label><input type='checkbox' style='width:9%;' class='form-control' name='invoice_cleared' /></div>";
            }
            echo "<div class='btn-group inputById' role='group'>";
            echo "<input type='submit' name='edit_invoice' class='btn btn-warning' value='Save Changes' />";
            echo "<input type='submit' name='del_invoice' class='btn btn-danger' value='Delete' />";
            echo "<a href='invoice.php' class='btn btn-primary'>Go Back</a>";
            echo "</div>";
            echo "</form>";
        echo "</div>
        </div>
      </div>";
      echo "</div>";
    }
}
?>
<?php include "../Modules/linksandscripts.php" ?>