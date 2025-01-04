-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2025 at 05:45 AM
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
  `ACCOUNT_TYPE` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_type`
--

INSERT INTO `account_type` (`ID`, `ACCOUNT_TYPE`) VALUES
(1, 'ADMIN'),
(2, 'STAFF'),
(3, 'SUPER_ADMIN');

-- --------------------------------------------------------

--
-- Table structure for table `animal`
--

CREATE TABLE `animal` (
  `ANIMAL_ID` int(11) NOT NULL,
  `CLIENT_ID` int(11) NOT NULL,
  `BIRTHDATE` date NOT NULL,
  `IMAGE_PATH` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
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

INSERT INTO `animal` (`ANIMAL_ID`, `CLIENT_ID`, `BIRTHDATE`, `IMAGE_PATH`, `category_id`, `ANIMAL_SEX`, `isVaccinated`, `STATUS`, `VACCINE_CARD_ID`, `isPayment`, `fromClient`, `date_created`) VALUES
(185, 62, '2024-09-12', 'path_to_images/6778b295bbf84_goat.jpg', 2, 'Female', '1', '1', 88, 0, 0, '2025-01-04'),
(186, 62, '2025-01-10', 'path_to_images/6778b33b4e72b_goat.jpg', 2, 'Female', '0', '1', 89, 0, 0, '2025-01-04'),
(187, 63, '2024-10-10', 'path_to_images/6778b3c1b7051_goat.jpg', 2, 'Male', '0', '1', 90, 1, 62, '2025-01-04');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL DEFAULT '0',
  `status` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `status`) VALUES
(1, 'Cattle', '0'),
(2, 'Goats', '0');

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
(62, 'Mark', 'Heaven', 'A', 'Farmer Assoc', '09499498583', 'Brgy Camindajao', '2025-01-04'),
(63, 'Henry', 'Saber', 'S', 'Farmer Assoc', '09484883847', 'Brgy Bugagaw', '2025-01-04');

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
  `STATUS` varchar(150) NOT NULL COMMENT '1=Ongoing \r\n2=Finished ',
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dispersal`
--

INSERT INTO `dispersal` (`DISPERSAL_ID`, `CLIENT_ID`, `1ST_PAYMENT_ID`, `DATE_FIRST_PAYMENT`, `2ND_PAYMENT_ID`, `DATE_SECOND_PAYMENT`, `PARENT_ANIMAL_ID`, `STATUS`, `date_created`) VALUES
(70, 62, 1, '2025-01-04', 0, NULL, 185, 'PENDING', '2025-01-04');

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
(773, 46, 139),
(774, 46, 139),
(775, 47, 141),
(776, 48, 142),
(777, 46, 139),
(778, 47, 141),
(779, 46, 139),
(780, 46, 139),
(781, 46, 139),
(782, 46, 139),
(783, 46, 139),
(784, 46, 139),
(785, 46, 139),
(786, 46, 139),
(787, 46, 139),
(788, 46, 139),
(789, 46, 139),
(790, 46, 139),
(791, 46, 139),
(792, 46, 139),
(793, 46, 139),
(794, 46, 139),
(795, 46, 139),
(796, 46, 139),
(797, 46, 139),
(798, 46, 139),
(799, 46, 139),
(800, 46, 139),
(801, 46, 139),
(802, 46, 139),
(803, 46, 139),
(804, 46, 139),
(805, 46, 139),
(806, 46, 139),
(807, 46, 139),
(808, 46, 139),
(809, 46, 139),
(810, 46, 139),
(811, 46, 139),
(812, 46, 139),
(813, 49, 151),
(814, 46, 139),
(815, 46, 139),
(816, 46, 139),
(817, 46, 139),
(818, 46, 139),
(819, 46, 139),
(820, 46, 139),
(821, 46, 139),
(822, 50, 152),
(823, 47, 141),
(824, 47, 141),
(825, 46, 139),
(826, 46, 139),
(827, 46, 139),
(828, 46, 139),
(829, 46, 139),
(830, 46, 139),
(831, 46, 139),
(832, 46, 139),
(833, 46, 139),
(834, 46, 139),
(835, 46, 139),
(836, 51, 154),
(837, 51, 154),
(838, 51, 154),
(839, 51, 154),
(840, 46, 139),
(841, 46, 139),
(842, 51, 154),
(843, 46, 139),
(844, 46, 139),
(845, 46, 139),
(846, 46, 139),
(847, 46, 139),
(848, 46, 139),
(849, 51, 154),
(850, 46, 139),
(851, 46, 139),
(852, 46, 139),
(853, 46, 139),
(854, 46, 139),
(855, 46, 139),
(856, 51, 154),
(857, 46, 139),
(858, 51, 154),
(859, 51, 154),
(860, 46, 139),
(861, 46, 139),
(862, 46, 139),
(863, 46, 139),
(864, 47, 141),
(865, 51, 154),
(866, 51, 154),
(867, 46, 139),
(868, 46, 139),
(869, 51, 154),
(870, 51, 154),
(871, 51, 154),
(872, 51, 154),
(873, 51, 154),
(874, 51, 154),
(875, 47, 141),
(876, 51, 154),
(877, 52, 158),
(878, 47, 141),
(879, 48, 142),
(880, 51, 154),
(881, 51, 154),
(882, 51, 154),
(883, 51, 154),
(884, 51, 154),
(885, 51, 154),
(886, 51, 154),
(887, 51, 154),
(888, 51, 154),
(889, 51, 154),
(890, 51, 154),
(891, 51, 154),
(892, 51, 154),
(893, 51, 154),
(894, 51, 154),
(895, 51, 154),
(896, 51, 154),
(897, 51, 154),
(898, 51, 154),
(899, 51, 154),
(900, 51, 154),
(901, 49, 159),
(902, 49, 159),
(903, 49, 159),
(904, 52, 158),
(905, 50, 152),
(906, 48, 142),
(907, 49, 159),
(908, 53, 161),
(909, 53, 161),
(910, 53, 161),
(911, 53, 161),
(912, 53, 161),
(913, 53, 161),
(914, 53, 161),
(915, 54, 162),
(916, 55, 163),
(917, 53, 161),
(918, 53, 161),
(919, 53, 161),
(920, 54, 162),
(921, 55, 163),
(922, 53, 161),
(923, 54, 162),
(924, 53, 161),
(925, 54, 162),
(926, 55, 163),
(927, 54, 162),
(928, 53, 161),
(929, 53, 161),
(930, 54, 162),
(931, 55, 163),
(932, 53, 161),
(933, 53, 161),
(934, 54, 162),
(935, 55, 163),
(936, 54, 162),
(937, 53, 161),
(938, 54, 162),
(939, 55, 163),
(940, 53, 161),
(941, 54, 162),
(942, 54, 162),
(943, 54, 162),
(944, 54, 162),
(945, 54, 162),
(946, 54, 162),
(947, 54, 162),
(948, 54, 162),
(949, 54, 162),
(950, 54, 162),
(951, 53, 161),
(952, 54, 162),
(953, 57, 167),
(954, 55, 163),
(955, 55, 163),
(956, 55, 163),
(957, 55, 163),
(958, 55, 163),
(959, 55, 163),
(960, 54, 162),
(961, 53, 161),
(962, 54, 162),
(963, 54, 162),
(964, 54, 162),
(965, 54, 162),
(966, 54, 162),
(967, 54, 162),
(968, 54, 162),
(969, 54, 162),
(970, 53, 161),
(971, 54, 162),
(972, 58, 169),
(973, 55, 163),
(974, 55, 163),
(975, 55, 163),
(976, 55, 163),
(977, 55, 163),
(978, 55, 163),
(979, 55, 163),
(980, 55, 163),
(981, 55, 163),
(982, 55, 163),
(983, 55, 163),
(984, 55, 163),
(985, 55, 163),
(986, 55, 163),
(987, 55, 163),
(988, 55, 163),
(989, 55, 163),
(990, 55, 163),
(991, 55, 163),
(992, 55, 163),
(993, 55, 163),
(994, 55, 163),
(995, 55, 163),
(996, 55, 163),
(997, 55, 163),
(998, 55, 163),
(999, 55, 163),
(1000, 55, 163),
(1001, 55, 163),
(1002, 55, 163),
(1003, 55, 163),
(1004, 55, 163),
(1005, 55, 163),
(1006, 59, 172),
(1007, 53, 161),
(1008, 58, 169),
(1009, 59, 172),
(1010, 59, 172),
(1011, 55, 163),
(1012, 55, 163),
(1013, 55, 163),
(1014, 55, 163),
(1015, 55, 163),
(1016, 55, 163),
(1017, 55, 163),
(1018, 55, 163),
(1019, 55, 163),
(1020, 55, 163),
(1021, 55, 163),
(1022, 55, 163),
(1023, 55, 163),
(1024, 55, 163),
(1025, 55, 163),
(1026, 55, 163),
(1027, 55, 163),
(1028, 55, 163),
(1029, 55, 163),
(1030, 55, 163),
(1031, 55, 163),
(1032, 55, 163),
(1033, 55, 163),
(1034, 55, 163),
(1035, 55, 163),
(1036, 55, 163),
(1037, 55, 163),
(1038, 62, 185),
(1039, 62, 185),
(1040, 62, 185),
(1041, 62, 185),
(1042, 62, 185),
(1043, 62, 185),
(1044, 62, 185);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PAYMENT_ID` int(11) NOT NULL,
  `DISPERSAL_ID` int(11) NOT NULL,
  `OR_PAYMENT_NO` varchar(50) NOT NULL,
  `DATE` date NOT NULL,
  `PAID_BY` int(11) NOT NULL,
  `GIVE_TO` int(11) NOT NULL,
  `PAYMENT_STATUS` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`PAYMENT_ID`, `DISPERSAL_ID`, `OR_PAYMENT_NO`, `DATE`, `PAID_BY`, `GIVE_TO`, `PAYMENT_STATUS`) VALUES
(85, 70, 'SOO03048884', '2025-01-04', 62, 63, 'First Payment');

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
(79, 4, '1', 'Vaccination', '2025-01-05', 62, '1', '1', '1', '1', '2025-01-04 04:01:48');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `FULL_NAME` varchar(255) NOT NULL,
  `USERNAME` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `ACCOUNT_TYPE_ID` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `FULL_NAME`, `USERNAME`, `PASSWORD`, `ACCOUNT_TYPE_ID`, `status`) VALUES
(4, 'RMAS', 'Staff', 'Staff', 2, 0),
(5, 'HER', 'Admin', 'Admin', 1, 0),
(6, 'Ryan Wong', 'ryanwong', '$2y$10$HmEtuUy3SJXnRyGqtBDlSOyXOV5j2mvLKMhljImiIzsR4TqiDNRBK', 1, 0),
(7, 'update 2', 'user1', '$2y$10$x/RQ/97DUwxnQrJXQTu5je98RQWJjLDGLRNoMCdIDU5aYwyINNb9i', 2, 0),
(8, 'kongwe', 'ryanwong1', '$2y$10$MD6e0sxFdTgO5l06.V.nLe65MyFGpZ6a1f8NEo/Sh9tLJXh8HllC2', 2, 0);

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
(48, 4, 98, '2026-10-06', '2025-01-04'),
(49, 5, 99, '2026-04-01', '2025-01-04'),
(50, 1, 100, '2026-02-04', '2025-01-04');

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
(88, 185, '2025-01-04'),
(89, 186, '2025-01-04'),
(90, 187, '2025-01-04');

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
(16, 88, 79, '1');

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
(19, 48, 4, 99, '2025-01-04'),
(20, 49, 5, 99, '2025-01-04'),
(21, 50, 1, 100, '2025-01-04');

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
(30, 48, 4, 1, '2025-01-04');

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
  ADD PRIMARY KEY (`ANIMAL_ID`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `animal`
--
ALTER TABLE `animal`
  MODIFY `ANIMAL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `CLIENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `dispersal`
--
ALTER TABLE `dispersal`
  MODIFY `DISPERSAL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `parent`
--
ALTER TABLE `parent`
  MODIFY `PARENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1045;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `PAYMENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `SCHEDULE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vaccine`
--
ALTER TABLE `vaccine`
  MODIFY `VACCINE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `vaccine_card`
--
ALTER TABLE `vaccine_card`
  MODIFY `VACCINE_CARD_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `vaccine_details`
--
ALTER TABLE `vaccine_details`
  MODIFY `VACCINE_DETAILS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `vaccine_history`
--
ALTER TABLE `vaccine_history`
  MODIFY `HISTORY_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `vaccine_type`
--
ALTER TABLE `vaccine_type`
  MODIFY `VACCINE_TYPE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vaccine_usage`
--
ALTER TABLE `vaccine_usage`
  MODIFY `usage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
