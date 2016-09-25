$(document).ready(function () {
	$("#where-section").hide();
	var options = [ {
		selector: '#where-section',
		offset: 0,
		callback: function(el) {
			$(el).slideDown("slow");
		}
	} ];
	Materialize.scrollFire(options);
} );
