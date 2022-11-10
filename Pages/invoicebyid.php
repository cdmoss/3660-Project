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
            echo "<div class='btn-group inputById' role='group'>";
            echo "<input type='submit' name='edit_invoice' class='btn btn-warning' value='Save Changes' />";
            echo "<input type='submit' name='del_invoice' class='btn btn-danger' value='Delete' />";
            echo "<a href='" . $_SERVER['HTTP_REFERER'] . "' class='btn btn-primary'>Go Back</a>";
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
                    echo "<a href='invoicebyid.php?invoice_id=" . $lineitems['id'] . "' class='btn btn-primary'>View/Edit</a>";
                    echo "<input type='submit' name='del_invoice_id_" . $lineitems['id'] . "' class='btn btn-danger' value='Delete' />";
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
<?php include "../Modules/linksandscripts.php" ?>