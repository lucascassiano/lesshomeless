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
    //Current user position
    var lat =0;
    var lng = 0;

    //Loading Situations to Map
    var situations = new Array();

    function LoadSituations(){
      var xmlhttp=new XMLHttpRequest();
      situations = new Array();
      xmlhttp.onreadystatechange=function() {
        //Receives data from situations_list.php
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
          situations = JSON.parse(xmlhttp.responseText);
          initialize();
        }
      }
        xmlhttp.open("GET","php/situations_list.php",true);
        xmlhttp.overrideMimeType('text/xml; charset=iso-8859-1');
        xmlhttp.send();
    }

    window.onload=LoadSituations();

    //center:new google.maps.LatLng(lat,long),
        function initialize() {
          var mapProp = {
    				center: {lat: lat, lng: lng},
            zoom:20,
            mapTypeId:google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true
          };

        var map=new google.maps.Map(document.getElementById("googleMap"), mapProp);
            //Definindo o estilo do mapa
        var styledMap = new google.maps.StyledMapType(map_style3,
            {name: "Dark map"});

        //var infoWindow = new google.maps.InfoWindow({map: map});

          // Try HTML5 geolocation.
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
              var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
              };
              map.setCenter(pos);
            });
          }


          //Adding markers on the map
          console.log("Situations");
          console.log(situations);

          for(var sit in situations){
            var icon_src ='img/marker_simple.png';
            console.log("reading..");
            var marker = new google.maps.Marker({
              position: new google.maps.LatLng(situations[sit].latitude, situations[sit].longitude) ,
              title: situations[sit].comment,
              icon: icon_src
            });

                var content = "<div><p>"+situations[sit].comment+"</p></div>";
                var infowindow = new google.maps.InfoWindow({
                  content: content
                });

                marker.addListener('click', function() {
                  //infowindow.open(map, marker);
                  $("#detail_comment").text(situations[sit].comment);
                  $("#detail_date").text("Postado em: "+situations[sit].date);
                  $('#detail_reporter_image').attr('src',"http://graph.facebook.com/"+situations[sit].facebook_id+"/picture?width=500");
                  $("#detail_reporter_name").text(situations[sit].name);
                  $("#detail_creator_id").val(situations[sit].reporter_id);
                  $('#detail_image').attr('src',"uploads/"+situations[sit].picture);
                  $("#situation_id").val(situations[sit].sit_id);
                  //End situations
                  //if(situations[sit].reporter_id==situations[sit)
                  //$( ".inner" ).append( "<p>Test</p>" );
                  $("#detail-situation").modal('toggle');

                });
                marker.setMap(map);
          }

        }//end of initialize()


      //Loading User GeoLocation
        function getLocation() {
          if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(showPosition);
          } else {
              alert("ERRO: Posição do usuário Não disponível");
          }
        }
        function showPosition(position) {
          SetMapCenter(position.coords.latitude,position.coords.longitude);
        }

        function SetMapCenter(lat, long){
          var pos = {
            lat: lat,
            lng: long
          };
          map.setCenter(pos);
        }


    //google.maps.event.addDomListener(window, 'load', initialize);


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

    .user-icon{
      width: 20%;
      max-width: 80px;
      min-width: 50px;
      border-radius: 50%;
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

    .smallText{
      text-align: justify;

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
        <!-- Old button that calls the modal-->
        <!--<a href="#" data-toggle="modal" data-target="#add-situation"><img id="bottom_button" src="img/icon_lesshomeless_medium.png" ></img></a>-->
        <a href="report.php"><img id="bottom_button" src="img/icon_lesshomeless_medium.png" ></img></a>

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

    <!-- Detail Situation -->
    <div class="modal fade" id="detail-situation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Detalhes da Situação</h4>
          </div>

          <div class="modal-body">
            <div class="col-md-6">
              <p id="detail_date"></p>
              <p id="detail_comment" class="smallText">Comentário da Situação</p>
            </div>
            <div class="col-md-6">
              <p>postado por:</p>
              <center>
              <img class="user-icon" id="detail_reporter_image" src="img/icon_generic_user.png"></img>
              <h4 id="detail_reporter_name">User Name</h4>
            </center>
            </div>

            <center>
                <img style="max-width:800px; width:90%" id="detail_image" src="img/background/background1.jpg"></img>
            </center>
            </div>
            <hr>
          <!--Analise da Situacao-->
          <div class="row">
          <form role="form" id="rate_situation_form" action="php/situation.php" method="post">
            <input type="hidden" name="exec" value="rate">
            <input id="situation_id" type="hidden" name="situation_id" value="0">
            <input id="detail_creator_id" type="hidden" name="creator_id" value="0">
            <center>
            <div class="form-group" >
              <input  id="comment" type="text" class="form-control" name="comment" value="null" placeholder="Comente sua experiência nesta situação">
            </div>
            <p>Avalie a confiabilidade desta situação, entre 0 (não confiável) e 5 (altamente confiável)</p>
            <div class="stars">
                <input class="star star-5" id="star-5" type="radio" name="star" value="5"/>
                <label class="star star-5" for="star-5"></label>
                <input class="star star-4" id="star-4" type="radio" name="star" value="4"/>
                <label class="star star-4" for="star-4"></label>
                <input class="star star-3" id="star-3" type="radio" name="star" value="3"/>
                <label class="star star-3" for="star-3"></label>
                <input class="star star-2" id="star-2" type="radio" name="star" value="2"/>
                <label class="star star-2" for="star-2"></label>
                <input class="star star-1" id="star-1" type="radio" name="star" value="1"/>
                <label class="star star-1" for="star-1"></label>
            </div>
          </center>

          <center>
            <button type="submit" class="btn btn-primary">Participar</button>
          </center>
          </form>
        </div>

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
              $reported = getReportedSituationsAmount(getCurrentUserId());
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
