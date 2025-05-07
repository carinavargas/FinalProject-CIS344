

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

<html>
<head>
    <title>Add Medication</title>
</head>
<body>
<div class="wrapper">
    <h2>Add New Medication</h2>
    
    <form method="POST" action="?action=addMedication">
        <label>Medication Name:</label><br>
        <input type="text" name="medication_name" required><br><br>

        <label>Dosage:</label><br>
        <input type="text" name="dosage" required><br><br>

        <label>Manufacturer:</label><br>
        <input type="text" name="manufacturer" required><br><br>

        <input type="submit" value="Add Medication">
    </form>
    <br>
    <a href="PharmacyServer.php">Back to Home</a>
</div>
</body>
</html>


<footer>
        &copy; 2025 Pharmacy Portal. All Rights Reserved.
    </footer>

</body>

</html>
