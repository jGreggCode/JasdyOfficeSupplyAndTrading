<?php
	session_start();
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

    class AccountManager {
        private $db;
    
        // Constructor to initialize the database connection
        public function __construct($db) {
            $this->db = $db;
        }
    
        // Method to delete an account
        public function deleteAccount($accountID) {
            try {
                $stmt = $this->db->prepare("DELETE FROM user WHERE userID = :id");
                $stmt->bindParam(':id', $accountID, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $message = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Account deleted successfully</div>';
                    return ['status' => 'success', 'message' => $message];
                } else {
                    $message = '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>Account not found or already deleted</div>';
                    return ['status' => 'warning', 'message' => $message];
                }
            } catch (PDOException $e) {
                $message = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Database error: ' . $e->getMessage() . '</div>';
                return ['status' => 'error', 'message' => $message];
            }
        }

        // Method to activate an account
        public function activateAccount($accountEmail) {
            try {
                // Validate if the account exists and is already active
                $stmt = $this->db->prepare("SELECT status, usertype FROM user WHERE email = :email");
                $stmt->bindParam(':email', $accountEmail, PDO::PARAM_STR);
                $stmt->execute();
    
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $accountType = $result['usertype'];
                $accountStatus = $result['status'];
    
                if (!$result) {
                    $message = 'Account not found';
                    return ['status' => 'error', 'message' => $message];
                }
    
                if ($accountStatus == 'Active') {
                    $message = 'Account is already active';
                    return ['status' => 'warning', 'message' => $message];
                }
    
                // Activate the account
                $updateStmt = $this->db->prepare("UPDATE user SET status = 'Active' WHERE email = :email");
                $updateStmt->bindParam(':email', $accountEmail, PDO::PARAM_STR);
                $updateStmt->execute();
    
                if ($updateStmt->rowCount() > 0) {
                    $message = 'Account activated and activation email notification has been sent';
                    return ['status' => 'success', 'message' => $message];
                } else {
                    $message = 'Failed to activate account';
                    return ['status' => 'error', 'message' => $message];
                }
            } catch (PDOException $e) {
                return ['status' => 'error', 'message' => 'Database error:' . $e->getMessage()];
            }
        }

        // Method to deactivate an account
        public function deactivateAccount($accountEmail) {
            try {
                // Validate if the account exists and is already active
                $stmt = $this->db->prepare("SELECT status, usertype FROM user WHERE email = :email");
                $stmt->bindParam(':email', $accountEmail, PDO::PARAM_INT);
                $stmt->execute();
    
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $accountStatus = $result['status'];
    
                if (!$result) {
                    $message = 'Account not found';
                    return ['status' => 'error', 'message' => $message];
                }
    
                if ($accountStatus == 'Disabled') {
                    $message = 'Account is already deactivated';
                    return ['status' => 'warning', 'message' => $message];
                }
    
                // Activate the account
                $updateStmt = $this->db->prepare("UPDATE user SET status = 'Disabled' WHERE email = :email");
                $updateStmt->bindParam(':email', $accountEmail, PDO::PARAM_STR);
                $updateStmt->execute();
    
                if ($updateStmt->rowCount() > 0) {
                    $message = 'Account deactivated and deactivation email notification has been sent';
                    return ['status' => 'success', 'message' => $message];
                } else {
                    $message = 'Failed to deactivate account';
                    return ['status' => 'error', 'message' => $message];
                }
            } catch (PDOException $e) {
                return ['status' => 'error', 'message' => 'Database error:' . $e->getMessage()];
            }
        }

        public function submitUpdate(
            $updateUserID,
            $updateUserDetailsUserFullName,
            $updateUserDetailsUserUsername,
            $updateUserDetailsUserEmail,
            $updateUserDetailsUserMobile,
            $updateUserDetailsUserLocation,
        ) {
            try {
                // Validate if the account exists and is already active
                $stmt = $this->db->prepare("SELECT * FROM user WHERE userID = :updateUserID");
                $stmt->bindParam(':updateUserID', $updateUserID, PDO::PARAM_STR);
                $stmt->execute();
    
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
                if (!$result) {
                    $message = 'Account not found';
                    return ['status' => 'error', 'message' => $message];
                }
    
                // Activate the account
                $updateStmt = $this->db->prepare("UPDATE user SET 
                    fullName = :fullName, 
                    username = :username, 
                    email = :email,
                    mobile = :mobile, 
                    location = :location 
                    WHERE userID = :userID"
                );
                $updateStmt->execute([
                    'fullName' => $updateUserDetailsUserFullName,
                    'username' => $updateUserDetailsUserUsername,
                    'email' => $updateUserDetailsUserEmail,
                    'mobile' => $updateUserDetailsUserMobile,
                    'location' => $updateUserDetailsUserLocation,
                    'userID' => $updateUserID

                ]);
    
                if ($updateStmt->rowCount() > 0) {
                    $message = 'Account details Successfully updated';
                    return ['status' => 'success', 'message' => $message];
                } else {
                    $message = 'Failed to update account details';
                    return ['status' => 'error', 'message' => $message];
                }
            } catch (PDOException $e) {
                return ['status' => 'error', 'message' => 'Database error:' . $e->getMessage()];
            }
        }

        public function adminUpdate(
            $updateUserID,
            $updateUserDetailsUserFullName,
            $updateUserDetailsUserUsername,
            $updateUserDetailsUserEmail,
            $updateUserDetailsUserMobile,
            $updateUserDetailsUserLocation,
            $updateUserDetailsUserType
        ) {
            try {
                // Validate if the account exists and is already active
                $stmt = $this->db->prepare("SELECT * FROM user WHERE userID = :updateUserID");
                $stmt->bindParam(':updateUserID', $updateUserID, PDO::PARAM_STR);
                $stmt->execute();
    
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
                if (!$result) {
                    $message = 'Account not found';
                    return ['status' => 'error', 'message' => $message];
                }
    
                // Activate the account
                $updateStmt = $this->db->prepare("UPDATE user SET 
                    fullName = :fullName, 
                    username = :username, 
                    usertype = :usertype,
                    email = :email, 
                    mobile = :mobile, 
                    location = :location 
                    WHERE userID = :userID"
                );
                $updateStmt->execute([
                    'fullName' => $updateUserDetailsUserFullName,
                    'username' => $updateUserDetailsUserUsername,
                    'usertype' => $updateUserDetailsUserType,
                    'email' => $updateUserDetailsUserEmail,
                    'mobile' => $updateUserDetailsUserMobile,
                    'location' => $updateUserDetailsUserLocation,
                    'userID' => $updateUserID

                ]);
    
                if ($updateStmt->rowCount() > 0) {
                    $message = 'Account details Successfully updated';
                    return ['status' => 'success', 'message' => $message];
                } else {
                    $message = 'Failed to update account details';
                    return ['status' => 'error', 'message' => $message];
                }
            } catch (PDOException $e) {
                return ['status' => 'error', 'message' => 'Database error:' . $e->getMessage()];
            }
        }
    }

	