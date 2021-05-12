<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Intro to PHP</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Intro to PHP</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">
		<div class="row">

			<h2 class="col-12 mt-4 mb-3">PHP Output</h2>

			<div class="col-12">
				<!-- Display Test Output Here -->

				<?php

					// Write PHP here

					// echo prints strings out to the browser
					echo "Hello World";
					// can echo HTML tags
					echo "<strong>Hello World!</strong>";
					echo "<hr>";

					// VARIABLES
					$name = "Tommy";
					$age = 5;
					echo $name;
					echo "<hr>";

					// concatenation - combine strings - use period
					echo "My name is " . $name;
					echo "<hr>";

					// var_dump also prints out to the browser, but it also prints out the data type
					var_dump($name);
					echo "<hr>";

					// can create strings with double quotes OR single quotes

					// double quotes -- you can utilize variable interpolation, meaning it can read variables within the string
					echo "My name is $name";
					echo "<hr>";

					// single quotes -- everything is literal
					echo 'My name is $name';
					echo "<hr>";


					// DATE/TIME

					// set the default timezone for this web application - can use timezones like PST, UTC, etc or can use cities like America/Los_Angeles
					// See full list of supported timezones here: https://www.php.net/manual/en/timezones.php
					date_default_timezone_set("America/Los_Angeles");

					// Get the current time
					// Formatting option list here: https://www.php.net/manual/en/datetime.format.php
					echo date("m-d-Y, H:i:s T");
					echo "<hr>";


					// ARRAYS
					$colors = ["red", "blue", "green"];
					echo $colors[0];
					echo "<hr>";

					for ($i = 0; $i < sizeof($colors); $i++) {
						echo $colors[$i] . " ";
					}
					echo "<hr>";


					// ASSOCIATIVE ARRAYS - arrays with STRING KEYS (similar to map/dict)
					$courses = [
						"ITP 303" => "Full-Stack Web Development",
						"ITP 404" => "Advanced Front-End Web Development",
						"ITP 405" => "Advanced Back-End Web Development"
					];

					echo $courses["ITP 303"];
					echo "<hr>";

					// loop through an associative array with foreach loop
					foreach ( $courses as $courseNumber => $courseName ) {
						echo $courseNumber . ": " . $courseName;
						echo "<br>";
					}

					echo "<hr>";

					foreach ($courses as $course) {
						echo $course;
						echo "<br>";
					}
					echo "<hr>";


					// echo cannot print out full arrays
					// echo $courses;
					// use var_dump to quickly see what's inside an array without having to run a foreach loop
					var_dump($courses);
					echo "<hr>";



					// SUPERGLOBALS - built in global variables that can be accessed at any time
					var_dump($_SERVER);
					echo "<hr>";

					echo $_SERVER["HTTP_USER_AGENT"];
					echo "<hr>";

					echo "GET superglobal: ";
					var_dump($_GET);
					echo "<hr>";

					echo "POST superglobal: ";
					var_dump($_POST);
					echo "<hr>";
				?>

			</div>

		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">
		<div class="row">

			<h2 class="col-12 mt-4">Form Data</h2>

		</div> <!-- .row -->

		<div class="row mt-3">
			<div class="col-3 text-right">Name:</div>
			<div class="col-9">
				<!-- Display Form Data Here -->
				<?php
					if (isset($_POST["name"]) && !empty($_POST["name"])) {
						echo $_POST["name"];
					}
					else {
						echo "<div class='text-danger'>Name is empty</div>";
					}
					
				?>

			</div>
		</div> <!-- .row -->
		<div class="row mt-3">
			<div class="col-3 text-right">Email:</div>
			<div class="col-9">
				<!-- Display Form Data Here -->
				<?php
					if (isset($_POST["email"]) && !empty($_POST["email"])) {
						echo $_POST["email"];
					}
					else {
						echo "<div class='text-danger'>Email is empty</div>";
					}
					
				?>

			</div>
		</div> <!-- .row -->
		<div class="row mt-3">
			<div class="col-3 text-right">Current Student:</div>
			<div class="col-9">
				<!-- Display Form Data Here -->
				<?php
					if (isset($_POST["current-student"]) && !empty($_POST["current-student"])) {
						echo $_POST["current-student"];
					}
					else {
						echo "<div class='text-danger'>Current student is not selected</div>";
					}
					
				?>

			</div>
		</div> <!-- .row -->
		<div class="row mt-3">
			<div class="col-3 text-right">Subscribe:</div>
			<div class="col-9">
				<!-- Display Form Data Here -->
				<?php
					if (isset($_POST["subscribe"]) && !empty($_POST["subscribe"])) {
						foreach ($_POST["subscribe"] as $subscribe) {
							echo $subscribe . " ";
						}
					}
					else {
						echo "<div class='text-danger'>No subscriptions selected</div>";
					}
					
				?>

			</div>
		</div> <!-- .row -->
		<div class="row mt-3">
			<div class="col-3 text-right">Subject:</div>
			<div class="col-9">
				<!-- Display Form Data Here -->
				<?php
					if (isset($_POST["subject"]) && !empty($_POST["subject"])) {
						echo $_POST["subject"];
					}
					else {
						echo "<div class='text-danger'>Subject is not selected</div>";
					}
					
				?>
				
			</div>
		</div> <!-- .row -->
		<div class="row mt-3">
			<div class="col-3 text-right">Message:</div>
			<div class="col-9">
				<?php
					if (isset($_POST["msg"]) && !empty($_POST["msg"])) {
						echo $_POST["msg"];
					}
					else {
						echo "<div class='text-danger'>Message is empty</div>";
					}
					
				?>
				
			</div>
		</div> <!-- .row -->

		<div class="row mt-4 mb-4">
			<a href="form.php" role="button" class="btn btn-primary">Back to Form</a>
		</div> <!-- .row -->

	</div> <!-- .container -->
	
</body>
</html>