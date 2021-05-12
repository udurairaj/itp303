<?php

	require '../config/config.php';

	if ( !isset($_POST['email']) || empty($_POST['email']) || !isset($_POST['username']) || empty($_POST['username']) || !isset($_POST['password']) || empty($_POST['password']) ) {
		$error = "Please fill out all required fields.";
	}
	else {
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if ($mysqli->connect_errno) {
			echo $mysqli->connect_error;
			exit();
		}

		$sql_registered = "SELECT * FROM users WHERE username='" . $_POST["username"] . "' OR email = '" . $_POST["email"] . "';";

		$results_registered = $mysqli->query($sql_registered);
		if (!$results_registered) {
			echo $mysqli->error;
			exit();
		}

		if ($results_registered->num_rows > 0) {
			$error = "Account exists for this username or password. Please try again.";
		}
		else {
			$password = hash("sha256", $_POST["password"]);

			$sql = "INSERT INTO users (username, email, password) VALUES ('" . $_POST["username"] ."', '" . $_POST["email"] . "', '" . $password . "');";

			$results = $mysqli->query($sql);
			if (!$results) {
				echo $mysqli->error;
				exit();
			}
		}

		$mysqli->close();
		
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
		$active_nav = "register";
		include "nav-home.php";
	?>

	<div class="container">

		<h1 class="text-center">Register</h1>

		<div class="row justify-content-center mt-4">
			<div class="col-12 col-md-7 text-center">
				<?php if ( isset($error) && !empty($error) ) : ?>
					<div class="text-danger"><?php echo $error; ?></div>
				<?php else : ?>
					<div>
						<?php echo $_POST['username']; ?> was successfully registered.
						<p>Start filling your recipe box!</p>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="row justify-content-center mt-4 mb-4">
			<div class="col-12 col-md-7 text-center">
				<a href="login.php" role="button" class="btn btn-primary">Login</a>
				<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-light">Back</a>
			</div>
		</div>

	</div>

	<div class="footer text-center footer-custom">@2021 recipage, inc.</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

</body>
</html>