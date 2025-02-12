<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$saleDetailsSearchSql = 'SELECT * FROM sale';
	$saleDetailsSearchStatement = $conn->prepare($saleDetailsSearchSql);
	$saleDetailsSearchStatement->execute();

	$output = '<table id="saleReportsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>Order ID</th>
						<th>Customer ID</th>
						<th>Seller ID</th>
						<th>Customer Name</th>
						<th>Order Date</th>
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
					'</tr>';
	}
	
	$saleDetailsSearchStatement->closeCursor();

	echo $output;
?>


