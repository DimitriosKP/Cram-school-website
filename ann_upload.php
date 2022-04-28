<?php 
// Initialize the session
session_start();

require_once "config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$pageTitle = 'HomeWork - Upload announcements';
require_once '_header.php';
?>
    <body>
        <?php require_once '_menu.php';?>

		
        <div class="text-box">
            <h1>Χώρος ανακοινώσεων</h1>
            <p>Αναρτήστε τις ανακοινώσεις σας</p>
        </div>
<br><br>

<section class="announcements">
    <section class="cards-area" id="announcements-section" style='width:300px; margin: 0 auto'>
        <!-- Χρειαζόμαστε τη φόρμα για να σταλούν τα δεδομένα στο announcements_upload.php-->
        <form action="announcements_upload.php" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="title">Title: </label><br />
                <input type="text" name="title" class="form-control" placeholder="Τίτλος" required="">
            </div>
            <br />

            <div class="form-group">
                <label for="post_tags">Text: </label><br />
                <textarea rows="5" cols="40" name="text" placeholder="Εσάγετε την ανακοίνωση"></textarea>
            </div>
            <br />

            <!-- εδω ανεβάζουμε νέο αρχείο. δεν υπάρχει ακόμη id. θα δημιουργηθεί στην πορεία -->
            <button name="upload" type='submit' >
                <i class="fa fa-upload" aria-hidden="true"></i> Upload
            </button>
        </form>

        <?php

        ?>
    </section>
</section>
<br><br>

<?php require_once '_footer.php'; ?>
<!---------JavaScript--------->
<script src="JavaScript.js"></script>

    </body>
</html>