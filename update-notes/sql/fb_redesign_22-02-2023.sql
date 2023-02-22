-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2023 at 04:46 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fb_redesign`
--
CREATE DATABASE IF NOT EXISTS `fb_redesign` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fb_redesign`;

-- --------------------------------------------------------

--
-- Table structure for table `breed`
--

CREATE TABLE `breed` (
  `id` int(11) NOT NULL,
  `breed_name` varchar(500) NOT NULL,
  `species` int(11) NOT NULL DEFAULT 1,
  `notes` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `breed`
--

INSERT INTO `breed` (`id`, `breed_name`, `species`, `notes`, `active`) VALUES
(11, 'Devon and Cornwall Longwool', 1, '', 1),
(12, 'Coloured Wensleydale', 1, '', 1),
(13, 'White Wensleydale', 1, '', 1),
(14, 'White Ryeland', 1, '', 1),
(15, 'Coloured Ryeland', 1, '', 1),
(16, 'Coloured Leicester Longwool', 1, '', 1),
(17, 'White Leicester Longwool', 1, '', 1),
(18, 'Coloured Blue Faced Leicester', 1, '', 1),
(19, 'White Blue Faced Leicester', 1, '', 1),
(20, 'X breed', 1, '', 1),
(21, 'Holstein', 1, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `farm_diary`
--

CREATE TABLE `farm_diary` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `entry` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `feed`
--

CREATE TABLE `feed` (
  `id` int(11) NOT NULL,
  `purchase_date` date DEFAULT NULL,
  `product_name` varchar(500) NOT NULL,
  `batch_number` varchar(500) DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `finished_date` date DEFAULT NULL,
  `purchased_from` varchar(500) DEFAULT NULL,
  `cost_per_item` float NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `feed_type` varchar(500) DEFAULT NULL,
  `feed_target` varchar(500) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feed`
--

INSERT INTO `feed` (`id`, `purchase_date`, `product_name`, `batch_number`, `expiration_date`, `finished_date`, `purchased_from`, `cost_per_item`, `quantity`, `feed_type`, `feed_target`, `notes`) VALUES
(25, '2018-11-30', 'Organic Allrounder 18%', '7336', '2019-02-27', '2018-12-12', 'CCF', 10.6, 4, 'nut', 'sheep', ''),
(26, '2018-11-30', 'Oyster shell', '', NULL, '2018-12-17', 'CCF', 0.4, 1, 'supplement', 'Chickens', 'To be added to layers pellets'),
(27, '2018-12-04', 'Org all rounder', 'UID 0304099   7336.00', '2019-02-12', '2018-12-12', 'CCF', 10.6, 3, '25KG', 'sheep', ''),
(28, '2018-12-04', 'Organilyx plus bucket', '17c 5473/01', '2020-06-17', '2018-12-12', 'CCF', 31.05, 1, 'BUCKET', 'sheep', ''),
(29, '2018-12-08', 'Organyx plus bucket', '17c 5473/01', '2020-08-17', '2018-12-17', 'CCF', 31.05, 2, 'BUCKET', 'sheep', ''),
(34, '2018-12-17', 'Organyx plus bucket', '17 c 6504', '2020-10-02', '2018-12-31', 'CCF', 31.05, 2, 'BUCKET', 'sheep', ''),
(31, '2018-12-08', 'Organic Allrounder 18%', 'UID 0304109 ', '2019-02-10', '2018-12-22', 'ccf', 10.6, 5, 'nut', 'sheep', ''),
(32, '2018-12-08', '95% organic layers pellets', '', '2019-02-25', '2019-01-17', 'CCF', 13.95, 2, 'LAYERS PELLETS', 'Chickens', 'BN NOT VISIBLE ON BAG DUE TO WATER'),
(33, '2018-12-08', 'Poultry rearer -farmgate', 'P04240', '2019-01-16', '2019-01-17', 'CCF', 6.7, 2, 'CHICK REARER', 'Chickens', ''),
(35, '2018-12-17', 'Oyster Shell', '', NULL, '2019-01-29', 'CCF', 0.53, 1, 'supplement', 'Chickens', ''),
(36, '2018-12-21', 'Garlyx feed bucket', '16c 5089/04', '2020-07-26', '2019-01-17', 'ccf', 25.3, 2, 'bucket', 'sheep', ''),
(37, '2018-12-21', 'organic all rounder 18%', 'UID 0304122', '2019-02-20', '2018-12-31', 'ccf', 10.6, 6, 'nut', 'sheep', ''),
(38, '2018-12-21', 'Organyx plus bucket', '17cJ473/01', '2020-06-17', '2019-01-17', 'ccf', 31.05, 1, 'bucket', 'sheep', ''),
(39, '2018-12-27', 'organic all rounder 18%', 'UID 0304129', '2019-02-12', '2019-01-17', 'CCF', 10.6, 3, 'nut', 'sheep', ''),
(40, '2019-01-02', 'Fargate poultry rearer', '25232', '2019-01-16', '2019-02-13', 'CCF', 6.7, 2, 'bag', 'Chickens', '17/1/19. Just noticed that this product has coccidiostats in it an there is a 5 day withdrawl period'),
(41, '2019-01-02', 'Organic Allrounder 18%', 'UID 0697216', '2019-03-30', '2019-01-22', 'CCF', 10.6, 6, 'bag', 'sheep', ''),
(42, '2019-01-02', 'Organic Layers pellets', '25480', '2019-03-18', '2019-02-13', 'CCF', 13.95, 2, 'bag', 'Chickens', ''),
(43, '2019-01-02', 'Organyx plus bucket', '18c 5862/01', '2021-06-22', '2019-01-29', 'CCF', 31.05, 2, 'bucket', 'sheep', ''),
(44, '2019-01-08', 'CCF cent ewe extra care', '1352787', '2019-05-24', '2019-01-22', 'CCF', 7.55, 3, 'bag', 'sheep', 'Organic not available \r\nThis was purchased for livestock mart ram lambs only'),
(45, '2019-01-11', 'Garlyx feed bucket', '', NULL, '2019-06-04', 'CCF', 25.3, 2, 'bucket', 'sheep', 'For in-lambs ewes and replacement ewe lambs'),
(46, '2019-01-11', 'Organic Allrounder 18%', 'uid 9557754', '2019-04-13', '2019-01-22', 'CCF', 10.6, 6, 'bag', 'sheep', ''),
(47, '2019-01-18', 'organic all rounder 18%', 'uid 9557772', '2019-04-13', '2019-01-29', 'CCF', 10.6, 6, 'nut', 'sheep', ''),
(48, '2019-01-25', 'Lifeline lamb and ewe ', '8284', '2020-04-12', '2019-02-13', 'ccf', 19.75, 1, 'bucket', 'in-lamb ewes', 'Too early too feed but some ewes loosing weight and asking for food'),
(49, '2019-01-25', 'Organyx plus bucket', '18c 5862/01', '2021-06-22', '2019-02-13', 'ccf', 31.05, 1, 'bucket', 'sheep', ''),
(50, '2019-01-25', 'Organic Allrounder 18%', 'UID 0684314', '2019-07-08', '2019-02-13', 'CCF', 10.6, 6, 'nut', 'SHEEP', ''),
(51, '2019-01-25', 'Lump rock salt', '', NULL, '2019-06-04', 'CCF', 7.45, 25, 'supplement', 'everyone', ''),
(52, '2019-01-25', 'Oyster Shell', '', NULL, '2019-06-04', 'ccf', 0.39, 0, 'supplement', 'hens', ''),
(53, '2019-01-29', 'Life line ewe and lamb', '', NULL, '2019-03-11', 'CCF', 19.75, 3, 'bucket', 'ewes', ''),
(54, '2019-01-29', 'Org allrounder 18% nut', 'UID0297354', '2019-07-09', '2019-02-13', 'CCF', 10.6, 2, 'NUT', 'SHEEP', ''),
(55, '2019-01-29', 'Apple Cider vinegar', '', '2020-04-30', '2019-06-04', 'CCF', 14.5, 0, 'supplement', 'all animals on farm', ''),
(56, '2019-02-04', 'Lifeline lamb and ewe ', '', NULL, '2019-03-11', 'CCF', 19.75, 2, 'bucket', 'sheep', ''),
(57, '2019-02-07', 'Org allrounder 18% nut', 'UID 0297344', '2019-07-09', '2019-02-13', 'CCF', 10.8, 6, 'NUT', 'SHEEP', ''),
(58, '2019-02-07', 'SUGER BEET PELLETS', '', '2020-01-31', '2019-02-13', 'ccf', 7.25, 1, 'NUT', 'SHEEP', 'PURCHASED TO ADD ENERGY + CALLORIES TO DIET AS SOME SHEEP BELOW 3.5 BODY SCORE'),
(59, '2019-02-07', 'organic all rounder 18%', 'uid 0304124', '2019-12-12', '2019-02-13', 'ccf', 10.8, 6, 'nut', 'sheep', ''),
(60, '2019-02-07', 'SUGER BEET PELLETS', '', '2020-01-31', '2019-02-13', 'CCF', 7.25, 1, 'nut', 'sheep', ''),
(61, '2019-02-11', 'Organyx plus bucket', '18c 5826/01', '2021-06-22', '2019-03-11', 'ccf', 31.05, 3, 'bucket', 'sheep', ''),
(62, '2019-02-11', 'sheep extra high energy', '18c 5915', '2020-08-22', '2019-03-11', 'ccf', 21.2, 1, 'bucket', 'ewes', ''),
(63, '2019-02-11', 'SUGER BEET PELLETS', '', '2020-01-31', '2019-03-11', 'ccf', 7.25, 1, 'nut', 'sheep', ''),
(64, '2019-02-11', 'Org allrounder 18% nut', 'uid 0684326', '2019-07-08', '2019-03-11', 'ccf', 10.8, 4, 'nut', 'sheep', ''),
(65, '2019-02-11', 'Organilyx plus bucket', '18c 5862/01', '2021-06-21', '2019-03-11', 'CCF', 31.05, 3, 'bucket', 'sheep', ''),
(66, '2019-02-11', 'Extra energy rumenco', '18 c 5915', '2020-08-22', '2019-03-11', 'ccf', 21.2, 1, 'bucket', 'sheep', ''),
(67, '2019-02-11', 'Org allrounder 18% nut', 'uid 0687124', '2019-08-25', '2019-03-11', 'ccf', 10.8, 4, 'nut', 'sheep', ''),
(68, '2019-02-11', 'sugar beet', '', NULL, '2019-03-11', 'ccf', 7.25, 1, 'nut', 'sheep', ''),
(69, '2019-02-13', 'sugar beet ', '', NULL, '2019-03-11', 'ccf', 7.25, 1, 'nut', 'sheep', ''),
(70, '2019-02-13', 'Org allrounder 18% nut', 'uid0297093', '2019-07-09', '2019-03-11', 'ccf', 10.8, 4, 'nut', 'sheep', ''),
(71, '2019-02-18', 'sugar beet ', '', NULL, '2019-03-11', 'ccf', 7.25, 1, 'nut', 'sheep', ''),
(72, '2019-02-18', 'Org allrounder 18% nut', 'uid 0297094', '2019-07-09', '2019-03-11', 'ccf', 10.8, 2, 'nut', 'sheep', ''),
(73, '2019-02-18', 'extra energy rumenco', '18c 5915/08', '2020-08-22', '2019-03-11', 'ccf', 21.2, 2, 'bucket', 'sheep', ''),
(74, '2019-02-22', 'sugar beet ', '', NULL, '2019-03-11', 'ccf', 7.25, 3, 'nut', 'sheep', ''),
(75, '2019-03-22', 'extra energy rumenco', '18c 5915 /08', '2020-08-22', '2019-06-04', 'ccf', 21.2, 2, 'bucket', 'sheep', ''),
(76, '2019-02-22', 'Org allrounder 18% nut', 'uid 0297088', '2019-08-09', '2019-03-11', 'ccf', 10.8, 4, 'nut', 'sheep', ''),
(77, '2019-03-28', 'extra energy rumenco', '', NULL, '2019-06-04', 'ccf', 21.2, 4, 'bucket', 'sheep', ''),
(78, '2019-02-28', 'Lifeline lamb and ewe ', '', NULL, '2019-06-04', 'ccf', 19.75, 1, 'bucket', 'sheep', ''),
(79, '2019-02-28', 'Organic Layers pellets', 'P05028', '2019-04-23', '2019-06-04', 'ccf', 13.95, 1, 'nut', 'hens', ''),
(80, '2019-03-06', 'organic all rounder 18%', '', NULL, '2019-06-04', 'CCF', 10.7, 4, 'nut', 'ewes', ''),
(81, '2019-03-06', 'SUGER BEET PELLETS', '', NULL, '2019-06-04', 'ccf', 7.25, 2, 'nut', 'ewes', ''),
(82, '2019-03-06', 'Organic Layers pellets', '', NULL, '2019-06-04', 'ccf', 13.95, 1, 'nut', 'Chickens', ''),
(83, '2019-03-13', 'sugar beet ', '', NULL, '2019-06-04', 'ccf', 7.25, 2, 'nut', 'ewes', ''),
(84, '2019-03-13', 'Org allrounder 18% nut', '', NULL, '2019-06-04', 'ccf', 10.8, 4, 'nut', 'ewes', ''),
(85, '2019-05-10', 'Organic Layers pellets', '', NULL, '2019-06-04', 'ccf', 13.95, 2, 'nut', 'Chickens', ''),
(86, '2019-05-10', 'Lump rock salt', '', NULL, '2019-09-06', 'ccf', 7.45, 2, 'supplement', 'sheep', ''),
(87, '2019-05-10', 'Org allrounder 18% nut', '', NULL, '2019-06-04', 'ccf', 11, 1, 'nut', 'ewes', ''),
(88, '2019-03-16', 'Organic Layers pellets', '', NULL, '2019-06-04', 'ccf', 13.95, 1, 'nut', 'Chickens', ''),
(89, '2019-03-16', 'extra high energy ', '', NULL, '2019-06-04', 'ccf', 21.2, 1, 'bucket', 'ewes', ''),
(90, '2019-03-27', 'Organic Layers pellets', '', NULL, '2019-06-04', 'ccf', 13.95, 1, 'nut', 'Chickens', ''),
(91, '2019-03-08', 'Lifeline lamb and ewe ', '', NULL, NULL, 'ccf', 19.75, 1, 'bucket', 'ewes', ''),
(92, '2019-04-12', 'extra high energy ', '', NULL, '2019-06-04', 'ccf', 21.2, 2, 'bucket', 'ewes', ''),
(93, '2019-04-12', 'Lump rock salt', '', NULL, '2019-09-06', 'ccf', 7.45, 1, 'supplement', 'sheep', ''),
(94, '2019-04-18', 'Organic Layers pellets', '', NULL, '2019-06-04', 'ccf', 13.95, 1, 'nut', 'Chickens', ''),
(95, '2019-04-18', 'Volac Lamlac 25kg', '100523D', NULL, '2019-06-04', 'ccf', 52.5, 1, 'Milk powder', 'Cade lambs', ''),
(96, '2019-04-18', 'start to finish lamb pellets', '', NULL, '2019-06-04', 'ccf', 7.2, 1, 'nut', 'Cade lambs', ''),
(97, '2019-03-30', 'SUGER BEET PELLETS', '', NULL, '2019-06-04', 'ccf', 7.25, 2, 'nut', 'ewes', ''),
(98, '2019-03-21', 'extra high energy ', '', NULL, '2019-06-04', 'ccf', 21.2, 2, 'bucket', 'ewes', ''),
(99, '2019-03-21', 'SUGER BEET PELLETS', '', NULL, '2019-06-04', 'ccf', 7.25, 3, 'nut', 'ewes', ''),
(100, '2019-03-21', 'Org allrounder 18% nut', '', NULL, '2019-06-04', 'ccf', 10.8, 3, 'nut', 'sheep', ''),
(101, '2019-04-03', 'SUGER BEET PELLETS', '', NULL, '2019-06-04', 'ccf', 7.25, 2, 'nut', 'ewes', ''),
(102, '2019-04-30', 'Volac Lamlac 25kg', '', NULL, '2019-06-04', 'ccf', 52.5, 1, 'Milk powder', 'Cade lambs', ''),
(103, '2019-04-30', 'SUGER BEET PELLETS', '', NULL, '2019-06-04', 'ccf', 7.25, 1, 'nut', 'ewes', ''),
(104, '2019-04-30', 'Org allrounder 18% nut', '', NULL, '2019-06-04', 'ccf', 10.8, 1, 'nut', 'ewes', ''),
(105, '2019-04-30', 'Organic Layers pellets', '', NULL, '2019-06-04', 'ccf', 13.95, 1, 'nut', 'Chickens', ''),
(106, '2019-05-01', 'Apple Cider vinegar 5l', 'AC345', '2020-04-30', '2019-09-06', 'ccf', 14.5, 1, 'supplement', 'everyone', ''),
(107, '2019-05-15', 'Garlyx feed bucket', '', NULL, '2019-09-06', 'ccf', 25.3, 3, 'bucket', 'everyone', ''),
(108, '2019-05-28', 'start to finish lamb pellets', '', NULL, '2019-09-06', 'ccf', 6.8, 1, 'nut', 'Cade lambs', ''),
(109, '2019-05-28', 'Org allrounder 18% nut', '', NULL, '2019-09-06', 'ccf', 11, 1, 'nut', 'ewes', ''),
(110, '2019-05-30', 'Volac Lamlac 5kg', '', NULL, '2019-09-06', 'ccf', 12.85, 1, 'Milk powder', 'Cade lambs', ''),
(113, '2019-07-19', 'Organyx plus bucket', '18C5862/01', '2021-06-22', '2019-12-11', 'CCF', 31.05, 2, 'bucket', 'sheep', ''),
(112, '2019-06-26', 'Organic Layers pellets', '', NULL, '2019-09-06', 'CCF', 13.95, 2, '', 'hens', ''),
(114, '2019-07-19', 'Organic Layers pellets', '', NULL, '2019-09-06', 'ccf', 13.95, 1, '25KG bag', 'hens', ''),
(115, '2019-08-03', 'Organic Layers pellets', '', NULL, '2019-09-06', 'CCF', 13.95, 1, '25KG bag', 'hens', ''),
(116, '2019-08-23', 'Organic Layers pellets', '', NULL, '2019-09-06', 'CCF', 13.95, 1, '25KG bag', 'hens', ''),
(117, '2019-08-23', 'SUGER BEET PELLETS', '', NULL, '2019-09-06', 'CCF', 6.9, 1, '25KG bag', 'THIN EWE', ''),
(118, '2019-09-05', 'Apple Cider vinegar 5l', 'AC508', '2022-02-01', '2020-06-13', 'CCF', 14.5, 1, 'supplement', 'everyone', ''),
(119, '2019-09-05', 'Farm gate chick crumbs', 'SEQ 41397 VER 9271', '2019-10-21', '2019-12-11', 'ccf', 7.1, 1, '20kg', 'chicks', ''),
(120, '2019-09-05', 'Organyx plus bucket', '18c 5862/01', '2021-06-22', '2019-12-11', 'ccf', 31.05, 1, 'bucket', 'sheep', ''),
(121, '2019-08-01', 'CCF cent layers pellets ', '', NULL, '2019-09-13', 'ccf', 6.85, 1, '20kg', 'hens', 'organic not available'),
(122, '2019-08-01', 'Organilyx plus bucket', '', NULL, '2019-12-11', 'ccf', 31.05, 2, 'bucket', 'sheep', ''),
(123, '2019-08-01', 'Oyster Shell', '', NULL, '2019-12-11', 'ccf', 0.55, 0, 'supplement', 'hens', ''),
(124, '2019-09-06', 'Organyx plus bucket', '18c5812/01', '2021-06-01', '2019-12-11', 'ccf', 31.05, 1, 'bucket', 'sheep', ''),
(125, '2019-09-06', 'Organic Layers pellets', 'EQ 17205 VER 8451', '2019-12-04', '2019-12-11', 'ccf', 13.95, 2, '25KG bag', 'hens', ''),
(126, '2019-09-06', 'sugar beet', '', NULL, '2019-12-11', 'ccf', 6.9, 1, '25KG bag', 'cades', ''),
(127, '2019-09-06', 'organic all rounder 18%', '1737402', '2019-10-12', '2019-12-11', 'ccf', 11, 2, '25KG bag', 'cades and thin ewe', ''),
(128, '2019-09-06', 'Lump rock salt', '', NULL, '2020-06-26', 'ccf', 7.45, 2, 'supplement', 'everyone', ''),
(129, '2019-10-10', 'SUGER BEET PELLETS', '076427', NULL, '2019-12-11', 'CCF', 6.9, 2, '25KG', 'Thin lambs and one ewe', ''),
(130, '2019-10-10', 'Org all rounder', '2247720', '2020-01-31', '2019-12-11', 'CCF', 11, 2, '25KG bag', 'sheep', ''),
(131, '2019-10-10', 'Org layers pellets', 'P05028', '2019-12-31', '2019-12-11', 'ccf', 13.95, 2, '25KG bag', 'hens', ''),
(132, '2019-10-10', 'Organyx plus bucket', '19c/6173/01', '2022-03-11', '2019-12-11', 'ccf', 31.05, 3, 'bucket', 'sheep', ''),
(133, '2019-10-10', 'Farm gate chick crumbs', '', NULL, '2019-12-11', 'ccf', 7.1, 1, '20kg', 'chicks', ''),
(134, '2019-10-10', 'Poultry rearer -farmgate', '', NULL, '2019-12-11', 'ccf', 6.4, 1, '20kg', 'chicks', ''),
(135, '2019-12-05', 'Org allrounder 18% nut', 'uid 2534800', '2020-03-15', '2020-06-13', 'ccf', 10.9, 2, '25KG', 'lambs', ''),
(136, '2019-12-05', 'Organyx plus bucket', '', NULL, NULL, 'ccf', 31.05, 2, 'bucket', 'everyone', ''),
(137, '2019-11-26', 'Organyx plus bucket', '', NULL, '2019-12-11', 'ccf', 31.05, 5, 'bucket', 'everyone', ''),
(138, '2019-11-26', 'Org allrounder 18% nut', 'uid 2534798', '2020-03-27', '2019-12-11', 'ccf', 10.9, 3, '25KG bag', 'lambs', ''),
(139, '2019-11-28', 'sugar beet ', '186838', NULL, '2020-06-30', 'ccf', 5.95, 1, 'nut', 'ram lambs', ''),
(140, '2019-11-08', 'Organyx plus bucket', '19c6201', '2022-04-01', '2019-12-11', 'ccf', 31.05, 3, 'bucket', 'everyone', ''),
(141, '2019-11-08', 'Org allrounder 18% nut', 'uid 3531849', '2020-03-10', '2019-12-11', 'ccf', 10.9, 3, '25KG bag', 'lambs', ''),
(142, '2019-10-24', 'Organyx plus bucket', '19c6201/01', '2022-04-01', '2019-12-11', 'ccf', 31.05, 2, 'bucket', 'everyone', ''),
(143, '2019-10-24', 'Org allrounder 18% nut', 'IUD 2531878', '2020-03-10', '2019-12-11', 'ccf', 10.9, 2, '25KG bag', 'lambs', ''),
(144, '2019-10-24', 'sugar beet ', '265z42jf', NULL, '2019-12-11', 'ccf', 5.8, 2, 'nut', 'ram lambs', ''),
(145, '2019-11-12', 'Organyx plus bucket', '19c6173/01', '2022-02-11', '2019-12-11', 'ccf', 31.05, 3, 'bucket', 'everyone', ''),
(146, '2019-11-12', 'Org allrounder 18% nut', 'UID 2261507', '2020-02-10', '2019-12-11', 'ccf', 10.9, 3, '25KG bag', 'lamb', ''),
(147, '2019-11-12', 'Poultry rearer -farmgate', 'p04240 ', '2020-01-29', '2019-12-11', 'ccf', 6.4, 1, '20kg bag', 'young hens', ''),
(148, '2020-02-22', 'Sheep extra high energu', '', NULL, NULL, 'ccf', 21.2, 3, 'bucket', 'in lamb ewes', ''),
(149, '2020-02-24', 'Organic All-rounder', '3374293', '2020-05-05', '2020-06-26', 'ccf', 10.9, 3, 'bag', 'everyone', ''),
(150, '2020-02-24', 'ACV 5L', 'AC543', '2022-07-30', '2020-06-13', 'ccf', 14.5, 1, 'supplement', 'everyone', ''),
(151, '2020-02-26', 'Organic All-rounder', '3374293', '2020-05-05', '2020-06-26', 'ccf', 10.9, 6, 'bag', 'everyone', ''),
(152, '2020-02-26', 'Sheep extra high energy', '', NULL, NULL, 'ccf', 21.2, 2, 'bucket', 'in lamb ewes', ''),
(153, '2020-02-20', 'Organic All-rounder', '3686545', '2020-07-14', '2020-06-13', 'ccf', 10.9, 8, 'bag', 'everyone', ''),
(154, '2020-02-20', 'organic layers pellets', '3517305', '2020-04-18', '2020-06-13', 'ccf', 7.75, 1, 'bag', 'hens', ''),
(155, '2020-02-19', 'Organyx plus lick', '', NULL, NULL, 'ccf', 31.05, 1, 'bucket', 'everyone', ''),
(156, '2020-02-19', 'Sheep extra high energy', '19c6307/03', NULL, NULL, 'ccf', 21.2, 2, 'bucket', 'in lamb ewes', ''),
(157, '2020-01-02', 'Organyx plus lick', '19c6173/01', '2022-03-11', '2020-06-13', 'ccf', 31.05, 4, 'bucket', 'everyone', ''),
(158, '2020-01-02', 'Organic All-rounder', '3486747', '2020-07-24', '2020-06-13', 'ccf', 10.9, 2, 'bucket', 'everyone', ''),
(159, '2020-01-02', 'sugar beet pellets', '8006209', NULL, '2020-06-30', 'ccf', 5.95, 1, 'bag', 'ram lambs', ''),
(160, '2020-01-02', 'lump rock salt', '', NULL, '2020-06-30', 'ccf', 7.45, 1, 'supplement', 'everyone', ''),
(161, '2020-01-02', 'organic layers pellets', '', NULL, NULL, 'ccf', 13.95, 2, 'bag', 'hens', ''),
(162, '2020-01-10', 'poultry rearer', 'p04240', '2020-02-04', '2020-06-13', 'ccf', 6.65, 1, 'bag', 'chicks', ''),
(163, '2020-01-16', 'ACV 5L', '', NULL, '2020-06-13', 'ccf', 11.5, 1, 'supplement', 'everyone', ''),
(164, '2020-01-02', 'Organyx plus lick', '', NULL, NULL, 'ccf', 31.05, 4, 'bucket', 'everyone', ''),
(165, '2019-12-23', 'Organic All-rounder', '2334764', '2020-03-23', '2020-06-26', 'ccf', 10.9, 1, 'bag', 'everyone', ''),
(166, '2019-12-23', 'Organyx plus lick', '', NULL, NULL, 'ccf', 31.05, 2, 'bucket', 'everyone', ''),
(167, '2019-12-20', 'poultry rearer', '', NULL, NULL, 'ccf', 6.4, 1, 'bag', 'chicks', ''),
(168, '2019-12-20', 'organic layers pellets', '', NULL, NULL, 'ccf', 13.95, 1, 'bag', 'hens', ''),
(169, '2019-12-20', 'Organic All-rounder', '2334764', '2020-03-23', '2020-06-26', 'ccf', 10.9, 2, 'bag', 'everyone', ''),
(170, '2020-01-31', 'lifeline lamb and ewe', '', NULL, '2020-06-26', 'ccf', 1990, 2, 'bucket', 'in lamb ewes', ''),
(171, '2020-01-31', 'Organyx plus lick', '', NULL, NULL, 'ccf', 31.05, 1, 'bucket', 'everyone', ''),
(172, '2020-01-31', 'Organic All-rounder', '3675218', '2020-07-06', '2020-07-06', 'ccf', 10.9, 4, 'bag', 'everyone', ''),
(173, '2020-01-15', 'Organyx plus lick', '', NULL, NULL, 'ccf', 31.05, 4, 'bucket', 'everyone', ''),
(174, '2020-01-15', 'Organic All-rounder', '3505092', '2020-06-10', '2020-06-13', 'ccf', 10.9, 6, 'bag', 'everyone', ''),
(175, '2020-01-15', 'organic layers pellets', '', NULL, NULL, 'ccf', 13.95, 1, 'bag', 'hens', ''),
(176, '2020-02-05', 'oyster shell', '', NULL, '2020-07-06', 'ccf', 0.55, 1, 'supplement', 'hens', ''),
(177, '2020-02-05', 'Organyx plus lick', '19c5201/01', '2022-04-01', '2020-06-13', 'ccf', 31.05, 1, 'bucket', 'everyone', ''),
(178, '2020-02-05', 'Sheep extra high energy', '19HP0508', '2021-09-11', '2020-06-13', 'ccf', 21.2, 1, 'bucket', 'in lamb ewes', ''),
(179, '2020-02-05', 'Organic All-rounder', '3505281', '2020-06-10', '2020-06-13', 'ccf', 10.9, 6, 'bag', 'everyone', ''),
(180, '2020-02-05', 'organic layers pellets', 'P05028', '2020-04-29', '2020-06-13', 'ccf', 13.95, 2, 'bag', 'hens', ''),
(181, '2020-01-24', 'Organyx plus lick', '', NULL, NULL, 'ccf', 31.05, 4, 'bucket', 'everyone', ''),
(182, '2020-01-24', 'Organic All-rounder', '3675218', '2020-07-06', '2020-07-06', 'ccf', 10.9, 6, 'bag', 'everyone', ''),
(183, '2020-01-08', 'Organyx plus lick', '19c6201/01', '2022-04-01', '2020-06-13', 'ccf', 31.05, 2, 'bucket', 'everyone', ''),
(184, '2020-01-08', 'Organic All-rounder', '3505124', '2020-06-10', '2020-06-13', 'ccf', 10.9, 6, 'bag', 'everyone', ''),
(185, '2019-12-16', 'Organyx plus lick', '19c6201', '2022-04-01', '2020-06-13', 'ccf', 31.05, 3, 'bucket', 'everyone', ''),
(186, '2019-12-16', 'Organic All-rounder', '3374812', '2020-05-05', '2020-06-13', 'ccf', 10.9, 1, 'bag', 'everyone', ''),
(187, '2019-12-16', 'Sugarbeet pellets', '26524ZJF', NULL, '2020-06-30', 'ccf', 5.95, 1, 'bag', 'ram lambs', ''),
(188, '2019-12-12', 'Organic All-rounder', '2334764', '2020-03-23', '2020-06-26', 'ccf', 10, 1, 'bag', 'everyone', ''),
(189, '2020-02-12', 'Organyx plus lick', '19c6136/01', '2022-03-18', '2020-06-13', 'ccf', 31.05, 1, 'bucket', 'everyone', ''),
(190, '2020-02-12', 'Sheep extra high energy', '19c6307/03', '2021-09-21', '2020-06-13', 'ccf', 21.2, 2, 'bucket', 'in lamb ewes', ''),
(191, '2020-02-12', 'Organic All-rounder', '3670682', '2020-06-04', '2020-06-13', 'ccf', 10.9, 4, 'bag', 'everyone', ''),
(192, '2020-05-18', 'Organic All-rounder', '', NULL, NULL, 'ccf', 11.15, 2, 'bag', 'sheep', ''),
(193, '2020-05-18', 'Sheep extra high energy', '', NULL, NULL, 'ccf', 22.25, 2, 'bucket', 'ewes and lambs', ''),
(194, '2020-05-18', 'chick crumbs- loose', 'non on bag as loose', NULL, '2020-06-26', 'ccf', 1.15, 1, 'bag', 'chicks', 'Gave away as didn\'t need'),
(195, '2020-06-05', 'Organyx plus lick', '', NULL, NULL, 'ccf', 31.05, 1, 'bucket', 'rams', ''),
(196, '2020-06-05', 'Sheep extra high energy', '', NULL, NULL, 'ccf', 22.25, 2, 'bucket', 'ewes and lambs', ''),
(197, '2020-06-05', 'Organic All-rounder', '4397473', '2020-11-11', '2020-06-30', 'ccf', 11.15, 3, 'bag', 'ewes and lambs', ''),
(198, '2020-06-05', 'organic layers pellets', '', NULL, NULL, 'ccf', 13.95, 1, 'bag', 'hens', ''),
(199, '2020-05-12', 'Sheep extra high energy', '20hp0303', '2022-03-11', '2020-06-26', 'ccf', 22.25, 3, 'bucket', 'ewes and lambs', ''),
(200, '2020-05-12', 'Organic All-rounder', '4387445', '2020-10-05', '2020-06-26', 'ccf', 11.15, 2, 'bag', 'ewes and lambs', ''),
(201, '2020-05-12', 'lump rock salt', '', NULL, NULL, 'ccf', 7.45, 1, 'supplement', 'everyone', ''),
(202, '2020-05-12', 'Volac lamlac', '25101', '2021-03-10', NULL, 'ccf', 12.85, 5, 'bag', 'lamb', ''),
(203, '2020-05-12', 'ACV 25L', 'ac592', '2023-03-01', '2020-07-06', 'ccf', 66.5, 1, 'supplement', 'everyone', ''),
(204, '2020-03-25', 'organic layers pellets', 'po5028', '2020-12-23', '2020-06-26', 'ccf', 13.95, 4, 'bag', 'hens', ''),
(205, '2020-03-25', 'ACV 5L', 'ac577', '2022-12-30', '2020-06-26', 'ccf', 14.5, 1, 'supplement', 'everyone', ''),
(206, '2020-03-27', 'Organic All-rounder', '', NULL, NULL, 'ccf', 10.9, 6, 'bag', 'ewes and lambs', ''),
(207, '2020-03-27', 'sugar beet pellets', '', NULL, '2020-06-30', 'ccf', 5.95, 1, 'bag', 'ewes and lambs', ''),
(208, '2020-03-02', 'organic layers pellets', '', NULL, NULL, 'ccf', 13.95, 2, 'bag', 'hens', ''),
(209, '2020-03-02', 'volac lamlac 5kg', '100658d', NULL, '2020-06-30', 'ccf', 12.85, 1, 'bag', ' lambs', ''),
(210, '2020-03-04', 'Sheep extra high energy', '', NULL, NULL, 'ccf', 21.2, 3, 'bucket', 'ewes and lambs', ''),
(211, '2020-03-04', 'Organic All-rounder', '', NULL, NULL, 'ccf', 10.9, 8, 'bag', 'ewes and lambs', ''),
(212, '2020-03-24', 'Sheep extra high energy', '20c6448/12', '2022-01-24', '2020-06-26', 'ccf', 21.2, 3, 'bucket', 'ewes and lambs', ''),
(213, '2020-03-24', 'sugar beet pellets', '', NULL, '2020-06-30', 'ccf', 5.95, 2, 'bag', 'ewes and lambs', ''),
(214, '2020-03-24', 'Organic All-rounder', '3966337', '2020-08-23', '2020-06-26', 'ccf', 10.9, 6, 'bag', 'ewes and lambs', ''),
(215, '2020-04-09', 'sugar beet pellets', '', NULL, '2020-06-30', 'ccf', 5.95, 1, 'bag', 'ewes and lambs', ''),
(216, '2020-04-09', 'Organic All-rounder', '3965968', '2020-08-23', '2020-06-26', 'ccf', 10.9, 4, '', 'ewes and lambs', ''),
(217, '2020-02-29', 'Organyx plus lick', '19c6185/01', '2022-03-01', '2020-06-26', 'ccf', 31.05, 1, 'bucket', 'everyone', ''),
(218, '2020-02-29', 'Sheep extra high energy', '19c6390/13', '2021-12-05', '2020-06-26', 'ccf', 21.2, 1, 'bucket', 'ewes and lambs', ''),
(219, '2020-02-29', 'Organic All-rounder', '3688513', '2020-07-20', '2020-06-26', 'ccf', 10.9, 6, 'bag', 'ewes and lambs', ''),
(220, '2020-03-09', 'Sheep extra high energy', '19c6390/13', '2021-12-05', '2020-06-26', 'ccf', 21.2, 2, 'bucket', 'ewes and lambs', ''),
(221, '2020-03-09', 'Organic All-rounder', '3683481', '2020-07-20', '2020-06-26', 'ccf', 10.9, 10, 'bag', 'ewes and lambs', ''),
(222, '2020-03-13', 'Sheep extra high energy', '', NULL, NULL, 'ccf', 21.2, 2, 'bucket', 'ewes and lambs', ''),
(223, '2020-03-13', 'organic layers pellets', '3945651', '2020-06-06', '2020-06-26', 'ccf', 7.75, 2, 'bag', 'hens', ''),
(224, '2020-03-13', 'sugar beet pellets', '', NULL, '2020-06-30', 'ccf', 5.95, 2, 'bag', 'ewes and lambs', ''),
(225, '2020-03-13', 'Organic All-rounder', '3966365', '2020-08-23', '2020-06-26', 'ccf', 10.9, 10, 'bag', 'ewes and lambs', '');

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `id` int(11) NOT NULL,
  `gender` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`id`, `gender`) VALUES
(1, 'Male'),
(2, 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `livestock`
--

CREATE TABLE `livestock` (
  `id` int(11) NOT NULL,
  `species` int(11) NOT NULL,
  `livestock_name` text DEFAULT NULL,
  `gender` varchar(10) NOT NULL,
  `uk_tag_no` varchar(500) DEFAULT NULL,
  `previous_tags` varchar(255) CHARACTER SET ascii DEFAULT NULL,
  `for_slaughter` tinyint(4) NOT NULL DEFAULT 0,
  `pedigree_no` varchar(500) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `date_of_sale` date DEFAULT NULL,
  `date_of_death` date DEFAULT NULL,
  `mother` int(11) DEFAULT NULL,
  `father` int(11) DEFAULT NULL,
  `home_bred` tinyint(4) NOT NULL,
  `origin` text DEFAULT NULL,
  `breed` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `livestock`
--

INSERT INTO `livestock` (`id`, `species`, `livestock_name`, `gender`, `uk_tag_no`, `previous_tags`, `for_slaughter`, `pedigree_no`, `date_of_birth`, `date_of_sale`, `date_of_death`, `mother`, `father`, `home_bred`, `origin`, `breed`, `notes`, `deleted`) VALUES
(52, 1, 'test', '1', 'UK364829', '', 0, '23', '2018-12-03', NULL, NULL, 0, 0, 1, '', 11, '', 1),
(53, 1, '', '2', 'UK747668/00077 Z', '', 0, '', NULL, NULL, NULL, 0, 0, 0, 'From Polly Jones\r\nBlossom Field flock', 17, '', 1),
(54, 1, 'Kerswell Ledley- Ramsey', '1', 'UK 361856 / 1884', '', 0, 'DV1366', '2009-02-12', NULL, '2017-03-10', 0, 0, 0, 'Purchased from Mark Snell', 11, '', 0),
(55, 1, 'Brexworthy Desperate Dan', '1', 'UK 372272/00066', '', 0, 'DV2928', '2013-01-20', NULL, '2017-10-09', 0, 0, 0, 'Lesley Perret', 11, '', 0),
(56, 1, 'Kentisbeare Bernard - Eddy', '1', 'UK367680/00021', '', 0, 'DV2086', '2011-02-13', NULL, '2015-01-01', 0, 0, 0, '', 11, 'Sold', 0),
(57, 1, 'Ladygrove Icon - Ike', '1', 'UK0328084/00050', '', 0, '1180 12 050', '2013-03-13', NULL, '2019-01-23', 0, 0, 0, 'Jeni Thompson\r\nLadygrove', 12, '', 0),
(58, 1, 'Broadstone Samson', '1', 'Uk330859/00039', '', 0, '15-1336-039B', '2015-03-08', NULL, '2019-02-18', 70, 57, 1, '', 12, '', 0),
(59, 1, 'Broadstone White Jasper', '1', 'UK330859/00141', '', 0, 'DV3454', '2015-02-28', NULL, '2019-02-06', 128, 55, 1, '', 11, '', 0),
(60, 1, 'Jo-Jo', '2', 'UK330859/00218 RED', '', 0, '', '2011-02-28', NULL, '2020-01-08', 0, 0, 0, '', 15, '', 0),
(61, 1, 'Rebecca', '2', 'UK1428/404', '', 0, 'F34185', '2014-04-10', NULL, NULL, 0, 0, 0, 'Little Close Breeding', 14, '', 0),
(62, 1, 'Racheal', '2', 'UK01428/401', '', 0, 'F34182', '2014-04-06', NULL, NULL, 0, 0, 0, 'Little Close Breeding', 14, '', 0),
(63, 1, 'Morgan', '1', 'uk330859/00219', '', 0, '', '2016-02-29', NULL, NULL, 0, 0, 0, '', 15, '', 0),
(64, 1, 'Ava', '2', 'uk754783/00062', '', 0, '', '2018-04-24', NULL, NULL, 62, 63, 1, '', 14, '', 0),
(65, 1, 'Kate', '2', 'UK728076/00111', '', 0, '', '2017-03-21', NULL, NULL, 0, 0, 0, '', 15, '', 0),
(66, 1, 'Bess', '2', 'UK754783/00064', '', 0, '', '2019-04-04', NULL, NULL, 60, 63, 1, '', 15, '', 0),
(67, 1, 'Bex', '2', 'UK 754783/000143 ', '', 0, '', '2019-03-19', NULL, NULL, 61, 63, 1, '', 14, '', 0),
(68, 1, 'Blanche', '2', 'UK754783/00147 ', '', 0, '', '2019-03-26', NULL, NULL, 62, 63, 1, '', 14, '', 0),
(69, 1, 'Bonnie', '2', 'uk208565/00068 ', '', 0, '1259-14-068', '2014-01-01', NULL, NULL, 0, 0, 0, 'Purchased from Juli Hewins', 12, '', 0),
(70, 1, 'Tina', '2', '', '', 0, '660-09-915', '2009-01-01', NULL, '2019-01-16', 0, 0, 0, 'Purchased from Juli hewins', 12, 'Mother of Samson', 0),
(71, 1, 'Morag', '2', 'uk107504/00172', '', 0, '694/12/00032', '2012-01-01', NULL, NULL, 0, 0, 0, 'Purchased from Jayne Dryden and bred by Sheila Prescott', 13, '', 0),
(72, 1, '', '2', 'uk224407/0084', '', 0, '660/11/00084', '2011-01-01', NULL, '2020-01-08', 0, 0, 0, 'Purchased from Jayne Dryden and bred by Sue Holdich', 13, 'transfered to Crymych Mart', 0),
(73, 1, 'Anwen (Black)', '2', 'Uk754783/00061 ', '', 0, '', '2018-01-01', NULL, NULL, 71, 58, 1, '', 12, '', 0),
(74, 1, 'Alice', '2', 'Uk754783/00065 ', '', 0, '', '2018-01-01', NULL, NULL, 71, 58, 1, 'White dam\r\nBlack Sire', 13, 'Has coloured genes', 0),
(75, 1, 'Berry', '2', 'UK754783/00070 ', '', 0, '', '2019-04-03', NULL, NULL, 69, 58, 1, '', 12, '', 0),
(76, 1, 'Bridie', '2', 'UK754783/00083 ', '', 0, '', '2019-04-03', NULL, NULL, 69, 58, 1, '', 12, '', 0),
(77, 1, 'Beatrix', '2', 'uk754783/000136 ', '', 0, '', '2019-04-04', NULL, '2019-09-20', 72, 58, 1, '', 13, 'White dam\r\nBlack sire', 0),
(78, 1, 'Layla', '2', 'uk208233/00357 ', '', 0, '1308-16-0357', '2016-01-01', NULL, NULL, 0, 0, 0, 'Purchased from Jayne Dryden', 12, '', 0),
(79, 1, 'Audrey', '2', 'Uk754783/00073 ', '', 0, '1336-18-073', '2018-01-01', NULL, NULL, 69, 58, 1, '', 12, '', 0),
(80, 1, 'Sophie', '2', 'uk330859/00205 ', '', 0, '1336/16/205B', '2016-01-01', NULL, NULL, 69, 57, 1, '', 12, '', 0),
(81, 1, 'Belle', '2', 'uk208233/00558', '', 0, '', '2017-01-01', NULL, NULL, 0, 0, 0, 'Purchased from Jayne dryden', 19, '', 0),
(82, 1, 'Daisy', '2', 'uk208233/00314', '', 0, '', '2016-01-01', NULL, NULL, 0, 0, 0, 'Purchased from Jayne Dryden', 19, '', 0),
(83, 1, 'Bentley', '1', 'uk208233/00481 ', '', 0, '', '2017-01-01', '2020-07-10', NULL, 0, 0, 0, 'Purchased from Jayne Dryden', 18, '', 0),
(84, 1, 'Ada', '2', 'UK 754783/00052 ', '', 0, '', '2018-05-16', NULL, NULL, 0, 58, 1, 'D+C dam unknown', 20, '', 0),
(85, 1, 'Brenna', '2', 'Uk754783/00057 ', '', 0, '', '2019-03-23', NULL, NULL, 96, 58, 1, 'wensleydale - LL X', 20, '', 0),
(86, 1, 'Adelle', '2', 'UK 754783/00060 ', '', 0, '', '2018-01-01', NULL, '2020-01-22', 65, 83, 1, 'BFL - Ryeland X', 20, 'To crymych mart', 0),
(87, 1, 'Ebony', '2', 'UK330859/00126', '', 0, '', '2015-03-03', NULL, NULL, 60, 57, 1, '', 20, '', 0),
(88, 1, 'Justine', '2', 'UK330859/00127 ', '', 0, '', '2016-01-01', NULL, NULL, 94, 57, 0, 'Wensleydale - D+D/ryeland X', 20, '', 0),
(89, 1, 'Brandy', '2', 'UK754783 / 00149 ', '', 0, '', '2019-03-26', NULL, NULL, 95, 58, 1, 'wensleydale- LL X', 20, '', 0),
(90, 1, 'Bobbie', '2', 'Uk754783/00151 ', '', 0, '', '2019-04-18', NULL, '2020-01-22', 93, 83, 1, 'Llanwenog - BFL X', 20, 'To crymych mart', 0),
(91, 1, 'Braelyn', '2', 'UK754783/ 00152 ', '', 0, '', '2019-04-05', NULL, NULL, 88, 83, 1, 'BFL - D+C/Ryeland/ Wensleydale X', 20, '', 0),
(92, 1, 'Dolly', '2', 'UK 754783/00051', '', 0, '', '2018-01-01', NULL, '2020-01-22', 0, 0, 0, 'Speckled x texel', 20, 'To Crymych mart', 0),
(93, 1, 'Lucy', '2', 'red 330869/00225 ', '', 0, '', '2016-01-01', NULL, NULL, 0, 0, 0, 'Llanwenog- welsh mountain X', 20, '', 0),
(94, 1, 'Blue', '2', 'UK330859/00109  ', '', 0, '', '2013-01-01', NULL, '2018-11-21', 60, 56, 1, 'Ryeland - D+C x', 20, '', 0),
(95, 1, 'Hope', '2', 'UK328084/00036 ', '', 0, '', '2011-01-01', NULL, NULL, 0, 0, 0, 'From Jeni Thompson', 17, '', 0),
(96, 1, 'Joy', '2', 'Uk330859/  00176 ', '', 0, '', '2016-01-01', NULL, NULL, 95, 110, 1, '', 17, '', 0),
(97, 1, 'Ican', '2', 'UK747668/128G', '', 0, '', '2012-01-01', NULL, NULL, 0, 0, 0, 'From Ladygrove flock. Jeni Thompson', 17, '', 0),
(98, 1, 'Iris', '2', 'UK747668/00090 Z ', '', 0, '', '2018-01-01', NULL, NULL, 199, 0, 0, 'Blossom field flock- Polly Jones', 16, '', 0),
(99, 1, 'Imogen', '2', 'UK747668/00089 Z ', '', 0, '', '2018-01-01', NULL, NULL, 199, 0, 0, 'Blossom field flock - Polly Jones', 16, '', 0),
(100, 1, '', '2', 'UK747668/00088 Z', '', 0, '', NULL, NULL, NULL, 0, 0, 0, 'Blossom field - Polly Jones', 16, '', 0),
(101, 1, '', '2', 'UK747668/00080 Z', '', 0, '', '2017-01-01', NULL, NULL, 0, 0, 0, 'Blossom field - Polly Jones', 16, '', 0),
(102, 1, '', '2', 'UK747668/00077 Z', '', 0, '', NULL, NULL, NULL, 0, 0, 0, 'Blossom field - Polly Jones', 17, '', 0),
(103, 1, '', '2', ' UK747668/00027 P', '', 0, '', NULL, NULL, NULL, 0, 0, 0, 'Blossom field - Polly Jones', 17, '', 0),
(104, 1, '', '2', 'UK747668/00011 N', '', 0, '', NULL, NULL, NULL, 0, 0, 0, 'Blossom Filed Polly Jones', 17, '', 0),
(105, 1, '', '2', 'UK747668/00004 ', '', 0, '', NULL, NULL, NULL, 0, 0, 0, 'Blossom Filed - Polly Jones', 17, '', 0),
(106, 1, '', '2', 'UK747668/00003 H', '', 0, '', NULL, NULL, NULL, 0, 0, 0, 'Blossom Field - Polly Jones', 17, '', 0),
(107, 1, '', '2', 'UK747668/00001 M ', '', 0, '', NULL, NULL, '2020-01-08', 0, 0, 0, 'Blossom Field - Polly Jones', 16, '', 0),
(108, 1, 'IQ', '2', 'UK747668/00079 Z', '', 0, '', '2012-01-01', NULL, NULL, 0, 0, 0, 'Ladygrove flock', 17, '', 0),
(109, 1, 'Chester', '1', 'Uk330859/00180', '', 0, '', '2016-01-01', NULL, NULL, 95, 110, 1, '', 17, '', 0),
(110, 1, 'Romeo (windy ridge LAVENTERA)', '1', '', '', 0, '', NULL, NULL, '2017-12-20', 0, 0, 0, '', 17, '', 0),
(111, 1, 'Braya', '2', 'UK754783/00066 ', '', 0, '', '2019-03-15', NULL, NULL, 53, 112, 1, '', 17, '', 0),
(112, 1, 'Harry ', '1', 'uk747668/00086', '', 0, '', '2017-01-01', NULL, '2020-01-06', 0, 0, 0, 'Bred from polly Jones from Ladygrove Hero', 17, ' Heros Lad\r\nVERY poor sheep. Not good food conversion, kept getting pneumonia and cough. Slaughtered', 0),
(113, 1, 'Bettina', '2', 'UK754783/00133 ', '', 0, '', '2019-04-11', NULL, NULL, 101, 109, 1, '', 17, '', 0),
(114, 1, 'Brooklyn', '2', 'UK754783 / 00134 ', '', 0, '', '2019-04-13', NULL, NULL, 106, 109, 1, '', 17, '', 0),
(115, 1, 'Buttercup', '2', 'UK754783 / 00137 ', '', 0, '', '2019-04-14', NULL, NULL, 107, 109, 1, '', 17, 'Got coloured genes from Dam', 0),
(116, 1, 'Bluestar', '2', 'UK754783 / 00141 ', '', 0, '', '2019-04-11', NULL, NULL, 103, 109, 1, '', 17, '', 0),
(117, 1, 'Bronwyn', '2', 'UK754783/ 00145 ', '', 0, '', '2019-04-30', NULL, '2019-08-11', 105, 112, 1, '', 17, 'Cade\r\nWas a susceptible lamb from weaning and shearing. Collapsed in bad weather ?pneumonia ? neurological.', 0),
(118, 1, 'Brylea', '2', 'UK754783/ 00146 Brylea', '', 0, '', '2019-04-30', NULL, NULL, 105, 112, 1, '', 17, '', 0),
(119, 1, 'Eddy- Kentisbeare Bernard', '1', 'uk367680/00021', '', 0, 'DV2086', '2011-01-01', NULL, NULL, 0, 0, 0, 'Melvin Britton', 11, '', 1),
(120, 1, 'Danny - Brexworthy Desparate Dan', '1', 'UK372272/00066', '', 0, 'DV2928', '2013-01-01', NULL, '2017-10-10', 0, 0, 0, '', 11, '', 1),
(121, 1, '', '2', 'UK370111/7', '', 0, 'DV1492', '2009-01-01', NULL, '2019-03-17', 0, 0, 0, 'Bickham FLOCK', 11, '', 0),
(122, 1, 'Fly', '2', 'uk370111/370', '', 0, 'DV1480', '2009-01-01', NULL, NULL, 0, 0, 0, 'Bickham FLOCK', 11, '', 0),
(123, 1, 'Holly', '2', 'uk370111/00391', '', 0, 'DV1501', '2010-01-01', NULL, '2020-01-08', 0, 0, 0, 'Bickham FLOCK', 11, 'transferred to crymych mart', 0),
(124, 1, '', '2', 'UK330859/00005', '', 0, 'DV1921', '2011-01-01', NULL, NULL, 157, 54, 1, '', 11, '', 0),
(125, 1, 'Willow', '2', 'UK330859/00042', '', 0, 'DV2247', '2012-01-01', NULL, NULL, 122, 54, 1, '', 11, '', 0),
(126, 1, '', '2', 'UK330859/00073 ', '', 0, 'DV2830', '2013-01-01', NULL, '2020-01-22', 158, 56, 1, '', 11, 'To crymych mart', 0),
(127, 1, 'Wren', '2', 'UK330859/00076 ', '', 0, 'DV2833', '2013-01-01', NULL, NULL, 158, 56, 1, '', 11, '', 0),
(128, 1, 'Sapphire', '2', 'UK330859/00078 ', '', 0, 'DV2835', '2013-01-01', NULL, NULL, 156, 54, 1, '', 11, '', 0),
(129, 1, '', '2', 'uk330859/ 00082', '', 0, 'DV2838', '2013-01-01', NULL, NULL, 159, 54, 1, '', 11, '', 0),
(130, 1, 'Poppy', '2', 'UK330859/ 00034', '', 0, 'DV3014', '2014-01-01', NULL, NULL, 153, 56, 1, '', 11, '', 0),
(131, 1, '', '2', 'UK330859/00181', '', 0, 'DV3898', '2016-01-01', NULL, NULL, 153, 55, 1, '', 11, '', 0),
(132, 1, '', '2', 'UK330859/00182', '', 0, ':  DV3900', '2016-01-01', NULL, NULL, 124, 55, 1, '', 11, '', 0),
(133, 1, '', '2', 'UK330859/00183', '', 0, 'DV3899', '2016-01-01', NULL, NULL, 154, 55, 1, '', 11, '', 0),
(134, 1, 'Winnie', '2', 'UK330859/00185', '', 0, 'DV3897', '2016-01-01', NULL, NULL, 153, 55, 1, '', 11, '', 0),
(135, 1, '', '2', 'UK330859/00190', '', 0, 'DV3901', '2016-01-01', NULL, NULL, 154, 55, 1, '', 11, '', 0),
(136, 1, 'Wendy', '2', 'UK330859/00195', '', 0, 'DV3903', '2016-01-01', NULL, NULL, 130, 55, 1, '', 11, '', 0),
(137, 1, 'Winter', '2', 'UK330859/00201', '', 0, 'DV3893', '2016-01-01', NULL, NULL, 122, 55, 1, '', 11, '', 0),
(138, 1, '', '2', 'UK330859/00202', '', 0, 'DV3902', '2016-01-01', NULL, '2020-05-08', 158, 55, 1, '', 11, '', 0),
(139, 1, 'Paige', '2', 'UK330859/00050', '', 0, 'DV3449', '2015-01-01', NULL, NULL, 160, 55, 1, '', 11, '', 0),
(140, 1, 'Josie', '2', 'UK330859/00057', '', 0, 'DV3453', NULL, NULL, NULL, 154, 55, 1, '', 11, '', 0),
(141, 1, '', '2', 'UK330859/00060', '', 0, 'DV3447', '2015-01-01', NULL, NULL, 161, 55, 1, '', 11, '', 0),
(142, 1, 'Astra', '2', 'UK754783/ 00068  ', '', 0, 'DV4786', '2018-05-29', NULL, NULL, 163, 59, 1, '', 11, '', 0),
(143, 1, 'Alpha', '2', 'UK754783/00074 ', '', 0, 'DV4785', '2018-05-13', NULL, NULL, 162, 59, 1, '', 11, '', 0),
(144, 1, 'Andrea', '2', 'UK754783/00076 ', '', 0, 'DV4782', '2018-05-06', NULL, NULL, 125, 59, 1, '', 11, '', 0),
(145, 1, 'Amelia', '2', 'UK754783/00077 ', '', 0, 'DV4781', '2018-04-24', NULL, NULL, 124, 59, 1, '', 11, '', 0),
(146, 1, 'April', '2', 'UK754783/ 00078 ', '', 0, 'DV4783', '2018-05-13', NULL, NULL, 159, 59, 1, '', 11, '', 0),
(147, 1, 'Aisha', '2', 'UK754783/ 00079 ', '', 0, 'DV4784', '2018-05-29', NULL, NULL, 123, 59, 1, '', 11, '', 0),
(148, 1, 'Bluebelle', '2', 'UK754783/00069 ', '', 0, '', '2019-04-02', NULL, '2019-06-10', 152, 59, 1, '', 11, 'Drowned in cattle water trough- RIP little one xx', 0),
(149, 1, 'Blossom', '2', 'UK754783/00071 ', '', 0, '', '2019-04-02', NULL, '2020-04-29', 152, 59, 1, '', 11, 'Killed by  dog', 0),
(150, 1, 'Brooke', '2', 'UK754783/ 00072 ', '', 0, '', '2019-03-26', NULL, '2020-01-26', 139, 59, 1, '', 11, 'Found dead in CB2 this morning. Blood from nose . Probably pneumonia but no previous sign in this lamb', 0),
(151, 1, 'Brie', '2', 'UK754783/00080 ', '', 0, '', '2019-04-09', NULL, NULL, 126, 59, 1, '', 11, 'Birth certs not exactly right.GGS + GGD is missing', 0),
(152, 1, '', '2', 'UK330859/00074 ', '', 0, 'DV2831', '2013-01-01', NULL, '2019-04-23', 153, 56, 1, '', 11, '', 0),
(153, 1, 'Copper', '2', 'UK330859/00032 ', '', 0, 'DV1927', '2011-01-01', NULL, '2016-01-01', 122, 54, 1, '', 11, '', 0),
(154, 1, 'Mable', '2', 'UK330859/00077 ', '', 0, 'DV2834', '2013-01-01', NULL, '2016-01-01', 155, 56, 1, '', 11, '', 0),
(155, 1, '', '2', 'UK330859/00030', '', 0, 'DV1925', '2011-01-01', NULL, '2016-01-01', 164, 54, 1, '', 11, '', 0),
(156, 1, 'Flo', '2', 'uk37010111/315', '', 0, 'DV1489', '2008-01-01', NULL, '2013-01-01', 0, 0, 0, 'Bickham flock', 11, '', 0),
(157, 1, 'Lady', '2', 'uk370111/360', '', 0, 'DV1478', '2009-01-01', NULL, '2014-01-01', 0, 0, 0, 'Bickham ewe', 11, '', 0),
(158, 1, '', '2', 'UK330859/00004', '', 0, 'DV1920', '2011-01-01', NULL, '2018-07-10', 157, 54, 1, '', 11, '', 0),
(159, 1, '', '2', 'uk370101/368/369', '', 0, 'DV1486', '2009-01-01', NULL, '2019-01-16', 0, 0, 0, 'Bickham', 11, '', 0),
(160, 1, '', '2', 'uk370101/ 382/381', '', 0, 'DV1481', '2009-01-01', NULL, '2019-03-18', 0, 0, 0, 'Bickham', 11, '', 0),
(161, 1, 'Lamb', '2', 'uk370101/384  ', '', 0, 'DV1500', '2010-01-01', NULL, '2019-02-06', 0, 0, 0, 'Bickham', 11, '', 0),
(162, 1, 'Amber', '2', 'UK330859/00001 ', '', 0, 'DV1917', '2011-01-01', NULL, '2019-01-27', 156, 54, 1, '', 11, '', 0),
(163, 1, 'Star', '2', 'uk370101/390', '', 0, 'DV1503', '2010-01-01', NULL, '2019-03-15', 0, 0, 0, 'Bickham', 11, '', 0),
(164, 1, 'Sherman', '2', 'Uk370101/ 357', '', 0, 'DV1483', '2009-01-01', NULL, '2015-01-01', 0, 0, 0, 'Bickham', 11, '', 0),
(165, 1, '', '1', 'UK754783/ST', '', 1, '', '2019-03-19', NULL, '2019-08-21', 61, 63, 1, '', 14, 'crymych mart', 0),
(166, 1, '', '1', 'UK754783/ ST', '', 1, '', '2019-04-09', NULL, '2019-12-02', 126, 59, 1, '', 11, 'Guess on DOD', 0),
(167, 1, '', '2', 'UK754783/ ST', '', 1, '', '2019-03-30', NULL, NULL, 129, 59, 1, '', 11, 'entropian', 0),
(168, 1, '', '1', 'UK754783/ ST', '', 1, '', '2019-03-26', NULL, NULL, 123, 59, 1, '', 11, '', 0),
(169, 1, '', '1', 'UK754783/ ST', '', 1, '', '2019-04-04', NULL, '2019-12-16', 141, 59, 1, '', 11, 'Guess on DOD', 0),
(170, 1, '', '1', 'UK754783/ ST', '', 1, '', '2019-04-05', NULL, NULL, 131, 59, 1, '', 11, '', 0),
(171, 1, 'Captain Jack', '1', 'UK754783/ 00048', '', 0, '', '2019-04-04', NULL, '2019-10-07', 78, 58, 1, '', 12, 'died of ? fluke \r\nrecent spell of these type of deaths', 0),
(172, 1, '', '1', 'UK754783/ ST', '', 1, '', '2019-04-04', NULL, '2019-09-06', 72, 58, 1, '', 13, 'VERY thin, wormed, ate too much lick shits +++\r\nbullied by mum\r\ndehydrated---basically a right fuck up !', 0),
(173, 1, '', '1', 'UK754783/ ST', '', 1, '', '2019-03-30', NULL, '2019-09-02', 133, 109, 1, '', 20, '', 0),
(174, 1, '', '2', 'UK754783/ ST', '', 1, '', '2019-04-03', NULL, NULL, 132, 109, 1, '', 20, '', 0),
(175, 1, '', '2', 'UK754783/ ST', '', 1, '', '2019-03-29', NULL, NULL, 135, 109, 1, '', 20, '', 0),
(176, 1, '', '1', 'UK754783/ ST', '', 1, '', '2019-04-01', NULL, NULL, 127, 109, 1, '', 20, '', 0),
(177, 1, '', '2', 'UK754783/ ST', '', 1, '', '2019-03-25', NULL, NULL, 137, 109, 1, '', 20, '', 0),
(178, 1, '', '1', 'UK754783/ ST', '', 1, '', '2019-04-11', NULL, '2019-12-16', 103, 109, 1, '', 17, 'Guess on DOD', 0),
(179, 1, '', '1', 'UK754783/ ST', '', 1, '', '2019-04-08', NULL, NULL, 100, 109, 1, '', 17, '', 0),
(180, 1, '', '2', 'UK754783/ ST', '', 1, '', '2019-04-08', NULL, NULL, 100, 109, 1, 'entropian', 17, '', 1),
(181, 1, 'Byron', '1', 'UK754783/ 00063', '', 0, '', '2019-03-15', NULL, '2019-09-28', 0, 112, 1, '', 17, '', 0),
(182, 1, '', '2', 'Uk754783/ST', '', 1, '', '2019-03-27', NULL, NULL, 128, 109, 1, '', 20, '', 0),
(183, 1, '', '2', 'Uk754783/ST', '', 1, '', '2019-03-27', NULL, NULL, 128, 109, 1, '', 20, '', 0),
(184, 1, '', '2', 'Uk754783/ST', '', 1, '', '2019-04-04', NULL, '2019-04-25', 108, 109, 1, '', 17, 'entropian', 0),
(185, 1, '', '1', 'Uk754783/ST', '', 1, '', '2019-04-04', NULL, '2019-10-05', 108, 109, 1, '', 17, 'guess on DOD', 0),
(186, 1, '', '1', 'Uk754783/ST', '', 1, '', '2019-03-21', NULL, '2019-08-21', 82, 83, 1, '', 18, 'crymych mart', 0),
(187, 1, '', '1', 'Uk754783/ST', '', 1, '', '2019-03-21', NULL, '2019-08-21', 82, 83, 1, '', 18, 'crymych mart', 0),
(188, 1, '', '1', 'Uk754783/ST', '', 1, '', '2019-04-04', NULL, '2019-08-29', 81, 83, 1, '', 19, 'Found wrapped in elec fence and fly strike. Started to recover but I think ewes stood on  him trying to see what was in my bucket when I was collecting some kit', 0),
(189, 1, '', '1', 'Uk754783/ST', '', 1, '', '2019-04-04', NULL, '2019-08-21', 81, 83, 1, '', 19, 'crymych mart', 0),
(190, 1, '', '1', 'Uk754783/ST', '', 1, '', '2019-03-26', NULL, '2019-08-21', 87, 83, 1, '', 20, 'crymych mart', 0),
(191, 1, '', '1', 'Uk754783/ST', '', 1, '', '2019-03-26', NULL, '2019-08-21', 87, 83, 1, '', 20, 'crymych mart', 0),
(192, 1, '', '1', 'Uk754783/ST', '', 1, '', '2019-03-31', NULL, '2019-08-21', 80, 83, 1, '', 20, 'crymych mart', 0),
(193, 1, '', '1', 'Uk754783/ST', '', 1, '', '2019-03-31', NULL, '2019-08-21', 80, 83, 1, '', 20, 'crymych mart', 0),
(194, 1, '', '1', 'Uk754783/ST', '', 1, '', '2019-04-18', NULL, '2019-08-21', 93, 83, 1, '', 20, 'crymych mart', 0),
(195, 1, 'Captain Archer', '1', 'Uk3754783/00044', '', 0, '1336-18-044B', '2018-01-01', NULL, NULL, 69, 58, 1, '', 12, 'Breeding ram number : 7631B', 1),
(196, 1, 'George', '1', 'UK751650/00028', '', 0, '', '2018-03-03', NULL, NULL, 0, 0, 0, 'From Pollys friend', 16, '', 0),
(197, 1, 'Zoe', '2', 'uk747668/00084', '', 0, '', NULL, NULL, NULL, 0, 0, 0, 'From Polly Jones', 17, 'Hardly any teeth\r\nLooks like a wensleydale X LL', 0),
(198, 1, 'Myrtle', '2', 'uk747668/00083', '', 0, '', NULL, NULL, NULL, 0, 0, 0, 'From Polly Jones', 17, 'Hardly any teeth', 0),
(199, 1, 'Joyce', '2', 'uk747668/00085', '', 0, '', NULL, NULL, NULL, 0, 0, 0, 'From Polly Jones', 16, 'Hardly any teeth', 0),
(200, 1, 'Harvey', '1', 'uk208233/523', '', 0, '1308/17/523B    7589B', '2017-01-01', NULL, NULL, 0, 0, 0, 'Home farm breeding from Jayne Dryden', 12, 'Sire: Home farm Brent 7521B\r\nDam templar-croft 1259/12/017B who\'s sire is Redgrave Abel Marley', 0),
(201, 1, 'Bernadette', '2', 'UK 754783/00153', '', 0, '', '2019-03-27', NULL, NULL, 128, 109, 1, '', 20, '', 0),
(202, 1, 'Belinda', '2', 'UK 754783/00158', '', 0, '', '2019-04-08', NULL, NULL, 100, 109, 1, '', 17, 'Not eligible for pedigree status\r\nEntropian', 0),
(203, 1, 'Beverly', '2', 'UK 754783/00159', '', 0, '', '2019-03-27', NULL, NULL, 128, 109, 1, '', 20, '', 0),
(204, 1, '', '2', 'uk747668/00029', '', 0, '', NULL, NULL, NULL, 0, 0, 0, 'From Blossom field', 17, '', 0),
(205, 1, 'Bert', '1', 'Uk361856/1730', '', 0, 'DV5043', '2018-01-01', NULL, NULL, 0, 0, 0, 'Sire : Essington Jimbo DV3425\r\nDam:  Orway DV3527\r\n\r\n', 11, 'Purchased 2019 from Exeter mart', 0),
(206, 1, 'Cerys', '2', 'UK754783/00081', '', 0, '', '2020-02-29', NULL, NULL, 133, 205, 1, '', 11, '', 0),
(207, 1, 'Caddy', '2', 'Uk754783/00084', '', 0, '', '2020-03-03', NULL, NULL, 136, 205, 1, '', 11, '', 0),
(208, 1, 'Clover', '2', 'UK754783/00191', '', 0, '', '2020-03-03', NULL, NULL, 136, 205, 1, '', 11, '', 0),
(209, 1, 'Cheryle', '2', 'Uk754783/ 00186', '', 0, '', '2020-03-04', NULL, NULL, 127, 205, 1, '', 11, '', 0),
(210, 1, '', '1', '1-1  1-2', '', 0, '', '2020-03-04', NULL, NULL, 127, 205, 1, '', 11, '', 0),
(211, 1, 'Chance', '2', 'Uk754783/ 00182', '', 0, '', '2020-03-05', NULL, NULL, 199, 109, 1, '', 17, 'White lamb with coloured genes', 0),
(212, 1, '', '2', 'UK754783/00160', '', 0, '', '2019-03-12', NULL, NULL, 0, 0, 1, '', 20, '', 0),
(213, 1, '', '2', 'Uk754783/00155', '', 0, '', '2019-04-03', NULL, NULL, 0, 0, 1, '', 20, '', 0),
(214, 1, '', '2', 'uk754783/00156', '', 0, '', '2019-04-03', NULL, NULL, 0, 0, 1, '', 20, '', 0),
(215, 1, '', '2', 'uk754783/00157', '', 0, '', '2019-04-03', NULL, NULL, 0, 0, 1, '', 20, '', 0),
(216, 1, '', '1', '8-8-8-9', '', 0, '', '2020-03-19', NULL, NULL, 138, 205, 1, '', 11, '', 0),
(217, 1, 'Chantal', '2', 'uk754783/00188', '', 0, '', '2020-03-19', NULL, NULL, 138, 205, 1, '', 11, '', 0),
(218, 1, '', '1', 'ST', '', 0, '', '2020-03-20', NULL, NULL, 135, 205, 1, '', 11, '', 0),
(219, 1, 'Camilla', '2', 'UK745783/00189', '', 0, '', '2020-03-13', NULL, NULL, 134, 205, 1, '', 11, '', 1),
(220, 1, '', '1', '7-7-7-8', '', 0, '', '2020-03-13', NULL, NULL, 137, 205, 1, '', 11, '', 0),
(221, 1, 'Chloe', '2', 'UK745783/00135', '', 0, '', '2020-03-17', NULL, NULL, 98, 109, 1, '', 17, 'with coloured genes', 0),
(222, 1, '', '1', 'ST', '', 0, '', '2020-03-16', NULL, NULL, 99, 109, 1, '', 17, 'with coloured genes', 0),
(223, 1, '', '1', '9-9 -9-10', '', 0, '', '2020-03-11', NULL, NULL, 134, 205, 1, '', 11, '', 0),
(224, 1, 'Camilla', '2', 'UK754783/ 00189', '', 0, '', '2020-03-11', NULL, NULL, 134, 205, 1, '', 11, '', 0),
(225, 1, '', '2', 'ST', '', 0, '', '2020-03-30', NULL, NULL, 144, 63, 1, '', 20, '', 0),
(226, 1, 'Cailin', '2', 'UK754783/ 00179', '', 0, '', '2020-03-12', NULL, NULL, 99, 109, 1, '', 17, 'with coloured genes', 0),
(227, 1, '', '1', 'ST', '', 0, '', '2020-03-12', NULL, NULL, 99, 109, 1, '', 17, 'with coloured genes', 0),
(228, 1, '', '1', 'ST', '', 0, '', '2020-03-12', NULL, NULL, 93, 63, 1, '', 20, '', 0),
(229, 1, '', '1', '6-6 6-7', '', 0, '', '2020-03-11', NULL, NULL, 131, 205, 1, '', 11, '', 0),
(230, 1, '', '1', '10-10 10-11', '', 0, '', '2020-03-11', NULL, NULL, 131, 205, 1, '', 11, '', 0),
(231, 1, '', '1', '4-4 4-5', '', 0, '', '2020-03-11', NULL, NULL, 140, 205, 1, '', 11, '', 0),
(232, 1, 'Camlynn', '2', 'UK754783/00087', '', 0, '', '2020-03-11', NULL, NULL, 140, 205, 1, '', 11, '', 0),
(233, 1, '', '1', '5-5 5-6', '', 0, '', '2020-03-10', NULL, NULL, 139, 205, 1, '', 11, '', 0),
(234, 1, 'Cora', '2', 'UK754783/ 00086', '', 0, '', '2020-03-10', NULL, NULL, 139, 205, 1, '', 11, '', 0),
(235, 1, '', '1', '3-3 3-4', '', 0, '', '2020-03-07', NULL, NULL, 132, 205, 1, '', 11, 'brown fleece on legs', 0),
(236, 1, 'Coral', '2', 'UK754783/ 00085', '', 0, '', '2020-03-05', NULL, NULL, 124, 205, 1, '', 11, '', 0),
(237, 1, '', '1', '2-2 2-3', '', 0, '', '2020-03-05', NULL, NULL, 124, 205, 1, '', 11, '', 0),
(238, 1, 'Caroline', '2', 'UK754783/ 00187', '', 0, '', '2020-03-13', NULL, NULL, 137, 205, 1, '', 11, '', 0),
(239, 1, '', '1', 'UK754783 / 00202', '', 0, '', '2020-03-19', NULL, NULL, 74, 200, 1, '', 12, 'with white genes', 0),
(240, 1, '', '1', 'UK754783/ 00201', '', 0, '', '2020-03-11', NULL, NULL, 74, 200, 1, '', 12, '', 0),
(241, 1, '', '1', '12-12 12-13', '', 0, '', '2020-03-24', NULL, NULL, 141, 205, 1, '', 11, '', 0),
(242, 1, 'Prince of Wales', '1', 'UK754783/ 00196', '', 0, '', '2020-03-21', NULL, NULL, 78, 200, 1, '', 12, '', 0),
(243, 1, '', '1', '11-11 11-12', '', 0, '', '2020-03-21', NULL, NULL, 125, 205, 1, '', 11, '', 0),
(244, 1, '', '2', 'ST', '', 0, '', '2020-04-11', NULL, NULL, 118, 63, 1, '', 20, '', 0),
(245, 1, '', '1', 'ST', '', 0, '', '2020-04-01', NULL, NULL, 84, 200, 1, '', 12, '3/4 wen 1/4 d+c', 0),
(246, 1, '', '1', 'ST', '', 0, '', '2020-04-01', NULL, NULL, 84, 200, 1, '', 13, '3/4 wensleydale 1/4 D+C', 0),
(247, 1, '', '2', 'ST', '', 0, '', '2020-04-06', NULL, NULL, 87, 63, 1, '', 20, '', 0),
(248, 1, '', '1', 'ST', '', 0, '', '2020-04-06', NULL, NULL, 87, 63, 1, '', 20, '', 0),
(249, 1, 'Celia', '2', 'UK754783/ 00174', '', 0, '', '2020-04-04', NULL, NULL, 64, 200, 1, '', 20, '', 0),
(250, 1, 'Ceridwen', '2', 'uk754783/ 00148', '', 0, '', '2020-04-04', NULL, NULL, 64, 200, 1, '', 20, '', 0),
(251, 1, '', '1', 'ST', '', 0, '', '2020-03-20', NULL, NULL, 65, 200, 1, '', 20, '', 0),
(252, 1, 'Cassie', '2', 'uk754783 / 00173', '', 0, '', '2020-03-20', NULL, NULL, 65, 200, 1, '', 20, '', 0),
(253, 1, 'Cassie', '2', 'uk754783 / 00173', '', 0, '', '2020-03-20', NULL, NULL, 65, 200, 1, '', 20, '', 1),
(254, 2, 'A cow', '1', 'newTagNo', NULL, 0, NULL, '2020-03-20', NULL, NULL, NULL, NULL, 1, NULL, 21, NULL, 0),
(255, 2, 'Another cow', '2', 'vg/789789789', NULL, 0, NULL, '2020-04-21', NULL, NULL, NULL, NULL, 1, NULL, 21, NULL, 0),
(256, 3, 'A goat', '1', 'gt/5676789', NULL, 0, NULL, '2020-04-22', NULL, NULL, NULL, NULL, 1, NULL, 21, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `livestock_diary`
--

CREATE TABLE `livestock_diary` (
  `id` int(11) NOT NULL,
  `entry_date` date NOT NULL,
  `entry_added_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `notes` text DEFAULT NULL,
  `livestock` varchar(500) DEFAULT NULL,
  `medicine` varchar(500) NOT NULL,
  `manual_treatment` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `livestock_diary`
--

INSERT INTO `livestock_diary` (`id`, `entry_date`, `entry_added_date`, `notes`, `livestock`, `medicine`, `manual_treatment`) VALUES
(26, '2018-12-15', '2018-12-31 10:47:21', 'Moved onto farm From Polly Jones', '53', '', ''),
(30, '2019-06-18', '2019-06-18 14:28:12', 'Dirty bums', '103,72,131,134,137,106,104,100,166,145,142,69,78,128', '24', ''),
(45, '2019-07-12', '2019-07-12 16:12:34', 'Flystrike again on right hip\r\nWashed with soap and water and sprayed with maggot spray and maggot oil', '67', '25', '7'),
(44, '2019-07-07', '2019-07-08 09:38:23', 'Flystrike. trimmed and applied neem', '67', '26', '7'),
(43, '2019-07-06', '2019-07-06 16:02:03', 'Flystrike either side of anus- Neem applied', '118', '', '7'),
(46, '2019-07-12', '2019-07-12 16:13:39', 'Checked again for FS as biting at skin. Non found and fleece is very short', '118', '', ''),
(47, '2019-07-12', '2019-07-12 16:15:38', 'Caught after three days of trying to treat for flystrike.\r\nMaggots at flesh eating stage. Pockets found. Washed with soap and water and sprayed with maggot oil. Lamb very strong willed and doing well despite this set-back', '115', '25', '7'),
(48, '2019-07-17', '2019-07-17 11:25:05', 'Flystrike ++ many pockets of maggots that would haven\'t been controlled with natural methods.Washed with hibiscrub and crovect applied', '178', '27', '7'),
(49, '2019-07-17', '2019-07-17 11:26:03', 'Slightly shitty', '178', '24', '8'),
(50, '2019-07-18', '2019-07-18 16:14:08', 'Dagged  damp and continuously swishing. No evidence of maggots but applied crovect anyway', '145', '27', '7'),
(51, '2019-07-24', '2019-07-26 08:34:42', 'Flytrike around tail area\r\nCrovect applied', '68', '27', '7'),
(52, '2019-07-30', '2019-07-30 13:41:27', 'Lost white ear tag during shearing. Needs replacing', '74', '', ''),
(53, '2019-08-14', '2019-08-18 14:43:51', 'started with cough in quarantine. Homeopathy given', '112', '', ''),
(54, '2019-08-21', '2019-08-22 08:06:54', 'One head collar for the first time. Was ok. Had to neck collar him first as he was running about pen', '195', '', ''),
(55, '2019-09-20', '2019-09-20 18:16:58', 'Found salivating, not wanting to eat or drink. abdo discomfort ++. Died shortly after', '77', '', ''),
(56, '2019-09-19', '2019-09-20 18:18:14', 'Found lame ++. Gathered. Injury mix 1m and 200c given and purple spray onto feet', '200', '', ''),
(57, '2019-09-20', '2019-09-20 18:18:43', 'Appears to be ok today. To observe over weekend', '200', '', ''),
(58, '2019-09-21', '2019-09-23 05:56:04', 'Bought in due to poor weather expected. VERY thin. Wouldn\'t eat food with others\r\nWas wormed at beginning of September', '181', '', ''),
(59, '2019-09-22', '2019-09-23 05:57:02', 'Having controlled access to organilyx.Not seen eating hay. At Himalayan lick ++', '181', '', ''),
(60, '2019-09-23', '2019-09-23 05:58:41', 'Given 3 mls of mineral drench and also 3mls molassess\r\nstumbling but moving. Will move to \'being fed\' section with Blossom and LL boy when I think he is a bit stronger. I think the move now will kill him due to stress', '181', '', ''),
(61, '2019-09-21', '2019-09-23 05:59:52', 'Still getting better. Purple spray applied again', '200', '', ''),
(62, '2019-09-23', '2019-09-23 06:00:36', 'Still coughing +\r\nWill contact vet today and get something for him', '112', '', ''),
(63, '2019-09-23', '2019-09-23 15:42:18', 'Metacam 2.5ML bn L21054-01 EX 30/9/21\r\nZACTRAN 2ML\r\nGYS064BB\r\nDexa-ject 2mg/ml inj\r\n19D0210C7\r\n30/4/22\r\nGiven S/C for cough', '112', '', ''),
(64, '2019-09-23', '2019-09-23 15:53:02', 'Gave him some warm yogurt. \r\nSeen to be nibbling at hay and up and about. Vitality 2 !', '181', '', ''),
(65, '2019-09-25', '2019-09-25 15:02:25', 'Seen a area on one front hoof. Needs looking at', '200', '', ''),
(66, '2019-09-25', '2019-09-25 15:03:58', 'Maggots in head from recent ram fight with Bentley. Maggot spray applied and maggot oil. Needs looking at tomorrow', '109', '', ''),
(67, '2019-09-25', '2019-09-25 15:05:11', '3ml of mineral drench given again. Not looking great this morning and not eaten any sheep nuts. Yogurt given.\r\nLooking a bit better this afternoon', '181', '', ''),
(68, '2019-10-07', '2019-10-25 13:04:48', '', '84,86,147,74,143,145,144,73,146,142,79,64,81,83,75,66,113,67,68,149,116,90,69,91,89,111,85,76,151,150,114,118,115,195,109,82,92,87,122,196,112,200,123,95,97,99,108,98,60,140,96,199,88,65,103', '28', ''),
(69, '2019-10-10', '2019-10-25 13:06:31', '', '123,88,65,78,93,71,63,198,139,130,62,61,128,80,52,103,72,129,124,125,141,126,127,131,132,133,134,135,136,137,138,121,107,106,105,104,53,101,100,166,182,197', '29', '8'),
(70, '2019-11-10', '2019-11-14 10:41:06', 'shitty bum still', '144,146,142,92', '29', '8'),
(71, '2019-11-14', '2019-11-14 10:42:32', 'Only 1 tooth left. Losing weight. Put into feed group for winter', '95', '', ''),
(72, '2019-11-15', '2019-11-18 06:26:43', 'second wormer as px by vet', '75,116,111,85,76,114,118,115,97,103,107,106,105,53,166,166', '29', ''),
(73, '2019-11-11', '2019-12-02 13:53:48', 'shitty bums\r\nwormed as requested by vet for 2nd time', '111,68,67,151,81,82,108,166', '29', ''),
(74, '2019-12-02', '2019-12-02 16:41:32', 'No teeth\r\nAppears to have a cough', '106', '', ''),
(75, '2019-11-24', '2019-12-02 16:43:16', 'Treated for corneal abrasion in both eyes due to hay feeding.\r\nEuphrasia and silica given daily for 5 days', '106', '', ''),
(76, '2019-12-22', '2019-12-29 08:54:46', 'Found on side with eye pecked out by birds and mouth injured. Tried to look at tongue but too dark to see properly. Penned by self and given homeopathics. Aconite, silicea, ledum, staphisagria et al\r\nAB given and metacam', '61', '', ''),
(77, '2019-12-29', '2019-12-29 08:56:15', 'Doing well. Taken out of pebn day after she lost eye to be with other sheep. Is eating well. Not sure about drinking or if she is using lick bucket. Body score 3. To keep observing. Ledum given daily', '61', '', ''),
(78, '2019-12-15', '2019-12-29 08:59:21', 'Found unwell. Refused food. Choking when offered by hand. Blind ? lesteriosis. Called vet. Not sure AB and steroid given.\r\nFor AB (strep and pen daily for 7 days)', '76', '', ''),
(79, '2019-12-29', '2019-12-29 09:00:01', 'Still partially sighted. Eating ok and Bonnie with her to aid recovery', '76', '', ''),
(80, '2019-12-29', '2019-12-29 16:08:16', 'Can\'t find this ewe in the flock ? has died', '121', '', ''),
(81, '2020-01-03', '2020-01-03 10:44:54', 'Coughing- pneumonia\r\nin lamb\r\n3.5ml given im', '140', '30', ''),
(82, '2020-01-03', '2020-01-03 10:46:25', 'Coughing- pneumonia\r\n3.5ml given im', '125', '30', ''),
(83, '2020-01-08', '2020-01-08 15:26:59', 'Pneumonia\r\n4.3ml AB given', '200', '30', ''),
(84, '2020-01-10', '2020-01-10 16:36:55', 'On-movement worming 20ml ', '204', '29', ''),
(85, '2020-01-10', '2020-01-10 16:38:06', 'Dirty bum\r\nwormed 10ml', '149', '29', ''),
(86, '2020-01-10', '2020-01-10 16:39:01', 'Dirty bum\r\nwormed 10ml', '149', '29', ''),
(87, '2020-01-12', '2020-01-12 09:22:28', 'In hay barn with leicesters as needing feeding. Looked at health docs. This ewe is always thin and unlikely to rear a lamb again. For cull', '126', '', ''),
(88, '2020-01-24', '2020-01-24 15:33:38', 'VERY thin. Body score 2.5\r\nWormed and moved intop CB3 for feeding with rest of thins', '79', '29', ''),
(89, '2020-01-26', '2020-01-26 16:11:48', 'Coughing\r\n? Pneumonia. Strep and pen 3.4ml given', '89', '30', ''),
(90, '2020-01-27', '2020-01-27 16:50:49', 'Strep and pen given for cough 3.5ml\r\nthin but eating hay etc. Lively. \r\nAge related weight loss', '122', '30', ''),
(91, '2020-01-29', '2020-01-29 08:48:18', 'Wormed as group sample revealed barber pole. Combinex 20ml', '95', '29', ''),
(92, '2020-01-29', '2020-01-29 08:49:30', 'Wormed as group sample revealed barber pole. 20ml combinex given', '97', '29', ''),
(93, '2020-01-29', '2020-01-29 08:50:02', 'Wormed as group sample revealed barber pole. 20ml combinex given', '102', '29', ''),
(94, '2020-01-29', '2020-01-29 08:51:22', 'Wormed as group sample revealed barber pole. 20ml combinex given\r\nalso cough clear snotty nose\r\n4ml Strep and pen given', '103', '30,29', ''),
(95, '2020-01-29', '2020-01-29 08:52:06', 'Wormed as group sample revealed barber pole. 20ml combinex given', '105', '29', ''),
(96, '2020-01-29', '2020-01-29 08:53:08', 'Wormed as group sample revealed barber pole. 20ml combinex given\r\nAlso 4ml Strep and pen as coughing and clear snotty nose', '106', '30,29', ''),
(97, '2020-01-29', '2020-01-29 08:54:05', 'Wormed as group sample revealed barber pole. 20ml combinex given', '108', '29', ''),
(98, '2020-01-29', '2020-01-29 08:54:59', 'Wormed as group sample revealed barber pole. 20ml combinex given', '204', '29', ''),
(99, '2020-01-29', '2020-01-29 08:55:51', 'Wormed as group sample revealed barber pole. 20ml combinex given', '71', '29', ''),
(100, '2020-01-29', '2020-01-29 08:56:42', 'Wormed as group sample revealed barber pole. 20ml combinex given', '79', '29', ''),
(101, '2020-01-29', '2020-01-29 08:58:06', 'Wormed as group sample revealed barber pole. 20ml combinex given', '202', '29', ''),
(102, '2020-01-30', '2020-02-01 08:39:59', 'Coughing ++\r\nStrep and pen given 3.5ml. Clear nose', '124', '30', ''),
(103, '2020-02-01', '2020-02-02 08:39:44', 'Second course AB shot for cough\r\nStrep andf pen 3.5ml\r\nAll is well', '124', '30', ''),
(104, '2020-02-02', '2020-02-02 08:40:28', 'Noticed he\'s lots a lot of weight suddenly\r\nNeeds FEC done ', '109', '', ''),
(105, '2020-02-03', '2020-02-03 08:45:12', 'Wormed before going out\r\nCombinex 18ml', '83', '29', '8'),
(106, '2020-02-03', '2020-02-03 08:45:43', 'Wormed before going out\r\nCombinex 23ml', '200', '29', '8'),
(107, '2020-02-03', '2020-02-03 08:47:05', 'not able to obtain feaces as boys fighting in pen\r\nWormed with Combinex 20ml\r\nTo monitor. Is eating', '109', '29', '8'),
(108, '2020-02-03', '2020-02-03 08:47:33', 'Wormed before going out\r\nCombinex 15ml', '63', '29', '8'),
(109, '2020-02-03', '2020-02-03 08:48:22', 'Fighting with Morgan this morning\r\nWormed before going out\r\nCombinex 18ml', '196', '29', '8'),
(110, '2020-02-03', '2020-02-03 08:55:31', 'Wormed Combinex 18ml before going out\r\n\r\n', '205', '29', '8'),
(111, '2020-02-04', '2020-02-04 16:33:14', 'Ears and nose VERY hot. Eating ok. ? pyrexia/infection. Strep and pen given 4ml', '109', '30', ''),
(112, '2020-02-10', '2020-02-11 17:56:19', 'Strep and pen given for cough', '122', '30', ''),
(113, '2020-02-11', '2020-02-11 17:56:38', '2nd strep and pen for cough', '122', '30', ''),
(114, '2020-04-20', '2020-04-20 10:28:42', 'Very dirty. Diarrhoea. Green. Was put into new field 5 days ago. Looks thin along spine.\r\nWormed 3ml combinex', '224', '29', '8'),
(115, '2020-04-20', '2020-04-20 10:29:16', 'Large teat on left side of udder.', '134', '', ''),
(116, '2020-04-20', '2020-04-20 10:30:10', 'Very dirty and smelly poo\r\nWormed 20ml', '69', '29', '8'),
(117, '2020-04-20', '2020-04-20 10:30:45', 'Dirty\r\nWormed Copmbinex 20ml', '80', '29', '8'),
(118, '2020-04-20', '2020-04-20 10:32:11', 'Dirty\r\nWormed 20ml Combinex', '81', '29', '8'),
(119, '2020-04-20', '2020-04-20 10:32:52', 'Dirty\r\nWormed 20ml combinex', '82', '29', '8'),
(120, '2020-04-15', '2020-04-23 16:28:30', 'Apears to have broken her hind right leg. Splinted\r\nEating much better', '250', '', ''),
(121, '2020-04-23', '2020-04-23 16:29:29', 'Noticed puss coming out of dressing. Small laceration by bone break. Drained and 2ml ABs given\r\nLeg redressed', '250', '30', ''),
(122, '2020-04-26', '2020-04-27 06:47:05', 'Wormed if shitty\r\n4-20ml each depending on weight', '210,230,243,241,237,235,231,233,229,220,216,223,143,145,73,146,142,79,202,75,113,68,85,76,115,207,226,232,238,206,211,217,209,221,208,234,122,95,97,96,88,78,71,130,242,128,129,132,138,215', '31', '8'),
(123, '2020-04-26', '2020-04-27 14:04:48', 'Leg redressed. Puss thinner. Is having 1.5ml AB\'s daily', '250', '30', ''),
(124, '2020-04-27', '2020-04-27 16:09:42', 'Having daily AB injection.\r\nIs really well. Managing on 3 legs. Eating well anmd generally looks good. Apyrexial. Wouldn\'t think she had a broken leg and infection.', '250', '', ''),
(125, '2020-04-29', '2020-04-29 17:09:11', 'Found dead and Zoe next doors dog sat next to her. Throat bitten and tail area\r\nRIP little girl xxx', '149', '', ''),
(126, '2020-05-08', '2020-05-08 06:00:12', 'Found dead in filed 8 post moving yesterday evening', '138', '', ''),
(127, '2020-05-17', '2020-05-17 11:41:43', 'Doing well. Now putting foot onto floor and slightly weight bearing', '250', '', ''),
(128, '2020-05-24', '2020-05-24 17:16:54', 'Found caught in elect fence. Ear tag needed to be removed and therefore number will change\r\nEar appears infected around tag site where she was caught in fence. No treatment for now', '207', '', ''),
(129, '2020-05-25', '2020-06-13 10:17:08', 'Wormed 5-20ml each weight depending', '74,64,91,250,87', '29', ''),
(130, '2020-06-08', '2020-06-13 10:18:37', 'Vet wrap and dressing fell off. Now walking on leg so left off. Monitor. Needs muscle strengthening but is doing well. Still on bottle', '250', '', ''),
(131, '2020-06-12', '2020-06-13 10:19:01', 'Now on one battle a night now.', '250', '', ''),
(132, '2020-06-26', '2020-06-26 17:28:22', 'Fly strike back of right shoulder downwards. Large patch and maggots have teeth stage.\r\nClipped and washed. Into TLC field behind house ad poor body condition too', '212', '', ''),
(133, '2020-06-28', '2020-06-28 10:48:25', 'Found worms in field in dung. AS these are in TLC field for one reason or another decided to worm the lot', '229,144,238,250,249,209,122,218,127', '29', '8'),
(134, '2020-06-28', '2020-06-28 11:13:01', 'Found stuck between Stock fence and pembrokeshire wall top of hay field and copse field.Had to use rachet cutters to get her out. No injury', '234', '', ''),
(135, '2020-06-29', '2020-06-29 13:39:48', 'Dirty\r\nWormed 16-20ml each', '103,131,132,204,84,143,146,108,62,61,197', '29', ''),
(136, '2020-06-29', '2020-07-01 07:28:19', 'Further flystrike on other shoulder. Crovect applied. Maggots have teeth', '212', '27', '7'),
(137, '2020-07-01', '2020-07-01 07:29:44', 'No sign of maggots but not socialising or eating nuts.\r\n4ml AB given as maybe infection from maggots. MOlasess drench given but is eating a small amount of grass\r\nCovered with maggot oil', '212', '30', ''),
(138, '2020-07-07', '2020-07-07 06:55:24', 'Flystrike on hits, shoulders and chest\r\nSheared and moggot oil applied. Given this is the second year and severity of case this ewe is for market now', '67', '25', '7'),
(139, '2020-07-09', '2020-07-09 15:56:29', 'Flystrike on shoulders. Unable to catch for 3 days and didn\'t come down for shearing at weekend.\r\nHand sheared', '62', '25', '7');

-- --------------------------------------------------------

--
-- Table structure for table `manual_treatment`
--

CREATE TABLE `manual_treatment` (
  `id` int(11) NOT NULL,
  `treatment_name` varchar(500) NOT NULL,
  `notes` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `supplier` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `manual_treatment`
--

INSERT INTO `manual_treatment` (`id`, `treatment_name`, `notes`, `price`, `supplier`) VALUES
(7, 'Dagging', '', '0.00', 7),
(8, 'Wormer - Drench', '', '0.00', 7);

-- --------------------------------------------------------

--
-- Table structure for table `manual_treatment_supplier`
--

CREATE TABLE `manual_treatment_supplier` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(500) NOT NULL,
  `treatment_type` varchar(500) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `website` varchar(500) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL,
  `telephone` varchar(500) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `manual_treatment_supplier`
--

INSERT INTO `manual_treatment_supplier` (`id`, `supplier_name`, `treatment_type`, `address`, `website`, `email`, `telephone`, `notes`, `deleted`) VALUES
(7, 'Jane', 'General', '', '', '', '', '', 0),
(8, 'MOLEVALLEY', 'ANIMAL MEDICINES', '', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `id` int(11) NOT NULL,
  `quantity` varchar(500) DEFAULT NULL,
  `medicine_name` varchar(500) NOT NULL,
  `description` text DEFAULT NULL,
  `batch_number` varchar(500) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `finished_date` date DEFAULT NULL,
  `supplier` int(11) NOT NULL,
  `medicine_type` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`id`, `quantity`, `medicine_name`, `description`, `batch_number`, `price`, `purchase_date`, `expiry_date`, `finished_date`, `supplier`, `medicine_type`) VALUES
(30, '100ml', 'Pen and Strp', 'AB for sheep', '9332-50A', '0.00', '2020-01-02', '2020-05-13', NULL, 10, 6),
(31, '1', 'combinex 2.2l', 'wormer', '22749', '88.00', '2020-02-07', '2022-03-30', NULL, 9, 6),
(24, '1L', 'Panacur 10%', 'Broad spectrum wormer\r\n1BZ', 'E383BV01', '0.00', '2019-06-13', '2020-06-01', NULL, 8, 6),
(25, '', 'Maggot oil', '', '', '0.00', NULL, NULL, NULL, 9, 6),
(27, '0.8l', 'Crovect', 'maggot control', '22641', '40.20', '2019-07-17', '2020-06-30', NULL, 9, 6),
(28, '0.8l', 'Combinex sheep 0.8l', 'Wormer', '', '0.00', '2019-10-08', NULL, NULL, 9, 6),
(29, '2.2l', 'Combinex sheep 2.2l', 'wormer', '21826', '105.60', '2019-10-10', '2021-07-31', NULL, 9, 6);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_supplier`
--

CREATE TABLE `medicine_supplier` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `address` text DEFAULT NULL,
  `website` varchar(500) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL,
  `telephone` varchar(500) DEFAULT NULL,
  `notes` text NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medicine_supplier`
--

INSERT INTO `medicine_supplier` (`id`, `name`, `address`, `website`, `email`, `telephone`, `notes`, `deleted`) VALUES
(7, 'Helios', '', '', '', '', '', 0),
(8, 'MOLEVALLEY', '', '', '', '', '', 0),
(9, 'CCF', '', '', '', '', '', 0),
(10, 'Vet', 'Market Hall Vets', '', '', '', '', 0),
(11, 'Essentially Oils', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_type`
--

CREATE TABLE `medicine_type` (
  `id` int(11) NOT NULL,
  `type` varchar(500) NOT NULL,
  `description` text DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medicine_type`
--

INSERT INTO `medicine_type` (`id`, `type`, `description`, `deleted`) VALUES
(5, 'Homeopathic', 'Any homeopathic remedy given to animals', 0),
(6, 'Allopathic', 'Any allopathic medicine given to animals', 0),
(7, 'Natural', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE `reminders` (
  `id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reminder_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `priority` int(11) NOT NULL,
  `description` text NOT NULL,
  `emails` text NOT NULL,
  `remindMe_before` varchar(400) NOT NULL,
  `remindMe_after` varchar(400) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reminders`
--

INSERT INTO `reminders` (`id`, `created_date`, `reminder_date`, `priority`, `description`, `emails`, `remindMe_before`, `remindMe_after`, `completed`) VALUES
(1, '2023-02-22 15:39:04', '2023-02-22 15:39:31', 3, 'Do something', 'pat@moonspace.co.uk', '1 Day', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `species`
--

CREATE TABLE `species` (
  `id` int(11) NOT NULL,
  `species` varchar(255) NOT NULL,
  `notes` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `species`
--

INSERT INTO `species` (`id`, `species`, `notes`) VALUES
(1, 'Sheep', ''),
(2, 'Cow', ''),
(3, 'Goat', '');

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE `treatment` (
  `id` int(11) NOT NULL,
  `diary_entry` int(11) NOT NULL,
  `medicine` int(11) NOT NULL,
  `manual_treatment` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `flockbook_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `flockbook_name`, `username`, `password`, `email`, `active`) VALUES
(2, 'broadstone', 'Jane Dobson', '$2y$10$xT56kA6vaGZ6ANLn6eHBPOAljpRpjaxo2kSKBImvFGDiw95gGzWcW', 'jane@broadstoneuk.co.uk', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `breed`
--
ALTER TABLE `breed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `farm_diary`
--
ALTER TABLE `farm_diary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feed`
--
ALTER TABLE `feed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `livestock`
--
ALTER TABLE `livestock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `livestock_diary`
--
ALTER TABLE `livestock_diary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manual_treatment`
--
ALTER TABLE `manual_treatment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manual_treatment_supplier`
--
ALTER TABLE `manual_treatment_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_supplier`
--
ALTER TABLE `medicine_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_type`
--
ALTER TABLE `medicine_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `species`
--
ALTER TABLE `species`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `treatment`
--
ALTER TABLE `treatment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `breed`
--
ALTER TABLE `breed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `farm_diary`
--
ALTER TABLE `farm_diary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `feed`
--
ALTER TABLE `feed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT for table `gender`
--
ALTER TABLE `gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `livestock`
--
ALTER TABLE `livestock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;

--
-- AUTO_INCREMENT for table `livestock_diary`
--
ALTER TABLE `livestock_diary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `manual_treatment`
--
ALTER TABLE `manual_treatment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `manual_treatment_supplier`
--
ALTER TABLE `manual_treatment_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `medicine_supplier`
--
ALTER TABLE `medicine_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `medicine_type`
--
ALTER TABLE `medicine_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `species`
--
ALTER TABLE `species`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `treatment`
--
ALTER TABLE `treatment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
