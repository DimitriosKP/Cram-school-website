<?php 
    require_once "config.php";
    
    // Check if the user is logged in, if not then redirect him to login page
    if (!isset($_SESSION['id']) || $_SESSION['id'] <= 0 ){
        header('Location: login.php');
        die();
    }

    $id=(int)$_GET['id'];

    // Only the tutor can delete homeworks
    if(isset($_GET['id']) && $_SESSION["role"] === 't'){
        $sql = "DELETE FROM upload_homeworks 
                WHERE file_id = ".intval($_GET['id'])." 
                    AND creator_id = ".$_SESSION['id']; 
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":file_id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":creator_id", $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();
    }

    header('Location: homework.php');