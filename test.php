
<?php
    $login = Session::get("loginUser");
    if ($login) {
        $userId = Session::get("userId");
        $getData = $ul->getUserById($userId);
        if ($getData) {
            while ($result = $getData->fetch_assoc()) {
    ?>
<div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="invoice-title">
                    <h2>Invoice</h2>
                    <h3 class="pull-right">Order # </h3>
                </div>
                <hr>

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
                                <div class="col-xs-6 text-right">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        12/12/12<br><br>
                                    </address>
                                </div>
                <?php }}}?>
            </div>

            <div class="orderbox order my-3 bg-light" > <!-- Hide the order box initially -->
                                <table class="cart-wrapper-table"> <!-- Table to display order details -->
                                    <!-- Table headers -->
                                    <tr class="table-heading">

                                        <th>Order Date</th>
                                        <th>Items</th>
                                        <th>Unit Price</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                    </tr>

                                </table>
                                <!-- Display total quantity and sum for this order group -->

                            </div>
