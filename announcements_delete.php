<?php 
    
    session_start();
    require_once "config.php";


    if (!isset($_SESSION['id']) || $_SESSION['id'] <=0 ){
        header('Location: login.php');
        die();
    }
    $id=(int)$_GET['id'];

    # μπορεί να διαγραψει μόνο ο tutor
    if(isset($_GET['id']) && $_SESSION["role"] === 't'){
        $sql = "DELETE 
                FROM announcements 
                WHERE ann_id = ".intval($_GET['id'])." 
                    AND creator_id = ".$_SESSION['id']; 
        
        mysqli_query($database, $sql)  ;
    }

    header('Location: announcements.php');
    