<?php

	require 'config/config.php';

	if (!$_SESSION['logged_in'] || !isset($_SESSION['logged_in'])) {
		header('Location: home.php');
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>recipage</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond&display=swap" rel="stylesheet">
</head>
<body>

	<?php
		$active_nav = "searching";
		include "nav.php";
	?>

	<div id="search-ing-form">
		<label for="search-ing" id="search-ing-label">Enter your ingredients, separated by commas:</label>
		<form id="search-ing" class="w-100 pb-3" action="" method="">
			<div class="form-row">
				<input type="text" id="search-ing-input" name="search-ing-input" placeholder="tomatoes, onions,..." />
				<button type="submit" id="go-button" class="btn btn-outline-primary btn-custom">Search</button>
				<small id="search-input-error" class="invalid-feedback">Please enter your ingredients.</small>
			</div>
		</form>
	</div>

	<div class="container">
		<div id="recipe-grid" class="row justify-content-between row-custom p-3 p-md-0">

			<div class="loading">loading recipes...</div>
			<div class="loading-animation">
				<div class="recipebox-animated">
					<img src="images/recipebox.png" alt="recipebox"/>
				</div>
			</div>


		</div>
	</div>

	<div class="footer text-center footer-custom">@2021 recipage, inc.</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	<script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

	<script src="main.js"></script>

	<script>
		document.querySelector('form').onsubmit = function(){
			if ( document.querySelector('#search-ing-input').value.trim().length == 0 ) {
				document.querySelector('#search-ing-input').classList.add('is-invalid');
			} else {
				document.querySelector('#search-ing-input').classList.remove('is-invalid');
			}

			return ( !document.querySelectorAll('.is-invalid').length > 0 );
		}
	</script>

</body>
</html>