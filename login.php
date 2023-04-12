<?php 
	require_once "config.php";
	$pageTitle = 'HomeWork - Login';
    require_once '_login_register_header.php';

    // Check if the user is logged in, if not then redirect him to login page
	if(isset($_SESSION["id"]) && $_SESSION["id"] > 0) {
		header("location: index.php");
		exit;
	}

	$error = '';

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$_POST = array_map('trim', $_POST);
	
		$username   = $_POST['username'] ?? '';
		$password   = $_POST['password'] ?? '';
	
		$sql = "SELECT * FROM `users` WHERE `username` = :username";
	
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':username', $username);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
		if ($row) {
			$hash_password = $row['password'];
			$verified = password_verify($password, $hash_password);
			if ($verified) {
	
				$_SESSION['id']             = intval($row['id']);
				$_SESSION['role']           = $row['role'];
				$_SESSION['username']       = $username;
	
				$_SESSION["loggedin"] = true;
	
				header("Location: index.php");
				die();
			} else {
				$error = 'The password is incorrect.';
			}
		} else {
			$error = 'User not exist.';
		}
	}
?>
	<div class="container"> 
		<form action="" method="POST" class="login-email">
			<p class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>
            <div class="input-group">
				<input type="username" placeholder="Username" name="username" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" required>
			</div>

			<?php if (!empty($error)) {?>
				<div style='padding:10px; background-color:#F00B17; color:#fff; text-align:center; margin:40px auto; border-radius:15px;'><?=$error;?></div>
			<?php } ?>

			<div class="input-group">
				<button name="submit" class="hero-btn">Login</button>
			</div>
			<p class="login-register-text">You don't have an account?<a href="register.php">Create now!</a></p><br>
			<p class="login-register-text"><a href="opening.php">Cancel</a></p>
		</form>
	</div>
</body>
</html>