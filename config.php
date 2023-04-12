<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    define("SITE_NAME", "HomeWork");

    $database = mysqli_connect("", "", "", "");
    mysqli_query($database,"SET CHARACTER SET UTF8");

    if (!$database) 
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
