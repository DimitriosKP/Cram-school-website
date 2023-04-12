<?php 
    require_once 'config.php';
    
    // Check if the user is logged in, if not then redirect him to login page
    if (!isset($_SESSION['id']) || $_SESSION['id'] <= 0 ) {
        header('Location: login.php');
        die();
    }

    if (! isset($_FILES['user_file']) || ! isset($_POST['title']) || ! isset($_POST['description'])) {
        header('Location: homework.php');
        die();
    }

    $ONE_MB = 1024*1024;

    if ($_FILES['user_file']['size'] > $ONE_MB*30) {
         header('Location: homework.php');
         die();
    }

    # Check the file extension
    $extension = pathinfo($_FILES['user_file']['name'], PATHINFO_EXTENSION);

    $allowed_filetypes=[
       'zip',
       'pdf',
       'doc',
       'docx',
       'ppt',
       'pptx',
       'txt',
    ];

    if (!in_array($extension, $allowed_filetypes)) {
         header('Location: homework.php');
         die();
    }
    
    # Replace all non-alphanumeric characters with an underscore
    $filename = greeklish($_FILES['user_file']['name']);
    $filename_chars = str_split($filename, 1);
    
    for($i=0; $i<strlen($filename); $i++){

        $allowd_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-.'; 
        $allowd_chars = str_split( $allowd_chars, 1);
        
        if (!in_array($filename[$i], $allowd_chars)) {
            $filename = str_replace($filename[$i], '_', $filename);
        }
    }

    if (!file_exists(__DIR__.'/upload_homeworks/')) { 
        mkdir(__DIR__.'/upload_homeworks/');
    }

    $filename = rand(1000,9999).'_'.$filename;

    move_uploaded_file($_FILES['user_file']['tmp_name'], __DIR__.'/upload_homeworks/' . $filename);

    $sql = "INSERT INTO upload_homeworks (`file_name`, `file_description`, `file_type`, `file_uploaded_on`, `file`, `creator_id`)  
            VALUES ('%s', '%s', '%s', NOW(), '%s', %d)";

    $sql = sprintf($sql,
                mysqli_real_escape_string($database, $_POST['title']),
                mysqli_real_escape_string($database, $_POST['description']),
                mysqli_real_escape_string($database, $extension),
                mysqli_real_escape_string($database, '/upload_homeworks/'.$filename),
                $_SESSION['id']
            );

    mysqli_query($database, $sql);
    header('Location: homework.php');

    function greeklish($str) {
        $greek = array('α','ά','Ά','Α','β','Β','γ','Γ','δ','Δ','ε','έ','Ε','Έ','ζ','Ζ','η','ή','Η','θ','Θ',
        'ι','ί','ϊ','ΐ','Ι','Ί','κ','Κ','λ','Λ','μ','Μ','ν','Ν','ξ','Ξ','ο','ό','Ο','Ό','π','Π','ρ','Ρ','σ',
        'ς','Σ','τ','Τ','υ','ύ','Υ','Ύ','φ','Φ','χ','Χ','ψ','Ψ','ω','ώ','Ω','Ώ');
        
        $english = array('a', 'a','A','A','b','B','g','G','d','D','e','e','E','E','z','Z','i','i','I','th','Th',
        'i','i','i','i','I','I','k','K','l','L','m','M','n','N','x','X','o','o','O','O','p','P' ,'r','R','s',
        's','S','t','T','u','u','Y','Y','f','F','x','X','ps','Ps','o','o','O','O');

        
        return str_replace($greek, $english, $str);
    }