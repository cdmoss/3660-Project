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
            $tableValues = '';
            foreach ($row as $field) {
                $tableValues = $tableValues . "<tr><td>" . $field . "<tr><td>"; 
            }

            echo $tableValues;
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
            $tableValues = '';
            foreach ($row as $field) {
                $tableValues = $tableValues . "<tr><td>" . $field . "<tr><td>"; 
            }

            echo $tableValues;
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
?>

<!doctype html>
<html lang="en">
  <head>
    <style>
        form#add-customer {
            display: flex;
            flex-direction: column;
        }

        input {
            width: 300px;
        }

    </style>
  </head>
  <body>

    <h5>Get all</h3>
    <?php
        getTable('customers');
    ?>

    <h5>Get single</h3>
    <?php
        getSingle('customers', '100036586082664448');    
    ?>

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
        <input type="submit" name="add-customer-btn" value="add-customer-button" />
    </form>
    <?php
    if (isset($_POST['add-customer-btn'])){
        _addCustomer($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address'],);
    }
    ?>
  </body>
</html>

<?php include "../Modules/linksandscripts.php" ?>