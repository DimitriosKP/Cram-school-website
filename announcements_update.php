<?php
    require_once "config.php";

    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

    $pageTitle = 'HomeWork - Update announcements';

    require_once '_menu.php';
    require_once '_header.php';

    $id = $_GET['id'] ?? 0; # Εach user to make changes only to his own announcements

    // Only allow the user to modify their own announcements
    $sql = "SELECT * FROM announcements WHERE ann_id = :id AND creator_id = :creator_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', intval($id), PDO::PARAM_INT);
    $stmt->bindValue(':creator_id', $_SESSION['id'], PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        // No announcement with this id
        header("location: announcements.php");
        die();
    }

    $title = $row['ann_title'];
    $text = $row['ann_text'];

?>

<body> 
    <div class="text-box">
        <h1>Edit announcements</h1>
    </div>
    <br><br>

    <section class="announcements">
        <section class="cards-area" id="announcements-section" style='width:300px; margin: 0 auto'>
            <form action="ann_update.php" method="post" enctype="multipart/form-data">
                <?php echo 'Announcements id:', $id;?>
                <div class="form-group">
                    <label for="title">Title: </label><br />
                    <input type="text" name="title" value='<?php echo $title?>' class="input-box" placeholder="Title" required="">
                </div>
                <br/>
                <div class="form-group">
                    <label for="post_tags">Text: </label><br />
                    <textarea rows="5" cols="40" name="text" placeholder="Content" class="input-box"><?=$text?></textarea>
                </div>
                <br/>
                
                <!-- Κρυφο πεδίο με το id -->
                <input type="hidden" name="id" value="<?=$id;?>">

                <button type='submit' name="submit" value="submit">Update</button>
                <button name="cancel" onclick="location.href='announcements.php;?>'" >
                                <i class="fa fa-trash" aria-hidden="true"></i>Cancel
                </button>
            </form>
        </section>
    </section>
    <br><br>
    <?php require_once '_footer.php'; ?>
    </body>
</html>