<?php
require_once('inc/config/constants.php');
require_once('inc/config/db.php');
include_once('tcpdf/tcpdf.php');

$invoiceNum = $_GET['invID'];

// Fetch sale and customer details
$saleDetailsSearchSql = 'SELECT sale.saleID, 
    sale.customerID, 
    sale.sellerID, 
    sale.customerID, 
    sale.saleDate,
    sale.payment,
    customer.customerID,
    customer.fullName,
    customer.mobile,
    order_items.orderID,
    order_items.saleID,
    order_items.itemNumber,
    order_items.quantity,
    order_items.unitPrice,
    user.userID,
    user.usertype,
    user.fullName AS sellerFullName,
    item.itemNumber,
    item.description
    FROM sale
    JOIN customer ON sale.customerID = customer.customerID
    JOIN order_items ON sale.saleID = order_items.saleID
    JOIN user ON sale.sellerID = user.userID
    JOIN item ON order_items.itemNumber = item.itemNumber
    WHERE sale.saleID = :saleID';
$saleDetailsSearchStatement = $conn->prepare($saleDetailsSearchSql);
$saleDetailsSearchStatement->execute(['saleID' => $invoiceNum]);

if ($saleDetailsSearchStatement->rowCount() > 0) {
    // Fetch sale details
    $rows = $saleDetailsSearchStatement->fetchAll(PDO::FETCH_ASSOC);
    $customerName = $rows[0]['fullName'];
    $customerMobile = $rows[0]['mobile'];
    $invoiceDate = date("d-m-Y", strtotime($rows[0]['saleDate']));
    $paymentMode = $rows[0]['payment'];
    $sellerName = $rows[0]['sellerFullName']; 
    $sellerID = $rows[0]['userID'];   
    $usertype = $rows[0]['usertype'];
    $tpye = null;

    if ($usertype == 'Admin') {
        $type = 'Admin';
    } else if ($usertype == 'Employee') {
        $type = 'Employee';
    } else {
        $type = 'Seller';
    }

    // Initialize TCPDF
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);  
	//$pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
	$pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
	$pdf->SetDefaultMonospacedFont('helvetica');  
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
	$pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
	$pdf->setPrintHeader(false);  
	$pdf->setPrintFooter(false);  
	$pdf->SetAutoPageBreak(TRUE, 10);  
	$pdf->AddPage(); //default A4
	//$pdf->AddPage('P','A5'); //when you require custome page size 

    $content .= '
    <style type="text/css">
        body {
            font-size: 14px;
            line-height: 1.6;
            font-family: "Poppins";
            color: #333;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }
        .invoice-header {
            text-align: center;
            padding: 10px 0;
        }
        .invoice-header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .invoice-header p {
            margin: 5px 0;
            color: #666;
        }
        .invoice-details, .invoice-footer {
            width: 100%;
            margin-top: 20px;
            border-top: 2px solid #eee;
            padding-top: 10px;
        }
        .invoice-details td {
            padding: 5px 10px;
            vertical-align: top;
        }
        .invoice-details td.label {
            font-weight: bold;
            color: #555;
        }
        .items-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .items-table th, .items-table td {
            padding: 10px;
            border: 1px solid #eee;
            text-align: left;
        }
        .items-table th {
            background: #f8f8f8;
            color: #333;
            font-weight: bold;
        }
        .items-table .total-row td {
            font-weight: bold;
            border-top: 2px solid #ddd;
            font-size: 16px;
        }
        .invoice-footer {
            text-align: center;
            color: #777;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>

    <div class="invoice-container">
        <div class="invoice-header">
            <h1>Jasdy Office Supplies Trading</h1>
            <p>Contact No: +63 123 4567 890 | Website: jasdyofficesupplies.shop</p>
            <p><strong>Invoice</strong></p>
        </div>

        <table class="invoice-details">
            <tr>
                <td class="label">Customer Name:</td>
                <td style="text-align:right;">'.$customerName.'</td>
                <td class="label">Invoice Date:</td>
                <td style="text-align:right;">'.date("d-m-Y").'</td>
            </tr>
            <tr>
                <td class="label">Mobile No:</td>
                <td style="text-align:right;">'.$customerMobile.'</td>
                <td class="label">Invoice No:</td>
                <td style="text-align:right;">'.$_GET['invID'].'</td>
            </tr>
            <tr>
                <td class="label">' . '<span style="text-transform: uppercase; font-weight: bold;">' . $type . '\'s Name</span> ' . '</td>
                <td style="text-align:right;">' . $sellerName . '</td>
                <td class="label">Seller ID:</td>
                <td style="text-align:right;">' . $sellerID . '</td>
            </tr>
        </table>

        <table class="items-table">
            <tr>
                <th>Items</th>
                <th style="text-align:right;">Amount</th>
            </tr>';

    $grandTotal = 0;

    foreach ($rows as $row) {
        $itemNumber = $row['itemNumber'];
        $quantity = $row['quantity'];
        $unitPrice = $row['unitPrice'];
        $description = $row['description'];
        $totalPrice = $quantity * $unitPrice;
        $grandTotal += $totalPrice;

        $content .= '
        <tr>
            <td>
                <strong>'.$itemNumber . ' (' . $quantity . 'x <small>'. number_format($unitPrice, 2) .'</small>)</strong>
                <br>
                <span style="color: #888; font-size: 12px;">'. $description .'</span>
            </td>
            <td style="text-align:right;">PHP '.number_format($totalPrice, 2).'</td>
        </tr>';
    }

    $content .= '
    <tr class="total-row">
            <td style="text-align:right;">GRAND TOTAL:</td>
            <td style="text-align:right;">PHP '.number_format($grandTotal, 2).'</td>
    </tr>';

    $content .= '
        </table>
        <div class="invoice-footer">
            <p><strong>Thank you for your business!</strong></p>
            <p style="color: #616161; font-size: 10rem;">For inquiries, contact us at +63 123 4567 890 or visit our website.</p>
        </div>
    </div>';

    $pdf->writeHTML($content);

    $datetime = date('dmY_hms');
    $file_name = "Receipt_" . $datetime . ".pdf";
    ob_end_clean();

    if ($_GET['ACTION'] == 'VIEW') {
        $pdf->Output($file_name, 'I'); // Inline view
    }
} else {
    echo 'No records found for this invoice.';
}
?>
