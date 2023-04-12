<?php
    require_once "config.php";

    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        $_SESSION['username'] = $username;
        header("location: login.php");
        exit;
    }

    # We check if all data has been sent by the user
    if (!isset($_POST['title']) || !isset($_POST['text'])) {
        header('Location: announcements.php');
        exit();
    }

    $title = $_POST['title'];
    $text = $_POST['text'];
    $creator_id = $_SESSION['id'];
    
    # We update the database
    # $title, $text, date , creator_id
    # in the announcements table ann_id must be primary_key and auto increment
    $sql = "INSERT INTO announcements (`ann_title`, `ann_uploaded_on`, `ann_text`, `creator_id`)  
    VALUES (:title, NOW(), :text, :creator_id)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':text', $text);
    $stmt->bindParam(':creator_id', $creator_id);
    $stmt->execute();

    header('Location: announcements.php');

    function greeklish($str) {
        $greek = array('α','ά','Ά','Α','β','Β','γ','Γ','δ','Δ','ε','έ','Ε','Έ','ζ','Ζ','η','ή','Η','θ','Θ',
        'ι','ί','ϊ','ΐ','Ι','Ί','κ','Κ','λ','Λ','μ','Μ','ν','Ν','ξ','Ξ','ο','ό','Ο','Ό','π','Π','ρ','Ρ','σ',
        'ς','Σ','τ','Τ','υ','ύ','Υ','Ύ','φ','Φ','χ','Χ','ψ','Ψ','ω','ώ','Ω','Ώ');

        $english = array('a', 'a','A','A','b','B','g','G','d','D','e','e','E','E','z','Z','i','i','I','th','Th',
        'i','i','i','i','I','I','k','K','l','L','m','M','n','N','x','X','o','o','O','O','p','P' ,'r','R','s',
        's','S','t','T','u','u','Y','Y','f','F','x','X','ps','Ps','o','o','O','O');

        return str_replace($greek, $english, $str);
    }