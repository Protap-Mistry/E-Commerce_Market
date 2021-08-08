<?php include 'inc/header.php' ;?>
<div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    <h2 style="width: 100%;">Wishlist Products</h2>
			    <!--delete portion -->
				<?php
					$format= new Format();

					if(isset($_GET['wishlist_product_id']))
					{
						$id= $_GET['wishlist_product_id'];

						$delete_product_from_wishlist= $format->deleteProductFromWishlist($id);

						if(isset($delete_product_from_wishlist))
						{
							echo $delete_product_from_wishlist;
						}

					}
				?>						
				<table class="tblone">
					<tr>
						<th>Serial</th>
						<th>Product Name</th>
						<th>Image</th>
						<th>Price</th>
						<th>Action</th>
					</tr>
					<?php
						
						$customer_id= Session::get("customer_id"); 

						$product= $format->showWishlistProducts($customer_id);						
						if($product)
						{
							$i=0;									
							foreach ($product as $key => $value) 
							{
								$i++;
			
					?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $value['productName']; ?></td>
							<td><img src="admin/<?php echo $value['image']; ?>" alt="Product Image" /></td>
							<td>$ <?php echo $value['price']; ?></td>
							
							<td>
								<a href="details.php?pro_id=<?php echo $value['product_id']; ?>">View</a> || 		
								<a onclick="return confirm('Are u sure to delete?');" href="?wishlist_product_id=<?php echo $value['product_id']; ?>">Delete</a>
							</td>

						</tr>

					<?php }} ?>

				</table>						
			</div>
			<div class="shopping">
				<div class="shopleft" style="width: 100%; text-align: center;">
					<a href="index.php"> <img src="images/shop.png" alt="Continue shopping" /></a>
				</div>
			</div>
    	</div>  	
       <div class="clear"></div>
    </div>
</div>
<?php include 'inc/footer.php' ;?>