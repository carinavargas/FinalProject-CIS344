<?php
require_once 'PharmacyDatabase.php';

class PharmacyPortal {
    private $db;

    public function __construct() {
        $this->db = new PharmacyDatabase();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'home';

        switch ($action) {
            case 'login':
                $this->login();
                break;
            case 'register':
                $this->registerPatient();
                break;
            case 'addPrescription':
                $this->addPrescription();
                break;
            case 'viewPatientPrescriptions':
                $this->viewPatientPrescriptions();
                break;
            case 'viewAllPrescriptions':
                $this->viewAllPrescriptions();
                break;
            case 'addMedication':
                $this->addMedication();
                break;
            case 'viewInventory':
                $this->viewInventory();
                break;
            case 'addUser':
                $this->addUser();
                break;
            case 'addOrUpdateUser':
                $this->addOrUpdateUser();
                break;
            case 'logout':
                $this->logout();
                break;

            default:
                $this->home();
        }
    }

    private function home() {
        // Home page view 
        include 'home.php';
    }

    private function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Verify user credentials
            $user = $this->db->verifyUserCredentials($username, $password);
            if ($user) {
                $_SESSION['userId'] = $user['userId'];
                $_SESSION['username'] = $username;
                $_SESSION['userType'] = $user['userType'];
                $_SESSION['message'] = 'Login successful!';
                header("Location: pharmacyServer.php?action=home");
                exit();
            } else {
                $_SESSION['error'] = 'Invalid username or password.';
                header("Location: pharmacyServer.php?action=login");
            }
        } else {
            include 'login.php';
        }
    }

    private function registerPatient() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $contactInfo = $_POST['contact_info'];
            $password = $_POST['password'];

            if ($this->db->userExists($username)) {
                $_SESSION['error'] = 'Username already exists.';
                header("Location: pharmacyServer.php?action=register");
                return;
            }

            $success = $this->db->registerPatient($username, $email, $contactInfo, $password);
            if ($success) {
                $_SESSION['message'] = 'Registration successful! Please log in.';
                header("Location: pharmacyServer.php?action=login");
            } else {
                $_SESSION['error'] = 'Failed to register user.';
                header("Location: pharmacyServer.php?action=register");
            }
        } else {
            include 'register.php';
        }
    }

    private function addPrescription() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $patientUserName = $_POST['patient_username'];
            $medicationId = $_POST['medication_id'];
            $dosageInstructions = $_POST['dosage_instructions'];
            $quantity = $_POST['quantity'];

            $this->db->addPrescription($patientUserName, $medicationId, $dosageInstructions, $quantity);
            $_SESSION['message'] = 'Prescription added successfully.';
            header("Location: pharmacyServer.php?action=viewAllPrescriptions");
        } else {
            include 'addPrescription.php';
        }
    }

    private function viewPatientPrescriptions() {
        if ($_SESSION['userType'] !== 'patient') {
            $_SESSION['error'] = 'Access denied.';
            header("Location: pharmacyServer.php?action=home");
            return;
        }

        $prescriptions = $this->db->getPrescriptionsByUser($_SESSION['userId']);
        include 'viewPatientPrescriptions.php';
    }

    private function viewAllPrescriptions() {
        if (!in_array($_SESSION['userType'], ['admin', 'pharmacist'])) {
            $_SESSION['error'] = 'Access denied.';
            header("Location: pharmacyServer.php?action=home");
            return;
        }

        $prescriptions = $this->db->getAllPrescriptions();
        include 'viewAllPrescriptions.php';
    }

    private function viewInventory() {
        if ($_SESSION['userType'] !== 'pharmacist') {
            $_SESSION['error'] = 'Access denied.';
            header("Location: pharmacyServer.php?action=home");
            return;
        }

        $inventory = $this->db->getMedicationInventory();
        include 'viewInventory.php';
    }
    public function addMedication() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['medicationName'], $_POST['dosage'], $_POST['manufacturer'], $_POST['quantityAvailable'])) {
                $medicationName = trim($_POST['medicationName']);
                $dosage = trim($_POST['dosage']);
                $manufacturer = trim($_POST['manufacturer']);
                $quantityAvailable = (int)$_POST['quantityAvailable'];
    
                if ($medicationName === '' || $dosage === '' || $quantityAvailable < 0) {
                    $_SESSION['error'] = "Please fill in all required fields with valid data.";
                } else {
                    $result = $this->db->addMedication($medicationName, $dosage, $manufacturer, $quantityAvailable);
    
                    if ($result) {
                        $_SESSION['message'] = "Medication added/updated successfully!";
                        header("Location: pharmacyServer.php?action=viewInventory");
                        exit();
                    } else {
                        $_SESSION['error'] = "Error adding medication.";
                    }
                }
            } else {
                $_SESSION['error'] = "Please fill in all required fields.";
            }
           
            header("Location: pharmacyServer.php?action=addMedication");
            exit();
        } else {
            include 'addMedication.php';  
        }
    }
    
    


    private function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userName = $_POST['username'];
            $contactInfo = $_POST['contact_info'];
            $userType = $_POST['user_type'];

            $this->db->addUser($userName, $contactInfo, $userType);
            $_SESSION['message'] = 'User added successfully.';
            header("Location: pharmacyServer.php?action=home");
        } else {
            include 'addUser.php';
        }
    }

    private function addOrUpdateUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? null;
            $userName = $_POST['username'];
            $contactInfo = $_POST['contact_info'];
            $userType = $_POST['user_type'];

            $this->db->addOrUpdateUser($userId, $userName, $contactInfo, $userType);
            $_SESSION['message'] = 'User saved successfully.';
            header("Location: pharmacyServer.php?action=home");
        } else {
            include 'addOrUpdateUser.php';
        }
    }

    private function logout() {
        session_destroy();
        header("Location: pharmacyServer.php?action=home");
    }
}


$portal = new PharmacyPortal();
$portal->handleRequest();
?>

