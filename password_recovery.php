<?php 
	include 'inc/header.php';
	Session::init();
	Session::checkLogin();
?>

<?php 
	
	$format= new Format();

	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['pass_recover']))
	{
		$pass_recover= $format->customerPasswordRecover($_POST);		
	}
				
?>
<div class="main">
    <div class="content">
    	<div class="section group">
			<form action="" method="POST" accept-charset="utf-8">
				<span style="text-align: center">
					<?php
					    
						if(isset($pass_recover))
						{
							echo $pass_recover;
						}
					?>
				</span>							
				<table class="update_tbl">										
					<tbody class="chng_pass">
						<tr>
							<td><h2>... Recover Your Password ...</h2></td>
						</tr>
						<tr>
							<td>
								<div>
									<input type="text" name="email" placeholder="Put your email address...">
								</div>																
			    			</td>		    				
				    	</tr>
				    	<tr>
							<td>
								<input type="submit" name="pass_recover" value="Completed">
							</td>
						</tr> 
				    </tbody>
				</table>
			</form>
		</div>	 	
    </div>
</div>
<?php include 'inc/footer.php'; ?>