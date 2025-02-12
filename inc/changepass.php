<?php
    require_once('config/constants.php');
    require_once('config/db.php');
    $token = $_GET['token'];

    $getUserSQL = 'SELECT * FROM user where reset_token = :reset_token LIMIT 1';
    $getUserStatement = $conn->prepare($getUserSQL);
    $getUserStatement->execute(['reset_token' => $token]);

    $row = $getUserStatement->fetch(PDO::FETCH_ASSOC);

    if ($row <= 0) {
        $userID = $row['userID'] ?? 'No user';
    } else {
        $userID = $row['userID'];
    }

    $checkTokenExpireSQL = "SELECT * FROM user WHERE reset_token = :reset_token AND reset_expires > NOW()";
    $checkTokenExpireStatement = $conn->prepare($checkTokenExpireSQL);
    $checkTokenExpireStatement->execute([
        'reset_token' => $token
    ]);

    // Check if there is a valid token
    if ($checkTokenExpireStatement->rowCount() <= 0) {
        // Token is invalid or expired
        // Redirect to a custom "Token Expired" page
        header("Location: 404.html");
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="stylesheet" href="../vendor/bootstrap/css/cerulean.theme.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- MATERIAL CDN -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp">
    <!-- ===== CUSTOM STYLE ===== -->
    <link href="../assets/css/shop-styles.css" rel="stylesheet">
    <title>Jasdy Office Supplies and Trading</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top"> 
        <div class="container">
            <img src="../data/item_images/logo.png" width="100px" height="32px" style="margin-right: 10px;">
            <a class="navbar-brand" href="index.php">WRAP <b>IT</b></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="material-icons-sharp">menu</span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <span class="nav-link">Hey, <b><?php echo $row['username'];?></b></span>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <div class="container">
        <div class="text-center mb-4">
            <h3>Change Password</h3>
            <p class="text-muted">Change password for <?php echo ucwords($row['fullName'] ?? "") . "<small>" . " (ID: " . "<span id='userID'>"  . $userID . "</span>" . ")" . "</small>"; ?></p>
        </div>

        <div class="container d-flex justify-content-center">
            <form method="POST" style="width:55vw; min-width:300px;">
                <div id="changePass"></div>
                <div class="row">
                    <div class="col mt-2">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" name="userDetailsUserPassword1" id="userDetailsUserPassword1">
                    </div>
                    <div class="col mt-2">
                        <label class="form-label">Retype New Password</label>
                        <input type="password" class="form-control" name="userDetailsUserPassword2" id="userDetailsUserPassword2">
                    </div>
                <div>
                <br>
                <input type="button" id="changePassBtn" value="Change Password" class="btn btn-primary">
            </form>
        </div>

    </div>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>           
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/bootbox/bootbox.min.js"></script>
    <script src="../assets/js/login.js"></script>    
</body>

</html>