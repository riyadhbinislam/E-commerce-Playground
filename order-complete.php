<?php
include_once "classes/cart.php";
include_once "classes/user.php";

$cart 	= new Cart();
$ul   	= new User();

$login  = Session::get("loginUser");

   if($login == false){
       echo '<script>window.location="login"</script>';
   }

   if (isset($_GET['orderId']) && $_GET['orderId'] == 'order') {
       $userId         = Session::get("userId");
       $insertOrder    = $cart->orderProduct($userId);
       $delData        = $cart->delCart();
       echo '<script>window.location="order-complete"</script>';
   }
?>
<?php include  'inc/breadcrumbs.php'; ?>

		<div class="colorlib-shop">
			<div class="container">
				<div class="row row-pb-lg">
					<div class="col-md-10 col-md-offset-1">
						<div class="process-wrap">
							<div class="process text-center active">
								<p><span>01</span></p>
								<h3>Shopping Cart</h3>
							</div>
							<div class="process text-center active">
								<p><span>02</span></p>
								<h3>Checkout</h3>
							</div>
							<div class="process text-center active">
								<p><span>03</span></p>
								<h3>Order Complete</h3>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-10 col-md-offset-1 text-center">
						<span class="icon"><i class="icon-shopping-cart"></i></span>
						<h2>Thank you for purchasing, Your order is complete</h2>
						<p>
							<a href="home"class="btn btn-primary">Home</a>
							<a href="shop"class="btn btn-primary btn-outline">Continue Shopping</a>
						</p>
					</div>
				</div>
			</div>
		</div>
