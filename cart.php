<?php include 'inc/header.php' ;?>
<?php 
	if(!isset($_GET['refresh_cart'])){
		echo "<meta http-equiv= 'refresh' content= '0; URL=?refresh_cart=live_refresh' />";
	}
?>
 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2>Your Cart</h2>
			    		<!--update portion-->
			    		<?php 
						    $format= new Format();
						    														            
		                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']))
		                    {	
		                    	$cart_id= $_POST['cart_id'];
		                    	$quantity= $_POST['quantity'];
		                        $update_cart_quantity= $format->updateCartQuantity($cart_id, $quantity);

		                        if(isset($update_cart_quantity))
								{
			                        echo $update_cart_quantity;
			                    }
		                    }
		                    
		                ?>
			    		<!--delete portion -->
						<?php

							if(isset($_GET['cart_id']))
							{
								$id= $_GET['cart_id'];

								$delete_product_from_cart= $format->deleteProductFromCart($id);

								if(isset($delete_product_from_cart)){
									echo $delete_product_from_cart;
								}

							}
						?>		
						
						<table class="tblone">
							<tr>
								<th width="5%">Serial</th>
								<th width="20%">Product Name</th>
								<th width="10%">Image</th>
								<th width="15%">Price</th>
								<th width="25%">Quantity</th>
								<th width="20%">Total Price</th>
								<th width="10%">Action</th>
							</tr>
							<?php 
								$product= $format->showProductToCart();
								$quantity= 0;
								$sum= 0;						
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
									<form action="" method="POST">
										
										<input type="hidden" name="cart_id" value="<?php echo $value['id']; ?>"/>
										<input type="number" name="quantity" value="<?php echo $value['quantity']; ?>"/>
										<input type="submit" name="submit" value="Update">

									</form>
								</td>
								<td>
									$ 	<?php $total= $value['quantity']*$value['price']; 
											echo $total;
										?>
								</td>
								<td>
									 		
									<a onclick="return confirm('Are u sure to delete?');" href="?cart_id=<?php echo $value['id']; ?>">Delete</a>
								</td>

							</tr>

							<?php
								$quantity += $value['quantity']; 
								$sum += $total; 

								Session::set("quantity", $quantity);
								Session::set("sum", $sum);
							?>

							<?php }} ?>

						</table>
						<table class="payment">

							<?php 
								$check_cart_table_data= $format->checkCartTableData();

								if($check_cart_table_data)
								{
							?>

								<tr>
									<td>Sub Total : </td>
									<td>$ <?php echo $sum; ?></td>
								</tr>
								<tr>
									<td>VAT : </td>
									<td>10% ($ <?php echo $vat= $sum*0.1; ?>)</td>
								</tr>
								<tr>
									<td>Total Amount:</td>
									<td>
										$ 	<?php
												$vat= $sum*(10/100);
												$with_vat= $sum+$vat; 
												echo $with_vat;
											?>
									</td>
								</tr>

							<?php } else { ?>
								<div style="text-align: center; color: red; font-size: 20px;">
									<?php echo "Cart Empty !!! Please, shop now."; ?>
								</div>
							<?php } ?>

					   </table>
					</div>
					<div class="shopping">
						<div class="shopleft">
							<a href="index.php"> <img src="images/shop.png" alt="Continue shopping" /></a>														
						</div>
						<div class="shopright">
							
							<?php 
								if($check_cart_table_data)
								{ 
					   		?>
									<a href="payment.php"> <img src="images/check.png" alt="Payment" /></a>

							<?php  }else{ ?>

									<a href="#" onclick="return confirm('You need to shop first.');"> <img src="images/check.png" alt="Payment" /></a>
							<?php } ?>
						</div>
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
<?php include 'inc/footer.php' ;?>