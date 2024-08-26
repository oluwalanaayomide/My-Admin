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
    if(isset($_GET['id'])){
        $idFromUrl=$_GET["id"];
        $conn;
        $sql="DELETE FROM comment WHERE datetime='$idFromUrl'";
        $result=mysqli_query($conn,$sql);
        if($result){
            $_SESSION["successMessage"]="Comment Deleted";
            Redirect_to("Comment.php");
        }
        else{
            $_SESSION["ErrorMessage"]="Something Went Wrong";
            Redirect_to("Comment.php");
        }
    }
    


?>