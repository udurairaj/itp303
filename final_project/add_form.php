<?php
	
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

		$sql = "SELECT user_id, username FROM users WHERE username = '" . $_SESSION['username'] . "';";
		
		$results = $mysqli->query($sql);
		if (!$results) {
			echo $mysqli->error;
			exit();
		}

		$row = $results->fetch_assoc();

		$mysqli->close();

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

		<h1 class="text-center">Add Recipe</h1>

		<form action="add_conf.php" method="POST">

			<div class="row justify-content-center">
				
				<div class="col-12 col-md-8 col-lg-7 pb-4">
					<label for="add-title" class="text-sm-right">Title: <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="add-title" name="title" value="<?php echo $_POST['recipe_title']; ?>">
					<small id="add-title-error" class="invalid-feedback">Title is required.</small>
				</div>

				<div class="col-12 col-md-8 col-lg-7 pb-4">
					<label for="add-url" class="text-sm-right">Recipe URL: <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="add-url" name="url" value="<?php echo $_POST['recipe_url']; ?>">
					<small id="add-url-error" class="invalid-feedback">Recipe URL is required.</small>
				</div>

				<div class="col-12 col-md-8 col-lg-7 pb-4">
					<label for="add-img-url" class="text-sm-right">Recipe Image (URL): </label>
					<input type="text" class="form-control" id="add-img-url" name="img-url" value="<?php echo $_POST['recipe_img_url'] ?>">
				</div>

				<div class="col-12 col-md-8 col-lg-7 pb-4">
					<label for="add-tags" class="text-sm-right">Tags: (separated by commas)</label>
					<input type="text" class="form-control" id="add-tags" name="tags">
				</div>

				<div class="col-12 col-md-8 col-lg-7 pb-5">
					<label for="add-comments" class="text-sm-right">Comments: (separated by newlines)</label>
					<textarea class="form-control" id="add-comments" name="comments" rows="3"></textarea>
				</div>

				<div class="col-12 col-md-8 col-lg-7 pb-2 text-end">
					<button type="reset" class="btn btn-light">Reset</button>
					<button type="submit" class="btn btn-primary">Add</button>
				</div>

				<input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">

			</div>

		</form>
	</div>

	<div class="footer text-center footer-custom">@2021 recipage, inc.</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<script>
		document.querySelector('form').onsubmit = function(){
			if ( document.querySelector('#add-title').value.trim().length == 0 ) {
				document.querySelector('#add-title').classList.add('is-invalid');
			} else {
				document.querySelector('#add-title').classList.remove('is-invalid');
			}

			if ( document.querySelector('#add-url').value.trim().length == 0 ) {
				document.querySelector('#add-url').classList.add('is-invalid');
			} else {
				document.querySelector('#add-url').classList.remove('is-invalid');
			}

			return ( !document.querySelectorAll('.is-invalid').length > 0 );
		}
	</script>

</body>
</html>