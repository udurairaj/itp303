<?php 

	if ( !isset($_POST['title']) || empty($_POST['title']) 
	|| !isset($_POST['url']) || empty($_POST['url'])
	|| !isset($_POST['recipe_id']) || empty($_POST['recipe_id']) ) {
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

		$sql_recipes = "UPDATE recipes
										SET recipe_title = '" . $_POST['title'] . "', 
					recipe_url = '" . $_POST['url'] ."', 
					recipe_img_url = '" . $img_url ."'
					WHERE recipe_id = " . $_POST['recipe_id'] . ";";

		$results_recipes = $mysqli->query($sql_recipes);
		if (!$results_recipes) {
			echo $mysqli->error;
			exit();
		}

		$tags_array = explode(", ", $tags);

		$sql_checktags = "SELECT recipe_tags.tag_id, tag_name FROM recipes_has_recipe_tags LEFT JOIN recipe_tags ON recipe_tags.tag_id = recipes_has_recipe_tags.tag_id WHERE recipe_id = " . $_POST['recipe_id'] . ";";

		$results_checktags = $mysqli->query($sql_checktags);
		if (!$results_checktags) {
			echo $mysqli->error;
			exit();
		}

		$oldtags = [];
		$oldtagids = [];
		while ($row_checktags = $results_checktags->fetch_assoc()) {
			array_push($oldtags, $row_checktags['tag_name']);
			array_push($oldtagids, $row_checktags['tag_id']);
		}
		
		// compare new tags to old tags for what to add
		foreach ($tags_array as $newtag) {
			foreach ($oldtags as $oldtag) {
				$exists = false;
				if ($oldtag == $newtag) {
					$exists = true;
					break;
				}
			}
			// add new tag if doesn't exist
			if (!$exists) {

				// check if tag generally exists
				$sql_tags = "SELECT * FROM recipe_tags WHERE tag_name = '" . $newtag . "';";

				$results_tags = $mysqli->query($sql_tags);
				if (!$results_tags) {
					echo $mysqli->error;
					exit();
				}

				// if tag exists, check if recipe is associated with it
				if ($results_tags->num_rows > 0) {

					$row_tags = $results_tags->fetch_assoc();

					$sql_hastag = "SELECT * FROM recipes_has_recipe_tags LEFT JOIN recipe_tags ON recipe_tags.tag_id = recipes_has_recipe_tags.tag_id WHERE tag_name = '" . $tag . "' AND recipe_id = " . $_POST['recipe_id'] . ";";
				
					$results_hastag = $mysqli->query($sql_hastag);
					if (!$results_hastag) {
						echo $mysqli->error;
						exit();
					}

					// if not associated, add, otherwise do nothing
					if ($results_hastag->num_rows == 0) {
						$sql_addtag = "INSERT INTO recipes_has_recipe_tags (recipe_id, user_id, tag_id) VALUES (" . $_POST['recipe_id'] . ", " . $_POST['user_id'] . ", " . $row_tags['tag_id'] . ");";
						$results_addtag = $mysqli->query($sql_addtag);
						if(!$results_addtag) {
							echo $mysqli->error;
							exit();
						}
					}
				}
				// if tag doesn't generally exist
				else {
					// create tag
					$sql_createtag = "INSERT INTO recipe_tags (tag_name) VALUES ('" . $newtag . "');";
					$results_createtag = $mysqli->query($sql_createtag);
					if (!$results_createtag) {
						echo $mysqli->error;
						exit();
					}

					// get new tag id
					$results_newtagid = $mysqli->query($sql_tags);
					if (!$results_newtagid) {
						echo $mysqli->error;
						exit();
					}
					$row_newtagid = $results_newtagid->fetch_assoc();

					// associate to recipe
					$sql_addnewtag = "INSERT INTO recipes_has_recipe_tags (recipe_id, user_id, tag_id) VALUES (" . $_POST['recipe_id'] . ", " . $_POST['user_id'] . ", " . $row_newtagid['tag_id'] . ");";
					$results_addnewtag = $mysqli->query($sql_addnewtag);
					if(!$results_addnewtag) {
						echo $mysqli->error;
						exit();
					}
				}
			}
		}

		// compare old tags to new tags for what to delete
		$count = 0;
		foreach ($oldtags as $oldtag) {
			foreach ($tags_array as $newtag) {
				$exists = false;
				if ($oldtag == $newtag) {
					$exists = true;
					break;
				}
			}
			// delete old tag if not there anymore
			if (!$exists) {
				$sql_deleteold = "DELETE FROM recipes_has_recipe_tags WHERE tag_id = " . $oldtagids[$count] . " AND recipe_id = " . $_POST['recipe_id'] . ";";

				$results_deleteold = $mysqli->query($sql_deleteold);
				if (!$results_deleteold) {
					echo $mysqli->error;
					exit();
				}
			}
			$count++;
		}

		// do the same for comments as what we did for tags
		$newcomments = explode("\r\n", $comments);

		$sql_checkcomments = "SELECT comment, recipe_comments.recipe_id FROM recipe_comments LEFT JOIN recipes ON recipes.recipe_id = recipe_comments.recipe_id WHERE recipes.recipe_id = " . $_POST['recipe_id'] . ";";

		$results_checkcomments = $mysqli->query($sql_checkcomments);
		if (!$results_checkcomments) {
			echo $mysqli->error;
			exit();
		}

		$oldcomments = [];
		while ($row_checkcomments = $results_checkcomments->fetch_assoc()) {
			array_push($oldcomments, $row_checkcomments['comment']);
		}
		
		// compare new comments to old comments for what to add
		foreach ($newcomments as $newcom) {
			foreach ($oldcomments as $oldcom) {
				$exists = false;
				if ($oldcom == $newcom) {
					$exists = true;
					break;
				}
			}
			// add comment if new
			if (!$exists) {

				// check if comment exists
				$sql_comments = "SELECT * FROM recipe_comments WHERE comment = '" . $newcom . "';";

				$results_comments = $mysqli->query($sql_comments);
				if (!$results_comments) {
					echo $mysqli->error;
					exit();
				}

				// if comment does not exist, create comment
				if ($results_comments->num_rows == 0) {
					$sql_addcom = "INSERT INTO recipe_comments (comment, recipe_id, user_id) VALUES ('" . $newcom . "', " . $_POST['recipe_id'] . ", " . $_POST['user_id'] . ");";
					$results_addcom = $mysqli->query($sql_addcom);
					if(!$results_addcom) {
						echo $mysqli->error;
						exit();
					}
				}
			}
		}

		// compare old comments to new comments for what to delete
		foreach ($oldcomments as $oldcom) {
			foreach ($newcomments as $newcom) {
				$exists = false;
				if ($oldcom == $newcom) {
					$exists = true;
					break;
				}
			}
			// delete old comment if not there anymore
			if (!$exists) {
				$sql_deleteoldcom = "DELETE FROM recipe_comments WHERE comment = '" . $oldcom . "' AND recipe_id = " . $_POST['recipe_id'] . ";";

				$results_deleteoldcom = $mysqli->query($sql_deleteoldcom);
				if (!$results_deleteoldcom) {
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

		<h1 class="text-center">Edit Confirmation</h1>

		<div class="row justify-content-center mt-4">
			<div class="col-12 col-md-7 text-center">
				<?php if ( isset($error) && !empty($error) ) : ?>
					<div class="text-danger"><?php echo $error; ?></div>
				<?php else : ?>
					<div>
						<span class="font-italic"><?php echo $_POST['title']; ?></span> was successfully edited.
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="row justify-content-center mt-4 mb-4">
			<div class="col-12 col-md-7 text-center">
				<a href="recipe-details.php?user_id=<?php echo $_POST['user_id']; ?>&recipe_id=<?php echo $_POST['recipe_id']; ?>" role="button" class="btn btn-light">Back to Recipe Details</a>
			</div>
		</div>

	</div>

	<div class="footer text-center footer-custom">@2021 recipage, inc.</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

</body>
</html>