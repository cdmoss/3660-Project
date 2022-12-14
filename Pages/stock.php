<?php 
  include "../data/db.php";
  session_start();
  include "../Modules/authcheck.php";

  if (!empty($_POST)) {
    foreach ($_POST as $name => $val) {
      if (str_contains($name, 'del_stock_id_')) {
        $stock_id = explode('_', $name);
        $db = Db::getInstance();
        $result = $db->delete('stock', $stock_id[3]);
        if (count($result->errors) > 0) {
          $_SESSION['errors_del'] = $result->errors;
        } else {
          $_SESSION['alertmessage'] = "You have successfully deleted the stock item.";
          //header('location: stock.php');
        }
      }
    }
  }
  
  if (isset($_POST['add_stock'])) {
    $db = Db::getInstance();
      $result = $db->addNewStockItem($_POST['add_sto_name'], $_POST['add_sto_price'], $_POST['add_sto_qty']);
      if (count($result->errors) > 0) {
        $_SESSION['errors_add'] = $result->errors;
      } else {
        $_SESSION['alertmessage'] = "You have successfully added a stock item.";
        //header('location: stock.php');
      }
  }
?>

<!doctype html>
<html lang="en">

<head>
  <title>Computer Repair - Stock</title>
</head>

<body id="page-top">

  <!-- Sidebar -->
  <?php include "../Modules/sidebar.php" ?>

  <div class="container-fluid">
  <?php // Display errors
      if(!empty($_SESSION['errors_del'])) {
        foreach ($_SESSION['errors_del'] as $error) {
          include "../Modules/error.php";
        }
        unset($_SESSION['errors_del']);
      }

      if(!empty($_SESSION['errors_add'])) {
        foreach ($_SESSION['errors_add'] as $error) {
          include "../Modules/error.php";
        }
        unset($_SESSION['errors_add']);
      }
      if(!empty($_SESSION['alertmessage'])) {
        include "../Modules/info.php";
        unset($_SESSION['alertmessage']);
      }
    ?>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStockModal">
      <i class='fa-solid fa-plus'></i><span class='ml-1'>Add a Stock Item</span>
    </button>
    <!-- Table -->
    <form method="POST">
      <table class="table mt-3 table-striped table-bordered">
        <thead class="thead-dark">
          <tr>
            <th scope='col'>ID</th>
            <th scope='col'>Name</th>
            <th scope='col'>Current Price</th>
            <th scope='col'>Quantity</th>
            <th scope='col'>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $db = Db::getInstance();
          $result = $db->getAll('stock');

          if (count($result->errors) > 0) {
            foreach ($result->errors as $error) {
              include "../Modules/error.php";
            }
          } else {
            while ($stock = $result->data->fetch()) {
              echo "<tr>";
              echo "<th scope='row'>" . $stock['id'] . "</th>";
              echo "<td>" . $stock['name'] . "</td>";
              echo "<td>" . $stock['current_price'] . "</td>";
              echo "<td>" . $stock['qty'] . "</td>";
              echo "<td><div class='btn-group' role='group'>";
              echo "<a href='stockbyid.php?stock_id=" . $stock['id'] . "&stock_name=" . $stock['name'] . "' class='btn btn-primary'>View/Edit</a>";
              echo "<input type='submit' name='del_stock_id_" . $stock['id'] . "' class='btn btn-danger' value='Delete' />";
              echo "</tr>";
              echo "</div>";
            }
          }
          ?>
        </tbody>
      </table>
    </form>

    <?php
    echo "<!-- Add Stock Modal -->";
    echo "<div class='modal fade' id='addStockModal' tabindex='-1' role='dialog' aria-labelledby='addStockModalLabel' aria-hidden='true'>";
    echo "<div class='modal-dialog' role='document'>";
    echo "<div class='modal-content'>";
    echo "<div class='modal-header'>";
    echo "<h5 class='modal-title' id='addStockModalLabel'>Add Stock Item</h5>";
    echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
    echo "<span aria-hidden='true'>&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<div class='modal-body'>";
    echo "<form method='POST'>";
    echo "<div class='form-group add-stock-modal'><label for='add_sto_name'>Name</label><input type='text' class='form-control' name='add_sto_name' /></div>";
    echo "<div class='form-group add-stock-modal'><label for='add_sto_price'>Price</label><input type='text' class='form-control' name='add_sto_price' /></div>";
    echo "<div class='form-group add-stock-modal'><label for='add_sto_qty'>Quantity</label><input type='text' class='form-control' name='add_sto_qty' /></div>";
    echo "</div>";
    echo "<hr'>";
    echo "<div class='modal-footer'>";
    echo "<div class='btn-group add-modal-footer mb-0'>";
    echo "<input type='submit' class='btn btn-primary' name='add_stock' value='Submit'>";
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