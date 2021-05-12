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
		<form id="search-ing" class="w-100" method="" action="">
			<div class="form-row">
				<input type="text" id="search-ing-input" name="search-ing-input" placeholder="tomatoes, onions,..." />
				<button type="submit" id="go-button" class="btn btn-outline-primary btn-custom">Search</button>
			</div>
		</form>
	</div>

	<div class="container">
		<p id="num-results">Results: 3 of 3</p>
		<div class="row justify-content-between row-custom p-3 p-md-0">
			<div class="col-12 col-md-6 col-lg-4 mb-4">
				<div class="notecard m-1 p-1 w-100 h-100">
					<div class="front">
						<div class="recipe-title text-center">
							<a href="recipe-details.php">Fusilli alla Vodka with Basil and Parmesan</a>
						</div>
						<div class="recipe-info">
							<img class="recipe-img" src="images/pastavodka.jpg" alt="fusilli-alla-vodka-basil-parmesan" class="img-fluid"/>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-6 col-lg-4 mb-4">
				<div class="notecard m-1 p-1 w-100 h-100">
					<div class="front">
						<div class="recipe-title text-center">
							<a href="recipe-details.php">Fusilli alla Vodka with Basil and Parmesan</a>
						</div>
						<div class="recipe-info">
							<img class="recipe-img" src="images/pastavodka.jpg" alt="fusilli-alla-vodka-basil-parmesan"/>
						</div>
					</div>
					<!-- <div class="back">
						<h3>BACK OF NOTECARD</h3>
					</div> -->
				</div>
			</div>
			<div class="col-12 col-md-6 col-lg-4 mb-4">
				<div class="notecard m-1 p-1 w-100 h-100">
					<div class="front">
						<div class="recipe-title text-center">
							<a href="recipe-details.php">Fusilli alla Vodka with Basil and Parmesan</a>
						</div>
						<div class="recipe-info">
							<img class="recipe-img" src="images/pastavodka.jpg" alt="fusilli-alla-vodka-basil-parmesan"/>
						</div>
					</div>
					<!-- <div class="back">
						<h3>BACK OF NOTECARD</h3>
					</div> -->
				</div>
			</div>
		</div>
	</div>

	<div class="footer text-center footer-custom">@2021 recipage, inc.</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

</body>
</html>