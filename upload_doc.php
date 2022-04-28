<?php 
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$pageTitle = 'HomeWork - Upload files';
require_once '_header.php';
?>
    <body>
        <?php
            require_once '_menu.php';
        ?>

		
        <div class="text-box">
            <h1>Ανεβάστε τα αρχεία σας</h1>
            <p>Επιτρεπτές μορφές αρχείων είναι pfd, docx, doc, zip</p>
        </div>
<br><br>

<section class="announcements">
    <section class="cards-area" id="announcements-section" style='width:300px; margin: 0 auto'>

        <!-- Χρειαζόμαστε τη φόρμα για να σταλούν τα δεδομένα στο document_upload.php-->
        <form action="document_upload.php" method="post" enctype="multipart/form-data">

         <!-- Χρειαζόμαστε τη φόρμα για να σταλούν τα δεδομένα στο homework_upload.php-->
         <form action="homework_upload.php" method="post" enctype="multipart/form-data">


            <div class="form-group">
                <label for="post_title">Title: </label><br />
                <input type="text" name="title" class="form-control" placeholder="Eg: Php Tutorial File"  value = "<?php if(isset($_POST['upload'])) {
                    echo $file_title; } ?>" required="">
            </div>
            <br />

            <div class="form-group">
                <label for="post_tags">Description: </label><br />
                <input type="text" name="description" class="form-control" placeholder="Eg: Php Tutorial File includes basic php programming ...." value="<?php if(isset($_POST['upload'])) {
                    echo $file_description;  } ?>" required="" ">
            </div>
            <br />

            <div class="form-group">
                <label for="post_image">Select File:</label><span style='color:red'> (allowed file type: 'pdf','doc','ppt','txt','zip' | allowed maximum size: 30 mb ) </span><br />
                <input type="file" name="user_file"> 
            </div>
            <!-- εδω ανεβάζουμε νέο αρχείο. δεν υπάρχει ακόμη id. θα δημιουργηθεί στην πορεία -->
            <button name="upload" type='submit' >
                <i class="fa fa-upload" aria-hidden="true"></i> Upload
            </button>
        </form>

        <?php
            /*
            # Αυτο θα πάει στο document_upload.php
            if (isset($_GET['upload'])) 
            {
                $file_name = $_FILES['file_name'];
                $file_description = $_FILES['file_description'];
                $file_type = $_FILES['file_type'];
                $file = $_FILES['file'];
                $upload_folder="uploads/";

                $movefile = move_uploaded_file($file_name, $uploads .$file_name);

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
        ?>
    </section>
</section>
<br><br>

<?php require_once '_footer.php'; ?>
<!---------JavaScript--------->
<script src="JavaScript.js"></script>

    </body>
</html>