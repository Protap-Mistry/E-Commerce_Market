<?php 
	include 'inc/header.php';
	Session::init();
	//Session::checkLogin();
?>
<?php 
	$logged_in= Session::get("customer_login");
	if($logged_in==true)
	{
		header("Location: cart.php");
	}
?>
<?php 
	$format= new Format();
	if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['register']))
	{
		$register= $format->customerRegistration($_POST);
	}
?>
<div class="main">
    <div class="content">
    	<div class="login_panel">
        	<h3>...Customer Login...</h3>
        	<form action="" method="POST">
        		<?php
					
					if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['login']))
					{
						$login= $format->customerLogin($_POST);
						if(isset($login))
						{
    						echo $login;
    					}
					}
				?>
            	<input name="email" type="text" placeholder="Put your e-mail address...">
                <input name="password" type="password" placeholder="Put your password...">

                <div class="buttons">
	            	<div>
	            		<button class="grey" name="login">Sign-In</button>
	            		<a href="password_recovery.php" style="text-decoration: none; font-size: 16px; font-weight: bold; float: right;margin-top: 20px;">Password Recovery
						</a>
	            		
	            	</div>
            	</div>
            </form>            
        </div>
    	<div class="register_account">
    		<h3> ...Customer Registration...</h3>
    		<form action="" method="POST">
    			<?php 
    				if(isset($register)){
    					echo $register;
    				}
    			?>
	   			<table>
	   				<tbody>
						<tr>
							<td>
								<div>
									<input type="text" name="name" placeholder="Put your name...">
								</div>
								<div>
									<select id="country" name="country" onchange="change_country(this.value)" class="frm-field required">
										<option value="null">Select a Country</option>       				
										<option value="BD">Bangladesh</option>
										<option value="IND">India</option>
					         		</select>
								</div>	
								<div>
								   <input type="text" name="city" placeholder="Put your city name...">
								</div>
								
								<div>
									<input type="text" name="zipcode" placeholder="Put your region zip-code...">
								</div>
			    			</td>
		    				<td>
								<div>
									<input type="text" name="address" placeholder="Put your address...">
								</div>

					           	<div>
					          		<input type="text" name="phone" placeholder="Put your contact number...">
					          	</div>
				  				<div>
									<input type="text" name="email" placeholder="Put your e-mail address...">
								</div>
								<div>
									<input type="password" name="password" placeholder="Put your password...">
								</div>
			    			</td>
				    	</tr> 
				    </tbody>
				</table> 
			   	<div class="search"><div><button class="grey" name="register">Create Account</button></div></div>
			  
			    <div class="clear"></div>
		    </form>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
<?php include 'inc/footer.php' ;?>