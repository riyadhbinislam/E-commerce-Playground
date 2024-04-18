<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// include_once "classes/category.php";
// $ct 		= new category();

// Create a connection
$conn = $db->createTBl();

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: ");
}

// SQL query to create the table
$sql = "CREATE TABLE IF NOT EXISTS tbl_product (
    proId INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    proName VARCHAR(30) NOT NULL,
    proBrandId INT(12) NOT NULL,
    proTypeId INT(12) NOT NULL,
    proCategoriesId INT(12) NOT NULL,
    proTagId INT(12) NOT NULL,
    proSize INT(12) NOT NULL,
    proPrice FLOAT(2, 0) NOT NULL,
    proDescription VARCHAR(255) NOT NULL,
    proManufacturer VARCHAR(255) NOT NULL,
    proReviews VARCHAR(255) NOT NULL,
    proImg VARCHAR(255) NOT NULL
)";

// Execute SQL query
if ($conn->query($sql) === FALSE) {
    echo "Error creating table: " . $conn->error;
}

// Close the connection
// $conn->close();
?>

<?php include  'inc/breadcrumbs.php'; ?>

		<div class="colorlib-shop">
			<div class="container">
				<div class="row">
					<div class="col-md-10 col-md-push-2">
						<div class="row row-pb-lg">
						<?php
                        $query = "SELECT tbl_product.*, tbl_tag.tagName
									FROM tbl_product
									JOIN tbl_tag ON tbl_product.proTagId = tbl_tag.proTagId
									ORDER BY tbl_product.proId ASC";
                        $product = $db->select($query);
                        if($product) {
                        while ($productresult = $product->fetch_assoc()) {
                    ?>
							<div class="col-md-4 text-center">
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
										<h3><a href="product-detail?proId=<?php echo $productresult['proId'];?>&<?php echo $productresult['proName'];?>"><?php echo $productresult['proName'];?></a></h3>
										<p class="price"><span>$<?php echo $productresult['proPrice'];?></span></p>
									</div>
								</div>
							</div>
<?php }}?>
						</div>

						<div class="row">
							<div class="col-md-12">
								<ul class="pagination">
									<li class="disabled"><a href="#">&laquo;</a></li>
									<li class="active"><a href="#">1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">4</a></li>
									<li><a href="#">&raquo;</a></li>
								</ul>
							</div>
						</div>

					</div>
					<div class="col-md-2 col-md-pull-10">
						<div class="sidebar">

							<div class="side">
								<h2>Categories</h2>
								<div class="fancy-collapse-panel">
									<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
										<?php
										$catList = $ct->catList();
										if ($catList) {
											while ($catListresult = $catList->fetch_assoc()) {
												?>
												<div class="panel panel-default">
													<div class="panel-heading" role="tab" id="heading_<?php echo $catListresult['proCategoriesId']; ?>">
														<h4 class="panel-title">
															<a style="font-size: 14px;" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $catListresult['proCategoriesId']; ?>" aria-expanded="true" aria-controls="collapse_<?php echo $catListresult['proCategoriesId']; ?>"><?php echo $catListresult['catName']; ?>
															</a>
														</h4>
													</div>
													<div id="collapse_<?php echo $catListresult['proCategoriesId']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_<?php echo $catListresult['proCategoriesId']; ?>">
														<div class="panel-body">
															<ul style="list-style-type: none; margin: 0; padding: 0; text-align: left;">
																<?php
																$typeList = $protyp->typeList();
																if ($typeList) {
																	while ($typeListresult = $typeList->fetch_assoc()) {
																		?>
																		<li style="font-size: 12px;"><a href="?proTypeId=<?php echo $typeListresult['proTypeId']; ?>"><?php echo $typeListresult['typeName']; ?></a></li>
																	<?php }
																} ?>
															</ul>
														</div>
													</div>
												</div>
											<?php }} ?>
									</div>
								</div>
							</div>

							<div class="side">
								<h2>Price Range</h2>
								<form method="post" class="colorlib-form-2">
				              	<div class="row">
				                <div class="col-md-12">
				                  <div class="form-group">
				                    <label for="guests">Price from:</label>
				                    <div class="form-field">
				                      <i class="icon icon-arrow-down3"></i>
				                      <select name="people" id="people" class="form-control">
				                        <option value="#">1</option>
				                        <option value="#">200</option>
				                        <option value="#">300</option>
				                        <option value="#">400</option>
				                        <option value="#">1000</option>
				                      </select>
				                    </div>
				                  </div>
				                </div>
				                <div class="col-md-12">
				                  <div class="form-group">
				                    <label for="guests">Price to:</label>
				                    <div class="form-field">
				                      <i class="icon icon-arrow-down3"></i>
				                      <select name="people" id="people" class="form-control">
				                        <option value="#">2000</option>
				                        <option value="#">4000</option>
				                        <option value="#">6000</option>
				                        <option value="#">8000</option>
				                        <option value="#">10000</option>
				                      </select>
				                    </div>
				                  </div>
				                </div>
				              </div>
				            </form>
							</div>

							<div class="side">
								<h2>Color</h2>
								<div class="color-wrap">
									<p class="color-desc">
										<a href="#" class="color color-1"></a>
										<a href="#" class="color color-2"></a>
										<a href="#" class="color color-3"></a>
										<a href="#" class="color color-4"></a>
										<a href="#" class="color color-5"></a>
									</p>
								</div>
							</div>

							<div class="side">
								<h2>Size</h2>
								<div class="size-wrap">
									<p class="size-desc">
										<a href="#" class="size size-1">xs</a>
										<a href="#" class="size size-2">s</a>
										<a href="#" class="size size-3">m</a>
										<a href="#" class="size size-4">l</a>
										<a href="#" class="size size-5">xl</a>
										<a href="#" class="size size-5">xxl</a>
									</p>
								</div>
							</div>

						</div>
					</div>
				</div>

