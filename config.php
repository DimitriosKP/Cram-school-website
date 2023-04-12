<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    defined('DB_HOST') || define('DB_HOST', 'localhost');
    defined('DB_USER') || define('DB_USER', 'root');
    defined('DB_PASS') || define('DB_PASS', '');
    defined('DB_NAME') || define('DB_NAME', 'dimipeft_');

    function dd($var) {
        echo '<pre>';
        print_r($var);
        die();
    }

    $dsn = 'mysql:name=' . DB_HOST . ';dbname=' . DB_NAME;
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    session_start();