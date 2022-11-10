<?php include "../data/db.php" ?>

<?php 
    if(isset($_POST['del_customer'])) {
        $db = Db::getInstance();
        $result = $db->deleteCustomer($_GET['cus_id']);
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
        header('location: customer.php');
    }


    if(isset($_POST['edit_customer'])) {
        $db = Db::getInstance();
        $result = $db->editCustomer($_POST['cus_id'], $_POST['cus_name'], $_POST['cus_email'], $_POST['cus_phone'], $_POST['cus_address']);
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
        header('location: customerbyid.php?cus_id=' . $_POST['cus_id'] . '&cus_name=' . $_POST['cus_name'] .'');
    }

?>

<!-- Sidebar -->
<?php include "../Modules/sidebar.php" ?>

<?php 
$db = Db::getInstance();
$result = $db->getSingleById('customers', $_GET['cus_id']);

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
    while ($customer = $result->data->fetch()) {
        echo "<div style='display:block;width:95%;margin-left:auto;margin-right:auto;'>";
        echo "<div class='card'>
        <div class='card-header' id='headingOne'>
          <h5 class='mb-0'>
            <button class='btn btn-link' data-toggle='collapse' data-target='#collapseOne' aria-expanded='true' aria-controls='collapseOne'>
              Customer Information
            </button>
          </h5>
        </div>";
    
        echo "<div id='collapseOne' class='collapse show' aria-labelledby='headingOne'>";
        echo "<div class='card-body'>";
        echo "<form method='POST'>";
            echo "<div class='form-group inputById'><label for='cus_id'>Customer ID</label><input type='text' class='form-control' name='cus_id' value='" . $customer['id'] . "' readonly /></div>";
            echo "<div class='form-group inputById'><label for='cus_name'>Name</label><input type='text' class='form-control' name='cus_name' value='" . $customer['name'] . "' /></div>";
            echo "<div class='form-group inputById'><label for='cus_phone'>Phone Number</label><input type='text' class='form-control' name='cus_phone' value='" . $customer['phone'] . "' /></div>";
            echo "<div class='form-group inputById'><label for='cus_email'>Email Address</label><input type='email' class='form-control' name='cus_email' value='" . $customer['email'] . "' /></div>";
            echo "<div class='form-group inputById'><label for='cus_address'>Address</label><input type='text' class='form-control' name='cus_address' value='" . $customer['address'] . "' /></div>";
            echo "<div class='btn-group inputById' role='group'>";
            echo "<input type='submit' name='edit_customer' class='btn btn-warning' value='Save Changes' />";
            echo "<input type='submit' name='del_customer' class='btn btn-danger' value='Delete' />";
            echo "<a href='customer.php' class='btn btn-primary'>Go Back</a>";
            echo "</div>";
            echo "</form>";
        echo "</div>
        </div>
      </div>";
    
      echo "<div class='card'>
        <div class='card-header' id='headingTwo'>
          <h5 class='mb-0'>
            <button class='btn btn-link collapsed' data-toggle='collapse' data-target='#collapseTwo'>
              Customer Invoices
            </button>
          </h5>
        </div>";
    
        echo "<div id='collapseTwo' class='collapse show' aria-labelledby='headingTwo'>
          <div class='card-body'>
            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
          </div>
        </div>
      </div>";
      echo "</div>";
    }
}
?>
<?php include "../Modules/linksandscripts.php" ?>