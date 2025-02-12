<?php
    session_start();
    // Redirect the user to login page if he is not logged in.
    if(!isset($_SESSION['loggedIn'])){
    	header('Location: index.php');
    	exit();
    }
    
    require_once('inc/config/constants.php');
    require_once('inc/config/db.php');
    require_once('inc/header.html');
?>
<body>
    <div id="loadingMessage" class="loading-message" style="display: none;">
      <div class="spinner"></div>
      <p>Please wait, processing...</p>
    </div>
    <?php
        require 'inc/navigation.php';
    ?>
    <!-- Page Content -->
    <div class="container-fluid">
        <div class="row">
            <?php
                require 'inc/navbar.php';
            ?>
            <div class="col-lg-10">
                <!-- ===== START OF TAB PANEL =====  -->
                <div class="tab-content" id="v-pills-tabContent">
                    <!-- ===== START OF ITEMS TAB PANEL =====  -->
                    <?php
                        if ($usertype === 'Employee' || $usertype === 'Admin') {
                            include 'inc/Pages/Item.php';
                        }
                    ?>
                    <!-- ===== END OF ITEMS TAB PANEL =====  -->

                    <!-- ===== START OF RESTOCK TAB PANEL =====  -->
                    <?php
                        if ($usertype === 'Admin') {
                            include 'inc/Pages/Restock.php';
                        }
                    ?>
                    <!-- ===== END OF RESTOCK TAB PANEL =====  -->
                    
                    <!-- ===== START OF SUPPLIERS TAB PANEL =====  -->
                    <?php
                        if ($usertype === 'Admin') {
                            include 'inc/Pages/Supplier.php';
                        }
                    ?>
                    <!-- ===== END OF SUPPLIERS TAB PANEL =====  -->
                    
                    <!-- ===== START OF ORDERS TAB PANEL =====  -->
                    <div class="tab-pane fade" id="v-pills-sale" role="tabpanel" aria-labelledby="v-pills-sale-tab">
                        <div class="card card-outline-secondary my-4">
                            <div class="card-header">Order</div>
                            <div class="card-body">
                                
                                <div id="saleDetailsMessage"></div>
                                <div id="" class="container-fluid tab-pane active">
                                    <h5>Add Item to Order</h5>
                                    <p>Use the grid below to search all items</p>
                                    <div class="table-responsive" id="itemSearchItemTableDiv"></div>
                                </div>
                                <br>

                                <div id="orders" class="container-fluid">
                                    <h5>Orders</h5>
                                    <table id="itemSearchTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="all-items">
                                            <!-- Items will be dynamically added here -->
                                            <tfoot>
                                                <tr>
                                                    <th colspan="2" style="text-align: right;">Total Price:</th>
                                                    <th id="final-total">0.00</th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </tbody>
                                    </table>
                                </div>

                                <form>
                                    <h5>Order Details</h5>
                                    <div class="form-row">
                                        <!-- <div class="form-group col-md-3">
                                            <label for="saleDetailsItemNumber">Item Number<span class="requiredIcon">*</span></label>
                                            <input type="text" class="form-control" id="saleDetailsItemNumber" name="saleDetailsItemNumber" autocomplete="off">
                                            <div id="saleDetailsItemNumberSuggestionsDiv" class="customListDivWidth"></div>
                                        </div> -->
                                        <div class="form-group col-md-3">
                                            <label for="saleDetailsCustomerID">Customer ID<span class="requiredIcon">*</span></label>
                                            <input type="text" class="form-control" id="saleDetailsCustomerID" name="saleDetailsCustomerID" autocomplete="off">
                                            <div id="saleDetailsCustomerIDSuggestionsDiv" class="customListDivWidth"></div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="saleDetailsCustomerName">Customer Name</label>
                                            <input type="text" class="form-control" id="saleDetailsCustomerName" name="saleDetailsCustomerName" readonly>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="saleDetailsSaleID">Order ID <small>Auto Generated</small></label>
                                            <input readonly type="text" class="form-control invTooltip" id="saleDetailsSaleID" name="saleDetailsSaleID" title="This will be auto-generated when you add a new record" autocomplete="off">
                                            <div id="saleDetailsSaleIDSuggestionsDiv" class="customListDivWidth"></div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <!-- <div class="form-group col-md-5">
                                            <label for="saleDetailsItemName">Item Name</label>
                                            <input type="text" class="form-control invTooltip" id="saleDetailsItemName" name="saleDetailsItemName" readonly title="This will be auto-filled when you enter the item number above">
                                        </div> -->
                                        <div class="form-group col-md-3">
                                            <label for="saleDetailsSaleDate">Order Date<span class="requiredIcon">*</span></label>
                                            <input type="text" class="form-control datepicker" id="saleDetailsSaleDate" value="2024-11-06" name="saleDetailsSaleDate" readonly>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="saleDetailsDiscount">Discount Code</label>
                                            <input type="text" class="form-control" id="saleDetailsDiscount" name="saleDetailsDiscount" value="">
                                        </div>
                                        <!-- <div class="form-group col-md-3">
                                            <label for="saleDetailsItemStatus">Status</label>
                                            <select class="form-control chosenSelect" name="saleDetailsItemStatus" id="saleDetailsItemStatus" autocomplete="off">
                                                <option value="To Deliver">Out of stock</option>
                                                <option value="Delivered">Delivered</option>
                                            </select>
                                        </div> -->
                                    </div>
                                    <div class="form-row">
                                        <!-- <div class="form-group col-md-2">
                                            <label for="saleDetailsTotalStock">Total Stock</label>
                                            <input type="text" class="form-control" name="saleDetailsTotalStock" id="saleDetailsTotalStock" readonly>
                                        </div> -->
                                        <!-- <div class="form-group col-md-2">
                                            <label for="saleDetailsQuantity">All Products Quantity<span class="requiredIcon">*</span></label>
                                            <input type="number" class="form-control" id="saleDetailsQuantity" name="saleDetailsQuantity" value="0">
                                        </div> -->
                                        <!-- <div class="form-group col-md-2">
                                            <label for="saleDetailsUnitPrice">Unit Price<span class="requiredIcon">*</span></label>
                                            <input type="text" class="form-control" id="saleDetailsUnitPrice" name="saleDetailsUnitPrice" value="0">
                                        </div> -->
                                        <!-- <div class="form-group col-md-3">
                                            <label for="saleDetailsTotal">Total</label>
                                            <input type="text" class="form-control" id="saleDetailsTotal" name="saleDetailsTotal">
                                        </div> -->
                                        <!-- <div class="form-group col-md-3">
                                            <label for="saleDetailsTotal">Cash</label>
                                            <select class="form-control" name="saleDetailsCash" id="saleDetailsCash">
                                                <option value="Cash Payment">Cash Payment</option>
                                                <option value="Online Payment">Onlne Payment</option>
                                            </select>
                                        </div> -->
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <div id="saleDetailsImageContainer"></div>
                                        </div>
                                    </div>
                                    <button type="button" id="addOrderButton" class="btn btn-success">Add Order</button>
                                    <!-- <button type="button" id="updateSaleDetailsButton" class="btn btn-primary">Update</button> -->
                                    <button type="reset" id="saleClear" class="btn">Clear</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- ===== END OF ORDERS TAB PANEL =====  -->
                    
                    <!-- ===== START OF CUSTOMERS TAB PANEL =====  -->
                    <div class="tab-pane fade" id="v-pills-customer" role="tabpanel" aria-labelledby="v-pills-customer-tab">
                        <div class="card card-outline-secondary my-4">
                            <div class="card-header">Customer Details</div>
                            <div class="card-body">
                                <!-- Div to show the ajax message from validations/db submission -->
                                <div id="customerDetailsMessage"></div>
                                <form>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="customerDetailsCustomerFullName">Full Name<span class="requiredIcon">*</span></label>
                                            <input type="text" class="form-control" id="customerDetailsCustomerFullName" name="customerDetailsCustomerFullName">
                                        </div>
                                        <!-- <div class="form-group col-md-2">
                                            <label for="customerDetailsStatus">Status</label>
                                            <select id="customerDetailsStatus" name="customerDetailsStatus" class="form-control chosenSelect">
                                            <?php //include('inc/statusList.html'); ?>
                                            </select>
                                        </div> -->
                                        <div class="form-group col-md-3">
                                            <label for="customerDetailsCustomerID">Customer ID <small>Auto Generated</small></label>
                                            <input type="text" class="form-control invTooltip" id="customerDetailsCustomerID" name="customerDetailsCustomerID" title="This will be auto-generated when you add a new customer" autocomplete="off" readonly>
                                            <div id="customerDetailsCustomerIDSuggestionsDiv" class="customListDivWidth"></div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="customerDetailsCustomerMobile">Primary Phone No.<span class="requiredIcon">*</span></label>
                                            <input type="text" class="form-control invTooltip" id="customerDetailsCustomerMobile" name="customerDetailsCustomerMobile" title="Format: 09xxxxxxxxx">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="customerDetailsCustomerPhone2">Secondary Phone No.</label>
                                            <input type="text" class="form-control invTooltip" id="customerDetailsCustomerPhone2" name="customerDetailsCustomerPhone2" title="Format: 09xxxxxxxxx">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="customerDetailsCustomerEmail">Email</label>
                                            <input type="email" class="form-control" id="customerDetailsCustomerEmail" name="customerDetailsCustomerEmail">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="customerDetailsCustomerAddress">Permanent Address<span class="requiredIcon">*</span></label>
                                        <input type="text" class="form-control" id="customerDetailsCustomerAddress" name="customerDetailsCustomerAddress">
                                    </div>
                                    <div class="form-group">
                                        <label for="customerDetailsCustomerAddress2">Temporary Address</label>
                                        <input type="text" class="form-control" id="customerDetailsCustomerAddress2" name="customerDetailsCustomerAddress2">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="customerDetailsCustomerCity">City</label>
                                            <input type="text" class="form-control" id="customerDetailsCustomerCity" name="customerDetailsCustomerCity">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="customerDetailsCustomerDistrict">District</label>
                                            <select id="customerDetailsCustomerDistrict" name="customerDetailsCustomerDistrict" class="form-control chosenSelect">
                                            <?php include('inc/districtList.html'); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="button" id="addCustomer" name="addCustomer" class="btn btn-success">Add Customer</button>
                                    <!-- <button type="button" id="updateCustomerDetailsButton" class="btn btn-primary">Update</button>
                                    <button type="button" id="deleteCustomerButton" class="btn btn-danger">Delete</button> -->
                                    <button type="reset" class="btn">Clear</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- ===== END OF CUSTOMERS TAB PANEL =====  -->
                    
                    <!-- ===== START OF SEARCH TAB PANEL =====  -->
                    <div class="tab-pane fade" id="v-pills-search" role="tabpanel" aria-labelledby="v-pills-search-tab">
                        <div class="card card-outline-secondary my-4">
                            <div class="card-header">Records Hub<button id="searchTablesRefresh" name="searchTablesRefresh" class="btn btn-warning float-right btn-sm">Refresh</button></div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" role="tablist">
                                <?php 
                                    if ($usertype === 'Admin') {
                                        ?>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#usersSearchTab">Accounts</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#purchaseSearchTab">Restock</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#auditSearchTab">Audit</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#vendorSearchTab">Supplier</a>
                                        </li>
                                        <?php
                                    } else if ($usertype === 'Employee' || $usertype === 'Admin') {
                                        ?>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#vendorSearchTab">Supplier</a>
                                        </li>
                                        <?php
                                    }
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#itemSearchTab">Item</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#customerSearchTab">Customer</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#saleSearchTab">Order</a>
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <?php 
                                
                                // Query to count all items with zero stock
                                $itemDetailsSearchSql = 'SELECT COUNT(*) AS zeroStockCount FROM item WHERE stock = 0';
                                $itemDetailsSearchStatement = $conn->prepare($itemDetailsSearchSql);
                                $itemDetailsSearchStatement->execute();

                                // Fetch the result
                                $result = $itemDetailsSearchStatement->fetch(PDO::FETCH_ASSOC);

                                // Get the count of items with zero stock
                                $zeroStockCount = $result['zeroStockCount'];

                                ?>
                                <div class="tab-content">
                                    <div id="itemSearchTab" class="container-fluid tab-pane active">
                                        <br>
                                        <p>Use the grid below to search all details of items</p>
                                        <p style="color: red; font-weight: bold;">Warning: <?php echo $zeroStockCount; ?> <?php echo $zeroStockCount > 1 ? 'items' : 'item' ?> are out of stock</p>
                                        <!-- <a href="#" class="itemDetailsHover" data-toggle="popover" id="10">wwwee</a> -->
                                        <div class="table-responsive" id="itemDetailsTableDiv"></div>
                                    </div>
                                    <div id="customerSearchTab" class="container-fluid tab-pane fade">
                                        <br>
                                        <p>Use the grid below to search all details of customers</p>
                                        <div class="table-responsive" id="customerDetailsTableDiv"></div>
                                    </div>
                                    <div id="saleSearchTab" class="container-fluid tab-pane fade">
                                        <br>
                                        <p>Use the grid below to search all sale details</p>
                                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                        <script type="text/javascript">
                                            <?php 
                                                    $saleDetailsSearchSql = '
                                                     SELECT oi.itemNumber, SUM(oi.quantity) AS totalQuantity
                                                    FROM order_items oi
                                                    INNER JOIN sale s ON oi.saleID = s.saleID
                                                    WHERE MONTH(s.saleDate) = MONTH(CURRENT_DATE())
                                                    AND YEAR(s.saleDate) = YEAR(CURRENT_DATE())
                                                    GROUP BY oi.itemNumber
                                                    ORDER BY totalQuantity DESC
                                                    ';
                                                    $saleDetailsSearchStatement = $conn->prepare($saleDetailsSearchSql);
                                                    $saleDetailsSearchStatement->execute();
                                                    $salesData = [];
                                                    while($row = $saleDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)) {
                                                        $salesData[] = [$row['itemNumber'], (int)$row['totalQuantity']];
                                                    }
                                                    
                                                    // Convert PHP array to JSON
                                                    $jsonData = json_encode($salesData);
                                                
                                                ?>
                                                google.charts.load('current', {'packages':['corechart']});
                                                google.charts.setOnLoadCallback(drawChart);
                                            
                                                var salesData = <?php echo $jsonData;
                                            ?>;
                                                function drawChart() {
                                            
                                                var data = google.visualization.arrayToDataTable([
                                                    ['Product Name', 'Product Sold'],
                                                    ...salesData // Spread the array data
                                                ]);
                                            
                                                var options = {
                                                    title: 'Most Purchased Products Of The Month',
                                                    is3D: true,
                                                    legend: {
                                                                                position: 'right', 
                                                                                textStyle: {color: 'black', 
                                                                                fontSize: 10}
                                                                        }
                                                };
                                            
                                                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                                            
                                                chart.draw(data, options);
                                            }
                                        </script>
                                        <div style="width: 1000px">
                                            <div id="piechart" style="min-width: 100%; height: 200px;"></div>
                                        </div>
                                        <div class="table-responsive" id="saleDetailsTableDiv"></div>
                                    </div>
                                    <div id="purchaseSearchTab" class="container-fluid tab-pane fade">
                                        <br>
                                        <p>Use the grid below to search purchase details</p>
                                        <div class="table-responsive" id="purchaseDetailsTableDiv"></div>
                                    </div>
                                    <div id="vendorSearchTab" class="container-fluid tab-pane fade">
                                        <br>
                                        <p>Use the grid below to search suppliers details</p>
                                        <div class="table-responsive" id="vendorDetailsTableDiv"></div>
                                    </div>
                                    <div id="auditSearchTab" class="container-fluid tab-pane fade">
                                        <br>
                                        <p>Use the grid below to search Audit Logs details</p>
                                        <div class="table-responsive" id="auditDetailsTableDiv"></div>
                                    </div>
                                    <div id="usersSearchTab" class="container-fluid tab-pane fade">
                                        <br>
                                        <p>Use the grid below to search Account's details</p>
                                        <div class="table-responsive" id="usersDetailsTableDiv"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ===== END OF SEARCH TAB PANEL =====  -->
                    
                    <!-- ===== START OF REPORTS TAB PANEL =====  -->
                    <div class="tab-pane fade" id="v-pills-reports" role="tabpanel" aria-labelledby="v-pills-reports-tab">
                        <div class="card card-outline-secondary my-4">
                            <div class="card-header">Reports<button id="reportsTablesRefresh" name="reportsTablesRefresh" class="btn btn-warning float-right btn-sm">Refresh</button></div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" role="tablist">
                                <?php 
                                    if ($usertype === 'Admin') {
                                        ?>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#purchaseReportsTab">Restock</a>
                                        </li>
                                        <?php
                                    } else if ($usertype === 'Employee' || $usertype === 'Admin') {
                                        ?>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#vendorReportsTab">Supplier</a>
                                        </li>
                                        <?php
                                    } 
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#itemReportsTab">Item</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#customerReportsTab">Customer</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#saleReportsTab">Order</a>
                                    </li>
                                </ul>
                                <!-- Tab panes for reports sections -->
                                <div class="tab-content">
                                    <div id="itemReportsTab" class="container-fluid tab-pane active">
                                        <br>
                                        <p>Use the grid below to get reports for items</p>
                                        <div class="table-responsive" id="itemReportsTableDiv"></div>
                                    </div>
                                    <div id="customerReportsTab" class="container-fluid tab-pane fade">
                                        <br>
                                        <p>Use the grid below to get reports for customers</p>
                                        <div class="table-responsive" id="customerReportsTableDiv"></div>
                                    </div>
                                    <div id="saleReportsTab" class="container-fluid tab-pane fade">
                                        <br>
                                        <!-- <p>Use the grid below to get reports for sales</p> -->
                                        <form>
                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label for="saleReportStartDate">Start Date</label>
                                                    <input type="text" class="form-control datepicker" id="saleReportStartDate" value="2024-11-06" name="saleReportStartDate" readonly>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="saleReportEndDate">End Date</label>
                                                    <input type="text" class="form-control datepicker" id="saleReportEndDate" value="2024-11-06" name="saleReportEndDate" readonly>
                                                </div>
                                            </div>
                                            <button type="button" id="showSaleReport" class="btn btn-report">Show Report</button>
                                            <button type="reset" id="saleFilterClear" class="btn">Clear</button>
                                        </form>
                                        <br><br>
                                        <div class="table-responsive" id="saleReportsTableDiv"></div>
                                    </div>
                                    <div id="purchaseReportsTab" class="container-fluid tab-pane fade">
                                        <br>
                                        <!-- <p>Use the grid below to get reports for purchases</p> -->
                                        <form>
                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label for="purchaseReportStartDate">Start Date</label>
                                                    <input type="text" class="form-control datepicker" id="purchaseReportStartDate" value="2024-11-06" name="purchaseReportStartDate" readonly>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="purchaseReportEndDate">End Date</label>
                                                    <input type="text" class="form-control datepicker" id="purchaseReportEndDate" value="2024-11-06" name="purchaseReportEndDate" readonly>
                                                </div>
                                            </div>
                                            <button type="button" id="showPurchaseReport" class="btn btn-report">Show Report</button>
                                            <button type="reset" id="purchaseFilterClear" class="btn">Clear</button>
                                        </form>
                                        <br><br>
                                        <div class="table-responsive" id="purchaseReportsTableDiv"></div>
                                    </div>
                                    <div id="vendorReportsTab" class="container-fluid tab-pane fade">
                                        <br>
                                        <p>Use the grid below to get reports for users</p>
                                        <div class="table-responsive" id="vendorReportsTableDiv"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ===== END OF REPORTS TAB PANEL =====  -->
                    
                    <!-- ===== START OF PROFILE TAB PANEL =====  -->
                    <?php 
                        require 'inc/profile.php'; 
                    ?>
                    <!-- ===== END OF PROFILE TAB PANEL =====  -->
                </div>
            </div>
        </div>
    </div>
    <!-- ===== END OF RESTOCK TAB PANEL =====  -->
    
    <!-- ===== START OF SUPPLIERS TAB PANEL =====  -->
    <?php
        require 'inc/footer.php';
    ?>
</body>
</html>