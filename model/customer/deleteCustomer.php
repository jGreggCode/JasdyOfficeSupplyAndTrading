<?php
session_start();
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	if(isset($_POST['customerDetailsCustomerID'])){
		
		$customerDetailsCustomerID = htmlentities($_POST['customerDetailsCustomerID']);
		
		// Check if mandatory fields are not empty
		if(!empty($customerDetailsCustomerID)){
			
			// Sanitize customerID
			$customerDetailsCustomerID = filter_var($customerDetailsCustomerID, FILTER_SANITIZE_STRING);

			// Check if the customer is in the database
			$customerSql = 'SELECT customerID FROM customer WHERE customerID=:customerID';
			$customerStatement = $conn->prepare($customerSql);
			$customerStatement->execute(['customerID' => $customerDetailsCustomerID]);
			
			if($customerStatement->rowCount() > 0){
				
				// Customer exists in DB. Hence start the DELETE process
				$deleteCustomerSql = 'DELETE FROM customer WHERE customerID=:customerID';
				$deleteCustomerStatement = $conn->prepare($deleteCustomerSql);
				$deleteCustomerStatement->execute(['customerID' => $customerDetailsCustomerID]);

				$time = date('Y-m-d H:i:s');
				$action = "Customer Deleted (Customer)";
				$insertAuditSql = 'INSERT INTO audit(`time`, userID, usertype, userName, Action) VALUES(:time, :userID, :usertype, :userName, :Action)';
		
				$insertAuditStatement = $conn->prepare($insertAuditSql);
				$insertAuditStatement->execute(['time' => $time, 'userID' => $_SESSION['userid'], 'usertype' => $_SESSION['usertype'], 'userName' => $_SESSION['fullName'], 'Action' => $action]);

				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Customer deleted.</div>';
				exit();
				
			} else {
				// Customer does not exist, therefore, tell the user that he can't delete that customer 
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Customer does not exist in DB. Therefore, can\'t delete.</div>';
				exit();
			}
			
		} else {
			// CustomerID is empty. Therefore, display the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter the CustomerID</div>';
			exit();
		}
	}
?>