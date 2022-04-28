<section class="header">
    <nav>
        <section class="heading1">HomeWork</section>
        <div class="nav-links" id="navLinks">
            <i class="fa fa-times" onclick="hideMenu()"></i>
            <ul>
                <li>
                    <a href="index.php" <?=(($currentPage??'') == 'index' ? 'style="font-weight:bold"' : '');?>>Αρχική Σελίδα</a>
                </li>

                <li>
                    <a href="announcements.php" <?=(($currentPage??'') == 'announcements' ? 'style="font-weight:bold"' : '');?>>Ανακοινώσεις</a>
                </li>

                <li>
                    <a href="communication.php" <?=(($currentPage??'') == 'communication' ? 'style="font-weight:bold"' : '');?>>Επικοινωνία</a>
                </li>

                <li>
                    <a href="documents.php" <?=(($currentPage??'') == 'documents' ? 'style="font-weight:bold"' : '');?>>Έγγραφα μαθήματος</a>
                </li>

                <li>
                    <a href="homework.php" <?=(($currentPage??'') == 'homework' ? 'style="font-weight:bold"' : '');?>>Εργασίες</a>
                </li>

                <?php if($_SESSION["role"] == 't'):?>
                    <li style="text-align: center;">
                        <a href="students.php" <?=(($currentPage??'') == 'students' ? 'style="font-weight:bold"' : '');?>>Φοιτητές</a>
                    </li>  
                <?php endif ?>  

                <li>
                    <?php echo "<h3>Καλώς ήρθες " . $_SESSION['username'] . "</h3>"; ?>
                    <?php if ($_SESSION['role'] == 's')?> <?php echo "<h3>Φοιτητής</h3>"?>
                    
                    <a href="logout.php">Αποσύνδεση</a>
                </li>
            </ul>
        </div>
        <i class="fa fa-bars" onclick="showMenu()"></i>
    </nav>
</section>