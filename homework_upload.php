<?php 
    
    session_start();

    if (!isset($_SESSION['id']) || $_SESSION['id'] <=0 ){
        header('Location: login.php');
        die();
    }

    require_once 'config.php';
    /*echo '<pre>';
    echo 'Τα  δεδομένα απ τα πεδια της φορμας<br />';
    print_r($_POST);
    echo '<br /><br />Το αρχειο<br />';
    print_r($_FILES);*/
    


    # Εδω πρέπει να γίνουν οι έλεγχοι πριν κάνουμε κάτι με το αρχείο...
    # ελεγχουμε αν εχουν σταλεί ολα τα δεδομένα απ τον χρηστη
    if (! isset($_FILES['user_file'])) {
        # δεν υπάρχει αρχείο; έξοδος
        header('Location: homework.php');
        die();
    }
    else if (! isset($_POST['title'])) {
        # δεν έβαλε τίτλο; έξοδος
        header('Location: homework.php');
        die();
    }
    else if (! isset($_POST['description'])) {
        # δεν έβαλε περιγραφή; έξοδος
        header('Location: homework.php');
        die();
    }

    # Βλέπουμε αν ειναι οκ το μέγεθος
    $ONE_MB = 1024*1024;

    if ($_FILES['user_file']['size'] > $ONE_MB*30){
         # πολύ μεγάλο αρχείο; έξοδος
         header('Location: homework.php');
         die();
    }

    # παίρνουμε το extension του αρχείου που ανεβηκε
    $extension = pathinfo($_FILES['user_file']['name'], PATHINFO_EXTENSION);

    # Βλέπουμε αν ειναι οκ ο τύπος
    $allowed_filetypes=[
       'zip',
       'pdf',
       'doc',
       'docx',
       'ppt',
       'pptx',
       'txt',
    ];

    if (!in_array($extension, $allowed_filetypes)){
         # μη επιτρεπόμενος τυπος; έξοδος
         header('Location: homework.php');
         die();
    }


    # για έξτρα ασφάλεια ελεγχουμε το όνομα του αρχείου μην περιέχει περιεργους χαρακτηρες που μπορεί να κανουν ζημια στον σερβερ.
    # πχ αντικαθιστουμε όλους τους μη αλφαριθμητικους χαρακτήρες με μια κατω παυλα

    $filename = greeklish($_FILES['user_file']['name']);
    $filename_chars = str_split($filename, 1); # θα σπασει το string σε ενα πινακα με τους χαρακτήρες ανα 1 χαρακτήρα.
    
    for($i=0; $i<strlen($filename); $i++){
        # στα linux αν ο χρήστης ανεβάσει ενα αρχείο με όνομα  ../file.zip  και εμεις παμε να το αποθηκεύσουμε στον φάκελο uploads
        # θα εχουμε την εξης διαδρομη:  uploads/../file.zip  Aυτο ειναι στην ουσια έξω από τον φάκελο uploads

        # μονο οι παρακάτω χαρακτηρες επιτρέπονται στο ονομα αρχειου:
        $allowd_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-.'; 
        $allowd_chars = str_split( $allowd_chars, 1); # θα σπασει το string σε ενα πινακα με τους χαρακτήρες ανα 1 χαρακτήρα
        
        if (!in_array($filename[$i], $allowd_chars)){
            $filename = str_replace($filename[$i], '_', $filename);
        }
    }

    // print($filename );die();

    ## ώρα να μεταφέρουμε το αρχειο στον φακελό μας
    ## __DIR__ ειναι ο φάκελος όπου βρίσκεται το αρχείο php οπου τρέχει το script μας
    
    if (!file_exists(__DIR__.'/upload_homeworks/')){ # αν δεν υπάρχει... 
        mkdir(__DIR__.'/upload_homeworks/');
    }

    # βλέπουμε μηπως υπάρχει αρχειο με ιδιο ονομα. οποτε πρεπει να αλλαξουμε το όνομα στο νεο αρχειο για να μην πετάξει σφαλμα
    # μπορούμε να το διαγράψουμε επισης αν δεν μας νοιαζει.. 

    # για διαγραφή: 
    # unlink(__DIR__.'/uploads/' . $filename);

    # αλλιως βαζουμε ενα ραντομ στην αρχή του ονοματος
    $filename = rand(1000,9999).'_'.$filename;

    move_uploaded_file($_FILES['user_file']['tmp_name'], __DIR__.'/upload_homeworks/' . $filename); ##  $filename το ασφαλές ονομα που ετοιμάσαμε για το αρχειο μας
    
    # τελος ενημερωνουμε τη βάση με 
    # $title, $description, #filename, date , creator_id
    # στον πινακα uploads το file_id πρπει να ειναι primary_key και auto increament

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
    /*
    if (isset($_GET['upload'])) 
    {
        $file_name = $_FILES['file_name'];
        $file_description = $_FILES['file_description'];
        $file_type = $_FILES['file_type'];
        $file = $_FILES['file'];
        $upload_folder="/uploads/";

        $movefile = move_uploaded_file($_FILES['user_file']['tmp_name'], 'uploads' .$file_name);

        if($move_uploaded_file){
            echo "File uploaded succesfully";
        }

        $sql="INSERT INTO uploads (file_name,file_description,file_type,file) VALUES('$file_name','$file_description','$file_type','$file')";
        mysqli_query($conn,$sql);
        if (mysqli_query($conn, $sql)) 
        {
            echo "New file uploaded successfully";
        } else 
        {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }       
    }
    */
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