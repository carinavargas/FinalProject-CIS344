-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 02:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharma_portal_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ProcessSale` (IN `pharm_prescriptionId` INT, IN `pharm_quantitySold` INT)   BEGIN
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
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventoryId` int(11) NOT NULL,
  `medicationId` int(11) NOT NULL,
  `quantityAvailable` int(11) NOT NULL,
  `lastUpdated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventoryId`, `medicationId`, `quantityAvailable`, `lastUpdated`) VALUES
(1, 1, 45, '2025-05-14 16:56:55'),
(2, 2, -15, '2025-05-14 20:29:44'),
(3, 3, 10, '2025-05-14 16:19:22');

-- --------------------------------------------------------

--
-- Stand-in structure for view `medicationinventoryview`
-- (See below for the actual view)
--
CREATE TABLE `medicationinventoryview` (
`medicationName` varchar(45)
,`dosage` varchar(45)
,`manufacturer` varchar(100)
,`quantityAvailable` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `medications`
--

CREATE TABLE `medications` (
  `medicationId` int(11) NOT NULL,
  `medicationName` varchar(45) NOT NULL,
  `dosage` varchar(45) NOT NULL,
  `manufacturer` varchar(100) DEFAULT NULL,
  `quantityAvailable` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `medications`
--

INSERT INTO `medications` (`medicationId`, `medicationName`, `dosage`, `manufacturer`, `quantityAvailable`) VALUES
(1, 'Aspirin', '100mg', 'PharmaComp', 20),
(2, 'Allergy Medicine', '10ml', 'MedicalLabs', 10),
(3, 'Antibiotic', '250mg', 'HealthFirst', 50),
(5, 'Vitamin C', '50mg', 'Natures Way', 50),
(6, 'Ibuprohen', '500mg', 'Tylenol', 100),
(7, 'Amoxilian', '500mg', 'Pharmacy Express', 100),
(8, 'Benadryl', '50mg', 'Sol Pharmacy', 100),
(12, 'Benadryl', '20mg', 'Sol Pharmacy', 50),
(15, 'Mint', '20mg', 'Sol Pharmacy', 50);

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `prescriptionId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `medicationId` int(11) NOT NULL,
  `prescribedDate` datetime NOT NULL,
  `dosageInstructions` varchar(200) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `refillCount` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`prescriptionId`, `userId`, `medicationId`, `prescribedDate`, `dosageInstructions`, `quantity`, `refillCount`) VALUES
(1, 1, 1, '2025-05-06 21:48:41', NULL, 5, 0),
(2, 3, 2, '2025-05-06 21:48:41', NULL, 3, 0),
(3, 1, 3, '2025-05-06 21:48:41', NULL, 2, 0),
(4, 1, 2, '2025-05-01 16:14:29', '', 25, 0),
(7, 4, 5, '0000-00-00 00:00:00', '20mg', 50, 0),
(8, 1, 2, '0000-00-00 00:00:00', '20mg', 20, 0);

--
-- Triggers `prescriptions`
--
DELIMITER $$
CREATE TRIGGER `AfterPrescriptionInsert` AFTER INSERT ON `prescriptions` FOR EACH ROW BEGIN
  UPDATE inventory
  SET quantityAvailable = quantityAvailable - NEW.quantity,
      lastUpdated = NOW()
  WHERE medicationId = NEW.medicationId;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `saleId` int(11) NOT NULL,
  `prescriptionId` int(11) NOT NULL,
  `saleDate` datetime NOT NULL,
  `quantitySold` int(11) NOT NULL,
  `saleAmount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`saleId`, `prescriptionId`, `saleDate`, `quantitySold`, `saleAmount`) VALUES
(1, 1, '2025-05-06 21:48:41', 5, 25.00),
(2, 2, '2025-05-06 21:48:41', 3, 15.00),
(3, 3, '2025-05-06 21:48:41', 2, 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `userName` varchar(45) NOT NULL,
  `contactInfo` varchar(200) DEFAULT NULL,
  `userType` enum('pharmacist','patient') DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userName`, `contactInfo`, `userType`, `password`, `email`) VALUES
(1, 'alex', 'alex@email.com', 'patient', '1234', 'alex@patient.com'),
(2, 'rosa', 'rosa@email.com', 'pharmacist', '1234', 'rosa@pharmacist.com'),
(3, 'carol', 'carol@email.com', 'patient', '1234', NULL),
(4, 'Celine', 'Celine@gmail.com', 'patient', '1234', NULL),
(14, 'David', NULL, 'patient', '1234', NULL),
(15, 'carina', NULL, 'patient', '1234', NULL);

-- --------------------------------------------------------

--
-- Structure for view `medicationinventoryview`
--
DROP TABLE IF EXISTS `medicationinventoryview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `medicationinventoryview`  AS SELECT `medications`.`medicationName` AS `medicationName`, `medications`.`dosage` AS `dosage`, `medications`.`manufacturer` AS `manufacturer`, `inventory`.`quantityAvailable` AS `quantityAvailable` FROM (`medications` join `inventory` on(`medications`.`medicationId` = `inventory`.`medicationId`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventoryId`),
  ADD KEY `fk_medicationId` (`medicationId`);

--
-- Indexes for table `medications`
--
ALTER TABLE `medications`
  ADD PRIMARY KEY (`medicationId`),
  ADD UNIQUE KEY `unique_medication` (`medicationName`,`dosage`,`manufacturer`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`prescriptionId`),
  ADD KEY `fk_prescriptions_user` (`userId`),
  ADD KEY `fk_prescriptions_medication` (`medicationId`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`saleId`),
  ADD KEY `fk_sales_prescription` (`prescriptionId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `medications`
--
ALTER TABLE `medications`
  MODIFY `medicationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `prescriptionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `saleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `fk_medicationId` FOREIGN KEY (`medicationId`) REFERENCES `medications` (`medicationId`) ON DELETE CASCADE;

--
-- Constraints for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `fk_prescriptions_medication` FOREIGN KEY (`medicationId`) REFERENCES `medications` (`medicationId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prescriptions_user` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `fk_sales_prescription` FOREIGN KEY (`prescriptionId`) REFERENCES `prescriptions` (`prescriptionId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
