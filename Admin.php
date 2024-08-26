<?php
    require_once "includes/db.php";   
?>
<?php 
     require_once "includes/sessions.php";
?>
<?php 
     require_once "includes/function.php";
?>
<?php Confirm_Login()?>
<?php
    if(isset($_POST["submit"])){
        $Username=$conn -> real_escape_string($_POST["UserName"]);
        $Password=$conn -> real_escape_string($_POST["Password"]);
        $ComfirmPassword=$conn -> real_escape_string($_POST["ComfirmPassword"]);
        date_default_timezone_set("Africa/Lagos");
        $CurrentTime=time();
        $DateTime= strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
        $DateTime;
        $Admin=$_SESSION['Username'];
        
        if(empty($Username)||empty($Password)||empty($ComfirmPassword)){
           $_SESSION["ErrorMessage"]="All field must be filled";
            Redirect_to("Admin.php");
        }

        elseif(strlen($Password)<8){
            $_SESSION["ErrorMessage"]="Too Short Name for Category";
             Redirect_to("Admin.php");
             
         }
         elseif($Password!==$ComfirmPassword){
            $_SESSION["ErrorMessage"]="Password Does not match!!";
             Redirect_to("Admin.php");
             
         }

        else{
            $sql = "INSERT INTO Admin_Registration (datetime, username, password, addedby) VALUES ('$DateTime' ,'$Username', '$Password', '$Admin')";
            
            if (mysqli_query($conn, $sql)){
                $_SESSION["successMessage"]="Admin added Successfully";
                Redirect_to("Admin.php");
                        }
            else{
                $_SESSION["ErrorMessage"]="Something went wrong";
                Redirect_to("Admin.php");
                }
             }

             mysqli_close($conn);
      
    }    
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    


    <style>
        .FieldInfo{
    color: black;
    font-family: bitter,Georgia,"Times New Roman ",Times,serif;
    font-size: 1.2em;
}

#Footer{
    padding: 10px;
    border-top: 1px solid black;
    color: #eeeeee;
    background-color: #211f22;
    text-align: center;
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
              <ul class="nav navbar-nav nav-pills">
                <li><a href="">Home</a></li>
                <li><a href="Blog.php?page=1" target="_blank">Blog</a></li>
                <li><a href="">About us</a></li>
                <li><a href="">Service</a></li>
                <li><a href="">Contact us</a></li>
                <li><a href="">Features</a></li>
             </ul>
          
            <form action="Blog.php" class="navbar-form navbar-right" >
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search" name="Search">
                </div>
                <button class="btn btn-default" name="SearchButton">Go</button>
            </form>
            </div>
        </div>
        <div  class="line" style="height: 10px; background: #27AAE1"></div>
    </nav>
    
    
    <nav class="container-fluid">
        <nav class="row">

            <div class="col-sm-2">
                <br><br>
                <ul id="side-menu" class="nav nav-pills nav-stacked">
                    <li><a href="Dash-Board.php"><span
                                class="glyphicon glyphicon-th"></span>DashBoard</a></li>
                    <li><a href="new_post.php"><span class="glyphicon glyphicon-list-alt"></span> Add New Post</a></li>
                    <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span> Categories</a></li>
                    <li class="active"><a href="Admin.php"><span class="glyphicon glyphicon-user"></span> Manage Admins</a></li>
                    <li><a href="Comment.php"><span class="glyphicon glyphicon-comment"></span> Comment</a></li>
                    <li><a href="Blog.php?page=1"><span class="glyphicon glyphicon-equalizer"></span> Live Blog</a></li>
                    <li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
            </div>
            <!--Ending of Side Area-->

            <div class="col-sm-10">
                <h1>Manage Admin</h1>
                <div><?php  echo Message(); 
                            echo successMessage(); 
                ?></div>
                <div>
                    <form action="Admin.php" method="post">
                        <fieldset>
                           <div class="form-group" >
                           <label for="UserName"><span class="FieldInfo">UserName:</span></label>
                           <input class="form-control" type="text" name="UserName" id="UserName" placeholder="UserName">
                          
                           </div>
                           <div class="form-group" >
                           <label for="Password"><span class="FieldInfo">Password:</span></label>
                           <input class="form-control" type="password" name="Password" id="Password" placeholder="Password">
                           
                           </div>
                           
                           <div class="form-group" >
                           <label for="Comfirm Password"><span class="FieldInfo">Comfirm Password:</span></label>
                           <input class="form-control" type="password" name="ComfirmPassword" id="ComfirmPassword" placeholder="Retype Password">
                           <input style="margin-top: 8px;" class="btn btn-success" type="submit" name="submit" value="Add to Admin">
                           </div>

                        </fieldset>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Sr No.</th>
                            <th>Date & Time</th>
                            <th>UserName</th>
                            <th>Admin</th>
                            <th>Action</th>
                        </tr>

                        <?php 
                            $sql= "SELECT * FROM Admin_Registration ORDER BY datetime desc";
                            $result= mysqli_query($conn,$sql);
                            $srNo=0;
                            if ($result->num_rows >0){
                                while($row= mysqli_fetch_assoc($result)){
                                    $id=$row["id"];
                                    $DateTime=$row["datetime"];
                                    $Username=$row["username"];
                                    $Admin=$row["addedby"];
                                    
                                    $srNo++;    

                                    
                            
                        ?>

                        <tr>
                            <td><?php echo $srNo ?></td>
                            <td><?php echo $DateTime ?></td>
                            <td><?php echo $Username ?></td>
                            <td><?php echo $Admin ?></td>
                            <td><a href="DeleteAdmin.php?time=<?php echo $DateTime;?>"><button class="btn btn-danger">Delete</button></a></td>
                        </tr>
                        
                        
                        
                        <?php } }
                        else{
                            echo " Admin is empty";
                        }
                        ?>
                        
                    </table>
                </div>
            </div>
            <!--Ending of Main AREA-->


        </nav>
        
        <!--Ending of Row-->
    </nav>
    <!--Ending of container-fluid-->

    <div id="Footer">
        <hr>
        <p>
            Theme By [Ayo Rookie] &copy;2016-2024 --- All right reserved.
        </p>
        <a style="color: white; text-decoration: none; cursor: pointer; font-weight: bold; text-align: center;"
            href="#">
            <p> This site is only for the purpose of practice. no one is allowed to copy other than <br> Ayo&trade;
            </p>
        </a>
        <hr>
        

    </div><!--container End-->
    
   
    
</body>

</html>