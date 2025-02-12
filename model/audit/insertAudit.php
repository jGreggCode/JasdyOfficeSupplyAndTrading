<?php
    require_once('../../inc/config/constants.php');
    require_once('../../inc/config/db.php');

    function insertAudit($message) {    
        global $conn;
        $action = $message;
        $time = date('Y-m-d H:i:s');

        $insertAuditSql = 'INSERT INTO audit(`time`, userID, usertype, userName, Action) VALUES(:time, :userID, :usertype, :userName, :Action)';

        $insertAuditStatement = $conn->prepare($insertAuditSql);
        $insertAuditStatement->execute([
            'time' => $time, 
            'userID' => $_SESSION['userid'], 
            'usertype' => $_SESSION['usertype'], 
            'userName' => $_SESSION['fullName'], 
            'Action' => $action
        ]);

    }

    function registerAudit($username, $message) {
        global $conn;
        $checkUserSql = 'SELECT * FROM user WHERE username = :username';
        $checkUserStatement = $conn->prepare($checkUserSql);
        $checkUserStatement->execute([
            'username' => $username
        ]);

        if($checkUserStatement->rowCount() > 0){
            // Valid credentials. Hence, start the session
            $row = $checkUserStatement->fetch(PDO::FETCH_ASSOC);

            $action = $message;
            $time = date('Y-m-d H:i:s');

            $insertAuditSql = 'INSERT INTO audit(`time`, userID, usertype, userName, Action) VALUES(:time, :userID, :usertype, :userName, :Action)';

            $insertAuditStatement = $conn->prepare($insertAuditSql);
            $insertAuditStatement->execute([
                'time' => $time, 
                'userID' => $row['userID'], 
                'usertype' => $row['usertype'], 
                'userName' => $row['fullName'], 
                'Action' => $action
            ]);
        }
    }