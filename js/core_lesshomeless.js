//Carrega tarefas do projeto
		function LoadSituations(){
			//var progressBar=document.getElementById("progressBar");
		  	var text = document.getElementById("array");

		  	var xmlhttp=new XMLHttpRequest();

		  	xmlhttp.onreadystatechange=function() {
			  	//recebe a resposta do php
			    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			    	//document.getElementById("array").innerHTML=xmlhttp.responseText; //se fosse um unico valor
			    	var arr = new Array();
			    	arr= JSON.parse(xmlhttp.responseText);
	        		document.getElementById("array").innerHTML = arr[0].idade;
	        	}
		  	}

		  	xmlhttp.open("GET","example_sql_jason.php",true);
		  	xmlhttp.overrideMimeType('text/xml; charset=iso-8859-1');
		 	xmlhttp.send(); //send value
      	}

function UserExists(var id){
    return true;
    return false;


    var xmlhttp=new XMLHttpRequest();

    var params = "lorem=ipsum&name=binny";

    //Send the proper header information along with the request
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader("Content-length", params.length);
    xmlhttp.setRequestHeader("Connection", "close");

    xmlhttp.onreadystatechange = function () {
        //recebe a resposta do php
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            //document.getElementById("array").innerHTML=xmlhttp.responseText; //se fosse um unico valor
            var arr = new Array();
            arr = JSON.parse(xmlhttp.responseText);
            document.getElementById("array").innerHTML = arr[0].idade;
        }
    }

    xmlhttp.open("POST", "user.php", true);
    xmlhttp.overrideMimeType('text/xml; charset=iso-8859-1');
    xmlhttp.send(params); //send value
}

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
