<?php
	session_start();
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	require_once('../../inc/errorhandling.php');
    require_once('../../send.php');

    // Get the protocol (HTTP or HTTPS)
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

    // Get the host (domain or IP)
    $host = $_SERVER['HTTP_HOST'];

    // Get the current directory
    $path = rtrim(dirname($_SERVER['SCRIPT_NAME'], 3), '/');

    // Combine to form the base URL
    $baseURL = $protocol . "://" . $host . $path;
	
	$loginUsername = '';
	
	if(isset($_POST['forgotPass'])){
		$loginUsername = $_POST['forgotPass'];
		
		if(!empty($loginUsername)){
			
			// Sanitize username
			$loginUsername = filter_var($loginUsername, FILTER_SANITIZE_STRING);
			
			// Check the given credentials
			$checkUserSql = 'SELECT * FROM user WHERE (username = :username OR email = :email)';
			$checkUserStatement = $conn->prepare($checkUserSql);
			$checkUserStatement->execute([
                'username' => $loginUsername,
                'email' => $loginUsername,
            ]);
			
			// Check if user exists or not
			if($checkUserStatement->rowCount() > 0){
				// Valid credentials. Hence, start the session
				$row = $checkUserStatement->fetch(PDO::FETCH_ASSOC);

                if ($row['status'] === 'Disabled') {
					echo '<div class="alert alert-danger" style="color: red;">Your account is disabled.</div>';
					exit();
				}

                $emailRecipient = $row['email'];

                $token = bin2hex(random_bytes(32));
                $expires = date("Y-m-d H:i:s", strtotime("+5 minutes"));

                $updateTokenSql = "UPDATE user SET reset_token = :reset_token, reset_expires = :reset_expires WHERE email = :email";
                $updateTokenStatement = $conn->prepare($updateTokenSql);
                $updateTokenStatement->execute([
                    'reset_token' => $token,
                    'reset_expires' => $expires,
                    'email' => $emailRecipient
                ]);

                
                $resetLink = $baseURL . "/inc/changepass.php?token=" . $token;
				echo '<div class="alert alert-success" >Password reset link has been sent to your email <b>' . $emailRecipient . '</b></div>';
                forgotPassword($resetLink, $emailRecipient);
                
				exit();
			} else {
				// Redirect to login with error message in query parameter
				echo '<div class="alert alert-danger" style="color: red;">User not found</div>';
			}
		} else {
			echo '<div class="alert alert-danger" style="color: red;">Please enter your USERNAME or EMAIL in username field</div>';
			exit();
		}
	}
?>