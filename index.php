<?php
ob_start();
session_start();
ob_end_clean();
date_default_timezone_get('Asia/Jakarta');

$levelno = isset($_SESSION['picknav_levelno']) ? $_SESSION['picknav_levelno'] : "";
$disabled = isset($_SESSION['picknav_disabled']) ? $_SESSION['picknav_disabled'] : "";

if($levelno == 2 && $disabled == 0){
   header('location:dashboard.php?smt=home');
}
elseif($levelno == 3 && $disabled == 0){
   header('location:dashboard.php?operator=home');
}
else{
	unset($_SESSION['picknav_pic']);
	unset($_SESSION['picknav_levelno']);
	unset($_SESSION['picknav_disabled']);
	unset($_SESSION['picknav_nik']);
	?>
	<!DOCTYPE html>
	<html>
		<head> 
			<meta charset="utf-8"/>
			<meta name="google" value="notranslate"/>
			<meta http-equiv="X-UA-Compatible" content=="IE=edge"/>
			<link rel="shortcut icon" href="asset/icon/picknav.png"/>
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="shortcut icon" href="asset/icon/check.ico"/>
			<link rel="stylesheet" type="text/css" href="asset/css/font-awesome.min.css">
			<link rel="stylesheet" type="text/css" href="asset/css/style_login.css">
			<title>PICKING NAVIGATION</title>
		</head>  
		<body>
			<div class="container">
				<div id="login">
					<p class="title">PICKING NAVIGATION SYSTEM</p>
					<form method="post" action="aksilogin.php?action=login">
						<p><i class="fa fa-user"></i><input type="text"  id="picknav_username" name="picknav_username" placeholder="Username" required="" autofocus="" /></p> <!-- JS because of IE support; better: placeholder="Username" -->
						<p><i class="fa fa-lock"></i><input type="password" id="picknav_password" name="picknav_password" placeholder="Password" required=""/></p> <!-- JS because of IE support; better: placeholder="Password" -->
						<div class="err">
						<?php 
							if(!empty($_GET['warning']) && $_GET['warning'] == 'errlog')
							{ echo "<h4 class='err'>The User ID and password you entered don't match.</h4>"; }
							elseif(!empty($_GET['warning']) && $_GET['warning'] == 'wrong')
							{ echo "<h4 class='err'>The User ID and password you entered don't match.</h4>"; }
							elseif(!empty($_GET['warning']) && $_GET['warning'] == 'unpermission')
							{ echo "<h4 class='err'>You don't have permission</h4>"; }			
						?>
						</div>
						<p><input type="submit" value="Sign In"></p>
					</form>
				</div>
			</div>
		</body>
	</html>
<?php
}
?>