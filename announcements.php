<?php 
    session_start();

    require_once "config.php";
    
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        $_SESSION['username'] = $username;
        header("location: login.php");
        exit;
    }

    $pageTitle = 'HomeWork - Ανακοινώσεις';
    require_once '_header.php';
?>

    <body>
        <?php
            $currentPage='announcements';
            require_once '_menu.php';
        ?>

        <div class="text-box">
            <h1>Ανακοινώσεις</h1>
        </div>
        
        <section class="announcements">
            <div class="cards-area" id="announcements-section">
                 
            <?php if($_SESSION["role"] === 't'):   ?>       
               <button onclick="location.href='ann_upload.php'" name="ann_upload">
                    <i class="fa fa-upload" aria-hidden="true"></i> Upload
                </button><br>
            <?php endif ?> 

           
            <?php
            # εδω πρεπει να συσχετιστεί με χρήστη και μαθημα ώστε ο κάθε χρήστης να βλεπει τα δικα του και ο καθε καθηγητης αυτά των μαθημάτων του.
                $sql = "SELECT AN.*, US.username
                FROM announcements AN LEFT JOIN users US ON AN.creator_id=US.id
                ORDER BY AN.ann_uploaded_on";

                if($result = mysqli_query($database, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){ ?>
                            <div class="announcements-col">
                                <img src="images/ann.png" alt="Document">
                                <div>
                                    <h1><?php echo  $row['ann_title'] ?></h1><br>
                                    <h4><?php echo 'Συντάκτης: ', $row['username']?></h4>
                                    <h4><?php echo 'Η ανακοίνωση αναρτήθηκε στις: ', $row['ann_uploaded_on'] ?></h4>
                                    <h4><?php echo 'Announcement ID: ', $row['ann_id'] ?></h4>	
                                    <h3><?php echo  $row['ann_text']?></h3>
                                
                                <?php if($_SESSION["role"] == 't' && $_SESSION['id'] == $row['creator_id']):   ?>
                                        <button name="delete" onclick="location.href='announcements_delete.php?id=<?=$row['ann_id'];?>'" >
                                            <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                        </button>
                                        
                                        <!-- μονο το id εδω . 
                                                επίσης μεσω την μεθοδου GET υπαρχει περιορισμός στο μέγεθος των δεδομενων
                                            -->
                                        <button name="update" onclick="location.href='announcements_update.php?id=<?=$row['ann_id'];?>'">
                                            <i class="fa fa-pencil" aria-hidden="true"></i> Update
                                        </button>
                                    <?php endif ?>  

                                </div>
                            </div>
                        <?php
                        }
                        // Free result set
                        mysqli_free_result($result);
                    } 
                    else{
                        echo "No records matching your query were found.";
                    }
                } 
                else{
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($database);
                }
                // Close connection
                mysqli_close($database);
                ?>
            </div>
        </section>
        <?php require_once '_footer.php'; ?>
    </body>
</html>