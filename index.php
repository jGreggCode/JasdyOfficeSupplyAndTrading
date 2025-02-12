<?php 
	session_start();

	if(isset($_SESSION['loggedIn'])){
		header('Location: dashboard.php');
		
	} 

	require_once('inc/config/constants.php');
	require_once('inc/config/db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/loginstyle.css" />
	
	<title>Jasdy Office and Supplies Trading</title>
</head>
<body>
	<div id="loadingMessage" class="loading-message" style="display: none;">
		<div class="spinner"></div>
		<p>Please wait, processing...</p>
	</div>
	<div class="container">
	<div class="forms-container">
		<div class="signin-signup">

		<!-- SiGN in -->
		<form class="sign-in-form">
			<h2 class="title">Sign in</h2>
			<div id="loginMessage"></div>
			<div class="input-field">
				<i class="fas fa-user"></i>
				<input type="text" placeholder="Username" id="loginUsername" name="loginUsername" />
			</div>
			<div class="input-field">
				<i class="fas fa-lock"></i>
				<input type="password" placeholder="Password" id="loginPassword" name="loginPassword" />
			</div>
			<a style="text-decoration: none; cursor: pointer;" type="button"" id="forgotpass">Forgot Password?</a>
			<input type="button" id="login" value="Login" class="btn" />		
		</form>

		<!-- SIGN UP -->
		<form class="sign-up-form">
			<h2 class="title">Sign up</h2>
			<div id="registerMessage"></div>
			<div class="input-field">
				<i class="fas fa-address-card"></i>
				<input type="text" placeholder="Full Name"  id="registerFullName" name="registerFullName"/>
			</div>
			<div class="input-field">
				<i class="fas fa-user"></i>
				<input type="text" placeholder="Username" id="registerUsername" name="registerUsername" autocomplete="on"/>
			</div>
			<div class="input-field">
				<i class="fas fa-envelope"></i>
				<input type="email" placeholder="Email" id="registerEmail" name="registerEmail" autocomplete="on"/>
			</div>
			<div class="input-field">
				<i class="fas fa-phone"></i>
				<input type="text" placeholder="Phone No (Ex: 09123456789)" id="registerPhoneNo" name="registerPhoneNo"/>
			</div>
			<div class="input-field">
				<i class="fas fa-user-tie"></i>
				<select name="registerUserType" id="registerUserType">
					<option value="Employee">Employee</option>
					<option value="Reseller">Reseller</option>
				</select>
			</div>
			<div class="input-field">
				<i class="fas fa-lock"></i>
				<input type="password" placeholder="Password" id="registerPassword1" name="registerPassword1"/>
			</div>
			<div class="input-field">
				<i class="fas fa-lock"></i>
				<input type="password" placeholder="Re-Password" id="registerPassword2" name="registerPassword2"/>
			</div>
			<input type="button" id="register" value="Sign up" class="btn" />
		</form>
		</div>
	</div>

	<!-- PANELS -->
	<div class="panels-container">
		<div class="panel left-panel">
			<div class="content">
				<h3>New here ?</h3>
				<p>
					Join the Jasdy Office Supplies Trading family, where customers enjoy quality products at reasonable prices, making it easy to stock up on essential supplies without overspending.
				</p>
				<button class="btn transparent" id="sign-up-btn">
					Sign up
				</button>
			</div>
			<img src="data/item_images/logo.png" class="image" alt="" />
			</div>
			<div class="panel right-panel">
				<div class="content">
					<h3>One of us ?</h3>
					<p>
						If you're already part of the Jasdy Office Supplies Trading team, please sign in to continue.
					</p>
					<button class="btn transparent" id="sign-in-btn">
						Sign in
					</button>
				</div>
				<img src="data/item_images/logo.png" class="image" alt="" />
			</div>
		</div>
	</div>

	<script src="assets/js/loginjs.js"></script>

	<!-- Bootstrap core JavaScript -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Chosen files for select boxes -->
	<script src="vendor/chosen/chosen.jquery.min.js"></script>
	<link rel="stylesheet" href="vendor/chosen/chosen.css" />


	<!-- Custom scripts -->
	<script src="assets/js/login.js"></script>
</body>
</html>
