-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 04, 2026 at 12:22 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ds_letter_handling`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily_letter_register`
--

DROP TABLE IF EXISTS `daily_letter_register`;
CREATE TABLE IF NOT EXISTS `daily_letter_register` (
  `register_id` int NOT NULL AUTO_INCREMENT,
  `letter_id` int NOT NULL,
  `register_date` date NOT NULL,
  PRIMARY KEY (`register_id`),
  KEY `letter_id` (`letter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `daily_letter_register`
--

INSERT INTO `daily_letter_register` (`register_id`, `letter_id`, `register_date`) VALUES
(1, 1, '2026-03-02'),
(2, 2, '2026-03-02'),
(3, 3, '2026-03-02'),
(4, 4, '2026-03-02'),
(5, 5, '2026-03-02'),
(6, 6, '2026-03-02'),
(7, 7, '2026-03-02'),
(8, 8, '2026-03-03'),
(9, 9, '2026-03-03'),
(10, 10, '2026-03-03'),
(11, 11, '2026-03-03'),
(12, 12, '2026-03-03'),
(13, 13, '2026-03-03'),
(14, 14, '2026-03-04'),
(15, 15, '2026-03-04'),
(16, 16, '2026-03-04');

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

DROP TABLE IF EXISTS `district`;
CREATE TABLE IF NOT EXISTS `district` (
  `district_id` int NOT NULL AUTO_INCREMENT,
  `district_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `province_id` int DEFAULT NULL,
  PRIMARY KEY (`district_id`),
  KEY `fk_districts_province` (`province_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`district_id`, `district_name`, `province_id`) VALUES
(1, 'Ampara', 5),
(2, 'Anuradhapura', 7),
(3, 'Badulla', 8),
(4, 'Batticaloa', 5),
(5, 'Colombo', 1),
(6, 'Galle', 3),
(7, 'Gampaha', 1),
(8, 'Hambantota', 3),
(9, 'Jaffna', 4),
(10, 'Kalutara', 1),
(11, 'Kandy', 2),
(12, 'Kegalle', 9),
(13, 'Kilinochchi', 4),
(14, 'Kurunegala', 6),
(15, 'Mannar', 4),
(16, 'Matale', 2),
(17, 'Matara', 3),
(18, 'Monaragala', 8),
(19, 'Mullaitivu', 4),
(20, 'Nuwara Eliya', 2),
(21, 'Polonnaruwa', 7),
(22, 'Puttalam', 6),
(23, 'Ratnapura', 9),
(24, 'Trincomalee', 5),
(25, 'Vavuniya', 4);

-- --------------------------------------------------------

--
-- Table structure for table `dsdivision`
--

DROP TABLE IF EXISTS `dsdivision`;
CREATE TABLE IF NOT EXISTS `dsdivision` (
  `dsid` int NOT NULL AUTO_INCREMENT,
  `dsname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `district_id` int DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`dsid`),
  KEY `fk_ds_division_district` (`district_id`)
) ENGINE=InnoDB AUTO_INCREMENT=330 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `dsdivision`
--

INSERT INTO `dsdivision` (`dsid`, `dsname`, `district_id`, `email`) VALUES
(1, 'Addalaichenai', 1, NULL),
(2, 'Akkaraipattu', 1, NULL),
(3, 'Alayadiwembu', 1, NULL),
(4, 'Damana', 1, NULL),
(5, 'Dehiattakandiya', 1, NULL),
(6, 'Irakkamam', 1, NULL),
(7, 'Kalmunai', 1, NULL),
(8, 'Lahugala', 1, NULL),
(9, 'Mahaoya', 1, NULL),
(10, 'Navithanveli', 1, NULL),
(11, 'Ninthavur', 1, NULL),
(12, 'Padiyathalawa', 1, NULL),
(13, 'Sainthamaruthu', 1, NULL),
(14, 'Samanthurai', 1, NULL),
(15, 'Thirukkovil', 1, NULL),
(16, 'Uhana', 1, NULL),
(18, 'Galenbindunuwewa', 2, NULL),
(19, 'Galnewa', 2, NULL),
(20, 'Horowpothana', 2, NULL),
(21, 'Ipalogama', 2, NULL),
(22, 'Kahatagasdigiliya', 2, NULL),
(23, 'Kebithigollewa', 2, NULL),
(24, 'Mahavilachchiya', 2, NULL),
(25, 'Mihintale', 2, NULL),
(26, 'Nochchiyagama', 2, NULL),
(27, 'Nuwaragam Palatha Central', 2, NULL),
(28, 'Nuwaragam Palatha East', 2, NULL),
(29, 'Palagala', 2, NULL),
(30, 'Palugaswewa', 2, NULL),
(31, 'Rajanganaya', 2, 'moha.divi.rajanganaya@gmail.com'),
(32, 'Rambewa', 2, NULL),
(33, 'Thalawa', 2, NULL),
(34, 'Thambuttegama', 2, NULL),
(35, 'Kekirawa', 2, NULL),
(36, 'Badulla', 3, NULL),
(37, 'Bandarawela', 3, NULL),
(38, 'Ella', 3, NULL),
(39, 'Haldummulla', 3, NULL),
(40, 'Hali-Ela', 3, NULL),
(41, 'Haputale', 3, NULL),
(42, 'Lunugala', 3, NULL),
(43, 'Mahiyanganaya', 3, NULL),
(44, 'Meegahakivula', 3, NULL),
(45, 'Passara', 3, NULL),
(46, 'Rideemaliyadda', 3, NULL),
(47, 'Soranatota', 3, NULL),
(48, 'Uva Paranagama', 3, NULL),
(49, 'Welimada', 3, NULL),
(50, 'Batticaloa', 4, NULL),
(51, 'Eravur Pattu', 4, NULL),
(52, 'Eravur Town', 4, NULL),
(53, 'Kattankudy', 4, NULL),
(54, 'Koralai Pattu', 4, NULL),
(55, 'Koralai Pattu North', 4, NULL),
(56, 'Koralai Pattu South', 4, NULL),
(57, 'Koralai Pattu West', 4, NULL),
(58, 'Manmunai North', 4, NULL),
(59, 'Manmunai Pattu', 4, NULL),
(60, 'Manmunai South and Eruvil Pattu', 4, NULL),
(61, 'Manmunai South West', 4, NULL),
(62, 'Porativu Pattu', 4, NULL),
(63, 'Akurassa', 6, NULL),
(64, 'Ambalangoda', 6, NULL),
(65, 'Baddegama', 6, NULL),
(66, 'Balapitiya', 6, NULL),
(67, 'Benthota', 6, NULL),
(68, 'Elpitiya', 6, NULL),
(69, 'Galle Four Gravets', 6, NULL),
(70, 'Gonapinuwala', 6, NULL),
(71, 'Habaraduwa', 6, NULL),
(72, 'Hiniduma', 6, NULL),
(73, 'Imaduwa', 6, NULL),
(74, 'Karandeniya', 6, NULL),
(75, 'Nagoda', 6, NULL),
(76, 'Neluwa', 6, NULL),
(77, 'Thawalama', 6, NULL),
(78, 'Welivitiya Divithura', 6, NULL),
(79, 'Yakkalamulla', 6, NULL),
(80, 'Attanagalla', 7, NULL),
(81, 'Biyagama', 7, NULL),
(82, 'Divulapitiya', 7, NULL),
(83, 'Dompe', 7, NULL),
(84, 'Gampaha', 7, NULL),
(85, 'Ja-Ela', 7, NULL),
(86, 'Kelaniya', 7, NULL),
(87, 'Mahara', 7, NULL),
(88, 'Minuwangoda', 7, NULL),
(89, 'Mirigama', 7, NULL),
(90, 'Negombo', 7, NULL),
(91, 'Wattala', 7, NULL),
(92, 'Katana', 7, NULL),
(93, 'Ambalantota', 8, NULL),
(94, 'Angunakolapelessa', 8, NULL),
(95, 'Beliatta', 8, NULL),
(96, 'Hambantota', 8, NULL),
(97, 'Katuwana', 8, NULL),
(98, 'Lunugamvehera', 8, NULL),
(99, 'Okewela', 8, NULL),
(100, 'Sooriyawewa', 8, NULL),
(101, 'Tangalle', 8, NULL),
(102, 'Tissamaharama', 8, NULL),
(103, 'Walasmulla', 8, NULL),
(104, 'Weeraketiya', 8, NULL),
(105, 'Colombo', 5, NULL),
(106, 'Dehiwala', 5, NULL),
(107, 'Homagama', 5, NULL),
(108, 'Kaduwela', 5, NULL),
(109, 'Kesbewa', 5, NULL),
(110, 'Kolonnawa', 5, NULL),
(111, 'Maharagama', 5, NULL),
(112, 'Moratuwa', 5, NULL),
(113, 'Padukka', 5, NULL),
(114, 'Ratmalana', 5, NULL),
(115, 'Seethawaka', 5, NULL),
(116, 'Sri Jayawardenepura Kotte', 5, NULL),
(117, 'Thimbirigasyaya', 5, NULL),
(118, 'Hanwella', 5, NULL),
(119, 'Boralesgamuwa', 5, NULL),
(120, 'Delft', 9, NULL),
(121, 'Island North', 9, NULL),
(122, 'Island South', 9, NULL),
(123, 'Jaffna', 9, NULL),
(124, 'Karainagar', 9, NULL),
(125, 'Nallur', 9, NULL),
(126, 'Sandilipay', 9, NULL),
(127, 'Tellippalai', 9, NULL),
(128, 'Uduvil', 9, NULL),
(129, 'Valikamam East', 9, NULL),
(130, 'Valikamam North', 9, NULL),
(131, 'Valikamam South', 9, NULL),
(132, 'Valikamam West', 9, NULL),
(133, 'Vadamarachchi East', 9, NULL),
(134, 'Vadamarachchi North', 9, NULL),
(135, 'Vadamarachchi South West', 9, NULL),
(136, 'Agalawatta', 10, NULL),
(137, 'Bandaragama', 10, NULL),
(138, 'Beruwala', 10, NULL),
(139, 'Bulathsinhala', 10, NULL),
(140, 'Dodangoda', 10, NULL),
(141, 'Horana', 10, NULL),
(142, 'Ingiriya', 10, NULL),
(143, 'Kalutara', 10, NULL),
(144, 'Madurawala', 10, NULL),
(145, 'Matugama', 10, NULL),
(146, 'Millaniya', 10, NULL),
(147, 'Panadura', 10, NULL),
(148, 'Palindanuwara', 10, NULL),
(149, 'Walallavita', 10, NULL),
(150, 'Akurana', 11, NULL),
(151, 'Delthota', 11, NULL),
(152, 'Doluwa', 11, NULL),
(153, 'Gangawata Korale', 11, NULL),
(154, 'Ganga Ihala Korale', 11, NULL),
(155, 'Harispattuwa', 11, NULL),
(156, 'Hatharaliyadda', 11, NULL),
(157, 'Kundasale', 11, NULL),
(158, 'Medadumbara', 11, NULL),
(159, 'Minipe', 11, NULL),
(160, 'Panvila', 11, NULL),
(161, 'Pasbage Korale', 11, NULL),
(162, 'Pathadumbara', 11, NULL),
(163, 'Pathahewaheta', 11, NULL),
(164, 'Poojapitiya', 11, NULL),
(165, 'Thumpane', 11, NULL),
(166, 'Udadumbara', 11, NULL),
(167, 'Udapalatha', 11, NULL),
(168, 'Udunuwara', 11, NULL),
(169, 'Yatinuwara', 11, NULL),
(170, 'Aranayaka', 12, NULL),
(171, 'Bulathkohupitiya', 12, NULL),
(172, 'Dehiovita', 12, NULL),
(173, 'Deraniyagala', 12, NULL),
(174, 'Galigamuwa', 12, NULL),
(175, 'Kegalle', 12, NULL),
(176, 'Mawanella', 12, NULL),
(177, 'Rambukkana', 12, NULL),
(178, 'Ruwanwella', 12, NULL),
(179, 'Warakapola', 12, NULL),
(180, 'Yatiyanthota', 12, NULL),
(181, 'Kandavalai', 13, NULL),
(182, 'Karachchi', 13, NULL),
(183, 'Pachchilaipalli', 13, NULL),
(184, 'Poonakary', 13, NULL),
(185, 'Alawwa', 14, NULL),
(186, 'Ambanpola', 14, NULL),
(187, 'Bamunakotuwa', 14, NULL),
(188, 'Bingiriya', 14, NULL),
(189, 'Ehetuwewa', 14, NULL),
(190, 'Galgamuwa', 14, NULL),
(191, 'Ganewatta', 14, NULL),
(192, 'Giribawa', 14, NULL),
(193, 'Ibbagamuwa', 14, NULL),
(194, 'Katupotha', 14, NULL),
(195, 'Kobeigane', 14, NULL),
(196, 'Kotavehera', 14, NULL),
(197, 'Kuliyapitiya East', 14, NULL),
(198, 'Kuliyapitiya West', 14, NULL),
(199, 'Kurunegala', 14, NULL),
(200, 'Mahawa', 14, NULL),
(201, 'Mallawapitiya', 14, NULL),
(202, 'Maspotha', 14, NULL),
(203, 'Mawathagama', 14, NULL),
(204, 'Narammala', 14, NULL),
(205, 'Nikaweratiya', 14, NULL),
(206, 'Panduwasnuwara', 14, NULL),
(207, 'Pannala', 14, NULL),
(208, 'Polgahawela', 14, NULL),
(209, 'Polpithigama', 14, NULL),
(210, 'Rasnayakapura', 14, NULL),
(211, 'Rideegama', 14, NULL),
(212, 'Udubaddawa', 14, NULL),
(213, 'Wariyapola', 14, NULL),
(214, 'Weerambugedara', 14, NULL),
(215, 'Madhu', 15, NULL),
(216, 'Mannar', 15, NULL),
(217, 'Manthai West', 15, NULL),
(218, 'Musalai', 15, NULL),
(219, 'Nanaddan', 15, NULL),
(220, 'Ambanganga Korale', 16, NULL),
(221, 'Dambulla', 16, NULL),
(222, 'Galewela', 16, NULL),
(223, 'Laggala-Pallegama', 16, NULL),
(224, 'Matale', 16, NULL),
(225, 'Naula', 16, NULL),
(226, 'Pallepola', 16, NULL),
(227, 'Rattota', 16, NULL),
(228, 'Ukuwela', 16, NULL),
(229, 'Wilgamuwa', 16, NULL),
(230, 'Yatawatta', 16, NULL),
(231, 'Akuressa', 17, NULL),
(232, 'Athuraliya', 17, NULL),
(233, 'Devinuwara', 17, NULL),
(234, 'Dickwella', 17, NULL),
(235, 'Hakmana', 17, NULL),
(236, 'Kamburupitiya', 17, NULL),
(237, 'Kirinda Puhulwella', 17, NULL),
(238, 'Kotapola', 17, NULL),
(239, 'Malimbada', 17, NULL),
(240, 'Matara', 17, NULL),
(241, 'Mulatiyana', 17, NULL),
(242, 'Pasgoda', 17, NULL),
(243, 'Pitabeddara', 17, NULL),
(244, 'Thihagoda', 17, NULL),
(245, 'Weligama', 17, NULL),
(246, 'Welipitiya', 17, NULL),
(247, 'Badalkumbura', 18, NULL),
(248, 'Bibile', 18, NULL),
(249, 'Buttala', 18, NULL),
(250, 'Katharagama', 18, NULL),
(251, 'Madulla', 18, NULL),
(252, 'Medagama', 18, NULL),
(253, 'Moneragala', 18, NULL),
(254, 'Sevanagala', 18, NULL),
(255, 'Siyambalanduwa', 18, NULL),
(256, 'Thanamalvila', 18, NULL),
(257, 'Wellawaya', 18, NULL),
(258, 'Manthai East', 19, NULL),
(259, 'Maritimepattu', 19, NULL),
(260, 'Oddusuddan', 19, NULL),
(261, 'Puthukudiyiruppu', 19, NULL),
(262, 'Thunukkai', 19, NULL),
(263, 'Welioya', 19, NULL),
(264, 'Ambagamuwa', 20, NULL),
(265, 'Hanguranketha', 20, NULL),
(266, 'Kothmale', 20, NULL),
(267, 'Nuwara Eliya', 20, NULL),
(268, 'Walapane', 20, NULL),
(269, 'Norwood', 20, NULL),
(270, 'Kothmale West', 20, NULL),
(271, 'Nildandahinna', 20, NULL),
(272, 'Thalawakale', 20, NULL),
(273, 'Mathurata', 20, NULL),
(274, 'Dimbulagala', 21, NULL),
(275, 'Elahera', 21, NULL),
(276, 'Hingurakgoda', 21, NULL),
(277, 'Lankapura', 21, NULL),
(278, 'Medirigiriya', 21, NULL),
(279, 'Thamankaduwa', 21, NULL),
(280, 'Welikanda', 21, NULL),
(281, 'Anamaduwa', 22, NULL),
(282, 'Arachchikattuwa', 22, NULL),
(283, 'Chilaw', 22, NULL),
(284, 'Dankotuwa', 22, 'divsecdankotuwa@gmail.com'),
(285, 'Kalpitiya', 22, NULL),
(286, 'Karuwalagaswewa', 22, NULL),
(287, 'Madampe', 22, NULL),
(288, 'Mahakumbukkadawala', 22, NULL),
(289, 'Mahawewa', 22, NULL),
(290, 'Mundalama', 22, NULL),
(291, 'Nattandiya', 22, NULL),
(292, 'Nawagattegama', 22, NULL),
(293, 'Pallama', 22, NULL),
(294, 'Puttalam', 22, NULL),
(295, 'Vanathavilluwa', 22, NULL),
(296, 'Wennappuwa', 22, NULL),
(297, 'Ayagama', 23, NULL),
(298, 'Balangoda', 23, NULL),
(299, 'Eheliyagoda', 23, NULL),
(300, 'Elapattha', 23, NULL),
(301, 'Embilipitiya', 23, NULL),
(302, 'Godakawela', 23, NULL),
(303, 'Imbulpe', 23, NULL),
(304, 'Kahawatta', 23, NULL),
(305, 'Kalawana', 23, NULL),
(306, 'Kiriella', 23, NULL),
(307, 'Kolonna', 23, NULL),
(308, 'Kuruvita', 23, NULL),
(309, 'Nivithigala', 23, NULL),
(310, 'Opanayaka', 23, NULL),
(311, 'Pelmadulla', 23, NULL),
(312, 'Ratnapura', 23, NULL),
(313, 'Weligepola', 23, NULL),
(314, 'Gomarankadawala', 24, NULL),
(315, 'Kantalai', 24, NULL),
(316, 'Kinniya', 24, NULL),
(317, 'Kuchchaveli', 24, NULL),
(318, 'Morawewa', 24, NULL),
(319, 'Muttur', 24, NULL),
(320, 'Padaviya', 24, NULL),
(321, 'Seruvila', 24, NULL),
(322, 'Thambalagamuwa', 24, NULL),
(323, 'Trincomalee', 24, NULL),
(324, 'Verugal', 24, NULL),
(325, 'Vavuniya', 25, NULL),
(326, 'Vavuniya North', 25, NULL),
(327, 'Vavuniya South', 25, NULL),
(328, 'Vengalacheddikulam', 25, NULL),
(329, 'Madawachchiya', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

DROP TABLE IF EXISTS `leaves`;
CREATE TABLE IF NOT EXISTS `leaves` (
  `leave_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `leave_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `leafsheet` enum('Pending','Approved','Rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'Pending',
  `applied_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `approved_by` int DEFAULT NULL,
  PRIMARY KEY (`leave_id`),
  KEY `fk_leaves_user` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `letters`
--

DROP TABLE IF EXISTS `letters`;
CREATE TABLE IF NOT EXISTS `letters` (
  `letter_id` int NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `file_number` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `recipient_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `recipient_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `post_type` enum('Normal','Registered') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `section_id` int NOT NULL,
  `dsid` int DEFAULT NULL,
  `created_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`letter_id`),
  KEY `section_id` (`section_id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `letters`
--

INSERT INTO `letters` (`letter_id`, `subject`, `file_number`, `recipient_name`, `recipient_address`, `post_type`, `section_id`, `dsid`, `created_by`, `created_at`) VALUES
(1, 'Regarding subsidy application', '111', 'Anura Bandara', 'colombo', 'Registered', 1, 31, 2, '2026-03-02 12:02:32'),
(2, 'praposal', '112', 'kelum', 'kandy', 'Normal', 1, 31, 2, '2026-03-02 12:03:01'),
(3, 'landing', '114', 'samadi', 'gampaha', 'Normal', 1, 31, 5, '2026-03-02 12:03:51'),
(4, 'Samurdhi beneficiary approval letter', '112', 'Kamal Franando', 'matara', 'Normal', 5, 200, 7, '2026-03-02 12:04:43'),
(5, 'Aswesuma', '115', 'upali', 'colombo', 'Registered', 5, 200, 7, '2026-03-02 12:05:11'),
(6, 'Aswesuma', '333', 'upali', 'kandy', 'Registered', 1, 31, 2, '2026-03-02 12:27:53'),
(7, 'Aswesuma', '115', 'kelum', 'colombo', 'Registered', 10, 31, 5, '2026-03-02 12:34:04'),
(8, 'loan', '6675', 'franando', 'anuradhapura', 'Registered', 1, 31, 2, '2026-03-03 03:58:01'),
(9, 'subasadhana', '4456', 'yasitha', 'colombo', 'Normal', 10, 31, 5, '2026-03-03 03:59:21'),
(10, 'landing', '4444', 'lakshitha', 'gampola', 'Registered', 10, 31, 5, '2026-03-03 04:00:07'),
(11, 'Samurdhi beneficiary approval letter', '666', 'costha', 'kandy', 'Normal', 1, 31, 2, '2026-03-03 16:02:56'),
(12, 'account mail', '4567', 'gamini', 'labuduuwa', 'Normal', 10, 31, 5, '2026-03-03 16:05:51'),
(13, 'course details', '1265', 'anurada', 'kelaniya', 'Registered', 5, 200, 7, '2026-03-03 16:07:04'),
(14, 'Samurdhi beneficiary approval letter', '4456', 'anura', 'kandy', 'Normal', 1, 31, 2, '2026-03-04 09:23:30'),
(15, 'Aswesuma', '547', 'samadi', 'colombo', 'Registered', 10, 31, 5, '2026-03-04 09:24:24'),
(16, 'Samurdhi beneficiary approval letter', '8876', 'kelum', 'colombo', 'Normal', 5, 200, 7, '2026-03-04 12:17:57');

-- --------------------------------------------------------

--
-- Table structure for table `ministries`
--

DROP TABLE IF EXISTS `ministries`;
CREATE TABLE IF NOT EXISTS `ministries` (
  `ministry_id` int NOT NULL AUTO_INCREMENT,
  `ministry_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`ministry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `ministries`
--

INSERT INTO `ministries` (`ministry_id`, `ministry_name`) VALUES
(1, 'Ministry of Defence'),
(2, 'Ministry of Finance, Planning and Economic Development'),
(3, 'Ministry of Energy'),
(4, 'Ministry of Agriculture, Livestock, Land, and Irrigation'),
(5, 'Ministry of Justice and National Integration'),
(6, 'Ministry of Education, Higher Education and Vocational Education'),
(7, 'Ministry of Women and Child Affairs'),
(8, 'Ministry of Trade, Commerce, Food Security and Co-operative Development'),
(9, 'Ministry of Health and Mass Media'),
(10, 'Ministry of Buddhasasana, Religious and Cultural Affairs'),
(11, 'Ministry of Transport, Highways, Ports and Civil Aviation'),
(12, 'Ministry of Public Security and Parliamentary Affairs'),
(13, 'Ministry of Foreign Affairs, Foreign Employment and Tourism'),
(14, 'Ministry of Environment'),
(15, 'Ministry of Urban Development, Construction and Housing'),
(16, 'Ministry of Industry and Entrepreneurship Development'),
(17, 'Ministry of Rural Development, Social Security, and Community Empowerment'),
(18, 'Ministry of Science and Technology'),
(19, 'Ministry of Labour'),
(20, 'Ministry of Plantation and Community Infrastructure'),
(21, 'Ministry of Public Administration, Provincial Councils and Local Government'),
(22, 'Ministry of Fisheries, Aquatic and Ocean Resources'),
(23, 'Ministry of Digital Economy'),
(24, 'Ministry of Youth Affairs and Sports'),
(25, 'North Central Provincial Council'),
(26, 'North Western Provincial Council'),
(27, 'Northern Provincial Council'),
(28, 'Southern Provincial Council'),
(29, 'Central Provincial Council'),
(30, 'Western Provincial Council'),
(31, 'Uva Provincial Council'),
(32, 'Eastern Provincial Council'),
(33, 'Sabaragamuwa Provincial Council');

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

DROP TABLE IF EXISTS `provinces`;
CREATE TABLE IF NOT EXISTS `provinces` (
  `province_id` int NOT NULL AUTO_INCREMENT,
  `province_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`province_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`province_id`, `province_name`) VALUES
(1, 'Western Province'),
(2, 'Central Province'),
(3, 'Southern Province'),
(4, 'Northern Province'),
(5, 'Eastern Province'),
(6, 'North Western Province'),
(7, 'North Central Province'),
(8, 'Uva Province'),
(9, 'Sabaragamuwa Province');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

DROP TABLE IF EXISTS `section`;
CREATE TABLE IF NOT EXISTS `section` (
  `section_id` int NOT NULL AUTO_INCREMENT,
  `section_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `section_name`) VALUES
(1, 'සංවර්ධන අංශය'),
(2, 'සමෘධි අංශය'),
(3, 'ග්‍රාම නිලධාරී'),
(4, 'ක්ෂේත්‍ර නිලධාරීන් (අමාත්‍යංශගත)'),
(5, 'පරිපාලන (DS, ADS, AO)'),
(6, 'ගිණුම් අංශය'),
(7, 'විදේශ රැකියා ප්‍රවර්ධන අංශය'),
(8, 'කුඩා ව්‍යාපාර සංවර්ධන අංශය'),
(9, 'රෙජිස්ට්‍රාර් අංශය'),
(10, 'ආපදා සහන අංශය'),
(11, 'බෞද්ධ කටයුතු අංශය'),
(12, 'විදාතා සම්පත් මධ්‍යස්ථානය'),
(13, 'ඉඩම් අංශය'),
(14, 'හැඳුනුම්පත් අංශය'),
(15, 'සමාජ සේවා අංශය'),
(16, 'ආයතන අංශය');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `NIC` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `Birthdate` date DEFAULT NULL,
  `Gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `Position` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `Contact` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `Username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `Password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `Role` enum('Admin','user','postman_officer','DS_Officer','Accountant','Officer') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `Email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `Created_At` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `province_id` int DEFAULT NULL,
  `district_id` int DEFAULT NULL,
  `dsid` int DEFAULT NULL,
  `section_id` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Username` (`Username`),
  KEY `province_id` (`province_id`),
  KEY `district_id` (`district_id`),
  KEY `dsid` (`dsid`),
  KEY `section_id` (`section_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `Name`, `NIC`, `Birthdate`, `Gender`, `Position`, `Contact`, `Username`, `Password`, `Role`, `Email`, `Created_At`, `province_id`, `district_id`, `dsid`, `section_id`) VALUES
(1, 'H.P.S.S.K.WIJERATHNA', '587843095v', '1987-03-24', 'Female', 'Development Officer', '12345789', 'testuser1', 's1231234', 'postman_officer', 'giwijerathna87@gmail.com', '2025-10-29 14:44:25', 7, 2, 31, 14),
(2, 'D.M.S.B Dissanayake', '200000600390', '1989-01-06', 'Male', 'Economics Development Officer', '1234578787', 'testuser2', '434312', 'user', 'thbandarahis@gmail.com', '2025-10-29 14:44:25', 7, 2, 31, 1),
(5, 'Amal Bandara', '751234567V', '1975-03-12', 'Male', 'letter management officer', '0712345678', 'ds_letter_officer', '12345', 'user', 'ds_letter_officer@gmail.com', '2025-11-01 20:56:59', 7, 2, 31, 10),
(6, 'Upali Bandara', '900000000V', '1990-01-01', 'Male', 'Administrator', '0710000000', 'head officer', 'head123', 'DS_Officer', 'head@ds.lk', '2026-01-23 11:58:08', 6, 14, 200, 5),
(7, 'Hasidu Kumara', '850000001V', '1985-05-10', 'Male', 'accounter', '0711111111', 'tester', '789789', 'user', 'ds@ds.lk', '2026-01-23 11:58:08', 6, 14, 200, 5),
(8, 'Shantha Bandara', '850055001V', '1995-05-10', 'Male', 'head officer', '0711111111', 'testuser', 't1234', 'postman_officer', 'admin@12.com', '2026-01-23 14:29:43', 6, 14, 200, 5);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `district`
--
ALTER TABLE `district`
  ADD CONSTRAINT `fk_districts_province` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`province_id`);

--
-- Constraints for table `dsdivision`
--
ALTER TABLE `dsdivision`
  ADD CONSTRAINT `fk_ds_division_district` FOREIGN KEY (`district_id`) REFERENCES `district` (`district_id`);

--
-- Constraints for table `letters`
--
ALTER TABLE `letters`
  ADD CONSTRAINT `letters_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `section` (`section_id`),
  ADD CONSTRAINT `letters_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user` (`ID`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`province_id`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`district_id`) REFERENCES `district` (`district_id`),
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`dsid`) REFERENCES `dsdivision` (`dsid`),
  ADD CONSTRAINT `user_ibfk_4` FOREIGN KEY (`section_id`) REFERENCES `section` (`section_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
