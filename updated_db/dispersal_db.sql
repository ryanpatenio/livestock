-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2024 at 01:20 AM
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
  `fromClient` int(11) DEFAULT 0,
  `date_created` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animal`
--

INSERT INTO `animal` (`ANIMAL_ID`, `CLIENT_ID`, `BIRTHDATE`, `IMAGE_PATH`, `ANIMALTYPE`, `ANIMAL_SEX`, `isVaccinated`, `STATUS`, `VACCINE_CARD_ID`, `isPayment`, `fromClient`, `date_created`) VALUES
(139, 46, '2024-12-05', 'path_to_images/6765df7006148_cattle1.jpg', 'CATTLE', 'Male', '1', '1', 42, 0, 0, '2024-12-21'),
(140, 46, '2024-12-13', 'path_to_images/6765e3e4df9fd_cattle1.jpg', 'CATTLE', 'Female', '0', '1', 43, 0, 0, '2024-12-21'),
(141, 47, '2024-12-20', 'path_to_images/6765e42a4b97e_cattle1.jpg', 'CATTLE', 'Female', '0', '1', 44, 1, 46, '2024-12-21'),
(142, 48, '2024-12-05', 'path_to_images/6765f7b99b0c8_cattle1.jpg', 'GOAT', 'Male', '0', '1', 45, 0, 0, '2024-12-21'),
(143, 47, '2024-12-11', 'path_to_images/676606544888a_cattle1.jpg', 'CATTLE', 'Female', '0', '1', 46, 1, 46, NULL);

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
(46, 'Ryan', 'Wong', 'A', 'Farmer Assoc/', '00499399488', 'Brgy 2', '2024-12-21'),
(47, 'Jamela', 'Junkok', 'A', 'Farmer Assoc/', '99598688544', 'Brgy 2', '2024-12-21'),
(48, 'Raven', 'Koleb', 'R', 'Farmer Assoc/', '99598688544', 'Brgy 2', '2024-12-21');

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
  `PARENT_ANIMAL_ID` int(11) NOT NULL,
  `STATUS` varchar(150) NOT NULL COMMENT '1=Ongoing \r\n2=Finished '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dispersal`
--

INSERT INTO `dispersal` (`DISPERSAL_ID`, `CLIENT_ID`, `1ST_PAYMENT_ID`, `DATE_FIRST_PAYMENT`, `2ND_PAYMENT_ID`, `DATE_SECOND_PAYMENT`, `PARENT_ANIMAL_ID`, `STATUS`) VALUES
(55, 46, 1, '2024-12-21', 0, NULL, 140, 'PENDING');

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
(679, 31, 117),
(680, 31, 117),
(681, 28, 107),
(682, 15, 78),
(683, 15, 78),
(684, 15, 78),
(685, 15, 78),
(686, 15, 78),
(687, 15, 78),
(688, 15, 78),
(689, 15, 78),
(690, 15, 78),
(691, 15, 78),
(692, 15, 78),
(693, 15, 78),
(694, 15, 78),
(695, 15, 78),
(696, 15, 78),
(697, 15, 78),
(698, 15, 78),
(699, 15, 78),
(700, 15, 78),
(701, 15, 78),
(702, 15, 78),
(703, 15, 78),
(704, 15, 78),
(705, 15, 78),
(706, 15, 78),
(707, 15, 78),
(708, 15, 78),
(709, 15, 78),
(710, 15, 78),
(711, 15, 78),
(712, 15, 78),
(713, 15, 78),
(714, 15, 78),
(715, 15, 78),
(716, 15, 78),
(717, 15, 78),
(718, 15, 78),
(719, 15, 78),
(720, 15, 78),
(721, 15, 78),
(722, 15, 78),
(723, 15, 78),
(724, 15, 78),
(725, 15, 78),
(726, 15, 78),
(727, 15, 78),
(728, 15, 78),
(729, 15, 78),
(730, 15, 78),
(731, 15, 78),
(732, 15, 78),
(733, 15, 78),
(734, 15, 78),
(735, 15, 78),
(736, 15, 78),
(737, 15, 78),
(738, 15, 78),
(739, 15, 78),
(740, 15, 78),
(741, 15, 78),
(742, 15, 78),
(743, 15, 78),
(744, 15, 78),
(745, 15, 78),
(746, 15, 78),
(747, 15, 78),
(748, 15, 78),
(749, 15, 78),
(750, 15, 78),
(751, 15, 78),
(752, 15, 78),
(753, 15, 78),
(754, 15, 78),
(755, 15, 78),
(756, 15, 78),
(757, 15, 78),
(758, 15, 78),
(759, 14, 136),
(760, 45, 135),
(761, 27, 133),
(762, 46, 139),
(763, 46, 139),
(764, 46, 139),
(765, 47, 141),
(766, 46, 139),
(767, 47, 141),
(768, 46, 139),
(769, 46, 139),
(770, 46, 139),
(771, 46, 139),
(772, 46, 139),
(773, 46, 139);

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
(48, 55, 3534534, '2024-12-21', 46, 47, 'First Payment');

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
(71, 5, '1', 'DEWORMING 2', '2024-12-28', 46, '1', '1', '1', '1', '2024-12-20 21:30:52');

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
(46, 5, 67, '2025-04-23', '2024-12-12'),
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
(42, 139, '2024-12-21'),
(43, 140, '2024-12-21'),
(44, 141, '2024-12-21'),
(45, 142, '2024-12-21'),
(46, 143, '2024-12-21');

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
(11, 10, 69, '1'),
(12, 42, 71, '1');

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
(25, 46, 5, 2, '2024-12-16'),
(26, 46, 5, 1, '2024-12-21');

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
  MODIFY `ANIMAL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `CLIENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `dispersal`
--
ALTER TABLE `dispersal`
  MODIFY `DISPERSAL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `parent`
--
ALTER TABLE `parent`
  MODIFY `PARENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=774;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `PAYMENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `SCHEDULE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

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
  MODIFY `VACCINE_CARD_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `vaccine_details`
--
ALTER TABLE `vaccine_details`
  MODIFY `VACCINE_DETAILS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `usage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
