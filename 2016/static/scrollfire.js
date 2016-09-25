$(document).ready(function () {
	$("#map").hide();
} );

var options = [ {
	selector: '#map',
	offset: 100,
	callback: function(el) {
		$("#map").show("slow");
	}
} ];
Materialize.scrollFire(options);

