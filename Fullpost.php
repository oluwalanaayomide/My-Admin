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
        $Name=$conn -> real_escape_string($_POST["name"]);
        $Email=$conn -> real_escape_string($_POST["Email"]);
        $Comment=$conn -> real_escape_string($_POST["comment"]);
        date_default_timezone_set("Africa/Lagos");
        $CurrentTime=time();
        $DateTime= strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
        $DateTime;
        $DateTimeFromUrl=$_GET['id'];
       
        if(empty($Name)||empty($Email)){
           $_SESSION["ErrorMessage"]="Title must be filled";
           Redirect_to("Fullpost.php?id=$DateTimeFromUrl");
            
        }

        elseif(strlen($Comment)>500){
            $_SESSION["ErrorMessage"]="Comment should be less than 500";
            Redirect_to("Fullpost.php?id=$DateTimeFromUrl");
             
             
         }
        
        else{
            $DateTimeFromUrl=$_GET["id"];
            $sql="INSERT INTO comment(Name,Email,Comment,approvedby,datetime,status,admin_panel_id) VALUES ('$Name','$Email','$Comment','Pending','$DateTime','OFF','$DateTimeFromUrl')";
            $return=mysqli_query($conn, $sql);
            
            if ($return){
                $_SESSION["successMessage"]="Comment added Successfully";
                Redirect_to("Fullpost.php?id=$DateTimeFromUrl");
                        }
            else{
                $_SESSION["ErrorMessage"]="Something went wrong. Try Again";
                Redirect_to("Fullpost.php?id=$DateTimeFromUrl");
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
    <title>Full Blog post</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dash.css">
    <link rel="stylesheet" href="css/publicstyle.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <style>
        #Footer{
    padding: 10px;
    border-top: 1px solid black;
    color: #eeeeee;
    text-align: center;
}

.background{
    background-color: #e9eee9;
}
.imageicon{
        max-width: 150px;
        margin: 0 auto;
        display: block;
        border-radius: 90px;
       }


        .FieldInfo{
    color: black;
    font-family: bitter,Georgia,"Times New Roman ",Times,serif;
    font-size: 1.2em;
}

    .comment-block{
        background-color: blanchedalmond;
    }

    .comment-info{
        color: #365899;
        font-family: sans-serif;
        font-family: 1.1em;
        font-weight: bold;
        padding-top: 10px;
    }
    .comment{
        margin-top: -2px;
        padding-bottom: 10px;
        font-size: 1.1em;
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
              <ul class="nav navbar-nav">
                <li><a href="">Home</a></li>
                <li class="active"><a href="Blog.php">Blog</a></li>
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
    <div class="container"><!--container-->
        <div class="blog-header"><br>
        <div><?php  echo Message(); 
                            echo successMessage(); 
                ?></div>
            <h1>The Complete Responsive CMS Blog</h1>
            <p class="lead">The Complete Blog using PHP by Ayo</p>
        </div> 
        <div class="row"><!--Row -->
            <div class="col-sm-8"><!-- Main Area-->
                <?php
                     if(isset($_GET["Search"])){
                        $Search =$_GET["Search"];
                        $sql="SELECT * FROM admin_panel 
                        WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%'   OR category LIKE '%$Search%' 
                         OR post LIKE '%$Search%'"
                        ;
                     }
                     else{

                          $PostId=$_GET['id'];  
                     $sql="SELECT * FROM admin_panel WHERE id='$PostId'
                     ORDER BY id desc";}
                     $result= mysqli_query($conn, $sql);
                     
                     
                     while($Datarow=mysqli_fetch_array($result)){
                        $PostId=$Datarow["id"];
                        $DateTime=$Datarow["datetime"];
                        $title=$Datarow["title"];
                        $Category=$Datarow["category"];
                        $User=$Datarow["author"];
                        $Image=$Datarow["image"];
                        $Post=$Datarow["post"];
                        
                ?>
                <div class="blogpost thumbnail">
                   <img class="img-responsive  img-rounded" src="upload/<?php echo $Image; ?>" >
                   <div class="caption">
                    <h1 id="heading">
                        <?php echo htmlentities($title); ?>
                    </h1>

                    <p class="description">
                        Category:<?php echo htmlentities($Category);?> Published on <?php echo htmlentities($DateTime);?>
                    </p>
                    <p class="post">
                        <?php 
                        echo nl2br($Post);?>
                    </p>
                   </div>
                  
                </div>
                <?php } 
                       
                ?>

<div><br><br>
                        <span class="FieldInfo">Comment Section</span>
                        <br>
                        <?php
                           $conn; 
                           $PostComment=$_GET['id'];
                           $sql="SELECT * FROM comment WHERE admin_panel_id='$PostComment' AND status='ON'";  
                           $result=mysqli_query($conn,$sql);
                           While($Datarow=mysqli_fetch_array($result)){
                                 $CommentDate=$Datarow["datetime"];
                                 $CommentorName=$Datarow["Name"];
                                 $Comment=$Datarow["Comment"];
                        
                        ?>
                        <br>
                          <div class="comment-block">
                            <img style="margin-left: 10px; margin-top:13px;" class="pull-left" src="image/Screenshot (4).png" width="70px"; height="70px";>
                            <p  style="margin-left: 90px;" class="comment-info"><?php   echo $CommentorName ;?></p>
                            <p style="margin-left: 90px;" class="description"><?php echo $CommentDate ;?></p>
                            <p style="margin-left: 90px;" class="comment"><?php echo  nl2br($Comment) ;?></p>
                          </div>

                                

                                <hr>


                          <?php }
                                
                           ?>
                        <br><br>
                    <form action="Fullpost.php?id=<?php echo $PostComment;?>" method="post" enctype="multipart/form-data">
                        <fieldset>
                           <div class="form-group" >
                           <label for="Name"><span class="FieldInfo">Name:</span></label>
                           <input class="form-control" type="text" name="name" id="Name" placeholder="Name"><br>

                           <div class="form-group" >
                           <label for="email"><span class="FieldInfo">Email:</span></label>
                           <input class="form-control" type="email" name="Email" id="Email" placeholder="Email"><br>

                           <div class="form-group" >
                           <label for="commentarea"><span class="FieldInfo">Comment:</span></label>
                           <textarea class="form-control" name="comment" id="commentarea"></textarea>
                           </div>

            
                           <input style="margin-top: 8px;" class="btn btn-primary" type="submit" name="submit" value="Add Comment">
                           </div>
                           

                        </fieldset>
                    </form>
                </div>
             <br><br><br><br>
            </div>

            <div class="col-sm-offset-1 col-sm-3">
            <h2>About Me</h2>
            <img class="img-responsive  imageicon" src="image/wallpaperflare.com_wallpaper (4).jpg">
            <p>giueiuchiuciubncicieucuihciuwehci 
                icuicuiuciiucniecnuciuiuechiuhiununcniucc
                ciuechiuhiununcniuc cciuyg
                ceesiuaciucshhcviu
                uchiuuhewufhhuchciuagicgia
                hciacicyeaywgcyuygvcuaaygc 
                uygaucgacgfyuaewcuyaugcygcc</p>
                <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="panel-title">Categories</h2>
                </div>
                <div class="panel-body ">
                      <?php 
                      $conn;
                      $sql="SELECT * FROM category ORDER BY datetime desc";
                      $result=mysqli_query($conn,$sql);
                      while($Datarow=mysqli_fetch_array($result)){
                        $id=$Datarow["id"];
                        $name=$Datarow["name"];
                      ?>
                      <a href="Blog.php?Category=<?php echo $name;?>">  
                      <span id="heading"><?php echo $name."<br>"; ?></span> 
                      </a>
                      <?php  } ?>      
                </div>
                <div class="panel-footer"></div>
            </div>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="panel-title">Recent Post</h2>
                </div>
                <div class="panel-body background">
                      <?php
                      $conn;
                      $sql="SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,5";
                      $result=mysqli_query($conn,$sql);
                      while($Datarow=mysqli_fetch_array($result)){
                        $id=$Datarow['id'];
                        $title=$Datarow['title'];
                        $DateTime=$Datarow['datetime'];
                        $Image=$Datarow['image'];
                        if(strlen($DateTime)>14){
                            $DateTime=substr($DateTime,0,14);
                        }
                        ?>
                        <div>
                            <img class="pull-left" style="margin-left: 10px; margin-top:5px;" src="Upload/<?php echo $Image;?>" width="70px" height="60px">
                            <a href="Fullpost.php?id=<?php echo $id;?>"><p id="heading" style="margin-left: 90px;"><?php echo htmlentities($title);?></p></a>
                            <p class="description" style="margin-left: 90px;"><?php echo htmlentities($DateTime) ;?></p>
                        <hr>
                        </div>


                      <?php } ?>          
                </div>
                <div class="panel-footer">

                </div>
            </div>
            </div>
    </div><!--row Ending-->
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

