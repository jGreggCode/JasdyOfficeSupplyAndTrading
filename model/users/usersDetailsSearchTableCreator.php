<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$vendorDetailsSearchSql = 'SELECT * FROM user';
	$vendorDetailsSearchStatement = $conn->prepare($vendorDetailsSearchSql);
	$vendorDetailsSearchStatement->execute();

	$output = '<table id="usersDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead class="">
					<tr style="">
						<th>Action</th>
						<th>Account ID</th>
						<th>Position</th>
						<th>Name</th>
						<th>Account Type</th>
						<th>Username</th>
						<th>Status</th>
						<th>Mobile</th>
						<th>Location</th>
						<th>Total Sales</th>
						<th>Total Sold</th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $vendorDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
		$output .= '<tr>' .
						'<td>' . '<a href="model/users/update.php?id='. $row['userID'] . '&ACTION=ADMIN" style="color: blue; font-weight: bold;">Edit</a>' . '</td>' .
						'<td>' . $row['userID'] . '</td>' .
						'<td>' . $row['usertype'] . '</td>' .
						'<td>' . $row['fullName'] . '</td>' .
						'<td>' . $row['usertype'] . '</td>' .
						'<td>' . $row['username'] . '</td>' .
						'<td>' . $row['status'] . '</td>' .
						'<td>' . $row['mobile'] . '</td>' .
						'<td>' . $row['location'] . '</td>' .
						'<td>' . $row['sales'] . '</td>' .
						'<td>' . $row['sold'] . '</td>' .
					'</tr>';
	}
	
	$vendorDetailsSearchStatement->closeCursor();
	

	echo $output;
?>