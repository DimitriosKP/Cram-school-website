<section class="header">
    <nav>
        <section class="heading1">HomeWork</section>
        <div class="nav-links" id="navLinks">
            <i class="fa fa-times" onclick="hideMenu()"></i>
            <ul>
                <li>
                    <a href="index.php" <?=(($currentPage??'') == 'index' ? 'style="font-weight:bold"' : '');?>>Home</a>
                </li>

                <li>
                    <a href="announcements.php" <?=(($currentPage??'') == 'announcements' ? 'style="font-weight:bold"' : '');?>>Announcements</a>
                </li>

                <li>
                    <a href="documents.php" <?=(($currentPage??'') == 'documents' ? 'style="font-weight:bold"' : '');?>>Files</a>
                </li>

                <li>
                    <a href="homework.php" <?=(($currentPage??'') == 'homework' ? 'style="font-weight:bold"' : '');?>>Homeworks</a>
                </li>

                
                <?php if($_SESSION["role"] == 't'):?>
                    <li>
                        <a href="students.php" <?=(($currentPage??'') == 'students' ? 'style="font-weight:bold"' : '');?>>Students</a>
                    </li>  
                <?php endif ?>  

                <li>
                    <a href="communication.php" <?=(($currentPage??'') == 'communication' ? 'style="font-weight:bold"' : '');?>>Contact</a>
                </li>
                
                <li>
                    <?php echo "<h3>Welcome " . $_SESSION['username'] . "</h3>"; ?>
                    <a href="logout.php">Log-out</a>
                </li>
            </ul>
        </div>
        <i class="fa fa-bars" onclick="showMenu()"></i>
    </nav>
</section>