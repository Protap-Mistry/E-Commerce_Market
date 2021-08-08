<?php 

	include '../helper/format.php';
	include '../library/session.php';

	Session::init();
	Session::checkLogin();
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>
<body>
<div class="container">
	<section id="content">
		
		<form action="" method="POST">
			<h1>Login</h1>

			<?php
				$db= new databaseClass();
				$format= new Format();

				if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])){

					$login= $format->userLogin($_POST);
					
					if(isset($login)){
						echo $login;
					}
				}
			?>

			<div>
				<input type="text" placeholder="Username" name="username"/>
			</div>
			<div>
				<input type="password" placeholder="Password" name="password"/>
			</div>
			<div>
				<input type="submit" name="submit" value="Log in" />
				<a href="password_recovery.php" style="text-decoration: none; font-size: 16px;">Password Recovery</a>
			</div>
		</form><!-- form -->
		<div class="button">
			<a href="#">Powered By #Tech_PRO</a>
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
</body>
</html>