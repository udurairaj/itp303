<?php
	require 'config/config.php';

	if (isset($_SESSION["logged_in"]) || $_SESSION["logged_in"]) {

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

	}
	else {
		header('Location: home.php');
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

	<div class="container details-container">

		<?php 
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
		?>

		<div class="row justify-content-between row-custom p-3 p-md-0">
			<div class="col-12 mb-4">
				<div class="notecard m-1 p-1">
					<div class="recipe-title text-center">
						<h3><?php echo $recipe_title; ?></h3>
					</div>
					<div class="recipe-info">
						<img class="recipe-img-det" src="<?php if ( $recipe_img_url != "null" ) { echo $recipe_img_url; } else { echo 'images/img-not-found.jpeg'; } ?>"/>
						<p class="recipe-url"><a href="<?php echo $recipe_url; ?>" target="_blank"><?php echo $recipe_url; ?></a></p>
						<p class="recipe-tags"><strong>Tags: </strong><?php echo $recipe_tags; ?></p>
						<p class="recipe-comments"><strong>Comments: </strong></p>
						<?php foreach ($recipe_comments as $comment): ?>
							<p class="recipe-comments"><?php echo "~ " . $comment; ?></p>
						<?php endforeach; ?>
					</div>
					<div class="row">
						<div class="col-6 back-btn">
							<a href="myrecipes.php?user_id=<?php echo $_GET['user_id']; ?>" role="button" class="btn btn-secondary back-btn-custom">Back</a>
						</div>
						<div class="col-6 edit-delete-btns">
							<a href="edit_form.php?user_id=<?php echo $_GET['user_id']; ?>&recipe_id=<?php echo $_GET['recipe_id']; ?>" role="button" class="btn btn-warning">Edit</a>
							<a href="delete.php?user_id=<?php echo $_GET['user_id']; ?>&recipe_id=<?php echo $_GET['recipe_id']; ?>&recipe_title=<?php echo $recipe_title; ?>" role="button" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your recipe for <?php echo $recipe_title; ?>?')">Delete</a>
						</div>
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