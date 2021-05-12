function ajax(endpoint, returnFunc) {
	let httpRequest = new XMLHttpRequest();
	httpRequest.open("GET", endpoint);
	httpRequest.send();

	httpRequest.onreadystatechange = function() {
		console.log(httpRequest.readyState);
		if (httpRequest.readyState == 4) {
			if (httpRequest.status == 200) {
				returnFunc(httpRequest.responseText);
			}
			else {
				console.log("ERROR");
				console.log(httpRequest.status);
			}
		}
	}
}

function display(results) {
	let grid = document.querySelector("#grid");
	while (grid.hasChildNodes()) {
		grid.removeChild(grid.lastChild);
	}

	let strResults = JSON.parse(results);
	console.log(strResults);

	if (strResults.results.length < 20) {
		document.querySelector("#showing-results").innerHTML = strResults.results.length;
		}
	else {
			document.querySelector("#showing-results").innerHTML = 20;
	}
	document.querySelector("#total-results").innerHTML = strResults.total_results;

	if (strResults.results.length == 0) {
		let noneDiv = document.createElement("div");
		let bold = document.createElement("strong");
		bold.innerHTML = "No results found.";
		noneDiv.appendChild(bold);
		grid.appendChild(noneDiv);
	}
	else {
		for (let i = 0; i < strResults.results.length; i++) {

			let colDiv = document.createElement("div");
			colDiv.classList.add("col-6","col-md-4","col-lg-3");

			let posterRowDiv = document.createElement("div");
			posterRowDiv.classList.add("poster-div");
			// posterRowDiv.classList.add("row","poster-div");

			let posterImg = document.createElement("img");
			if (strResults.results[i].poster_path != null && strResults.results[i].poster_path != "") {
				posterImg.src = "https://image.tmdb.org/t/p/original" + strResults.results[i].poster_path;
			}
			else {
				posterImg.src = "images/not-available.jpg";
			}
			
			posterImg.alt = strResults.results[i].title + " Poster";
			posterRowDiv.appendChild(posterImg);


			let overlayDiv = document.createElement("div");
			overlayDiv.classList.add("img-overlay","p-3");
			let rating = document.createElement("p");
			rating.innerHTML = "Rating: " + strResults.results[i].vote_average;
			let numVoters = document.createElement("p");
			numVoters.innerHTML = "Number of Voters: " + strResults.results[i].vote_count;
			let summary = document.createElement("p");
			if(strResults.results[i].overview.length <= 200) {
				summary.innerHTML = strResults.results[i].overview;
			}
			else {
				summary.innerHTML = (strResults.results[i].overview).substring(0, 200) + "...";
			}
			overlayDiv.appendChild(rating);
			overlayDiv.appendChild(numVoters);
			overlayDiv.appendChild(summary);

			posterRowDiv.appendChild(overlayDiv);


			let infoDiv = document.createElement("div");
			infoDiv.classList.add("row","text-center");

			let title = document.createElement("p");
			title.classList.add("mt-1","mb-0");
			title.innerHTML = strResults.results[i].title;

			let release = document.createElement("p");
			release.classList.add("mt-0");
			release.innerHTML = strResults.results[i].release_date;

			infoDiv.appendChild(title);
			infoDiv.appendChild(release);

			colDiv.appendChild(posterRowDiv);
			colDiv.appendChild(infoDiv);

			grid.appendChild(colDiv);
		}
	}
}

let theatersEndpoint = "https://api.themoviedb.org/3/movie/now_playing?api_key=997d5afab1fcec94dbc66136953d1bee&language=en-US";
ajax(theatersEndpoint, display);



document.querySelector("#search").onsubmit = function(event) {
	event.preventDefault();

	let searchInput = document.querySelector("#search-input").value.trim();

	let searchEndpoint = "https://api.themoviedb.org/3/search/movie?api_key=997d5afab1fcec94dbc66136953d1bee&language=en-US&query=" + searchInput;

	searchEndpoint = encodeURI(searchEndpoint);

	ajax(searchEndpoint, display);

	document.querySelector("#search-input").value = "";
}