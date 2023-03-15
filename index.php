<?php 
    // Initialize the session
    session_start();
    
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
    {
        header("location: login.php");
        exit;
    }

    $pageTitle = 'HomeWork';
    require_once '_header.php';
?>

    <body>
        <?php
            $currentPage='index';
            require_once '_menu.php';
        ?>
		
        <div class="text-box">
            <h1>Welcome!</h1>
            <p> The cram-school is an online application that anyone can log in either as a student or as a teacher. 
                If the user chooses to be a professor he will be able to add and delete announcements, work and have 
                access to the student category.
            </p>
        </div>
        

        <?php require_once '_footer.php'; ?>
    </body>
</html>