<?php
    session_start();
    function Message(){ 
        if (isset($_SESSION["ErrorMessage"])){
            $Output="<div class=\"alert alert-danger\">";
            $Output.=htmlentities($_SESSION["ErrorMessage"]);
            $_SESSION["ErrorMessage"]=null;
            $Output.="</div>";
            return $Output;
        }
    }


    function successMessage(){ 
        if (isset($_SESSION["successMessage"])){
            $Output="<div class=\"alert alert-success\">";
            $Output.=htmlentities($_SESSION["successMessage"]);
            $_SESSION["successMessage"]=null;
            $Output.="</div>";
            return $Output;
        }
    }?>
    