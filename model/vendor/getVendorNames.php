<?php
	$vendorNamesSql = 'SELECT * FROM vendor';
	$vendorNamesStatement = $conn->prepare($vendorNamesSql);
	$vendorNamesStatement->execute();
	
	if($vendorNamesStatement->rowCount() > 0) {
		while($row = $vendorNamesStatement->fetch(PDO::FETCH_ASSOC)) {
			echo '<option value="' .$row['fullName'] . '">' . $row['fullName'] . '</option>';
		}
	} else {
		echo '<option value="No Vendors" disabled>No vendors</option>';
	}
	$vendorNamesStatement->closeCursor();
?>