<?php

    require_once('config/constants.php');
    require_once('config/db.php');

    $saleDetailsSearchSql = 'SELECT itemName, quantity FROM sale';
    $saleDetailsSearchStatement = $conn->prepare($saleDetailsSearchSql);
    $saleDetailsSearchStatement->execute();

    $salesData = [];


    while($row = $saleDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)) {
        $salesData[] = [$row['itemName'], (int)$row['quantity']];
    }   

    // Convert PHP array to JSON
    $jsonData = json_encode($salesData);

        