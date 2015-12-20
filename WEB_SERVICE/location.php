<!DOCTYPE html>
<html>
<body onload="getLocation()">

<p id="demo"></p>

<script>
var x = document.getElementById("demo");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    window.location.href = "calculatedistance.php?lat=" + position.coords.latitude + "&lng=" + position.coords.longitude;
}
</script>

</body>
</html>
