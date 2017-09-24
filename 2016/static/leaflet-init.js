// Linux Day 2016 - Leaflet.js init
// Copyright (C) 2016 Valerio Bozzolan
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
$(document).ready(function () {
	$map = $("#map");
	lat = $map.data("lat");
	lng = $map.data("lng");
	z   = $map.data("zoom");
	lat || $.error("Missing lat");
	lng || $.error("Missing lng");
	z   || $.error("Missing z");
	var center = L.latLng(lat, lng);
	var url = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	var thanks = 'Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var map = L.map('map', {
 		scrollWheelZoom: false
	} );
	map.setView(center, z);
	map.addLayer( new L.TileLayer(url, {
		minZoom: 10,
		maxZoom: 19,
		attribution: thanks
	}));
	var ldIcon = L.icon({
		iconUrl:   '/2016/static/linuxday-64.png',
		shadowUrl: '/2016/static/linuxday-64-shadow.png',
		iconSize:     [27,   32], // size of the icon
		shadowSize:   [50,   32], // size of the shadow
		iconAnchor:   [13,   26], // point of the icon which will correspond to marker's location
		shadowAnchor: [11,   29],  // the same for the shadow
		popupAnchor:  [-3,  -76] // point from which the popup should open relative to the iconAnchor
	});
	L.marker(center, {icon: ldIcon}).addTo(map);
});
