<?php
    require_once "config.php"; 
    require_once "api/User.class.php";
    $pageTitle = 'HomeWork - Add new student';
    require_once '_header.php';
?>

    <body>
        <?php require_once '_menu.php'; ?>

        <div class="text-box">
            <h1>Add new student</h1>
            <p>Give a username, email and password</p>
        </div><br><br>

        <section class="announcements">
            <section class="cards-area" id="announcements-section" style='width:300px; margin: 0 auto'>
                <form action="users_add.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="post_title">Username</label><br/>
                        <input type="text" placeholder="Username" name="username" class="input-box" required>
                    </div>
                    <br/>
                    <div class="form-group">
                        <label for="post_tags">Email</label><br/>
                        <input type="email" placeholder="Email" name="email" class="input-box" required>
                    </div>
                    <br/>
                    <div class="form-group">
                        <label for="post_tags">Password</label><br/>
                        <input type="password" placeholder="Password" name="password" class="input-box" required>
                    </div>
                    <br/>
                    <div class="form-group">
                        <label for="post_tags">Confirm password</label><br/>
                        <input type="password" placeholder="Confirm password" name="cpassword" class="input-box" required>
                    </div>
                    <br />
                    <button name="add" type='submit'>
                        <i class="fa fa-plus" aria-hidden="true"></i>Add</button>
                </form>

                <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST") {
                        $_POST = array_map('trim', $_POST);
                
                        $email 		=  $_POST['email']??'';
                        $username 	=  $_POST['username']??'';
                        $password 	=  $_POST['password']??'';
                        $cpassword 	=  $_POST['cpassword']??'';
                        $role 		=  's';
                        
                        $user = new User($_POST['username']??'', $_POST['email']??'', $_POST['password']??'', $_POST['cpassword']??'', $_POST['role']??'');
                        
                        if ($user->checkFields($email, $username, $password, $cpassword)) {
                            echo "<script>alert('Fill all fields.')</script>";
                        } else if (!$user->checkPassword($password, $cpassword)) {
                            echo "<script>alert('Passwords dont match.')</script>";
                        } else if ($user->checkUsername($username)) {
                            echo "<script>alert('Woops! The Username Already Exists.')</script>";
                        } else if ($user->checkEmail($email)) {
                            echo "<script>alert('Woops! The Email Already Exists.')</script>";
                        } else {
                            $user->save($username, $email, $password);
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