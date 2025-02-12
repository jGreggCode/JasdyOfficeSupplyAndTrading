<?php
	require_once 'AccountManager.php';
	require_once '../../send.php';
	require_once '../audit/insertAudit.php';
	require_once './GetAccountDetails.php';


    // Handle AJAX request
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteUsingAccountID'])) {
        $accountID = intval($_POST['deleteUsingAccountID']);

        // Initialize your database connection
        $db = $conn; 

        $accountManager = new AccountManager($db);
		$response = null;

		if ($_SESSION['userid'] == $accountID) {
			$message = 'You cannot delete your own account!';
			$response = ['status' => 'warning', 'message' => $message];
		} else {
			$response = $accountManager->deleteAccount($accountID);
		}

		insertAudit('Account: ' . '(' . $_SESSION['userid'] . ')' . ' Deleted ' . $accountID);

        // Return JSON response
        echo json_encode($response);
        exit();
    }
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['activateAccountEmail'])) {
		$accountID = trim($_POST['accountID']);
		$accountEmail = trim($_POST['activateAccountEmail']);
		$accountType = trim($_POST['activateAccountType']);
	
		$db = $conn;
	
		$accountManager = new AccountManager($db);
		$response = $accountManager->activateAccount($accountEmail);
		
		if ($response['status'] === 'success') {
			accountActivatedEmail($accountType, $accountEmail);
			
			insertAudit('Account: ' . '(' . $_SESSION['userid'] . ')' . ' Activated ' . $accountID);
			$message = 'Account Activated and Email notification has been sent.';
			$response = ['status' => 'success', 'message' => $message];
		} 

		
		echo json_encode($response);
		exit();
	}

	// Deactivate
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deactivateAccountEmail'])) {
		$accountID = trim($_POST['accountID']);
		$accountEmail = trim($_POST['deactivateAccountEmail']);
		$accountType = trim($_POST['deactivateAccountType']);
	
		$db = $conn;
	
		$accountManager = new AccountManager($db);
		$response = $accountManager->deactivateAccount($accountEmail);
		
		if ($response['status'] === 'success') {
			accountDeactivateEmail($accountType, $accountEmail);
			
			insertAudit('Account: ' . '(' . $_SESSION['userid'] . ')' . ' Deactivate ' . $accountID);
			$message = 'Account Deactivated and Email notification has been sent.';
			$response = ['status' => 'success', 'message' => $message];
		} 

		
		echo json_encode($response);
		exit();
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateUserID'])) {
		$updateUserID = trim($_POST['updateUserID']);
		$updateUserDetailsUserFullName = trim($_POST['updateUserDetailsUserFullName']);
		$updateUserDetailsUserUsername = trim($_POST['updateUserDetailsUserUsername']);
		$updateUserDetailsUserEmail = trim($_POST['updateUserDetailsUserEmail']);
		$updateUserDetailsUserMobile = trim($_POST['updateUserDetailsUserMobile']);
		$updateUserDetailsUserLocation = trim($_POST['updateUserDetailsUserLocation']);

		// Admin Can Update these
		$updateUserDetailsUserStatus = '';
		$updateUserDetailsUserPosition = '';

		// Connection to pass in AccountManager
		$db = $conn;
	
		// Initialize Account Manager Class
		$accountManager = new AccountManager($db);

		// If the editor is Admin
		if ($_SESSION['edit'] == 'ADMIN') {
			$updateUserDetailsUserStatus = trim($_POST['updateUserDetailsUserStatus']);
			$updateUserDetailsUserType = trim($_POST['updateUserDetailsUserType']);

			$response = $accountManager->adminUpdate($updateUserID, 
				$updateUserDetailsUserFullName, 
				$updateUserDetailsUserUsername, 
				$updateUserDetailsUserEmail, 
				$updateUserDetailsUserMobile, 
				$updateUserDetailsUserLocation,
				$updateUserDetailsUserType
			);
		} else {
			$response = $accountManager->submitUpdate(
				$updateUserID,
				$updateUserDetailsUserFullName,
				$updateUserDetailsUserUsername,
				$updateUserDetailsUserEmail,
				$updateUserDetailsUserMobile,
				$updateUserDetailsUserLocation,
			);

			getAccountDetails($updateUserID);
		}

		if ($response['status'] === 'success') {
			$message = 'Account Successfully updated!';
			if ($_SESSION['userid'] == $updateUserID) {
				insertAudit('Account: ' . '(' . $_SESSION['userid'] . ')' . ' Updated his/her account details.');
			} else {
				insertAudit('Account: ' . '(' . $_SESSION['userid'] . ')' . ' Updated ' . $updateUserID . ' details.');
			}
			$response = ['status' => 'success', 'message' => $message];
		} 

		
		
		$_SESSION['edit'] = '';
		echo json_encode($response);
		exit();
	}
