<!DOCTYPE html>
<!--AIzaSyA_BB6lZDuQmJ7Wl2rW6RpNCLepVWPetwA    API maps-->
<html>
<head>
    <?php session_start();
      if(!isset($_SESSION["lesshomeless_user_id"])){
        //header ("location: index.php");
      }
    ?>
    <title>lessHomeless</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

    <!-- Custom Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <link href="css/lesshomeless.css" rel="stylesheet">
    <link href="css/jasny-bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!-- Map Custom Style -->
    <script src="js/map_styles.js"></script>
    <!-- Google Maps API -->
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/jasny-bootstrap.min.js"></script>
    <style>
    .jus{
      text-align: justify;
    }
    .smallText{
      text-align: justify;
      font-weight: lighter;
      font-size: 15px;
      line-height: 90%;
    }
    </style>
</head>

<body>
  <div class="container">
        <div class="header clearfix">
          <nav>
            <ul class="nav nav-pills pull-left">
              <li role="presentation"><a href="home.php"><i class="fa fa-angle-left"></i> Voltar</a></li>
            </ul>
          </nav>
        </div>

        <div class="jumbotron">
          <h3 style="color:black">Reportar Situação</h3>
          <p class="smallText"><small>Insira apenas informações verdadeiras, nós confiamos em você e outros usuários irão avaliar os dados inseridos por você.</small></p>

          <form action="php/add_situation.php" method="post">
            <input type="hidden" name="exec" value="add">
            <input type="hidden" name="reporter_id" value="<?php include "php/user.php"; echo getCurrentUserId();?>">
            <div class="row">
            <div class="col-md-6">
            <!--Upload Image-->
            <center>
              <div class="fileinput fileinput-new" data-provides="fileinput" style="width: 100%;">
                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 80%;"></div>
                <div>
                  <span class="btn btn-primary btn-file">
                    <span class="fileinput-new"><span class="fa fa-camera"></span> Anexar Foto</span>
                    <span class="fileinput-exists">Mudar Foto</span>
                    <input type="file" name="photo">
                    </span>
                  <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a>
                </div>
              </div>
            </center>
            </div>
            <!-- end upload image-->
            <center>
            <div class="col-md-6">
              <label for="comment">Comentário:</label>
              <input class="form-control" id="comment" type="text" name="comment" placeholder="Comentário sobre o morador e/ou situação" required>
            </div>
          </center>
        </div>
            <div class="row">
              <center>
                <p class="smallText"><small>Avalie este morador, entre 0 estrelas (não indica) e 5 (indica fortemente) a ser ajudado</small></p>
              <div class="stars">
                  <input class="star star-5 star-black" id="star-5" type="radio" name="star" value="5"/>
                  <label class="star star-5 star-black" for="star-5"></label>
                  <input class="star star-4 star-black" id="star-4" type="radio" name="star" value="4"/>
                  <label class="star star-4 star-black" for="star-4"></label>
                  <input class="star star-3 star-black" id="star-3" type="radio" name="star" value="3"/>
                  <label class="star star-3 star-black" for="star-3"></label>
                  <input class="star star-2 star-black" id="star-2" type="radio" name="star" value="2"/>
                  <label class="star star-2 star-black" for="star-2"></label>
                  <input class="star star-1 star-black" id="star-1" type="radio" name="star" value="1"/>
                  <label class="star star-1 star-black" for="star-1"></label>
              </div>
              </center>
            </div>
            <div class="row">
              <center>
              <div class="checkbox">
                <label><input type="checkbox" required> Li e aceito os termos de compromisso.</label>
              </div>
            <input class="btn btn-primary btn-lg" type="submit" value="Enviar">
            </center>
          </div>
          </form>
        </div>

</body>

</html>
