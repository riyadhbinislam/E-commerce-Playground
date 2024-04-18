<?php

 // Include necessary files and initialize objects
 include 'inc/breadcrumbs.php';
 include_once "classes/user.php";
 error_reporting(E_ALL);
 $or = new Order();
 $or = new Order();
 $userId = Session::get("userId");

    // Initialize an array to store orders grouped by their IDs
    $orderGroups = [];
    $getOrder = $or->getAllorder();
    // Custom counter variable for order group ID
    $orderIdCounter = 1;
    // Group orders by their unique order IDs
    if ($getOrder) {
        while ($result = $getOrder->fetch_assoc()) {
            $orderId = $result['order_grp_id'];
            $orderGroups[$orderId][] = $result;
        }
    }
?>

<style>
    .invoice-title h2,
    .invoice-title h3 {
        display: inline-block;
    }

    .table>tbody>tr>.no-line {
        border-top: none;
    }

    .table>thead>tr>.no-line {
        border-bottom: none;
    }

    .table>tbody>tr>.thick-line {
        border-top: 2px solid;
    }
    .grand-total,
    .sub > span {
    display: grid;
    grid-template-columns: 1fr 1fr;
    }

    .payable-amount {
        max-width: 400px;
        width: 100%;
        float: right;
        text-align: right;
        padding: 0;
    }

    .grand-total {
        margin-top: 15px;
        padding-top: 10px;
        border-top: 2px solid #d8d8d8;
    }

    @media print{
        aside#colorlib-hero,
        div#colorlib-subscribe,
        footer#colorlib-footer,
        nav.colorlib-nav,
        form {
            display: none;
        }
        .invoice-title h2,
        .invoice-title h3 {
            font-size: 18px;
        }
    }
</style>


    <div class="container">
        <div id="printableArea">
            <div class="row">
                <div class="col-xs-12">
                    <div class="invoice-title">
                        <h2>Invoice</h2>
                        <h3 class="pull-right">Order ID #<?php  if (isset($_GET['ordergrpid'])) {
                                                                $ordergrpid = $_GET["ordergrpid"];
                                                                echo $ordergrpid;}?></h3>
                    </div>
                    <hr>
                    <?php
                    $login = Session::get("loginUser");
                    if ($login) {
                        $userId = Session::get("userId");
                        $getData = $ul->getUserById($userId);
                        if ($getData) {
                            while ($result = $getData->fetch_assoc()) {
                    ?>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <address>
                                            <strong>Billed To:</strong><br>
                                            <?= $result["userFullName"] ?><br>
                                            <?= $result["userAddress"] ?><br>
                                            <?= $result["userCity"] ?><br>
                                            <?= $result["userState"] ?>, <?= $result["userZipCode"] ?>
                                        </address>
                                    </div>
                                    <div class="col-xs-6 text-right">
                                        <address>
                                            <strong>Shipped To:</strong><br>
                                            <?= $result["userFullName"] ?><br>
                                            <?= $result["userAddress"] ?><br>
                                            <?= $result["userCity"] ?><br>
                                            <?= $result["userState"] ?>, <?= $result["userZipCode"] ?>
                                        </address>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6">
                                        <address>
                                            <strong>Payment Method:</strong><br>
                                            Cash On Delivery<br>
                                            <?= $result["userEmail"] ?>
                                        </address>
                                    </div>
                                </div>
                                    <?php }}}?>


                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Order summary</strong></h3>
                        </div>

                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr class="table-heading">
                                            <th>Order Date</th>
                                            <th>Items</th>
                                            <th>Unit Price</th>
                                            <th>Quantity</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sum = 0;
                                                if (isset($_GET['ordergrpid'])) {
                                                    $ordergrpid = $_GET["ordergrpid"];
                                                    $query = "SELECT * FROM tbl_order WHERE order_grp_id='$ordergrpid' ORDER BY date DESC";
                                                    $invoice = $db->select($query);

                                                    $sum= 0;
                                                if ($invoice && $invoice->num_rows > 0) {
                                                while ($invoiceresult = $invoice->fetch_assoc()) {
                                                    $sum += $invoiceresult['proPrice'] * $invoiceresult['quantity'];

                                            ?>
                                            <tr>
                                                <td><?php echo $fm->formatDate($invoiceresult['date']) ;?></td>
                                                <td><?php echo $invoiceresult['productName']; ?></td>
                                                <td class="text-center"><?php echo $invoiceresult['proPrice']; ?></td>
                                                <td class="text-center"><?php echo $invoiceresult['quantity']; ?></td>
                                                <td class="text-right">$<?php echo number_format((float)$invoiceresult['proPrice'] * $invoiceresult['quantity'], 2); ?></td>
                                            </tr>

                                        <?php } }}?>

                                    </tbody>
                                </table>
                                <div class="payable-amount col-md-5"> <!-- Payable amount section -->
                                    <div   div class="sub"> <!-- Payable amount section -->

                                        <span>
                                            <span class="amount-heading">Sub Total :</span>
                                            <span class="final-amount">$<?php  echo number_format((float)$sum, 2, '.', '')?></span>
                                        </span>
                                        <span>
                                            <span class="amount-heading">VAT :</span>
                                            <span class="final-amount">15%</span>
                                        </span>
                                    </div>
                                    <div class="grand-total">
                                            <span class="amount-heading">Grand Total :</span>
                                                <span class="final-amount">$<?php
                                                $vat = $sum * 0.15;
                                                $grandTotal = $sum + $vat;
                                                echo number_format($grandTotal, 2);?>
                                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <form action="invoicepdf" method="post">
                                    <input type="hidden" name="ordergrpid" value="<?php echo isset($_GET['ordergrpid']) ? $_GET['ordergrpid'] : ''; ?>">
                                    <button type="submit" class="btn btn-primary">Download Invoice as PDF</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="button" onclick="printDiv('printableArea')" value="Print Invoice" />




<script>
        function printDiv(printableArea) {
     var printContents = document.getElementById(printableArea).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>