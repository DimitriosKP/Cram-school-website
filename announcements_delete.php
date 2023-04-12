<?php 
    require_once "config.php";

    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        $_SESSION['username'] = $username;
        header("location: login.php");
        exit;
    }

    $id=(int)$_GET['id'];

    // Only the tutor who create it can delete it
    if(isset($_GET['id']) && $_SESSION["role"] === 't') {
        $sql = "DELETE FROM announcements WHERE ann_id = :id AND creator_id = :creator_id"; 

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':creator_id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();
    }

    header('Location: announcements.php');