<?php
    session_start();
    require_once('../../inc/config/constants.php');
    require_once('../../inc/config/db.php');
    require_once('../audit/insertAudit.php');

    if(isset($_POST['saleDetailsCustomerID'])) {

        $sellerID = $_SESSION['userid'];
        $saleItems = json_decode($_POST['saleItems'], true); // Decode the JSON string into an array
        $saleDetailsCustomerID = $_POST['saleDetailsCustomerID'];
        $saleDetailsCustomerName = $_POST['saleDetailsCustomerName'];
        $saleDetailsSaleDate = $_POST['saleDetailsSaleDate'];
        $saleDetailsCash = $_POST['saleDetailsCash'] ?? 0;
        $saleDetailsDiscount = $_POST['saleDetailsDiscount'];
        $saleDetailsItemStatus = $_POST['saleDetailsItemStatus'] ?? 'Active';

        // Check if mandatory fields are not empty
		if(!empty($sellerID) && 
            isset($saleItems) && 
            isset($saleDetailsCustomerID) && 
            isset($saleDetailsCash) &&
            isset($saleDetailsItemStatus)) {

                // Check if customerID is empty
			if($saleDetailsCustomerID == ''){ 
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a Customer ID.</div>';
				exit();
			}

            if(filter_var($saleDetailsCustomerID, FILTER_VALIDATE_INT) === 0 || filter_var($saleDetailsCustomerID, FILTER_VALIDATE_INT)){
				// Valid customerID
			} else {
				// customerID is not a valid number
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid Customer ID</div>';
				exit();
			}

			if($saleDetailsCash == ''){ 
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid payment mode.</div>';
				exit();
			}

            $insufficientStock = []; 

            // First, check stock availability for all items
            foreach ($saleItems as $item) {
                $itemNumber = $item['itemNumber'];
                $requestedQuantity = $item['quantity'];

                $stockQuery = "SELECT stock FROM item WHERE itemNumber = :itemNumber";
                $stockQueryStatement = $conn->prepare($stockQuery);
                $stockQueryStatement->execute(['itemNumber' => $itemNumber]);

                if ($stockQueryStatement->rowCount() > 0) {
                    $row = $stockQueryStatement->fetch(PDO::FETCH_ASSOC);
                    $currentStock = $row['stock'];
                    if ($currentStock < $requestedQuantity) {
                        // Add the item to the insufficient stock list
                        $insufficientStock[] = [
                            'itemNumber' => $itemNumber,
                            'requestedQuantity' => $requestedQuantity,
                            'availableStock' => $currentStock
                        ];
                    }
                }
            }

            // If there are any items with insufficient stock, show an error and stop
            if (!empty($insufficientStock)) {
                foreach ($insufficientStock as $item) {
                    echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Insufficient stock for item: ' . $item['itemNumber'] . 
                    ' (Requested: ' . $item['requestedQuantity'] . 
                    ', Available: ' . $item['availableStock'] . ').</div>';
                }
                exit();
            }

            // Proceed to process the sale if all items have sufficient stock
            $insertSaleSql = 'INSERT INTO sale(customerID, customerName, saleDate, payment, status, sellerID) VALUES(:customerID, :customerName, :saleDate, :payment, :status, :sellerID)';
            $insertSaleStatement = $conn->prepare($insertSaleSql);
            $insertSaleStatement->execute([
                'customerID' => $saleDetailsCustomerID,
                'customerName' => $saleDetailsCustomerName,
                'saleDate' => $saleDetailsSaleDate,
                'payment' => $saleDetailsCash,
                'status' => $saleDetailsItemStatus,
                'sellerID' => $sellerID
            ]);

            $saleID = $conn->lastInsertId();

            $itemAddSql = "INSERT INTO order_items (saleID, itemNumber, quantity, unitPrice) VALUES (:saleID, :itemNumber, :quantity, :unitPrice)";
            $itemAddStatement = $conn->prepare($itemAddSql);
            $totalSold = 0;
            $totalSale = 0.0;

            foreach ($saleItems as $item) {
                $itemNumber = $item['itemNumber'];
                $quantity = $item['quantity'];
                $unitPrice = $item['unitPrice'];
                $totalSold += $quantity;
                $totalSale += $unitPrice * $quantity;

                $itemAddStatement->execute([
                    'saleID' => $saleID,
                    'itemNumber' => $itemNumber,
                    'quantity' => $quantity,
                    'unitPrice' => $unitPrice
                ]);

                $updateItemSql = "UPDATE item SET stock = stock - :quantity WHERE itemNumber = :itemNumber";
                $updateItemStatement = $conn->prepare($updateItemSql);
                $updateItemStatement->execute([
                    'quantity' => $quantity,
                    'itemNumber' => $itemNumber
                ]);
            }

            $updateTotalOrder = 'UPDATE user SET sales = sales + :sales, sold = sold + :sold WHERE userID = :sellerID';
            $updateTotalOrderStatement = $conn->prepare($updateTotalOrder);
            $updateTotalOrderStatement->execute([
                'sales' => $totalSale,
                'sold' => $totalSold,
                'sellerID' => $sellerID
            ]);

            insertAudit('Account: ' . '(' . $sellerID . ')' . ' made a sale');
            $_SESSION['sales'] += $totalSale;
            $_SESSION['sold'] += $totalSold;

            echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Order has been successfully added!</div>';
        }

    } 