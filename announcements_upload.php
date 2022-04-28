<?php 
    
    session_start();
    require_once 'config.php';

    if (!isset($_SESSION['id']) || $_SESSION['id'] <=0 ){
        header('Location: login.php');
        die();
    }

    /*echo '<pre>';
    echo 'Τα  δεδομένα απ τα πεδια της φορμας<br />';
    print_r($_POST);
    echo '<br /><br />Το αρχειο<br />';
    print_r($_FILES);*/
    

    # Εδω πρέπει να γίνουν οι έλεγχοι πριν κάνουμε κάτι με το αρχείο...

    # ελεγχουμε αν εχουν σταλεί ολα τα δεδομένα απ τον χρηστη
    if (! isset($_POST['title'])) {
        # δεν έβαλε τίτλο; έξοδος
        header('Location: announcements.php');
        die();
    }
    else if (! isset($_POST['text'])) {
        # δεν έβαλε κείμενο; έξοδος
        header('Location: announcements.php');
        die();
    }


    # ενημερωνουμε τη βάση με 
    # $title, $text, date , creator_id
    # στον πινακα announcements το ann_id πρέπει να ειναι primary_key και auto increament

    $sql = "INSERT INTO announcements (`ann_title`, `ann_uploaded_on`, `ann_text`, `creator_id`)  
            VALUES ('%s', NOW(), '%s', '%d')";

    $sql = sprintf($sql,
                mysqli_real_escape_string($database, $_POST['title']),
                mysqli_real_escape_string($database, $_POST['text']),
                $_SESSION['id']
            );

    mysqli_query($database, $sql);

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