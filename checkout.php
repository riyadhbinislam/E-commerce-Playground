<?php include_once "classes/user.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php
$cart 	= new Cart();
$ul   	= new User();
$login  = Session::get("loginUser");

if (isset($_POST['submit'])) {
    if ($login == false) {
		// Attempt to add user
		$addUser = $ul->userAdd($_POST);
		if ($addUser) {
			// User added successfully
			echo "User added successfully.";
			echo '<meta http-equiv="refresh" content="0.01;url=login">';
			exit;
		} else {
			// Failed to add user
			echo "Failed to add user.";
		}
	} else {
		// Attempt to edit user
		$updateUser = $ul->updateUser($_POST); // Pass $_POST data here
		if ($updateUser) {
			// User updated successfully
			echo "User updated successfully.";
		} else {
			// Failed to update user
			echo "Failed to update user.";
		}
	}
}

?>

<?php
   if(isset($updateUser)){
       echo $updateUser;
   }
?>

<?php include  'inc/breadcrumbs.php'; ?>
<style>
	.form-group .col-md-6 {
    padding-left: 0;
}

.form-group .col-md-6:last-child {
    padding-right: 0;
}
</style>
		<div class="colorlib-shop">
			<div class="container">
				<div class="row row-pb-md">
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
							<div class="process text-center">
								<p><span>03</span></p>
								<h3>Order Complete</h3>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-7">
						<form method="post" class="colorlib-form">
							<h2>Billing Details</h2>
<?php
if (isset($addUser)) {
	echo "<span class='error'>". $addUser. "</span>";
}
?>
<?php
if(isset($updateUser)){
	echo $updateUser;
}
?>
						<div class="row">
						  <?php
							$login = Session::get("loginUser");
							if($login == false){
							?>
			               <div class="col-md-12">
								<div class="form-group">
										<div class="col-md-6">
											<label for="fname">First Name</label>
											<input type="text" id="fname" class="form-control" name="userFirstName" placeholder="Your firstname">
										</div>
										<div class="col-md-6">
											<label for="lname">Last Name</label>
											<input type="text" id="lname" class="form-control" name="userLastName" placeholder="Your lastname">
										</div>
								</div>

							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="lname">Full Name</label>
									<input type="text" id="lname" class="form-control" name="userFullName" placeholder="Your Fullname">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="companyname">Company Name</label>
									<input type="text" id="companyname" class="form-control" name="userCompanyName" placeholder="Company Name">
								</div>
								<div class="form-group">
										<label for="country">Select Country</label>
										<div class="form-field">
											<i class="icon icon-arrow-down3"></i>
											<select name="userCountry" id="people" class="form-control">
												<option value="#">Select country</option>
												<option value="#">Alaska</option>
												<option value="#">China</option>
												<option value="#">Japan</option>
												<option value="#">Korea</option>
												<option value="#">Philippines</option>
											</select>
										</div>
								</div>
							</div>
			               <div class="col-md-12">
									<div class="form-group">
										<label for="fname">Address</label>
			                    		<input type="text" id="address" class="form-control" name="userAddress"placeholder="Enter Your Address">
			                  		</div>

			               </div>
			               <div class="col-md-12">
									<div class="form-group">
										<label for="">Town/City</label>
			                    		<input type="text" id="towncity" class="form-control" name="userCity" placeholder="Town or City">
			                  		</div>
			               </div>
						   <div class="col-md-12">
								<div class="form-group">
										<div class="col-md-6">
											<label for="stateprovince">State/Province</label>
											<input type="text" id="fname" class="form-control" name="userState" placeholder="State Province">
										</div>
										<div class="col-md-6">
											<label for="zip">Zip/Postal Code</label>
											<input type="text" id="zippostalcode" class="form-control" name="userZipCode" placeholder="Zip / Postal">
										</div>
								</div>
								<div class="form-group">
									<div class="col-md-6">
										<label for="email">E-mail Address</label>
										<input type="text" id="email" class="form-control" name="userEmail" placeholder="State Province">
									</div>
									<div class="col-md-6">
										<label for="Phone">Phone Number</label>
										<input type="text" id="zippostalcode" class="form-control" name="userPhoneNumber" placeholder="">
									</div>
								</div>

							</div>
							<div class="form-group">
								<div class="form-group">
									<div class="col-md-12">
										<div class="form-group">
											<label for="password">Password</label>
											<input type="password" id="password" class="form-control" name="UserPassword" placeholder="Enter Your Password">
										</div>
									</div>
								</div>
						   </div>
							<div class="form-group">
								<div class="col-md-12">
									<div class="radio">
										<label><input type="radio" name="optradio">Create an Account?</label>


									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<div class="submit">
										<input type="submit" class="btn btn-primary" name="submit" value="Submit">
									</div>
								</div>
							</div>
							</form>
					</div>
<!-- Render Form Fields with Pre-filled Values -->
							<?php }else{
							$userId = Session::get("userId");
							$getData = $ul->getUserById($userId);
							if($getData) {
								while ($result = $getData->fetch_assoc())
							{?>
							<div class="col-md-12">
								<div class="form-group">
									<label for="fname">First Name</label>
									<input type="text" id="fname" class="form-control" name="userFirstName" placeholder="Your firstname" value="<?= $result['userFirstName'] ?>">
								</div>
								<div class="form-group">
									<label for="lname">Last Name</label>
									<input type="text" id="lname" class="form-control" name="userLastName" placeholder="Your lastname" value="<?= $result['userLastName'] ?>">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="lname">Full Name</label>
									<input type="text" id="lname" class="form-control" name="userFullName" placeholder="Your Fullname" value="<?= ucwords($result["userFullName"]) ?>">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="companyname">Company Name</label>
									<input type="text" id="companyname" class="form-control" name="userCompanyName" placeholder="Company Name" value="<?= ucwords($result["userCompanyName"]) ?>">
								</div>
								<div class="form-group">
										<label for="country">Select Country</label>
										<div class="form-field">
											<i class="icon icon-arrow-down3"></i>
											<select name="userCountry" id="people" class="form-control">
												<option value="<?= $result["userCountry"]?>"><?= $result["userCountry"]?></option>
												<option value="Bangladesh">Bangladesh</option>
												<option value="China">China</option>
												<option value="Japan">Japan</option>
												<option value="Korea">Korea</option>
												<option value="Philippines">Philippines</option>
											</select>
										</div>
								</div>
							</div>
			               <div class="col-md-12">
									<div class="form-group">
										<label for="fname">Address</label>
			                    		<input type="text" id="address" class="form-control" name="userAddress"placeholder="Enter Your Address" value="<?= ucwords($result["userAddress"]) ?>">
			                  		</div>

			               </div>
			               <div class="col-md-12">
									<div class="form-group">
										<label for="">Town/City</label>
			                    		<input type="text" id="towncity" class="form-control" name="userCity" placeholder="Town or City" value="<?= ucwords($result["userCity"]) ?>">
			                  		</div>
			               </div>
						   <div class="col-md-12">
								<div class="form-group">
										<div class="col-md-6">
											<label for="stateprovince">State/Province</label>
											<input type="text" id="fname" class="form-control" name="userState" placeholder="State Province" value="<?= ucwords($result["userState"]) ?>">
										</div>
										<div class="col-md-6">
											<label for="zip">Zip/Postal Code</label>
											<input type="text" id="zippostalcode" class="form-control" name="userZipCode" placeholder="Zip / Postal" value="<?= ucwords($result["userZipCode"]) ?>">
										</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<div class="col-md-6">
										<label for="Phone">Phone Number</label>
										<input type="text" id="zippostalcode" class="form-control" name="userPhoneNumber" placeholder="" value="<?= ucwords($result["userPhoneNumber"]) ?>">
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label for="email">E-mail Address</label>
											<input type="text" id="email" class="form-control" name="userEmail" placeholder="Enter Your Email" value="<?= $result["userEmail"] ;?>">
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
								<div class="form-group">
									<input type="hidden" name="userId" value="<?= $result["userId"] ?>">
									<input class="btn btn-primary" type="submit" value="UpdateInfo" name="submit"/>
								</div>
							</div>

		            </form>
					</div>
					</div>
					<?php }}} ?>
					</div>


					<div class="col-md-5">
						<div class="cart-detail">
							<h2>Cart Total</h2>
							<ul>
							<?php
								$cartItems = $cart->getCartProduct();
								$sum = 0; // Initialize sum outside the loop
								$i = 0;
								$quantity = 0;

								if ($cartItems && $cartItems->num_rows > 0) { // Check if $cartItems is not null and has rows
									$i = 0;
									// Calculate subtotal
									while ($result = $cartItems->fetch_assoc()) {
										$i++;
										$total = $result["proPrice"] * $result["quantity"];
										$sum += $total; // Add each total to the sum
								?>
										<li>
											<span><?= $result['quantity']; ?> x <?= $result['productName']; ?></span>
											<span>$<?= number_format((float)$total, 2, '.', ''); ?></span>
										</li>
								<?php
									}
								} else {
									echo "Your Cart is Empty";
								}



							// Calculate VAT
							$vat = $sum * 0.15;
							$Shipping = 160;

							// Calculate order total (subtotal + VAT)
							$orderTotal = $sum + $vat + $Shipping;
							?>
							<ul>
								<li><span>Subtotal</span> <span>$<?=number_format((float)$sum, 2, '.', '');?></span></li>
								<li><span>VAT</span> <span>$<?=number_format((float)$vat, 2, '.', '');?></span></li>
								<li><span>Shipping</span> <span>$160.00</span></li>
								<li><span>Order Total</span> <span>$<?=number_format((float)$orderTotal, 2, '.', '');?></span></li>
							</ul>
							</ul>
						</div>
						<div class="cart-detail">
							<h2>Payment Method</h2>
							<div class="form-group">
								<div class="col-md-12">
									<div class="radio">
									   <label><input type="radio" name="optradio">Direct Bank Tranfer</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<div class="radio">
									   <label><input type="radio" name="optradio">Check Payment</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<div class="radio">
									   <label><input type="radio" name="optradio">Paypal</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<div class="radio">
									   <label><input type="radio" name="optradio">Cash On Delivery</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<div class="checkbox">
									   <label><input type="checkbox" value="">I have read and accept the terms and conditions</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<p><a href="order-complete?orderId=order" class="btn btn-primary">Place an order</a></p>
							</div>
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
										<span><a href="product-detail.php"><i class="icon-eye"></i></a></span>
										<span><a href="#"><i class="icon-heart3"></i></a></span>
										<span><a href="add-to-wishlist.php"><i class="icon-bar-chart"></i></a></span>
									</p>
								</div>
							</div>
							<div class="desc">
								<h3><a href="shop.php">Floral Dress</a></h3>
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
										<span><a href="product-detail.php"><i class="icon-eye"></i></a></span>
										<span><a href="#"><i class="icon-heart3"></i></a></span>
										<span><a href="add-to-wishlist.php"><i class="icon-bar-chart"></i></a></span>
									</p>
								</div>
							</div>
							<div class="desc">
								<h3><a href="shop.php">Floral Dress</a></h3>
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
										<span><a href="product-detail.php"><i class="icon-eye"></i></a></span>
										<span><a href="#"><i class="icon-heart3"></i></a></span>
										<span><a href="add-to-wishlist.php"><i class="icon-bar-chart"></i></a></span>
									</p>
								</div>
							</div>
							<div class="desc">
								<h3><a href="shop.php">Floral Dress</a></h3>
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
										<span><a href="product-detail.php"><i class="icon-eye"></i></a></span>
										<span><a href="#"><i class="icon-heart3"></i></a></span>
										<span><a href="add-to-wishlist.php"><i class="icon-bar-chart"></i></a></span>
									</p>
								</div>
							</div>
							<div class="desc">
								<h3><a href="shop.php">Floral Dress</a></h3>
								<p class="price"><span>$300.00</span></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>



