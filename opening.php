<?php 
session_start();
if(isset($_SESSION['sig']))
{
    echo("<script>window.location='opening.php'</script>");
}
require_once "_header.php";
?>

<!DOCTYPE html>
<html>
    <body>
        
        <section class="header">
            <nav>
                <section class="heading1">HomeWork</section>
                <div class="nav-links" id="navLinks">
                    <i class="fa fa-times" onclick="hideMenu()"></i>
            </nav>
        </section>
		
        <div class="text-box">
            <h1>Καλώς ήρθατε στη σελίδα μας!</h1>
            <p>Η σελίδα αυτή είναι ένας οδηγός εκμάθησης των γλωσσών HTML και CSS. Εδώ θα μπορείτε να δημιουργήσετε το δικό σας λογαριασμό
                και να διαβάζετε τις ανακοινώσεις μας σχετικά με τα νέα πανω στις συγκεκριμένες γλώσσες. Υπάρχει καρτέλα με έγγραφα 
                που θα χρησιμοποιηθούν για εξάσκηση, κατάθεση εργασιών αλλά και επικοινωνία με μας για να σας προσφέρουμε βοήθεια σε 
                τυχόν απορείες.</p>
                
            <a class="hero-btn" href="login.php">Είσοδος στην εφαρμογή</a>
        </div>
        
<?php require_once "_footer.php" ?>

    </body>
</html>