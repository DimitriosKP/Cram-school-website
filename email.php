<?php
    require_once "config.php";

    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }

    $emailsql = "SELECT * FROM users WHERE role = 't'";
    $stmt = $pdo->query($emailsql);

    while($emailrow = mysqli_fetch_array ($email_query)) {
        $userNameSend = $emailrow['username'];

        $sendsql = "SELECT * FROM users WHERE username = :username";
        $sendstmt = $pdo->prepare($sendsql);
        $sendstmt->bindParam(':username', $userNameSend);
        $sendstmt->execute();
        $sendrow = $sendstmt->fetch(PDO::FETCH_ASSOC);

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