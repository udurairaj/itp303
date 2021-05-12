<?php

	if ( !isset($_POST['title']) || empty($_POST['title']) 
	|| !isset($_POST['url']) || empty($_POST['url']) ) {
		$error = "Please fill out all required fields.";
	}
	else {
		require 'config/config.php';

		if (!$_SESSION['logged_in'] || !isset($_SESSION['logged_in'])) {
			header('Location: home.php');
		}

		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->errno ) {
			echo $mysqli->error;
			exit();
		}

		$mysqli->set_charset('utf8');

		if ( isset($_POST['img-url']) && !empty($_POST['img-url']) ) {
			$img_url = $_POST['img-url'];
		}
		else {
			$img_url = "null";
		}
		if ( isset($_POST['tags']) && !empty($_POST['tags']) ) {
			$tags = $_POST['tags'];
		}
		else {
			$tags = "null";
		}
		if ( isset($_POST['comments']) && !empty($_POST['comments']) ) {
			$comments = $_POST['comments'];
		}
		else {
			$comments = "null";
		}

		$sql_recipes = "INSERT INTO recipes (recipe_title, recipe_url, user_id, recipe_img_url) VALUES ('" . $_POST['title'] . "', '" . $_POST['url'] . "', " . $_POST['user_id'] . ", '" . $img_url . "');";

		$results_recipes = $mysqli->query($sql_recipes);
		if (!$results_recipes) {
			echo $mysqli->error;
			exit();
		}

		$sql_recipeid = "SELECT * FROM recipes WHERE recipe_title = '" . $_POST['title'] . "';";
		$results_recipeid = $mysqli->query($sql_recipeid);
		if (!$results_recipeid) {
			echo $mysqli->error;
			exit();
		}
		$row_recipeid = $results_recipeid->fetch_assoc();

		if ($tags != "null") {
			$tags_array = explode(", ", $tags);
			foreach ($tags_array as $newtag) {
				// check if tag generally exists
				$sql_tags = "SELECT * FROM recipe_tags WHERE tag_name = '" . $newtag . "';";

				$results_tags = $mysqli->query($sql_tags);
				if (!$results_tags) {
					echo $mysqli->error;
					exit();
				}

				// if tag exists, associate recipe with it
				if ($results_tags->num_rows > 0) {

					$row_tags = $results_tags->fetch_assoc();

					$sql_addtag = "INSERT INTO recipes_has_recipe_tags (recipe_id, user_id, tag_id) VALUES (" . $row_recipeid['recipe_id'] . ", " . $_POST['user_id'] . ", " . $row_tags['tag_id'] . ");";
					$results_addtag = $mysqli->query($sql_addtag);
					if(!$results_addtag) {
						echo $mysqli->error;
						exit();
					}
				}
				// if tag doesn't exist, then create tag and associate recipe with it
				else {
					// create tag
					$sql_createtag = "INSERT INTO recipe_tags (tag_name) VALUES ('" . $newtag . "');";
					$results_createtag = $mysqli->query($sql_createtag);
					if (!$results_createtag) {
						echo $mysqli->error;
						exit();
					}

					// get tag id
					$results_newtagid = $mysqli->query($sql_tags);
					if (!$results_newtagid) {
						echo $mysqli->error;
						exit();
					}
					$row_newtagid = $results_newtagid->fetch_assoc();

					// associate recipe with tag
					$sql_addnewtag = "INSERT INTO recipes_has_recipe_tags (recipe_id, user_id, tag_id) VALUES (" . $row_recipeid['recipe_id'] . ", " . $_POST['user_id'] . ", " . $row_newtagid['tag_id'] . ");";
					$results_addnewtag = $mysqli->query($sql_addnewtag);
					if(!$results_addnewtag) {
						echo $mysqli->error;
						exit();
					}
				}

			}
		}

		if ($comments != "null") {
			$newcomments = explode("\r\n", $comments);
			foreach ($newcomments as $newcom) {
				$sql_addcom = "INSERT INTO recipe_comments (comment, recipe_id, user_id) VALUES ('" . $newcom . "', " . $row_recipeid['recipe_id'] . ", " . $_POST['user_id'] . ");";
				$results_addcom = $mysqli->query($sql_addcom);
				if(!$results_addcom) {
					echo $mysqli->error;
					exit();
				}
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

		<h1 class="text-center">Add Confirmation</h1>

		<div class="row justify-content-center mt-4">
			<div class="col-12 col-md-7 text-center">
				<?php if ( isset($error) && !empty($error) ) : ?>
					<div class="text-danger"><?php echo $error; ?></div>
				<?php else : ?>
					<div>
						<span class="font-italic"><?php echo $_POST['title']; ?></span> was successfully added to your recipe box.
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="row justify-content-center mt-4 mb-4">
			<div class="col-12 col-md-7 text-center">
				<a href="myrecipes.php?user_id=<?php echo $_POST['user_id']; ?>" role="button" class="btn btn-light">Back to My Recipes</a>
			</div>
		</div>

	</div>

	<div class="footer text-center footer-custom">@2021 recipage, inc.</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

</body>
</html>