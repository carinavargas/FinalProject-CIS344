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



<?php
require_once 'PharmacyDatabase.php';
require_once 'PharmacyServer.php';

// instance of pharmacy database
$db = new PharmacyDatabase();

// Retrieve prescriptions (if needed)
$prescriptions = $db->getAllPrescriptions();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pharmacy Portal Express</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Welcome to Pharmacy Portal Express</h1>
    <nav>
        <a href="?action=addPrescription" class="nav-link">Add Prescription</a>
        <a href="?action=viewPrescriptions" class="nav-link">View Prescriptions</a>
        <a href="?action=addOrUpdateUser" class="nav-link">Add or Update User</a>
        <a href="?action=viewUserDetails" class="nav-link">View User Details</a>
        <a href="?action=viewInventory" class="nav-link">View Inventory</a>
        <a href="?action=addMedication" class="nav-link">Add Medication</a>


        <br><br><br><br>
        <a href="logout.php">Logout</a>
    </nav>
</body>
</html>


<footer>
        &copy; 2025 Pharmacy Portal. All Rights Reserved.
    </footer>
</body>
</html>
