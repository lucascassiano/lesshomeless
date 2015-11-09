<!DOCTYPE html>
<!--AIzaSyA_BB6lZDuQmJ7Wl2rW6RpNCLepVWPetwA    API maps-->
<html>
<head>
    <?php session_start() ?>
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

    <script>

    //center:new google.maps.LatLng(lat,long),
        function initialize() {
          var mapProp = {
    				center: {lat: -5.7792569, lng:-35.200916},
            zoom:20,
            mapTypeId:google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true
          };

        var map=new google.maps.Map(document.getElementById("googleMap"), mapProp);
            //Definindo o estilo do mapa
        var styledMap = new google.maps.StyledMapType(map_style3,
            {name: "Dark map"});

        var infoWindow = new google.maps.InfoWindow({map: map});

          // Try HTML5 geolocation.
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
              var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
              };
              map.setCenter(pos);
            }, function() {
              handleLocationError(true, infoWindow, map.getCenter());
            });
          } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
          }

}
        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
          infoWindow.setPosition(pos);
          infoWindow.setContent(browserHasGeolocation ?
                                'Error: The Geolocation service failed.' :
                                'Error: Your browser doesn\'t support geolocation.');
        }

        function SetMapCenter(lat, long){
          var pos = {
            lat: lat,
            lng: long
          };
          map.setCenter(pos);
        }


    google.maps.event.addDomListener(window, 'load', initialize);

    </script>
    <style>
    #googleMap{
        position: absolute;
  top: 0; bottom: 0; right: 0; left: 0;
        z-index: -100;
    }

    #user-icon{
      position: absolute;
      top:5px;
      right:5px;
      width: 10%;
      max-width: 80px;
      min-width: 50px;
      border-radius: 50%;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);;
    }

    .bottomDiv{
        position: absolute;
        margin: auto;
        align-content: center;
        text-align: center;
        align-items: center;
        align-self: center;
        bottom: 10px;
        width: 100%;
        opacity: 0.8;
    }

    #bottom_button{
      width: 20%;
      max-width: 150px;
      min-width: 50px;
      border: none;
    }
    </style>
</head>

<body>
  <div id="googleMap"></div>
  <a href="#" data-toggle="modal" data-target="#user-profile">
    <?php
      include "php/user.php";
      $facebook_id = getCurrentFacebookId();
      echo '<img id="user-icon" src="http://graph.facebook.com/'.$facebook_id.'/picture?width=500"></img>';
    ?>
  </a>
  <div>
    <div class="bottomDiv">
        <a href="#" data-toggle="modal" data-target="#add-situation"><img id="bottom_button" src="img/icon_lesshomeless_medium.png" ></img></a>
        <br><a href="http://lucascassiano.github.io">&copy; Lucas Cassiano - 2015</a>
    </div>

  </div>
    <!------------Modals------------>
    <script>
        /**
         * Vertically center Bootstrap 3 modals so they aren't always stuck at the top
         */
        $(function() {
            function reposition() {
                var modal = $(this),
                    dialog = modal.find('.modal-dialog');
                modal.css('display', 'block');

                // Dividing by two centers the modal exactly, but dividing by three
                // or four works better for larger screens.
                dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
            }
            // Reposition when a modal is shown
            $('.modal').on('show.bs.modal', reposition);
            // Reposition when the window is resized
            $(window).on('resize', function() {
                $('.modal:visible').each(reposition);
            });
        });

    </script>


    <!-- Add main -->

    <div class="modal fade" id="add-main" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Adicionar</h4>
          </div>
          <div class="modal-body">
            <!-- Columns are always 50% wide, on mobile and desktop -->
            <center>
            <div class="row">
              <div class="col-xs-6">
                <input id="add-homeless-button" data-toggle="modal" data-target="#add-homeless" type="image" src="img/icon_homeless.png" width="100%"
                onmouseover="this.src='img/icon_homeless_hover.png'"
                onmouseout="this.src='img/icon_homeless.png'"
                ></input>
                <h5>Morador em estado de rua</h5>
              </div>
              <div class="col-xs-6">
                <input id="add-situation-button" data-toggle="modal" data-target="#add-situation" type="image" src="img/icon_add_location.png" width="100%"
                onmouseover="this.src='img/icon_add_location_hover.png'"
                onmouseout="this.src='img/icon_add_location.png'"
                ></input>
                <h5>Situacao a ser reportada</h5>
              </div>
            </div>
          </center>
          </div>

        </div>
      </div>
    </div>
    <script>
    $("#add-homeless-button").click(function(){
      $('#add-main').modal('hide');
    });

    $("#add-situation-button").click(function(){
      $('#add-main').modal('hide');
    });

    $("add-situation").on('show.bs.modal', function (event) {
      alert("Hello! I am an alert box!!");
    });

    </script>

    <!-- Add Homeless -->
    <div class="modal fade" id="add-homeless" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Adicionar Morador em estado de Rua</h4>
          </div>

          <form role="form" id="add_usrform" >
            <div class="form-group">
              <label for="name">Nome Completo:</label>
              <input type="text" class="form-control" id="name" name="homeless_name" required placeholder="Nome Completo do morador">
              <label for="birth">Data de Nascimento:</label>
              <input type="date" class="form-control" id="name" name="homeless_name" required min="1929-12-31">
            </div>
            <hr>
            <div class="form-group">
              <p>Os dados abaixos não serão mostrados a demais usuários, serão usados apenas para validação de registro*</p>
              <label for="cpf">CPF:</label>
              <input type="number" class="form-control" id="cpf" name="homeless_cpf" required pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" placeholder="CPF no formato 000.000.000-00">

              <label for="rg">RG:</label>
              <input type="number" class="form-control" id="rg" name="homeless_rg" required pattern="\d{3}\.\d{3}\.\d{3}" placeholder="RG no formato 000.000.000">
            </div>
            <hr>
            <div class="form-group">
              <!--
              <center>
                <p>Avalie este morador, entre 0 (não indica) e 5 (indica fortemente)</p>
              <div class="stars">
                  <input class="star star-5" id="star-5" type="radio" name="star"/>
                  <label class="star star-5" for="star-5"></label>
                  <input class="star star-4" id="star-4" type="radio" name="star"/>
                  <label class="star star-4" for="star-4"></label>
                  <input class="star star-3" id="star-3" type="radio" name="star"/>
                  <label class="star star-3" for="star-3"></label>
                  <input class="star star-2" id="star-2" type="radio" name="star"/>
                  <label class="star star-2" for="star-2"></label>
                  <input class="star star-1" id="star-1" type="radio" name="star"/>
                  <label class="star star-1" for="star-1"></label>
              </div>
            </center>
          -->
            <label for="comment">Comentario sobre o morador:</label>
            <input type="text" class="form-control" id="comment" name="homeless_comment" required placeholder="Comentario sobre o morador">

          </div>
            <div class="checkbox">
              <label><input type="checkbox" required> Li e aceito os termos de compromisso.</label>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>

        </div>
      </div>
    </div>

    <!-- Report Situation -->
    <div class="modal fade" id="add-situation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Reportar Situação</h4>
          </div>

          <form role="form" id="add_usrform" action="php/situation">
            <div class="col-md-6">
              <label for="name">Comentário:</label>
              <input type="text" width="50%" class="form-control" id="title" name="homeless_name" required placeholder="Comentário sobre a situação (ex.:Morador precisando de almoço)">
              <center>
                <h4><span class="fa fa-map-marker"></span>
                Nós iremos armazenar o evento utilizando sua localização atual</h4>
                <p>Lembre-se de ativar a opção de GPS do seu dispositivo</p>
              </center>
            </div>

            <center>
              <div class="fileinput fileinput-new" data-provides="fileinput" style="width: 100%;">
                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 80%;"></div>
                <div>
                  <span class="btn btn-primary btn-file"><span class="fileinput-new"><span class="fa fa-camera"></span> Anexar Foto</span><span class="fileinput-exists">Mudar Foto</span><input type="file" name="..."></span>
                  <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a>
                </div>
              </div>
            </center>

            <br>
            <center>
              <p>Avalie este morador, entre 0 (não indica) e 5 (indica fortemente) a ser ajudado</p>
            <div class="stars">
                <input class="star star-5" id="star-5" type="radio" name="star"/>
                <label class="star star-5" for="star-5"></label>
                <input class="star star-4" id="star-4" type="radio" name="star"/>
                <label class="star star-4" for="star-4"></label>
                <input class="star star-3" id="star-3" type="radio" name="star"/>
                <label class="star star-3" for="star-3"></label>
                <input class="star star-2" id="star-2" type="radio" name="star"/>
                <label class="star star-2" for="star-2"></label>
                <input class="star star-1" id="star-1" type="radio" name="star"/>
                <label class="star star-1" for="star-1"></label>
            </div>
          </center>
            <div class="checkbox">
              <label><input type="checkbox" required> Li e aceito os termos de compromisso.</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>

    <!-- User Profile -->
    <div class="modal fade" id="user-profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="user-profile-title">Perfil do Usuário</h4>
          </div>
          <center>
            <br>
            <?php
              $facebook_id = getCurrentFacebookId();
              echo '<img src="http://graph.facebook.com/'.$facebook_id.'/picture?width=500" style="border-radius: 50%; width:30%; max-width:400px; min-width:100px"></img>';
              $userData = getDataToArray($facebook_id);
              $userName = $userData["name"];
              $score = getUserRating($facebook_id);
              $reported = getReportedSituationsAmount($userData["id"]);
            ?>
            <h2 id="user_profile_name"><?php echo $userName ?></h2>
            <div id="user_profile_score" class="stars">
                <label class="star star-5 <?php if($score>=5)echo "on" ?>"></label>
                <label class="star star-4 <?php if($score>=4)echo "on" ?>"></label>
                <label class="star star-3 <?php if($score>=3)echo "on" ?>"></label>
                <label class="star star-2 <?php if($score>=2)echo "on" ?>"></label>
                <label class="star star-1 <?php if($score>=1)echo "on" ?>"></label>
            </div>
            <h1 id="user_profile_reports"><?php echo $reported ?></h1>
            <h3>Situações Reportadas</h3>

            <br>
            <h4><small>Sair do app</small></h4>
            <fb:login-button scope="public_profile,email" data-size="xlarge" onlogin="checkLoginState();" auto_logout_link="true">
        Entrar</fb:login-button>
        <br>
          </center>
          <br>

        </div>
      </div>
    </div>

    <!--Methods for Facebook SDK-->
    <script>
      // This is called with the results from from FB.getLoginStatus().
      function statusChangeCallback(response) {
        console.log('statusChangeCallback');
        console.log(response);
        // The response object is returned with a status field that lets the
        // app know the current login status of the person.
        // Full docs on the response object can be found in the documentation
        // for FB.getLoginStatus().
        if (response.status === 'connected') {
          // Logged into your app and Facebook.
        } else if (response.status === 'not_authorized') {
          // The person is logged into Facebook, but not your app.
        } else {
          // The person is not logged into Facebook, so we're not sure if
          // they are logged into this app or not.
          LogOut();
        }
      }

      // This function is called when someone finishes with the Login
      // Button.  See the onlogin handler attached to it in the sample
      // code below.
      function checkLoginState() {
        FB.getLoginStatus(function(response) {
          statusChangeCallback(response);
        });
      }

      window.fbAsyncInit = function() {
      FB.init({
        appId      : 522430154523440,
        cookie     : true,  // enable cookies to allow the server to access the session
        xfbml      : true,  // parse social plugins on this page
        version    : 'v2.0' // use version 2.2
      });

      FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
      });

      };

      // Load the SDK asynchronously
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));

      function LogOut(){
        FB.api('/me', function(response) {
          window.location.href = "index.php";
        });
      }
    </script>

</body>

</html>
