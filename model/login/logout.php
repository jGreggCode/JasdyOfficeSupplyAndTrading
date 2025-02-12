<?php
	session_start();
	
	unset($_SESSION['loggedIn']);
	unset($_SESSION['fullName']);
	unset($_SESSION['usertype']);
	session_destroy();
	header('Location: ../../index.php');
	exit();
?>