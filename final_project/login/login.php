<?php
require '../config/config.php';

if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
	if (isset($_POST['username']) && isset($_POST['password'])) {
		if (empty($_POST['username']) || empty($_POST['password'])) {
			$error = "Please enter username and password.";
		}
		else {
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if($mysqli->connect_errno) {
				echo $mysqli->connect_error;
				exit();
			}

			$passwordHash = hash("sha256", $_POST["password"]);
			$sql = "SELECT * FROM users
						WHERE username = '" . $_POST['username'] . "' AND password = '" . $passwordHash . "';";

			$results = $mysqli->query($sql);

			if(!$results) {
				echo $mysqli->error;
				exit();
			}

			if ($results->num_rows > 0) {
				$_SESSION['username'] = $_POST['username'];
				$_SESSION['logged_in'] = true;

				header("Location: ../myrecipes.php");
			}
			else {
				$error = "Invalid username or password.";
			}
		}
	}
}
else {
	header ("Location: ../myrecipes.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>recipage</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="../style.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond&display=swap" rel="stylesheet">

</head>
<body>

	<?php
		$active_nav = "login";
		include "nav-home.php";
	?>

	<div class="container">

		<h1 class="text-center">Login</h1>

		<form action="login.php" method="POST">

			<div class="row">
				<div class="font-italic text-danger col-sm-9 ml-sm-auto">
					<?php
						if ( isset($error) && !empty($error) ) {
							echo $error;
						}
					?>
				</div>
			</div>

			<div class="row justify-content-center">
				
				<div class="col-12 col-md-8 col-lg-7 pb-2">
					<label for="log-user" class="text-sm-right">Username: <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="log-user" name="username">
					<small id="log-user-error" class="invalid-feedback">Username is required.</small>
				</div>

				<div class="col-12 col-md-8 col-lg-7 pb-4">
					<label for="log-pass" class="text-sm-right">Password: <span class="text-danger">*</span></label>
					<input type="password" class="form-control" id="log-pass" name="password">
					<small id="log-pass-error" class="invalid-feedback">Password is required.</small>
				</div>

				<div class="col-12 col-md-8 col-lg-7 pb-2">
					<button type="submit" class="btn btn-primary">Login</button>
					<a href="../home.php" role="button" class="btn btn-light">Cancel</a>
				</div>

				<div class="col-12 col-md-8 col-lg-7 pb-2">
					<a class="reg-log-custom" href="register_form.php">Don't have an account? Register here</a>
				</div>

			</div>

		</form>
	</div>

	<div class="footer text-center footer-custom">@2021 recipage, inc.</div>

	<script>

		document.querySelector('form').onsubmit = function(){
			if ( document.querySelector('#log-user').value.trim().length == 0 ) {
				document.querySelector('#log-user').classList.add('is-invalid');
			} else {
				document.querySelector('#log-user').classList.remove('is-invalid');
			}

			if ( document.querySelector('#log-pass').value.trim().length == 0 ) {
				document.querySelector('#log-pass').classList.add('is-invalid');
			} else {
				document.querySelector('#log-pass').classList.remove('is-invalid');
			}

			return ( !document.querySelectorAll('.is-invalid').length > 0 );
		}

	</script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

</body>
</html>