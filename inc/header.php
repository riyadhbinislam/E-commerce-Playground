<?php
  //set headers to NOT cache a page
  header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
  header("Pragma: no-cache"); //HTTP 1.0
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
  header("Cache-Control: max-age=2592000");
?>

<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
	include_once "config/config.php";
	include_once "lib/Database.php";
	include_once "lib/Session.php";
	Session::init();
	include_once "helpers/format.php";
	include_once "classes/product.php";
	include_once "classes/category.php";
	include_once "classes/type.php";
	include_once "classes/brand.php";
	include_once "classes/tag.php";
	include_once "classes/cart.php";
	include_once "classes/user.php";
	include_once "classes/order.php";
?>

<?php
	$db     	= new Database();
	$fm     	= new Format();
	$pro 		= new Product();
	$ct 		= new category();
	$protyp 	= new Type();
	$brand 		= new Brand();
	$tag 		= new Tag();
	$cart 		= new Cart();
	$ul 		= new User();

?>

<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>PlayGround Store</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />

  <!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">

	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">

	<!-- Magnific Popup -->
	<link rel="stylesheet" href="css/magnific-popup.css">

	<!-- Flexslider  -->
	<link rel="stylesheet" href="css/flexslider.css">

	<!-- Owl Carousel -->
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">

	<!-- Date Picker -->
	<link rel="stylesheet" href="css/bootstrap-datepicker.css">
	<!-- Flaticons  -->
	<link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
	<!-- Theme style  -->

	<?php
        $filename = 'css/style.css';
        $fileModified = substr(md5(filemtime($filename)), 0, 6);
    ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $filename;?>?v=<?php echo $fileModified ; ?>">

	<!-- <link rel="stylesheet" href="css/style.css"> -->

	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	</head>
	<body>
		<style>
			   /* ------------  Modal Styles / PoP-Up  Window  ------------- */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
  }

  .modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 40%;
    text-align: center;
  }
  .modal-content p {
      font-size: 22px;
      text-transform: uppercase;
      font-weight: bold;
      color: #2196f3;
      margin-bottom: 10px !important;
      display: inline-block;
  }

  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: #222;
    text-decoration: none;
    cursor: pointer;
  }
  #confirmBtn {
      display: block;
      margin: 10px auto 0;
  }

  /* ------------  Modal Styles / PoP-Up  Window-------------*/
		</style>
<!-- Modal HTML -->
<div id="confirmationModal" class="modal">
  <div class="modal-content">
    <p>Are You sure to Delete?</p>
    <button class="btn btn-primary" id="confirmBtn">Confirm</button>
    <span class="close">&times;</span>
  </div>
</div>

<!-- Check if PDF generation is requested -->
<?php
  // Start output buffering
  ob_start();

  // Check if PDF generation is requested
  if(isset($_POST['ordergrpid'])) {
    // Include FPDF library
    require_once 'fpdf/fpdf.php';

    // Include invoice generation logic
    include_once "invoicepdf.php";

    // Flush the output buffer and send PDF file
    ob_end_flush();
    exit; // Terminate further execution after generating PDF
  }
  ?>
	<!-- <div class="colorlib-loader"></div> -->
	<?php
	if(isset($_GET['userId'])){
		$cart->delCart();
		Session::userdestroy();
	}
	?>

	<div id="page">
		<nav class="colorlib-nav" role="navigation">
			<div class="top-menu">
				<div class="container">
					<div class="row">
						<div class="col-xs-2">
							<div id="colorlib-logo"><a href="/home"><img src="/images/store.webp" alt="" style="width:120px;height: auto;"></a></div>
						</div>
						<div class="col-xs-10 text-right menu-1">
							<ul>
								<li class="active"><a href="/home">Home</a></li>
								<li class="has-dropdown">
									<a href="/shop">Shop</a>
									<ul class="dropdown">
										<!-- <li><a href="/product-detail">Product Detail</a></li> -->
										<li><a href="/cart">Shipping Cart</a></li>
										<li><a href="/checkout">Checkout</a></li>
										<li><a href="/order-complete">Order Complete</a></li>
										<li><a href="/add-to-wishlist">Wishlist</a></li>
									</ul>
								</li>
								<li><a href="/blog">Blog</a></li>
								<li><a href="/about">About</a></li>
								<li><a href="/contact">Contact</a></li>
								<?php
								$login = Session::get("loginUser");
								if($login == false){
								?>
									<li><a href="signup"><i class="fas fa-user-plus"></i>SignUp</a></li>
									<li><a href="login"><i class="fas fa-sign-in-alt"></i>Login</a></li>
								<?php }else{ ?>
									<li><a href="?userId=<?php Session::get('userId') ;?>">Log Out</a></li>
									<li><a href="profile">Profile</a></li>
								<?php }?>

								<?php
								$chkCart = $cart->checkCartTable();
								if(!empty($chkCart)) {  ?>
									<li>
										<a href="/cart"><i class="icon-shopping-cart"></i> Cart <span id="cartQuantity">[<?php
											$getData = $cart->checkCartTable();
											if($getData){
												$quantity = Session::get("quantity");
												echo $quantity;
											}
										?>]</span>
										</a>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</nav>
