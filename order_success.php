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
			<div class="order_success">
				<h2 style="color: #fff">Order Confirmation</h2>
				<p>Ordered successfull !!!</p>
				<h3>
					Total payable amount (Including VAT): 
					<span style="color: #CC3636;">$ 
					 	<?php
					 		$format= new Format();
							$customer_id= Session::get("customer_id");

							$get_amount= $format->payableAmount($customer_id);
							
							if($get_amount)
							{
								$sum= 0;	

								foreach ($get_amount as $key => $value) 
								{
							 		$price= $value['price'];
									$sum += $price;

									$vat= $sum*(10/100);
									$with_vat= $sum+$vat; 
									
									echo $with_vat;
									
								}
							}
						?>
					</span>
				</h3>
				</br>
				<h4>
					Thanks for purchased. We will contact you ASAP with your delivery details. Here is your order details. Please, <a href="order_details.php" title="">Visit here !!!</a>
				</h4>
			</div>
		</div>	 	
    </div>
 </div>
<?php include 'inc/footer.php'; ?>