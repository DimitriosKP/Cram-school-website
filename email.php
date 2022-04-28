<?php

    session_start();
    require_once "config.php";

        
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

    $emailsql = "SELECT * FROM users WHERE role = 't'";
    $email_query = mysqli_query($database, $emailsql);
    while($emailrow = mysqli_fetch_array ($email_query)){
    $Usernamesend = $emailrow['username'];

    $sendsql = "SELECT * FROM users WHERE username = '$Usernamesend'";
    $send_query = mysqli_query($database, $sendsql);
    $mail_body = '';
    $sendrow = '';
    $sendrow = mysqli_fetch_array($send_query);
        $email = $sendrow["email"];
        $name = $sendrow["username"];

        $to = "$email";                          
            $from = "$_SESSION[email]";
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            $headers = "From: $from\n";

            $mail_result = mail($to, $subject, $message, $headers);
    }       
            if ($mail_result) {
            echo "Submitted Successfully! Press close";
        } else {
        echo "There was an error submitting... Press close";
        }
?>