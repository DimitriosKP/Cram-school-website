<?php 
    require_once "config.php";
    
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
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
            <h1>Upload your files</h1>
            <p>Allowed file formats: pfd, docx, doc, zip</p>
        </div><br><br>

        <section class="announcements">
            <section class="cards-area" id="announcements-section" style='width:300px; margin: 0 auto'>

                <!-- We need the form to send the data to document_upload.php-->
                <form action="document_upload.php" method="post" enctype="multipart/form-data">

                <!-- We need the form to send the data to homework_upload.php-->
                <form action="homework_upload.php" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="post_title">Title</label><br />
                        <input type="text" name="title" class="input-box" placeholder="Eg: Php Tutorial File"  value = "<?php if(isset($_POST['upload'])) {
                            echo $file_title; } ?>" required="">
                    </div>
                    <br />

                    <div class="form-group">
                        <label for="post_tags">Description</label><br/>
                        <input type="text" name="description" class="input-box" placeholder="Eg: Php Tutorial File includes basic php programming ...." value="<?php if(isset($_POST['upload'])) {
                            echo $file_description;  } ?>" required="">
                    </div>
                    <br />

                    <div class="form-group">
                        <label for="post_image">Select File</label><span style='color:red'> (allowed file type: 'pdf','doc','ppt','txt','zip' | allowed maximum size: 30 mb ) </span><br />
                        <input type="file" name="user_file" value="Select file"> 
                    </div>
                    <button name="upload" type='submit'>
                        <i class="fa fa-upload" aria-hidden="true"></i>Upload</button>
                </form>
            </section>
        </section><br><br>
    <?php require_once '_footer.php'; ?>
    <!---------JavaScript--------->
    <script src="JavaScript.js"></script>
    </body>
</html>