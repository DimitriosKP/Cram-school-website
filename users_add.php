<?php
session_start();

include "config.php"; 

$pageTitle = 'HomeWork - Add new student';
require_once '_header.php';
?>
    <body>
        <?php
            require_once '_menu.php';
        ?>

        <div class="text-box">
            <h1>Προσθέστε χρήστη</h1>
            <p>Δώστε όνομα χρήστη, το email του και κωδικό πρόσβασης</p>
        </div>
<br><br>

<section class="announcements">
    <section class="cards-area" id="announcements-section" style='width:300px; margin: 0 auto'>

        <!-- Χρειαζόμαστε τη φόρμα για να σταλούν τα δεδομένα στο users_add.php-->
        <form action="users_add.php" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="post_title">Username: </label><br />
                <input type="text" placeholder="Όνομα χρήστη" name="username" required>
            </div>
            <br/>

            <div class="form-group">
                <label for="post_tags">email: </label><br />
                <input type="email" placeholder="Διεύθυνση Ηλ. ταχυδρομείου" name="email" required>
            </div>
            <br/>

            <div class="form-group">
                <label for="post_tags">password: </label><br />
                <input type="password" placeholder="Κωδικός" name="password" required>
            </div>
            <br/>

            <div class="form-group">
                <label for="post_tags">email: </label><br />
                <input type="password" placeholder="Επαλήθευση κωδικού" name="cpassword" required>
            </div>
            <br />

            <!-- εδω ανεβάζουμε νέο αρχείο. δεν υπάρχει ακόμη id. θα δημιουργηθεί στην πορεία -->
            <button name="add" type='submit' >
                <i class="fa fa-plus" aria-hidden="true"></i> Add
            </button>
        </form>

        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $_POST = array_map('trim', $_POST); 	# Θα τρέξει την συνάρτηση trim για όλα τα στοιχεία του πίνακα
        
                $email 		=  $_POST['email']??'';
                $username 	=  $_POST['username']??'';
                $password 	=  $_POST['password']??'';
                $cpassword 	=  $_POST['cpassword']??'';
                $role 		=  's';
                
                
                if (empty($email) || empty($username) || empty($password) || empty($cpassword)){
                    echo "<script>alert('Fill all fields.')</script>";
                }
                else if ($password != $cpassword){
                    echo "<script>alert('Passwords dont match.')</script>";
                }
                else{
                    
                    $sql = "SELECT *
                            FROM `users`
                            WHERE `email` = '%s' OR `username` = '%s'";
        
                    $sql = sprintf($sql,
                            mysqli_real_escape_string($database, $email),
                            mysqli_real_escape_string($database, $username),
                    );			
                    $res=mysqli_query($database, $sql);
                    if (!$res) die(mysqli_error($database));
        
                    if (mysqli_num_rows($res)>0){
                        $row = mysqli_fetch_assoc($res);
        
                        if ($row['email'] == $email){
                            # email exists
                            echo "<script>alert('Woops! The Email Already Exists.')</script>";
                        }
                        else if ($row['username'] == $username){
                            # username exists
                            echo "<script>alert('Woops! The Username Already Exists.')</script>";
                        }
                    }
                    else{
                        $hash_password = password_hash($password, PASSWORD_DEFAULT);		# SOS για κρυπτογραφηση κωδικών στη βάση
        
                        if ($role === 's');
        
                        $sql = "INSERT INTO `users` (`username`, `email`, `password`, `role`) VALUES('%s', '%s', '%s', '%s');";
                        $sql = sprintf($sql, 
                                    mysqli_real_escape_string($database, $username),
                                    mysqli_real_escape_string($database, $email),
                                    mysqli_real_escape_string($database, $hash_password),
                                    $role
                                );
                        #	die($sql);
                        if (mysqli_query($database, $sql)){
                            echo "<script>
                                    if (alert('Registration successful')){
                                        window.location='login.php';
                                    }
                                    </script>";
                        }
        
                    }
                }
            }
        
        ?>
        
    </section>
</section>
<br><br>

<?php require_once '_footer.php'; ?>
<!---------JavaScript--------->
<script src="JavaScript.js"></script>

    </body>
</html>