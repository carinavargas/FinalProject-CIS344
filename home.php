<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'PharmacyDatabase.php';

if (!isset($_SESSION['userId'])) {
    header("Location: pharmacyServer.php?action=login");
    exit();
}

$username = $_SESSION['username'];
$userType = $_SESSION['userType'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pharmacy Portal Express</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <img src="logo.jpg" alt="Pharmacy Logo">
    <h1>Pharmacy Portal</h1>
    <a href="pharmacyServer.php?action=logout" class="cross-icon">&times;</a>
</header>

<main>
    <h2>Welcome, <?php echo htmlspecialchars($username); ?> (<?php echo ucfirst($userType); ?>)</h2>

    <nav class="dashboard-nav">
        <?php if ($userType === 'pharmacist'): ?>
            <a href="pharmacyServer.php?action=addPrescription" class="nav-link">Add Prescription</a>
            <a href="pharmacyServer.php?action=viewAllPrescriptions" class="nav-link">View All Prescriptions</a>
            <a href="pharmacyServer.php?action=addOrUpdateUser" class="nav-link">Add or Update User</a>
            <a href="pharmacyServer.php?action=viewInventory" class="nav-link">View Inventory</a>
            <a href="pharmacyServer.php?action=addMedication" class="nav-link">Add Medication</a>
           
        <?php elseif ($userType === 'patient'): ?>
            <a href="pharmacyServer.php?action=viewPatientPrescriptions" class="nav-link">View My Prescriptions</a>
        <?php endif; ?>

        <a href="pharmacyServer.php?action=logout" class="nav-link logout">Logout</a>
    </nav>
</main>

<footer>
    &copy; 2025 Pharmacy Portal. All Rights Reserved.
</footer>

</body>
</html>
