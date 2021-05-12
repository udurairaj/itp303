<?php

	if ( !isset($_GET['recipe_id']) || empty($_GET['recipe_id']) ) {
		echo "Invalid Recipe ID";
		exit();
	}

	require 'config/config.php';

	if (!$_SESSION['logged_in'] || !isset($_SESSION['logged_in'])) {
		header('Location: home.php');
	}

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	$mysqli->set_charset('utf8');

	$sql_tags = "SELECT recipes.recipe_id, recipe_title, recipe_url, recipe_img_url, tag_name
			FROM recipes
			LEFT JOIN recipes_has_recipe_tags
				ON recipes_has_recipe_tags.recipe_id = recipes.recipe_id
			LEFT JOIN recipe_tags
				ON recipes_has_recipe_tags.tag_id = recipe_tags.tag_id
			WHERE recipes.recipe_id=" . $_GET['recipe_id'] . ";";
		
	$results_tags = $mysqli->query($sql_tags);
	if (!$results_tags) {
		echo $mysqli->error;
		exit();
	}

	$sql_comments = "SELECT recipes.recipe_id, recipe_title, recipe_url, recipe_img_url, comment
		FROM recipes
		LEFT JOIN recipe_comments
			ON recipes.recipe_id = recipe_comments.recipe_id
		WHERE recipes.recipe_id=" . $_GET['recipe_id'] . ";";

	$results_comments = $mysqli->query($sql_comments);
	if (!$results_comments) {
		echo $mysqli->error;
		exit();
	}

	$mysqli->close();

	$recipe_tags = [];
	$recipe_comments = [];
	while ( $row_tags = $results_tags->fetch_assoc() ) {
		$recipe_title = $row_tags['recipe_title'];
		$recipe_url = $row_tags['recipe_url'];
		$recipe_img_url = $row_tags['recipe_img_url'];
		array_push($recipe_tags, $row_tags['tag_name']);
	}
	$recipe_tags = implode(", ", $recipe_tags);

	while ( $row_comments = $results_comments->fetch_assoc() ) {
		array_push($recipe_comments, $row_comments['comment']);
	}
	$recipe_comments_list = implode("\r\n", $recipe_comments);

?>

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

	<div class="container">

		<h1 class="text-center">Edit Recipe</h1>

		<form action="edit_conf.php" method="POST">

			<div class="row justify-content-center">
				
				<div class="col-12 col-md-8 col-lg-7 pb-4">
					<label for="edit-title" class="text-sm-right">Title: <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="edit-title" name="title" value="<?php echo $recipe_title; ?>">
					<small id="edit-title-error" class="invalid-feedback">Title is required.</small>
				</div>

				<div class="col-12 col-md-8 col-lg-7 pb-4">
					<label for="edit-url" class="text-sm-right">Recipe URL: <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="edit-url" name="url" value="<?php echo $recipe_url; ?>">
					<small id="edit-url-error" class="invalid-feedback">Recipe URL is required.</small>
				</div>

				<div class="col-12 col-md-8 col-lg-7 pb-4">
					<label for="edit-img-url" class="text-sm-right">Recipe Image (URL): </label>
					<input type="text" class="form-control" id="edit-img-url" name="img-url" value="<?php echo $recipe_img_url; ?>">
				</div>

				<div class="col-12 col-md-8 col-lg-7 pb-4">
					<label for="edit-tags" class="text-sm-right">Tags: </label>
					<input type="text" class="form-control" id="edit-tags" name="tags" value="<?php echo $recipe_tags; ?>">
				</div>

				<div class="col-12 col-md-8 col-lg-7 pb-5">
					<label for="edit-comments" class="text-sm-right">Comments: </label>
					<textarea class="form-control" id="edit-comments" name="comments" rows="<?php count($recipe_comments); ?>"><?php echo $recipe_comments_list; ?></textarea>
				</div>

				<div class="col-12 col-md-8 col-lg-7 pb-2 text-end">
					<button type="reset" class="btn btn-light">Reset</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>

				<input type="hidden" name="recipe_id" value="<?php echo $_GET['recipe_id']; ?>">

				<input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>">

			</div>

		</form>
	</div>

	<div class="footer text-center footer-custom">@2021 recipage, inc.</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<script>
		document.querySelector('form').onsubmit = function(){
			if ( document.querySelector('#edit-title').value.trim().length == 0 ) {
				document.querySelector('#edit-title').classList.add('is-invalid');
			} else {
				document.querySelector('#edit-title').classList.remove('is-invalid');
			}

			if ( document.querySelector('#edit-url').value.trim().length == 0 ) {
				document.querySelector('#edit-url').classList.add('is-invalid');
			} else {
				document.querySelector('#edit-url').classList.remove('is-invalid');
			}

			return ( !document.querySelectorAll('.is-invalid').length > 0 );
		}
	</script>

</body>
</html>