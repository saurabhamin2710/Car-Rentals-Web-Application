<?php 
    include 'functionsignup.php';
    session_start();
    $variable = $_GET['id'];
    //echo $variable;
    $str = "call deleteOffers('$variable')";
    $result = ExecuteQuery($str);
    header("location: offerlist.php");
    
?>