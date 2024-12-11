-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2024 at 04:09 AM
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
-- Database: `dispersal_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_type`
--

CREATE TABLE `account_type` (
  `ID` int(11) NOT NULL,
  `ACCOUNT_TYPE` varchar(150) NOT NULL,
  `ACCOUNT_TYPE_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_type`
--

INSERT INTO `account_type` (`ID`, `ACCOUNT_TYPE`, `ACCOUNT_TYPE_ID`) VALUES
(1, 'ADMIN', 2),
(2, 'STAFF', 1);

-- --------------------------------------------------------

--
-- Table structure for table `animal`
--

CREATE TABLE `animal` (
  `ANIMAL_ID` int(11) NOT NULL,
  `CLIENT_ID` int(11) NOT NULL,
  `BIRTHDATE` date NOT NULL,
  `IMAGE_PATH` varchar(255) NOT NULL,
  `ANIMALTYPE` varchar(255) NOT NULL,
  `ANIMAL_SEX` varchar(255) NOT NULL COMMENT '1=Male 2=Female',
  `STATUS` varchar(150) NOT NULL DEFAULT '1' COMMENT '1= Alive \r\n2= Dead',
  `VACCINE_CARD_ID` int(11) NOT NULL DEFAULT 1 COMMENT '1=not Vaccinated \r\n2=Vaccinated \r\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animal`
--

INSERT INTO `animal` (`ANIMAL_ID`, `CLIENT_ID`, `BIRTHDATE`, `IMAGE_PATH`, `ANIMALTYPE`, `ANIMAL_SEX`, `STATUS`, `VACCINE_CARD_ID`) VALUES
(5, 14, '2024-09-30', '', 'Goat', 'Male', 'Alive', 0),
(6, 14, '2024-10-23', '', 'Goat', '', 'Alive', 0),
(7, 0, '2024-10-08', '', 'Goat', '', 'Ongoing', 0),
(8, 15, '2024-10-22', '', 'Goat', '', 'Alive', 0),
(9, 16, '2024-10-22', '', 'Cow', '', 'Alive', 0),
(10, 16, '2024-11-01', '', 'Goat', '', 'Alive', 0),
(11, 16, '0000-00-00', '', 'Goat', '', 'Alive', 0),
(12, 16, '0000-00-00', '', 'Goat', '', 'dead', 0),
(13, 16, '2024-10-28', '', 'Goat', '', 'Alive', 0),
(14, 16, '0000-00-00', '', 'Goat', '', 'Alive', 0),
(15, 16, '0000-00-00', '', 'Cow', '', 'Alive', 0),
(16, 13, '0000-00-00', '', 'Cow', '', 'Alive', 0),
(17, 15, '2024-10-29', '', 'Goat', '', '1', 1),
(18, 17, '2024-10-29', '', 'Cow', '0', '1', 1),
(19, 13, '2024-10-30', '', 'Goat', '0', '1', 1),
(20, 14, '2024-10-31', '', 'Cow', '0', '1', 1),
(21, 16, '2024-11-01', '', 'Cow', '0', '1', 1),
(22, 14, '2024-10-31', '', 'Goat', '0', '1', 1),
(23, 14, '2024-11-03', '', 'Goat', '0', '1', 1),
(24, 14, '2024-10-31', '', 'Goat', '1', '1', 1),
(25, 13, '2024-10-30', '', 'Goat', '1', '1', 1),
(26, 17, '2024-10-28', '', 'Goat', '1', '1', 1),
(27, 17, '2024-11-03', '', 'Cow', '2', '1', 1),
(28, 17, '2024-11-03', '', 'Goat', '1', '1', 1),
(29, 16, '2024-11-03', '', 'Goat', '1', '1', 1),
(30, 16, '2024-10-29', '', 'Goat', '1', '1', 1),
(31, 17, '2024-11-02', '', 'Cow', '1', '1', 1),
(32, 13, '2024-11-03', '', 'Goat', '1', '1', 1),
(33, 13, '2024-11-01', '', 'Cow', '2', '1', 1),
(34, 15, '2024-11-04', '', 'Cow', '1', '1', 1),
(35, 15, '2024-11-06', '', 'Cow', '2', '1', 1),
(36, 16, '2024-11-02', '', 'Goat', '1', '1', 1),
(37, 13, '2024-11-11', '', 'Goat', '1', '1', 1),
(38, 17, '2024-11-11', '', 'Goat', '2', '1', 1),
(39, 17, '2024-11-11', '', 'Goat', '1', '1', 1),
(40, 17, '2024-11-11', '', 'Horse', '1', '1', 1),
(41, 15, '2024-11-11', '', 'Goat', 'Male', '1', 1),
(42, 15, '2024-11-11', '', 'Goat', 'Male', '1', 1),
(43, 15, '2024-11-11', '', 'Goat', 'Male', '1', 1),
(44, 15, '2024-11-11', '', 'Goat', 'Male', '1', 1),
(45, 17, '2024-11-12', '', 'Goat', 'Female', '1', 1),
(46, 13, '2024-11-11', '', 'Horse', 'Male', '1', 1),
(47, 16, '2024-11-12', '', 'Goat', 'Female', '1', 1),
(48, 17, '2024-11-13', '', 'Goat', 'Male', '1', 2),
(49, 14, '2024-11-08', '', 'Horse', 'Male', '1', 2),
(50, 13, '2024-11-13', '', 'Goat', 'Male', '1', 1),
(51, 14, '2024-11-13', '', 'Goat', 'Male', '1', 1),
(52, 15, '2024-11-13', '', 'Goat', 'Male', '1', 1),
(53, 18, '2024-11-24', '', 'Cow', 'Male', '1', 1),
(54, 18, '2024-11-24', '', 'Goat', 'Male', '1', 1),
(55, 18, '2024-12-07', 'uploads/116008437_p0_master1200.jpg', 'Cow', 'Male', '1', 1),
(59, 18, '2024-11-26', 'uploads/124014025_p0_master1200.jpg', 'Cow', 'Male', '1', 1),
(61, 15, '2024-11-24', 'uploads/120597943_p0_master1200.jpg', 'Horse', 'Male', '1', 1),
(62, 18, '2024-11-20', 'uploads/120199856_p0_master1200.jpg', 'Horse', 'Male', '1', 1),
(64, 18, '2024-11-24', 'uploads/417514633_377879608538586_8441283269290102432_n.jpg', 'Sheep', 'Male', '1', 1),
(66, 18, '2024-11-24', 'uploads/119695829_p0_master1200.jpg', 'Sheep', 'Male', '1', 1),
(67, 18, '2024-11-24', 'uploads/120562691_p3_master1200.jpg', 'Horse', 'Female', '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `CLIENT_ID` int(11) NOT NULL,
  `FNAME` varchar(150) NOT NULL,
  `LNAME` varchar(140) NOT NULL,
  `MIDINITIAL` varchar(150) NOT NULL,
  `ASSOCIATION` varchar(255) NOT NULL,
  `CONTACT_NO` varchar(255) NOT NULL,
  `ADDRESS` varchar(150) NOT NULL,
  `DATE_REGISTERED` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`CLIENT_ID`, `FNAME`, `LNAME`, `MIDINITIAL`, `ASSOCIATION`, `CONTACT_NO`, `ADDRESS`, `DATE_REGISTERED`) VALUES
(13, 'asd', 'dsa', 'a', 'asda', '', 'vvx', '2024-10-10'),
(14, 'bud', 'dy', 'h', 'SAd', '', 'ST@', '2024-10-05'),
(15, 'Raprap', 'Say', 'h', 'SUS', '', 'vvx', '2024-10-04'),
(16, 'Gloria', 'Capunong', 'S', 'Farmers Association', '', 'Kabankalan', '2024-10-22'),
(17, 'Nica', 'Cobing', 'f', 'Farmers Association', '', 'zon3', '2024-11-03'),
(18, 'Ramian', 'Say', 'h', 'Farmers Association', '09294760873', 'ews', '2024-11-24');

-- --------------------------------------------------------

--
-- Table structure for table `dispersal`
--

CREATE TABLE `dispersal` (
  `DISPERSAL_ID` int(11) NOT NULL,
  `CLIENT_ID` int(11) NOT NULL,
  `1ST_PAYMENT_ID` int(11) NOT NULL DEFAULT 1 COMMENT '1= Unpaid\r\n2=Paid',
  `2ND_PAYMENT_ID` int(11) NOT NULL DEFAULT 1 COMMENT '1=Unpaid 2=Paid	',
  `STATUS` varchar(150) NOT NULL COMMENT '1=Ongoing \r\n2=Finished '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dispersal`
--

INSERT INTO `dispersal` (`DISPERSAL_ID`, `CLIENT_ID`, `1ST_PAYMENT_ID`, `2ND_PAYMENT_ID`, `STATUS`) VALUES
(21, 15, 0, 0, ''),
(22, 15, 0, 0, ''),
(23, 17, 0, 0, ''),
(24, 13, 1, 0, '1'),
(25, 14, 1, 0, '2'),
(26, 16, 0, 0, ''),
(27, 15, 0, 0, ''),
(28, 16, 0, 0, ''),
(29, 13, 2, 0, ''),
(30, 14, 26, 0, 'Partially Paid'),
(31, 17, 0, 0, ''),
(32, 14, 0, 0, ''),
(33, 0, 0, 0, ''),
(34, 0, 0, 0, ''),
(35, 17, 0, 0, ''),
(36, 15, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

CREATE TABLE `parent` (
  `PARENT_ID` int(11) NOT NULL,
  `CLIENT_ID` int(11) NOT NULL,
  `ANIMAL_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parent`
--

INSERT INTO `parent` (`PARENT_ID`, `CLIENT_ID`, `ANIMAL_ID`) VALUES
(60, 14, 5),
(61, 14, 5),
(62, 14, 5),
(63, 14, 5),
(64, 18, 53),
(65, 14, 5),
(66, 14, 5),
(67, 14, 5),
(68, 14, 5),
(69, 14, 5),
(70, 14, 5),
(71, 14, 5),
(72, 14, 5),
(73, 14, 5),
(74, 14, 5),
(75, 18, 53),
(76, 15, 8),
(77, 15, 8),
(78, 15, 8),
(79, 15, 8),
(80, 13, 16),
(81, 14, 5),
(82, 14, NULL),
(83, 13, 16),
(84, 14, 5),
(85, 14, 5),
(86, 14, 5),
(87, 14, 5),
(88, 18, 53),
(89, 18, 53),
(90, 18, 53),
(91, 16, 9),
(92, 13, 16),
(93, 14, 5),
(94, 15, 8),
(95, 18, 53),
(96, 18, 53),
(97, 18, 53),
(98, 13, 16),
(99, 14, 5),
(100, 13, 16),
(101, 14, 5),
(102, 13, 16),
(103, 15, 8),
(104, 16, 9),
(105, 13, 16);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PAYMENT_ID` int(11) NOT NULL,
  `DISPERSAL_ID` int(11) NOT NULL,
  `OR_PAYMENT_NO` int(11) NOT NULL,
  `PARENT_ID` int(11) NOT NULL,
  `DATE` date NOT NULL,
  `PAID_BY` int(11) NOT NULL,
  `PAID_TO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`PAYMENT_ID`, `DISPERSAL_ID`, `OR_PAYMENT_NO`, `PARENT_ID`, `DATE`, `PAID_BY`, `PAID_TO`) VALUES
(1, 0, 0, 0, '0000-00-00', 0, 0),
(2, 0, 0, 0, '0000-00-00', 0, 0),
(3, 0, 0, 0, '0000-00-00', 0, 0),
(4, 0, 0, 0, '0000-00-00', 0, 0),
(5, 0, 0, 0, '0000-00-00', 0, 0),
(6, 0, 0, 0, '0000-00-00', 0, 0),
(7, 24, 313, 3113, '0000-00-00', 0, 0),
(8, 26, 5466, 4564, '2024-11-08', 0, 0),
(9, 26, 3123421, 45645, '2024-11-09', 0, 0),
(10, 21, 313123, 231312312, '2024-11-09', 0, 0),
(11, 24, 123123, 65456465, '2024-11-09', 0, 0),
(12, 23, 2131231, 45546546, '2024-11-09', 0, 0),
(13, 26, 43424, 324234, '2024-11-09', 0, 0),
(14, 23, 312312321, 231, '2024-11-09', 0, 0),
(15, 0, 0, 0, '0000-00-00', 0, 0),
(16, 0, 0, 0, '0000-00-00', 0, 0),
(17, 0, 0, 0, '0000-00-00', 0, 0),
(18, 0, 0, 0, '0000-00-00', 0, 0),
(19, 0, 0, 0, '0000-00-00', 0, 0),
(20, 0, 0, 0, '0000-00-00', 0, 0),
(21, 0, 0, 0, '0000-00-00', 0, 0),
(22, 0, 0, 0, '0000-00-00', 0, 0),
(23, 0, 0, 0, '0000-00-00', 0, 0),
(24, 0, 0, 0, '0000-00-00', 0, 0),
(25, 32, 1234567890, 231, '0000-00-00', 0, 0),
(26, 30, 321, 0, '2024-11-30', 14, 13);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `SCHEDULE_ID` int(11) NOT NULL,
  `EVENT_NAME` varchar(255) NOT NULL,
  `EVENT_DATE` datetime NOT NULL,
  `CLIENT_ID` int(11) NOT NULL,
  `1ST_REQUIREMENT` varchar(255) NOT NULL COMMENT '0= Not Submitted \r\n1= Submitted ',
  `2ND_REQUIREMENT` varchar(255) NOT NULL COMMENT '0= Not Submitted \r\n1= Submitted ',
  `STATUS` varchar(255) NOT NULL COMMENT '3=request sent, 1=accept, 2=reject	',
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `FULL_NAME` varchar(255) NOT NULL,
  `USERNAME` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `ACCOUNT_TYPE_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `FULL_NAME`, `USERNAME`, `PASSWORD`, `ACCOUNT_TYPE_ID`) VALUES
(4, 'RMAS', 'Staff', 'Staff', 1),
(5, 'HER', 'Admin', 'Admin', 2);

-- --------------------------------------------------------

--
-- Table structure for table `vaccine`
--

CREATE TABLE `vaccine` (
  `VACCINE_ID` int(11) NOT NULL,
  `VACCINE_TYPE_ID` int(11) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `QUANTITY` int(255) NOT NULL,
  `EXPIRY_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccine`
--

INSERT INTO `vaccine` (`VACCINE_ID`, `VACCINE_TYPE_ID`, `DESCRIPTION`, `QUANTITY`, `EXPIRY_DATE`) VALUES
(17, 1, 'sdad', 55, '2024-12-07'),
(18, 2, 'Vaccination', 55, '2024-12-07'),
(19, 1, 'dasd', 55, '2024-12-07'),
(20, 2, 'ddad', 55, '2024-12-03');

-- --------------------------------------------------------

--
-- Table structure for table `vaccine_card`
--

CREATE TABLE `vaccine_card` (
  `VACCINE_CARD_ID` int(11) NOT NULL,
  `ANIMAL_ID` int(11) NOT NULL,
  `VACCINE_ID` int(11) NOT NULL,
  `DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccine_card`
--

INSERT INTO `vaccine_card` (`VACCINE_CARD_ID`, `ANIMAL_ID`, `VACCINE_ID`, `DATE`) VALUES
(1, 55, 0, '2024-11-24');

-- --------------------------------------------------------

--
-- Table structure for table `vaccine_type`
--

CREATE TABLE `vaccine_type` (
  `VACCINE_TYPE_ID` int(11) NOT NULL,
  `VACCINE_NAME` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccine_type`
--

INSERT INTO `vaccine_type` (`VACCINE_TYPE_ID`, `VACCINE_NAME`) VALUES
(1, 'ExMed 1'),
(2, 'Medicine 2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_type`
--
ALTER TABLE `account_type`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`ANIMAL_ID`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`CLIENT_ID`);

--
-- Indexes for table `dispersal`
--
ALTER TABLE `dispersal`
  ADD PRIMARY KEY (`DISPERSAL_ID`);

--
-- Indexes for table `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`PARENT_ID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PAYMENT_ID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`SCHEDULE_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `vaccine`
--
ALTER TABLE `vaccine`
  ADD PRIMARY KEY (`VACCINE_ID`);

--
-- Indexes for table `vaccine_card`
--
ALTER TABLE `vaccine_card`
  ADD PRIMARY KEY (`VACCINE_CARD_ID`);

--
-- Indexes for table `vaccine_type`
--
ALTER TABLE `vaccine_type`
  ADD PRIMARY KEY (`VACCINE_TYPE_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_type`
--
ALTER TABLE `account_type`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `animal`
--
ALTER TABLE `animal`
  MODIFY `ANIMAL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `CLIENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `dispersal`
--
ALTER TABLE `dispersal`
  MODIFY `DISPERSAL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `parent`
--
ALTER TABLE `parent`
  MODIFY `PARENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `PAYMENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `SCHEDULE_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vaccine`
--
ALTER TABLE `vaccine`
  MODIFY `VACCINE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vaccine_card`
--
ALTER TABLE `vaccine_card`
  MODIFY `VACCINE_CARD_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vaccine_type`
--
ALTER TABLE `vaccine_type`
  MODIFY `VACCINE_TYPE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
