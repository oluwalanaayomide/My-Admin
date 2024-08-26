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
        
        $Image = $_FILES["Image"]["name"];
        $Target = "upload/".basename($_FILES["Image"]["name"]);
    }
        
        else{
            $DeleteFromUrl=$_GET['id'];
            $sql = "DELETE FROM admin_panel WHERE id='$DeleteFromUrl'";
            mysqli_query($conn, $sql);
            move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
            if (mysqli_query($conn, $sql)){
                $_SESSION["successMessage"]="Post Deleted Successfully";
                Redirect_to("Dash-Board.php");
                        }
            else{
                $_SESSION["ErrorMessage"]="Something went wrong. Try Again";
                Redirect_to("Dash-Board.php");
                exit();
                }
             
        }
             
    
             mysqli_close($conn);
            
    
?>


<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Post</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/Admin.css">


    <style>
        .FieldInfo{
    color: black;
    font-family: bitter,Georgia,"Times New Roman ",Times,serif;
    font-size: 1.2em;
}

    </style>

</head>

<body>
    <nav class="container-fluid">
        <nav class="row">

            <div class="col-sm-2">
                
                <ul id="side-menu" class="nav nav-pills nav-stacked">
                    <li><a href="Dash-Board.php"><span
                                class="glyphicon glyphicon-th"></span>DashBoard</a></li>
                    <li class="active"><a href="new_post.php"><span class="glyphicon glyphicon-list-alt"></span> Delete Post</a></li>
                    <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span> Categories</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> Manage Admins</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-comment"></span> Comment</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-equalizer"></span> Live Blog</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
            </div>
            <!--Ending of Side Area-->

            <div class="col-sm-10">
                <h1>Delete Post</h1>
                <div><?php  echo Message(); 
                            echo successMessage(); 
                ?></div>
                <div>
                    <?php 
                        $DateTimeFromUrl=$_GET['id'];
                        $sql= "SELECT * FROM admin_panel WHERE id='$DateTimeFromUrl' ORDER BY id desc ";
                        $result = mysqli_query($conn,$sql);
                       
                            while($Datarow=mysqli_fetch_array($result)){
                               $title=$Datarow["title"];
                               $Category=$Datarow["category"];
                               $Image=$Datarow["image"];
                               $Post=$Datarow["post"];}
                    ?>
                    <form action="Delete.php?id=<?php echo $DateTimeFromUrl?>" method="post" enctype="multipart/form-data">
                        <fieldset>
                           <div class="form-group" >
                           <span class="FieldInfo">Update</span>
                           <label for="Title"><span class="FieldInfo">Title:</span></label><br>
                           <input disabled value="<?php echo $title;?>" class="form-control" type="text" name="Title" id="title" placeholder="Title"><br>

                           <div class="form-group" >
                           <span class="FieldInfo">Existing category:<?php echo $Category;?></span><br>
                        
                           <label for="categoryselect"><span class="FieldInfo">Category:</span></label>
                           <select disabled class="form-control" id="categoryselect" name="category">
                           <?php 
                            $sql= "SELECT * FROM category ORDER BY id desc";
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
                           <span class="FieldInfo">Existing Image: <img src="upload/<?php echo $Image;?>" width="100px" height="100px";> </span><br>
                           <label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
                           <input disabled  type="File" class="form-control" name="Image" accept="image/*" id="imageselect">
                           </div>

                           <div class="form-group" >
                           <label for="postarea"><span class="FieldInfo">Existing</span></label>
                           <label for="postarea"><span class="FieldInfo">Post:</span></label>
                           <textarea  disabled class="form-control" name="post" id="postarea"><?php echo $Post; ?> </textarea>
                           </div>

            
                           <input style="margin-top: 8px;" class="btn btn-danger" type="submit" name="submit" value="Delete Post">
                           <button class="btn btn-warning" style="margin-top: 8px; color: wheat;" ><a href="Dash-Board.php" style="color: white;">Back</a></button>
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

    <div id="Footer" style="background-color: rgb(43, 42, 42);">
        <hr background-color: black;>
        <p style="text-align: center; color:white;">
            Theme By [Ayo Rookie] &copy;2016-2024 --- All right reserved.
        </p>
        <a style="color: white; text-decoration: none; cursor: pointer; font-weight: bold; text-align: center;"
            href="#">
            <p> This site is only for the purpose of practice. no one is allowed to copy other than <br> Ayo&trade;
            </p>
        </a>
        
    </div>

   
    
</body>

</html>