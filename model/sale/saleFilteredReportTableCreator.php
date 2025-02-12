<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	if(isset($_POST['startDate'])){
		$startDate = htmlentities($_POST['startDate']);
		$endDate = htmlentities($_POST['endDate']);
		
		$saleFilteredReportSql = 'SELECT * FROM sale WHERE saleDate BETWEEN :startDate AND :endDate';
		$saleFilteredReportStatement = $conn->prepare($saleFilteredReportSql);
		$saleFilteredReportStatement->execute(['startDate' => $startDate, 'endDate' => $endDate]);

		$output = '<table id="saleFilteredReportsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
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
		while($row = $saleFilteredReportStatement->fetch(PDO::FETCH_ASSOC)){
		
			$output .= '<tr>' .
							'<td>' . $row['saleID'] . '</td>' .
							'<td>' . $row['customerID'] . '</td>' .
							'<td>' . $row['sellerID'] . '</td>' .
							'<td>' . $row['customerName'] . '</td>' .
							'<td>' . $row['saleDate'] . '</td>' .
						'</tr>';
		}
		
		$saleFilteredReportStatement->closeCursor();

		echo $output;
	}
?>


