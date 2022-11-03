<?php $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1); ?>

<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">Group 2's Computer Repair Store</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item"><a class="nav-link <?= $page == 'index.php' ? 'active' : '' ?>" href="index.php">Home</a></li>
      <li class="nav-item"><a class="nav-link <?= $page == 'customer.php' ? 'active' : '' ?>" href="customer.php">Customer</a></li>
      <li class="nav-item"><a class="nav-link <?= $page == 'stock.php' ? 'active' : '' ?>" href="stock.php">Stock</a></li>
      <li class="nav-item"><a class="nav-link <?= $page == 'invoice.php' ? 'active' : '' ?>" href="invoice.php">Invoice</a></li>
    </ul>
  </div>
</nav>
