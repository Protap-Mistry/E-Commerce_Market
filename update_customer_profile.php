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

	$format= new Format();

	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['update']))
	{
		$update_customer= $format-> updateCustomerData($customer_id, $_POST);
	}
?>
<div class="main">
    <div class="content">
    	<div class="section group">
			<?php
				$customer_data= $format->getCustomerById($customer_id);
				if($customer_data)
				{

			?>

			<form action="" method="POST" accept-charset="utf-8">
				<span style="text-align: center">
					<?php
					   	if(isset($update_customer))
						{
							echo $update_customer;
						}
					?>
				</span>							
				<table class="update_tbl">
					<tr>
						<td colspan="3"><h2>... Update Your Details ...</h2></td>
					</tr>					
					<tr>
						<td width="40%">Your Name</td>
						<td>:</td>
						<td><input type="text" name="name" value="<?php echo $customer_data->customerName; ?>"></td>
					</tr>
					<tr>
						<td>Country</td>
						<td>:</td>
						<td><input type="text" name="country" value="<?php echo $customer_data->country; ?>"></td>
					</tr>
					<tr>
						<td>City</td>
						<td>:</td>
						<td><input type="text" name="city" value="<?php echo $customer_data->city; ?>"></td>
					</tr>
					<tr>
						<td>Zipcode of Your Region</td>
						<td>:</td>
						<td><input type="text" name="zipcode" value="<?php echo $customer_data->zipcode; ?>"></td>
					</tr>
					<tr>
						<td>Your Address</td>
						<td>:</td>
						<td><input type="text" name="address" value="<?php echo $customer_data->address; ?>"></td>
					</tr>
					<tr>
						<td>Your Contact Number</td>
						<td>:</td>
						<td><input type="text" name="phone" value="<?php echo $customer_data->phone; ?>"></td>
					</tr>
					<tr>
						<td>E-mail Address</td>
						<td>:</td>
						<td><input type="text" name="email" value="<?php echo $customer_data->email; ?>"></td>
					</tr>
					<tr>
						<td>
							<input type="submit" name="update" value="Completed">
						</td>
						<td></td>
						<td>
							<a href="change_customer_password.php?cutomer_id_for_update_pass=<?php echo $customer_id;?>">Password Change</a>
						</td>
					</tr>
				</table>
			</form>
			<?php } ?>

		</div>	 	
    </div>
</div>
<?php include 'inc/footer.php'; ?>