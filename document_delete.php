<?php     
    require_once "config.php";

    if (!isset($_SESSION['id']) || $_SESSION['id'] <= 0 ) {
        header('Location: login.php');
        die();
    }

    $id=(int)$_GET['id'];

    if(isset($_GET['id']) && $_SESSION["role"] === 't') {
        $sql = "DELETE FROM upload_documents WHERE file_id = :id 
                AND creator_id = :creator_id"; 

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':creator_id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();
    }

    header('Location: documents.php');