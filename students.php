<?php 
    require_once "config.php";
    session_start();

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        $_SESSION['username'] = $username;
        header("location: login.php");
        exit;
    }
    $pageTitle = 'HomeWork - Εγγεγραμμένοι φοιτητές';
    require_once '_header.php';
?>

    <body>
        <?php $currentPage='students';
            require_once '_menu.php'; ?>

        <div class="text-box">
            <h1>Students</h1>
        </div>

        <section class="announcements">
            <div class="cards-area" id="announcements-section">
            <button name="add" onclick="location.href='users_add.php'"><i class="fa fa-plus" aria-hidden="true"></i>Add</button>
            <?php
                $sql = "SELECT * FROM users WHERE role = 's'";
                if($result = mysqli_query($database, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){ ?>

                            <div class="announcements-col">
                            <img src="images/student.png" alt="student">
                                <div>
                                        <h4 style='display:inline;'><?php echo 'username:  '?></h4><h1 style='display:inline;'><?php echo $row['username'] ?></h1><br><br>	
                                        <h4><?php echo 'student ID: ', $row['id'] ?></h4>
                                        <h4 style='display:inline;'><?php echo  'email: '?></h4><h3 style='display:inline;'><?php echo $row['email'] ?></h3></h5><br>    
                                    <?php if($_SESSION["role"] == 't'):   ?>
                                        <button name="delete" onclick="location.href='users_delete.php?id=<?=$row['id'];?>'" >
                                            <i class="fa fa-trash" aria-hidden="true"></i> Delete
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