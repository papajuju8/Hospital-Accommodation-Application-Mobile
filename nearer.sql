-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2021 at 12:24 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nearer`
--

-- --------------------------------------------------------

--
-- Table structure for table `admission`
--

CREATE TABLE `admission` (
  `ADMISSION_ID` int(11) NOT NULL,
  `ADMISSION_BIRTHDATE` date NOT NULL,
  `TIME_REQUESTED` time NOT NULL,
  `TIME RESPONDED` time NOT NULL,
  `ADMISSION_STATUS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hospital_profile`
--

CREATE TABLE `hospital_profile` (
  `HOSPITAL_ID` int(11) NOT NULL,
  `HOSPITAL_USERNAME` varchar(255) NOT NULL,
  `HOSPITAL_EMAIL` varchar(255) NOT NULL,
  `HOSPITAL_PASSWORD` varchar(255) NOT NULL,
  `HOSPITAL_FNAME` varchar(100) NOT NULL,
  `HOSPITAL_MNAME` varchar(100) NOT NULL,
  `HOSPITAL_LNAME` varchar(100) NOT NULL,
  `HOSPITAL_CONTACTNO` varchar(11) NOT NULL,
  `HOSPITAL_SEX` int(11) NOT NULL,
  `HOSPITAL_AGE` int(11) NOT NULL,
  `HOSPITAL_BIRTHDATE` date NOT NULL,
  `CREATED_ON` datetime(6) NOT NULL,
  `MODIFIED_ON` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hospital_profile`
--

INSERT INTO `hospital_profile` (`HOSPITAL_ID`, `HOSPITAL_USERNAME`, `HOSPITAL_EMAIL`, `HOSPITAL_PASSWORD`, `HOSPITAL_FNAME`, `HOSPITAL_MNAME`, `HOSPITAL_LNAME`, `HOSPITAL_CONTACTNO`, `HOSPITAL_SEX`, `HOSPITAL_AGE`, `HOSPITAL_BIRTHDATE`, `CREATED_ON`, `MODIFIED_ON`) VALUES
(1, 'HospitalTest1', 'hospital_test@example.com', 'hospital123', 'Hospital', '', 'Test', '09123456789', 1, 0, '2000-09-19', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000'),
(2, 'HospiTest2', 'hospital_test2@example.com', 'hospital123', 'Hospital', '', 'Test', '09123454321', 1, 0, '2000-01-01', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000'),
(3, 'UserTest2', 'usertest2@example.com', 'usertest2', 'User', '', 'Test', '09123456789', 1, 0, '1999-01-01', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000'),
(4, 'papajujubajuju', 'juliusvilla1208@gmail.com', 'julius1208', 'Julius', 'Altura', 'Villa', '09154547585', 1, 0, '1999-12-08', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000'),
(5, 'as', 'juliusvilla1208@gmail.com', 'juliusabaga', 'Julius', 'A', 'Villa', '09123456712', 1, 0, '1999-12-08', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `issue` varchar(255) NOT NULL,
  `date_issued` datetime DEFAULT NULL,
  `date_resolved` datetime DEFAULT NULL,
  `status_update` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id`, `subject`, `issue`, `date_issued`, `date_resolved`, `status_update`) VALUES
(5, 'Test', 'Hello, World!', '2021-06-30 07:25:21', NULL, 'In Queue');

-- --------------------------------------------------------

--
-- Table structure for table `users_profile`
--

CREATE TABLE `users_profile` (
  `USER_ID` int(11) NOT NULL,
  `USER_USERNAME` varchar(255) NOT NULL,
  `USER_EMAIL` varchar(255) NOT NULL,
  `USER_PASSWORD` varchar(255) NOT NULL,
  `USER_FNAME` varchar(100) NOT NULL,
  `USER_MNAME` varchar(100) NOT NULL,
  `USER_LNAME` varchar(100) NOT NULL,
  `USER_CONTACTNO` varchar(11) NOT NULL,
  `USER_ADDRESS` varchar(255) NOT NULL,
  `USER_SEX` int(11) NOT NULL,
  `USER_AGE` int(11) NOT NULL,
  `USER_BIRTHDATE` date NOT NULL,
  `CREATED_ON` datetime(6) NOT NULL,
  `MODIFIED_ON` datetime(6) NOT NULL,
  `MEDCON_DIABETES` int(11) DEFAULT NULL,
  `MEDCON_HEART_DISEASE` int(11) DEFAULT NULL,
  `MEDCON_HEART_FAILURE` int(11) DEFAULT NULL,
  `MEDCON_STROKE` int(11) DEFAULT NULL,
  `MEDCON_ASTHMA` int(11) DEFAULT NULL,
  `MEDCON_COPD` int(11) DEFAULT NULL,
  `MEDCON_ARTHRITIS` int(11) DEFAULT NULL,
  `MEDCON_CANCER` int(11) DEFAULT NULL,
  `MEDCON_CANCER_NAME` varchar(255) DEFAULT NULL,
  `MEDCON_HBP` int(11) DEFAULT NULL,
  `MEDCON_ALZHEIMERS` int(11) DEFAULT NULL,
  `MEDCON_OTHERS` int(11) DEFAULT NULL,
  `MEDCON_OTHERS_NAME` varchar(255) DEFAULT NULL,
  `ALLERGY_FOOD` int(11) DEFAULT NULL,
  `ALLERGY_FOOD_NAME` varchar(255) DEFAULT NULL,
  `ALLERGY_MEDICATION` int(11) DEFAULT NULL,
  `ALLERGY_MEDICATION_NAME` varchar(255) DEFAULT NULL,
  `ALLERGY_ENVIRONMENTAL` int(11) DEFAULT NULL,
  `ALLERGY_ENVIRONMENTAL_NAME` varchar(255) DEFAULT NULL,
  `SURGERY_NAME` varchar(255) DEFAULT NULL,
  `SURGERY_DATE` date DEFAULT NULL,
  `SURGERY_HOSPITAL` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_profile`
--

INSERT INTO `users_profile` (`USER_ID`, `USER_USERNAME`, `USER_EMAIL`, `USER_PASSWORD`, `USER_FNAME`, `USER_MNAME`, `USER_LNAME`, `USER_CONTACTNO`, `USER_ADDRESS`, `USER_SEX`, `USER_AGE`, `USER_BIRTHDATE`, `CREATED_ON`, `MODIFIED_ON`, `MEDCON_DIABETES`, `MEDCON_HEART_DISEASE`, `MEDCON_HEART_FAILURE`, `MEDCON_STROKE`, `MEDCON_ASTHMA`, `MEDCON_COPD`, `MEDCON_ARTHRITIS`, `MEDCON_CANCER`, `MEDCON_CANCER_NAME`, `MEDCON_HBP`, `MEDCON_ALZHEIMERS`, `MEDCON_OTHERS`, `MEDCON_OTHERS_NAME`, `ALLERGY_FOOD`, `ALLERGY_FOOD_NAME`, `ALLERGY_MEDICATION`, `ALLERGY_MEDICATION_NAME`, `ALLERGY_ENVIRONMENTAL`, `ALLERGY_ENVIRONMENTAL_NAME`, `SURGERY_NAME`, `SURGERY_DATE`, `SURGERY_HOSPITAL`) VALUES
(1, 'UserTest2', 'usertest2@example.com', 'user123', 'User', 'Two', 'Test', '09222222222', 'Quezon City', 2, 0, '2000-02-02', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', 0, 0, 0, 0, 0, 0, 0, 0, '', 0, 0, 0, '', 0, '', 0, '', 0, '', '', '0000-00-00', ''),
(2, 'UserTest3', 'user3test@sample.com', 'user123', 'User', 'Three', 'Test', '09123445674', 'Quezon City', 1, 0, '2000-01-03', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', 0, 0, 0, 0, 0, 0, 0, 0, '', 0, 0, 0, '', 0, '', 0, '', 0, '', '', '0000-00-00', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admission`
--
ALTER TABLE `admission`
  ADD PRIMARY KEY (`ADMISSION_ID`);

--
-- Indexes for table `hospital_profile`
--
ALTER TABLE `hospital_profile`
  ADD PRIMARY KEY (`HOSPITAL_ID`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_profile`
--
ALTER TABLE `users_profile`
  ADD PRIMARY KEY (`USER_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admission`
--
ALTER TABLE `admission`
  MODIFY `ADMISSION_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hospital_profile`
--
ALTER TABLE `hospital_profile`
  MODIFY `HOSPITAL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users_profile`
--
ALTER TABLE `users_profile`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
