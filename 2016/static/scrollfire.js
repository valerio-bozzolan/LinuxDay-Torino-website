$(document).ready(function () {
	$("#map-section").fadeTo(0, 0);
	$("#talk-section").fadeTo(0, 0);
	$("#activities-section").fadeTo(0, 0);
	$("#price-section").fadeTo(0, 0);

	function showSection($el) {
		var show = $( $el ).data("show");
		console.log(show);
		var $show = $( show );
		$show.fadeTo(1200, 1);
	}

	var offset = 20;

	var options = [
		{
			selector: '#map',
			offset: offset,
			callback: showSection
		},
		{
			selector: '#talk',
			offset: offset,
			callback: showSection
		},
		{
			selector: '#activities',
			offset: offset,
			callback: showSection
		},
		{
			selector: '#price',
			offset: offset,
			callback: showSection
		}
	];
	Materialize.scrollFire(options);
} );
