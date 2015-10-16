<?php
  session_start();
  $_SESSION["user"] = 10;
  Test(5,6);

  function Test($A, $B=$_SESSION["user"], $C){
    echo $A . "," . $B .",".$C;
  }

 ?>
