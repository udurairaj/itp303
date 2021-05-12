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

		<form action="register_conf.php" method="POST">
			<div class="row justify-content-center">
				
				<div class="col-12 col-md-8 col-lg-7 pb-2">
					<label for="user-id" class="text-sm-right">Username: <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="user-id" name="username">
					<small id="user-error" class="invalid-feedback">Username is required.</small>
				</div>

				<div class="col-12 col-md-8 col-lg-7 pb-2">
					<label for="email-id" class="text-sm-right">Email: <span class="text-danger">*</span></label>
					<input type="email" class="form-control" id="email-id" name="email">
					<small id="email-error" class="invalid-feedback">Email is required.</small>
				</div>

				<div class="col-12 col-md-8 col-lg-7 pb-4">
					<label for="pass-id" class="text-sm-right">Password: <span class="text-danger">*</span></label>
					<input type="password" class="form-control" id="pass-id" name="password">
					<small id="pass-error" class="invalid-feedback">Password is required.</small>
				</div>

				<div class="col-12 col-md-8 col-lg-7 pb-2">
					<button type="submit" class="btn btn-primary">Register</button>
					<a href="../home.php" role="button" class="btn btn-light">Cancel</a>
				</div>

				<div class="col-12 col-md-8 col-lg-7 pb-2">
					<a class="reg-log-custom" href="login.php">Already have an account? Login here</a>
				</div>

			</div>

		</form>
	</div>

	<div class="footer text-center footer-custom">@2021 recipage, inc.</div>

	<script>

		document.querySelector('form').onsubmit = function(){
			if ( document.querySelector('#user-id').value.trim().length == 0 ) {
				document.querySelector('#user-id').classList.add('is-invalid');
			} else {
				document.querySelector('#user-id').classList.remove('is-invalid');
			}

			if ( document.querySelector('#email-id').value.trim().length == 0 ) {
				document.querySelector('#email-id').classList.add('is-invalid');
			} else {
				document.querySelector('#email-id').classList.remove('is-invalid');
			}

			if ( document.querySelector('#pass-id').value.trim().length == 0 ) {
				document.querySelector('#pass-id').classList.add('is-invalid');
			} else {
				document.querySelector('#pass-id').classList.remove('is-invalid');
			}

			return ( !document.querySelectorAll('.is-invalid').length > 0 );
		}

	</script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

</body>
</html>