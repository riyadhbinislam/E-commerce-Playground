<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "config/config.php";
include_once "lib/Database.php";
$db = new Database();

// Create a connection

$conn = $db->createTBl();

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: ");
}

// SQL query to create the table
$sql = "CREATE TABLE IF NOT EXISTS tbl_cart (
    cartId INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sId VARCHAR(255) NOT NULL,
    productId INT(12) NOT NULL,
    productName	VARCHAR(255) NOT NULL,
    proPrice	float(10,2) NOT NULL,
    quantity	INT(11) NOT NULL,
    proImg	varchar(255) NOT NULL
)";

// Execute SQL query
if ($conn->query($sql) === FALSE) {
    echo "Error creating table: " . $conn->error;
}

// Close the connection
// $conn->close();
?>

<?php include  'inc/breadcrumbs.php'; ?>
<?php $cart = new Cart();?>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $quantity = $_POST['quantity'];
    $cartId = $_POST['cartId'];
    $updateCart  = $cart->updateCart($quantity, $cartId);
    if($quantity<=0){
        $delProduct = $cart->deleteFromCart($cartId);
    }
}

?>
<?php
if(isset($updateCart)){
	echo  $updateCart;
}
?>
<style>form .display-tc {
    display: grid !important;
    grid-template-columns: 1fr 1fr !important;
    place-content: center;
}</style>
<div class="colorlib-shop">
			<div class="container">
				<div class="row row-pb-md">
					<div class="col-md-10 col-md-offset-1">
						<div class="process-wrap">
							<div class="process text-center active">
								<p><span>01</span></p>
								<h3>Shopping Cart</h3>
							</div>
							<div class="process text-center">
								<p><span>02</span></p>
								<h3>Checkout</h3>
							</div>
							<div class="process text-center">
								<p><span>03</span></p>
								<h3>Order Complete</h3>
							</div>
						</div>
					</div>
				</div>
				<div class="row row-pb-md">
					<div class="col-md-10 col-md-offset-1">
						<div class="product-name">
							<div class="one-forth text-center">
								<span>Product Details</span>
							</div>
							<div class="one-eight text-center">
								<span>Price</span>
							</div>
							<div class="one-eight text-center">
								<span>Quantity</span>
							</div>
							<div class="one-eight text-center">
								<span>Total</span>
							</div>
							<div class="one-eight text-center">
								<span>Remove</span>
							</div>
						</div>
						<?php

						$cartItems = $cart->getCartProduct();
						$sum = 0;
						$quantity = 0;
						if ($cartItems && $cartItems->num_rows > 0) { // Check if $cartItems is not null and has rows
							$i = 0;
							while ($result = $cartItems->fetch_assoc()) {
								$i++;
								// Check if $result is not null before accessing its elements
								if (!empty($result['quantity']) && !empty($result["proPrice"])) {
									$quantity += $result['quantity'];
									$total = $result["proPrice"] * $result["quantity"];
									$sum += $total; // Add each total to the sum
								}

						?>
						<div class="product-cart">
							<div class="one-forth">
								<div class="product-img" style="background-image: url(<?=$result['proImg'] ?>);">
								</div>
								<div class="display-tc">
									<h3><?=$result['productName'] ?></h3>
								</div>
							</div>
							<div class="one-eight text-center">
								<div class="display-tc">
									<span class="price">$<?=$result['proPrice'] ?></span>
								</div>
							</div>
							<div class="one-eight text-center">
							<form action="" method="post">
								<div class="display-tc">
									<input type="number" id="quantity" name="quantity" class="form-control input-number text-center" value="<?=$result['quantity']?>" min="1" max="100">
									<input type="hidden" name="cartId" value="<?=$result['cartId']?>" />
                            		<input type="submit" value="Update" />
								</div>
							</form>
							</div>
							<div class="one-eight text-center">
								<div class="display-tc">
									<span class="price">$<?php
										$total = $result["proPrice"] * $result["quantity"];
										echo number_format((float)$total, 2, '.', '');
										?>
									</span>
								</div>
							</div>
							<div class="one-eight text-center">
								<div class="display-tc">
									<span class="acction-button">
										<a href="delcart?cartId=<?=$result['cartId']?>" class="delete-item closed" ><i class="fas fa-trash-alt"></i></a>
									</span>
								</div>
							</div>
							<?}}?>
						</div>


					</div>
				</div>
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<div class="total-wrap">
							<div class="row">
								<div class="col-md-8">
									<form action="#">
										<div class="row form-group">
											<div class="col-md-9">
												<input type="text" name="quantity" class="form-control input-number" placeholder="Your Coupon Number...">
											</div>
											<div class="col-md-3">
												<input type="submit" value="Apply Coupon" class="btn btn-primary">
											</div>
										</div>
									</form>
								</div>
								<div class="col-md-3 col-md-push-1 text-center">
								<?php
								if (!empty($sum) && !empty($quantity)) {
									Session::set("quantity", $quantity);
									Session::set("sum", $sum);
								?>

									<div class="total total-price">
										<div class="sub">
											<p><span>Subtotal:</span> <span>$<?php  echo number_format((float)$sum, 2, '.', '')?></span></p>
											<p><span>VAT:</span> <span>15%</span></p>
											<p><span>Discount:</span> <span>$00.00</span></p>
										</div>
										<div class="grand-total">
											<p>
												<span><strong>Total:</strong></span>
												<span>$<?php
															$vat = $sum * 0.15;
															$grandTotal = $sum + $vat;
															echo number_format($grandTotal, 2);
														?>
												</span>
											</p>
										</div>
									</div>
									<?php } else {
										echo "<span class='msg-alt'>Your Cart is Empty! Please add some products to your cart.</span>";
									} ?>
								</div>
							</div>

							<a href="checkout" class="btn btn-primary" style="margin-top: 3rem; text-transform: none;  width: 100%;"><i class="fas fa-money-check-alt"></i>Checkout</a></td>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="colorlib-shop">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3 text-center colorlib-heading">
						<h2><span>Recommended Products</span></h2>
						<p>We love to tell our successful far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 text-center">
						<div class="product-entry">
							<div class="product-img" style="background-image: url(images/item-5.jpg);">
								<p class="tag"><span class="new">New</span></p>
								<div class="cart">
									<p>
										<span class="addtocart"><a href="#"><i class="icon-shopping-cart"></i></a></span>
										<span><a href="product-detail.html"><i class="icon-eye"></i></a></span>
										<span><a href="#"><i class="icon-heart3"></i></a></span>
										<span><a href="add-to-wishlist.html"><i class="icon-bar-chart"></i></a></span>
									</p>
								</div>
							</div>
							<div class="desc">
								<h3><a href="shop.html">Floral Dress</a></h3>
								<p class="price"><span>$300.00</span></p>
							</div>
						</div>
					</div>
					<div class="col-md-3 text-center">
						<div class="product-entry">
							<div class="product-img" style="background-image: url(images/item-6.jpg);">
								<p class="tag"><span class="new">New</span></p>
								<div class="cart">
									<p>
										<span class="addtocart"><a href="#"><i class="icon-shopping-cart"></i></a></span>
										<span><a href="product-detail.html"><i class="icon-eye"></i></a></span>
										<span><a href="#"><i class="icon-heart3"></i></a></span>
										<span><a href="add-to-wishlist.html"><i class="icon-bar-chart"></i></a></span>
									</p>
								</div>
							</div>
							<div class="desc">
								<h3><a href="shop.html">Floral Dress</a></h3>
								<p class="price"><span>$300.00</span></p>
							</div>
						</div>
					</div>
					<div class="col-md-3 text-center">
						<div class="product-entry">
							<div class="product-img" style="background-image: url(images/item-7.jpg);">
								<p class="tag"><span class="new">New</span></p>
								<div class="cart">
									<p>
										<span class="addtocart"><a href="#"><i class="icon-shopping-cart"></i></a></span>
										<span><a href="product-detail.html"><i class="icon-eye"></i></a></span>
										<span><a href="#"><i class="icon-heart3"></i></a></span>
										<span><a href="add-to-wishlist.html"><i class="icon-bar-chart"></i></a></span>
									</p>
								</div>
							</div>
							<div class="desc">
								<h3><a href="shop.html">Floral Dress</a></h3>
								<p class="price"><span>$300.00</span></p>
							</div>
						</div>
					</div>
					<div class="col-md-3 text-center">
						<div class="product-entry">
							<div class="product-img" style="background-image: url(images/item-8.jpg);">
								<p class="tag"><span class="new">New</span></p>
								<div class="cart">
									<p>
										<span class="addtocart"><a href="#"><i class="icon-shopping-cart"></i></a></span>
										<span><a href="product-detail.html"><i class="icon-eye"></i></a></span>
										<span><a href="#"><i class="icon-heart3"></i></a></span>
										<span><a href="add-to-wishlist.html"><i class="icon-bar-chart"></i></a></span>
									</p>
								</div>
							</div>
							<div class="desc">
								<h3><a href="shop.html">Floral Dress</a></h3>
								<p class="price"><span>$300.00</span></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


