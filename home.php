<html>
<head>
    <title>Pharmacy Portal Carina</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Welcome to Pharmacy Portal Carina</h1>
    <nav>
        <a href="addPrescription.php" class="nav-link">Add Prescription</a>
        <a href="viewPrescriptions.php" class="nav-link">View Prescriptions</a>
        <a href="addMedication.php" class="nav-link">Add Medication</a>
        <a href="viewInventory.php" class="nav-link">View Inventory</a>
        <br><br><br><br>
        <a href="logout.php">Logout</a>
    </nav>
</body>
</html>

<?php
require_once 'PharmacyDatabase.php';
require_once 'PharmacyServer.php';
require_once 'PharmacyClient.php';
?php
require_once 'PharmacyDatabase.php';


$db = new PharmacyDatabase();


$prescriptions = $db->getAllPrescriptions();
?>