<?php
class PharmacyDatabase {
    private $host = "localhost";
    private $port = "3306";
    private $database = "pharma_portal_db";
    private $user = "root";
    private $password = "";
    private $connection;

    public function __construct() {
        $this->connect();
    }

    // Database connection
    private function connect() {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database, $this->port);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    // Add or update user
    public function addOrUpdateUser($userId, $userName, $contactInfo, $userType) {
        if ($userId) {
            // Update existing user
            $stmt = $this->connection->prepare(
                "UPDATE users SET userName = ?, contactInfo = ?, userType = ? WHERE userId = ?"
            );
            $stmt->bind_param("sssi", $userName, $contactInfo, $userType, $userId);
            $stmt->execute();
            $stmt->close();
            echo "User updated successfully";
        } else {
            // Add new user
            $stmt = $this->connection->prepare(
                "INSERT INTO users (userName, contactInfo, userType) VALUES (?, ?, ?)"
            );
            $stmt->bind_param("sss", $userName, $contactInfo, $userType);
            $stmt->execute();
            $stmt->close();
            echo "User added successfully";
        }
    }

    // Add prescription
    public function addPrescription($patientUserName, $medicationId, $dosageInstructions, $quantity) {
        $stmt = $this->connection->prepare("SELECT userId FROM Users WHERE userName = ? AND userType = 'patient'");
        $stmt->bind_param("s", $patientUserName);
        $stmt->execute();
        $stmt->bind_result($patientId);
        $stmt->fetch();
        $stmt->close();

        if ($patientId) {
            $stmt = $this->connection->prepare(
                "INSERT INTO prescriptions (userId, medicationId, dosageInstructions, quantity) VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param("iisi", $patientId, $medicationId, $dosageInstructions, $quantity);
            $stmt->execute();
            $stmt->close();
            echo "Prescription added successfully";
        } else {
            echo "Failed to add prescription: Patient not found";
        }
    }

    // Process sale
    public function processSale($prescriptionId, $quantitySold) {
        $stmt = $this->connection->prepare("CALL ProcessSale(?, ?)");
        $stmt->bind_param("ii", $prescriptionId, $quantitySold);
        if ($stmt->execute()) {
            echo "Sale processed successfully.";
        } else {
            echo "Failed to process sale: " . $stmt->error;
        }
        $stmt->close();
    }

    // Get all prescriptions

    public function getAllPrescriptions() {
        $result = $this->connection->query("
            SELECT p.prescriptionId, u.userId, u.userName, m.medicationId, m.medicationName, p.dosageInstructions, p.quantity, p.prescribedDate 
            FROM prescriptions p
            JOIN users u ON p.userId = u.userId
            JOIN medications m ON p.medicationId = m.medicationId
        ");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    

    // Get medication inventory view
    public function getMedicationInventory() {
        $result = $this->connection->query("
            SELECT * FROM MedicationInventoryView
        ");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addMedication($medicationName, $dosage, $manufacturer) {
        $stmt = $this->connection->prepare("INSERT INTO medications (medicationName, dosage, manufacturer) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $medicationName, $dosage, $manufacturer);
        $stmt->execute();
        $stmt->close();
        echo "Medication added successfully";
    }

    // Close the connection
    public function close() {
        $this->connection->close();
    }
}
?>
