<?php
require_once 'PharmacyDatabase.php';


if (!isset($_SESSION['userId']) || $_SESSION['userType'] !== 'pharmacist') {
    header('Location: login.php');
    exit;
}

$db = new PharmacyDatabase();
$prescriptions = $db->getAllPrescriptions();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Prescriptions</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="logo.jpg" alt="Pharmacy Logo">
        <h1>Pharmacy Portal Express</h1>
        <a href="logout.php" class="cross-icon">&times;</a>
    </header>

    <h2>All Prescriptions</h2>
    <table>
        <thead>
            <tr>
                <th>Patient</th>
                <th>Medication</th>
                <th>Dosage Instructions</th>
                <th>Quantity</th>
                <th>Prescribed Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($prescriptions)): ?>
                <tr><td colspan="5">No prescriptions found.</td></tr>
            <?php else: ?>
                <?php foreach ($prescriptions as $prescription): ?>
                    <tr>
                        <td><?= htmlspecialchars($prescription['username']) ?></td>
                        <td><?= htmlspecialchars($prescription['medicationName']) ?></td>
                        <td><?= htmlspecialchars($prescription['dosageInstructions']) ?></td>
                        <td><?= htmlspecialchars($prescription['quantity']) ?></td>
                        <td><?= htmlspecialchars($prescription['prescribedDate']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="PharmacyServer.php">Back to Home</a>
</body>
</html>
