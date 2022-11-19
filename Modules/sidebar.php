<?php $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1); ?>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark" id="Sidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="customer.php">
                <div class="sidebar-brand-icon" style="margin-top: 45px;">
                    <img src="../images/logowhite.png" width="160" height="120">
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider mt-5">

            <!-- Heading -->
            <div class="sidebar-heading mt-2">
                Pages
            </div>

            <!-- Nav Item - Customer -->
            <li class="nav-item ml-2 <?= $page == 'customer.php' ? 'active' : '' ?>"><a class="nav-link" href="customer.php"><i class="fa-solid fa-user fa-lg"></i><span class="ml-2">Customers</span></a></li>

            <!-- Nav Item - Stock -->
            <li class="nav-item ml-2 <?= $page == 'stock.php' ? 'active' : '' ?>"><a class="nav-link" href="stock.php"><i class="fa-solid fa-boxes-stacked"></i><span class="ml-2">Stock</span></a></li>

            <!-- Nav Item - Invoice -->
            <li class="nav-item ml-2 <?= $page == 'invoice.php' ? 'active' : '' ?>"><a class="nav-link" href="invoice.php"><i class="fa-solid fa-file-invoice-dollar"></i><span class="ml-2">Invoices</span></a></li>

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
              <?= $page == 'customerbyid.php' ? "<b><a href='customer.php'>Customer Information</a> / Customer Name: " . $_GET['cus_name'] . " - ID: #" . $_GET['cus_id'] . "</b>" : '' ?>
              <?= $page == 'stock.php' ? "<b>Stock Items</b>" : '' ?>
              <?= $page == 'stockbyid.php' ? "<b><a href='stock.php'>Stock Items</a> / Item Name: " . $_GET['stock_name'] . " - Item ID: #" . $_GET['stock_id'] . "</b>" : '' ?>
              <?= $page == 'invoice.php' ? "<b>Invoices</b>" : '' ?>
              <?= $page == 'invoicebyid.php' ? "<b><a href='invoice.php'>Invoices</a> / Invoice ID: #" . $_GET['invoice_id'] . "</b>" : '' ?>
              <?= $page == 'lineitembyid.php' ? "<b><a href='invoice.php'>Invoices</a></b><b><span>&nbsp;/&nbsp;</span></b><b><a href='invoicebyid.php?invoice_id=" . $_GET['invoice_id'] . "'>Invoice ID: #" . $_GET['invoice_id'] . "</b></a><span><b>&nbsp;/ Stock ID: #" . $_GET['stock_id'] . "&nbsp;&amp;&nbsp;Invoice ID: #" . $_GET['invoice_id'] . "</b></span>" : '' ?>

              <ul class="navbar-nav ml-auto">
              <li class="nav-item dropdown no-arrow mx-auto my-0">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><i class="fa-solid fa-user fa-lg"></i>&nbsp;Welcome, USER_NAME</span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
              </ul>
            </nav>
            <!-- End of Topbar -->
            