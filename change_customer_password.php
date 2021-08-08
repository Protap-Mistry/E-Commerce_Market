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
	if(isset($_GET['cutomer_id_for_update_pass']))
	{
		$customer_id= (int) $_GET['cutomer_id_for_update_pass']; 
		$session_id= Session::get("customer_id");

		if($customer_id!=$session_id)
		{
			header("Location: index.php");
		}				
	}	
	$format= new Format();

	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['updatepass']))
	{
		$updatepass= $format->updateCustomerPassword($customer_id, $_POST);
	}
?>
<div class="main">
    <div class="content">
    	<div class="section group">
			<form action="" method="POST" accept-charset="utf-8">
				<span style="text-align: center">
					<?php
					    if(isset($updatepass))
						{
							echo $updatepass;
						}
					?>
				</span>							
				<table class="update_tbl">										
					<tbody class="chng_pass">
						<tr>
							<td><h2>... Update Your Password ...</h2></td>
						</tr>
						<tr>
							<td>
								<div>
									<input type="password" name="old_pass" placeholder="Put your old password...">
								</div>
									
								<div>
								   <input type="password" name="password" placeholder="Put your new password...">
								</div>																
			    			</td>		    				
				    	</tr>
				    	<tr>
							<td>
								<input type="submit" name="updatepass" value="Completed">
							</td>
						</tr> 
				    </tbody>
				</table>
			</form>
		</div>	 	
    </div>
</div>
<?php include 'inc/footer.php'; ?>