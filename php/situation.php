<?php
  //This class handles the Situations

  $exec=$_POST['exec'];
  session_start();

  if($exec=="add"){
    if(!$_POST["reporter_id"]){
      $reporter_id = $_SESSION["lesshomeless_user_id"];
    }
    else{
      $reporter_id = $_POST["reporter_id"];
    }

    add($_POST['title'],$_POST['latitude'],$_POST['longitude'],$reporter_id);
  }

  else if($exec=="getData"){
    getData($_POST["facebook-id"]);
  }

  else if($exec=="rate"){
    if(!$_POST["executer_id"]){
      $executer_id = $_SESSION["lesshomeless_user_id"];
    }
    else{
      $executer_id = $_POST["executer_id"]
    }

    rate($executer_id,$_POST["receiver_id"],$_POST["score"]);
  }

  else if($exec=="listAll")
      listAllSituations();

  else if($exec=="listAround")
      listAround();

  function Add(){

  }

  function getData(){

  }

  function listAllSituations(){
    //Remove Old Situations before process call
  }

  function ListAround(){
    //Remove Old Situations before process call
  }

  //Internal Call
  function getSituationRating(){

  }

  //Remove overdated Situations
  function RemoveOldSituations(){
    //Read through all situations and remove the ones that are out of date

  }

 ?>
