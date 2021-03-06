-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 23, 2022 at 11:36 AM
-- Server version: 8.0.28-0ubuntu0.20.04.3
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sudo_meds`
--
CREATE DATABASE sudo_meds;
-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

CREATE TABLE `sudo_meds`.`auth` (
  `id` int NOT NULL,
  `phrase` varchar(40) NOT NULL,
  `DataInit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
);
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `auth`
--

INSERT INTO `sudo_meds`.`auth` (`id`, `phrase`, `DataInit`) VALUES
(1, 'SuperSim22', '2022-02-03 11:41:36');

-- --------------------------------------------------------

--
-- Table structure for table `drugs`
--

CREATE TABLE `sudo_meds`.`drugs` (
  `id` int NOT NULL,
  `DrugName` varchar(45) CHARACTER SET utf8,
  `Dose` text NOT NULL,
  `Barcode` varchar(12) DEFAULT NULL
);

--
-- Dumping data for table `drugs`
--

INSERT INTO `sudo_meds`.`drugs` (`id`, `DrugName`, `Dose`, `Barcode`) VALUES
(2, 'KCl 20 mEq in NSS 500 ml', '', '10000007'),
(3, 'KCl 20 mEq in NSS 250 mL', '', '10000014'),
(4, 'NaCl 0.9% - 1000 mL', '', '10000038'),
(5, 'NaCl 0.9% - 500 mL', '', '10000045'),
(6, 'NaCl 0.9% - 250 mL', '', '10000052'),
(7, 'NaCl 0.9% - 100 mL', '', '10000069'),
(8, 'NaCl 0.9% - 50 mL', '', '10000076'),
(9, 'Insulin 100 u / NaCl 0.9% - 100 mL', '', '10000083'),
(10, 'acetaminophen 325 mg tab', '', '10000090'),
(11, 'nimodipine 30 mg tablets', '', '10000106'),
(12, 'metoprolol 50mg', '', '10000113'),
(13, 'acetaminophen 80 mg tablets', '', '10000120'),
(14, 'pantoprazole 20mg tablets', '', '10000137'),
(15, 'multivitamin tablets', '', '10000151'),
(16, 'propranolol 10 mg tablets ', '', '10000168'),
(17, 'spironolactone 100 mg tablets ', '', '10000175'),
(18, 'docusate 100 mg tablets', '', '10000182'),
(19, 'furosemide 40 mg tablets ', '', '10000199'),
(20, 'levatiracetam 500 mg / 50 mL bag ', '', '10000205'),
(21, 'Lactulose 20 gm/30 mL - small, round tan cups', '', '10000229'),
(22, 'phenylephrine 50 mg /500 mL bag', '', '10000236'),
(23, 'pantoprazole 40mg/ 10ml', '', '10001219'),
(24, 'morphine 1 mg / mL vial', '', '10001226'),
(25, 'ondansetron 2mg /ml', '', '10001233'),
(26, 'Albuterol inhaler', '', '10001240'),
(27, 'pedialyte lemon lime 180ml', '', '10001257'),
(28, 'Ibuprofen 200mg tablet', '', '10001264'),
(29, 'pedialyte fruit punch 180 mL', '', '10001264'),
(30, 'magnesium hydroxide 30ml', '', '10001271'),
(31, 'methlergonovine .2mg/ml', '', '10001288'),
(32, '1000mL Lactated Ringers', '', '10001295'),
(33, 'Oxytocin 30u / 500ml in LR', '', '10001301'),
(34, 'Oxytocin 20u/1000ml in LR', '', '10001318'),
(35, 'Ampicillin 100 mg - 50 mL bag', '', '10001325'),
(36, 'cefotaxime 1 gm/50 mL', '', '10001332'),
(37, 'Nitroglycerine 0.4 mg', '', '303614725810'),
(38, 'Oxycodone 5/325', '', '303614755817'),
(39, 'metformin 500 mg', '', '322753835857'),
(40, 'Heparin 1 Ku/ml', '', '336825847217'),
(41, 'Heparin 10 Ku/ml', '', '336825847224'),
(42, 'Oral Swabs', '', '616784121826'),
(43, 'surgical sponges', '', '616784334219'),
(44, 'Lo Mein', '', 'm'),
(45, 'Pizza', '', 'p'),
(46, 'acetaminophen 10 mg oral', '', '10001349'),
(47, 'acetaminophen 300mg supository', '', '10001356'),
(48, 'benzocaine spray', '', '10001363'),
(60, 'acetaminophen 80 mg - TAB', '', '69168002330'),
(61, 'acetaminophen 325 mg - TAB', '', '69168023460'),
(62, 'acetaminophen 325 mg - SUPPOSITORY', '', '00472120206'),
(63, 'acetaminophen 500 mg - CAP', '', '00113002571'),
(64, 'acetaminophen 650 mg - TAB', '', '00363034080'),
(65, 'acetaminophen 650 mg - SUPPOSITORY', '', '00472120350'),
(66, 'albuterol 90 mcg - INHALER', '', '10001240'),
(67, 'albuterol/ipratropium 3 mg/0.5 mg - SOLU', '', '304870201100'),
(68, 'albuterol sulfate 2.5 mg in 3 mL - SOLU', '', '4950269785'),
(69, 'amiodarone 200 mg - TAB', '', '00093913306'),
(70, 'amiodarone hydrochloride 150 mg in 100 mL - S', '', '00143987510'),
(71, 'ampicillin 100 mg - 50 mL bag', '', '10001325'),
(72, 'ampicillin sodium 150 mg per mL - INJ', '', '00049002428'),
(73, 'ARIPiprazole 10 mg tab', '', '00093758056'),
(74, 'aspirin 81 mg - TAB', '', '00280210020'),
(75, 'aspirin 81 mg (chewable)', '', '306030024369'),
(76, 'aspirin 325 mg - TAB', '', '00067014922'),
(77, 'atorvastatin(practi-LIPIT) 10 mg tab', '', '55426114'),
(78, 'atropine sulfate 1 mg prefilled syringe', '', '010030548333'),
(79, 'baclophen 20 mg TAB', '', '00378302405'),
(80, 'benazepril (practi-LOTEN) 20 mg', '', '35690528'),
(81, 'benzocaine 200 mg - SPRAY', '', '00283067902'),
(82, 'benztropine 1 mg - TAB', '', '00603243410'),
(83, 'benztropin 1 mg per mL - INJ', '', '64725001201'),
(84, 'betadine 10% - DO NOT USE ON MANIKINS', '', '367618150047'),
(85, 'bisacodyl 10 mg - SUPPOSITORY', '', '00363046631'),
(86, 'blood IV Set', '', '+M3351420028'),
(87, 'blood tubing', '', '+M3354602580'),
(88, 'bumetanide 1 mg', '', '15645319'),
(89, 'bumetanide 0.25 mg per mL - INJ', '', '55154035805'),
(90, 'bupropion (WELLB) 100 mg tab', '', '77325686'),
(91, 'calcium chloride 13 mEq prefilled syringe', '', '010030548330'),
(92, 'calcium gluconate 10% 1 g in 10 mL - INJ', '', '44756208'),
(93, 'captopril 25mg tab', '', '0904504661'),
(94, 'castile soap', '', '+H776D419002'),
(95, 'ceFAZolin sodium 1 g in 50 mL - SOLU', '', '35698760'),
(96, 'ceFAZolin sodium 2 g in 50 mL - SOLU', '', '00264310511'),
(97, 'cefotaxime 2 g in 50 mL - SOLU', '', '00143993325'),
(98, 'ciprofloxacin 400 mg in 40 mL - SOLU', '', '21695091440'),
(99, 'ciprofloxacin 500 mg - TAB', '', '00143992805'),
(100, 'clindamycin 300 mg - CAPSULE', '', '00009039514'),
(101, 'clopidogrel 75 mg - TAB', '', '00093731405'),
(102, 'cyanocobalamin 1000 mcg per mL', '', '10001455'),
(103, 'D5 0.5 NSS w/ KCL 40 mEq 1000 mL', '', '10002025'),
(104, 'D5 Lactated Ringers 1000 mL', '', '10002049'),
(105, 'D5 NSS w/ 20 mEq KCl', '', '10001974'),
(106, 'D5 NSS w/ 40 mEq 1000ml', '', '10001981'),
(107, 'D5W 0.25%', '', '10002032'),
(108, 'dexamethasone 4 mg per mL INJ', '', '00069017902'),
(109, 'dextrose 5% and NaCl 0.25% - INJ', '', '00264751000'),
(110, 'diazePAM 5 mg per mL', '', '61786078208'),
(111, 'digoxin 0.25 mg tab', '', '10120125CANC'),
(112, 'dilTIAZem 240 mg - TAB', '', '00187204730'),
(113, 'diphenhydrAMINE 25 mg per mL - LIQUID', '', '00363041804'),
(114, 'divalproex sodium 500 mg - TAB', '', '00074712611'),
(115, 'docusate sodium 100 mg - CAPSULE', '', '00597001601'),
(116, 'docusate/senna 50 mg/8.6 mg', '', '42576891'),
(117, 'donepezil hydrochloride 10 mg - TAB', '', '00143974809'),
(118, 'DOPamine 400 mg in 250 mL', '', '303381007027'),
(119, 'Drug Guide', '', '978080365705'),
(120, 'DULoxetine 40 mg - CAPSULE', '', '27437029806'),
(121, 'enoxaparin sodium 40 mg in 0.4 mL - INJ', '', '00075062041'),
(122, 'EPINEPHrine 0.1 mg per mL - INJ', '', '54868572500'),
(123, 'famotidine 10 mg per mL - INJ', '', '67457043322'),
(124, 'fentaNYL 50 mcg - PATCH', '', '00378912298'),
(125, 'fentaNYL 50 mcg per mL - SOLU', '', '00409909332'),
(126, 'fentynl 50 mcg per hour - Demo Dose', '', '664113331057'),
(127, 'ferrous sulfate 325 mg - TAB', '', '54738096313'),
(128, 'fluticasone/salmeterol 250/50 mcg - DPI', '', '70518053800'),
(129, 'fluticasone/salmeterol 500/50 mcg - DPI', '', '10001707'),
(131, 'furosemide 10 mg per mL', '', '00054329450'),
(132, 'furosemide 20 mg - TAB', '', '00039006710'),
(133, 'gabapentin 300 mg - TAB', '', '00378542705'),
(134, 'glipiZIDE 5 mg - TAB', '', '00049017402'),
(135, 'glycerin - SUPPOSITORY', '', '00363044025'),
(136, 'haloperidol 2 mg - TAB', '', '00378021401'),
(137, 'haloperidol 5 mg - TAB', '', '00378032701'),
(138, 'haloperidol 10 mg - TAB', '', '00378033401'),
(139, 'haloperidol 2 mg per mL - SOLU', '', '00093960412'),
(140, 'haloperidol 5 mg per mL - SOLU', '', '00069011302'),
(141, 'hand foam', '', '25469002419'),
(142, 'hand foam 1 can', '', '025469002419'),
(143, 'heparin 1000 units per mL - INJ', '', '00069004301'),
(144, 'heparin 5000 units per mL - INJ', '', '00069005902'),
(145, 'heparin 10000 units per mL - INJ', '', '00069006201'),
(146, 'heparin 25000 units in 250 mL D5W', '', '00069023201'),
(147, 'hydroCHLOROthiazide 12.5 mg - CAPSULE', '', '00143312501'),
(148, 'HYDROmorphone 1 mg per mL - INJ', '', '94365252'),
(149, 'hydrOXYzine 50 mg - TAB', '', '00093506201'),
(150, 'ibuprofen 200 mg - TAB', '', '00113007471'),
(151, 'ibuprofen 800 mg - TAB', '', '00179011990'),
(152, 'insulin aspart (Novolog) 100 units per mL - I', '', '46818751'),
(153, 'insulin detemir (Levemir) 100 units per mL - ', '', '85672000'),
(154, 'insulin glargine (Lantus) 100 units per mL - ', '', '0088221905'),
(155, 'insulin NPH 100 units per mL - INJ', '', '355120536428'),
(156, 'insulin R 100 units per mL - INJ', '', '00002751001'),
(157, 'insulin R 250 units in 250 mL - SOLU', '', '54868361900'),
(158, 'Isosource food', '', '043900181509'),
(159, 'KCl 10 mEq in 0.9% NaCl 50 mL - SOLU', '', '04099707426'),
(160, 'KCl 20 mEq in 5% Dextrose and 0.45% NaCl 50 m', '', '02647623'),
(161, 'KCl 20 mEq in 0.9% NaCl 500 mL - SOLU', '', '0409711609'),
(162, 'labetalol hydrochloride 5 mg per mL - INJ', '', '00143962301'),
(163, 'labetalol hydrochloride 200 mg - TAB', '', '00172436560'),
(164, 'Lactated Ringers 1000 mL - SOLU', '', '00409795309'),
(165, 'Lactated Ringers 1000 mL', '', '10001295'),
(166, 'Lactated Ringers 1000 mL', '', '10001950'),
(167, 'Lactated Ringers 500 mL - SOLU', '', '00409795303'),
(168, 'Lactated Ringers 500 mL', '', '10001967'),
(169, 'levETIRAcetam 500 mg per 50 mL - SOLU', '', '13668027210'),
(170, 'levoFLOXacin 500 mg in 0.9% NaCl 100 mL - SOL', '', '10001400'),
(171, 'levoFLOXacin 750 mg - TAB', '', '00143977505'),
(172, 'levoFLOXacin 750 mg in 0.9% NaCl 50 mL - SOLU', '', '00143972024'),
(173, 'lidocaine HCL 2% 100 mg syringe', '', '010030409132'),
(174, 'lipitor 80 mg', '', '22215635'),
(175, 'lisinopril 5 mg - TAB', '', '00006001954'),
(176, 'lisinopril 10 mg - TAB', '', '00006010654'),
(177, 'lisinopril 20 mg - TAB', '', '00006020754'),
(178, 'lithium 450 mg - TAB', '', '00054002025'),
(180, 'LORazepam 0.5 mg - TAB', '', '00591024010'),
(181, 'LORazepam 1 mg - TAB', '', '00179016330'),
(182, 'LORazepam 2 mg - TAB', '', '00187006550'),
(183, 'LORazepam 2 mg per mL - SOLU', '', '00054353244'),
(184, 'losartan 50 mg - TAB', '', '00093736510'),
(185, 'magnesium hydroxide 200 mg per 5 mL - SUSPENS', '', '00054356749'),
(186, 'magnesium sulfate 4 g in 100 mL - SOLU', '', '00409672909'),
(187, 'magnesium sulfate 30 g in 500 mL - SOLU', '', '52533009929'),
(188, 'mannitol 20% 50 g in 50 mL - SOLU', '', '00264230350'),
(189, 'MATERNITY PAD', '', '011069439313'),
(190, 'memantine 5 g - TAB', '', '00378110391'),
(191, 'metFORMIN 500 mg - TAB', '', '00185021305'),
(192, 'metFORMIN - 850 mg - TAB', '', '23155010305'),
(193, 'methlergonovine 0.2 mg per mL - INJ', '', '00517074020'),
(194, 'methylPREDNISOLONE 125 mg per mL - INJ', '', '9004722'),
(195, 'metoprolol 25 mg - TAB', '', '00186108805'),
(196, 'metoprolol 50 mg - TAB', '', '00186109005'),
(197, 'miralax', '', '350383779162'),
(198, 'MiraLAX 1 g/mL', '', '99123451'),
(199, 'montelukast sodium 10 mg - TAB', '', '00006911731'),
(200, 'morphine sulfate 1 mg per mL - INJ', '', '52533016004'),
(201, 'morphine sulfate 1 mg per mL - SOLU', '', '00409381512'),
(202, 'morphine sulfate 100 mg - TAB', '', '68084040601'),
(203, 'multivitamin - TAB', '', '68308050260'),
(204, 'NaCl 5% - ophthalmic SOLU', '', '309046490357'),
(205, 'NaCl 0.9% - 1000 mL', '', '10000038'),
(206, 'NaCl 0.9% - 500 mL', '', '010030409613'),
(207, 'NaCl 0.9% - 500 mL', '', '10000045'),
(208, 'NaCl 0.9% - 250 mL', '', '10000052'),
(209, 'NaCl 0.9% - 100 mL', '', '10000069'),
(210, 'NaCl 0.9% - 50 mL', '', '10000076'),
(211, 'NaCl 0.65% - NASAL SPRAY', '', '050428311806'),
(212, 'NaCl 0.45% - 1000 mL', '', '10001905'),
(213, 'NaCl 0.45% - 500 mL', '', '10001912'),
(214, 'NaCl 0.45% - 250 mL', '', '10001929'),
(215, 'NaCl 0.45% - 100 mL', '', '10001936'),
(216, 'NaCl 0.45% - 50 mL', '', '10001943'),
(217, 'nicotine patch 21 mg', '', '84671110'),
(218, 'niMODipine 30 mg - CAPSULE', '', '00904656604'),
(219, 'NITRO-BID applicator', '', '301680326306'),
(220, 'NITRO-BID ointment USP 2%', '', '302810326302'),
(221, 'nitroglycerin 0.4 mg - TAB', '', '00071041824'),
(222, 'norEPINEPHrine 8 mg in 5% Dextrose 250 mL - S', '', '00409144325'),
(223, 'OLANZapine 5 mg - TAB', '', '00002411730'),
(224, 'OLANZapine 10 mg - TAB', '', '00002411730'),
(225, 'omeprozole 40 mg - CAPSULE', '', '00378522293'),
(226, 'ondansetron 2 mg per mL', '', '00069134002'),
(227, 'ondansetron 2 mg per mL', '', '10001233'),
(228, 'ondansetron 4 mg - TAB', '', '00143242201'),
(229, 'oral swabs', '', '616784121826'),
(230, 'oxyCODONE 5 mg - TAB', '', '00378611201'),
(231, 'oxyCODONE/acetaminophen 5/325 mg - TAB', '', '16590061990'),
(232, 'oxytocin 20 units in 1000 mL LR - SOLU', '', '52533005030'),
(233, 'oxytocin 30 units in 500 mL LR - SOLU', '', '52533005430'),
(234, 'pantoprazole 40 mg - TAB', '', '00008060704'),
(235, 'pantoprazole 40 mg per 10 mL - INJ', '', '00008094103'),
(236, 'Pedialyte lemon lime 180 ml', '', '10001257'),
(237, 'phenylephrine hydrochloride 50 mg in 500 mL -', '', '00641614225'),
(238, 'piperacillin sodium 1 g in 50 mL D5W - INJ', '', '67457052122'),
(239, 'piperacillin and tazobactam 3.375 g per 50 mL', '', '00206240502'),
(240, 'pneumococcal vaccine - INJ', '', '00005197101'),
(241, 'polyethylene glycol 17 mg - POWDER', '', '11523435701'),
(242, 'potassium chloride 10 mEq in NaCl 0.9% - INJ', '', '00409707426'),
(243, 'potassium chloride 20 mEq in 500 mL 0.9% NaCl', '', '22235466'),
(244, 'predniSONE 10 mg - TAB', '', '63739051910'),
(245, 'tubing - primary', '', '+M3351468728'),
(246, 'promethazine 25 mg per mL - INJ', '', '00641092825'),
(247, 'propranolol 10 mg TABs', '', '10000168'),
(248, 'quail', '', 'q'),
(249, 'rosuvastatin 20 mg - TAB', '', '00310075290'),
(250, 'safety needle 22 g', '', '100382903059'),
(251, 'scopolamine 1.5 mg - PATCH', '', ' 4580258001'),
(252, 'screen cleaning wipes', '', '735854873516'),
(253, 'secondary tubing', '', '+M3351423028'),
(254, 'senna glycoside 20 mg - TAB', '', '42982444101'),
(255, 'simvastatin 20 mg - TAB', '', '00006074054'),
(256, 'spironolactone 100 mg TABs', '', '10000175'),
(257, 'sponges - cover', '', '011088452105'),
(258, 'sponges - drain', '', '011088452701'),
(259, 'sponges - gauze', '', '011088452105'),
(260, 'surgical sponges', '', '616784334219'),
(261, 'synthroid 1.25 mcg', '', '94215441'),
(262, 'syringe 3 mL', '', '010038290309'),
(263, 'syringe - flush 3 mL', '', '013088452100'),
(264, 'syringe - flush 10 mL', '', '011088452100'),
(265, 'syringe 20 mL', '', '010038290309'),
(266, 'syringe - insulin', '', '010038290305'),
(267, 'syringe - test', '', '59'),
(268, 'terahydroanninol - 50mg', '', 'th'),
(269, 'temazapam 15 mg cap', '', '664113930236'),
(270, 'timolol maleate 0.5%', '', '10001448'),
(271, 'traZODone 50 mg - TAB', '', '00603616002'),
(272, 'valproic acid 250 mg - TAB', '', '00074568113'),
(273, 'valproic acid 500 mg tab', '', '66662303'),
(274, 'warfarin (COUMA) 5 mg tab', '', '11236405'),
(275, 'warfarin sodium 5 mg - TAB', '', '00056017201'),
(276, 'DEMO LSAI 20MG', '', '664113100028'),
(278, 'nopeadone', '', 'n');

-- --------------------------------------------------------

--
-- Table structure for table `drug_admins`
--

CREATE TABLE `sudo_meds`.`drug_admins` (
  `id` int NOT NULL,
  `DrugID` int NOT NULL,
  `DrugName` varchar(40) NOT NULL,
  `PatientID` int NOT NULL,
  `UserID` int NOT NULL,
  `UserInitals` varchar(16) NOT NULL,
  `AdminTime` varchar(20) NOT NULL,
  `RealTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `drug_admins`
--

INSERT INTO `sudo_meds`.`drug_admins` (`id`, `DrugID`, `DrugName`, `PatientID`, `UserID`, `UserInitals`, `AdminTime`, `RealTime`) VALUES
(10, 44, 'Lo Mein', 2, 3, 'Mary', '0700', '2022-01-13 18:49:11'),
(13, 114, 'divalproex sodium 500 mg - TAB', 55, 835, 'Nicholai', '0700', '2022-01-13 21:38:24'),
(17, 179, 'Lo Mein', 1, 2, 'Miles', '0700', '2022-01-18 18:49:01'),
(18, 179, 'Lo Mein', 1, 2, 'Miles', '0700', '2022-01-19 15:07:39'),
(19, 179, 'Lo Mein', 1, 2, 'Miles', '0700', '2022-01-19 15:08:37'),
(20, 179, 'Lo Mein', 1, 2, 'Miles', '0700', '2022-01-19 15:09:40'),
(21, 179, 'Lo Mein', 1, 2, 'Miles', '0700', '2022-01-19 15:11:17'),
(25, 248, 'quail', 57, 2, 'Miles', '0700', '2022-01-20 18:50:07'),
(46, 45, 'Pizza', 58, 2, 'Miles', '02/05/22 :????', '2022-02-05 19:42:45'),
(64, 73, 'ARIPiprazole 10 mg tab', 58, 887, 'Jana', '02/13/22 :????', '2022-02-13 16:03:03'),
(71, 123, 'famotidine 10 mg per mL - INJ', 48, 857, 'Mark', '02/15/22 :1440', '2022-02-15 19:42:26'),
(121, 134, 'glipiZIDE 5 mg - TAB', 13, 1006, 'Vanessa', '03/02/22 :0257', '2022-03-02 15:56:15'),
(132, 74, 'aspirin 81 mg - TAB', 25, 1019, 'Amanda', '03/04/22 0820', '2022-03-04 19:08:26'),
(133, 177, 'lisinopril 20 mg - TAB', 25, 1019, 'Amanda', '03/04/22 0820', '2022-03-04 19:08:42'),
(134, 61, 'acetaminophen 325 mg - TAB', 25, 1019, 'Amanda', '03/04/22 0833', '2022-03-04 19:20:43'),
(135, 61, 'acetaminophen 325 mg - TAB', 25, 1019, 'Amanda', '03/04/22 :????', '2022-03-04 19:21:19'),
(142, 150, 'ibuprofen 200 mg - TAB', 42, 896, 'BlueBadge', '03/08/22 :7:15', '2022-03-08 13:23:17'),
(143, 193, 'methlergonovine 0.2 mg per mL - INJ', 42, 896, 'BlueBadge', '03/08/22 :7:30', '2022-03-08 13:35:56'),
(144, 156, 'insulin R 100 units per mL - INJ', 40, 1027, 'Kiauna', '03/09/22 :????', '2022-03-09 13:26:49'),
(145, 156, 'insulin R 100 units per mL - INJ', 40, 1027, 'Kiauna', '03/09/22 :????', '2022-03-09 13:27:26'),
(146, 161, 'KCl 20 mEq in 0.9% NaCl 500 mL - SOLU', 40, 1026, 'bhawana', '03/09/22 :????', '2022-03-09 13:39:14'),
(147, 161, 'KCl 20 mEq in 0.9% NaCl 500 mL - SOLU', 40, 1029, 'Yashoda', '03/09/22 :????', '2022-03-09 14:58:04'),
(148, 156, 'insulin R 100 units per mL - INJ', 40, 1029, 'Yashoda', '03/09/22 :????', '2022-03-09 15:10:19'),
(149, 61, 'acetaminophen 325 mg - TAB', 44, 1031, 'Kaitlyn', '03/09/22 :????', '2022-03-09 17:05:57'),
(150, 61, 'acetaminophen 325 mg - TAB', 44, 1031, 'Kaitlyn', '03/09/22 :????', '2022-03-09 17:06:10'),
(151, 97, 'cefotaxime 2 g in 50 mL - SOLU', 44, 1031, 'Kaitlyn', '03/09/22 :????', '2022-03-09 17:06:41'),
(152, 232, 'oxytocin 20 units in 1000 mL LR - SOLU', 4, 902, 'WhiteRN', '03/10/22 :0700', '2022-03-10 12:55:05'),
(153, 193, 'methlergonovine 0.2 mg per mL - INJ', 4, 902, 'WhiteRN', '03/10/22 :0700', '2022-03-10 13:22:56'),
(154, 150, 'ibuprofen 200 mg - TAB', 4, 902, 'WhiteRN', '03/10/22 :0700', '2022-03-10 13:24:57'),
(155, 150, 'ibuprofen 200 mg - TAB', 4, 902, 'WhiteRN', '03/10/22 :0700', '2022-03-10 13:25:09'),
(172, 61, 'acetaminophen 325 mg - TAB', 5, 1035, 'Maggie', '03/17/22 :0800', '2022-03-17 12:25:08'),
(173, 61, 'acetaminophen 325 mg - TAB', 5, 1035, 'Maggie', '03/17/22 :0800', '2022-03-17 12:25:21'),
(174, 61, 'acetaminophen 325 mg - TAB', 5, 1035, 'Maggie', '03/17/22 :0800', '2022-03-17 12:25:36'),
(175, 61, 'acetaminophen 325 mg - TAB', 5, 1035, 'Maggie', '03/17/22 :0800', '2022-03-17 12:25:59'),
(176, 127, 'ferrous sulfate 325 mg - TAB', 5, 1035, 'Maggie', '03/17/22 :0800', '2022-03-17 12:26:12'),
(177, 113, 'diphenhydrAMINE 25 mg per mL - LIQUID', 5, 1035, 'Maggie', '03/17/22 :0820', '2022-03-17 12:46:14'),
(178, 113, 'diphenhydrAMINE 25 mg per mL - LIQUID', 5, 1035, 'Maggie', '03/17/22 :0820', '2022-03-17 12:46:31'),
(179, 60, 'acetaminophen 80 mg - TAB', 35, 900, 'GreenCRNA', '03/17/22 :1100', '2022-03-17 14:10:49'),
(186, 146, 'heparin 25000 units in 250 mL D5W', 28, 925, 'fgj', '03/17/22 :0700', '2022-03-17 17:19:46'),
(187, 231, 'oxyCODONE/acetaminophen 5/325 mg - TAB', 28, 896, 'BlueBadge', '03/17/22 :????', '2022-03-17 17:44:05'),
(188, 231, 'oxyCODONE/acetaminophen 5/325 mg - TAB', 28, 896, 'BlueBadge', '03/17/22 :????', '2022-03-17 17:44:11'),
(189, 123, 'famotidine 10 mg per mL - INJ', 28, 896, 'BlueBadge', '03/17/22 :????', '2022-03-17 17:46:22'),
(190, 69, 'amiodarone 200 mg - TAB', 28, 896, 'BlueBadge', '03/17/22 :????', '2022-03-17 17:54:45'),
(191, 89, 'bumetanide 0.25 mg per mL - INJ', 28, 896, 'BlueBadge', '03/17/22 :????', '2022-03-17 17:55:50'),
(192, 64, 'acetaminophen 650 mg - TAB', 5, 925, 'fgj', '03/18/22 :????', '2022-03-18 11:59:23'),
(193, 64, 'acetaminophen 650 mg - TAB', 5, 925, 'fgj', '03/18/22 :????', '2022-03-18 12:00:28'),
(197, 205, 'NaCl 0.9% - 1000 mL', 54, 899, 'BlueBadgeEd', '03/18/22 1900', '2022-03-18 14:19:28'),
(198, 64, 'acetaminophen 650 mg - TAB', 54, 899, 'BlueBadgeEd', '03/18/22 1900', '2022-03-18 14:28:05'),
(199, 69, 'amiodarone 200 mg - TAB', 28, 896, 'BlueBadge', '03/18/22 :????', '2022-03-18 15:00:42'),
(200, 231, 'oxyCODONE/acetaminophen 5/325 mg - TAB', 28, 896, 'BlueBadge', '03/18/22 :????', '2022-03-18 15:00:54'),
(201, 69, 'amiodarone 200 mg - TAB', 28, 896, 'BlueBadge', '03/18/22 :????', '2022-03-18 18:00:16'),
(202, 69, 'amiodarone 200 mg - TAB', 28, 896, 'BlueBadge', '03/18/22 :????', '2022-03-18 18:00:32'),
(203, 69, 'amiodarone 200 mg - TAB', 28, 896, 'BlueBadge', '03/18/22 :????', '2022-03-18 18:00:46'),
(204, 231, 'oxyCODONE/acetaminophen 5/325 mg - TAB', 28, 896, 'BlueBadge', '03/18/22 :????', '2022-03-18 18:26:58'),
(211, 44, 'Lo Mein', 57, 4, 'Lao', '800 - 03/22/22', '2022-03-22 17:31:43'),
(225, 45, 'Pizza', 6, 4, 'Lao', '800 - 03/23/22', '2022-03-23 11:58:14'),
(226, 268, 'terahydroanninol - 50mg', 6, 4, 'Lao', '800 - 03/23/22', '2022-03-23 14:19:54'),
(227, 278, 'nopeadone', 6, 4, 'Lao', '800 - 03/23/22', '2022-03-23 14:51:11'),
(228, 268, 'terahydroanninol - 50mg', 6, 4, 'Lao', '800 - 03/23/22', '2022-03-23 14:51:28');

-- --------------------------------------------------------

--
-- Table structure for table `nurse_notes`
--

CREATE TABLE `sudo_meds`.`nurse_notes` (
  `id` int NOT NULL,
  `UserID` int NOT NULL,
  `PatientID` int NOT NULL,
  `DateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `HR` int NOT NULL,
  `RR` int NOT NULL,
  `Bp` varchar(12) NOT NULL,
  `Spo` int NOT NULL,
  `Note` mediumtext NOT NULL
);

--
-- Dumping data for table `nurse_notes`
--

INSERT INTO `sudo_meds`.`nurse_notes` (`id`, `UserID`, `PatientID`, `DateTime`, `HR`, `RR`, `Bp`, `Spo`, `Note`) VALUES
(1, 2, 1, '2022-01-13 19:27:28', 50, 12, '120/80', 95, 'He is doing very well'),
(10, 2, 58, '2022-02-05 19:43:13', 80, 12, '120/80', 98, 'SUBJECTIVE-:\r\n\r\nOBJECTIVE-:\r\n\r\nASSESSMENT-:\r\n\r\nPLAN-:\r\n'),
(17, 4, 6, '2022-03-23 15:05:28', 0, 0, '0', 0, 'SUBJECTIVE-:\r\n\r\nOBJECTIVE-:\r\n\r\nASSESSMENT-:\r\n\r\nPLAN-:\r\n'),
(18, 4, 6, '2022-03-23 15:09:16', 0, 0, '0', 0, 'SUBJECTIVE-:\r\n\r\nOBJECTIVE-:\r\n\r\nASSESSMENT-:\r\n\r\nPLAN-:\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `sudo_meds`.`patients` (
  `id` int NOT NULL,
  `FirstName` varchar(16) NOT NULL,
  `LastName` varchar(16) NOT NULL,
  `Barcode` varchar(40) NOT NULL,
  `DOB` varchar(16) CHARACTER SET utf8mb4,
  `Provider` varchar(40) NOT NULL DEFAULT 'Aldo Castaneda  M.D.',
  `MarFile` text CHARACTER SET utf8mb4 NOT NULL,
  `HpFile` varchar(40) CHARACTER SET utf8mb4 NOT NULL DEFAULT 'HpMissing.txt',
  `OrdersFile` varchar(40) CHARACTER SET utf8mb4 DEFAULT 'OrdersMissing.txt',
  `ReportFile` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT 'ReportMissing.txt'
);
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `sudo_meds`.`patients` (`id`, `FirstName`, `LastName`, `Barcode`, `DOB`, `Provider`, `MarFile`, `HpFile`, `OrdersFile`, `ReportFile`) VALUES
(4, 'Leslie', 'Allison', '86443920', '06/10/19XX', 'B. Glassman', 'Allison, Leslie - 5 - Medications_MM.pdf', 'Allison, Leslie - 3 - H & P_MM.pdf', 'Allison, Leslie - 4 - Orders_MM.pdf', 'Allison, Leslie - 2 - Shift Report_MM.pdf'),
(5, 'Jennifer', 'Applebaum', '15693563', '02/11/19XX', 'Paul Neumann, DO', 'Applebaum, Jennifer - MAR.pdf', 'Applebaum, Jennifer - 3 - H & P_MM.pdf', 'Applebaum, Jennifer - 4 - Orders_MM.pdf', 'Applebaum, Jennifer - 2 - Shift Report_MM.pdf'),
(6, 'Marshal', 'Ericson', 'a', '12/11/1954', 'Aldo Castaneda  M.D.', 'missingfile.txt', 'missingfile.txt', '', ''),
(8, 'Bea', 'Comfortable', '42575689', NULL, 'Aldo Castaneda  M.D.', 'Comfortable-Bea-MAR.txt', '', '', ''),
(9, 'Audie', 'Cornish', '35562610', '', 'Aldo Castaneda  M.D.', 'Cornish, Audie - MAR.pdf', '', '', ''),
(10, 'Chris', 'Cosper', '46215581', NULL, 'Aldo Castaneda  M.D.', 'Cosper-Chris-MAR.txt', 'noafile.txt', '', ''),
(11, 'Jonathan', 'Cowley', '27544716', NULL, 'Aldo Castaneda  M.D.', 'Cowley-Jonathan-MAR.txt', '', '', ''),
(12, 'Katelyn', 'Davis', '29563951', NULL, 'Aldo Castaneda  M.D.', 'Davis-Katelyn-MAR.txt', '', '', ''),
(13, 'Jackie', 'Edwards', '21132179', '05/18/19XX', 'Aldo Castaneda  M.D.', 'Edwards, Jackie - 5 - Medications_MM.pdf', 'Edwards, Jackie - 3 - H & P_MM.pdf', 'Edwards, Jackie - 4 - Orders_MM.pdf', 'Edwards, Jackie - 2 - Shift Report_MM.pdf'),
(14, 'Trudy', 'Fasbender', '65983317', NULL, 'Aldo Castaneda  M.D.', 'Fasbender-Trudy-MAR.txt', '', '', ''),
(15, 'Chris', 'Forrester', '99821433', NULL, 'Aldo Castaneda  M.D.', 'Forrester-Chris-MAR.txt', '', '', ''),
(16, 'Chris', 'Garcia', '45183270', NULL, 'Aldo Castaneda  M.D.', 'Garcia-Chris-MAR.txt', '', '', ''),
(17, 'Matthew', 'Geyer', '29511433', NULL, 'Aldo Castaneda  M.D.', 'Geyer-Matthew-MAR.txt', '', '', ''),
(18, 'Rebecca', 'Geyer', '40528885', NULL, 'Aldo Castaneda  M.D.', 'Geyer-Rebecca-MAR.txt', '', '', ''),
(19, 'Kathy', 'Givens', '1551557', NULL, 'Aldo Castaneda  M.D.', 'Givens-Kathy-MAR.txt', '', '', ''),
(20, 'Kathy', 'Givens', '15515575', NULL, 'Aldo Castaneda  M.D.', 'Givens-Kathy-MAR.txt', '', '', ''),
(21, 'Jake', 'Henry', '55841238', NULL, 'Aldo Castaneda  M.D.', 'Henry-Jake-MAR.txt', '', '', ''),
(22, 'Paul', 'Horn', '4321', NULL, 'Aldo Castaneda  M.D.', 'Horn-Paul-MAR.txt', '', '', ''),
(23, 'Juanita', 'Ibarra', '84956224', NULL, 'Aldo Castaneda  M.D.', 'Ibarra-Juanita-MAR.txt', '', '', ''),
(24, 'Juanita', 'Ibarra', '21201479', NULL, 'Aldo Castaneda  M.D.', 'ibarra-juanita-MAR.txt', '', '', ''),
(25, 'Jacob', 'Johnson', '25522143', NULL, 'Aldo Castaneda  M.D.', 'Johnson-Jacob-MAR.txt', '', '', ''),
(26, 'Mark', 'Johnson', '29587452', NULL, 'Aldo Castaneda  M.D.', 'Johnson-Mark-MAR.txt', '', '', ''),
(27, 'Jacob', 'King', '35574262', NULL, 'Aldo Castaneda  M.D.', 'King-Jacob-MAR.txt', '', '', ''),
(28, 'Samuel', 'Lapp', '32876437', NULL, 'Aldo Castaneda  M.D.', 'Lapp-Samuel-MAR.txt', '', '', ''),
(29, 'Greg', 'Martin', '27565438', NULL, 'Aldo Castaneda  M.D.', 'Martin-Greg-MAR.txt', '', '', ''),
(30, 'Dale', 'Mayman', '1349567', NULL, 'Aldo Castaneda  M.D.', 'Mayman-Dale-MAR.txt', '', '', ''),
(31, 'Bart', 'McFarkin', '10254431', NULL, 'Aldo Castaneda  M.D.', 'McFarkin-Bart-MAR.txt', '', '', ''),
(33, 'Ty', 'Nguyen', '62510325', NULL, 'Aldo Castaneda  M.D.', 'Nguyen-Ty-MAR.txt', '', '', ''),
(34, 'Thomas', 'Pickles', '24539852', NULL, 'Aldo Castaneda  M.D.', 'Pickles-Thomas-MAR.txt', '', '', ''),
(35, 'Jordan', 'Brown', '63532647', '02/01/19XX', 'JB Waltman MD', 'Brown, Jordan - 5 - Medications_MM.pdf', 'Brown, Jordan - 3 - H & P_MM.pdf', 'Brown, Jordan - 4 - Orders_MM.pdf', 'Brown, Jordan - 2 - Shift Report_MM.pdf'),
(36, 'Maria', 'Rodriguez', '11587439', NULL, 'Aldo Castaneda  M.D.', 'Rodriguez-Maria-MAR.txt', '', '', ''),
(37, 'Robert', 'Sanchez', '25574180', '03/26/20XX', 'Katherine Nelson D.O.', '', '', '', ''),
(38, 'Joyce', 'Schmough', '55987417', NULL, 'Aldo Castaneda  M.D.', 'Schmough-Joyce-MAR.txt', '', '', ''),
(39, 'Melody', 'Schreiber', '35569855', NULL, 'Aldo Castaneda  M.D.', 'Schreiber-Melody-MAR.txt', '', '', ''),
(40, 'Jada', 'Scott', '13594558', '06/10/20XX', 'Paul Jordan, M.D.', 'Scott, Jada - 5 - Medications_MM.pdf', 'Scott, Jada - 3 - H & P_MM.pdf', 'Scott, Jada - 4 - Orders_MM.pdf', 'Scott, Jada - 2 - Shift Report_MM.pdf'),
(41, 'Adrian', 'Shapiro', '25330090', '07/19/19XX', 'Aldo Castaneda  M.D.', 'Shapiro, Adrian - 5 - Medications_MM.pdf', 'Shapiro, Adrian - 3 - H & P_MM.pdf', 'Shapiro, Adrian - 4 - Orders_MM.pdf', 'Shapiro, Adrian - 2 - Shift Report_MM.pdf'),
(42, 'Danielle', 'Simmons', '35585244', '06/10/19XX', 'B. Glassman M.D.', '', '', '', ''),
(43, 'Julia', 'Morales', '11204862', '10/03/19XX', 'Anne Davis, M.D.', 'Morales, Julia - 5 - Medications_MM.pdf', '', '', ''),
(44, 'Marco', 'Sorrells', '45521690', '09/08/20XX', 'James Town, D.O.', 'Sorrells, Marco - 5 - Medications_MM.pdf', 'Sorrells, Marco - 3 - H & P_MM.pdf', 'Sorrells, Marco - 4 - Orders_MM.pdf', 'Sorrells, Marco - 2 - Shift Report_MM.pdf'),
(45, 'Andy', 'Spree', '21265891', NULL, 'Aldo Castaneda  M.D.', 'Spree-Andy-MAR.txt', '', '', ''),
(46, 'Michael', 'Stipe', '17595186', NULL, 'Aldo Castaneda  M.D.', 'Stipe-Michael-MAR.txt', '', '', ''),
(47, 'Daniel', 'Stoltzfus', '29545872', NULL, 'Aldo Castaneda  M.D.', 'Stoltzfus-Daniel-MAR.txt', '', '', ''),
(48, 'Henry', 'Williams', '27954614', NULL, 'Aldo Castaneda  M.D.', 'Williams-Henry-MAR.txt', '', '', ''),
(49, 'Joseph', 'Williams', '11558842', NULL, 'Aldo Castaneda  M.D.', 'Williams-Joseph-MAR.txt', '', '', ''),
(50, 'Wanda', 'Willow', '55214797', NULL, 'Aldo Castaneda  M.D.', 'Willow-Wanda-MAR.txt', '', '', ''),
(51, 'Natalie', 'Wolchover', '55124873', '06/10/19XX', 'Sophia Good, MD', 'Wolchover, Natalie - 5 - MAR_MM.pdf', 'Wolchover, Natalie - 3 - HP_MM.pdf', 'Wolchover, Natalie - 4 - Orders_MM.pdf', 'Wolchover, Natalie - 2 -Report_MM.pdf'),
(52, 'Sherman', 'Yoder', '64646428', '06/26/19XX', 'Frank Baker  M.D.', 'Yoder, Sherman - 5 - Medications_MM1.pdf', 'Yoder, Sherman - 3 - H & P_MM.pdf', 'Yoder, Sherman - 4 - Orders_MM.pdf', 'Yoder, Sherman - 2 - Shift Report_MM.pdf'),
(53, 'Gladys', 'Young', '78785212', NULL, 'Aldo Castaneda  M.D.', 'Young-Gladys-MAR.txt', '', '', ''),
(54, 'Jacob', 'Zook', '97953135', '07/02/19XX', 'Robert Martin MD', 'Zook, Jacob - 5 - Medications_MM.pdf', 'Zook, Jacob - 3 - H & P_MM.pdf', 'Zook, Jacob - 4 - Orders_MM.pdf', 'Zook, Jacob - 2 - Shift Report_MM.pdf'),
(57, 'Hugh', 'Laurie', '999', 'who knows', 'Aldo Castaneda  M.D.', 'dotpict_20220119_185244.png', 'H&P.txt', '_amissingfile.txt', '_amissingfile.txt');

-- --------------------------------------------------------

--
-- Table structure for table `patient_files`
--

CREATE TABLE `sudo_meds`.`patient_files` (
  `id` int NOT NULL,
  `PatientID` int NOT NULL,
  `Label` text CHARACTER SET utf8mb4 NOT NULL,
  `FileName` varchar(100) CHARACTER SET utf8mb4 NOT NULL
);

--
-- Dumping data for table `patient_files`
--

INSERT INTO `sudo_meds`.`patient_files` (`id`, `PatientID`, `Label`, `FileName`) VALUES
(5, 58, 'Lab Results', 'Yoder, Sherman - Hospital - Labs.pdf'),
(7, 40, 'ED Lab Results', 'Scott, Jada - Lab Results - ED - 0530_MM.pdf'),
(8, 40, 'ED Pulmonary Results', 'Scott, Jada - Pulmonary Results - ED_MM.pdf'),
(9, 51, 'Labs', 'Wolchover, Natalie - 6 - Labs_MM.pdf'),
(10, 4, 'Admission Labs', 'Allison, Leslie - Lab Results - On Admission_MM.pdf'),
(11, 13, 'Labs-ED', 'Edwards, Jackie - Laboratory Results_MM.pdf'),
(12, 13, 'Radiology-Yesterday', 'Edwards, Jackie - Radiology Results (Yesterday)_MM.pdf'),
(13, 52, 'Labs - POD 1', 'Yoder, Sherman - Lab Results - POD 1.pdf'),
(14, 41, 'Labs - ED', 'Shapiro, Adrian - Lab Results - Yesterday.pdf'),
(15, 54, 'Lab 0600', 'Zook, Jacob - Lab Results Today 0600.pdf'),
(16, 54, 'Pulmonary(3 days ago)', 'Zook, Jacob - Pulmonary Results - 3 days ago.pdf'),
(17, 54, 'Radiology-Intra Op', 'Zook, Jacob - Radiology Results - Intra-op.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `sudo_meds`.`users` (
  `id` int NOT NULL,
  `FirstName` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `LastName` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `Barcode` varchar(40) NOT NULL,
  `Pin` varchar(40) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AccessLevel` int NOT NULL DEFAULT '1',
  `StartDate` varchar(14) CHARACTER SET utf8mb4 DEFAULT '2022'
);

--
-- Dumping data for table `users`
--

INSERT INTO `sudo_meds`.`users` (`id`, `FirstName`, `LastName`, `Barcode`, `Pin`, `AccessLevel`, `StartDate`) VALUES
(4, 'Lao', 'Tzu', '666', 'e58cc5ca94270acaceed13bc82dfedf7', 3, '2030'),
(27, 'Plumby', 'Daniel', 'MedID177', 'b59c67bf196a4758191e42f76670ceba', 1, 'Tue 01/22/2019'),
(565, 'Wilder', 'Gabrielle', 'MedID765', 'b59c67bf196a4758191e42f76670ceba', 1, 'Sun 10/20/2019');
INSERT INTO `sudo_meds`.`users` (`id`, `FirstName`, `LastName`, `Barcode`, `Pin`, `AccessLevel`, `StartDate`) VALUES
(896, 'BlueBadge', 'RN', 'MedId1712', 'd41d8cd98f00b204e9800998ecf8427e', 1, '2022'),
(897, 'RedBadge', 'MD', 'MedId2045', 'd41d8cd98f00b204e9800998ecf8427e', 1, '2022'),
(898, 'BlueBadge', 'RN', 'MedId1587', 'd41d8cd98f00b204e9800998ecf8427e', 1, '2022'),
(899, 'BlueBadgeEd', 'RN', 'MedId1595', 'd41d8cd98f00b204e9800998ecf8427e', 1, '2022'),
(900, 'GreenCRNA', 'CRNA', 'MedId2049', 'd41d8cd98f00b204e9800998ecf8427e', 1, '2022'),
(901, 'PurpleCNA', 'CNA', 'MedId1591', 'd41d8cd98f00b204e9800998ecf8427e', 1, '2022'),
(902, 'WhiteRN', 'RN', 'MedId2053', 'd41d8cd98f00b204e9800998ecf8427e', 1, '2022'),
(1035, 'Mi', 'wang', 'MedID1372', 'd41d8cd98f00b204e9800998ecf8427e', 1, '2022');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth`
--
ALTER TABLE `sudo_meds`.`auth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drugs`
--
ALTER TABLE `sudo_meds`.`drugs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drug_admins`
--
ALTER TABLE `sudo_meds`.`drug_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nurse_notes`
--
ALTER TABLE `sudo_meds`.`nurse_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `sudo_meds`.`patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_files`
--
ALTER TABLE `sudo_meds`.`patient_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `sudo_meds`.`users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth`
--
ALTER TABLE `sudo_meds`.`auth`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `drugs`
--
ALTER TABLE `sudo_meds`.`drugs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=279;

--
-- AUTO_INCREMENT for table `drug_admins`
--
ALTER TABLE `sudo_meds`.`drug_admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT for table `nurse_notes`
--
ALTER TABLE `sudo_meds`.`nurse_notes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `sudo_meds`.`patients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `patient_files`
--
ALTER TABLE `sudo_meds`.`patient_files`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `sudo_meds`.`users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1046;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
