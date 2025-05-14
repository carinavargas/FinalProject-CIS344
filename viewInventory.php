<?php
require_once 'PharmacyDatabase.php';

$db = new PharmacyDatabase();
$inventory = $db->getMedicationInventory();
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
        <h1>Pharmacy Portal Express</h1>
        <a href="logout.php" class="cross-icon">&times;</a>
    </header>

    <h2>Medication Inventory</h2>

    <table>
        <thead>
            <tr>
                <th>Medication Name</th>
                <th>Dosage</th>
                <th>Manufacturer</th>
                <th>Quantity Available</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventory as $med): ?>
            <tr>
                <td><?= htmlspecialchars($med['medicationName']) ?></td>
                <td><?= htmlspecialchars($med['dosage']) ?></td>
                <td><?= htmlspecialchars($med['manufacturer']) ?></td>
                <td><?= htmlspecialchars($med['quantityAvailable']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="PharmacyServer.php">Back to Home</a>

    <footer>
        &copy; 2025 Pharmacy Portal. All Rights Reserved.
    </footer>
</body>
</html>


