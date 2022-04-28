<?php 
    
    session_start();

    # $_SESSION['id'] : ορίζεται μονο οταν κανει login ο χρηστης και περιέχει το userid του
    if (!isset($_SESSION['id']) || $_SESSION['id'] <=0 ){
        header('Location: login.php');
        die();
    }

    require_once "config.php";
    $id=(int)$_GET['id'];

    # μπορεί να διαγραψει μόνο ο tutor
    if(isset($_GET['id']) && $_SESSION["role"] === 't'){
        $sql = "DELETE 
                FROM upload_documents 
                WHERE file_id = ".intval($_GET['id'])." 
                    AND creator_id = ".$_SESSION['id']; 
        
        mysqli_query($database, $sql)  ;
    }

    header('Location: documents.php');
    