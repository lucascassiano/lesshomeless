<?php
//xmlhttp.open("POST", "functions.php?name="+somename, true);
    // Create connection	    
    
    $exec = "sign";
    //$exec=$_POST['exec'];
    // Check connection
    if (mysqli_connect_errno()) {
        return "Failed to connect to MySQL: " . mysqli_connect_error();
    }   
    else{
        
        if($exec=="sign") sign("lucas 2",6);
            //sign($_POST['name'],$_POST['facebook-id']);
        else if($exec=="login")login(2);
            //login($_POST['facebook-id']);
        else if($exec=="rate")rate(9,8,5);
            //rate($_POST["executer-id"],$_POST["receiver-id"],$_POST["score"]);
        else if($exec=="getData") getData(4);
            //getData($_POST["user-id"]);
            

    }
    
    function sign($name, $facebook_id,$email){
         include 'system_settings.php'; 
    $con=mysqli_connect($host,$user_name,$user_password,$database_name);
        //connect();
        $score = 0;
        $date =  date( 'Y-m-d H:i:s');
        $phpdate = strtotime( $date );
        
        $query = "INSERT INTO users (name,facebook_id,email,score)  VALUES ('$name','$facebook_id','$email','$score')";
        $result = mysqli_query($con,$query);
        
        if(!$result){
            echo "error: ".mysqli_error($con);
        }
        else
            echo "ok"; //user added with success
    }

    function login($facebook_id){
        include 'system_settings.php'; 
        $con = mysqli_connect($host,$user_name,$user_password,$database_name);
        $query = "SELECT facebook_id, id FROM users WHERE facebook_id = ".$facebook_id;
        $results = mysqli_query($con,$query);
        if ($results) { 
            if($results->num_rows === 0)
            {
               echo "no"; //There is no user with this facebook login
            }
            else{
                echo "ok"; //The user exists
                $client_ip = get_client_ip();
                $row = mysqli_fetch_array($results);
                $user_id = $row["id"];
                $date = new DateTime('d/m/Y $ H:i:s');
                $query_log = "INSERT INTO login-log (user_id, date, user_ip) VALUES (".$row["id"].")"; 
            }
        }
        else{
            echo "error: " . mysqli_error($con);
        }
    }
    
    //Internal calls
    function userExists($facebook_id){
        include 'system_settings.php'; 
        $con = mysqli_connect($host,$user_name,$user_password,$database_name);
        $query = "SELECT facebook_id, id FROM users WHERE facebook_id = ".$facebook_id;
        $results = mysqli_query($con,$query);
        if ($results) { 
            if($results->num_rows === 0)
            {
               return false; //There is no user with this facebook login
            }
            else{
                return true; 
            }
        }
        else{
            return false;
        }
    }

    function TryLogin($name,$facebook_id,$email){
        if(userExists($facebook_id)){
            login($name,$facebook_id,$email);
        }
        else{
            sign($name,$facebook,$email);
        }
    }

    function rate($executer_id, $receiver_id, $score){
        include 'system_settings.php'; 
        $con = mysqli_connect($host,$user_name,$user_password,$database_name);
        $date = date('yyyy-mm-dd hh:mm:ss');
        $query = "INSERT INTO users_ratings (executer_id, receiver_id, score) VALUES ('$executer_id','$receiver_id','$score',)";
        $result = mysqli_query($con,$query);
        if(!$result){
            echo "error: ".mysqli_error($con);
        }
        else
            echo "ok"; //rating added with success
    }
    
    function getUserRating($facebook_id){
        include 'system_settings.php'; 
        $con = mysqli_connect($host,$user_name,$user_password,$database_name);
        $date = date('yyyy-mm-dd hh:mm:ss');
        $query = "SELECT AVG(user_ratings.score) AS rate FROM 
            users JOIN users_ratings
                ON users.id = users_ratings.receiver_id
            WHERE users.facebook_id = '$facebook_id'
            GROUP BY users.facebook_id";
        
        $result = mysqli_query($con,$query);
        if(!$result){
            return 0;
        }
        else{
            $getRate = mysqli_fetch_assoc($result);
            $rate = $getRate['rate'];
            return $rate;
        }
             //rating added with success
    }

    function getData($facebook_id){
        include 'system_settings.php'; 
        $con = mysqli_connect($host,$user_name,$user_password,$database_name);
        $date = date('yyyy-mm-dd hh:mm:ss');
        $query = "SELECT * FROM users WHERE facebook_id =".$facebook_id;
        $result = mysqli_query($con,$query);
        if(!$result){
            echo "error: ".mysqli_error($con);
        }
        else{
            //Encode to JSON
            $rows = array();
            while($r = mysqli_fetch_assoc($result)) {
               $rows[] = $r;
            }
            print json_encode($rows);
        }
    }
	        
	    


?>