<?php 
    // Initialize the session
    session_start();
    
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
    {
        header("location: login.php");
        exit;
    }

    $pageTitle = 'HomeWork';
    require_once '_header.php';

?>
    <body>
        <?php
            $currentPage='index';
            require_once '_menu.php';
        ?>
		
        <div class="text-box">
            <h1>Καλώς ήρθατε στη σελίδα μας!</h1>
            <p>Η σελίδα αυτή είναι ένας οδηγός εκμάθησης των γλωσσών HTML και CSS. Εδώ θα μπορείτε να δημιουργήσετε το δικό σας λογαριασμό
                και να διαβάζετε τις ανακοινώσεις μας σχετικά με τα νέα πανω στις συγκεκριμένες γλώσσες. Υπάρχει καρτέλα με έγγραφα 
                που θα χρησιμοποιηθούν για εξάσκηση, κατάθεση εργασιών αλλά και επικοινωνία με μας για να σας προσφέρουμε βοήθεια σε 
                τυχόν απορείες.</p>
        </div>
        

        <?php require_once '_footer.php'; ?>
    </body>
</html>