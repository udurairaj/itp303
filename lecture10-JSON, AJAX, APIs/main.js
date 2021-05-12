function displayResults(results) {
			
	// clear out all previous results before displaying new ones
	// hasChildNodes() - returns true/false
	let tbody = document.querySelector("tbody");
	while (tbody.hasChildNodes()) {
		tbody.removeChild(tbody.lastChild);
	}

	console.log(results);
	// results are currently a STRING in JSON format --> convert this string into JS objects
	let convertedResults = JSON.parse(results);
	console.log(convertedResults);
	console.log(convertedResults.results[0].artistName);

	// iterate through results, create new elements per result
	for (let i = 0; i < convertedResults.results.length; i++) {
		// create <tr> tag
		let trTag = document.createElement("tr");

		// create a <td> tag for album art
		let coverTd = document.createElement("td");
		// create an <img> for the album art image
		let imgTag = document.createElement("img");
		imgTag.src = convertedResults.results[i].artworkUrl100;
		// append the img to the td tag
		coverTd.appendChild(imgTag);

		// create <td> tag for the artist
		let artistTd = document.createElement("td");
		artistTd.innerHTML = convertedResults.results[i].artistName;

		// create <td> tag for the track
		let trackTd = document.createElement("td");
		trackTd.innerHTML = convertedResults.results[i].trackName;

		// create <td> tag for the album name
		let albumTd = document.createElement("td");
		albumTd.innerHTML = convertedResults.results[i].collectionName;

		// create <td> tag for the audio
		let audioTd = document.createElement("td");
		let audioTag = document.createElement("audio");
		audioTag.src = convertedResults.results[i].previewUrl;
		audioTag.controls = true;
		// append audio tag to audio TD tag
		audioTd.appendChild(audioTag);

		// append all td tags to the tr
		trTag.appendChild(coverTd);
		trTag.appendChild(artistTd);
		trTag.appendChild(trackTd);
		trTag.appendChild(albumTd);
		trTag.appendChild(audioTd);

		console.log(trTag);

		// append tr tag to <tbody> to make it show up in browser
		tbody.appendChild(trTag);
	}
}

// separate function for AJAX
// first param is endpoint, second param is the name of function that runs after we get a response
function ajax(endpoint, returnFunction) {
	// make AJAX request using the XMLHttpRequest object
	let httpRequest = new XMLHttpRequest();

	// open() opens a new http request - two parameters: 1) METHOD, 2) endpoint
	httpRequest.open("GET", endpoint);
	// send() sends the request to the specified endpoint
	httpRequest.send();

	// create an event handler so that when iTunes responds, we make it run some code
	httpRequest.onreadystatechange = function() {
		// state 4 means full response back
		console.log(httpRequest.readyState);
		// readyState == 4 when we have a full response from iTunes
		if (httpRequest.readyState == 4) {
			// check if we got a success or error response from iTunes (200 means success)
			if (httpRequest.status == 200) {
				// .responseText will give us whatever iTunes sent back to us as a STRING
				//console.log(httpRequest.responseText);
				returnFunction(httpRequest.responseText);
			}
			else {
				console.log("ERROR");
				console.log(httpRequest.status);
			}
		}
	}
}

// when user submits the search form
document.querySelector("#search-form").onsubmit = function(event) {
	// prevent form from actually submitting
	event.preventDefault();
	//console.log("submitted!");

	// store user input
	let searchInput = document.querySelector("#search-id").value.trim();
	let limitInput = document.querySelector("#limit-id").value;
	//console.log(searchInput);
	//console.log(limitInput);

	let endpoint = "https://itunes.apple.com/search?term=" + searchInput + "&limit=" + limitInput;

	// call the ajax function
	ajax(endpoint, displayResults);

	//console.log("hi");
}