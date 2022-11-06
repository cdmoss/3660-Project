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
              echo "<tr><td>" . $customer['id'] . "</td><td>" . $customer['name'] . "</td><td>" . $customer['email'] . "</td><td>" . $customer['phone'] . "</td><td>" . $customer['address'] . "</td><td><button type='button' class='btn btn-primary'>View</button><button type='button' class='btn btn-secondary'>Edit</button><button type='button' class='btn btn-danger'>Delete</button></td></tr>";
            }
          }
        ?>
      </tbody>
      </table>
    </div>

  </body>
</html>

<?php include "../Modules/linksandscripts.php" ?>
