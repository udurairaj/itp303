function ajax (citySelect) {
	$.ajax({
		method: "GET",
		url: "http://api.weatherbit.io/v2.0/current",
		data: {
			key: "8045856207894322be28ef6be1e2fd75",
			units: "I",
			city: citySelect,
			country: "US"
		}
		})
		.done(function(data) {
			display(data);
		}).fail(function() {
			console.log("ERROR");
	});
};

let citySelect;
if (localStorage.city) {
	$("#city").val(localStorage.city);
}
citySelect = $("#city :selected").text();
ajax(citySelect);


$("#city").on("change", function() {
	citySelect = $("#city :selected").text();
	localStorage.city = $("#city").val();

	ajax(citySelect);

});

$("#list").on("click", ".todo", function() {
	console.log("TEXT");
	$(this).css("color", "gray");
	$(this).prev().css("color", "gray");
	$(this).css("text-decoration", "line-through");
});

$("#list").on("click", ".space", function(event) {
	console.log("ICON");
	event.stopPropagation();
	$(this).parent().fadeOut(500, function() {
				$(this).remove();
			});
});

$(".expand").on("click", function() {
	$("#form").slideToggle(500, function() {
				console.log("slide effect finished");
			});
});

function display(data) {
	let results = data.data[0];
	$("#temp").text(results.temp);
	$("#weather-description").text(results.weather.description);
	$("#app_temp").text(results.app_temp);
};

$("#form").on("submit", function(event) {
	event.preventDefault();
	$("#list").append("<div class='item'>" + 
		"<i class='far fa-times-circle space'></i>"
		+ "<span class='todo'> "
		+ $("#input").val() + "</span></div>");

	$("#input").val("");
});