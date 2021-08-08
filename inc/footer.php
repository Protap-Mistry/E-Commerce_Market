</div>
   <div class="footer">
   	  <div class="wrapper">	
	     <div class="section group">
				<div class="col_1_of_4 span_1_of_4">
					<h4>Information</h4>
					<?php
					   $customer_id= Session::get("customer_id");
					   $customer_login= Session::get("customer_login");
					   
				    ?>
					<?php 
						$path= $_SERVER['SCRIPT_FILENAME'];
						$current_page= basename($path,'.php');
					?>
						<ul>
							<li><a 
									<?php 
										if($current_page == 'about')
										{
											echo 'id="footer_active"';
										}
									?> 

									href="about.php">About Me
								</a>
							</li>
							<li><a href="#">Customer Service</a></li>
							<li><a href="#">Advanced Search</a></li>
							<li><a href="#">Orders and Returns</a></li>
							<?php if($customer_login==true)
			   					{ 
			   				?>
								<li><a 
										<?php 
											if($current_page == 'contact')
											{
												echo 'id="footer_active"';
											}
										?> 

										href="contact.php">Contact with Us</a></li>

							<?php  }else{ ?>

								<li> <a onclick="return confirm('You need to admit first.');"  href="login.php"> Contact with Us							
										</a> </li>
							<?php } ?>
							
						</ul>
					</div>
				<div class="col_1_of_4 span_1_of_4">
					<h4>Why buy from us</h4>
						<ul>
							
							<?php if($customer_login==true)
			   					{ 
			   				?>
								<li><a 
										<?php 
											if($current_page == 'contact')
											{
												echo 'id="footer_active"';
											}
										?> 

										href="contact.php">Customer Service</a></li>

							<?php  }else{ ?>

								<li> <a onclick="return confirm('You need to admit first.');"  href="login.php"> Customer Service							
										</a> </li>
							<?php } ?>

							<li><a href="#">Privacy Policy</a></li>
							<li><a href="contact.php">Site Map</a></li>
							<li><a href="details.php">Search Terms</a></li>
						</ul>
				</div>
				<div class="col_1_of_4 span_1_of_4">
					<h4>My account</h4>
						<ul>
							<li><a
									<?php 
											if($current_page == 'login')
											{
												echo 'id="footer_active"';
											}
										?> 
									href="login.php">Sign In</a>
							</li>
							<?php if($customer_login==true)
			   					{ 
			   				?>
								<li><a 
										<?php 
											if($current_page == 'cart')
											{
												echo 'id="footer_active"';
											}
										?> 

										href="cart.php">View Cart</a></li>

							<?php  }else{ ?>

								<li> <a onclick="return confirm('You need to admit first.');"  href="login.php"> View Cart							
										</a> </li>
							<?php } ?>

							<?php if($customer_login==true)
			   					{ 
			   				?>
								<li><a 
										<?php 
											if($current_page == 'wishlist')
											{
												echo 'id="footer_active"';
											}
										?> 

										href="wishlist.php">My Wishlist</a></li>

							<?php  }else{ ?>

								<li> <a onclick="return confirm('You need to admit first.');"  href="login.php"> My Wishlist							
										</a> </li>
							<?php } ?>

							<?php if($customer_login==true)
			   					{ 
			   				?>
								<li><a 
										<?php 
											if($current_page == '#')
											{
												echo 'id="footer_active"';
											}
										?> 

										href="#">Track My Order</a></li>

							<?php  }else{ ?>

								<li> <a onclick="return confirm('You need to admit first.');"  href="#"> Track My Order							
										</a> </li>
							<?php } ?>

							<?php if($customer_login==true)
			   					{ 
			   				?>
								<li><a 
										<?php 
											if($current_page == 'contact')
											{
												echo 'id="footer_active"';
											}
										?> 

										href="contact.php">Help</a></li>

							<?php  }else{ ?>

								<li> <a onclick="return confirm('You need to admit first.');"  href="login.php"> Help							
										</a> </li>
							<?php } ?>

						</ul>
				</div>
				<div class="col_1_of_4 span_1_of_4">
					<h4>Contact</h4>
						<ul>
							<li><span>+88-01728145671</span></li>
							<li><span>+88-01982861866</span></li>
						</ul>
						<div class="social-icons">
							<h4>Follow Me</h4>
					   		  <ul>
							      <li class="facebook"><a href="https://www.facebook.com/profile.php?id=100068297407403" target="_blank" title="facebook"> </a></li>
							      <li class="twitter"><a href="https://twitter.com/ProtapMistry2" target="_blank" title="twitter"> </a></li>
							      <li class="googleplus"><a href="#" target="_blank" title="google +"> </a></li>
							      <li class="contact"><a href="#" target="_blank" title="email"> </a></li>
							      <div class="clear"></div>
						     </ul>
   	 					</div>
				</div>
			</div>
			<?php 
			
				$footer= $format->showFooterCopyright();                     
		        if($footer)
		        {
		            foreach ($footer as $key => $value) 
		            {

			?>

				<p style="color: #fff; text-align: center">&copy; <?php echo $value['text']; ?><?php echo " ".date('Y'); ?></p>

			<?php } } ?>
     </div>
    </div>
    <script type="text/javascript">
		$(document).ready(function() {
			/*
			var defaults = {
	  			containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
	 		};
			*/
			
			$().UItoTop({ easingType: 'easeOutQuart' });
			
		});
	</script>
    <a href="#" id="toTop" style="display: block;"><span id="toTopHover" style="opacity: 1;"></span></a>
    <link href="css/flexslider.css" rel='stylesheet' type='text/css' />
	  <script defer src="js/jquery.flexslider.js"></script>
	  <script type="text/javascript">
		$(function(){
		  SyntaxHighlighter.all();
		});
		$(window).load(function(){
		  $('.flexslider').flexslider({
			animation: "slide",
			start: function(slider){
			  $('body').removeClass('loading');
			}
		  });
		});
	  </script>
</body>
</html>
