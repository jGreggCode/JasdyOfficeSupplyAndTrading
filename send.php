<?php 

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'Mail/src/Exception.php';
    require 'Mail/src/PHPMailer.php';
    require 'Mail/src/SMTP.php';
    
    require_once('inc/config/constants.php');
    require_once('inc/config/db.php');

    $mail = new PHPMailer(true);
    $registerEmail = "";
    $registerUserType = "";
    $activatedEmail = "";
    $activatedAccountType = "";
    $activateDetailsUserStatus = "";

    // Activate Account Status and send email
    if (isset($_POST['userDetailsUserEmail'])) {
        $activatedEmail = $_POST['userDetailsUserEmail'];
        $activatedAccountType = $_POST['userDetailsUserPosition'];
        $activateDetailsUserStatus = $_POST['userDetailsUserStatus'];
        
        if ($activateDetailsUserStatus === 'Active') {
            echo '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>Account already activated!</div>';
            exit();
        } else {

            $updateVendorDetailsSql = 'UPDATE user SET status = :status WHERE email = :email';
            $updateVendorDetailsStatement = $conn->prepare($updateVendorDetailsSql);
            $updateVendorDetailsStatement->execute([
                'status' => 'Active', 
                'email' => $activatedEmail
            ]);

            accountActivatedEmail($activatedAccountType, $activatedEmail);
            echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Account Activated Successfully!</div>';
            exit();
        }
        exit();
    }

    // // Deactivate Account Status and send email
    // if (isset($_POST['deactUserDetailsUserEmail'])) {
    //     $deactUserID = $_POST['deactUserDetailsUserID'];
    //     $deactivateEmail = $_POST['deactUserDetailsUserEmail'];
    //     $deactivateAccountType = $_POST['deactUserDetailsUserPosition'];
    //     $deactivateDetailsUserStatus = $_POST['deactUserDetailsUserStatus'];
        

    //     if ($activateDetailsUserStatus === 'Disabled') {
    //         echo '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>Account already deactivated!</div>';
    //         exit();
    //     } else {
    //         echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Account Deactivated Successfully!</div>';
            
    //         $updateVendorDetailsSql = 'UPDATE user SET status = :status WHERE userID = :userID';
    //         $updateVendorDetailsStatement = $conn->prepare($updateVendorDetailsSql);
    //         $updateVendorDetailsStatement->execute([
    //             'status' => 'Disabled', 
    //             'userID' => $deactUserID
    //         ]);
            
    //         accountDeactivateEmail($deactivateAccountType, $deactivateEmail);
    //         exit();
    //     }
    //     exit();
    // }

    // Send Email for activation
    function accountActivatedEmail($accountType, $recipientEmail) {
        try {
            global $mail; 
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            // $mail->Username = 'noreply@jasdyofficesupplies.shop';
            // $mail->Password = '10kls.Smalltank';
            $mail->Username = 'jgdev101613@gmail.com';
            $mail->Password = 'bjbl usgj ajyp krqz';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    
            // Set sender and recipient
            $mail->setFrom('jgdev101613@gmail.com', 'JASDY OFFICE SUPPLIES TRADING');
            $mail->addAddress($recipientEmail);
            $mail->isHTML(true);
            $mail->Subject = "Account Activation " .  "(" . $accountType . ")";
    
            // Embed logo
            $mail->AddEmbeddedImage(__DIR__ . '/data/item_images/logowithbg.jpg', 'logo_img');
    
            // HTML Email Content
            $mail->Body = "
            <html>
            <head>
                <style>
                    body {
                        background: linear-gradient(135deg, #ffffff, #000000);
                        font-family: Arial, sans-serif;
                        color: #333333;
                        padding: 20px;
                    }
                    .email-container {
                        max-width: 600px;
                        margin: auto;
                        background: #ffffff;
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    }
                    .header {
                        text-align: center;
                        padding: 20px;
                    }
                    .header img {
                        width: 150px;
                        margin-bottom: 20px;
                    }
                    .content {
                        text-align: center;
                        font-size: 18px;
                        line-height: 1.6;
                    }
                    .code {
                        display: inline-block;
                        font-size: 24px;
                        font-weight: bold;
                        background: #000000;
                        color: #ffffff;
                        padding: 10px 20px;
                        border-radius: 5px;
                        margin-top: 20px;
                    }
                    .note {
                        text-align: center;
                    }
                    .footer {
                        margin-top: 30px;
                        font-size: 12px;
                        color: #555555;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
            <div class='email-container'>
                <div class='header'>
                    <img src='cid:logo_img' alt='System Logo'>
                    <h2>Your account has been activated!</h2>
                </div>
                <div class='content'>
                    <p>We are pleased to inform you that your account has been successfully activated. You can now access all our services and features</p>
                    <p>Thank you for choosing us!</p>
                </div>
                <div class='footer'>
                    <p>If you have any issues accessing your account, please feel free to contact us at <b>+63 906 236 4630</b></p>
                </div>
            </div>
            </body>
            </html>
            ";
    
            // Send the email
            $mail->send();
            
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    // Send email for deactivation
    function accountDeactivateEmail($accountType, $recipientEmail) {
        try {
            global $mail; 
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            // $mail->Username = 'noreply@jasdyofficesupplies.shop';
            // $mail->Password = '10kls.Smalltank';
            $mail->Username = 'jgdev101613@gmail.com';
            $mail->Password = 'bjbl usgj ajyp krqz';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    
            // Set sender and recipient
            $mail->setFrom('jgdev101613@gmail.com', 'JASDY OFFICE SUPPLIES TRADING');
            $mail->addAddress($recipientEmail);
            $mail->isHTML(true);
            $mail->Subject = "Account Deactivation " .  "(" . $accountType . ")";
    
            // Embed logo
            $mail->AddEmbeddedImage(__DIR__ . '/data/item_images/logowithbg.jpg', 'logo_img');
    
            // HTML Email Content
            $mail->Body = "
            <html>
            <head>
                <style>
                    body {
                        background: linear-gradient(135deg, #ffffff, #000000);
                        font-family: Arial, sans-serif;
                        color: #333333;
                        padding: 20px;
                    }
                    .email-container {
                        max-width: 600px;
                        margin: auto;
                        background: #ffffff;
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    }
                    .header {
                        text-align: center;
                        padding: 20px;
                    }
                    .header img {
                        width: 150px;
                        margin-bottom: 20px;
                    }
                    .content {
                        text-align: center;
                        font-size: 18px;
                        line-height: 1.6;
                    }
                    .code {
                        display: inline-block;
                        font-size: 24px;
                        font-weight: bold;
                        background: #000000;
                        color: #ffffff;
                        padding: 10px 20px;
                        border-radius: 5px;
                        margin-top: 20px;
                    }
                    .note {
                        text-align: center;
                    }
                    .footer {
                        margin-top: 30px;
                        font-size: 12px;
                        color: #555555;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
            <div class='email-container'>
                <div class='header'>
                    <img src='cid:logo_img' alt='System Logo'>
                    <h2>Your Account Has Been Deactivated</h2>
                </div>
                <div class='content'>
                    <p>We regret to inform you that your account has been deactivated due to a violation of our policies and guidelines.</p>
                    <p>If you believe this is an error or wish to discuss your account status, please contact our support team.</p>
                </div>
                <div class='footer'>
                    <p>If you have any questions, please feel free to reach out to us at <b>+63 906 236 4630</b></p>
                </div>
            </div>
            </body>
            </html>
            ";
    
            // Send the email
            $mail->send();
            
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    // Send email for registering
    function registerSendEmail($accountType, $recipientEmail) {
        try {
            global $mail; 
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            // $mail->Username = 'noreply@jasdyofficesupplies.shop';
            // $mail->Password = '10kls.Smalltank';
            $mail->Username = 'jgdev101613@gmail.com';
            $mail->Password = 'bjbl usgj ajyp krqz';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    
            // Set sender and recipient
            $mail->setFrom('jgdev101613@gmail.com', 'JASDY OFFICE SUPPLIES TRADING');
            $mail->addAddress($recipientEmail);
            $mail->isHTML(true);
            $mail->Subject = "Account Registration " .  "(" . $accountType . ")";
    
            // Embed logo
            $mail->AddEmbeddedImage(__DIR__ . '/data/item_images/logowithbg.jpg', 'logo_img');
    
            // HTML Email Content
            $mail->Body = "
            <html>
            <head>
                <style>
                    body {
                        background: linear-gradient(135deg, #ffffff, #000000);
                        font-family: Arial, sans-serif;
                        color: #333333;
                        padding: 20px;
                    }
                    .email-container {
                        max-width: 600px;
                        margin: auto;
                        background: #ffffff;
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    }
                    .header {
                        text-align: center;
                        padding: 20px;
                    }
                    .header img {
                        width: 150px;
                        margin-bottom: 20px;
                    }
                    .content {
                        text-align: center;
                        font-size: 18px;
                        line-height: 1.6;
                    }
                    .code {
                        display: inline-block;
                        font-size: 24px;
                        font-weight: bold;
                        background: #000000;
                        color: #ffffff;
                        padding: 10px 20px;
                        border-radius: 5px;
                        margin-top: 20px;
                    }
                    .note {
                        text-align: center;
                    }
                    .footer {
                        margin-top: 30px;
                        font-size: 12px;
                        color: #555555;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='header'>
                        <img src='cid:logo_img' alt='System Logo'>
                        <h2>Thank you for registering!</h2>
                    </div>
                    <div class='content'>
                        <p>Your registration is currently being reviewed by our administration team. You will receive an email once your profile has been approved.</p>
                        <p>We appreciate your patience during this process.</p>
                    </div>
                    <div class='note'>
                        <p><strong>Note:</strong> Please be patient as we work to review all registrations. Thank you!</p>
                    </div>
                    <div class='footer'>
                        <p>If you have any questions, please feel free to contact us at <b>+63 906 236 4630</b></p>
                    </div>
                </div>
            </body>
            </html>
            ";
    
            // Send the email
            $mail->send();
            
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    // Send verification email for changing password
    function forgotPassword($link, $recipientEmail) {
        try {
            global $mail; 
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            // $mail->Username = 'noreply@jasdyofficesupplies.shop';
            // $mail->Password = '10kls.Smalltank';
            $mail->Username = 'jgdev101613@gmail.com';
            $mail->Password = 'bjbl usgj ajyp krqz';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    
            // Set sender and recipient
            $mail->setFrom('jgdev101613@gmail.com', 'JASDY OFFICE SUPPLIES TRADING');
            $mail->addAddress($recipientEmail);
            $mail->isHTML(true);
            $mail->Subject = "Change Password";
    
            // Embed logo
            $mail->AddEmbeddedImage('../../data/item_images/logowithbg.jpg', 'logo_img');
    
            // HTML Email Content
            $mail->Body = "
            <html>
            <head>
                <style>
                    body {
                        background: linear-gradient(135deg, #ffffff, #000000);
                        font-family: Arial, sans-serif;
                        color: #333333;
                        padding: 20px;
                    }
                    .email-container {
                        max-width: 600px;
                        margin: auto;
                        background: #ffffff;
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    }
                    .header {
                        text-align: center;
                        padding: 20px;
                    }
                    .header img {
                        width: 150px;
                        margin-bottom: 20px;
                    }
                    .content {
                        text-align: center;
                        font-size: 18px;
                        line-height: 1.6;
                    }
                    .code {
                        display: inline-block;
                        font-size: 24px;
                        font-weight: bold;
                        background: #000000;
                        color: #ffffff;
                        padding: 10px 20px;
                        border-radius: 5px;
                        margin-top: 20px;
                    }
                    .code a {
                        text-decoration: none;
                        color: #ffffff;
                    }
                    .note {
                        text-align: center;
                    }
                    .footer {
                        margin-top: 30px;
                        font-size: 12px;
                        color: #555555;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='header'>
                        <img src='cid:logo_img' alt='System Logo'>
                        <h2>Password Reset Request</h2>
                    </div>
                    <div class='content'>
                        <p>You requested to reset your password. Click the button below to proceed:</p>
                        <div class='code'>
                            <a href='{$link}'>Reset Password</a>
                        </div>
                        <p>Please note: This link will expire in 5 minutes.</p>
                    </div>
                    <div class='footer'>
                        <p>If you did not make this request, you can safely ignore this email. If you have concerns, please contact our support team immediately.</p>
                    </div>
                </div>
            </div>
            </body>
            </html>
            ";
    
            // Send the email
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    