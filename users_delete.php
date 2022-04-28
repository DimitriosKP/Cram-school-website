<?php 
    
    session_start();

    if (!isset($_SESSION['id']) || $_SESSION['id'] <=0 ){
        header('Location: login.php');
        die();
    }

    require_once "config.php";
    $id=(int)$_GET['id'];

    if(isset($_GET['id']) && $_SESSION["role"] === 't'){
        $sql = "DELETE FROM users WHERE id = ".intval($_GET['id']).""; 
        
        mysqli_query($database, $sql)  ;
    }

    header('Location: students.php');
    