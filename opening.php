<?php 
    require_once "config.php"; 
	$pageTitle = 'HomeWork - Welcome!';
    require_once "_header.php"; 
?>
    <body>
        <section class="header">
            <nav>
                <section class="heading1">HomeWork</section>
                <div class="nav-links" id="navLinks">
                <i class="fa fa-times" onclick="hideMenu()"></i>
            </nav>
        </section>
		
        <div class="text-box">
            <h1>Welcome!</h1>
            <p></p>
            <a class="hero-btn" href="login.php">Let's start!</a>
        </div>
    <?php require_once '_footer.php'; ?>
    </body>
</html>