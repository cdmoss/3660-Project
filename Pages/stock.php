<!doctype html>
<html lang="en">
  <head>
  </head>
  <body>

    <!-- Sidebar -->
    <?php include "../Modules/sidebar.php" ?>

    <div class="container-fluid">
    <!-- Table -->
    <table class="table mt-5">
    <thead class="thead-dark">
      <tr> 
        <th>Name</th>
        <th>Current Price</th>
        <th>Quantity</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <!-- Data and Actions (View/Edit/Delete) -->
      <tr>
        <td>Weedwacker</td>
        <td>$50.00</td>
        <td>20</td>
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