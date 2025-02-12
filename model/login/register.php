<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	require_once('../audit/insertAudit.php');
	require_once('../../send.php');
	
	$registerFullName = '';
	$registerUsername = '';
	$registerUserType = '';
	$registerEmail = '';
	$registerPhoneNo = '';
	$registerPassword1 = '';
	$registerPassword2 = '';
	$hashedPassword = '';
	// 
	function isValidEmail($registerEmail) {
		$pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
		return preg_match($pattern, $registerEmail);
	}

	function validatePhilippineNumber($registerPhoneNo) {
		// Regular expression pattern for Philippine numbers in different valid formats
		$pattern = '/^(09\d{9}|9\d{9}|639\d{9})$/';
	
		// Check if the number matches the pattern
		if (preg_match($pattern, $registerPhoneNo)) {
			return true; // Valid Philippine number
		} else {
			return false; // Invalid number
		}
	}
	
	if(isset($_POST['registerUsername'])){
		$registerFullName = htmlentities($_POST['registerFullName']);
		$registerUsername = htmlentities($_POST['registerUsername']);
		$registerUserType = htmlentities($_POST['registerUserType']);
		$registerEmail = htmlentities($_POST['registerEmail']);
		$registerPhoneNo = htmlentities($_POST['registerPhoneNo']);
		$registerPassword1 = htmlentities($_POST['registerPassword1']);
		$registerPassword2 = htmlentities($_POST['registerPassword2']);

		
		if(!empty($registerFullName) && !empty($registerUsername) && !empty($registerUserType) && !empty($registerPassword1) && !empty($registerPassword2)){
			
			// Sanitize name
			$registerFullName = filter_var($registerFullName, FILTER_SANITIZE_STRING);
			
			// Check if name is empty
			if($registerFullName == ''){
				echo '<div class="alert alert-danger" style="color: red;">Please enter your name.</div>';
				exit();
			}
			
			// Check if username is empty
			if($registerUsername == ''){
				echo '<div class="alert alert-danger" style="color: red;">Please enter your username.</div>';
				exit();
			}

			if($registerUsername == ''){
				echo '<div class="alert alert-danger" style="color: red;">Please enter your username.</div>';
				exit();
			}
			
			// Check if both passwords are empty
			if($registerEmail == ''){
				echo '<div class="alert alert-danger" style="color: red;">Please enter your Email.</div>';
				exit();
			}

			if (!isValidEmail($registerEmail)) {
				echo '<div class="alert alert-danger" style="color: red;">Invalid Email!</div>';
				exit();
			}

			if (!validatePhilippineNumber($registerPhoneNo)) {
				echo '<div class="alert alert-danger" style="color: red;">Invalid Phone Number!</div>';
				exit();
			}
			
			// Check if username is available
			$usernameCheckingSql = 'SELECT * FROM user WHERE username = :username';
			$usernameCheckingStatement = $conn->prepare($usernameCheckingSql);
			$usernameCheckingStatement->execute(['username' => $registerUsername]);

			// Check if email is available
			$emailCheckingSql = 'SELECT * FROM user WHERE email = :email';
			$emailCheckingStatement = $conn->prepare($emailCheckingSql);
			$emailCheckingStatement->execute(['email' => $registerEmail]);
			
			if($usernameCheckingStatement->rowCount() > 0){
				// Username already exists. Hence can't create a new user
				echo '<div class="alert alert-danger" style="color: red;">Username not available. Please select a different username.</div>';
				exit();
			} else if ($emailCheckingStatement->rowCount() > 0) {
				// Email already exists. Hence can't create a new user
				echo '<div class="alert alert-danger" style="color: red;">Email not available. Please select a different Email.</div>';
				exit();
			} else {
				// Check if passwords are equal
				if($registerPassword1 !== $registerPassword2){
					echo '<div class="alert alert-danger" style="color: red;">Passwords do not match.</div>';
					exit();
				} else {
					// Start inserting user to DB
					// Encrypt the password
					$hashedPassword = md5($registerPassword1);
					$insertUserSql = 'INSERT INTO user(usertype, fullName, email, username, password, mobile) VALUES(:usertype, :fullName, :email, :username, :password, :mobile)';
					$insertUserStatement = $conn->prepare($insertUserSql);
					$insertUserStatement->execute([
						'usertype' => $registerUserType, 
						'fullName' => $registerFullName, 
						'email' => $registerEmail, 
						'username' => $registerUsername, 
						'password' => $hashedPassword,
						'mobile' => $registerPhoneNo
					]);

					
					// Insert To Audit
					$message = $registerFullName . " has registered under account name " .  "\"" . $registerUsername . "\"";
					
					echo '<div class="alert alert-danger" style="color: green;">Registered Successfully, please check your email.</div>';
					
					// Add audit for user registration
					registerAudit($registerUsername, $message);

					// Send registered email
					registerSendEmail($registerUserType, $registerEmail);
					exit();
				}
			}
		} else {
			// One or more mandatory fields are empty. Therefore, display a the error message
			echo '<div class="alert alert-danger" style="color: red;">Please enter all fields</div>';	
			exit();
		}
	}
?>