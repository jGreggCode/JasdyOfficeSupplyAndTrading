<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$vendorDetailsSearchSql = 'SELECT * FROM audit';
	$vendorDetailsSearchStatement = $conn->prepare($vendorDetailsSearchSql);
	$vendorDetailsSearchStatement->execute();

	$output = '<table id="auditDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>Audit ID</th>
						<th>Time</th>
						<th>User ID</th>
						<th>User Type</th>
						<th>User Name</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $vendorDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
		$output .= '<tr>' .
						'<td>' . $row['auditID'] . '</td>' .
						'<td>' . $row['time'] . '</td>' .
						'<td>' . $row['userID'] . '</td>' .
						'<td>' . $row['usertype'] . '</td>' .
						'<td>' . $row['userName'] . '</td>' .
						'<td>' . $row['Action'] . '</td>' .
					'</tr>';
	}
	
	$vendorDetailsSearchStatement->closeCursor();
	
	
	echo $output;
?>