<?php 
    require_once "config.php";

    // Check if the user is logged in, if not then redirect him to login page
    if (!isset($_SESSION['id']) || $_SESSION['id'] <= 0 ){
        header('Location: login.php');
        die();
    }

    # Check if all data has been sent by the user
    if (!isset($_FILES['user_file']) || !isset($_POST['title']) || !isset($_POST['description'])) {    // if there is no file, title or description, exit
        header('Location: documents.php');
        die();
    }

    # Check the size of the file
    $ONE_MB = 1024*1024;

    if ($_FILES['user_file']['size'] > $ONE_MB*30) {    # Ιf it is a large file, exit
         header('Location: documents.php');
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

    if (!in_array($extension, $allowed_filetypes)) { # Ιf it is a wrong type, exit
        header('Location: documents.php');
        die();
    }

    # Replace all non-alphanumeric characters with an underscore
    $filename = greeklish($_FILES['user_file']['name']);
    $filename_chars = str_split($filename, 1); # Will break the string into an array of characters 1 character at a time.
    
    for($i=0; $i<strlen($filename); $i++) {
        # only the following characters are allowed in the file name:
        $allowd_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-.'; 
        $allowd_chars = str_split( $allowd_chars, 1); # Will break the string into an array of characters 1 character at a time.
        
        if (!in_array($filename[$i], $allowd_chars)) {
            $filename = str_replace($filename[$i], '_', $filename);
        }
    }

    ## Move the file to our folder
    ## __DIR__ is the folder where the php file where our script runs is located
    
    if (!file_exists(__DIR__.'/upload_documents/')) {
        mkdir(__DIR__.'/upload_documents/');
    }

    # We see if there is a file with the same name. so we have to change the name in the new file. 
    # We put a random character at the beginning of the name
    $filename = rand(1000,9999).'_'.$filename;

    move_uploaded_file($_FILES['user_file']['tmp_name'], __DIR__.'/upload_documents/' . $filename);
    
    # We update the database
    # $title, $description, #filename, date , creator_id
    # in the uploads table the file_id must be primary key and auto increment

    $stmt = $pdo->prepare("INSERT INTO upload_documents (file_name, file_description, file_type, file_uploaded_on, file, creator_id) 
                                VALUES (?, ?, ?, NOW(), ?, ?)");

    $stmt->execute([
        $_POST['title'],
        $_POST['description'],
        $extension,
        '/upload_documents/'.$filename,
        $_SESSION['id']
    ]);
        
    header('Location: documents.php');

    function greeklish($str) {
        $greek = array('α','ά','Ά','Α','β','Β','γ','Γ','δ','Δ','ε','έ','Ε','Έ','ζ','Ζ','η','ή','Η','θ','Θ',
        'ι','ί','ϊ','ΐ','Ι','Ί','κ','Κ','λ','Λ','μ','Μ','ν','Ν','ξ','Ξ','ο','ό','Ο','Ό','π','Π','ρ','Ρ','σ',
        'ς','Σ','τ','Τ','υ','ύ','Υ','Ύ','φ','Φ','χ','Χ','ψ','Ψ','ω','ώ','Ω','Ώ');
        
        $english = array('a', 'a','A','A','b','B','g','G','d','D','e','e','E','E','z','Z','i','i','I','th','Th',
        'i','i','i','i','I','I','k','K','l','L','m','M','n','N','x','X','o','o','O','O','p','P' ,'r','R','s',
        's','S','t','T','u','u','Y','Y','f','F','x','X','ps','Ps','o','o','O','O');

        
        return str_replace($greek, $english, $str);
    }