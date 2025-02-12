<?php
    session_start();
    require_once('../../inc/config/constants.php');
    require_once('../../inc/config/db.php');
    require_once('../audit/insertAudit.php');
    $id = $_GET["id"];

    $fullName = '';
    $email = '';
    $mobile = '';
    $phone = '';
    $phone2 = '';
    $address = '';
    $adress2 = '';
    $city = '';
    $district = '';

    $getItemDetailsQuery = 'SELECT * FROM customer WHERE customerID = :customerID';
    $getItemDetailsStatment = $conn->prepare($getItemDetailsQuery);
    $getItemDetailsStatment->execute([
        'customerID' => $id
    ]);

    $row = null;
    if ($getItemDetailsStatment->rowCount() > 0) {
        $row = $getItemDetailsStatment->fetch(PDO::FETCH_ASSOC);
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

    <link rel="stylesheet" href="../../vendor/bootstrap/css/cerulean.theme.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- MATERIAL CDN -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp">
    
    <link rel="icon" type="image/png" href="../../data/item_images/logowithbg.jpg">
    <!-- ===== CUSTOM STYLE ===== -->
    <link href="../../assets/css/shop-styles.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/loadingMessage.css">
    <title>JOST System</title>
</head>

<body>
    <div id="loadingMessage" class="loading-message" style="display: none;">
		<div class="spinner"></div>
		<p>Please wait, processing...</p>
	</div>
    <nav class="navbar navbar-expand-lg fixed-top"> 
        <div class="container">
            <img src="../../data/item_images/logo.png" width="100px" height="32px" style="margin-right: 10px;">
            <a class="navbar-brand" href="index.php">WRAP <b>IT</b></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="material-icons-sharp">menu</span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <!-- <li class="nav-item">
                        <form class="form-inline" action="/action_page.php">
                            <input class="form-control col-md-8 mr-sm-2" type="text" placeholder="Search">
                            <button class="btn btn-success" type="submit">Search</button>
                        </form>
                    </li> -->
                    <li class="nav-item">
                    <?php 
                    $usertype = "";
                    if ($_SESSION['usertype'] === 'Admin') {
                        $usertype = "ADMIN";
                    } elseif ($_SESSION['usertype'] === 'Reseller') {
                        $usertype = "RESELLER";
                    } elseif ($_SESSION['usertype'] === 'Employee') {
                        $usertype = "EMPLOYEE";
                    }
                    ?>
                    <span class="nav-link">Hey, <?php echo $_SESSION['fullName'] . " <small>" . $usertype . "</small> "; ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <div style="position: fixed;top: 4rem;right: 0; margin: 1rem; z-index: 1000; box-shadow: 0 2rem 3rem var(--color-light);">
        <a href="../../dashboard.php" class="btn btn-theme"><i class="fa-solid fa-chevron-left"></i> Go Back</a>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center">Edit Customer Info</h5>
                <h6 class="card-subtitle mb-2 text-muted text-center">Editing Customer <small>(CID: <span id="customerID"><?php echo $row['customerID'];?></span>)</small></h6>
                <div id="message"></div>
                <div class="row">
                    <div class="col-sm-6 mt-2">
                        <label class="form-label">Full Name</label>
                        <input placeholder="Full Name" type="text" class="form-control" name="customerDetailsFullName" id="customerDetailsFullName" value="<?php echo $row['fullName'] ?? "" ; ?>">
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label class="form-label">Email</label>
                        <input placeholder="Email" type="text" class="form-control" name="customerDetailsEmail" id="customerDetailsEmail" value="<?php echo $row['email'] ?? "" ; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 mt-2">
                        <label class="form-label">Primary Phone No.</label>
                        <input placeholder="Primary Phone No." type="text" class="form-control" name="customerDetailsPhone" id="customerDetailsPhone" value="<?php echo $row['mobile'] ?? "" ; ?>">
                    </div>
                    <div class="col-sm-3 mt-2">
                        <label class="form-label">Secondary Phone No.</label>
                        <input placeholder="Secondary Phone No." type="text" class="form-control" name="customerDetailsPhone2" id="customerDetailsPhone2" value="<?php echo $row['phone2'] ?? "" ; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8 mt-2">
                        <label class="form-label">Primary Address</label>
                        <input placeholder="Primary Address" type="text" class="form-control" name="customerDetailsAddress" id="customerDetailsAddress" value="<?php echo $row['address'] ?? "" ; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8 mt-2">
                        <label class="form-label">Secondary Address</label>
                        <input placeholder="Secondary Address" type="text" class="form-control" name="customerDetailsAddress2" id="customerDetailsAddress2" value="<?php echo $row['address2'] ?? "" ; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 mt-2">
                        <label class="form-label">City</label>
                        <input placeholder="City" type="text" class="form-control" name="customerDetailsCity" id="customerDetailsCity" value="<?php echo $row['city'] ?? "" ; ?>">
                    </div>
                    <div class="col-sm-3 mt-2">
                        <label class="form-label">District</label>
                        <input placeholder="District" type="text" class="form-control" name="customerDetailsDistrict" id="customerDetailsDistrict" value="<?php echo $row['district'] ?? "" ; ?>">
                    </div>
                    <div class="col-sm mt-2">
                        <label class="form-label">Created On <small>(Date this customer is added)</small></label>
                        <input placeholder="Created On" readonly type="text" class="form-control" name="customerDetailsCreatedOn" id="customerDetailsCreatedOn" value="<?php echo $row['createdOn'] ?? "" ; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-10 mt-4">
                        <button id="customerUpdateBtn" class="btn btn-success">Update</button>
                        <button id="customerDeleteBtn" class="btn btn-danger">Delete</button>
                    </div>
                </div>
        </div>
    </div>
    
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>           
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../vendor/bootbox/bootbox.min.js"></script>
    <script src="../../assets/js/management.js" ></script>    
</body>

</html>