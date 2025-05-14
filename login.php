<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
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

    <h2>Login</h2>

    <?php 
   
    if (isset($_GET['error'])) {
        echo "<p style='color:red'>" . htmlspecialchars($_GET['error']) . "</p>";
    }
    ?>

    <form method="POST" action="pharmacyServer.php?action=login">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a>.</p>

    <footer>
        &copy; 2025 Pharmacy Portal. All Rights Reserved.
    </footer>
</body>
</html>


