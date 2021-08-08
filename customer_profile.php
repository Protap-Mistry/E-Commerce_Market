<?php 
	include 'inc/header.php';
	//Session::checkSession();
?>
<?php 
	$logged_in= Session::get("customer_login");
	if($logged_in==false)
	{
		header("Location: login.php");
	}
?>
<?php 
	if(isset($_GET['customer_id']))
	{
		$customer_id= (int) $_GET['customer_id']; 
	}
?>
<div class="main">
    <div class="content">
    	<div class="section group">
			<?php
				$format= new Format();

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
</div>
<?php include 'inc/footer.php'; ?>