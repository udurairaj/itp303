<?php

	session_start();

	$data = array (
		"ingredients" => $_GET['ingredients'],
		"number" => 15,
		"apiKey" => "1ad6f9e50cd34e61af156740d95bec14",
	);

	$url = "https://api.spoonacular.com/recipes/findByIngredients?" . http_build_query($data);

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true
	));

	$response = curl_exec($curl);
	$response = json_decode($response, true);

	$ids = array();

	$filteredResponse = array();

	foreach ($response as $result) {
		$ids[] = $result["id"];
	}

	foreach ($ids as $id) {
		$url2 = "https://api.spoonacular.com/recipes/" . $id . "/information?includeNutrition=false&apiKey=1ad6f9e50cd34e61af156740d95bec14";

		$curl2 = curl_init();
		curl_setopt_array($curl2, array(
			CURLOPT_URL => $url2,
			CURLOPT_RETURNTRANSFER => true
		));

		$response2 = curl_exec($curl2);
		$response2 = json_decode($response2, true);

		$recipeInfo = array (
			"title" => $response2["title"],
			"image" => $response2["image"],
			"sourceUrl" => $response2["sourceUrl"]
		);

		$filteredResponse[] = $recipeInfo;
	}
	echo json_encode($filteredResponse);

?>