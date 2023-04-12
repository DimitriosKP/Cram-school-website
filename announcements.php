<?php 
    require_once "config.php";
    include "api/Announcements.class.php";
    $currentPage='announcements';
    $pageTitle = 'HomeWork - Announcements';
    require_once "_header.php";
    require_once "_menu.php";

    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        $_SESSION['username'] = $username;
        header("location: login.php");
        exit;
    }
?>
<body>
    <div class="text-box"><h1>Announcements</h1></div>
    <section class="announcements">
        <div class="cards-area" id="announcements-show">
            <?php 
            if($_SESSION["role"] === 't'): ?>       
                <button name="upload_btn" id="upload-btn"><i class="fa fa-upload" aria-hidden="true"></i>Upload</button><br>
            <?php endif;
                $title = isset($_POST['title']) ? $_POST['title'] : '';
                $text = isset($_POST['text']) ? $_POST['text'] : '';
                $ann = new Announcements($title, $_SESSION['username'], $text);
                $ann->showAnnouncements();
            ?> 
        </div>
    </section>
    <section class="cards-area" id="announcements-upload" style='display:none; width:300px; margin: 0 auto'>
        <!-- Send data to announcements_upload.php-->
        <form action="announcements_upload.php" method="post" enctype="multipart/form-data" style="text-align:center;">
            <div class="form-group">
                <label for="title">Title: </label><br />
                <input type="text" name="title" class="input-box" placeholder="Title" style="height:40px;" required="">
            </div>
            <br />
            <div class="form-group">
                <label for="post_tags">Text: </label><br />
                <textarea name="text" class="input-box" placeholder="Content" style="height:100px;"></textarea>
            </div>
            <br />
            <!-- Here we upload new file. no id yet. -->
            <button name="upload" type='submit'><i class="fa fa-upload" aria-hidden="true"></i>Upload</button>
            <button name="cancel" type='button'><i class="fa fa-cancel" aria-hidden="true"></i>Cancel</button>
        </form>
    </section>
    <script src="announcements.js"></script>
    <?php require_once '_footer.php'; ?>
</body>
</html>