<?php 
    require_once "config.php";
    
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        $_SESSION['username'] = $username;
        header("location: login.php");
        exit;
    }

    $id=(int)$_GET['id'];

    if(isset($_GET['id']) && $_SESSION["role"] === 't') {
        $sql = "DELETE FROM users WHERE id = ".intval($_GET['id']).""; 
        mysqli_query($database, $sql)  ;
    }

    header('Location: students.php');