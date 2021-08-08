<?php
	$filepath= realpath(dirname(__FILE__));
	include $filepath.'/../helper/format.php';

?>

<?php
	$filepath= realpath(dirname(__FILE__));
	include_once $filepath.'/../library/session.php';
	Session::init();
	//Session::checkSession();
?>
<?php
    $customer_loginmsg= Session::get("customer_login_msg");
    if(isset($customer_loginmsg))
    {
        echo $customer_loginmsg;
    }
    Session::set("customer_login_msg", NULL);
?>
<?php
  //set headers to NOT cache a page
  header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
  header("Pragma: no-cache"); //HTTP 1.0
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
  // Date in the past
  //or, if you DO want a file to cache, use:
  header("Cache-Control: max-age=2592000"); 
//30days (60sec * 60min * 24hours * 30days)
?>

<!DOCTYPE HTML>
<head>
<title>Marketing</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<link href="css/style.css?v=<?php echo time()?>" rel="stylesheet" type="text/css" media="all"/>
<link href="css/menu.css?v=<?php echo time()?>" rel="stylesheet" type="text/css" media="all"/>

<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css?v=<?php echo time()?>">

<link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>

<script src="js/jquerymain.js"></script>
<script src="js/script.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> 
<script type="text/javascript" src="js/nav.js"></script>
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script> 
<script type="text/javascript" src="js/nav-hover.js"></script>

<script type="text/javascript">
  $(document).ready(function($){
    $('#dc_mega-menu-orange').dcMegaMenu({rowItems:'4',speed:'slow',effect:'fade'});
  });
</script>
</head>
<body>
<div class="wrap">
	<div class="header_top">
		<div class="logo">
			<a href="index.php"><img src="images/slider/logo_1.jpg" alt="" /></a>
		</div>
		<div class="header_top_right">
		    <div class="search_box">
			    <form action="search.php" method="POST">
			    	<input type="text" name="search" placeholder="Search Product Using Product Name..."/>
					<input type="submit" name="submit" value="Inquiry"/>
			    </form>
		    </div>
		    <div class="shopping_cart">
				<div class="cart">
					<a href="#" title="View my shopping cart" rel="nofollow">
						<span class="cart_title">Cart: </span>
						<span class="no_product">
							<?php
								$format= new Format();
								$check_cart_table_data= $format->checkCartTableData();

								if($check_cart_table_data)
								{
									$quantity= Session::get("quantity");
									$sum= Session::get("sum");

									echo "$ ".$sum." (".$quantity.")";
								}
								else
								{
									echo "(Empty)";
								}
							?>
						</span>
					</a>
				</div>
		    </div>

		    <!-- log-out portion-->
		    <?php 

	            if(isset($_GET['action']) && $_GET['action']=='logout')
	            {
	            	$delete_cart_data_for_a_customer= $format->deleteCartDataForACustomerAfterLogout();

	            	$customer_id= Session::get("customer_id");
	            	$delete_cart_data_for_a_customer= $format->deleteComparisonDataForACustomerAfterLogout($customer_id);

	                Session::destroy();
	            }
	        ?>

		   	<div class="login">
		   		<?php 
					$logged_in= Session::get("customer_login");
					if($logged_in==false)
					{

				?>
					<a href="login.php">Admit</a>
				<?php 
						
					}else{
						$customer_id_for_profile= Session::get("customer_id");
				?>
					<a href="?action=logout">Sign-out</a>
					<a href="customer_profile.php?customer_id=<?php echo $customer_id_for_profile; ?>">Profile</a>
		   			
		   		<?php } ?>

		   	</div>

	 		<div class="clear"></div>
	 	</div>
	 	<div class="clear"></div>
	</div>
	<div class="menu">
		<ul id="dc_mega-menu-orange" class="dc_mm-orange">
			<?php 
				$path= $_SERVER['SCRIPT_FILENAME'];
				$current_page= basename($path,'.php');
			?>
		  	<li>
		  		<a 
					<?php 
						if($current_page == 'index')
						{
							echo 'id="navbar_active"';
						}
					?>
					href="index.php">Abode
				</a>
		  	</li>
		  	<li>
		  		<a 
					<?php 
						if($current_page == 'topbrands')
						{
							echo 'id="navbar_active"';
						}
					?>
					href="topbrands.php">Top Brands
				</a>
		  	</li>
		  	<li>
		  		<a 
					<?php 
						if($current_page == 'categories')
						{
							echo 'id="navbar_active"';
						}
					?>
					href="categories.php">Categories
				</a>
				<ul>
					<?php 

						$category= $format->showCategory();						
						if($category)
						{
							foreach ($category as $key => $value)
							{
					
					?>
			      		<li><a href="productbycat.php?category_id=<?php echo $value['id']; ?>"><?php echo $value['categoryName']; ?></a></li>

			      	<?php } } ?>
				</ul>
		  	</li>
		  	
		  	<?php
				$customer_id= Session::get("customer_id"); 

				$product= $format->showComparisonProducts($customer_id);						
				if($product)
				{
			?>
		  		<li>
		  			<a 
						<?php 
							if($current_page == 'comparison_products')
							{
								echo 'id="navbar_active"';
							}
						?>
						href="comparison_products.php">Comparison
					</a>
		  		</li>
		  	<?php } ?>

		  	<?php
				$customer_id= Session::get("customer_id"); 

				$product= $format->showWishlistProducts($customer_id);						
				if($product)
				{
			?>
		  		<li>
		  			<a 
						<?php 
							if($current_page == 'wishlist')
							{
								echo 'id="navbar_active"';
							}
						?>
						href="wishlist.php">Wishlist
					</a>
		  		</li>
		  	<?php } ?>

		  	<?php 
				$logged_in= Session::get("customer_login");
				if($logged_in==true)
				{

			?>
		  		<li>
		  			<a 
						<?php 
							if($current_page == 'cart')
							{
								echo 'id="navbar_active"';
							}
						?>
						href="cart.php">Cart
					</a>
		  		</li>

		  	<?php 
		  		$check_cart_table_data= $format->checkCartTableData();

				if($check_cart_table_data)
				{
		  	?>
		  		<li>
		  			<a 
						<?php 
							if($current_page == 'payment')
							{
								echo 'id="navbar_active"';
							}
						?>
						href="payment.php">Payment
					</a>
		  		</li>

			<?php }} ?>
			<?php 
				$customer_id= Session::get("customer_id");
				$order_details= $format->orderDetails($customer_id);
				if($order_details)
				{
			?>
				<li>
					<a 
						<?php 
							if($current_page == 'order_details')
							{
								echo 'id="navbar_active"';
							}
						?>
						href="order_details.php">Ordered
					</a>
				</li>
			<?php } ?>					  	
		  	<div class="clear"></div>
		</ul>
	</div>