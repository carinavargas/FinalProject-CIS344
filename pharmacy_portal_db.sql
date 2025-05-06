
DELIMITER //

CREATE PROCEDURE ProcessSale (
    IN pharm_prescriptionId INT,
    IN pharm_quantitySold INT
)
BEGIN
    DECLARE pharm_medId INT;
    DECLARE pharm_price DECIMAL(10,2);
    SET pharm_price = 10.00;

   
    SELECT medicationId INTO pharm_medId
    FROM Prescriptions
    WHERE prescriptionId = pharm_prescriptionId;

    
    UPDATE Inventory
    SET quantityAvailable = quantityAvailable - pharm_quantitySold,
        lastUpdated = NOW()
    WHERE medicationId = pharm_medId;

    
    INSERT INTO Sales (prescriptionId, saleDate, quantitySold, saleAmount)
    VALUES (pharm_prescriptionId, NOW(), pharm_quantitySold, pharm_quantitySold * pharm_price);
END //

DELIMITER ;

CREATE VIEW MedicationInventoryView AS
SELECT 
  medications.medicationName,
  medications.dosage,
  medications.manufacturer,
  inventory.quantityAvailable
FROM 
  medications
JOIN 
  inventory ON medications.medicationId = inventory.medicationId;


DELIMITER //

CREATE TRIGGER AfterPrescriptionInsert
AFTER INSERT ON prescriptions
FOR EACH ROW
BEGIN
  UPDATE inventory
  SET quantityAvailable = quantityAvailable - NEW.quantity,
      lastUpdated = NOW()
  WHERE medicationId = NEW.medicationId;
END //

DELIMITER ;


INSERT INTO users (userName, contactInfo, userType) VALUES
('alex', 'alex@email.com', 'patient'),
('rosa', 'rosa@email.com', 'pharmacist'),
('carol', 'carol@email.com', 'patient');


INSERT INTO medications (medicationName, dosage, manufacturer) VALUES
('Aspirin', '100mg', 'PharmaComp'),
('Allergy Medicine', '10ml', 'MedicalLabs'),
('Antibiotic', '250mg', 'HealthFirst');


INSERT INTO inventory (medicationId, quantityAvailable, lastUpdated) VALUES
(1, 50, NOW()),
(2, 30, NOW()),
(3, 20, NOW());


INSERT INTO prescriptions (userId, medicationId, prescribedDate, quantity) VALUES
(1, 1, NOW(), 5),
(3, 2, NOW(), 3),
(1, 3, NOW(), 2);


INSERT INTO sales (prescriptionId, saleDate, quantitySold, saleAmount) VALUES
(1, NOW(), 5, 25.00),
(2, NOW(), 3, 15.00),
(3, NOW(), 2, 10.00);



