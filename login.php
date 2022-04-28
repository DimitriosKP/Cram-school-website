<?php 

	session_start();
	
	# σε περιπτωση που είναι συνδεδεμένος, δρόμο...
	if(isset($_SESSION["id"]) && $_SESSION["id"] > 0)
	{
		header("location: index.php");
		exit;
	}

	$error = '';

	require_once "config.php";

	//if(isset($_POST['submit']))
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$_POST = array_map('trim', $_POST); 	# Θα τρέξει την συνάρτηση trim για όλα τα στοιχεία του πίνακα

		$username 	=  $_POST['username']??'';
		$email 		=  $_POST['email']??'';
		$password 	=  $_POST['password']??'';

		$sql = "SELECT * 
				FROM `users` 
				WHERE `username` ='%s' AND `email`='%s'";

		$sql = sprintf($sql,
						mysqli_real_escape_string($database, $username),
						mysqli_real_escape_string($database, $email)
					);			
		
		$res=mysqli_query($database, $sql);
		if (!$res) die(mysqli_error($database));

		if (mysqli_num_rows($res) > 0){
			$row = mysqli_fetch_assoc($res);

			$hash_password = $row['password'];
			$verified = password_verify($password, $hash_password);
			if ($verified){

				$_SESSION['id']			= intval($row['id']);
				$_SESSION['role']		= $row['role'];
				$_SESSION['username']	= $username;
				$_SESSION['email'] 		= $email;

				#$_SESSION['password'] = $password;	#δεν χρειαζεται να ειναι πουθενά αυτο περαν της βασης οπου είναι κρυπτογραφημένο
				$_SESSION["loggedin"] = true;	# αυτο μπορεις να το ξερουμε εφοσον $_SESSION[id] > 0

				header("Location: index.php");
				die();
			}
			else{
				$error = 'The password is incorrect.';
			}
		}
		else{
			$error = 'User not exist.';
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
	<title>Login</title>
</head>
<body>
	<div class="container"> 
		<form action="" method="POST" class="login-email">
			<p class="login-text" style="font-size: 2rem; font-weight: 800;">Είσοδος</p>
            <div class="input-group">
				<input type="username" placeholder="Όνομα χρήστη" name="username" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Διεύθυνση Ηλ. ταχυδρομείου" name="email" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Κωδικός" name="password" required>
			</div>

			<?php if (!empty($error)){?>
				<div style='padding:10px; background-color:#F00B17; color:#fff; text-align:center; margin:40px auto; border-radius:15px;'><?=$error;?></div>
			<?php } ?>

			<div class="input-group">
				<button name="submit" class="hero-btn">Είσοδος</button>
			</div>
			<p class="login-register-text">Δεν έχετε λογαριασμό; <a href="register.php">Εγγραφείτε τώρα</a>.</p>
			<p class="login-register-text"><a href="opening.php">Κλείσιμο</a></p>
		</form>
	</div>
</body>
</html>