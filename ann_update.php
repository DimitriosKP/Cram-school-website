<?php 
    require_once "config.php";

    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }


    if($_POST['submit']){
        $id = $_POST['id'] ?? 0;
        $title = $_POST['title'] ?? false;
        $text = $_POST['text'] ?? false;
    
        if ($id>0 && $title !== false && $text !== false) {
            $sql = "UPDATE announcements SET ann_title=:title, ann_text=:text WHERE ann_id=:id AND creator_id=:creator_id";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':text', $text, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':creator_id', $_SESSION['id'], PDO::PARAM_INT);

            if($stmt->execute()) {
                echo "<script>alert('Announcement updated!')</script>";
                header("location: announcements.php");
                die();
            } else {
                echo "<script>alert('Announcement update failed!')</script>";
                header("location: announcements.php");
                die();
            }
        }
    }
    echo "<script>alert('Announcement update failed!')</script>";
    header("location: announcements.php");