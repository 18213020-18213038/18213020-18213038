<?php
$info = array();
if(isset($_GET["lat1"]) && isset($_GET["lng1"]) && isset($_GET["lat2"]) && isset($_GET["lng2"])){
	$lat1 = $_GET["lat1"];
	$lng1 = $_GET["lng1"];
	$lat2 = $_GET["lat2"];
	$lng2 = $_GET["lng2"];
	$jarak =  distance($lat1, $lng1, $lat2, $lng2);
	array_push($info, $lat1, $lat2, $lng1, $lng2, $jarak);
}

function distance($lat1, $lng1, $lat2, $lng2) {
	$unit = 'K';
	$theta = $lng1 - $lng2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);
	return ($miles * 1.609344 *1000);
}

exit(json_encode($info));
?>


