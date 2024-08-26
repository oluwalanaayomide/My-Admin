<?php
    require_once "includes/db.php";   
?>
<?php 
     require_once "includes/sessions.php";
?>
<?php 
     require_once "includes/function.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/publicstyle.css">
    <link rel="stylesheet" href="css/dash.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <style>
       
       .imageicon{
        max-width: 150px;
        margin: 0 auto;
        display: block;
        border-radius: 90px;
       }
       

        #Footer{
    padding: 10px;
    border-top: 1px solid black;
    color: #eeeeee;
    text-align: center;
}
.background{
    background-color: #e9eee9;
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
               <a class="navbar-brand" href="Blog.php?page=1">
               <img style="margin-top: -13px;" src="image/THE PLAN.jpg"  width="200px"  height="45px"  alt="">
               </a>
            </div>

        <div class="collapse navbar-collapse" id="#collapse">
              <ul class="nav navbar-nav">
                <li><a href="Blog.php?page=1">Home</a></li>
                <li class="active"><a href="Blog.php?page=1">Blog</a></li>
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
        <div class="blog-header">
            <h1 id="heading">Blog</h1>
            <p class="lead"></p>
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
                     
                     elseif(isset($_GET['Category'])){
                        $name=$_GET['Category'];
                        $conn;
                        $sql="SELECT * FROM admin_panel WHERE category='$name' ORDER BY datetime desc";
                     }
                     elseif(isset($_GET['page'])){
                        $Page=$_GET['page'];
                        if($Page==0||$Page<1){
                            $showPost=0;
                        }
                        else{
                        $showPost=($Page*5)-5;
                        
                        $sql="SELECT * FROM admin_panel  ORDER BY datetime desc LIMIT $showPost,5";}
                     }
                     else{
                        
                     $sql="SELECT * FROM admin_panel  ORDER BY datetime desc LIMIT 0,5";}
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
                            if(strlen($Post)>150){$Post = substr($Post,0,150) . '...';}
                        echo htmlentities($Post);?>
                    </p>
                   </div>
                   <a href="FullPost.php?id=<?php echo $PostId ?>"><span class="btn btn-info">
                    Read More &rsaquo; &rsaquo; 
                   </span></a>
                </div>
                
                <?php }?>
                <?php 
                    $conn;
                    $sql="SELECT COUNT(*) FROM admin_panel";
                    $result=mysqli_query($conn,$sql);
                    $RowPage=mysqli_fetch_array($result);
                    $Total=array_shift($RowPage);
                        
                        $PostPerPage=$Total/5;
                        $PostPerPage=ceil($PostPerPage);
                       
                      

                        for($i=1;$i<=$PostPerPage;$i++){
                          
                                
                ?>
                <nav><ul class="pagination pull-left pagination-lg">
                                                
                     <?php 
                     if(isset($Page)){
                     if($i==$Page){ ?>     
                <li class="active"><a href="Blog.php?page=<?php echo $i;?>"><?php echo $i;?></a></li>
               <?php } else{?>
                     <li><a href="Blog.php?page=<?php echo $i;?>"><?php echo $i;?></a></li>
              <?php }} ?>
            </ul>    
                </nav>
                <?php }?>
                
            </div>
            <a href="Blog.php?page=2"><span class="btn btn-info pull-right">
                     More Blog &rsaquo; &rsaquo; 
                   </span></a>
            

            <div class="col-sm-offset-1 col-sm-3">
            <h2>About us</h2>
            <img class="img-responsive  imageicon" src="image/wallpaperflare.com_wallpaper (4).jpg">
            <p class="description">
                Name: LandMark Computer Science Students <br>
                This Website was Created For Only Educational
                Purposes. <a href="https://www.lmu.edu.ng/" target="_blank">Learn more</a>

            </p>
                <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="panel-title">Categories</h2>
                </div>
                <div class="panel-body">
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

