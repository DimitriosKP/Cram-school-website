<?php

class User {

    protected $id;
    protected $username;
    protected $email;
    protected $password;
    protected $cpassword;
    protected $role;
    protected $pdo;

    // Create the object
    public function __construct($username, $email, $password, $cpassword, $role) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->cpassword = $cpassword;
        $this->role = $role;
        $this->connect();
    }

    // Connect to the database
    public function connect() {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $this->pdo = new PDO($dsn, DB_USER, DB_PASS);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    // Check if all fields are filled
    public function checkFields($email, $username, $password, $cpassword) {
        return (empty($email) || empty($username) || empty($password) || empty($cpassword));
    }

    // Check if passwords are the same
    public function checkPassword($password, $cpassword) {
        return ($password == $cpassword);
    }

    // Check if username already exists in database
    public function checkUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `username` = ?");
        $stmt->execute([$username]);
        return ($stmt->rowCount() > 0);
    }

    // Check if email already exists in database
    public function checkEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `email` = ?");
        $stmt->execute([$email]);
        return ($stmt->rowCount() > 0);
    }

    // Save new user to database
    public function save() {
        $hash_password = password_hash($this->password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO `users` (`username`, `email`, `password`, `role`) VALUES (?, ?, ?, ?);";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->username, $this->email, $hash_password, $this->role]);

        if ($stmt->rowCount() > 0) {
            echo "<script>";
            echo "alert('Registration successful');";
            echo "window.location='login.php';";
            echo "</script>";
        }
    }
}