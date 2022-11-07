<?php include "../data/db.php" ?> 

<!doctype html>
<html lang="en">
  <head>
  </head>
  <body id="page-top">

    <!-- Sidebar -->
    <?php include "../Modules/sidebar.php" ?>

    <div class="container-fluid">
      <!-- Table -->
      <form method="POST">
        <table class="table mt-5">
        <thead class="thead-dark">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $db = Db::getInstance();
            $result = $db->getAll('customers');

            if (count($result->errors) > 0) {
              foreach ($result->errors as $error) {
                echo "$error";
              }
            }
            else {
              while ($customer = $result->data->fetch()) {
                echo "<tr>";
                echo "<td>" . $customer['id'] ."</td>";
                echo "<td>" . $customer['name'] . "</td>";
                echo "<td>" . $customer['email'] . "</td>";
                echo "<td>" . $customer['phone'] . "</td>";
                echo "<td>" . $customer['address'] . "</td>";
                echo "<td><div class='btn-group' role='group'>";
                echo "<a href='customerbyid.php?cus_id=" . $customer['id'] . "&cus_name=" . $customer['name'] . "' class='btn btn-primary'>Edit</a>";
                echo "<a href='#' class='btn btn-danger'>Delete</a></td>";
                echo "</tr>";
                echo "</div>";
              }
            }
          ?>
        </tbody>
        </table>
      </form>
    </div>

  </body>
</html>

<?php include "../Modules/linksandscripts.php" ?>
