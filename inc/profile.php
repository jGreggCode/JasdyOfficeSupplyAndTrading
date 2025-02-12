<?php
    require_once('checkApprovals.php');
    require_once('./inc/config/constants.php');
    require_once('./inc/config/db.php');

    $topSeller = null;
    $totalProduct = null;
    $totalSales = null;
    // Query to find the top seller with the most products sold and their total sales
    $topSellerSql = "
    SELECT 
        u.fullName AS sellerName,
        u.userID AS sellerID,
        SUM(oi.quantity) AS totalProductsSold,
        SUM(oi.quantity * oi.unitPrice) AS totalSalesValue
    FROM 
        User u
    INNER JOIN 
        sale s ON u.userID = s.sellerID
    INNER JOIN 
        order_items oi ON s.saleID = oi.saleID
    GROUP BY 
        u.userID
    ORDER BY 
        totalProductsSold DESC
    LIMIT 1";

    $topSellerStatement = $conn->prepare($topSellerSql);
    $topSellerStatement->execute();

    // Fetch the result
    $topSeller = $topSellerStatement->fetch(PDO::FETCH_ASSOC);

    if ($topSeller) {
        $totalSales = number_format($topSeller['totalSalesValue'], 2);
        $totalProduct = $topSeller['totalProductsSold'];
        $topSellerName = $topSeller['sellerName'];
    } else {
        $topSellerName = "No sales data found.";
    }
?>
<!-- Profile -->
<div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-reports-tab">
    <div class="card card-outline-secondary my-4">
        <div class="card-header">PROFILE
            <button onclick="location.href='model/users/update.php?id=<?php echo $_SESSION['userid']; ?>&ACTION=EDIT'" type="button" data-mdb-button-init data-mdb-ripple-init class="btn float-right btn-sm btn-edit-profile">
            <i class='bx bx-edit'></i> Edit Profile</button>
            <button id="reloadDataBtn" class="btn float-right btn-sm btn-edit-profile btn-warning" style="margin-right: .5rem;">Reload</button>
        </div>
            <div class="card-body">
                <!-- START HERE -->
                <h5 class="profile-heading">INSIGHTS <span class="heading-arrow">></span></h5>
                <div class="insights">
                    <div class="sales">
                        <span class="material-icons-sharp">point_of_sale</span>
                        <div class="middle">
                            <div class="lef">
                                <h5>Your Total Sales</h5>
                                <h5 id="profileSales" class="text-muted">PHP <?php echo $_SESSION['sales']; ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="income">
                        <span class="material-icons-sharp">data_thresholding</span>
                        <div class="middle">
                            <div class="lef">
                                <h5>Your Total Sold</h5>
                                <h5 id="profileSold" class="text-muted"><?php echo $_SESSION['sold'] ?? 0; ?> product/s</h5>
                            </div>
                        </div>
                    </div>
                    <div class="sales">
                        <span class="material-icons-sharp">analytics</span>
                        <div class="middle">
                            <div class="lef">
                                <h5>JOST Total Sales</h5>
                                <h5 id="profileCompanySales" class="text-muted">PHP <?php echo $_SESSION['companysales']; ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="sales">
                        <span class="material-icons-sharp">stacked_line_chart</span>
                        <div class="middle">
                            <div class="lef">
                                <h5>JOST Total Customer</h5>
                                <h5 id="profileCompanyCustomers" class="text-muted"><?php echo $_SESSION['customers']; ?></h5>
                            </div>
                        </div>
                    </div>
                    <?php 
                        if ($_SESSION['usertype'] === 'Admin') {
                            ?>
                            <div class="expenses">
                                <span class="material-icons-sharp">bar_chart</span>
                                <div class="middle">
                                    <div class="lef">
                                        <h5>JOST Total Expense</h5>
                                        <h5 id="profileCompanyExpense" class="text-muted">PHP <?php echo $_SESSION['companyexpense'] ?? 0; ?></h5>
                                    </div>
                                </div>
                            </div> <?php
                        }
                        if ($_SESSION['usertype'] === 'Admin') {
                            ?>
                            <div class="income">
                                <span class="material-icons-sharp">workspace_premium</span>
                                <div class="middle">
                                    <div class="lef">
                                        <h5>Top Seller</h5>
                                        <h5 id="profileCompanyExpense" class="text-muted"><p><?php echo $topSellerName; ?></p><small style="margin-top: -.8rem; color: green"> with <?php echo $totalProduct; ?> product/s sold and PHP <?php echo $totalSales; ?> total sales</small></h5>
                                    </div>
                                </div>
                            </div> <?php
                        }
                    ?>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <h5 class="my-3" style="max-width: 400px; margin: 0 auto;">
                                <?php echo ucwords($_SESSION['fullName']); ?><span class="material-icons-sharp material-icons-sharp-user" style="font-size: .9rem;">verified</span> <small><?php echo '(UID: ' . $_SESSION['userid'] . ')';?></small>
                                </h5>
                                <p class="text-muted mb-1"><?php echo strtoupper($_SESSION['usertype']); ?></p>
                                <p class="text-muted mb-1" style="font-size: .7rem;">
                                    Account Status: <?php echo $_SESSION['status']; ?>
                                </p>
                            </div>
                        </div>
                        <div class="card mb-4 pb-5">
                            <div class="card-body text-left">
                                <h5 class="my-3">JOST Profile</h5>
                                <p class="text-muted text-center">Jasdy Office Supplies Trading aim is to provide you with products at reasonable prices, so that you can stock up on necessary supplies without breaking the bank. <hr></p>
                                <p class="text-muted mb-1">Facebook <span class="heading-arrow">></span> <a href="https://www.facebook.com/jasdyOStrading/"><small>Jasdy Office Supplies Trading </small></a></p>
                                <p class="text-muted mb-1">Contact <span class="heading-arrow">></span> +63 906 236 4630</p>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Full Name</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo ucwords($_SESSION['fullName']); ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Email</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $_SESSION['email']; ?></p>
                                    </div>
                                </div>	
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Phone No</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo ucwords($_SESSION['mobile']); ?></p>
                                    </div>
                                </div>	
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Location</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo ucwords($_SESSION['location']); ?></p>
                                    </div>
                                </div>	
                                <?php 
                                    if ($usertype === 'Admin') {
                                        ?>
                                        <hr style="background-color: var(--color-primary);">
                                        <div class="row">
                                            
                                            <div class="col-sm-3">
                                                <p class="mb-0">Pending Reseller Approval</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0"><?php echo $totalDisabledUsersReseller; ?></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Pending Employee Approval</p>
                                            </div>
                                            <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $totalDisabledUsersEmployee; ?></p>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                ?>

                                <?php
                                    if ($usertype === 'Admin') {
                                        ?>
                                        <div class="row">
                                            <div class="col-sm-6 mt-2">
                                                <p class="text-muted mb-0" style="font-size: .8rem;">| Go to <b>Search/Track</b> <span class="heading-arrow">></span> <b>Accounts</b> to approve accounts</p>
                                            </div>  
                                        </div>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
<!-- Profile -->