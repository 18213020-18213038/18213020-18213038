<?php
	// Create connection
	$conn = mysql_connect('localhost', 'root', '');
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysql_error());
	} 
	mysql_select_db('progif', $conn);
	$sql = "INSERT INTO googlesigninout (id_token)
	VALUES ('$_POST[id_token]')";

	if (!mysql_query($sql, $conn)) {
		die("Connection failed: " . mysql_error());
	}
	echo "1 second added";

	mysql_close($conn);
	
?>
