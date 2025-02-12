<?php 
    session_start();
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

    // Execute the script if the POST request is submitted
	if(isset($_POST['orderItemID'])){
		
		$orderItemID = htmlentities($_POST['orderItemID']);
		
		$itemOrderIDSql = 'SELECT * FROM item WHERE productID = :productID';
		$itemOrderIDStatement = $conn->prepare($itemOrderIDSql);
		$itemOrderIDStatement->execute(['productID' => $orderItemID]);
		
		// If data is found for the given item number, return it as a json object
		if($itemOrderIDStatement->rowCount() > 0) {
			$row = $itemOrderIDStatement->fetch(PDO::FETCH_ASSOC);

            $response = [
                'itemNumber' => $row['itemNumber'],
                'itemName' => $row['itemName'],
                'price' => $row['unitPrice']
            ];

			echo json_encode($response);
		}

		$itemOrderIDStatement->closeCursor();
	}
