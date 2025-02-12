<?php 
    require_once('../../inc/config/constants.php');
    require_once('../../inc/config/db.php');

    function getAccountDetails($userID) {
        global $conn;
        $checkUserSql = 'SELECT * FROM user WHERE userID = :userID';
        $checkUserStatement = $conn->prepare($checkUserSql);
        $checkUserStatement->execute(['userID' => $userID]);

        if($checkUserStatement->rowCount() > 0) {
                $row = $checkUserStatement->fetch(PDO::FETCH_ASSOC);
                
				$_SESSION['userid'] = $row['userID'];
				$_SESSION['fullName'] = $row['fullName'];
				$_SESSION['usertype'] = $row['usertype'];
				$_SESSION['status'] = $row['status'];
				$_SESSION['sales'] = $row['sales'];
				$_SESSION['sold'] = $row['sold'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['mobile'] = $row['mobile'];
				$_SESSION['location'] = $row['location'];
        }
    }
