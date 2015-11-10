<?php
	include 'system_settings.php';

	// Create connection
	    $con=mysqli_connect($host,$user_name,$user_password,$database_name);

	    // Check connection
	    if (mysqli_connect_errno()) {
	        return "Failed to connect to MySQL: " . mysqli_connect_error();
	    }

	    else{
				$query = "SELECT * FROM situation JOIN users ON situation.reporter_id = users.id";
	        $result = mysqli_query($con,$query);
			$rows = array();
			while($r = mysqli_fetch_assoc($result)) {
			    $rows[] = $r;
			}
			print json_encode($rows);
  	    }

?>
