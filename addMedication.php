<?php
require_once 'PharmacyDatabase.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $medicationName = trim($_POST['medicationName'] ?? '');
    $dosage = trim($_POST['dosage'] ?? '');
    $manufacturer = trim($_POST['manufacturer'] ?? '');
    $quantityAvailable = $_POST['quantityAvailable'] ?? '';

    
    if ($medicationName === '' || $dosage === '' || $manufacturer === '' || $quantityAvailable === '') {
        $message = "Please fill in all required fields.";
    } elseif (!filter_var($quantityAvailable, FILTER_VALIDATE_INT, ["options" => ["min_range" => 0]])) {
        $message = "Quantity Available must be a non-negative integer.";
    } else {
        
        $medicationName = htmlspecialchars($medicationName);
        $dosage = htmlspecialchars($dosage);
        $manufacturer = htmlspecialchars($manufacturer);
        $quantityAvailable = (int)$quantityAvailable;

        $db = new PharmacyDatabase();
        if ($db->addMedication($medicationName, $dosage, $manufacturer, $quantityAvailable)) {
            $message = "Medication added successfully!";
        } else {
            $message = "Error adding medication.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Medication</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <header>
        <img src="logo.jpg" alt="Pharmacy Logo" />
        <h1>Pharmacy Portal Express</h1>
        <a href="logout.php" class="cross-icon">&times;</a>
    </header>

    <div class="wrapper">
        <h2>Add New Medication</h2>

        <?php if ($message): ?>
            <p style="color:<?= strpos($message, 'successfully') !== false ? 'green' : 'red' ?>;">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <form action="addMedication.php" method="POST">
            <label for="medicationName">Medication Name:</label>
            <input type="text" id="medicationName" name="medicationName" required value="<?= htmlspecialchars($_POST['medicationName'] ?? '') ?>" />

            <label for="dosage">Dosage:</label>
            <input type="text" id="dosage" name="dosage" required value="<?= htmlspecialchars($_POST['dosage'] ?? '') ?>" />

            <label for="manufacturer">Manufacturer:</label>
            <input type="text" id="manufacturer" name="manufacturer" required value="<?= htmlspecialchars($_POST['manufacturer'] ?? '') ?>" />

            <label for="quantityAvailable">Quantity Available:</label>
            <input type="number" id="quantityAvailable" name="quantityAvailable" required min="0" value="<?= htmlspecialchars($_POST['quantityAvailable'] ?? '') ?>" />

            <button type="submit">Add Medication</button>
        </form>
        <br />
        <a href="PharmacyServer.php">Back to Home</a>
    </div>

    <footer>
        &copy; 2025 Pharmacy Portal. All Rights Reserved.
    </footer>
</body>
</html>
