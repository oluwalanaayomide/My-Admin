<?php
   require_once "includes/sessions.php";
?>

<?php 
     require_once "includes/function.php";
?>

<?php 
     $_SESSION["User_Id"]=null;
     session_destroy();
     Redirect_to("Login.php");
?>