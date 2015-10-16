<?php
  //This class handles the Homeless people data
  $exec = "register";
  //$exec=$_POST['exec'];

  session_start();

  if($exec=="register")
      register($_POST['name'],$_POST['rg'],$_POST['cpf'],$_POST['birth_date'],$_POST['registered_by']);

  else if($exec=="getData")
      getData($_POST["facebook-id"]);

  else if($exec=="rate"){
    if(!$_POST["executer_id"]){
      $executer_id = $_SESSION["lesshomeless_user_id"];
    }
    else{
      $executer_id = $_POST["executer_id"];
    }

    rate($executer_id,$_POST["receiver_id"],$_POST["score"]);
  }

  else if($exec=="listAll") listAllHomelessPeople();

//Create a new register for a homeless person
      function register($name, $rg, $cpf, $birth_date, $registered_by){
       include 'system_settings.php';
       $con=mysqli_connect($host,$user_name,$user_password,$database_name);
       //Check if homeless person is already on system
       if(!homelessExists($name,$cpf,$rg)){
         $query = "INSERT INTO homeless_person (name,rg,cpf,birth_date,registered_by_user_id) VALUES ('$name','$rg','$cpf','$birth_date','$registered_by')";
         $result = mysqli_query($con,$query);

         if(!$result){
             echo "error: ".mysqli_error($con);
         }
         else
             echo "ok"; //new record created
      }
      else{
        echo "already exists"; //homeless person already exists on the system
      }

      }

      //Internal Call
      function homelessExists($name,$cpf, $rg){
        include 'system_settings.php';
        $con = mysqli_connect($host,$user_name,$user_password,$database_name);
        $query = "SELECT * FROM homeless_person WHERE name = '$name' OR rg = '$rg' OR cpf='$cpf'";
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

      function getData($homeless_id){
        if(!homelessExists($homeless_id)){
            die "##invalid homeless person id";
        }
        else{
          include 'system_settings.php';
          $con = mysqli_connect($host,$user_name,$user_password,$database_name);
          $query = "SELECT * FROM homeless_person WHERE id = $homeless_id";
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
      }

      function rate($executer_id, $receiver_id, $score){
          include 'system_settings.php';
          $con = mysqli_connect($host,$user_name,$user_password,$database_name);
          $query = "INSERT INTO homeless_ratings (executer_id, receiver_id, score) VALUES ('$executer_id','$receiver_id','$score',)";
          $result = mysqli_query($con,$query);
          if(!$result){
              echo "##error: ".mysqli_error($con);
          }
          else{
            //Updating into homeless_person date
            $newScore = getHomelessRating($receiver_id);
            $query = "UPDATE homeless_person SET homeless_person.score = $newScore WHERE id=$receiver_id";

            echo "ok"; //rating added with success
          }

      }

      function getHomelessRating($homeless_id){
          include 'system_settings.php';
          $con = mysqli_connect($host,$user_name,$user_password,$database_name);
          $query = "SELECT AVG(homeless_ratings.score) AS rate FROM
              homeless JOIN homeless_ratings
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
      }

      function listAllHomelessPeople(){
          include 'system_settings.php';
          $con = mysqli_connect($host,$user_name,$user_password,$database_name);
          $query = "SELECT * FROM homeless_person";
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

    function searchHomeless(){

    }
?>
