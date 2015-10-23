//Lesshomeless JavaScript Core
/*

Receive one value

var fn = document.getElementById("first_name").value;
    var ln = document.getElementById("last_name").value;
    var vars = "firstname="+fn+"&lastname="+ln;


var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    document.getElementById("accordion").innerHTML=xmlhttp.responseText;
  }
}
xmlhttp.open("POST","php/list_projects.php",true);
xmlhttp.send(vars);
}

Multiple returns (JSON)

var arr = new Array();
arr= JSON.parse(xmlhttp.responseText);
  document.getElementById("array").innerHTML = arr[0].idade;

*/

function getCurrentUserId(){
  var params = "exec=getCurrentUserId";
  var request = new XMLHttpRequest();

  request.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      return parseInt(xmlhttp.responseText);
    }
  }

  request.open("POST","../php/user.php",true);
  request.send(vars);

}


/*
--LOGIN--
*/
// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
  console.log('statusChangeCallback');
  console.log(response);

  if (response.status === 'connected')
  {
    // Logged into your app and Facebook.
    Login();
  }
  else if (response.status === 'not_authorized')
  {
    // The person is logged into Facebook, but not your app.
    //document.getElementById('status').innerHTML = 'Entrar no app';
  }
  else {
    // The person is not logged into Facebook, so we're not sure if
    // they are logged into this app or not.
    //document.getElementById('status').innerHTML = 'Faça o login com o Facebook.';
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
  appId      : '522430154523440',
  cookie     : true,  // enable cookies to allow the server to access
                      // the session
  xfbml      : true,  // parse social plugins on this page
  version    : 'v2.0' // use version 2.0
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
  js.src = "http://connect.facebook.net/en_US/sdk.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Here we run a very simple test of the Graph API after login is
// successful.  See statusChangeCallback() for when this call is made.
function Login() {
  console.log('Welcome!  Fetching your information.... ');
  FB.api('/me', {fields:"id, name, picture,email"},function(response) {
    console.log('Successful login for: ' + response.name);
      //implementar chamada AJAX
      var params = "exec=login"
      +"&name="+response.name
      +"&facebook_id="+response.id
      +"&email="+response.email;
      console.log(params);

      var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
          if(xmlhttp.responseText == "ok"){
            console.log("Usuario Logado");
            console.log(xmlhttp.responseText);
            //window.location.href = "home.html";

          }
          else{
            //Error
            console.log(xmlhttp.responseText);
            return xmlhttp.responseText;
          }
        }

      }

      xmlhttp.open("POST","php/user.php",true);
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send(params);
      //get profile picture
      //graph.facebook.com/id/picture?width=120&height=12
//graph.facebook.com/683513915037176/picture?type=square&width=120&height=120‌​

  });
}
