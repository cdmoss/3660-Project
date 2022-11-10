<?php include "../data/db.php" ?>

<?php 
    if(isset($_POST['del_stock'])) {
        $db = Db::getInstance();
        $result = $db->deleteStockItem($_GET['stock_id']);
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
        header('location: stock.php');
    }


    if(isset($_POST['edit_stock'])) {
        $db = Db::getInstance();
        $result = $db->editStockItem($_POST['stock_id'], $_POST['stock_name'], $_POST['stock_cur_price'], $_POST['stock_qty']);
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
        header('location: stockbyid.php?stock_id=' . $_POST['stock_id'] . '&stock_name=' . $_POST['stock_name'] .'');
    }

?>

<!-- Sidebar -->
<?php include "../Modules/sidebar.php" ?>

<?php 
$db = Db::getInstance();
$result = $db->getSingleById('stock', $_GET['stock_id']);

if (count($result->errors) > 0) {
    foreach ($result->errors as $error) {
        echo "$error";
    }
}
else {
    while ($stock = $result->data->fetch()) {
        echo "<div style='display:block;width:95%;margin-left:auto;margin-right:auto;'>";
        echo "<div class='card'>
        <div class='card-header' id='headingOne'>
          <h5 class='mb-0'>
            <button class='btn btn-link' data-toggle='' data-target='' aria-expanded='true' aria-controls='collapseOne'>
              Stock Item Information
            </button>
          </h5>
        </div>";
    
        echo "<div id='collapseOne' class='collapse show' aria-labelledby='headingOne'>";
        echo "<div class='card-body'>";
        echo "<form method='POST'>";
            echo "<div class='form-group inputById'><label for='stock_id'>Stock ID</label><input type='text' class='form-control' name='stock_id' value='" . $stock['id'] . "' readonly /></div>";
            echo "<div class='form-group inputById'><label for='stock_name'>Name</label><input type='text' class='form-control' name='stock_name' value='" . $stock['name'] . "' /></div>";
            echo "<div class='form-group inputById'><label for='stock_cur_price'>Current Price</label><input type='text' class='form-control' name='stock_cur_price' value='" . $stock['current_price'] . "' /></div>";
            echo "<div class='form-group inputById'><label for='stock_qty'>Quantity</label><input type='text' class='form-control' name='stock_qty' value='" . $stock['qty'] . "' /></div>";
            echo "<div class='btn-group inputById' role='group'>";
            echo "<input type='submit' name='edit_stock' class='btn btn-warning' value='Save Changes' />";
            echo "<input type='submit' name='del_stock' class='btn btn-danger' value='Delete' />";
            echo "<a href='stock.php' class='btn btn-primary'>Go Back</a>";
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