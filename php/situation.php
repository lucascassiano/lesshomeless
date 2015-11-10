<?php
  //This class handles the Situations
  session_start();

  if(isset($_POST['exec'])){
    $exec=$_POST['exec'];

    if($exec=="add"){
      Add();
    }

    else if($exec=="getData"){
      getData($_POST["facebook-id"]);
    }

    else if($exec=="rate"){
      Rate();
    }

    else if($exec=="listAll")
        listAllSituations();

    else if($exec=="listAround")
        listAround();
  }

  function Rate(){
    $situation_id = $_POST["situation_id"];
    include "user.php";
    session_start();
    $user_id = getCurrentUserId();
    $score = 0;
    if(isset($_POST["star"])){
      $score = $_POST["star"];
    }
    
  }

  function Add(){
    include 'system_settings.php';

    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];

    $comment = $_POST["comment"];
    $reporter_id = $_POST["reporter_id"];
    $score = 0;

    $standardWidth = 800;
    $standardHeight = 600;

    if(isset($_POST["star"])){
      $score = $_POST["star"];
    }

    //Upload Image
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    $uploadOk = 1;

    $image_code = GenerateRandomString(34);
    $image_saved_name = $image_code .".". $imageFileType;
    $image_path = $target_dir . $image_saved_name;

    echo "Upload: " . $_FILES["image"]["name"] . "<br />";
     echo "Type: " . $_FILES["image"]["type"] . "<br />";
     echo "Size: " . ($_FILES["image"]["size"] / 1024) . " Kb<br />";
     echo "Stored in: " . $_FILES["image"]["tmp_name"];

 //exit();

    $output_message = '<strong><i class="fa fa-check"></i> Situação Adicionada<strong> com sucesso';
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $output_message = '<strong><i class="fa fa-exclamation-triangle"></i>Arquivo Selecionado Não é uma imagem</strong>';
            $uploadOk = 0;
            Finalize($uploadOk,$output_message);
        }
    }

    // Check if file already exists
    while (file_exists($image_path)) {
      $image_code = GenerateRandomString(34);
      $image_saved_name = $image_code .".". $imageFileType;
      $image_path = $target_dir . $image_saved_name;
    }

    // Check file size
    if ($_FILES["image"]["size"] > (30000000)) { //30Mb
        $output_message = '<strong><i class="fa fa-exclamation-triangle"></i>Arquivo Selecionado É Muito Grande, máximo = 30Mb</strong>';
        $uploadOk = 0;
        Finalize($uploadOk,$output_message);
    }

    //ResizeAndSave($standardWidth,$standardHeight,$image_saved_name);
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
      $output_message = '<strong><i class="fa fa-exclamation-triangle"></i>Arquivo Selecionado Não possui formato compatível (.jpg, .png ou .jpeg)</strong>';
      $uploadOk = 0;
      Finalize($uploadOk,$output_message);
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      $output_message = '<strong><i class="fa fa-exclamation-triangle"></i>Imagem não pode ser enviada ao Banco de Dados :( </strong>';
      Finalize($uploadOk,$output_message);
    // if everything is ok, try to upload file
    } else {
        $path = ResizeAndSave($standardWidth,$standardHeight,$image_saved_name);
        //Finalize($uploadOk,$output_message."  -> ".$path);
        /*
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
            $output_message = '<strong><i class="fa fa-exclamation-triangle"></i>Houve um erro</strong> enquanto faziamos o upload do seu arquivo, tente novamente mais tarde.';
            Finalize($uploadOk,$output_message);
        }
        */
        //$reporter_id, $comment, $score, $latitude, $longitude,$image_code
        AddSituation($reporter_id, $comment, $score, $latitude, $longitude,$image_saved_name);
    }

    //---End of Image Upload
  }

  function AddSituation($reporter_id, $comment, $score, $latitude, $longitude,$image_path){
    include 'system_settings.php';
    $con=mysqli_connect($host,$user_name,$user_password,$database_name);
    $query = "INSERT INTO situation (longitude, latitude, reporter_id, picture, comment, score) VALUES ($longitude, $latitude, $reporter_id, '$image_path', '$comment',$score)";
    $result = mysqli_query($con,$query);

    if(mysqli_error($con)){
        echo "Error: ".mysqli_error($con);
        //header ("location: ../index.php");
        echo "<br> <a href='../index.php'> Voltar </a>";
        //exit();
    }
    else{
        //echo "ok"; //user added with success
        header ("location: ../home.php?result=ok");
        //exit();
    }
  }

  function Finalize($hasError, $message){
    header ("location: test.php?e=".$hasError."&message=".$message);
    exit();
  }

  function getData(){

  }

  function listAllSituations(){
    //List all situations
    include 'system_settings.php';
    // Create connection
        $con=mysqli_connect($host,$user_name,$user_password,$database_name);

        // Check connection
        if (mysqli_connect_errno()) {
            return "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        else{

            $result = mysqli_query($con,"SELECT * FROM situation");
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        print json_encode($rows);
          }
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

//Internal method
  function SituationExists($lat, $long){
    include 'system_settings.php';
    $con = mysqli_connect($host,$user_name,$user_password,$database_name);
    $query = "SELECT * FROM situation WHERE latitude = '$lat' AND longitude = '$log'";
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

  function GenerateRandomString($length = 40) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, strlen($characters) - 1)];
      }
      return $randomString;
  }

  /**
 * Image resize
 * @param int $width
 * @param int $height
 */
function ResizeAndSave($width, $height, $file_name){
  /* Get original image x y*/
  list($w, $h) = getimagesize($_FILES['image']['tmp_name']);
  /* calculate new image size with ratio */
  $ratio = max($width/$w, $height/$h);
  $h = ceil($height / $ratio);
  $x = ($w - $width / $ratio) / 2;
  $w = ceil($width / $ratio);
  /* new file name */
  $path = '../uploads/'.$file_name;
  /* read binary data from image file */
  $imgString = file_get_contents($_FILES['image']['tmp_name']);
  /* create image from string */
  $image = imagecreatefromstring($imgString);
  $tmp = imagecreatetruecolor($width, $height);
  imagecopyresampled($tmp, $image,
    0, 0,
    $x, 0,
    $width, $height,
    $w, $h);
  /* Save image */
  switch ($_FILES['image']['type']) {
    case 'image/jpeg':
      imagejpeg($tmp, $path, 100);
      break;
    case 'image/png':
      imagepng($tmp, $path, 0);
      break;
    case 'image/gif':
      imagegif($tmp, $path);
      break;
    default:
      exit;
      break;
  }
  return $path;
  /* cleanup memory */
  imagedestroy($image);
  imagedestroy($tmp);
}

 ?>
