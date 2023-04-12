<?php 
    require_once "config.php";

    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        $_SESSION['username'] = $username;
        header("location: login.php");
        exit;
    }

    $pageTitle = 'HomeWork - Homeworks';
    require_once '_header.php';
?>

    <body>
        <?php
            $currentPage='homework';
            require_once '_menu.php';
        ?>

        <div class="text-box">
            <h1>Homeworks</h1>
        </div>

        <div class="container">
            <section class="announcements">
            <section class="cards-area" id="announcements-section">

            <?php if($_SESSION["role"] === 't'):   ?>       
                <button onclick="location.href='upload_hw.php'" name="upload_hw">
                    <i class="fa fa-upload" aria-hidden="true"></i>Upload</button><br>
            <?php endif ?> 

            <?php
            # Here it must be associated with a user and a course so that each user can see his own and each teacher can see those of his courses.
            $sql = "SELECT UH.*, US.username
                    FROM upload_homeworks UH LEFT JOIN users US ON UH.creator_id=US.id
                    ORDER BY UH.file_uploaded_on";

            $stmt = $pdo->query($sql);
            $rowCount = $stmt->rowCount();
            if($rowCount > 0) {
                while($row = mysqli_fetch_array($result)) { ?>
                    <div class="announcements-col">
                        <img src="images/pencil.png" alt="Document">
                        <div>
                            <h1><?php echo  $row['file_name'] ?></h1><br>
                            <h4><?php echo 'The announcement was posted from: ', $row['username'] ?></h4>
                            <h4><?php echo 'The announcement was posted on: ', $row['file_uploaded_on'] ?></h4>
                            <h4><?php echo 'File ID: ', $row['file_id'] ?></h4>
                            <h3 style='display: inline-block;'><?php echo 'Description: '?></h3><h2 style='display: inline-block;'><?php echo $row['file_description']?></h2><br>
                            <p><?php echo "Type of file: ", $row['file_type'] ?></p>
                            
                            <?php if($_SESSION["role"] == 't' && $_SESSION['id'] == $row['creator_id']):   ?>
                                <button name="delete" onclick="location.href='homework_delete.php?id=<?=$row['file_id'];?>'" >
                                    <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                </button>   
                            <?php endif ?>  
                            <?php if($_SESSION["role"] === 't' && $_SESSION['id'] === $row['creator_id']):   ?>
                                <form action="upload_hw.php" method="post" enctype="multipart/form-data">file to upload:
                                    <input type="file" name="myfile" >
                                    <input type="submit" value="Upload" name="submit">
                                </form>
                
                            <?php endif ?>  
                            <?php if($_SESSION["role"] !== 't'):   ?>       
                                <button name="download" onclick="location.href='download_hw.php?file=<?=$row['file'];?>'" >
                                        <i class="fa fa-download" aria-hidden="true"></i> Download
                                    </button>
                                <button onclick="location.href='upload_hw.php'" name="upload_hw">
                                <i class="fa fa-upload" aria-hidden="true"></i>Upload</button>
                            <?php endif ?>
                        </div>
                    </div>
                <?php
                }
            } else {
                echo "No records matching your query were found.";
            }
        ?>
        </section>
        </div>

        <?php require_once '_footer.php'; ?>
    </body>
</html>