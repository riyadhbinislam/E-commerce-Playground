<?php include  'inc/breadcrumbs.php'; ?>
<style>
	.input-group.text-uppercase {
    display: flex;
    align-items: center;
    font-weight: 500;
}

input#quantity {
    margin-left: 5px;
    border: 1px solid #d1d1d1 !important;
}
</style>
<?php $cart = new Cart();?>

		<div class="colorlib-shop">
			<div class="container">
				<div class="row row-pb-lg">
					<div class="col-md-10 col-md-offset-1">
						<div class="product-detail-wrap">
						<?php
							if(isset( $_GET['proId'] )) {
								$productId 	= $_GET["proId"];
								$query = "SELECT tbl_product.*, tbl_tag.tagName
													FROM tbl_product
													JOIN tbl_tag ON tbl_product.proTagId = tbl_tag.proTagId WHERE  proId=$productId
													ORDER BY tbl_product.proId ";

								$product 	= $db->select($query);

							if($_SERVER['REQUEST_METHOD'] == 'POST'){
								$quantity = $_POST['quantity'];
								$addCart  = $cart->addToCart($quantity, $productId);
							}
							if($product && $product->num_rows > 0) {
							while ($productresult = $product->fetch_assoc()) {
						;?>
							<div class="row">
								<div class="col-md-5">
									<div class="product-entry">
										<div class="product-img" style="background-image: url(<?php echo $productresult['proImg'];?>);">
											<p class="tag"><span class="sale"><?php echo $productresult['tagName'];?></span></p>
										</div>
										<div class="thumb-nail">
											<a href="#" class="thumb-img" style="background-image: url(<?php echo $productresult['proImg'];?>);"></a>
											<a href="#" class="thumb-img" style="background-image: url(<?php echo $productresult['proImg'];?>);"></a>
											<a href="#" class="thumb-img" style="background-image: url(<?php echo $productresult['proImg'];?>);"></a>
										</div>
									</div>
								</div>
								<div class="col-md-7">
									<div class="desc">
										<h3><?php echo $productresult['proName'];?></h3>
										<p class="price">
											<span>$<?php echo $productresult['proPrice'];?></span>
											<span class="rate text-right">
												<i class="icon-star-full"></i>
												<i class="icon-star-full"></i>
												<i class="icon-star-full"></i>
												<i class="icon-star-full"></i>
												<i class="icon-star-half"></i>
												(74 Rating)
											</span>
										</p>
										<p>	<?php echo $fm->readmore($productresult['proDescription'], 250) ;?></p>
										<div class="color-wrap">
											<p class="color-desc">
												Color:
												<a href="#" class="color color-1"></a>
												<a href="#" class="color color-2"></a>
												<a href="#" class="color color-3"></a>
												<a href="#" class="color color-4"></a>
												<a href="#" class="color color-5"></a>
											</p>
										</div>
										<div class="size-wrap">
											<p class="size-desc">
												Size:
												<a href="#" class="size size-1">s</a>
												<a href="#" class="size size-2">s</a>
												<a href="#" class="size size-3">m</a>
												<a href="#" class="size size-4">l</a>
												<a href="#" class="size size-5">xl</a>
												<a href="#" class="size size-5">xxl</a>
											</p>
										</div>
										<div class="row row-pb-sm">
											<div class="col-md-4">
											<form action="" method="post">
												<div class="input-group text-uppercase">
													Quantity:<input type="number" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="100">

												</div>
												</div>
													</div>
													<input type="submit" class="buysubmit btn btn-primary btn-addtocart" name="submit" value="Add To Cart">
												</div>
											</from>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<div class="row">
							<div class="col-md-12 tabulation">
								<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" href="#description">Description</a></li>
									<li><a data-toggle="tab" href="#manufacturer">Manufacturer</a></li>
									<li><a data-toggle="tab" href="#review">Reviews</a></li>
								</ul>
								<div class="tab-content">
									<div id="description" class="tab-pane fade in active">
										<p><?php echo $productresult['proDescription'];?></p>
						         </div>
						         <div id="manufacturer" class="tab-pane fade">
						         	<p><?php echo $productresult['proManufacturer'];?></p>
								   </div>
								   <div id="review" class="tab-pane fade">
								   	<div class="row">

								   		<div class="col-md-7">
								   			<h3>23 Reviews</h3>
											   <?php
													$query = "SELECT * FROM tbl_testimony";
													$testimony = $db->select($query);
													if($testimony) {
													while ($testimonyresult = $testimony->fetch_assoc()) {
												?>
								   			<div class="review">
										   		<div class="user-img" style="background-image: url(<?php echo $testimonyresult['testimonyImg'];?>)"></div>
										   		<div class="desc">
										   			<h4>
										   				<span class="text-left"><?php echo $testimonyresult['testimonyName'];?></span>
										   				<span class="text-right"><?php echo $testimonyresult['testimonyLocation'];?></span>
										   			</h4>
										   			<p class="star">
										   				<span>
										   					<i class="icon-star-full"></i>
										   					<i class="icon-star-full"></i>
										   					<i class="icon-star-full"></i>
										   					<i class="icon-star-half"></i>
										   					<i class="icon-star-empty"></i>
									   					</span>
									   					<span class="text-right"><a href="#" class="reply"><i class="icon-reply"></i></a></span>
										   			</p>
										   			<p><?php echo $testimonyresult['testimonytext'];?></p>
										   		</div>
										   	</div>
										   <?php }}?>
								   		</div>
								   	</div>
								   </div>
					         </div>
				         </div>
						</div>
					</div>
				</div>
<?php }}?>
			</div>
		</div>
		<?php };?>

		<div class="colorlib-shop">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3 text-center colorlib-heading">
						<h2><span>Similar Products</span></h2>
						<p>We love to tell our successful far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
					</div>
				</div>
				<div class="row">
				<?php
					if(isset( $_GET['proId'] )) {
						$productId 	= $_GET["proId"];
						$query = "SELECT tbl_product.*, tbl_tag.tagName
									FROM tbl_product
									JOIN tbl_tag ON tbl_product.proTagId = tbl_tag.proTagId
									WHERE tbl_product.proTagId IN (
										SELECT proTagId
										FROM tbl_product
										WHERE proId = $productId
									)
									AND tbl_product.proId != $productId
									ORDER BY tbl_product.proId " ;

						$product 	= $db->select($query);
					if($product && $product->num_rows > 0) {
					while ($productresult = $product->fetch_assoc()) {
				;?>
					<div class="col-md-3 text-center">
						<div class="product-entry">
							<div class="product-img" style="background-image: url(<?php echo $productresult['proImg'];?>);">
								<p class="tag"><span class="new"><?php echo $productresult['tagName'];?></span></p>
								<div class="cart">
									<p>
										<span class="addtocart"><a href="cart"><i class="icon-shopping-cart"></i></a></span>
										<span><a href="product-detail"><i class="icon-eye"></i></a></span>
										<span><a href="#"><i class="icon-heart3"></i></a></span>
										<span><a href="add-to-wishlist"><i class="icon-bar-chart"></i></a></span>
									</p>
								</div>
							</div>
							<div class="desc">
								<h3><a href="product-detail?proId=<?php echo $productresult['proId'];?>"><?php echo $productresult['proName'];?></a></h3>
								<p class="price"><span>$<?php echo $productresult['proPrice'];?></span></p>
							</div>
						</div>
					</div>
				<?php }}} ;?>
				</div>
			</div>
		</div>

