<?php
$function =  $_POST["function"];
if($function == "CreateUser"){
	CreateUser();
}
if($function == "AddImage"){
	AddImage();
}

function CreateUser(){

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
	$user_code =  GenerateRandomString();
	$exists = false;
	$query = "SELECT COUNT(*) AS num FROM users WHERE user_code = '".$user_code."'";
	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
	if($row = mysqli_fetch_array($result)){
		if($row['num'] == 0){
			$exists = false;
		}
		else{
			$exists = true;
		}
	}

	while($exists){
		$user_code =  GenerateRandomString();
		$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
		if($row = mysqli_fetch_array($result)){
			if($row['num'] == 0){
				$exists = false;
			}
			else{
				$exists = true;
			}
		}
	}

	if($exists == false){
		$insert = "INSERT INTO users (user_code, user_creation) VALUES ('".$user_code."', NOW())";
		if(mysqli_query($conn, $insert)){
			echo $user_code;
		}
		else{
			echo "ERROR";
		}
	}

}

function AddImage(){
	$data = $_POST['data'];
	$title = $_POST['title'];
	$comment = $_POST['comment'];
	$author  = $_POST['author'];
	$category  = $_POST['category'];

	$servername = "mysql.hostinger.com.br";
	$username = "u222353824_admin";
	$password = "monkey";
	$dbname = "u222353824_base";

	/*
	$data = 'iVBORw0KGgoAAAANSUhEUgAAABwAAAASCAMAAAB/2U7WAAAABl'
       . 'BMVEUAAAD///+l2Z/dAAAASUlEQVR4XqWQUQoAIAxC2/0vXZDr'
       . 'EX4IJTRkb7lobNUStXsB0jIXIAMSsQnWlsV+wULF4Avk9fLq2r'
       . '8a5HSE35Q3eO2XP1A1wQkZSgETvDtKdQAAAABJRU5ErkJggg==';
	   */

	$data = base64_decode($data);

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$imageCode = GenerateRandomString();
	$exists = false;

	$query = "SELECT COUNT(*) AS num FROM images WHERE image_code= '".$imageCode."'";
	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
	if($row = mysqli_fetch_array($result)){
		if($row['num'] == 0){
			$exists = false;
		}
		else{
			$exists = true;
		}
	}

	while($exists){
		$imageCode =  GenerateRandomString();
		$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
		if($row = mysqli_fetch_array($result)){
			if($row['num'] == 0){
				$exists = false;
			}
			else{
				$exists = true;
			}
		}
	}

	if($exists == false){
		/*
			$data = $_POST['data'];
	$title = $_POST['title'];
	$comment = $_POST['comment'];
	$author*/

		$insert = "INSERT INTO images (image_code, author_code, title,comment,category,creation) VALUES ('"
			.$imageCode."','".$author."','"
			.$title."','"
			.$comment."','"
			.$category."',"
			." NOW())";

		if(mysqli_query($conn, $insert)){
			$im = imagecreatefromstring($data);
			if ($im !== false) {
				//header('Content-Type: image/png');
				imagepng($im,"../uploaded_images/".$imageCode.".png");
				imagedestroy($im);
				echo "OK";
			}
			else {
				echo 'An error occurred.';
			}
		}
		else{
			echo "ERROR: ".mysqli_error($conn);
		}
	}

}


function GenerateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}


	//CreateUser();
	//AddImage();
?>
