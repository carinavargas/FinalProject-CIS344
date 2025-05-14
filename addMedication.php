<?php
require_once 'PharmacyDatabase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $medicationName = htmlspecialchars($_POST['medicationName']);
    $dosage = htmlspecialchars($_POST['dosage']);
    $manufacturer = htmlspecialchars($_POST['manufacturer']);
    
   
    $quantityAvailable = filter_var($_POST['quantityAvailable'], FILTER_VALIDATE_INT);
    
    if ($quantityAvailable === false || $quantityAvailable < 0) {
        echo "Invalid quantity available.";
        exit;
    }

    
    $db = new PharmacyDatabase();

    if ($db->addMedication($medicationName, $dosage, $manufacturer, $quantityAvailable)) {
        echo "Medication added successfully!";
    } else {
        echo "Error adding medication.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medication</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="logo.jpg" alt="Pharmacy Logo">
        <h1>Pharmacy Portal Express</h1>
        <a href="logout.php" class="cross-icon">&times;</a>
    </header>

    <div class="wrapper">
        <h2>Add New Medication</h2>

        <form action="addMedication.php" method="POST">
            <label for="medicationName">Medication Name:</label>
            <input type="text" name="medicationName" required>

            <label for="dosage">Dosage:</label>
            <input type="text" name="dosage" required>

            <label for="manufacturer">Manufacturer:</label>
            <input type="text" name="manufacturer" required>

            <label for="quantityAvailable">Quantity Available:</label>
            <input type="number" name="quantityAvailable" required>

            <button type="submit">Add Medication</button>
        </form>
        <br>
        <a href="PharmacyServer.php">Back to Home</a>
    </div>

    <footer>
        &copy; 2025 Pharmacy Portal. All Rights Reserved.
    </footer>
</body>
</html>


