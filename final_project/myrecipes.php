<?php
	require 'config/config.php';

	if (isset($_SESSION["logged_in"]) || $_SESSION["logged_in"]) {

		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}

		$mysqli->set_charset('utf8');

		$sql = "SELECT recipe_id, recipe_title, recipe_url, recipes.user_id, recipe_img_url, username FROM recipes LEFT JOIN users ON users.user_id=recipes.user_id WHERE username = '" . $_SESSION['username'] . "';";
		
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

	<div id="search-form" class="pb-3">
		<label for="search" id="search-label">Search recipes:</label>
		<form id="search" class="w-100" method="GET" action="recipe_search.php?user_id=<?php $_GET['user_id']; ?>">
			<div class="row">
				<div class="col-12">
					<input type="text" id="search-input" name="search-input" placeholder="title or tag" />
					<button type="submit" id="go-button" class="btn btn-outline-primary btn-custom">Search</button>
					<small id="search-input-error" class="invalid-feedback">Please enter a term to search by title or tag.</small>
				</div>
				<div class="col-12 text-start ps-4">
			    <input type="radio" id="radio-title"
			     name="search-type" value="title" checked>
			    <label for="radio-title" class="typeradio">Search by title</label>

			    <input type="radio" id="radio-tag"
			     name="search-type" value="tag">
			    <label for="radio-tag" class="typeradio">Search by tag</label>
			  </div>
			 </div>
		</form>
	</div>

	<div class="container">

		<div class="row justify-content-between row-custom p-3 p-md-0">

			<?php if ($results->num_rows == 0): ?>
				<p>Your recipe box is empty. Start adding new recipes now! Try to <a href="add_custom_form.php" class="link">add a recipe</a> or <a href="search-ing.php" class="link">search by ingredient</a>!</p>
			<?php endif; ?>

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
		document.querySelector('form').onsubmit = function(){
			if ( document.querySelector('#search-input').value.trim().length == 0 ) {
				document.querySelector('#search-input').classList.add('is-invalid');
			} else {
				document.querySelector('#search-input').classList.remove('is-invalid');
			}

			return ( !document.querySelectorAll('.is-invalid').length > 0 );
		}


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