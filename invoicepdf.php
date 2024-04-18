<?php
// Include necessary files and initialize objects
require_once 'fpdf/fpdf.php'; // Include FPDF library
include_once "config/config.php";
include_once "lib/Database.php";
include_once "lib/Session.php"; // Include Session class
include_once "classes/user.php";
include_once "classes/order.php";

// Initialize session
Session::init();

$db = new Database();
$or = new Order();
$ul = new User();

// Check if ordergrpid is set
if (isset($_POST['ordergrpid'])) {
    // Get the order group ID
    $ordergrpid = $_POST['ordergrpid'];

    // Fetch invoice data from the database
    $query = "SELECT * FROM tbl_order WHERE order_grp_id='$ordergrpid' ORDER BY date DESC";
    $invoice = $db->select($query);
    $invoiceresult = $invoice->fetch_all(MYSQLI_ASSOC);

    // Initialize FPDF object
    $pdf = new FPDF();
    $pdf->AddPage();

    // Add content to PDF
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->Cell(0, 10, 'Invoice', 0, 1, 'C');

    // Get customer details from session
    $login = Session::get("loginUser");
    if ($login) {
        $userId = Session::get("userId");
        $getData = $ul->getUserById($userId);
        $result = $getData->fetch_assoc();

        // Get customer details
        $customerName   = $result["userFullName"];
        $address        = $result["userAddress"];https://playground.r3al.win/invoice?ordergrpid=660bce1081b71
        $city           = $result["userCity"];
        $state          = $result["userState"];
        $email          = $result["userEmail"];
        $phone          = $result["userPhoneNumber"];
        $company        = $result["userCompanyName"];

        // Add customer details to PDF
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Customer Name: ' . $customerName, 0, 1);
        $pdf->Cell(0, 10, 'Address: ' . $address . ', ' . $city . ', ' . $state, 0, 1);
        $pdf->Cell(0, 10, 'Email: ' . $email, 0, 1);
        $pdf->Cell(0, 10, 'Phone: ' . $phone, 0, 1);
        $pdf->Cell(0, 10, 'Company: ' . $company, 0, 1);
        $pdf->Ln();

        // Add order summary header
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20, 10, 'SN.', 1);
        $pdf->Cell(40, 10, 'Product Name', 1);
        $pdf->Cell(30, 10, 'Unit Price', 1);
        $pdf->Cell(20, 10, 'Quantity', 1);
        $pdf->Cell(40, 10, 'Total', 1);
        $pdf->Ln();

        // Loop through invoice items and add to PDF
        $totalAmount = 0;
        $vat = 0.15; // VAT percentage (assuming 15%)
        $i = 1; // Initialize the counter
        foreach ($invoiceresult as $item) {
            $pdf->Cell(20, 10, $i++, 1); // Increment and display the counter
            $pdf->Cell(40, 10, $item['productName'], 1);
            $pdf->Cell(30, 10, '$' . $item['proPrice'], 1);
            $pdf->Cell(20, 10, $item['quantity'], 1);
            $total = $item['proPrice'] * $item['quantity'];
            $pdf->Cell(40, 10, '$' . number_format($total, 2), 1);

            $pdf->Ln();
            $totalAmount += $total;
            $payable = $total * (1 + $vat); // Calculate payable amount including VAT
        }

        $pdf->Ln();
        // Add total amount, VAT, and payable amount
        $pdf->Cell(0, 10, 'Total Amount: $' . number_format($totalAmount, 2), 0, 1);
        $pdf->Cell(0, 10, 'VAT: ' . number_format($vat * 100, 2) . '%', 0, 1);
        $pdf->Cell(0, 10, 'Total Payable Amount: $' . number_format($totalAmount * (1 + $vat), 2), 0, 1);

        // Output PDF for download
        $pdf->Output('D', 'Invoice.pdf');
        exit;
    }else{
        // Redirect back to the invoice page if ordergrpid is not set
        echo '<meta http-equiv="refresh" content="0;url=profile">';
        exit;
    }
}



