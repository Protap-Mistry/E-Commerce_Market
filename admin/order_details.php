<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php';
    session::init();
    Session::checkSession(); 
?>
<?php
	$format= new Format(); 

	if(isset($_GET['order_id']))
	{
		$order_id= $_GET['order_id'];
		$customer_id= $_GET['customer_id'];
		$product_id= $_GET['product_id'];		
		$price= $_GET['price'];
		$date= $_GET['date'];

		$shift_activate= $format->shiftActivated($order_id, $customer_id, $product_id, $price, $date);
	}

	if(isset($_GET['delete_order_id']))
	{
		$delete_order_id= $_GET['delete_order_id'];
		$customer_id= $_GET['customer_id'];
		$product_id= $_GET['product_id'];		
		$price= $_GET['price'];
		$date= $_GET['date'];

		$order_delete= $format->orderProductDeleted($delete_order_id, $customer_id, $product_id, $price, $date);
	}
?>
<div class="grid_10">
	<div class="box round first grid">
	    <h2>Ordered details</h2>
	    <?php 
	    	if(isset($shift_activate))
	    	{
	    		echo $shift_activate;
	    	}
	    	if(isset($order_delete))
	    	{
	    		echo $order_delete;
	    	}
	    ?>
	    <div class="block">
	        <table class="data display datatable" id="example">
				<thead>
					<tr>
						<th width="10%">Product ID</th>
						<th width="15%">Ordered Time</th>
						<th>Product</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>Customer ID</th>
						<th>Details</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>

					<?php

						$get_ordered_products= $format->getAllOrderedProducts();						
						if($get_ordered_products)
						{
							foreach ($get_ordered_products as $key => $value) 
							{
								
					
					?>

					<tr class="odd gradeX">
						<td><a href="ordered_product_details.php?product_id=<?php echo $value['product_id']; ?>" title=""><?php echo "Details(".$value['product_id'].")"; ?> </a></td>
						<td><?php echo $format->formatDate($value['date']); ?></td>						
						<td><?php echo $value['productName']; ?></td>				
						<td><?php echo $value['quantity']; ?></td>
						<td>$ <?php echo $value['price']; ?></td>
						<td><?php echo $value['customer_id']; ?></td>
						<td><a href="customer_details.php?customer_id=<?php echo $value['customer_id']; ?>" title="">Customer Details</a></td>
						
						<?php 
							if($value['status']==0)
							{
						?>
							<td>
							
								<a href="?order_id=<?php echo $value['id']; ?>&customer_id=<?php echo $value['customer_id']; ?>&product_id=<?php echo $value['product_id']; ?>&price=<?php echo $value['price']; ?>&date=<?php echo $value['date']; ?>">Shifted</a>
																								
							</td>

						<?php } elseif($value['status']==1) { ?>

							<td>Pending...</td>

						<?php } else { ?>

							<td>
							
								<a style="color: red;" href="?delete_order_id=<?php echo $value['id']; ?>&customer_id=<?php echo $value['customer_id']; ?>&product_id=<?php echo $value['product_id']; ?>&price=<?php echo $value['price']; ?>&date=<?php echo $value['date']; ?>" onclick="return confirm('Are u sure to delete?');">Remove</a>
																								
							</td>

						<?php } ?>

					</tr>
					
					<?php } }?>

				</tbody>
			</table>
	   	</div>
	</div>


    
</div>
    
<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();
        $('.datatable').dataTable();
		setSidebarHeight();
    });
</script>
    
<?php include 'include/footer.php'; ?>