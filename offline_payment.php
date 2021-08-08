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
				<h2 style="color: #fff;">Offline Payment System</h2>
				<table class="tblone">
					<tr>
						<th>No</th>
						<th>Product Name</th>
						<th>Image</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Total Price</th>
					</tr>
					<?php 
						$format= new Format();

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
						<td><?php echo $value['quantity']; ?></td>
						
						<td>
							$ 	<?php $total= $value['quantity']*$value['price']; 
									echo $total;
								?>
						</td>

					</tr>

					<?php
						$quantity += $value['quantity']; 
						$sum += $total; 

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
							<td>Total Amount :</td>
							<td>
								$ 	<?php
										$vat= $sum*(10/100);
										$with_vat= $sum+$vat; 
										echo $with_vat;
									?>
							</td>
						</tr>
						<tr>
							<td>Total Quantity : </td>
							<td><?php echo $quantity; ?></td>
						</tr>

					<?php } else { ?>
						<div style="text-align: center; color: red; font-size: 20px;">
							<?php echo "Cart Empty !!! Please, shop now."; ?>
						</div>
					<?php } ?>

			   </table>
			</div>
			<div class="payment">
				<?php
					
					$customer_id= Session::get("customer_id");

					$customer_data= $format->getCustomerById($customer_id);
					if($customer_data)
					{

				?>
				<table class="update_tbl">
					<tr>
						<td colspan="3"><h2>... Your Details ...</h2></td>
					</tr>
					<tr>
						<td width="40%">Your Name</td>
						<td>:</td>
						<td><?php echo $customer_data->customerName; ?></td>
					</tr>
					<tr>
						<td>Country</td>
						<td>:</td>
						<td><?php echo $customer_data->country; ?></td>
					</tr>
					<tr>
						<td>City</td>
						<td>:</td>
						<td><?php echo $customer_data->city; ?></td>
					</tr>
					<tr>
						<td>Zipcode of Your Region</td>
						<td>:</td>
						<td><?php echo $customer_data->zipcode; ?></td>
					</tr>
					<tr>
						<td>Your Address</td>
						<td>:</td>
						<td><?php echo $customer_data->address; ?></td>
					</tr>
					<tr>
						<td>Your Contact Number</td>
						<td>:</td>
						<td><?php echo $customer_data->phone; ?></td>
					</tr>
					<tr>
						<td>E-mail Address</td>
						<td>:</td>
						<td><?php echo $customer_data->email; ?></td>
					</tr>
					<tr>
						<td>
							<a href="update_customer_profile.php?customer_id=<?php echo $customer_data->id; ?>">Update</a>
						</td>
						<td></td>
						<td>
							<a href="change_customer_password.php?cutomer_id_for_update_pass=<?php echo $customer_id;?>">Password Change</a>
						</td>
					</tr>
				</table>

				<?php } ?>

			</div>
		</div>	 	
       <div class="clear"></div>
    </div>
    <?php 
    	if(isset($_GET['order_id']) && $_GET['order_id']=='order')
    	{
    		$customer_id= Session::get("customer_id");
    		$insert_order_table= $format->orderProduct($customer_id);
    		// if(isset($insert_order_table))
    		// {
    		// 	echo $insert_order_table;
    		// }
    		$delete_cart_data_for_a_customer= $format->deleteCartDataForACustomerAfterLogout();
    	}
    ?>
    <div class="order">
    	<a href="?order_id=order" title="">Order</a>
    </div>
</div>
<?php include 'inc/footer.php'; ?>