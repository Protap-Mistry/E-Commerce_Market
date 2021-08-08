<?php include 'inc/header.php' ;?>
<?php 
    if(isset($_GET['pro_id']))
    {
        $pro_id= $_GET['pro_id'];
    }
?>
<div class="main">
    <div class="content">
    	<div class="section group">
			<div class="cont-desc span_1_of_2">
				<?php 
					$format= new Format();

					$get_product= $format->getSingleProduct($pro_id);
					if($get_product)
					{

				?>				
					<div class="grid images_3_of_2">
						<img src="admin/<?php echo $get_product->image; ?>" alt="Product Image" />
					</div>

					<div class="desc span_3_of_2">
						<h2><?php echo $get_product->productName; ?></h2>					
						<div class="price">
							<p>Price: <span>$ <?php echo $get_product->price; ?></span></p>
							<p>Category: <span><?php echo $get_product->categoryName; ?></span></p>
							<p>Brand:<span><?php echo $get_product->brandName; ?></span></p>
						</div>
						<div class="add-cart">
							<form action="" method="POST">
								<?php 
				                    
				                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']))
				                    {
				                    	$cart= $_POST['quantity'];
				                        $add_to_cart= $format->addToCart($pro_id, $cart);
				                    }
				                ?>

				                <?php
								   $customer_id= Session::get("customer_id");
								   $customer_login= Session::get("customer_login");
								   
							    ?>

								<input type="number" class="buyfield" name="quantity" value="1"/>
								 
									<?php if($customer_login==true)
					   					{ 
					   				?>
										<input type="submit" class="buysubmit" name="submit" value="Buy Now"/>
									<?php  }else{ ?>

										<a class="buysubmit" onclick="return confirm('You need to admit first.');"  href="login.php"> Buy Now							
										</a>
									<?php } ?>
							</form>
							<span style="color:red;">
								<?php 
									if(isset($add_to_cart))
									{
				                        echo $add_to_cart;
				                    }
								?>
							</span>
						</div>
						<?php 
		                    $customer_id= Session::get("customer_id");
		                    
		                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comparison']))
		                    {
		                    	$product_id= $_POST['product_id'];
		                    	
		                        $comparison_products= $format->insertComparisonProduct($customer_id, $product_id);
								if(isset($comparison_products))
								{
									echo $comparison_products;
								}
		                    }
		                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['wishlist']))
		                    {
		                    	$product_id= $_POST['product_id'];

		                        $wishlist_products= $format->insertWishlistProduct($customer_id, $product_id);
								if(isset($wishlist_products))
								{
									echo $wishlist_products;
								}
		                    }
		                ?>
		                <?php 
							$logged_in= Session::get("customer_login");
							if($logged_in==true)
							{

						?>
							<div class="add-cart">
								<form action="" method="POST">								
									<input type="hidden" class="buyfield" name="product_id" value="<?php echo $get_product->id; ?>"/>
									<input type="submit" class="buysubmit" name="comparison" value="Product Comparison"/>

									<input type="hidden" class="buyfield" name="product_id" value="<?php echo $get_product->id; ?>"/>
									<input type="submit" class="buysubmit" name="wishlist" value="Wish List"/>
								</form>
							</div>
						<?php } ?>						
					</div>

					<div class="product-desc">
						<h2>Product Details</h2>
						<p><?php echo $get_product->body; ?></p>
				    </div>

				<?php } ?>

		    </div>
						
			<div class="rightsidebar span_3_of_1">
				<h2>Categories</h2>
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

			</div>
		</div>
 	</div>
</div>
<?php include 'inc/footer.php' ;?>