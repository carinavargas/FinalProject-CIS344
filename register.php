<?php session_start(); ?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Portal Express</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="logo.jpg" alt="Pharmacy Logo">
        <h1>Pharmacy Portal</h1>
        <a href="logout.php" class="cross-icon">&times;</a>
    </header>

    <h2>Register</h2>

    <?php 
    
    if (isset($_GET['error'])) {
        echo "<p style='color:red'>" . htmlspecialchars($_GET['error']) . "</p>";
    } elseif (isset($_GET['message'])) {
        echo "<p style='color:green'>" . htmlspecialchars($_GET['message']) . "</p>";
    }
    ?>

    <form method="POST" action="pharmacyServer.php?action=register">
        <input type="text" name="username" placeholder="Username" required><br><br>

        <input type="text" name="contactInfo" placeholder="Contact Info" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Register</button>
    </form>

    <br>
    <a href="pharmacyServer.php?action=home">Back to Home</a>

    <footer>
        &copy; 2025 Pharmacy Portal. All Rights Reserved.
    </footer>
</body>
</html>
