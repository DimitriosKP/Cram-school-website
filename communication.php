<?php 
    require_once "config.php";
    session_start();

    $_SESSION['form_message'] = [
        'has_error' => false,
        'message'   => ''
    ];

    if (!empty($_POST["subject"]) || !empty($_POST["message"])){
        $subject = $_POST["subject"] ?? '';
        $message = $_POST["message"] ?? '';
        
       
        if (empty($subject) || empty($message)){
            $_SESSION['form_message']['has_error'] = true;
            $_SESSION['form_message']['message'] = 'Παρακαλώ συμπληρώστε όλα τα πεδία της φόρμας.';
        }
        else{

            # με χρήση INSERT.
            $sql = "INSERT INTO `messages` SET 
                        `user_id` = '%d',
                        `subject` = '%s',
                        `message` = '%s' ";

            # %d integer, %s string
            # εδω αντικαθιστούμε τα % με τη σειρά που είναι στο string. παράλληλα κάνουμε και escape oποιοδήποτε string μπαίνει στη βάση ΠΡΕΠΕΙ να γίνει escape!
            $sql = sprintf(
                        $sql, 
                        $_SESSION['id'],    # όταν κάνει login βάζουμε στο session το userid
                        mysqli_real_escape_string($database, $subject), # `subject` = '%s' << θα αντικαταστήσει το πρώτο %s 
                        mysqli_real_escape_string($database, $message), # `message` = '%s' << θα αντικαταστήσει το δεύτερο %s
                    );

            if(mysqli_query($database, $sql)){
                $_SESSION['form_message']['message'] = 'Το μήνυμά σας έχει αποσταλεί.';
            }
            
            # κανουμε redirect στην ιδια σελίδα ώστε αν κανει refresh να μην κάνει επανα-αποστολή της φόρμας. 
            # βαλέ σε σχολιο τις 2 παρακάτω γραμμες, κανε submit ενα μήνυμα και μετα F5.
            header("Location: ".$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);
            exit;
        }
    }
    
    $pageTitle = 'HomeWork - Επικοινωνία';
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
                            <h2>Αποστολή e-mail μέσω web φόρμας</h2>

                            <form action="email.php" method="POST">
                                <input type="subject" name='subject' class="input-box" placeholder="Θέμα" required/>
                                <textarea type="message" name='message' class="input-box" placeholder="Μήνυμα" required></textarea>
                                <button type="submit" name='submit' class="submit-btn">Αποστολή</button>

                                <?php if ( !empty($_SESSION['form_message']['message']) ){ ?>
                                    <div class='<?=($_SESSION['form_message']['has_error']?'error':'success');?>-message'>
                                        <?php
                                            echo $_SESSION['form_message']['message'];
                                            unset($_SESSION['form_message']);
                                        ?>
                                    </div>
                                        
                                <?php } ?>
                            </form>
                            
                            <h2><a href="https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox?compose=new">Αποστολή με χρήση e-mail διεύθυνσης</a></h2>
                            <br><br><br><a href="/">Επιστροφή στην αρχική</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

		<div class="text-box">
				<h1>Επικοινωνία</h1>
		</div>

		<?php require_once '_footer.php'; ?>
	</body>
</html>

<?php
/*
CREATE TABLE `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
*/