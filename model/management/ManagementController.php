<?php
	require_once 'Management.php';
	require_once '../audit/insertAudit.php';

    // Handle AJAX request

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profileSold'])) {
        $profileSold = $_POST['profileSold'];
        $profileSales = $_POST['profileSold'];
        $profileCompanySales = $_POST['profileCompanySales'];
        $profileCompanyCustomers = $_POST['profileCompanyCustomers'];
        $profileCompanyExpense = $_POST['profileCompanyExpense'];
        // Initialize your database connection
        $db = $conn; 

        $management = new Management($db);
        $response = $management->refreshData($profileSold, $profileSales, $profileCompanySales, $profileCompanyCustomers, $profileCompanyExpense);

        // Return JSON response
        echo json_encode($response);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteUsingItemID'])) {
        $productID = intval($_POST['deleteUsingItemID']);

        // Initialize your database connection
        $db = $conn; 

        $management = new Management($db);
        $response = $management->itemDelete($productID);

		insertAudit('Account: ' . '(' . $_SESSION['userid'] . ')' . ' Deleted Item ' . $productID);

        // Return JSON response
        echo json_encode($response);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateUsingProductID'])) {
        $productID = intval($_POST['updateUsingProductID']);
        $itemName = $_POST['updateUsingItemName'];
        $itemNumber = $_POST['updateUsingItemNumber'];
        $itemCategory = $_POST['updateUsingItemCategory'];
        $itemDescription = $_POST['updateUsingItemDescription'];
        $itemCosting = $_POST['updateUsingItemCosting'];
        $itemStock = $_POST['updateUsingItemStock'];
        $itemUnitPrice = $_POST['updateUsingItemUnitPrice'];

        // Initialize your database connection
        $db = $conn; 

        $management = new Management($db);
        $response = $management->itemUpdate($productID, $itemNumber, $itemName, $itemCategory, $itemDescription, $itemCosting, $itemStock, $itemUnitPrice);

		insertAudit('Account: ' . '(' . $_SESSION['userid'] . ')' . ' Updated Item ' . $productID);

        // Return JSON response
        echo json_encode($response);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteUsingCustomerID'])) {
        $customerID = intval($_POST['deleteUsingCustomerID']);

        // Initialize your database connection
        $db = $conn; 

        $management = new Management($db);
        $response = $management->customerDelete($customerID);

		insertAudit('Account: ' . '(' . $_SESSION['userid'] . ')' . ' Deleted Item ' . $customerID);

        // Return JSON response
        echo json_encode($response);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateUsingCustomerID'])) {
        $customerID = intval($_POST['updateUsingCustomerID']);
        $customerFullName = $_POST['updateUsingCustomerFullName'];
        $customerEmail = $_POST['updateUsingCustomerEmail'];
        $customerMobile = $_POST['updateUsingCustomerMobile'];
        $customerPhone2 = $_POST['updateUsingCustomerMobile2'];
        $customerAddress = $_POST['updateUsingCustomerAddress'];
        $customerAddress2 = $_POST['updateUsingCustomerAdress2'];
        $customerCity = $_POST['updateUsingCustomerCity'];
        $customerDistrict = $_POST['updateUsingCustomerDistrict'];

        // Initialize your database connection
        $db = $conn; 

        $management = new Management($db);
        $response = $management->customerUpdate(
            $customerID, 
            $customerFullName, 
            $customerEmail,
            $customerMobile, 
            $customerPhone2, 
            $customerAddress, 
            $customerAddress2, 
            $customerCity, 
            $customerDistrict
        );

		insertAudit('Account: ' . '(' . $_SESSION['userid'] . ')' . ' Updated Customer ' . $customerID);

        // Return JSON response
        echo json_encode($response);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteUsingVendorID'])) {
        $vendorID = intval($_POST['deleteUsingVendorID']);

        // Initialize your database connection
        $db = $conn; 

        $management = new Management($db);
        $response = $management->vendorDelete($vendorID);

		insertAudit('Account: ' . '(' . $_SESSION['userid'] . ')' . ' Deleted Supplier ' . $vendorID);

        // Return JSON response
        echo json_encode($response);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateUsingVendorID'])) {
        $vendorID = intval($_POST['updateUsingVendorID']);
        $vendorFullName = $_POST['updateUsingVendorFullName'];
        $vendorEmail = $_POST['updateUsingVendorEmail'];
        $vendorMobile = $_POST['updateUsingVendorMobile'];
        $vendorMobile2 = $_POST['updateUsingVendorMobile2'];
        $vendorAddress = $_POST['updateUsingVendorAddress'];
        $vendorAddress2 = $_POST['updateUsingVendorAddress2'];
        $vendorCity = $_POST['updateUsingVendorCity'];
        $vendorDistrict = $_POST['updateUsingVendorDistrict'];

        // Initialize your database connection
        $db = $conn; 

        $management = new Management($db);
        $response = $management->vendorUpdate(
            $vendorID, 
            $vendorFullName, 
            $vendorEmail, 
            $vendorMobile, 
            $vendorMobile2, 
            $vendorAddress, 
            $vendorAddress2, 
            $vendorCity, 
            $vendorDistrict
        );

		insertAudit('Account: ' . '(' . $_SESSION['userid'] . ')' . ' Updated Supplier ' . $vendorID);

        // Return JSON response
        echo json_encode($response);
        exit();
    }

    
