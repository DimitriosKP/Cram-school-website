<?php

class Announcements {

    protected $pdo;
    protected $title;
    protected $author;
    protected $text;

    public function __construct($title, $author, $text) {
        $this->title = $title;
        $this->author = $author;
        $this->text = $text;
        $this->connect();
    }

    // Connect to the database
    public function connect() {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }

    public function showAnnouncements() {
        $sql = "SELECT AN.*, US.username
        FROM announcements AN LEFT JOIN users US ON AN.creator_id=US.id
        ORDER BY AN.ann_uploaded_on";

        $stmt = $this->pdo->query($sql);
        $rowCount = $stmt->rowCount();
        if($rowCount > 0) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="announcements-col">
                    <img src="images/ann.png" alt="Document">
                    <div>
                        <h1><?php echo  $row['ann_title'] ?></h1><br>
                        <h4><?php echo 'Author: ', $row['username']?></h4>
                        <h4><?php echo 'The announcement was posted on: ', $row['ann_uploaded_on'] ?></h4>
                        <h4><?php echo 'Announcement ID: ', $row['ann_id'] ?></h4>	
                        <h3><?php echo  $row['ann_text']?></h3>
                    
                        <?php if($_SESSION["role"] == 't' && $_SESSION['id'] == $row['creator_id']):   ?>
                            <button name="update" onclick="location.href='announcements_update.php?id=<?=$row['ann_id'];?>'">
                                <i class="fa fa-pencil" aria-hidden="true"></i>Update</button>
                            <button name="delete" onclick="location.href='announcements_delete.php?id=<?=$row['ann_id'];?>'" >
                                <i class="fa fa-trash" aria-hidden="true"></i>Delete</button>
                        <?php endif ?>  
                    </div>
                </div>
            <?php
            }
        } else {
            echo "No records matching your query were found.";
        }
    }
}