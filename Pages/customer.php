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
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Address</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Data and Actions (View/Edit/Delete) -->
        <tr>
          <td>John</td>
          <td>doe@hotmail.com</td>
          <td>4038765847</td>
          <td>31 Baker Lane</td>
          <td><button type="button" class="btn btn-primary">View</button>
          <button type="button" class="btn btn-secondary">Edit</button>
          <button type="button" class="btn btn-danger">Delete</button></td>
        </tr>
      </tbody>
      </table>
    </div>

  </body>
</html>

<!-- Bootstrap links -->
<?php include "../Modules/linksandscripts.php" ?>
