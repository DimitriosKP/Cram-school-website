<?php 
// Initialize the session
session_start();
require_once "config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$pageTitle = 'HomeWork - Update announcements';

require_once '_menu.php';
require_once '_header.php';



$id = $_GET['id'] ?? 0; ## εδω λεμε αν δεν ειναι ορισμένη η μεταβλητή $_GET['id'], βάλε το 0. δλδ: 

#εδω πρεπει ο καθε χρήστης να πειραζει μονο τα δικα του

$sql = "SELECT *
        FROM announcements
        WHERE ann_id = ".intval($id). "
            AND creator_id=".$_SESSION["id"];


$title = '';
$text = '';

if(($result = mysqli_query($database, $sql)) && mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_array($result);


    $title = $row['ann_title'];
    $text = $row['ann_text'];
}
else{
    #δεν βρεθηκε ανακoίνωση με αυτο το id
    header("location: announcements.php");
    die();
    
}

?>

<body> 
    <div class="text-box">
        <h1>Επεξεργασία ανακοινώσεων</h1>
    </div>
    <br><br>

    <section class="announcements">
        <section class="cards-area" id="announcements-section" style='width:300px; margin: 0 auto'>
            <form action="ann_update.php" method="post" enctype="multipart/form-data">
                <?php echo 'Announcements id:', $id;?>
                <div class="form-group">
                    <label for="title">Title: </label><br />
                    <input type="text" name="title" value='<?php echo $title?>' class="form-control" placeholder="Τίτλος" required="">
                </div>
                <br/>
                <div class="form-group">
                    <label for="post_tags">Text: </label><br />
                    <textarea rows="5" cols="40" name="text" placeholder="Εισάγετε την ανακοίνωση"><?=$text?></textarea>
                </div>
                <br/>
                
                <!-- Κρυφο πεδίο με το id -->
                <input type="hidden" name="id" value="<?=$id;?>">


                <button type='submit' name="submit" value="submit">Update</button>
            </form>
        </section>
    </section>
    <br><br>
    <?php require_once '_footer.php'; ?>
    </body>
</html>
