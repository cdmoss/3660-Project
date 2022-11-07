<?php include "../data/db.php" ?>

<?php 
    if(isset($_POST['delCustomer'])) {
        $db = Db::getInstance();
        $result = $db->delete('customers', $_GET['cus_id']);
    }

    if(isset($_POST['editCustomer'])) {
        $db = Db::getInstance();
        $result = $db->editCustomer($_POST['cusid'], $_POST['cusname'], $_POST['cusemail'], $_POST['cusphone'], $_POST['cusaddress']);
    }
?>

<!-- Sidebar -->
<?php include "../Modules/sidebar.php" ?>

<?php 
$db = Db::getInstance();
$result = $db->getSingleById('customers', $_GET['cus_id']);

if (count($result->errors) > 0) {
    foreach ($result->errors as $error) {
        echo "$error";
    }
}
else {
    while ($customer = $result->data->fetch()) {
        echo "<form method='POST'>";
        echo "<div>";
        echo "<div class='form-group' style='min-width: 300px; width: 25%; margin-left: 2%;'><label for='cusid'>Customer ID</label><input type='text' class='form-control' id='cusid' value='" . $customer['id'] . "' readonly /></div>";
        echo "<div class='form-group' style='min-width: 300px; width: 25%; margin-left: 2%;'><label for='cusname'>Name</label><input type='text' class='form-control' id='cusname' value='" . $customer['name'] . "' /></div>";
        echo "<div class='form-group' style='min-width: 300px; width: 25%; margin-left: 2%;'><label for='cusphone'>Phone Number</label><input type='text' class='form-control' id='cusphone' value='" . $customer['phone'] . "' /></div>";
        echo "<div class='form-group' style='min-width: 300px; width: 25%; margin-left: 2%;'><label for='cusemail'>Email Address</label><input type='text' class='form-control' id='cusemail' value='" . $customer['email'] . "' /></div>";
        echo "<div class='form-group' style='min-width: 300px; width: 25%; margin-left: 2%;'><label for='cusaddress'>Address</label><input type='text' class='form-control' id='cusaddress' value='" . $customer['address'] . "' /></div>";
        echo "<div class='btn-group' role='group' style='min-width: 300px; width: 25%; margin-left: 2%;'>";
        echo "<input type='submit' name='editCustomer' class='btn btn-warning' value='Save Changes' />";
        echo "<input type='submit' name='delCustomer' class='btn btn-danger' value='Delete' />";
        echo "<a href='customer.php' class='btn btn-primary'>Go Back</a>";
        echo "</div>";
        echo "</div>";
        echo "</form>";
    }
}
?>
<?php include "../Modules/linksandscripts.php" ?>

