<!doctype html>
<html lang="en">
  <head>
  </head>
  <body>

    <!-- Navbar -->
    <?php include "../Modules/navbar.php" ?>

    <!-- Table -->
    <table class="table mt-5">
    <thead class="thead-dark">
      <tr> 
        <th>Label</th>
        <th>Date</th>
        <th>Created</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <!-- Data and Actions (View/Edit/Delete) -->
      <tr>
        <td>Example data</td>
        <td>11/03/22</td>
        <td>Example data</td>
        <td><button type="button" class="btn btn-primary">View</button>
        <button type="button" class="btn btn-secondary">Edit</button>
        <button type="button" class="btn btn-danger">Delete</button></td>
      </tr>
    </tbody>
    </table>

  </body>
</html>

<!-- Bootstrap links -->
<?php include "../Modules/bootstrap.php" ?>
