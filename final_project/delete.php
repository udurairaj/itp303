<?php

	require 'config/config.php';

	if (!$_SESSION['logged_in'] || !isset($_SESSION['logged_in'])) {
		header('Location: home.php');
	}

	if ( !isset($_GET['user_id']) || empty($_GET['user_id']) 
		|| !isset($_GET['recipe_id']) || empty($_GET['recipe_id']) ) {
		$error = "Invalid URL.";
	}
	else {
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}

		$mysqli->set_charset('utf8');

		$sql_comments = "DELETE FROM recipe_comments WHERE recipe_id = " . $_GET['recipe_id'] . ";";

		$results_comments = $mysqli->query($sql_comments);
		if ( !$results_comments ) {
			echo $mysqli->error;
			exit();
		}

		$sql_tags = "DELETE FROM recipes_has_recipe_tags WHERE recipe_id = " . $_GET['recipe_id'] . ";";

		$results_tags = $mysqli->query($sql_tags);
		if ( !$results_tags ) {
			echo $mysqli->error;
			exit();
		}

		$sql = "DELETE FROM recipes
					WHERE recipe_id = " . $_GET['recipe_id'] . ";";

		$results = $mysqli->query($sql);
		if ( !$results ) {
			echo $mysqli->error;
			exit();
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

		<h1 class="text-center">Delete Confirmation</h1>

		<div class="row justify-content-center mt-4">
			<div class="col-12 col-md-7 text-center">
				<?php if ( isset($error) && !empty($error) ) : ?>
					<div class="text-danger"><?php echo $error; ?></div>
				<?php else : ?>
					<div>
						<span class="font-italic"><?php echo $_GET['recipe_title']; ?></span> was successfully deleted.
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="row justify-content-center mt-4 mb-4">
			<div class="col-12 col-md-7 text-center">
				<a href="myrecipes.php?user_id=<?php echo $_GET['user_id']; ?>&recipe_id=<?php echo $_GET['recipe_id']; ?>" role="button" class="btn btn-light">Back to My Recipes</a>
			</div>
		</div>

	</div>

	<div class="footer text-center footer-custom">@2021 recipage, inc.</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

</body>
</html>