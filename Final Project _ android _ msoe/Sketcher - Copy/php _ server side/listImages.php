<?php
ListImages();
function ListImages(){

$servername = "mysql.hostinger.com.br";
$username = "u222353824_admin";
$password = "monkey";
$dbname = "u222353824_base";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
	$query = "SELECT * FROM images";
	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
	
	if (mysqli_num_rows($result) > 0) {
		echo 
			"<!DOCTYPE html>
<html>
<head>
<style> 
div {
    width: 90%;
   text-align: center;
    background-color: white;
    box-shadow: 0px 5px 5px #888888;
    font-family: Arial, Helvetica, sans-serif;
    padding-top: 10px;
    padding-right: 12px;
    padding-bottom: 10px;
    padding-left: 12px;
}
</style>
</head>
<body>
<center>
";
		
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			//echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
				echo '<div>';
				echo '<h2>'.$row["title"]."</h2><br>";
				//echo "<a onClick='showAndroidToast('".$row["comment"]."')'>";
				echo '<img src = "../uploaded_images/'.$row["image_code"].'.png" boder = "0" width="80%"/><br>';
				echo '<p>'.$row["comment"].'</p>';
				echo '<p>'.$row["creation"].'</p>';
				echo '</a></div><br><br>';
		}
		
		echo "</center></body></html>";
		
	} else {
		echo "0 results";
	}

}
?>