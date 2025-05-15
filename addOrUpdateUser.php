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
        <h1>Pharmacy Portal Express</h1>
        
    
        <a href="logout.php" class="cross-icon">&times;</a>
    </header>

<!DOCTYPE html>
<html>
<head>
    <h2>Add or Update User</h2>
</head>
<body>
    <h1><?= isset($_GET['id']) ? "Update User" : "Add User" ?></h1>
    <form method="POST" action="?action=addOrUpdateUser">
        <input type="hidden" name="user_id" value="<?= $_GET['id'] ?? '' ?>">

        <label>User Name:</label>
        <input type="text" name="username" required><br><br>

        <label>Contact Info:</label>
        <input type="text" name="contactInfo" required><br><br>

        <label>User Type:</label>
        <select name="user_type" required>
            <option value="patient">Patient</option>
            <option value="pharmacist">Pharmacist</option>
        </select><br><br>

        <button type="submit"><?= isset($_GET['id']) ? "Update User" : "Add User" ?></button>
    </form>
    <br>
    <a href="?action=home">Back to Home</a>
</body>
</html>



<footer>
        &copy; 2025 Pharmacy Portal. All Rights Reserved.
    </footer>
</body>
</html>
