<?php 
    $usertype = $_SESSION['usertype'];
    
?>
<div class="col-lg-2">
    <h1 class="my-4"></h1>
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <?php 
            if ($usertype === 'Employee' || $usertype === 'Admin') {
                ?>
                <a class="nav-link" id="v-pills-item-tab" data-toggle="pill" href="#v-pills-item" role="tab" aria-controls="v-pills-item" aria-selected="true"><i class='bx bx-package'></i> Item</a>
                <?php
            }   

            if ($usertype === 'Admin') {
                ?>
                <a class="nav-link" id="v-pills-vendor-tab" data-toggle="pill" href="#v-pills-vendor" role="tab" aria-controls="v-pills-vendor" aria-selected="false"><i class='bx bx-store' ></i> Suppliers</a>
                <a class="nav-link" id="v-pills-purchase-tab" data-toggle="pill" href="#v-pills-purchase" role="tab" aria-controls="v-pills-purchase" aria-selected="false"><i class='bx bx-cart-add' ></i> Restock</a>
                <?php
            }
        ?>
        <a class="nav-link" id="v-pills-sale-tab" data-toggle="pill" href="#v-pills-sale" role="tab" aria-controls="v-pills-sale" aria-selected="false"><i class='bx bx-receipt'></i> Order</a>
        <a class="nav-link" id="v-pills-customer-tab" data-toggle="pill" href="#v-pills-customer" role="tab" aria-controls="v-pills-customer" aria-selected="false"><i class='bx bx-group' ></i> Customers</a>
        <a class="nav-link" id="v-pills-search-tab" data-toggle="pill" href="#v-pills-search" role="tab" aria-controls="v-pills-search" aria-selected="false"><i class='bx bx-search-alt'></i> Records Hub</a>
        <a class="nav-link" id="v-pills-reports-tab" data-toggle="pill" href="#v-pills-reports" role="tab" aria-controls="v-pills-reports" aria-selected="false"><i class='bx bx-notepad'></i> Reports</a>
        <a class="nav-link active" id="v-pills-reports-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-reports" aria-selected="false"><i class='bx bx-user-circle' ></i> My Profile</a>
        <a class="nav-link nav-link-logout" href="model/login/logout.php"><i class='bx bx-log-out-circle'></i> <b>Logout</b></a>
    </div>
</div>