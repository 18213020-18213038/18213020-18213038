<?php
	if (isset($_GET["lat1"]) && isset($_GET["lng1"]) && isset($_GET["lat2"]) && isset($_GET["lng2"])) {
		$info = file_get_contents('http://localhost/tes/calculatedistance-server.php?lat1=' . $_GET["lat1"] . '&lng1=' . $_GET["lng1"] . '&lat2=' . $_GET["lat2"] . '&lng2=' . $_GET["lng2"]);
		$info = json_decode($info,true);
	}

	if (isset($_GET["lat"]) && isset($_GET["lat"])){
		$lat = $_GET["lat"];
		$lng = $_GET["lng"];
	}
?>
<?php
function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

$user_ip = getUserIP();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> Finding Location & Distance | KM-ITB </title>

	<link href="css/association.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/half-slider.css" rel="stylesheet">
	
	<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
    <script type="text/javascript">
	var customIcons = {
      restaurant: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
      },
      bar: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png'
      }
    };

    function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(-6.89038,107.6104),
        zoom: 17,
        mapTypeId: 'hybrid'
      });
      var infoWindow = new google.maps.InfoWindow;

      // Change this depending on the name of your PHP file
      downloadUrl("phpsql_genxml.php", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var name = markers[i].getAttribute("name");
          var address = markers[i].getAttribute("address");
          var type = markers[i].getAttribute("type");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = "<b>" + name + "</b> <br/>" + address;
          var icon = customIcons[type] || {};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });
          bindInfoWindow(marker, map, infoWindow, html);
        }
      });
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}
    </script>
</head>

<body onload="load()">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <div class="title">
					<a class="navbar-brand" href="#">KM-ITB</a>
				</div>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
               </div>
        </div>
    </nav>

	
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
				<div class="menu-bar">
					<div class= "logo">
						<img id="logo-img" src="assets/logo.gif"></img>
					</div>
					<div class= "menu">
							<ul class="nav nav-pills">
								<li><a href="index.html">Home</a></li>
								<li><a href="#">Event</a></li>
								<li><a href="#">Open Data</a></li>
								<li><a href="#">Kader</a></li>
							</ul>
					</div>
				</div>
            </div>
        </div>
	</div>
	
	<div class="container">
	<div class="about">
				<div class="main">
					<div class="kiri-abt">
						<h3>Location Tracking & Finding Distance</h3>
						<p align="justify">Untuk mencari jarak antara dua buah lokasi, anda perlu untuk mengetahui latitude dan longitude dari masing-masing lokasi. Setelah anda mengetahui latitude dan longitude dari kedua posisi, anda dapat mengisinya di form sebelah.</p>
						<p align="justify">Setiap posisi mempunyai latitude dan longitudenya masing-masing. Ibarat sebuah titik memiliki absis dan ordinat (x,y), maka setiap posisi memiliki latitude dan longitude (lat, lng). Jika anda ingin mencari posisi anda dimana, anda dapat mengklik 'Track Location' disamping.</p>
						<p align="justify">Dikarenakan tempat-tempat di dalam ITB tidak masuk ke database google maps, maka anda dapat melihat informasi latitude dan longitude dari tempat-tempat di dalam ITB dengan mengklik marker dari google maps di bawah.</p>
						<p align="justify">Anda dapat melihat informasi dari tempat-tempat yang telah terdaftar dalam google maps dengan hanya meng-klik icon-icon pada maps di bawah dan pilih 'View on Google Maps'.</p>
						<hr>
						<h2 align="center">Peta Institut Teknologi Bandung</h2>
						<marquee behavior="alternate" bgcolor="gray"><font color="white"><font face="courier" font size="4"><b><i>Click the markers to see latitude and longitude!</b></i></font></marquee>
						<pr></pr>
						<div id="map" style="width: 745px; height: 720px"></div>
						<br>
					</div>
				</div>
				<div class="aside">
					<div class="kanan-abt">
						<h3>Referensi Lokasi</h3>
						<br>
						<center>
						<form action="location.php">
						<fieldset style="width:350px">
						<legend><font face="times new roman" font size="5"><b>My Location Now</b></font></legend>
						<br>
						<font face="times new roman" font size="3"><b>Your IP Information :</b></font>
						<br>
						<br><font color="black"><font face="courier" font size="2"><b><?php if(isset($user_ip)) echo "IP Address  : " . $user_ip; ?></b></font>
						<br><font color="blue"><font face="courier" font size="2"><b><?php if(isset($lat)) echo "Latitude  : " . $lat . "<br>"; ?></b></font>
						<font color="blue"><font face="courier" font size="2"><b><?php if(isset($lng)) echo "Longitude : " . $lng . "<br>"; ?></b></font>
						<br>
						<input type="submit" name="submit" value="Track Location..." />
						<br><br>
						<div class='short_explanation'><a href='location.php' >Refresh!</a></div>
						<br>
						</fieldset>
						</form>
						<br>
						<font color ="black">
						<form action="calculatedistance.php" method="get">
						<fieldset style="width:350px">
						<legend><font face="times new roman" font size="5"><b>Find Distance</b></font></legend>
						<br><font face="calibri" font size="3"><b><u>Location 1</u></b></font>
						<br>
						<div class='container'>
							<label for='lat1' >Latitude 1: </label><br/>
							<div class='short_explanation'><font size ="2">* required fields</font></div>
							<input type='text' name='lat1' value='<?php if(isset($info[0])) echo $info[0]?>' required/><br/>
						</div>
						<br>
						<div class='container'>
							<label for='lng1' >Longitude 1: </label><br/>
							<div class='short_explanation'><font size ="2">* required fields</font></div>
							<input type='text' name='lng1' value='<?php if(isset($info[2])) echo $info[2]?>' required/><br/>
						</div>
						<br>
						<br>
						<font face="calibri" font size="3"><b><u>Location 2</u></b></font>
						<br>
						<div class='container'>
							<label for='lat2' >Latitude 2: </label><br/>
							<div class='short_explanation'><font size ="2">* required fields</font></div>
							<input type='text' name='lat2' value='<?php if(isset($info[1])) echo $info[1]?>' required/><br/>
						</div>
						<br>
						<div class='container'>
							<label for='lng2' >Longitude 2: </label><br/>
							<div class='short_explanation'><font size ="2">* required fields</font></div>
							<input type='text' name='lng2' value='<?php if(isset($info[3])) echo $info[3]?>' required/><br/>
						</div>
						<br>
						</font>
						<input type="submit" name="submit" value="Submit" />
						<br><br><font color="red"><font face="courier" font size="2"><b><?php if(isset($info[4])) echo "Jarak : " . $info[4] . " Meters<br><br>"; ?></b></font>
						<font face="calibri" font size="2" font color="black">To find distance you will need to know latitude and longitude from the places</font>
						<br>
						<br>
						<div class='short_explanation'><a href='calculatedistance.php' >Isi Ulang!</a></div>
						</fieldset>
						</form>
						</font>
						<br>
						</center>
					</div>
				</div>
	</div>
	</div>

    <!-- Page Content -->
    <div class="container">
	<div class="center">
		<div class="social-media">
			<a href='https://www.facebook.com/ITB.KM'><img id="icon-fb" src="assets/home/icon-fb.png"></img></a>
			<a href='http://mail.google.com'><img id="icon-mail" src="assets/home/icon-mail.png"></img></a>
			<a href='https://www.instagram.com/km_itb/'><img id="icon-ig" src="assets/home/icon-ig.png"></img></a>	
		</div>
	</div>
	
	</div>
	
        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="copyright">
						<p>Sistem dan Teknologi Informasi 2013</p>
					</div>
            </div>
        </footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

</body>

</html>
