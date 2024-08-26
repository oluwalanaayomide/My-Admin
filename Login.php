<?php
    require_once "includes/db.php";   
?>
<?php 
     require_once "includes/sessions.php";
?>
<?php 
     require_once "includes/function.php";
?>
<?php
    if(isset($_POST["submit"])){
        $Username=$conn -> real_escape_string($_POST["UserName"]);
        $Password=$conn -> real_escape_string($_POST["Password"]);
        
        
        
        if(empty($Username)||empty($Password)){
           $_SESSION["ErrorMessage"]="All field must be filled";
            Redirect_to("Login.php");
        }

       else{
        $found=Login_attempt($Username,$Password); 
        $_SESSION["User_Id"]=$found["id"];
        $_SESSION["Username"]=$found["username"];
            if($found){
                $_SESSION["successMessage"]="Welcome {$_SESSION["Username"]}";
                Redirect_to("Dash-Board.php");
            }
            else{
                $_SESSION["ErrorMessage"]="Invalid Password / Username";
                Redirect_to("Login.php");
            }
        }
         
       }


      
      
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Admin</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    


    <style>
        .FieldInfo{
    color: black;
    font-family: bitter,Georgia,"Times New Roman ",Times,serif;
    font-size: 1.2em;
}

   
    </style>

</head>

<body>


<div style="height: 10px; background: #27AAE1"></div>
    <nav class="navbar navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
                    <span class="sr-only" >Toggle Navigation</span>
                    <span class="icon-bar" ></span>
                    <span class="icon-bar" ></span>
                    <span class="icon-bar" ></span>
                </button>
               <a class="navbar-brand" href="Blog.php">
               <img style="margin-top: -13px;" src="image/THE PLAN.jpg"  width="200px"  height="45px"  alt="">
               </a>
            </div>

        <div class="collapse navbar-collapse" id="#collapse">
             
            </div>
        </div>
        <div  class="line" style="height: 10px; background: #27AAE1"></div>
    </nav>
    
    <nav class="container-fluid">
        <nav class="row">

           
            <div class="col-sm-offset-4 col-sm-4">
            <div><?php  echo Message(); 
                            echo successMessage(); 
                ?></div>
                <br><br><br><br>
                <h1>Welcome Back!!</h1>
                <br>
                
                <div>
                    <form action="Login.php" method="post">
                        <fieldset>
                           <div class="form-group" >
                           
                           <label for="UserName"><span class="FieldInfo">UserName:</span></label>
                           <div class="input-group input-group-lg">
                           <span class="input-group-addon"><span class=" glyphicon glyphicon-user text-primary"></span></span>
                           <input class="form-control" type="text" name="UserName" id="UserName" placeholder="UserName">
                           </div>
                           </div>
                           <div class="form-group" >
                           <label for="Password"><span class="FieldInfo">Password:</span></label>
                           <div class="input-group input-group-lg">
                           <span class="input-group-addon"><span class=" glyphicon glyphicon-lock text-primary"></span></span>
                           <input class="form-control" type="password" name="Password" id="Password" placeholder="Password">
                           </div>
                           </div>
                           
                           
                           <input style="margin-top: 8px;" class="btn btn-info" type="submit" name="submit" value="Login">
                           

                        </fieldset>
                    </form>
                </div>
                
            <!--Ending of Main AREA-->


        </nav>
        
        <!--Ending of Row-->
    </nav>
    <!--Ending of container-fluid-->

   
   
    
</body>

</html>