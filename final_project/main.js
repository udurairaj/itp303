const $grid = $("#recipe-grid");

function loadRecipes (ingredients) {
	$.ajax({
		method: "GET",
		url: "search-ing_backend.php",
		data: {
			ingredients: ingredients,
		},
	}).done(function(response) {
		response = JSON.parse(response);
		$grid.html("");

		for (let recipe of response) {
			const recipeHTML = `<div class="col-12 col-md-6 col-lg-4 mb-4">
				<div class="notecard m-1 p-1 w-100 h-100">
					<div class="recipe-title text-center">
						<p>${recipe.title}</p>
					</div>
					<div class="recipe-info">
						<img class="recipe-img" src="${recipe.image}"/>
						<div class="recipe-url-div">
							<p class="recipe-url"><a href="${recipe.sourceUrl}" target="_blank">${recipe.sourceUrl}</a></p>
						</div>
					</div>
					<div class="container">
						<form action="add_form.php" method="POST">
							<input type="hidden" name="recipe_title" value="${recipe.title}">
							<input type="hidden" name="recipe_url" value="${recipe.sourceUrl}">
							<input type="hidden" name="recipe_img_url" value="${recipe.image}">
							<div class="col-12 text-end add-btn align-middle">
								<button type="submit" class="btn btn-primary">Add to My Recipes</button>
							</div>
						</form>
					</div>
				</div>
			</div>`;
			$grid.append(recipeHTML);
		}

	});
}

$("#search-ing").on("submit", function(event) {
	event.preventDefault();
	const searchInput = $("#search-ing-input").val();
	$(".loading").addClass("visible");
	$(".recipebox-animated").addClass("animate");
	loadRecipes(searchInput);
});