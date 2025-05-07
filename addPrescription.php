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


<html>
<head><title>Add Prescription</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Add Prescription</h2>
    <form method="POST" action="?action=addPrescription">
        Patient Username: <input type="text" name="patient_username" /><br>
        Medication ID : <input type="number" name="medication_id"/><br>
        Dossage Instructions: <textarea name="dosage_instructions"></textarea><br>
        Quantity: <input type="number" name="quantity" /><br>
        <button type="submit">Save</button>
    </form>
    <a href="PharmacyServer.php">Back to Home</a>
</body>
</html>




<footer>
        &copy; 2025 Pharmacy Portal. All Rights Reserved.
    </footer>
</body>
</html>
