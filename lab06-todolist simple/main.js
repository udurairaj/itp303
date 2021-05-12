$.ajax({
	method: "GET",
	url: "http://api.weatherbit.io/v2.0/current",
	data: {
		key: "8045856207894322be28ef6be1e2fd75",
		units: "I",
		city: "Los Angeles,CA",
		country: "US"
	}
})
.done(function(data) {
	display(data);
}).fail(function() {
	console.log("ERROR");
});

function display(data) {
	let results = data.data[0];
	$("#temp").text(results.temp);
	$("#weather-description").text(results.weather.description);
	$("#app_temp").text(results.app_temp);
}

$("#form").on("submit", function(event) {
	event.preventDefault();
	console.log($("#input").val());
	$("ul").append("<li>X " + $("#input").val() + "</li>");
	$("#input").val("");
});