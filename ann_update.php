<?php 
    session_start();
    require_once "config.php";

        
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }


    if($_POST['submit']){

        $id = $_POST['id'] ?? 0;
        $title = $_POST['title'] ?? false;
        $text = $_POST['text'] ?? false;

        if ($id>0 && $title !== false && $text !== false){
            $title = mysqli_real_escape_string($database, $title);
            $text = mysqli_real_escape_string($database, $text);
            $id = (int)$id;

            $sql = "UPDATE announcements SET 
                        ann_title='$title', 
                        ann_text='$text' 
                    WHERE ann_id='$id' AND creator_id=".$_SESSION['id'];

            $done = mysqli_query($database, $sql);

            if($done){
                echo "<script>alert('Announcement updated!')</script>";
                header("location: announcements.php");
                die();
            }
            else{
                echo "<script>alert('Announcement update failed!</script>";
                header("location: announcements.php");
                die();
            }
        }
    }
    echo "<script>alert('Announcement update failed!</script>";
    header("location: announcements.php");






    ###  Αυτο ειναι ενα αρχειο μονο php για να κανει το update δεν εχει ουτε html ουτε javascript. 

#<?php require_once '_footer.php';
#<script src="JavaScript.js"></script>
