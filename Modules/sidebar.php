<?php $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1); ?>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark" id="Sidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-text mx-3">GROUP <sup>2</sup> COMPUTER REPAIR</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Home -->
            <li class="nav-item <?= $page == 'index.php' ? 'active' : '' ?>"><a class="nav-link" href="index.php"><i class="fa-solid fa-house"></i><span class="ml-1">Home</span></a></li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Pages
            </div>

            <!-- Nav Item - Customer -->
            <li class="nav-item <?= $page == 'customer.php' ? 'active' : '' ?>"><a class="nav-link" href="customer.php"><i class="fa-solid fa-user"></i><span class="ml-1">Customer</span></a></li>

            <!-- Nav Item - Stock -->
            <li class="nav-item <?= $page == 'stock.php' ? 'active' : '' ?>"><a class="nav-link" href="stock.php"><i class="fa-solid fa-boxes-stacked"></i><span class="ml-1">Stock</span></a></li>

            <!-- Nav Item - Invoice -->
            <li class="nav-item <?= $page == 'invoice.php' ? 'active' : '' ?>"><a class="nav-link" href="invoice.php"><i class="fa-solid fa-file-invoice-dollar"></i><span class="ml-1">Invoice</span></a></li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
              <?= $page == 'index.php' ? "<b>Home</b>" : '' ?>
              <?= $page == 'customer.php' ? "<b>Customer Information</b>" : '' ?>
              <?= $page == 'stock.php' ? "<b>Stock Items</b>" : '' ?>
              <?= $page == 'invoice.php' ? "<b>Invoices</b>" : '' ?>
            </nav>
            <!-- End of Topbar -->
            