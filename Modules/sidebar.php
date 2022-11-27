<?php 
$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1); 
if (isset($_POST['logout'])) {
    $_SESSION['loggedin'] = NULL;
    $_SESSION['alertmessage'] = 'You have successfully logged out.';
    header('location: login.php');
}
?>
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
            <li class="nav-item <?= $page == 'customer.php' ? 'active' : '' ?>"><a class="nav-link" href="customer.php"><i class="fa-solid fa-user"></i>&nbsp;<span>Customers</span></a></li>

            <!-- Nav Item - Stock -->
            <li class="nav-item <?= $page == 'stock.php' ? 'active' : '' ?>"><a class="nav-link" href="stock.php"><i class="fa-solid fa-boxes-stacked "></i>&nbsp;<span>Stock</span></a></li>

            <!-- Nav Item - Invoice -->
            <li class="nav-item <?= $page == 'invoice.php' ? 'active' : '' ?>"><a class="nav-link" href="invoice.php"><i class="fa-solid fa-file-invoice-dollar"></i>&nbsp;<span>Invoices</span></a></li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

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
                                <span class="mr-1 mt-2 d-none d-lg-inline text-gray-600 small"><h6>Welcome, USER_NAME&nbsp;&nbsp;<i class="fa-solid fa-circle-user fa-lg"></i></h6></span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <form class="dropdown-menu dropdown-menu-right shadow animated--grow-in" method="POST">
                                <button class="dropdown-item" type="submit" name="logout">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
              </ul>
            </nav>
            <!-- End of Topbar -->
            