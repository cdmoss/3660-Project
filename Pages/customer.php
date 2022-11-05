<?php include "../Modules/db.php" ?> 

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
          $stmt = $pdo->query('SELECT id, name, email, phone, address FROM CUSTOMERS');
          while ($row = $stmt->fetch()) {
            echo "<tr><td>" . $row['id'] . "</td><td>" . $row['name'] . "</td><td>" . $row['email'] . "</td><td>" . $row['phone'] . "</td><td>" . $row['address'] . "</td><td><button type='button' class='btn btn-primary'>View</button><button type='button' class='btn btn-secondary'>Edit</button><button type='button' class='btn btn-danger'>Delete</button></td></tr>";
          }
        ?>
      </tbody>
      </table>
    </div>

  </body>
</html>

<!-- Links and Scripts -->
<?php include "../Modules/linksandscripts.php" ?>
