<?php
    require_once "includes/db.php";   
?>
<?php 
     require_once "includes/sessions.php";
?>
<?php
    function Redirect_to($New_Location){
        header ("location:".$New_Location);
        exit();
}




function Login_attempt($Username,$Password){
    $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "blogphp";

     $conn =  mysqli_connect($servername, $username, $password, $dbname);

     if (!$conn){
        die("connection failed : " . mysqli_connect_error());
     }
    
    $sql="SELECT * FROM admin_registration WHERE username='$Username' AND password='$Password'";
    $result=mysqli_query($conn,$sql);
    if($admin=mysqli_fetch_array($result)){
        return $admin;

    }
    else{
        return null;
    }
}

function UserLogin(){
    if(isset($_SESSION["User_Id"])){
        return true;
    }
}

function Confirm_Login(){
    if(!UserLogin()){
        $_SESSION["ErrorMessage"]="Login Required";
        Redirect_to("Login.php");
    }
}
  
  ?>