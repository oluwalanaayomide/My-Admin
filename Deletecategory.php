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
    if(isset($_GET['time'])){
        $idFromUrl=$_GET["time"];
        $conn;
        $sql="DELETE FROM category WHERE datetime='$idFromUrl'";
        $result=mysqli_query($conn,$sql);
        if($result){
            $_SESSION["successMessage"]="Category Deleted";
            Redirect_to("Categories.php");
        }
        else{
            $_SESSION["ErrorMessage"]="Something Went Wrong";
            Redirect_to("Categories.php");
        }
    }


?>