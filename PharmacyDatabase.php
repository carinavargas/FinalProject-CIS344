<?php     
class PharmacyDatabase {
    private $pdo;

    public function __construct() {
        $host = 'localhost';
        $dbname = 'pharma_portal_db';
        $username = 'root';
        $password = '';

        try {
            // Initialize PDO 
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
         
            die("Database Connection Failed: " . $e->getMessage());
        }
    }

    public function verifyUserCredentials($username, $password) {
        $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':password' => $password
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function userExists($username) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0;
    }

    public function registerPatient($username, $email, $contactInfo, $password) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO users (username, email, contactInfo, password, userType) VALUES (?, ?, ?, ?, 'patient')");
            return $stmt->execute([$username, $email, $contactInfo, $password]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function addUser($username, $contactInfo, $userType) {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, contactInfo, userType) VALUES (?, ?, ?)");
        $stmt->execute([$username, $contactInfo, $userType]);
    }

    public function addOrUpdateUser($userId, $username, $contactInfo, $userType) {
        if ($userId) {
            $stmt = $this->pdo->prepare("UPDATE users SET username = ?, contactInfo = ?, userType = ? WHERE userId = ?");
            $stmt->execute([$username, $contactInfo, $userType, $userId]);
        } else {
            $this->addUser($username, $contactInfo, $userType);
        }
    }

    public function addMedication($medicationName, $dosage, $manufacturer, $quantityAvailable) {
        $sql = "INSERT INTO medications (medicationName, dosage, manufacturer, quantityAvailable)
                VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    quantityAvailable = VALUES(quantityAvailable)";
                    
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$medicationName, $dosage, $manufacturer, $quantityAvailable]);
    }
    
    
    
    
    

    public function getMedicationInventory() {
        $stmt = $this->pdo->query("SELECT medicationName, dosage, manufacturer, quantityAvailable FROM medications");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addPrescription($patientUsername, $medicationId, $dosageInstructions, $quantity) {
        // Get patient userId from username
        $stmt = $this->pdo->prepare("SELECT userId FROM users WHERE username = ?");
        $stmt->execute([$patientUsername]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) return false;

        $stmt = $this->pdo->prepare("INSERT INTO prescriptions (userId, medicationId, dosageInstructions, quantity) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user['userId'], $medicationId, $dosageInstructions, $quantity]);
        return true;
    }

    public function getAllPrescriptions() {
        $sql = "SELECT prescriptions.*, medications.medicationName, users.username 
                FROM prescriptions 
                JOIN medications ON prescriptions.medicationId = medications.medicationId
                JOIN users ON prescriptions.userId = users.userId";  // Changed 'patientId' to 'userId'
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getPrescriptionsByUser($userId) {
        $stmt = $this->pdo->prepare("
            SELECT p.prescriptionId, m.medicationName, p.dosageInstructions, p.quantity, p.prescribedDate
            FROM prescriptions p
            JOIN medications m ON p.medicationId = m.medicationId
            WHERE p.userId = :userId
            ORDER BY p.prescribedDate DESC
        ");
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }





}    
