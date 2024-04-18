
<?php

    $ul   	    = new User();
    $cart   	= new Cart();
    $or   	    = new Order();
?>
<?php
if(isset($_GET['statusId'])){
    if(isset($_GET['statusId']) && isset($_GET['price']) && isset($_GET['date'])){
        $userId     = $_GET['statusId'];
        $price      = $_GET['price'];
        $date       = $_GET['date'];
        $proshift   = $or->proshift($userId, $price, $date);
    }
}

if(isset($_GET['delstatusId'])){
    if(isset($_GET['delstatusId']) && isset($_GET['price']) && isset($_GET['date'])){
        $userId         = $_GET['delstatusId'];
        $price          = $_GET['price'];
        $date           = $_GET['date'];
        $delProShift    = $or->delProShift($userId, $price, $date);
    }
}
?>

<style>
#main-content{padding:30px;border-radius:15px}#main-content .h5,#main-content .text-uppercase{font-weight:600;margin-bottom:0}#main-content .h5+div,.order .rating .far,.order .rating .fas{font-size:.9rem}#main-content .box{padding:10px;border-radius:6px;width:170px;height:90px}#main-content .box img{width:40px;height:40px;object-fit:contain}#main-content .box .tag{font-size:.9rem;color:#000;font-weight:500}#main-content .box .number{font-size:1.5rem;font-weight:600}.order{padding:10px 30px;min-height:150px}.order .order-summary{height:100%}.order .blue-label{background-color:#aeaeeb;color:#0046dd;font-size:.9rem;padding:0 3px;width:fit-content;margin-bottom:10px!important}.order .green-label{background-color:#a8e9d0;color:#008357;font-size:.9rem;padding:0 3px}.order .fs-8{font-size:.85rem}.order .rating img{width:20px;height:20px;object-fit:contain}.order .rating .fas{color:#daa520}.order .status{font-weight:600}.order .btn.btn-primary{background-color:#fff;color:#4e2296;border:1px solid #4e2296}.order .btn.btn-primary:hover{background-color:#4e2296;color:#fff}.order .progressbar-track{margin-top:20px;margin-bottom:20px;position:relative}.order .progressbar-track .progressbar{list-style:none;display:flex;align-items:center;justify-content:space-between;padding-left:0}.order .progressbar-track .progressbar li{font-size:1.5rem;border:1px solid #333;padding:5px 10px;border-radius:50%;background-color:#ddd;z-index:100;position:relative}.order .progressbar-track .progressbar li.green{border:1px solid #007965;background-color:#d5e6e2}.order .progressbar-track .progressbar li::after{position:absolute;font-size:.9rem;top:50px;left:0}#tracker{position:absolute;border-top:1px solid #bbb;width:100%;top:25px}#step-1::after{content:'Placed'}#step-2::after{content:'Accepted';left:-10px}#step-3::after{content:'Packed'}#step-4::after{content:'Shipped'}#step-5::after{content:'Delivered';left:-10px}.bg-purple{background-color:#55009b}.bg-light{background-color:#f0ecec!important}.green{color:#007965!important}@media(max-width:1199.5px){nav ul li{padding:0 10px}}@media(max-width:500px){.order .progressbar-track .progressbar li{font-size:1rem}.order .progressbar-track .progressbar li::after{font-size:.8rem;top:35px}#tracker{top:20px}}@media(max-width:440px){#main-content,.order{padding:20px}#step-4::after{left:-5px}}@media(max-width:395px){.order .progressbar-track .progressbar li{font-size:.8rem}.order .progressbar-track .progressbar li::after{font-size:.7rem;top:35px}#tracker{top:15px}.order .btn.btn-primary{font-size:.85rem}}@media(max-width:355px){#main-content{padding:15px}.order{padding:10px}}.my-4{margin-top:1.5rem!important;margin-bottom:1.5rem!important}.flex-wrap{flex-wrap:wrap!important;gap:30px}.d-flex{display:flex!important}.bg-white{background-color:#fff!important}.border{border:1px solid #dee2e6!important}.mt-2{margin-top:.5rem!important}.align-items-center{align-items:center!important;justify-content:space-between}.flex-column{flex-direction:column}.my-3{margin-top:1.3rem}.justify-content-between{justify-content:space-between}.fs-12{width:330px;text-align:left}.custom-box-1{width:40%;max-width:100%}.custom-box-1 span{display:grid;grid-template-columns:1fr 1fr}.custom-box-1 strong{color:#666}.custom-box-2{width:60%;max-width:100%;flex-direction:column-reverse}.flex-row{align-items:center}
.order.my-3.bg-light {border: 1px solid #0019ff;border-radius: 10px;grid-column-end: span 2 !important;width: 80% !important;margin-left:  auto !important;}.custom-box-2 div {margin-left: auto;}.orderbox {margin-bottom: 15px;}.cart-wrapper-table {width: 100%;}.cart-wrapper-table.tbody tr {display: flex;justify-content: space-between !important;}
.payable-amount > span {display: flex;justify-content: space-between;width: 300px;margin-left: auto;margin-top: 5px;}.payable-amount {margin-top: 5px;}
.msg {color: green;font-size: 18px;font-weight: bold;text-align: center;display: block;margin: 10px;}.order-box-alt {display: grid;grid-template-columns: 1fr 1fr;margin-bottom: 20px;}h3 {text-transform:capitalize;letter-spacing:1px;}h3 span{color: #914e4e;font-size: 13px;letter-spacing: 0.2em;}.view-order-btn {width: 150px !important;transition: all 0.3s;}.order-items ul {padding: 0;list-style-type: disclosure-closed;}
.order-items ul li::marker {color: #914E4E;}
</style>
<div id="colorlib-contact">
    <div class="container">
        <div class="row">
            <div class="main-dashboard">
                <div class="order-items">
                    <?php
                    if(isset($proshift)){
                        echo $proshift;
                    }
                    ?>
                    <?php
                    if(isset($delProShift)){
                        echo $delProShift;
                    }
                    ?>

                    <?php
                    // Initialize an array to store orders grouped by their IDs
                    $orderGroups = [];
                    $getOrder = $or->getAllorder();
                    // Custom counter variable for order group ID
                    $orderIdCounter = 1;
                    // Group orders by their unique order IDs
                    if ($getOrder) {
                        while ($result = $getOrder->fetch_assoc()) {
                            $orderId = $result['order_grp_id']; // Assuming 'order_grp_id' is the unique identifier for order groups
                            $orderGroups[$orderId][] = $result;
                        }
                    }
                    ?>
            <ul>
                    <!-- Display order details grouped by order group IDs -->
                    <?php
                    foreach ($orderGroups as $orderId => $orders) {
                    ?>

                    <li><div class="order-box-alt"> <!-- Add ID with Order Group ID -->
                        <h3>Order Group ID: <span><?php echo $orderId; ?><spaan></h3>
                        <button class="view-order-btn" data-order-id="<?php echo $orderId; ?>">View Order Details</button> <!-- Add "View Order" button -->
                            <div class="orderbox order my-3 bg-light" style="display: none;"> <!-- Hide the order box initially -->
                                <table class="cart-wrapper-table"> <!-- Table to display order details -->
                                    <!-- Table headers -->
                                    <tr class="table-heading">
                                        <th>Sl.No.</th>
                                        <!-- <th>User Details</th> -->
                                        <th>Order Date</th>
                                        <th>Product Name</th>
                                        <th>Product Quantity</th>
                                        <th>Total Price</th>
                                        <th>Action</th>
                                    </tr>
                                    <!-- Table data -->
                                    <?php
                                    $i = 0;
                                    $sum = 0; // Initialize the total sum outside the loop
                                    foreach ($orders as $order) {
                                        $i++;
                                        $total = $order["proPrice"] * $order["quantity"]; // Calculate total for each order
                                        $sum += $total; // Accumulate the total sum
                                    ?>
                                    <tr class="table-data">
                                        <td><?= $i ?></td>
                                        <!-- <td> <a class='info-btn' href="userlist?userId=<?php echo $order['userId'];?>"><i class="bi bi-info-circle"></i></a></td> -->
                                        <td><?= $fm->formatDate($order["date"]) ?></td>
                                        <td> <a href="../product.php?proId=<?php echo $order['productId'];?>"><?php echo $order['productName'];?> </a></td>
                                        <td><?= $order["quantity"] ?></td>
                                        <td>$<?= number_format((float)($order["proPrice"] * $order["quantity"]), 2, '.', '') ?></td>
                                        <?php
                                        if($order['status'] == '0'){?>
                                        <td><a href="?statusId=<?php echo $order['userId'];?>&price=<?php echo $order['proPrice'];?>&date=<?php echo $order['date'];?>"><i>Shifted</i></a></td>
                                        <?php } else {?>
                                        <td class="acction-button">
                                            <a class="delete-item" href="?delstatusId=<?php echo $order['userId'];?>&price=<?php echo $order['proPrice'];?>&date=<?php echo $order['date'];?>">Remove</a>
                                        </td>
                                        <?php }?>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                                <!-- Display total quantity and sum for this order group -->
                                <div class="payable-amount" style="margin-top: 10px"> <!-- Payable amount section -->
                                    <span>
                                        <span class="amount-heading">Total Quantity :</span>
                                        <span class="final-amount"><?= count($orders) ?></span>
                                    </span>
                                    <span>
                                        <span class="amount-heading">Sub Total :</span>
                                        <span class="final-amount">$<?php  echo number_format((float)$sum, 2, '.', '')?></span>
                                    </span>
                                    <span>
                                        <span class="amount-heading">VAT :</span>
                                        <span class="final-amount">15%</span>
                                    </span>
                                    <span>
                                        <span class="amount-heading">Grand Total :</span>
                                        <span class="final-amount">$<?php
                                            $vat = $sum * 0.15;
                                            $grandTotal = $sum + $vat;
                                            echo number_format($grandTotal, 2);?>
                                        </span>
                                    </span>
                                </div>
                            </div>
                    </div></li>
                <?php
                }
                ?>
            </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// JavaScript code to handle the click event on the "View Order" button
document.addEventListener('DOMContentLoaded', function () {
    var viewOrderBtns = document.querySelectorAll('.view-order-btn');

    viewOrderBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var orderbox = this.nextElementSibling;

            if (orderbox.style.display === 'none') {
                orderbox.style.display = 'block';
            } else {
                orderbox.style.display = 'none';
            }
        });
    });
});
</script>
