<?php 
    require_once "config.php";

    $_SESSION['form_message'] = [
        'has_error' => false,
        'message'   => ''
    ];

    if (!empty($_POST["subject"]) || !empty($_POST["message"])){
        $subject = $_POST["subject"] ?? '';
        $message = $_POST["message"] ?? '';
        
       
        if (empty($subject) || empty($message)) {
            $_SESSION['form_message']['has_error'] = true;
            $_SESSION['form_message']['message'] = 'Please fill in all fields of the form.';
        } else {
            $sql = "INSERT INTO `messages` SET 
                        `user_id` = '%d',
                        `subject` = '%s',
                        `message` = '%s' ";

            $sql = sprintf(
                        $sql, 
                        $_SESSION['id'],
                        mysqli_real_escape_string($database, $subject), 
                        mysqli_real_escape_string($database, $message), 
                    );

            if(mysqli_query($database, $sql)) {
                $_SESSION['form_message']['message'] = 'Your message has been sent.';
            }
            
            header("Location: ".$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);
            exit;
        }
    }
    
    $pageTitle = 'HomeWork - Contact';
    require_once '_header.php';
?>

	<body>
		<?php
            $currentPage='communication';
            require_once '_menu.php';
        ?>

		<section class="message">
            <div class="container">
                <div class="card">
                    <div class="inner-box" id="card">
                        <div class="card-front">
                            <h2>Send from web form</h2>
                            <form action="email.php" method="POST">
                                <input type="subject" name='subject' class="input-box" placeholder="Subject" required/>
                                <textarea type="message" name='message' class="input-box" placeholder="Message" required></textarea>
                                <button type="submit" name='submit' class="submit-btn">Send</button>

                                <?php if (!empty($_SESSION['form_message']['message'])){ ?>
                                    <div class='<?=($_SESSION['form_message']['has_error']?'error':'success');?>-message'>
                                        <?php
                                            echo $_SESSION['form_message']['message'];
                                            unset($_SESSION['form_message']);
                                        ?>
                                    </div>
                                        
                                <?php } ?>
                            </form>
                            
                            <h2><a href="https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox?compose=new">Send with email</a></h2>
                            <br><br><br><a href="index.php">Return to home page</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

		<div class="text-box">
				<h1>Contact</h1>
		</div>

		<?php require_once '_footer.php'; ?>
	</body>
</html>

<?php