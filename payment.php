<?php include 'inc/header.php';?>
<?php 
	$logged_in= Session::get("customer_login");
	if($logged_in==false)
	{
		header("Location: login.php");
	}
?>
 <div class="main">
    <div class="content">
    	<div class="section group">
			<div class="payment">
				<h2 style="color: #fff;">Choose a Payment Option</h2>
				<a href="offline_payment.php" title="">Offline Payment</a>
				<a href="online_payment.php" title="">Online Payment</a>
			</div>
		</div>	 	
       <div class="clear"></div>
    </div>
 </div>
<?php include 'inc/footer.php'; ?>