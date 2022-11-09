<?php include '../data/db.php' ?>

<?php 

function getTable($tableName) {
    $db = Db::getInstance();
    $result = $db->getAll($tableName);

    if (count($result->errors) > 0) {
        foreach ($result->errors as $error) {
            echo "$error";
        }
    }
    else {
        while ($row = $result->data->fetch()) {
            echo '<div class="row">';
            $tableValues = '';
            foreach ($row as $field) {
                $tableValues = $tableValues . "<span>" . $field . "</span>"; 
            }

            echo $tableValues;
            echo "</div>";
        }
    }
}

function getSingle($tableName, $id) {
    $db = Db::getInstance();
    $result = $db->getSingleById($tableName, $id);

    if (count($result->errors) > 0) {
        foreach ($result->errors as $error) {
            echo "$error";
        }
    }
    else {
        
        while ($row = $result->data->fetch()) {
            echo '<div class="row">';
            $tableValues = '';
            foreach ($row as $field) {
                $tableValues = $tableValues . "<span>" . $field . "<span>"; 
            }

            echo $tableValues;
            echo "</div>";
        }
    }
}

function _addCustomer($name, $email, $phone, $address) {
    $db = Db::getInstance();
    $result = $db->addCustomer($name, $email, $phone, $address);

    if (count($result->errors) > 0) {
        foreach ($result->errors as $error) {
            echo "$error";
        }
    }
    else {
        echo "Added Customer";
    }
}

function _editCustomer($id, $name, $email, $phone, $address) {
    $db = Db::getInstance();
    $result = $db->editCustomer($id, $name, $email, $phone, $address);

    if (count($result->errors) > 0) {
        foreach ($result->errors as $error) {
            echo "$error";
        }
    }
    else {
        echo "Edited Customer";
    }
}

function _deleteCustomer($id) {
    $db = Db::getInstance();
    $result = $db->deleteCustomer($id);

    if (count($result->errors) > 0) {
        foreach ($result->errors as $error) {
            echo "$error";
        }
    }
    else {
        echo "Deleted Customer";
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <style>
        form {
            display: flex;
            flex-direction: column;
        }

        input {
            width: 300px;
        }

        .container {
            margin: 50px;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .row span {
            margin-left: 5px;
            margin-right: 5px;
        }
    </style>
  </head>
  <body>
    <div class="container">
        <h5>Get all customers</h3>
        <?php
            getTable('customers');
        ?>
        <hr/>
        <h5>Get single</h3>
        <?php
            getSingle('customers', '100036586082664449');    
        ?>
        <hr/>
        <h5>Add customer</h5>
        <form id="add-customer" name="add-customer" action="test.php" method="post">
            <label for="name">name</label>
            <input type="text" name="name">
            <label for="name">email</label>
            <input type="text" name="email">
            <label for="name">phone</label>
            <input type="text" name="phone">
            <label for="name">address</label>
            <input type="text" name="address">
            <br>
            <input type="submit" style="margin-top: 20px;" name="add-customer-btn" value="add customer" />
        </form>
        <?php
        if (isset($_POST['add-customer-btn'])){
            _addCustomer($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address']);
        }
        ?>
        <hr/>
        <h5>Edit Customer</h5>
        <form id="edit-customer" name="edit-customer" action="test.php" method="post">
            <label for="id">id</label>
            <input type="text" name="id">
            <label for="name">name</label>
            <input type="text" name="name">
            <label for="name">email</label>
            <input type="text" name="email">
            <label for="name">phone</label>
            <input type="text" name="phone">
            <label for="name">address</label>
            <input type="text" name="address">
            <input type="submit" style="margin-top: 20px;" name="edit-customer-btn" value="edit customer" />
        </form>
        <?php
        if (isset($_POST['edit-customer-btn'])){
            _editCustomer($_POST['id'], $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address']);
        }
        ?>
        <hr/>
        <h5>Delete Customer</h5>
        <form id="delete-customer" name="delete-customer" action="test.php" method="post">
            <label for="id">id</label>
            <input type="text" name="id">
        </form>
        <?php
        if (isset($_POST['delete-customer-btn'])){
            _deleteCustomer($_POST['id']);
        }
        ?>
    </div>
  </body>
</html>

<?php include "../Modules/linksandscripts.php" ?>