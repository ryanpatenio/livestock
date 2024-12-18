-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 05:04 PM
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
  `isVaccinated` varchar(255) NOT NULL DEFAULT '0',
  `STATUS` varchar(150) NOT NULL COMMENT '1= Alive \r\n2= Dead',
  `VACCINE_CARD_ID` int(11) DEFAULT NULL COMMENT '1=not Vaccinated \r\n2=Vaccinated \r\n',
  `isPayment` int(11) DEFAULT 0,
  `fromClient` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animal`
--

INSERT INTO `animal` (`ANIMAL_ID`, `CLIENT_ID`, `BIRTHDATE`, `IMAGE_PATH`, `ANIMALTYPE`, `ANIMAL_SEX`, `isVaccinated`, `STATUS`, `VACCINE_CARD_ID`, `isPayment`, `fromClient`) VALUES
(77, 13, '2024-12-01', 'C:\\xampp\\htdocs\\mytestpage.test\\Livestock2\\Livestock2\\path_to_images\\110734577_p0_master1200.jpg', 'Horse', 'Male', '0', '1', 1, 0, 0),
(78, 15, '2024-12-01', 'path_to_images/116008587_p0_master1200.jpg', 'Sheep', 'Male', '0', '1', 1, 0, 0),
(79, 15, '2024-12-01', 'path_to_images/110029455_p0_master1200.jpg', 'Sheep', 'Female', '0', '1', 1, 0, 0),
(80, 13, '2024-12-03', 'path_to_images/__ninomae_ina_nis_ninomae_ina_nis_and_ao_chan_hololive_and_1_more_drawn_by_namaonpa__sample-92ba1c127463fcdfd13a86c3d2d711b7.jpg', 'Goat', 'Male', '0', '1', 1, 0, 0),
(81, 13, '2024-12-03', 'path_to_images/110029455_p0_master1200.jpg', 'Goat', 'Male', '0', '1', 1, 0, 0),
(107, 28, '2024-12-11', 'path_to_images/cattle1.jpg', 'Cattle', 'Male', '1', '1', 10, 0, 0),
(108, 28, '2024-12-18', 'path_to_images/cattle1.jpg', 'Cattle', 'Male', '1', '1', 11, 0, 0),
(117, 31, '2014-01-02', 'path_to_images/6762eef8c164a_cattle1.jpg', 'Sheep', 'Male', '0', '1', 20, 1, 15);

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
(13, 'Jamese', 'HOOMAN', 'A', 'Farmers Assoc', '093884848384', 'Brgy 4', '2024-10-10'),
(14, 'Bea', 'Alonzo', 'B', 'Farmers Assoc', '09187101282', 'Brgy 2', '2024-10-05'),
(15, 'Raprap', 'Say', 'h', 'SUS', '639510995227', 'vvx', '2024-10-04'),
(16, 'Gloria', 'Capunong', 'S', 'Farmers Association', '', 'Kabankalan', '2024-10-22'),
(17, 'Nica', 'Cobing', 'f', 'Farmers Association', '639163181979', 'zon3', '2024-11-03'),
(18, 'Ramian', 'Say', 'h', 'Farmers Association', '639294760873', 'ews', '2024-11-24'),
(19, 'Ramian', 'sdad', 'G', 'Farmers Association', '639294760873', 'zone 2 ', '2024-11-28'),
(20, 'MacKensie', 'Travis', 'Rerum incididunt nem', 'Quasi tempore quaer', '197', 'Laudantium nihil el', '2024-12-11'),
(21, 'Cynthia', 'Sanford', 'Qui voluptas adipisc', 'Ut dicta magna conse', '644', 'Esse non velit labor', '2024-12-11'),
(22, 'Hiram', 'Crosby', 'In aut ratione inven', 'Minima velit quam mo', '523', 'Voluptas labore veli', '2024-12-11'),
(23, 'Sean', 'Lindsey', 'Officiis elit error', 'Et earum ipsum dolor', '182', 'Nulla officia at max', '2024-12-11'),
(24, 'Chester', 'Todd', 'Asperiores in esse ', 'Vel aut delectus do', '830', 'Est adipisicing atqu', '2024-12-11'),
(25, 'Marsden', 'Villarreal', 'Voluptas beatae dolo', 'Sapiente dolorum rer', '553', 'Lorem quis quibusdam', '2024-12-11'),
(26, 'Walter', 'Campos', 'Mollitia quibusdam p', 'Voluptas omnis place', '923', 'Ad odit dolores quas', '2024-12-11'),
(27, 'Aphrodite', 'Clements', 'Perferendis quo dolo', 'Recusandae Laboris ', '671', 'Exercitation rerum c', '2024-12-11'),
(28, 'Ryan', 'Warner', 'S', 'Farmers Assoc', '09770772409', 'Brgy 4', '2024-12-11'),
(29, 'Jamela', 'Junkok', 'A', 'wa', '099598688544', 'Brgy 2', '2024-12-11'),
(30, 'Bevis', 'Savage', 'Ipsum minima explica', 'Voluptatem asperiore', '502', 'Est ducimus sit nos', '2024-12-12'),
(31, 'Avye', 'Brock', 'Quo nisi deserunt ei', 'Numquam cillum minus', '821', 'Non veniam enim sus', '2024-12-12'),
(32, 'Jedi', 'Manugsulit', 'A', 'Farmer Assoc', '094858838843', 'Brgy 2', '2024-12-12'),
(33, 'Chandler', 'Molina', 'Perferendis aut et a', 'Lorem accusamus qui ', '09384884838', 'Eum aute quia unde c', '2024-12-12'),
(36, 'Beas', 'Joyner', 'A', 'Farmers Assoc', '09187101282', 'Brgy 4', '2024-12-18'),
(37, 'Chester', 'Field', 'H', 'Farmers Assoc', '639510995227', 'Brgy 2', '2024-12-18');

-- --------------------------------------------------------

--
-- Table structure for table `dispersal`
--

CREATE TABLE `dispersal` (
  `DISPERSAL_ID` int(11) NOT NULL,
  `CLIENT_ID` int(11) NOT NULL,
  `1ST_PAYMENT_ID` int(11) NOT NULL DEFAULT 1 COMMENT '1= Unpaid\r\n2=Paid',
  `DATE_FIRST_PAYMENT` date DEFAULT NULL,
  `2ND_PAYMENT_ID` int(11) NOT NULL DEFAULT 1 COMMENT '1=Unpaid 2=Paid	',
  `DATE_SECOND_PAYMENT` date DEFAULT NULL,
  `STATUS` varchar(150) NOT NULL COMMENT '1=Ongoing \r\n2=Finished '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dispersal`
--

INSERT INTO `dispersal` (`DISPERSAL_ID`, `CLIENT_ID`, `1ST_PAYMENT_ID`, `DATE_FIRST_PAYMENT`, `2ND_PAYMENT_ID`, `DATE_SECOND_PAYMENT`, `STATUS`) VALUES
(46, 28, 2, NULL, 0, NULL, 'PENDING'),
(47, 28, 1, NULL, 0, NULL, 'PENDING'),
(48, 28, 0, NULL, 0, NULL, 'PENDING'),
(49, 27, 0, '2024-12-18', 0, NULL, 'PENDING'),
(50, 15, 1, '1973-08-31', 0, NULL, 'PENDING');

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
(496, 13, 77),
(497, 13, 77),
(498, 13, 77),
(499, 13, 77),
(500, 13, 77),
(501, 13, 77),
(502, 13, 77),
(503, 13, 77),
(504, 13, 77),
(505, 13, 77),
(506, 13, 77),
(507, 13, 77),
(508, 13, 77),
(509, 15, 78),
(510, 13, 77),
(511, 13, 77),
(512, 13, 77),
(513, 13, 77),
(514, 13, 77),
(515, 13, 77),
(516, 13, 77),
(517, 15, 78),
(518, 15, 78),
(519, 15, 78),
(520, 13, 77),
(521, 13, 77),
(522, 13, 77),
(523, 15, 78),
(524, 13, 77),
(525, 13, 77),
(526, 13, 77),
(527, 13, 77),
(528, 13, 77),
(529, 13, 77),
(530, 13, 77),
(531, 13, 77),
(532, 15, 78),
(533, 15, 78),
(534, 13, 77),
(535, 13, 77),
(536, 13, 77),
(537, 13, 77),
(538, 15, 78),
(539, 13, 77),
(540, 13, 77),
(541, 13, 77),
(542, 13, 77),
(543, 13, 77),
(544, 15, 78),
(545, 13, 77),
(546, 28, 89),
(547, 13, 77),
(548, 14, 82),
(549, 15, 78),
(550, 18, 84),
(551, 18, 84),
(552, 13, 77),
(553, 28, 89),
(554, 13, 77),
(555, 14, 82),
(556, 15, 78),
(557, 28, 89),
(558, 28, 89),
(559, 28, 89),
(560, 28, 89),
(561, 28, 89),
(562, 28, 89),
(563, 28, 89),
(564, 28, 89),
(565, 28, 89),
(566, 28, 89),
(567, 28, 89),
(568, 28, 89),
(569, 28, 89),
(570, 28, 89),
(571, 28, 89),
(572, 28, 89),
(573, 28, 89),
(574, 13, 77),
(575, 28, 89),
(576, 13, 77),
(577, 28, 89),
(578, 28, 89),
(579, 28, 89),
(580, 28, 89),
(581, 28, 107),
(582, 28, 107),
(583, 28, 107),
(584, 28, 107),
(585, 28, 107),
(586, 28, 107),
(587, 28, 107),
(588, 28, 107),
(589, 28, 107),
(590, 28, 107),
(591, 28, 107),
(592, 28, 107),
(593, 28, 107),
(594, 28, 107),
(595, 28, 107),
(596, 28, 107),
(597, 28, 107),
(598, 28, 107),
(599, 28, 107),
(600, 28, 107),
(601, 15, 78),
(602, 28, 107),
(603, 28, 107),
(604, 28, 107),
(605, 28, 107),
(606, 13, 77),
(607, 28, 107),
(608, 28, 107),
(609, 28, 107),
(610, 28, 107),
(611, 28, 107),
(612, 28, 107),
(613, 28, 107),
(614, 15, 78),
(615, 15, 78),
(616, 15, 78),
(617, 15, 78),
(618, 15, 78),
(619, 15, 78),
(620, 15, 78),
(621, 15, 78),
(622, 15, 78),
(623, 15, 78),
(624, 15, 78),
(625, 15, 78),
(626, 15, 78),
(627, 15, 78),
(628, 15, 78),
(629, 15, 78),
(630, 15, 78),
(631, 15, 78),
(632, 15, 78),
(633, 15, 78),
(634, 15, 78),
(635, 15, 78),
(636, 15, 78),
(637, 15, 78),
(638, 15, 78),
(639, 15, 78),
(640, 15, 78),
(641, 15, 78),
(642, 15, 78),
(643, 15, 78),
(644, 15, 78),
(645, 15, 78),
(646, 15, 78),
(647, 15, 78),
(648, 15, 78),
(649, 15, 78),
(650, 15, 78),
(651, 15, 78),
(652, 15, 78),
(653, 15, 78),
(654, 15, 78),
(655, 15, 78),
(656, 15, 78),
(657, 15, 78),
(658, 15, 78),
(659, 15, 78),
(660, 15, 78),
(661, 15, 78),
(662, 15, 78),
(663, 15, 78),
(664, 15, 78),
(665, 15, 78),
(666, 15, 78),
(667, 15, 78),
(668, 15, 78),
(669, 15, 78),
(670, 15, 78),
(671, 15, 78),
(672, 15, 78),
(673, 15, 78),
(674, 15, 78),
(675, 15, 78),
(676, 15, 78),
(677, 15, 78),
(678, 31, 117),
(679, 31, 117);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PAYMENT_ID` int(11) NOT NULL,
  `DISPERSAL_ID` int(11) NOT NULL,
  `OR_PAYMENT_NO` int(11) NOT NULL,
  `DATE` date NOT NULL,
  `PAID_BY` int(11) NOT NULL,
  `GIVE_TO` int(11) NOT NULL,
  `PAYMENT_STATUS` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`PAYMENT_ID`, `DISPERSAL_ID`, `OR_PAYMENT_NO`, `DATE`, `PAID_BY`, `GIVE_TO`, `PAYMENT_STATUS`) VALUES
(32, 50, 23939949, '2024-12-18', 15, 31, 'First Payment');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `SCHEDULE_ID` int(11) NOT NULL,
  `VACCINE_TYPE_ID` int(11) NOT NULL DEFAULT 0,
  `QTY_USED` varchar(50) NOT NULL,
  `EVENT_NAME` varchar(255) NOT NULL,
  `EVENT_DATE` date NOT NULL,
  `CLIENT_ID` int(11) NOT NULL,
  `1ST_REQUIREMENT` varchar(255) NOT NULL DEFAULT '0' COMMENT '0= Not Submitted \r\n1= Submitted ',
  `2ND_REQUIREMENT` varchar(255) NOT NULL DEFAULT '0' COMMENT '0= Not Submitted \r\n1= Submitted ',
  `STATUS` varchar(255) DEFAULT '0' COMMENT '1=accept, 2=reject	',
  `isCompleted` varchar(255) DEFAULT '0',
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`SCHEDULE_ID`, `VACCINE_TYPE_ID`, `QTY_USED`, `EVENT_NAME`, `EVENT_DATE`, `CLIENT_ID`, `1ST_REQUIREMENT`, `2ND_REQUIREMENT`, `STATUS`, `isCompleted`, `CREATED_AT`) VALUES
(67, 4, '20', 'DEWORMING', '2024-12-26', 28, '1', '1', '1', '1', '2024-12-16 02:49:54'),
(68, 5, '2', 'DEWORMING', '2024-12-20', 28, '1', '1', '1', '1', '2024-12-16 02:36:53'),
(69, 5, '2', 'DEWORMING', '2025-01-17', 28, '1', '1', '1', '1', '2024-12-16 02:52:16'),
(70, 5, '1', 'DEWORMING', '2024-12-18', 28, '1', '1', '1', '0', '2024-12-17 10:13:24');

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
  `QUANTITY` int(255) NOT NULL,
  `EXPIRY_DATE` date NOT NULL,
  `DATE_CREATED` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccine`
--

INSERT INTO `vaccine` (`VACCINE_ID`, `VACCINE_TYPE_ID`, `QUANTITY`, `EXPIRY_DATE`, `DATE_CREATED`) VALUES
(42, 6, 15, '2025-01-12', '2024-12-12'),
(43, 6, 50, '2025-02-14', '2024-12-12'),
(44, 4, 0, '2025-02-07', '2024-12-12'),
(45, 4, 0, '2025-02-21', '2024-12-12'),
(46, 5, 68, '2025-04-23', '2024-12-12'),
(47, 4, 30, '2024-12-28', '2024-12-16');

-- --------------------------------------------------------

--
-- Table structure for table `vaccine_card`
--

CREATE TABLE `vaccine_card` (
  `VACCINE_CARD_ID` int(11) NOT NULL,
  `ANIMAL_ID` int(11) NOT NULL,
  `DATE_CREATED` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccine_card`
--

INSERT INTO `vaccine_card` (`VACCINE_CARD_ID`, `ANIMAL_ID`, `DATE_CREATED`) VALUES
(10, 107, '2024-12-13'),
(11, 108, '2024-12-16'),
(20, 117, '2024-12-18');

-- --------------------------------------------------------

--
-- Table structure for table `vaccine_details`
--

CREATE TABLE `vaccine_details` (
  `VACCINE_DETAILS_ID` int(11) NOT NULL,
  `VACCINE_CARD_ID` int(11) NOT NULL,
  `SCHEDULE_ID` int(11) NOT NULL,
  `STATUS` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccine_details`
--

INSERT INTO `vaccine_details` (`VACCINE_DETAILS_ID`, `VACCINE_CARD_ID`, `SCHEDULE_ID`, `STATUS`) VALUES
(9, 10, 68, '1'),
(10, 11, 67, '1'),
(11, 10, 69, '1');

-- --------------------------------------------------------

--
-- Table structure for table `vaccine_history`
--

CREATE TABLE `vaccine_history` (
  `HISTORY_ID` int(11) NOT NULL,
  `VACCINE_ID` int(11) NOT NULL,
  `VACCINE_TYPE_ID` int(11) NOT NULL,
  `QTY_ADD` int(11) NOT NULL,
  `DATE_CREATED` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccine_history`
--

INSERT INTO `vaccine_history` (`HISTORY_ID`, `VACCINE_ID`, `VACCINE_TYPE_ID`, `QTY_ADD`, `DATE_CREATED`) VALUES
(13, 42, 6, 60, '2024-12-12'),
(14, 43, 6, 50, '2024-12-12'),
(15, 44, 4, 60, '2024-12-12'),
(16, 45, 4, 20, '2024-12-12'),
(17, 46, 5, 80, '2024-12-12'),
(18, 47, 4, 60, '2024-12-16');

-- --------------------------------------------------------

--
-- Table structure for table `vaccine_type`
--

CREATE TABLE `vaccine_type` (
  `VACCINE_TYPE_ID` int(11) NOT NULL,
  `VACCINE_NAME` varchar(255) NOT NULL,
  `DESCRIPTION` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccine_type`
--

INSERT INTO `vaccine_type` (`VACCINE_TYPE_ID`, `VACCINE_NAME`, `DESCRIPTION`) VALUES
(1, 'ExMed 1', 'Ex Medicine'),
(2, 'Medicine 2', 'Medicine For'),
(3, 'MedYUmayu', 'Medicine For Nothing'),
(4, 'hemosep', 'Maryusip'),
(5, 'VACCi', 'Vaccine for Deworming'),
(6, 'COVID-19 Vaccine', 'Effective against COVID-19');

-- --------------------------------------------------------

--
-- Table structure for table `vaccine_usage`
--

CREATE TABLE `vaccine_usage` (
  `usage_id` int(11) NOT NULL,
  `VACCINE_ID` int(11) NOT NULL,
  `VACCINE_TYPE_ID` int(11) NOT NULL,
  `use_quantity` int(11) NOT NULL,
  `date_used` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccine_usage`
--

INSERT INTO `vaccine_usage` (`usage_id`, `VACCINE_ID`, `VACCINE_TYPE_ID`, `use_quantity`, `date_used`) VALUES
(8, 42, 6, 15, '2024-12-12'),
(9, 44, 4, 15, '2024-12-12'),
(10, 42, 6, 20, '2024-12-12'),
(11, 42, 6, 10, '2024-12-12'),
(12, 44, 4, 20, '2024-12-12'),
(13, 44, 4, 15, '2024-12-13'),
(14, 44, 4, 10, '2024-12-13'),
(15, 45, 4, 5, '2024-12-13'),
(16, 45, 4, 5, '2024-12-13'),
(17, 45, 4, 10, '2024-12-16'),
(18, 47, 4, 10, '2024-12-16'),
(19, 46, 5, 2, '2024-12-16'),
(20, 46, 5, 2, '2024-12-16'),
(21, 46, 5, 2, '2024-12-16'),
(22, 46, 5, 2, '2024-12-16'),
(23, 46, 5, 2, '2024-12-16'),
(24, 47, 4, 20, '2024-12-16'),
(25, 46, 5, 2, '2024-12-16');

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
  ADD PRIMARY KEY (`PAYMENT_ID`),
  ADD KEY `GIVE_TO` (`GIVE_TO`),
  ADD KEY `PAID_BY` (`PAID_BY`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`SCHEDULE_ID`),
  ADD KEY `VACCINE_ID` (`VACCINE_TYPE_ID`) USING BTREE;

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
-- Indexes for table `vaccine_details`
--
ALTER TABLE `vaccine_details`
  ADD PRIMARY KEY (`VACCINE_DETAILS_ID`),
  ADD KEY `VACCINE_CARD_ID` (`VACCINE_CARD_ID`),
  ADD KEY `SCHEDULE_ID` (`SCHEDULE_ID`);

--
-- Indexes for table `vaccine_history`
--
ALTER TABLE `vaccine_history`
  ADD PRIMARY KEY (`HISTORY_ID`);

--
-- Indexes for table `vaccine_type`
--
ALTER TABLE `vaccine_type`
  ADD PRIMARY KEY (`VACCINE_TYPE_ID`);

--
-- Indexes for table `vaccine_usage`
--
ALTER TABLE `vaccine_usage`
  ADD PRIMARY KEY (`usage_id`),
  ADD KEY `vaccine_id` (`VACCINE_ID`) USING BTREE;

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
  MODIFY `ANIMAL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `CLIENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `dispersal`
--
ALTER TABLE `dispersal`
  MODIFY `DISPERSAL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `parent`
--
ALTER TABLE `parent`
  MODIFY `PARENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=680;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `PAYMENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `SCHEDULE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vaccine`
--
ALTER TABLE `vaccine`
  MODIFY `VACCINE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `vaccine_card`
--
ALTER TABLE `vaccine_card`
  MODIFY `VACCINE_CARD_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vaccine_details`
--
ALTER TABLE `vaccine_details`
  MODIFY `VACCINE_DETAILS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vaccine_history`
--
ALTER TABLE `vaccine_history`
  MODIFY `HISTORY_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `vaccine_type`
--
ALTER TABLE `vaccine_type`
  MODIFY `VACCINE_TYPE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vaccine_usage`
--
ALTER TABLE `vaccine_usage`
  MODIFY `usage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
