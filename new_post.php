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
        $title=$conn -> real_escape_string($_POST["Title"]);
        $Category=$conn -> real_escape_string($_POST["category"]);
        $Post=$conn -> real_escape_string($_POST["post"]);
        date_default_timezone_set("Africa/Lagos");
        $CurrentTime=time();
        $DateTime= strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
        $DateTime;
        $User=$_SESSION['Username'];
        $Image = $_FILES["Image"]["name"];
        $Target = "upload/".basename($_FILES["Image"]["name"]);
        if(empty($title)){
           $_SESSION["ErrorMessage"]="Title must be filled";
            Redirect_to("new_post.php");
        }

        elseif(strlen($title)<2){
            $_SESSION["ErrorMessage"]="Title should be at least 2 Characters";
             Redirect_to("new_post.php");
             
         }
        
        else{
            $sql = "INSERT INTO admin_panel (datetime,title,category,author,image,post) VALUES ('$DateTime', '$title', '$Category', '$User', '$Image', '$Post')";
            $result=mysqli_query($conn, $sql);
            move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
            if ($result){
                $_SESSION["successMessage"]="Post added Successfully";
                Redirect_to("new_post.php");
                        }
            else{
                $_SESSION["ErrorMessage"]="Something went wrong. Try Again";
                Redirect_to("new_post.php");
                exit();
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
    <title>Add New Post</title>
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
                <li><a href="Blog.php" target="_blank">Blog</a></li>
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
                    <li class="active"><a href="new_post.php"><span class="glyphicon glyphicon-list-alt"></span> Add New Post</a></li>
                    <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span> Categories</a></li>
                    <li><a href="Admin.php"><span class="glyphicon glyphicon-user"></span> Manage Admins</a></li>
                    <li><a href="Comment.php"><span class="glyphicon glyphicon-comment"></span> Comment</a></li>
                    <li><a href="Blog.php?page=1"><span class="glyphicon glyphicon-equalizer"></span> Live Blog</a></li>
                    <li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
            </div>
            <!--Ending of Side Area-->

            <div class="col-sm-10">
                <h1>Add New Post</h1>
                <div><?php  echo Message(); 
                            echo successMessage(); 
                ?></div>
                <div>
                    <form action="new_post.php" method="post" enctype="multipart/form-data">
                        <fieldset>
                           <div class="form-group" >
                           <label for="Title"><span class="FieldInfo">Title:</span></label>
                           <input class="form-control" type="text" name="Title" id="title" placeholder="Title">
                           <div class="form-group" >
                           <label for="categoryselect"><span class="FieldInfo">Category:</span></label>
                           <select class="form-control" id="categoryselect" name="category">
                           <?php 
                            $sql= "SELECT * FROM category ORDER BY datetime desc";
                            $result= mysqli_query($conn,$sql);
                            
                            if ($result->num_rows >0){
                                while($row= mysqli_fetch_assoc($result)){
                                    $id=$row["id"];
                                    $name=$row["name"];
                                ?>
                                <option><?php echo $name; ?></option>

                                <?php } }?>
                           </select>
                           </div>
                           <div class="form-group" >
                           <label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
                           <input type="File" class="form-control" name="Image" accept="image/*" id="imageselect">
                           </div>
                           <div class="form-group" >
                           <label for="postarea"><span class="FieldInfo">Post:</span></label>
                           <textarea class="form-control" name="post" id="postarea"></textarea>
                           </div>
                           <input style="margin-top: 8px;" class="btn btn-success" type="submit" name="submit" value="Add New Post">
                           </div>
                        </fieldset>
                    </form>
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