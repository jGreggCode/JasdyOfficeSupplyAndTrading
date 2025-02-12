<?php
            

require_once('config/constants.php');
require_once('config/db.php');

// Employee
$disabledUserEmployeeSql = 'SELECT COUNT(*) AS DisabledEmployeeCount FROM user WHERE status = "Disabled" AND usertype = "Employee"';
$disabledUserEmployeeStatement = $conn->prepare($disabledUserEmployeeSql);
$disabledUserEmployeeStatement->execute();

$resultEmployee = $disabledUserEmployeeStatement->fetch(PDO::FETCH_ASSOC);
$totalDisabledUsersEmployee = $resultEmployee['DisabledEmployeeCount'];

// Reseller
$disabledUserResellerSql = 'SELECT COUNT(*) AS DisabledResellerCount FROM user WHERE status = "Disabled" AND usertype = "Reseller"';
$disabledUserResellerStatement = $conn->prepare($disabledUserResellerSql);
$disabledUserResellerStatement->execute();

$resultReseller = $disabledUserResellerStatement->fetch(PDO::FETCH_ASSOC);
$totalDisabledUsersReseller = $resultReseller['DisabledResellerCount'];
        
    
	
	