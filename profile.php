<?php include  'inc/breadcrumbs.php';
    include_once "classes/user.php";
    include_once "classes/cart.php";
    $ul   	    = new User();
    $cart   	= new Cart();
?>

<style>
#main-content{padding:30px;border-radius:15px}#main-content .h5,#main-content .text-uppercase{font-weight:600;margin-bottom:0}#main-content .h5+div,.order .rating .far,.order .rating .fas{font-size:.9rem}#main-content .box{padding:10px;border-radius:6px;width:170px;height:90px}#main-content .box img{width:40px;height:40px;object-fit:contain}#main-content .box .tag{font-size:.9rem;color:#000;font-weight:500}#main-content .box .number{font-size:1.5rem;font-weight:600}.order{padding:10px 30px;min-height:150px}.order .order-summary{height:100%}.order .blue-label{background-color:#aeaeeb;color:#0046dd;font-size:.9rem;padding:0 3px;width:fit-content;margin-bottom:10px!important}.order .green-label{background-color:#a8e9d0;color:#008357;font-size:.9rem;padding:0 3px}.order .fs-8{font-size:.85rem}.order .rating img{width:20px;height:20px;object-fit:contain}.order .rating .fas{color:#daa520}.order .status{font-weight:600}.order .btn.btn-primary{background-color:#fff;color:#4e2296;border:1px solid #4e2296}.order .btn.btn-primary:hover{background-color:#4e2296;color:#fff}.order .progressbar-track{margin-top:20px;margin-bottom:20px;position:relative}.order .progressbar-track .progressbar{list-style:none;display:flex;align-items:center;justify-content:space-between;padding-left:0}.order .progressbar-track .progressbar li{font-size:1.5rem;border:1px solid #333;padding:5px 10px;border-radius:50%;background-color:#ddd;z-index:100;position:relative}.order .progressbar-track .progressbar li.green{border:1px solid #007965;background-color:#d5e6e2}.order .progressbar-track .progressbar li::after{position:absolute;font-size:.9rem;top:50px;left:0}#tracker{position:absolute;border-top:1px solid #bbb;width:100%;top:25px}#step-1::after{content:'Placed'}#step-2::after{content:'Accepted';left:-10px}#step-3::after{content:'Packed'}#step-4::after{content:'Shipped'}#step-5::after{content:'Delivered';left:-10px}.bg-purple{background-color:#55009b}.bg-light{background-color:#f0ecec!important}.green{color:#007965!important}@media(max-width:1199.5px){nav ul li{padding:0 10px}}@media(max-width:500px){.order .progressbar-track .progressbar li{font-size:1rem}.order .progressbar-track .progressbar li::after{font-size:.8rem;top:35px}#tracker{top:20px}}@media(max-width:440px){#main-content,.order{padding:20px}#step-4::after{left:-5px}}@media(max-width:395px){.order .progressbar-track .progressbar li{font-size:.8rem}.order .progressbar-track .progressbar li::after{font-size:.7rem;top:35px}#tracker{top:15px}.order .btn.btn-primary{font-size:.85rem}}@media(max-width:355px){#main-content{padding:15px}.order{padding:10px}}.my-4{margin-top:1.5rem!important;margin-bottom:1.5rem!important}.flex-wrap{flex-wrap:wrap!important;gap:30px}.d-flex{display:flex!important; align-items:center}.bg-white{background-color:#fff!important}.border{border:1px solid #dee2e6!important}.mt-2{margin-top:.5rem!important}.align-items-center{align-items:center!important;justify-content:space-between}.flex-column{flex-direction:column}.my-3{margin-top:1.3rem}.justify-content-between{justify-content:space-between}.fs-12{width:330px;text-align:left}.custom-box-1{width:40%;max-width:100%}.custom-box-1 span{display:grid;grid-template-columns:1fr 1fr;width: 100%;}.custom-box-1 strong{color:#666}.custom-box-2{width:60%;max-width:100%;flex-direction:column-reverse}.flex-row{align-items:center}
.order.my-3.bg-light {border: 1px solid #0019ff;border-radius: 10px;}.custom-box-2 div {margin-left: auto;}
a.invoice-btn {
    border: 1px solid #FFC300;
    margin-left: 20px;
    padding: 5px 10px;
    color: black;
    float: right;
}
</style>

<div id="colorlib-contact">
    <div class="container">
        <div class="row">
        <?php
        $login = Session::get("loginUser");
        if($login){
            $userId = Session::get("userId");
            $getData = $ul->getUserById($userId);
            if($getData) {
                while ($result = $getData->fetch_assoc()) {
        ?>
            <div class="col-lg-12 my-lg-0 my-1">
                <div id="main-content" class="bg-white border">
                    <div class="d-flex flex-column">
                        <div class="h2">Hello <?= ucwords($result["userFullName"]) ?>,</div>
                        <div>Logged in as: <?= $result["userEmail"]; ?></div>
                    </div>
                    <div class="d-flex flex-row">
                        <div class="d-flex flex-column my-4 custom-box-1">
                            <span><strong>User FirstName</strong>: <?= $result["userFirstName"] ?></span>
                            <span><strong>User LastName</strong>: <?= $result["userLastName"]; ?></span>
                            <span><strong>User Email</strong>: <?= $result["userEmail"]; ?></span>
                            <span><strong>User PhoneNumber</strong>: <?= $result["userPhoneNumber"]; ?></span>
                            <span><strong>User CompanyName</strong>: <?= $result["userCompanyName"]; ?></span>
                            <span><strong>User Country</strong>: <?= $result["userCountry"]; ?></span>
                            <span><strong>User Address</strong>: <?= $result["userAddress"]; ?></span>
                            <span><strong>User City</strong>: <?= $result["userCity"]; ?></span>
                            <span><strong>User State</strong>: <?= $result["userState"]; ?></span>
                            <span><strong>User ZipCode</strong>: <?= $result["userZipCode"]; ?></span>
                        </div>


        <?php }}};?>

        <?php
            // Fetch order details for the logged-in user
            $userId = Session::get("userId");

            // Initialize an array to store orders grouped by their IDs
            $orderGroups = [];
            $getOrder = $cart->getOrderDetails($userId);


            // Custom counter variable for order group ID
            $orderIdCounter = 1;

            // Group orders by their unique order IDs
            if ($getOrder) {
                while ($orderresult = $getOrder->fetch_assoc()) {
                    $orderId = $orderresult['order_grp_id']; // Assuming 'order_grp_id' is the unique identifier for order groups
                    $orderGroups[$orderId][] = $orderresult;
                }
            }

            // Sort the order groups by their keys (Order Group ID)
            ksort($orderGroups);
            $totalOrders = count($orderGroups);

        ?>
  <!-- <div class="col-lg-12 my-lg-0 my-1">
                <div id="main-content" class="bg-white border"> -->


                <div class="d-flex my-4  flex-column custom-box-2 flex-wrap">
                    <div class="box me-4 my-1 bg-light">
                        <img src="https://www.freepnglogos.com/uploads/box-png/cardboard-box-brown-vector-graphic-pixabay-2.png" alt="">
                        <div class="d-flex align-items-center mt-2">
                            <p class="fs-14">Orders placed</p>
                            <p class="ms-auto number"><?php echo $totalOrders; ?></p>
                        </div>
                    </div>
                    <div class="box me-4 my-1 bg-light">
                        <img src="https://www.freepnglogos.com/uploads/shopping-cart-png/shopping-cart-campus-recreation-university-nebraska-lincoln-30.png" alt="">
                        <div class="d-flex align-items-center mt-2">
                            <p class="fs-14">Items in Cart</p>
                            <p class="ms-auto number">
                            <?php
                                // $chkCart = $cart->checkCartTable();
                                $getData = $cart->checkCartTable();
											if($getData){
												$quantity = Session::get("quantity");
												echo $quantity;
                                            }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="box me-4 my-1 bg-light">
                        <img src="https://www.freepnglogos.com/uploads/love-png/love-png-heart-symbol-wikipedia-11.png" alt="">
                        <div class="d-flex align-items-center mt-2">
                            <p class="fs-14">Wishlist</p>
                            <p class="ms-auto number">**</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-uppercase">My recent orders</div>

            <?php

            foreach ($orderGroups as $orderId => $orders) {?>
            <div class="order my-3 bg-light">
                <div class="row">
                    <div class="col-lg-12">
                            <div>
                                <h4 class=" fs-16">ORDER ID #<?php echo $orderId; ?>"</h4>

                                <p class="blue-label ms-auto text-uppercase">COD</p>
                            </div>

                            <?php
                            $i = 1;
                            foreach ($orders as $order) {?>
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <div class="col-lg-1"><?php echo $i ?></div>
                                        <div class="fs-12">Products ID: <?php echo $order['date']; ?></div>
                                        <div class="fs-12">Products ID: <?php echo $order['productId']; ?></div>
                                        <div class="fs-12">Name: <?php echo $order['productName']; ?></div>
                                        <div class="fs-12">Quantity: <?php echo $order['quantity']; ?></div>



                                    </div>

                                </div>
                                <?php $i++;?>
                            <?php }?>
                                <div class="fs-12 status" style="margin-top: 15px; width: 100%;">Status :
                                    <?php
                                        if ($order["status"] == 0) {
                                            echo "<span style='color:#914e4e;'>Order Received</span>";
                                        }elseif($order["status"] == 1) {?>
                                            <span style='color:green;'> Order Delivered <a class='invoice-btn' href='invoice?ordergrpid=<?php echo $orderId;?>' >Get Invoice</a></span>
                                    <?php } ;?>
                                </div>
                    </div>
                </div>
            </div>
                <?php }?>
                </div>
                </div>
            </div>
        </div>
    </div>


