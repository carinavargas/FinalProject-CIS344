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
            case 'addPrescription':
                $this->addPrescription();
                break;
            case 'addMedication':
                    $this->addMedication();
                    break;
            case 'viewPrescriptions':
                $this->viewPrescriptions();
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
            default:
                $this->home();
        }
    }

    private function home() {
        include 'home.php';
    }

    private function addPrescription() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $patientUserName = $_POST['patient_username'];
            $medicationId = $_POST['medication_id'];
            $dosageInstructions = $_POST['dosage_instructions'];
            $quantity = $_POST['quantity'];

            $this->db->addPrescription($patientUserName, $medicationId, $dosageInstructions, $quantity);
            header("Location: ?action=viewPrescriptions&message=Prescription Added");
        } else {
            include 'addPrescription.php';
        }
    }

    private function viewPrescriptions() {
        $prescriptions = $this->db->getAllPrescriptions();
        include 'viewPrescriptions.php';
    }

    private function viewInventory() {
        $inventory = $this->db->getMedicationInventory();
        include 'viewInventory.php';
    }

    private function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userName = $_POST['username'];
            $contactInfo = $_POST['contact_info'];
            $userType = $_POST['user_type'];

            $this->db->addUser($userName, $contactInfo, $userType);
            header("Location: ?action=home&message=User Added");
        } else {
            include 'addUser.php';
        }
    }

    private function addMedication() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $medicationName = $_POST['medication_name'];
            $dosage = $_POST['dosage'];
            $manufacturer = $_POST['manufacturer'];
    
            $this->db->addMedication($medicationName, $dosage, $manufacturer);
            header("Location:?action=viewInventory&message=Medication Added");
        } else {
            include 'addMedication.php';
        }
    }
    private function addOrUpdateUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? null;
            $userName = $_POST['username'];
            $contactInfo = $_POST['contact_info'];
            $userType = $_POST['user_type'];
    
            // Nullify empty userId to handle insert case
            $userId = empty($userId) ? null : (int)$userId;
    
            $this->db->addOrUpdateUser($userId, $userName, $contactInfo, $userType);
            header("Location: ?action=home&message=User Saved");
        } else {
            include 'addOrUpdateUser.php';
        }
    }
    


}

$portal = new PharmacyPortal();
$portal->handleRequest();
?>
