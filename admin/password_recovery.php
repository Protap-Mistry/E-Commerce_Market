<?php 

	include '../helper/format.php';
	include '../library/session.php';

	Session::init();
	Session::checkLogin();
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Change Password</title>
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>
<body>
<div class="container">
	<section id="content">
		
		<form action="" method="POST">
			<h1>Password Recovery</h1>

			<?php
				$db= new databaseClass();
				$format= new Format();

				if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])){

					$pass_recover= $format->passwordRecover($_POST);
					
					if(isset($pass_recover)){
						echo $pass_recover;
					}
				}
			?>

			<div>
				<input type="text" placeholder="Enter your email address..." name="email"/>
			</div>
			<div>
				<input type="submit" name="submit" value="Send E-mail" />
				<a href="login.php" style="text-decoration: none; font-size: 16px;">Log-in</a>
			</div>
		</form><!-- form -->
		<div class="button">
			<a href="#">Powered By #Tech_PRO</a>
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
</body>
</html>