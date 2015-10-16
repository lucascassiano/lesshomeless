<?php

    $exec=$_POST['exec'];
    session_start();

    if($exec=="sign")
      sign($_POST['name'],$_POST['facebook_id'],$_POST["email"]);
    else if($exec=="login")
      tryLogin($_POST['name'],$_POST['facebook_id'],$_POST["email"]);
    else if($exec=="rate")
            rate($_POST["executer-id"],$_POST["receiver-id"],$_POST["score"]);
    else if($exec=="getData")
            getData($_POST["facebook-id"]);
    else if($exec=="listAll")
            listAllUsers();
    else if($exec=="getCurrentUserId"){
            getCurrentUserId();
    }

    function tryLogin($name,$facebook_id,$email){
        if(userExists($facebook_id)){
            login($facebook_id);
        }
        else{
            sign($name,$facebook_id,$email);
        }
    }

    function sign($name, $facebook_id,$email){
         include 'system_settings.php';
         $con=mysqli_connect($host,$user_name,$user_password,$database_name);

        $score = 0;
        $query = "INSERT INTO users (name,facebook_id,email,score) VALUES ('$name','$facebook_id','$email','$score')";
        $result = mysqli_query($con,$query);

        if(!$result){
            echo "##error: function SIGN -> ".mysqli_error($con);
        }
        else{

            $_SESSION["lesshomeless_user_id"] = getUser_internal_Id($facebook_id);
            echo "ok"; //user added with success
        }

    }

    function login($facebook_id){
        include 'system_settings.php';
        $con = mysqli_connect($host,$user_name,$user_password,$database_name);
        $query = "SELECT id FROM users WHERE facebook_id = $facebook_id";
        $results = mysqli_query($con,$query);

        if ($results) {
            if($results->num_rows == 0)
            {
               echo "no"; //There is no user with this facebook login
            }
            else{
                $_SESSION["lesshomeless_user_id"] = getUser_internal_Id($facebook_id);
                echo "ok"; //The user exists
            }
        }
        else{
            echo "##error: function LOGIN ->" . mysqli_error($con);
        }
    }

    //Internal calls
    function userExists($facebook_id){
        include 'system_settings.php';
        $con = mysqli_connect($host,$user_name,$user_password,$database_name);
        $query = "SELECT * FROM users WHERE facebook_id = $facebook_id";
        $results = mysqli_query($con,$query);
        // Check connection
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        else{
          if(mysqli_num_rows($results) == 0)
          {
             return false; //There is no user with this facebook login
          }
          else {
            return true;
          }
        }
    }
    //Internal calls
    function getUser_internal_Id($facebook_id){
        include 'system_settings.php';
        $con = mysqli_connect($host,$user_name,$user_password,$database_name);
        $query = "SELECT id FROM users WHERE facebook_id = $facebook_id";
        $results = mysqli_query($con,$query);

        if ($results) {
          $getid = mysqli_fetch_assoc($results);
          $id = $getid['id'];
          return $id;
        }
        else{
            return null;
        }
    }


    function rate($executer_id, $receiver_id, $score){
        include 'system_settings.php';
        $con = mysqli_connect($host,$user_name,$user_password,$database_name);
        $query = "INSERT INTO users_ratings (executer_id, receiver_id, score) VALUES ('$executer_id','$receiver_id','$score',)";
        $result = mysqli_query($con,$query);
        if(!$result){
            echo "##error: ".mysqli_error($con);
        }
        else{
          //Updating into homeless_person date
          $newScore = getUserRating($receiver_id);
          $query = "UPDATE users SET users.score = $newScore WHERE id=$receiver_id";

          echo "ok"; //rating added with success
        }

    }

    function getUserRating($facebook_id){
        include 'system_settings.php';
        $con = mysqli_connect($host,$user_name,$user_password,$database_name);
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
        $query = "SELECT * FROM users WHERE facebook_id =".$facebook_id;
        $result = mysqli_query($con,$query);
        if(!$result){
            echo "##error: ".mysqli_error($con);
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

    function listAllUsers(){
        include 'system_settings.php';
        $con = mysqli_connect($host,$user_name,$user_password,$database_name);
        $query = "SELECT * FROM users";
        $result = mysqli_query($con,$query);
        if(!$result){
            echo "##error: ".mysqli_error($con);
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

  function getCurrentUserId(){
    session_start();
    echo $_SESSION["lesshomeless_user_id"];
  }

?>
