<?php 
  include "../data/db.php";
  session_start();

  include "../Modules/authcheck.php";

  if (isset($_POST['add_customer'])) {
    $db = Db::getInstance();
    $result = $db->addCustomer($_POST['add_cus_name'], $_POST['add_cus_email'], $_POST['add_cus_phone'], $_POST['add_cus_address']);
    if (count($result->errors) > 0) {
      $_SESSION['errors_add'] = $result->errors;
    } else {
      header('location: customer.php');
    }
  }

  if (!empty($_POST)) {
    foreach ($_POST as $name => $val) {
      if (str_contains($name, 'del_customer_id_')) {
        $cus_id = explode('_', $name);
        $db = Db::getInstance();
        $result = $db->delete('customers', $cus_id[3]);
        if (count($result->errors) > 0) {
          $_SESSION['errors_del'] = $result->errors;
        } else {
          header('location: customer.php');
        }
      }
    }
  }
?>

<!doctype html>
<html lang="en">

<head>
  <title>Computer Repair - Customers</title>
</head>

<body id="page-top">

  <!-- Sidebar -->
  <?php include "../Modules/sidebar.php" ?>

  <div class="container-fluid">
    <?php // Display Errors
    if(!empty($_SESSION['errors_add'])) {
      foreach ($_SESSION['errors_add'] as $error) {
        include "../Modules/error.php";
      }
      session_unset();
    }
    if(!empty($_SESSION['errors_del'])) {
      foreach ($_SESSION['errors_del'] as $error) {
        include "../Modules/error.php";
      }
      session_unset();
    }
    ?>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCustomerModal">
      <i class='fa-solid fa-plus'></i><span class='ml-1'>Add a Customer</span>
    </button>

    <!-- Table -->
    <form method="POST">
      <table class="table mt-3 table-striped table-bordered">
        <thead class="thead-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Address</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $db = Db::getInstance();
          $result = $db->getAll('customers');

          if (count($result->errors) > 0) {
            foreach ($result->errors as $error) {
              include "../Modules/error.php";
            }
          } else {
            while ($customer = $result->data->fetch()) {
              echo "<tr>";
                echo "<th scope='row'>" . $customer['id'] . "</th>";
                echo "<td>" . $customer['name'] . "</td>";
                echo "<td>" . $customer['email'] . "</td>";
                echo "<td>" . $customer['phone'] . "</td>";
                echo "<td>" . $customer['address'] . "</td>";
                echo "<td><div class='btn-group' role='group'>";
                echo "<a href='customerbyid.php?cus_id=" . $customer['id'] . "&cus_name=" . $customer['name'] . "' class='btn btn-primary'>View/Edit</a>";
                echo "<input type='submit' name='del_customer_id_" . $customer['id'] . "' class='btn btn-danger' value='Delete' />";
              echo "</tr>";
              echo "</div>";
            }
          }
          ?>
        </tbody>
      </table>
    </form>

    <?php
    echo "<!-- Add Customer Modal -->";
    echo "<div class='modal fade' id='addCustomerModal' tabindex='-1' role='dialog' aria-labelledby='addCustomerModalLabel' aria-hidden='true'>";
    echo "<div class='modal-dialog' role='document'>";
    echo "<div class='modal-content'>";
    echo "<div class='modal-header'>";
    echo "<h5 class='modal-title' id='addCustomerModalLabel'>Add Customer</h5>";
    echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
    echo "<span aria-hidden='true'>&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<div class='modal-body'>";

    echo "<form method='POST'>";
    echo "<div class='form-group add-customer-modal'><label for='add_cus_name'>Name</label><input type='text' class='form-control' name='add_cus_name' /></div>";
    echo "<div class='form-group add-customer-modal'><label for='add_cus_phone'>Phone Number</label><input type='text' class='form-control' name='add_cus_phone' /></div>";
    echo "<div class='form-group add-customer-modal'><label for='add_cus_email'>Email Address</label><input type='email' class='form-control' name='add_cus_email' /></div>";
    echo "<div class='form-group add-customer-modal'><label for='add_cus_address'>Address</label><input type='text' class='form-control' name='add_cus_address' /></div>";
    echo "</div>";
    echo "<div class='modal-footer'>";
    echo "<div class='btn-group add-modal-footer mb-0'>";
    echo "<input type='submit' class='btn btn-primary' name='add_customer' value='Submit' />";
    echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
    echo "</div>";
    echo "</form>";
    echo "</div>
          </div>
        </div>
      </div>";
    ?>

  </div>

</body>

</html>

<?php include "../Modules/linksandscripts.php" ?>