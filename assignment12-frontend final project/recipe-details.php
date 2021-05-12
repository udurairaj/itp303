<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>recipage</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond&display=swap" rel="stylesheet">

</head>
<body>

	<?php
		$active_nav = "myrecipes";
		include "nav.php";
	?>

	<div class="container details-container">

		<div class="row justify-content-between row-custom p-3 p-md-0">
			<div class="col-12 mb-4">
				<div class="notecard m-1 p-1">
					<div class="recipe-title text-center">
						<h3>Fusilli alla Vodka with Basil and Parmesan</h3>
					</div>
					<div class="recipe-info">
						<img class="recipe-img" src="images/pastavodka.jpg" alt="fusilli-alla-vodka-basil-parmesan"/>
						<p class="recipe-url"><a href="https://www.bonappetit.com/recipe/fusilli-alla-vodka-basil-parmesan">https://www.bonappetit.com/recipe/fusilli-alla-vodka-basil-parmesan</a></p>
						<p class="recipe-tags">Tags</p>
						<p class="recipe-comments">Comments</p>
					</div>
					<div class="edit-delete-btns">
						<button type="edit" id="edit-button" class="btn btn-warning">Edit</button>
						<button type="delete" id="delete-button" class="btn btn-danger">Delete</button>
					</div>
				</div>
			</div>		
		</div>

	</div>

	<div class="recipebox">
		<img src="images/recipebox.png" alt="recipebox"/>
	</div>

	<div class="footer text-center footer-custom">@2021 recipage, inc.</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

</body>
</html>