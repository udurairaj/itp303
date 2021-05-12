<?php
	$php_array = [
		"first_name" => "Tommy",
		"last_name" => "Trojan",
		"age" => 21,
		"phone" => [
			"cell" => "123-123-1234",

			"home" => "456-456-4567"
		],
	];

	// Whatever is echoed out here is sent to the frontend as results.
	// Note: you can only echo out STRINGS
	// echo "hi";
	// echo $php_array; // doesn't work

	// convert associative array into a JSON string
	//echo json_encode($php_array);

	// Connect to the database to search for a song in the database
	$host = "303.itpwebdev.com";
	$user = "uduraira_db_user";
	$pass = "uscItp2021!";
	$db = "uduraira_song_db";

	$mysqli = new mysqli($host, $user, $pass, $db);
	if ( $mysqli->errno ) {
		echo $mysqli->error;
		exit();
	}

	// Generate the SQL based on the user's input
	$sql = "SELECT * FROM tracks WHERE name LIKE '%" . $_GET["term"] . "%' LIMIT 10;";

	$results = $mysqli->query($sql);
	if ( !$results ) {
		echo $mysqli->error;
		exit();
	}

	$mysqli->close();

	// Run the while loop to get all the results. Store the results in a nother variable
	$results_array = [];
	while ($row = $results->fetch_assoc()) {
		array_push($results_array, $row);
	}

	// Convert the associative array to a JSON string and echo it out to the frontend as results
	echo json_encode($results_array);


?>