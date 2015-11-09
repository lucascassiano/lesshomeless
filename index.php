<!DOCTYPE html>
<!--AIzaSyA_BB6lZDuQmJ7Wl2rW6RpNCLepVWPetwA    API maps-->
<html>
<head>
    <title>lessHomeless</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

    <!-- Custom Bootstrap -->
    <link href="css/lesshomeless.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>
<style>
  body{
    background: url("img/background/background2.jpg") no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    margin: auto;
    background-color: #111;
  }
  .container{
    background-color: rgba(0, 0, 0, 0.4);
    padding: 10px;
    padding-bottom: 20px;
    align-content: center;
    vertical-align: middle;
    margin: auto;
    -webkit-box-shadow: 0 5px 5px rgba(0,0,0,.5);
   -moz-box-shadow: 0 5px 5px rgba(0,0,0,.5);
        box-shadow: 0 5px 5px rgba(0,0,0,.5);
  }

  img.topImage{
    width: 30%;
    max-width: 300px;
    min-width: 100px;
  }

  .email{
    width: 5%;
    max-width: 60px;
    min-width: 30px;
    background-color: transparent;
    position: absolute;
    top: 5px;
    right: 5px;
    margin-right: 5px;
    margin-top: 5px;
  }

  h3 {
    text-align: justify;
  }
  .jus{
    text-align: justify;
  }
</style>



<body>
  <div class="container">
    <center>
      <br>
    <img class="topImage" src="img/icon_lesshomeless_big.png"><br><br>
    <h4 class="jus"><strong>LessHomeless</strong> é uma rede social criada para permitir que os usuários registrem e encontrem mais facilmente moradores em estado de rua que necessitam de auxílio.
    Desenvolvida em 2015 por alunos da Universidade Federal do Rio Grande do Norte (UFRN)</h4>
    <h4><small>Para sua comodidade acesse utilizando sua conta do <strong>Facebook</strong></small></h4>
    <fb:login-button scope="public_profile,email" data-size="xlarge" onlogin="checkLoginState();" auto_logout_link="true">
Entrar</fb:login-button>
    <div id="status"></div>
  </center>

  <form action="php/user.php" id="formLogin" method="post">
    <input id="login_user_id" name="facebook_id" type="hidden" value="null" required>
    <input id="login_user_name" name="name" type="hidden" value="null" required>
    <input id="login_user_email" name="email" type="hidden" value="null" required>
    <input name="exec" type="hidden" value="login" required> <!--defines the invoked method-->
    <!--<input type="submit" value="Go">-->
  </form>

  </div> <!-- /container -->
  <div class="email">
    <button style="background-color:transparent; border:none"  type="button" data-toggle="modal" data-target="#myModal"><i style="color: rgba(255,255,255,0.8)" class="fa fa-envelope fa-2x"></i></button>
    <!--<a style="color: rgba(255,255,255,0.8)"href="php/email.php"></a>-->
  </div>
  <footer class="footer">
    <center>
    <p style="color: rgba(255,255,255,0.5);">&copy; Lucas Cassiano - 2015<br>
    <small><a href="lucascassiano@github.io"> lucascassiano@github.io</a></small></p>
    </center>
  </footer>

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

<!--------------- Email Modal -------------->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

</body>
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
      testAPI(); //Para debugar a api
      Login();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';

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

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.id);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  }

  function Login(){
    FB.api('/me', function(response) {
      $("#login_user_id").val(response.id);
      $("#login_user_name").val(response.name);
      $("#login_user_email").val(response.email);
      $( "#formLogin" ).submit();
      //document.getElementById("formLogin").submit();
    });
  }
</script>

</html>
