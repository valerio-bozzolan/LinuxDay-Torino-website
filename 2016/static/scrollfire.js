$(document).ready(function () {
	if(window.location.hash) {
		return;
	}

	function showSection($el) {
		var show = $( $el ).data("show");
		console.log(show);
		var $show = $( show );
		$show.fadeTo(1200, 1);
	}

	var offset = 150;

	var asd = ['talk', 'rooms', 'fdroid', 'activities', 'where', 'price'];
	var options = [];
	for(var i=0; i<asd.length; i++) {
		$("#" + asd[i] + "-section").fadeTo(0, 0);
		options[i] = {
			selector: '#' + asd[i],
			offset: offset,
			callback: showSection
		};
	}	

	Materialize.scrollFire(options);
} );
