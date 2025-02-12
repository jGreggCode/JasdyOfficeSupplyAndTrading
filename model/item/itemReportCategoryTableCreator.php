<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

    $category = '';
	 
	$itemDetailsSearchSql = 'SELECT * FROM item WHERE category = :category';
	$itemDetailsSearchStatement = $conn->prepare($itemDetailsSearchSql);
	$itemDetailsSearchStatement->execute(['category' => $category]);

	$output = '<table id="itemReportsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>Product ID</th>
						<th>Category</th>
						<th>Item Number</th>
						<th>Item Name</th>
						<th>Stock</th>
						<th>Unit Price</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $itemDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
		$output .= '<tr>' .
						'<td>' . $row['productID'] . '</td>' .
						'<td>' . $row['category'] . '</td>' .
						'<td>' . $row['itemNumber'] . '</td>' .
						//'<td>' . $row['itemName'] . '</td>' .
						'<td><a href="#" class="itemDetailsHover" data-toggle="popover" id="' . $row['productID'] . '">' . $row['itemName'] . '</a></td>' .
						'<td>' . $row['stock'] . '</td>' .
						'<td>' . $row['unitPrice'] . '</td>' .
						'<td>' . $row['description'] . '</td>' .
					'</tr>';
	}
	
	$itemDetailsSearchStatement->closeCursor();
	

	echo $output;
?>