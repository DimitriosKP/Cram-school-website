<?php
	session_start();

	# σε περιπτωση που είναι συνδεδεμένος, δρόμο...
	if(isset($_SESSION["id"]) && $_SESSION["id"] > 0)
	{
		header("location: index.php");
		exit;
	}

	include "config.php"; 

	//if(isset($_POST['submit']))
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$_POST = array_map('trim', $_POST); 	# Θα τρέξει την συνάρτηση trim για όλα τα στοιχεία του πίνακα

		$email 		=  $_POST['email']??'';
		$username 	=  $_POST['username']??'';
		$password 	=  $_POST['password']??'';
		$cpassword 	=  $_POST['cpassword']??'';
		$role 		=  $_POST['role']??'';
		
		
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

				if ($role != 't') $role='s';

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

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="style-login-register.css">
	<title>Register</title>
</head>
<body>
	<div class="container">
		<form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Εγγραφή</p>
			<div class="input-group">
				<input type="text" placeholder="Όνομα χρήστη" name="username" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Διεύθυνση Ηλ. ταχυδρομείου" name="email" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Κωδικός" name="password" required>
            </div>
            <div class="input-group">
				<input type="password" placeholder="Επαλήθευση κωδικού" name="cpassword" required>
			</div>
			<div>
                    <label for="tutor" class="radio-inline"><input type="radio" name="role" value="t" id="tutor" required>Καθηγητής</label>
                    <label for="student" class="radio-inline"><input type="radio" name="role" value="s" id="student" required>Φοιτητής</label>
            </div>
			<br>
			<div class="input-group">
				<button name="submit" class="hero-btn">Εγγραφή</button>
			</div>
			<p class="login-register-text">Έχετε ήδη λογαριασμό; <a href="login.php">Συνδεθείτε</a>.</p>
			<p class="login-register-text"><a href="opening.php">Κλείσιμο</a></p>
		</form>
	</div>

</body>
</html>