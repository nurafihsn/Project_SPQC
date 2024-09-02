<?php
@session_start();
include "include/database.php";
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$passwd = isset($_POST['passwd']) ? $_POST['passwd'] : '';
$username_x = '';
$passwd_x = '';

if (isset($_POST['login'])) {
	$sql = "SELECT * FROM tbuser WHERE username='$username'";
	$q 	= mysqli_query($conn, $sql);
	$capt = strtolower($_POST['captcha']);
	$code = strtolower($_SESSION['CAPTCHA_CODE']);
	
	while ($d = mysqli_fetch_array($q)) {
		$username_x = $d['username'];
		$passwd_x = $d['passwd'];
		
		if ($username == $d['username'] && md5($passwd) == $d['passwd'] && $capt == $code) {
			$_SESSION['username'] = $d['username'];
			$_SESSION['level'] = $d['level'];
			header("Location: home.php");
			exit;
		}
	}
} else {
	unset($_SESSION['username']);
	unset($_SESSION['level']);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Aplikasi Database QC</title>
	<link href="css/admin_login.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
		.style1 {
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: 12px;
			color: #D67361;
			font-weight: bold;
		}
	</style>
</head>

<body>
	<p align="center">&nbsp;</p>
	<p align="center">&nbsp;</p>
	<p align="center">&nbsp;</p>
	<p align="center">&nbsp;</p>
	<form id="form1" name="form1" method="POST" action="index.php">
		<div id="ctr" align="center">
			<div class="login">
				<div class="login-form">
					<img src="images/login.jpg" alt="Login" width="169" height="32" />
					<div class="form-block">
						<p> </p>
						<div>
							<input name="username" type="text" placeholder="User" class="inputlabel" required oninvalid="this.setCustomValidity('data user tidak boleh kosong')" oninput="setCustomValidity('')" value="<?= $username; ?>">
						</div>

						<p style='color: red;'>
							<?php if ($username <> $username_x) {
								echo "User tidak benar";
							} ?>
						</p>
						<div>
							<input name="passwd" type="password" placeholder="Password" class="inputlabel" required oninvalid="this.setCustomValidity('data password tidak boleh kosong')" oninput="setCustomValidity('')" />
						</div>

						<div class="form-group col-4">
							<label>Enter Captcha</label>
							<input type="text" class="form-control" name="captcha" id="captcha">
						</div>
						<div class="form-group col-4">
							<label>Captcha Code</label>
							<img src="scripts/captcha.php" alt="PHP Captcha">
						</div>
						<p style='color: red;'>
							<?php if ($passwd <> $passwd_x) {
								echo "Password atau Captcha tidak benar";
							} ?>
						</p>
					</div>
					<div align="left">
						<p> </p>
						<input name="login" type="submit" class="button" id="login" value="Login" />
					</div>
				</div>
				<div align="justify"></div>
				<div class="login-text">

					<div class="ctr">
						<p><br>
							<br>
							<img src="images/splogo.jpg" width="80" height="95" /><br>
						</p>
						<p>Selamat Datang di Aplikasi Database QC</p>

					</div>

				</div>
				<div class="clr"></div>
			</div>
		</div>
		<p align="center">&nbsp;</p>
		<label></label>
		<p align="center">
			<label></label><label></label>
		</p>
		<p align="center" class="style1"><? echo $komen; ?></p>
	</form>
	 <script src="include/footer.js"></script>
</body>

</html>