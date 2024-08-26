<?php
    require_once "includes/db.php";   
    require_once "includes/sessions.php";
    require_once "includes/function.php";
    
?>
<?php  Confirm_Login()?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin DashBoard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
  
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
 
    <style>
.navbar-nav li{
    font-weight: bold;
    font-family: 'Times New Roman', Times, serif;
    font-size: 1.2em;
}


.line{
    margin-top: -20px;
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
    </nav>
    <div  class="line" style="height: 10px; background: #27AAE1"></div>
    <nav class="container-fluid">
        <nav class="row">

            <div class="col-sm-2">
                <br><br>
                
                <ul id="side-menu" class="nav nav-pills nav-stacked">
                    <li class="active"><a href="Dash-Board.php"><span class="glyphicon glyphicon-th"></span>DashBoard</a></li>
                    <li><a href="new_post.php"><span class="glyphicon glyphicon-list-alt"></span> Add New Post</a></li>
                    <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span> Categories</a></li>
                    <li><a href="Admin.php"><span class="glyphicon glyphicon-user"></span> Manage Admins</a></li>
                    <li><a href="Comment.php"><span class="glyphicon glyphicon-comment"></span> Comment</a></li>
                    <li><a href="Blog.php?page=1" target="_blank"><span class="glyphicon glyphicon-equalizer"></span> Live Blog</a></li>
                    <li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
            </div><br>
            <!--Ending of Side Area-->
        
            <div class="col-sm-10">
            <div><?php 
                echo Message();  echo successMessage();
                ?>
                </div>
            <h1>Admin DashBoard</h1>
            <div class="table-responsive">
               <table class="table table-hover table-striped">
                    <tr>
                        <th>No</th>
                        <th>Post Title</th>
                        <th>Date Time</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Banner</th>
                        <th>Comment</th>
                        <th>Action</th>
                        <th>Details</th>
                    </tr>

                    <?php

                        $sql= "SELECT * FROM admin_panel ORDER BY id desc";
                        $result= mysqli_query($conn, $sql);
                        $sr=0;
                     
                        
                        while($Datarow=mysqli_fetch_array($result)){
                           $PostId=$Datarow["id"];
                           $DateTime=$Datarow["datetime"];
                           $title=$Datarow["title"];
                           $Category=$Datarow["category"];
                           $User=$Datarow["author"];
                           $Image=$Datarow["image"];
                           $Post=$Datarow["post"];
                           $sr++;
                           ?> 

                           <tr>
                                <td><?php echo $sr?></td>
                                <td><?php if(strlen($title)>15){$title=substr($title,0,15).'...';}
                                 echo $title
                                 ?></td>
                                <td><?php echo $DateTime
                                 ?></td>
                                <td><?php echo $User?></td>
                                <td><?php if(strlen($Category)>6){$Category=substr($Category,0,6).'...';}
                                echo $Category?></td>
                                <td><img src="upload/<?php echo $Image ?>" width="120px" height="50px"></td>
                                <td>
                            <?php 
                              //  $conn;
                                //$Approved="SELECT COUNT (*) FROM comment WHERE admin_panel_id='id'";
                                //$Eresult=mysqli_query($conn,$Approved);
                                //$Rows=mysqli_fetch_array($Eresult);
                                //$totalApproved=array_shift($Rows);
                            ?>
                            <span class="label label-success">
                                //<?php  // echo $totalApproved;?>
                            </span>
                                </td>
                                <td><a href="Edit.php?id=<?php echo $PostId?>"><span class="btn btn-primary">Edit </span></a>
                                 <a href="Delete.php?id=<?php echo $PostId?>"><span class="btn btn-danger">Delete</span></a>
                                </td>
                                <td><a href="Fullpost.php?id=<?php echo $PostId?>" target="_blank">
                                    <span class="btn btn-success">Live Preview</span>
                                </a></td>
                                
                           </tr>
                           <?php 
                           }
                            ?>

                        
                     
                    
               </table>
             </div>
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