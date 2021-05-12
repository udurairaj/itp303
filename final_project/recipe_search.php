<?php
	require 'config/config.php';

	if (isset($_SESSION["logged_in"]) || $_SESSION["logged_in"]) {

		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}

		$mysqli->set_charset('utf8');

		if ($_GET['search-type'] == "title") {
			$sql = "SELECT recipe_id, recipe_title, recipes.user_id, recipe_img_url, username FROM recipes LEFT JOIN users ON users.user_id=recipes.user_id WHERE username = '" . $_SESSION['username'] . "' AND recipe_title LIKE '%" . $_GET['search-input'] . "%';";
		}
		else {
			$sql = "SELECT recipes.recipe_id, recipe_title, recipes.user_id, recipe_img_url, username, recipe_tags.tag_id, tag_name FROM recipes LEFT JOIN users ON users.user_id=recipes.user_id LEFT JOIN recipes_has_recipe_tags ON recipes_has_recipe_tags.recipe_id = recipes.recipe_id LEFT JOIN recipe_tags ON recipe_tags.tag_id = recipes_has_recipe_tags.tag_id WHERE username = '" . $_SESSION['username'] . "' AND tag_name LIKE '%" . $_GET['search-input'] . "%';";
		}
		
		$results = $mysqli->query($sql);
		if (!$results) {
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

	<div class="container">

		<h1 class="text-center">My Recipe Search Results</h1>

		<p class="text-center"><?php echo $results->num_rows; ?> results found for <?php echo $_GET['search-input']; ?></p>

		<div class="row justify-content-between row-custom p-3 p-md-0">

			<?php while ($row = $results->fetch_assoc()) : ?>

				<div class="col-12 col-md-6 col-lg-4 mb-4">
					<div class="notecard m-1 p-1 w-100 h-100">
						<div class="front">
							<div class="recipe-title text-center">
								<a href="recipe-details.php?user_id=<?php echo $row['user_id']; ?>&recipe_id=<?php echo $row['recipe_id']; ?>" class="title-url"><?php echo $row['recipe_title']; ?></a>
							</div>
							<div class="recipe-info">
								<img class="recipe-img" src="<?php if ( isset($row['recipe_img_url']) ) { echo $row['recipe_img_url']; } else { echo 'images/img-not-found.jpeg'; } ?>" class="img-fluid"/>
							</div>
						</div>
					</div>
				</div>

			<?php endwhile; ?>

		</div>

	</div>

	<div class="recipebox">
		<img src="images/recipebox.png" alt="recipebox"/>
	</div>

	<div class="footer text-center footer-custom">@2021 recipage, inc.</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<script>
		let urls = document.querySelectorAll(".title-url");

		for (let i = 0; i < urls.length; i++) {
			urls[i].onmouseover = function() {
				this.style.color = "#00aaff";
				this.style.fontSize = "25px";
			}

			urls[i].onmouseout = function() {
				this.style.color = "black";
				this.style.fontSize = "20px";
			}
		}
	</script>

</body>
</html>