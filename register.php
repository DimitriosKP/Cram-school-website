<?php
    require_once "config.php"; 
    include "api/User.class.php";

    $pageTitle = 'HomeWork - Register';
    require_once '_login_register_header.php';

    // Check if the user is logged in, if not then redirect him to login page
	if(isset($_SESSION["id"]) && $_SESSION["id"] > 0) {
		header("location: index.php");
		exit;
	}

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $_POST = array_map('trim', $_POST);

        $username 	=  $_POST['username']??'';
        $email 		=  $_POST['email']??'';
        $password 	=  $_POST['password']??'';
        $cpassword 	=  $_POST['cpassword']??'';
        $role 		=  $_POST['role']??'';

        $user = new User($_POST['username']??'', $_POST['email']??'', $_POST['password']??'', $_POST['cpassword']??'', $_POST['role']??'');

        if ($user->checkFields($email, $username, $password, $cpassword)) {
            echo "<script>alert('Fill all fields.')</script>";
        } else if (!$user->checkPassword($password, $cpassword)) {
            echo "<script>alert('Passwords dont match.')</script>";
        } else {
            $user->save($username, $email, $password);
        }
    }
?>

	<div class="container">
		<form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
			<div class="input-group">
				<input type="text" placeholder="Username" name="username" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" required>
            </div>
            <div class="input-group">
				<input type="password" placeholder="Confirm password" name="cpassword" required>
			</div>
			<div>
				<label for="tutor" class="radio-inline"><input type="radio" name="role" value="t" id="tutor" required>Tutor</label>
				<label for="student" class="radio-inline"><input type="radio" name="role" value="s" id="student" required>Student</label>
            </div>
			<br>
			<div class="input-group">
				<button name="submit" class="hero-btn">Register</button>
			</div>
			<p class="login-register-text">Already have an account? <a href="login.php">Login!</a></p><br>
			<p class="login-register-text"><a href="opening.php">Cancel</a></p>
		</form>
	</div>

</body>
</html>