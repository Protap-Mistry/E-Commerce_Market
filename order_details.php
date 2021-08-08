<?php include 'inc/header.php';?>
<?php 
	$logged_in= Session::get("customer_login");
	if($logged_in==false)
	{
		header("Location: login.php");
	}
?>
<?php 
	$format= new Format();

	if(isset($_GET['order_id_for_shift_confirmed']))
	{
		$order_id_for_shift_confirmed= $_GET['order_id_for_shift_confirmed'];
		$customer_id= $_GET['customer_id'];
		$product_id= $_GET['product_id'];		
		$price= $_GET['price'];
		$date= $_GET['date'];

		$shift_confirmed= $format->shiftConfirmed($order_id_for_shift_confirmed, $customer_id, $product_id, $price, $date);
	}
?>
<div class="main">
    <div class="content">
    	<div class="section group">
			<div class="order_details">
				<h2 style="color: #fff;">Your ordered details</h2>
				<?php 
					if(isset($shift_confirmed))
					{
						echo $shift_confirmed;
					}
				?>
				<!--delete portion -->
				<?php

					if(isset($_GET['order_details_remove_id']))
					{
						$id= $_GET['order_details_remove_id'];

						$delete_product_from_order_details= $format->deleteProductFromOrderDetails($id);

						if(isset($delete_product_from_order_details)){
							echo $delete_product_from_order_details;
						}

					}
				?>	
				<table class="tblone">
					<tr>
						<th>No</th>
						<th>Product Name</th>
						<th>Image</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>Date</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
					<?php 
						
						$customer_id= Session::get("customer_id");

						$get_order_details= $format->orderDetails($customer_id);
						
						if($get_order_details)
						{
							$i= 0;
							foreach ($get_order_details as $key => $value) 
							{
								$i++;

					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $value['productName']; ?></td>
						<td><img src="admin/<?php echo $value['image']; ?>" alt="Product Image" /></td>
						<td><?php echo $value['quantity']; ?></td>
						<td>
							$ <?php echo $value['price']; ?>
						</td>
						<td><?php echo $format->formatDate($value['date']); ?></td>
						<td>
							<?php 
								if($value['status'] == 0)
								{
									echo "Pending...";
								}
								elseif($value['status'] == 1)
								{

							?>
								<a class="details" style="color: green; background-image: none; font-size: 15px; text-align: left; hover: none;" href="?order_id_for_shift_confirmed=<?php echo $value['id']; ?>&customer_id=<?php echo $value['customer_id']; ?>&product_id=<?php echo $value['product_id']; ?>&price=<?php echo $value['price']; ?>&date=<?php echo $value['date']; ?>">Shifted</a>

							<?php
									 
								}
								else
								{
									echo "Confirm"; 
								}
							?>
								
						</td>
						<td>
							<?php 
								if($value['status'] == 2)
								{
							?>
								<a href="?order_details_remove_id=<?php echo $value['id']; ?>" onclick="return confirm('Are u sure to delete?');">X</a>
							<?php
								
								}
								else
								{
									echo "N/A "; 
								}
							?> 							
						</td>
					</tr>

					<?php }} ?>

				</table>
			</div>
		</div>	 	
       <div class="clear"></div>
    </div>
 </div>
<?php include 'inc/footer.php'; ?>