<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$itemDetailsSearchSql = 'SELECT * FROM item';
	$itemDetailsSearchStatement = $conn->prepare($itemDetailsSearchSql);
	$itemDetailsSearchStatement->execute();
	
	$output = '<table id="itemDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>Action</th>
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
		$isInStock = $row['stock'] > 0 ? $row['stock'] : 'Out of Stock';
		$output .= '<tr>' .
						'<td>' . '<a href="model/item/update.php?id='. $row['productID'] . '" style="color: blue; font-weight: bold;">Edit</a>' . '</td>' .
						'<td>' . $row['productID'] . '</td>' .
						'<td>' . $row['category'] . '</td>' .
						'<td>' . $row['itemNumber'] . '</td>' .
						'<td><a href="#" class="itemDetailsHover" data-toggle="popover" id="' . $row['productID'] . '">' . $row['itemName'] . '</a></td>' .
						'<td style="color: ' . ($row['stock'] > 0 ? 'green' : 'red') . ';">' . $isInStock . '</td>' .
						'<td>' . $row['unitPrice'] . '</td>' .
						'<td>' . $row['description'] . '</td>' .
					'</tr>';
	}
	
	$itemDetailsSearchStatement->closeCursor();
	

	echo $output;
?>