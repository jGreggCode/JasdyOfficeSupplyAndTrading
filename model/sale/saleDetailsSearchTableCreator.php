<?php
	session_start();
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	$usertype = $_SESSION['usertype'];
	$userid = $_SESSION['userid'];

	if ($usertype === 'Admin') {
		$saleDetailsSearchSql = 'SELECT * FROM sale';
		$saleDetailsSearchStatement = $conn->prepare($saleDetailsSearchSql);
		$saleDetailsSearchStatement->execute();
	} else {
		$saleDetailsSearchSql = 'SELECT * FROM sale WHERE sellerID = :sellerID';
		$saleDetailsSearchStatement = $conn->prepare($saleDetailsSearchSql);
		$saleDetailsSearchStatement->execute(['sellerID' => $userid]);
	}

	$output = '<table id="saleDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>Order ID</th>
						<th>Customer ID</th>
						<th>Seller ID</th>
						<th>Customer Name</th>
						<th>Order Date</th>
						<th>Invoice</th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $saleDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
			
		$output .= '<tr>' .
						'<td>' . $row['saleID'] . '</td>' .
						'<td>' . $row['customerID'] . '</td>' .
						'<td>' . $row['sellerID'] . '</td>' .
						'<td>' . $row['customerName'] . '</td>' .
						'<td>' . $row['saleDate'] . '</td>' .
						'<td> <a href="generatePDF.php?invID='. $row['saleID'] .'&ACTION=VIEW" style="color: blue; font-weight: bold;">Invoice</a> </td>' .
					'</tr>';
	}
	
	$saleDetailsSearchStatement->closeCursor();
	
	echo $output;
?>


