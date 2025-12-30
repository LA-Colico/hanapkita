-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2025 at 06:25 AM
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
-- Database: `hanapkita`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(10) NOT NULL,
  `AdminName` varchar(200) DEFAULT NULL,
  `UserName` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`) VALUES
(1, 'Admin', 'admin', 7987979878, 'admin@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2024-11-30 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblapplyjob`
--

CREATE TABLE `tblapplyjob` (
  `ID` int(10) NOT NULL,
  `UserId` int(5) DEFAULT NULL,
  `JobId` int(5) DEFAULT NULL,
  `Applydate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Status` varchar(200) DEFAULT NULL,
  `ResponseDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblapplyjob`
--

INSERT INTO `tblapplyjob` (`ID`, `UserId`, `JobId`, `Applydate`, `Status`, `ResponseDate`) VALUES
(1, 1, 6, '2023-02-25 16:28:17', 'Hired', '2023-02-25 16:28:17'),
(2, 2, 1, '2024-12-07 22:44:06', 'Hired', '2024-12-07 22:44:06'),
(3, 3, 19, '2024-12-09 08:03:10', 'Hired', '2024-12-09 08:03:10'),
(4, 4, 15, '2024-12-09 08:14:31', NULL, NULL),
(5, 4, 18, '2024-12-09 08:15:11', NULL, NULL),
(6, 3, 18, '2024-12-09 09:18:06', 'Hired', '2024-12-09 09:18:06'),
(7, 3, 20, '2024-12-09 10:10:36', 'Hired', '2024-12-09 10:10:36'),
(8, 4, 20, '2025-03-11 16:13:01', 'Hired', '2025-03-11 16:13:01');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL,
  `CategoryName` varchar(200) NOT NULL,
  `Description` mediumtext NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL,
  `Is_Active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`id`, `CategoryName`, `Description`, `PostingDate`, `UpdationDate`, `Is_Active`) VALUES
(6, 'Construction ', 'The Construction and Maintenance category focuses on providing expert services for building, renovating, and maintaining structures, ensuring safety, functionality, and longevity. It includes a wide range of tasks, from initial construction to ongoing repairs and regular upkeep.', '2024-12-08 14:14:01', NULL, 0),
(7, 'Logistics ', 'The Transportation and Logistics category encompasses services related to the movement, storage, and delivery of goods, ensuring the efficient management of supply chains, transportation networks, and distribution systems. It focuses on optimizing routes, minimizing costs, and maintaining timely deliveries to meet customer demands.', '2024-12-08 14:15:15', NULL, 0),
(8, 'Waste Management', 'The Sanitation and Waste Management category focuses on maintaining clean and healthy environments by implementing effective waste disposal, recycling, and sanitation practices. It ensures the proper handling of waste to prevent health hazards and promote sustainability.', '2024-12-08 14:16:05', NULL, 0),
(12, 'Security', 'Security', '2025-01-09 11:46:37', NULL, 0),
(13, 'Cash Handler', 'Cash Handler', '2025-01-09 11:54:56', NULL, 0),
(14, 'Retail', 'Retail Jobs', '2025-01-09 12:04:11', NULL, 0),
(16, 'Food', 'Food', '2025-01-09 14:11:47', NULL, 0),
(17, 'Automotive Service', 'Automotive Service encompasses a range of professional services designed to maintain, repair, and optimize the performance of vehicles. ', '2025-01-10 03:17:19', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbleducation`
--

CREATE TABLE `tbleducation` (
  `ID` int(10) NOT NULL,
  `UserID` int(5) DEFAULT NULL,
  `Qualification` varchar(200) DEFAULT NULL,
  `ClgorschName` varchar(200) DEFAULT NULL,
  `PassingYear` varchar(200) DEFAULT NULL,
  `Stream` varchar(200) DEFAULT NULL,
  `CGPA` decimal(2,0) DEFAULT NULL,
  `Percentage` decimal(4,0) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbleducation`
--

INSERT INTO `tbleducation` (`ID`, `UserID`, `Qualification`, `ClgorschName`, `PassingYear`, `Stream`, `CGPA`, `Percentage`, `CreationDate`) VALUES
(4, 3, 'College Graduate', 'Technological University of the Philippines', '2026', 'BSCS', 1, 0, '2024-12-09 07:53:36'),
(5, 3, 'High School Graduate', 'St. Matthew College', '2022', 'STEM', 1, 0, '2024-12-09 07:54:20'),
(6, 4, 'College Graduate', 'Technological University of the Philippines', '2024', 'Computer Science', 2, 0, '2024-12-09 08:08:35');

-- --------------------------------------------------------

--
-- Table structure for table `tblemployers`
--

CREATE TABLE `tblemployers` (
  `id` int(11) NOT NULL,
  `ConcernPerson` varchar(150) DEFAULT NULL,
  `EmpEmail` varchar(250) DEFAULT NULL,
  `EmpPassword` varchar(250) DEFAULT NULL,
  `CompnayName` varchar(255) DEFAULT NULL,
  `CompanyTagline` mediumtext DEFAULT NULL,
  `CompnayDescription` mediumtext DEFAULT NULL,
  `CompanyUrl` varchar(255) DEFAULT NULL,
  `CompnayLogo` varchar(200) DEFAULT NULL,
  `noOfEmployee` char(10) DEFAULT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `typeBusinessEntity` varchar(255) DEFAULT NULL,
  `lcation` varchar(255) DEFAULT NULL,
  `establishedIn` char(200) DEFAULT NULL,
  `RegDtae` timestamp NULL DEFAULT current_timestamp(),
  `LastUpdationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Is_Active` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblemployers`
--

INSERT INTO `tblemployers` (`id`, `ConcernPerson`, `EmpEmail`, `EmpPassword`, `CompnayName`, `CompanyTagline`, `CompnayDescription`, `CompanyUrl`, `CompnayLogo`, `noOfEmployee`, `industry`, `typeBusinessEntity`, `lcation`, `establishedIn`, `RegDtae`, `LastUpdationDate`, `Is_Active`) VALUES
(1, 'Joanna Dee', 'abc-dee@employer.com', '$2y$12$gsxEM6omnddZUuVCY/IbNetavuHfqu44DKVD92/z24S3bj9PT2DJ2', 'ABC-Dee Catering', '\"Serving Delicious Moments\"', '<span lang=\"EN-PH\" style=\"font-size:11.0pt;mso-bidi-font-size:\r\n14.0pt;line-height:107%;font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;;mso-ascii-theme-font:\r\nminor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;\r\nmso-hansi-theme-font:minor-latin;mso-bidi-font-family:&quot;Cordia New&quot;;mso-bidi-theme-font:\r\nminor-bidi;mso-ansi-language:EN-PH;mso-fareast-language:EN-US;mso-bidi-language:\r\nTH\">ABC-Dee Catering offers exceptional catering services for events of all\r\nsizes. From small gatherings to large celebrations, we specialize in creating\r\nmemorable dining experiences with fresh, high-quality ingredients and diverse\r\nmenu options.</span>', 'https://www.abcdeecatering.com', '13574033cb42a5e28c350844804dd833.png', '25', 'Food Service', 'Private Company', 'Barangay 565, Zone 55, Balic-Balic, Sampaloc, Manila City', '2015', '2024-12-07 23:18:08', '2024-12-07 23:34:21', 1),
(2, 'Judel Ubaldo', 'prime.craft@employer.com', '$2y$12$9UUyUk.umXImhn6ZqIM8.uya5f3ttYx/r8OZ6WI9wT.azXHIRQySK', 'Prime Craft Manufacturer', '\"Precision in every product, excellence in every craft.\"', 'Prime Craft Manufacturer specializes in delivering high-quality, precision-crafted products. With a commitment to excellence, we combine advanced techniques and expert craftsmanship to create exceptional items that meet the highest standards. Whether you\'re looking for custom solutions or large-scale production, we ensure top-tier results every time.', 'http://prime.craft.com', '2eea8a00a986b8eec14ee62a9e28a9e5.png', '350', 'Manufacturing', 'Private Company', 'Barangay 563, Zone 55, Balic-Balic, Sampaloc, Manila City', '2010', '2024-12-07 23:09:23', '2024-12-08 00:26:53', 1),
(7, 'Elijah Ashley Santiago', 'contact@stonebridge.com', '$2y$12$veHH9PbbiaLYUGeHzMRsbOL6GQxLQ3DyNZghOLnU9iky/b97sunsO', 'StoneBridge Services ', 'Connecting Vision to Reality, Maintenance to Mastery', 'StoneBridge Services is your reliable partner for construction and transportation solutions. From building strong and sustainable structures to ensuring efficient and seamless logistics, we prioritize quality, integrity, and customer satisfaction. Whether you need innovative construction services or dependable transportation, we’re here to connect your vision to reality.', '', '10fb15c77258a991b0028080a64fb42d.png', NULL, NULL, NULL, NULL, NULL, '2024-12-08 14:06:37', '2024-12-08 14:06:37', 1),
(8, 'Elijah Ashley Santiago', 'hr@powerlinksolutions.com', '$2y$12$YYMFHLaP54QlWxNOBAXHWuxfRiJiq1n1k/kFUqDukdF36tBHlSII6', 'PowerLink Solutions ', 'Your Connection to Reliable Electrical Services', 'PowerLink Solutions specializes in providing expert electrical maintenance, repair, and installation services. From troubleshooting to system upgrades, we ensure safe and efficient solutions for residential, commercial, and industrial needs.', 'https://www.powerlink.com', 'f768b3402e1ac5d40d1a39ae453609a2.png', NULL, NULL, NULL, NULL, NULL, '2024-12-08 14:09:03', '2024-12-08 14:27:22', 1),
(9, 'Elijah Ashley Santiago', 'service@streetsmart.com', '$2y$12$SeRclwxnG//GbtAHtVVm6.UsnXrsf.cq.IvBakYPQZ3UMHmbcneja', 'StreetSmart Cleaning Co.', 'Smart Solutions for Street and Facility Cleanliness.', 'StreetSmart Cleaning Co. delivers efficient and effective cleaning services for streets, offices, and public spaces. Our mission is to make urban living cleaner and safer for everyone.', '', '8266e4bfeda1bd42d8f9794eb4ea0a13.png', '20', 'Cleaning Services', 'Private Company', '109 Valdez St. Barangay 562 Sampaloc, Manila', '1999', '2024-12-08 14:48:14', '2024-12-08 15:12:08', 1),
(10, 'Elijah Ashley Santiago', 'info@swiftpack.com', '$2y$12$ITlCqlosCmRLzmrjidtKsuiY...AwQTQuugPNb2NSJoOdnIkpu0ye', 'SwiftPack Systems', 'Your Trusted Warehouse and Packaging Partner.', 'SwiftPack Systems is dedicated to providing expert warehouse and packaging services. We focus on streamlining storage processes and ensuring that each item is properly packed for secure transportation, offering reliable solutions for all your logistics needs.', 'https://www.swiftpack.com', 'f19c9085129709ee14d013be869df69b.png', '25', 'Logistics', 'Private Company', '1112 Bataan St. Brgy. 561 Sampaloc, Manila', '1971', '2024-12-08 15:15:20', '2024-12-08 15:22:06', 1),
(11, 'Lanz Colico', 'service@wastewise.com', '$2y$12$t7YInX.Vi6xBZKhQuoSwFO3BMK4AMYHdaKesZhetTjIwHlWssIRBO', 'WasteWise Solutions', 'Efficient Waste Management, Cleaner Earth.', 'WasteWise Solutions focuses on responsible waste collection and recycling practices. By partnering with us, clients can enjoy hassle-free waste removal while contributing to a cleaner, greener environment.', 'https://www.wastewise.com', '711fc75247e85b8015188d8c6a2c6f43.png', '15', 'Waste Management and Recycling', 'Sole Proprietorship', '578 Panay St. Brgy. 567 Sampaloc, Manila', '2013', '2024-12-08 15:28:03', '2024-12-08 15:34:52', 1),
(12, 'Joanna Dee', 'joannadeesigns@gmail.com', '$2y$12$cr27fG5VDqpalz4Wa6VIp.z4z72gZWgKujsohxi2IW5JY6IXG40J.', 'DeeSigns', 'Design with the best.', 'Design with the best.', '', 'ebcd036a0db50db993ae98ce380f6419.png', NULL, NULL, NULL, NULL, NULL, '2024-12-08 16:18:02', '2024-12-08 16:18:02', 1),
(13, 'JD Foods Premium Sauces Distributor', 'superdaddy.gtuazonsampaloc@gmail.com', '$2y$12$B6jYAdzNwR1oVgboKBEfo.yh/Q.Yt3S6FM01h3Vm.pbkk6ECW.h8S', 'SuperDaddy', 'N/A', '10 Baristas', 'htttp://superdaddy.com', 'cd02732154fb704cf379266533f4be0b.png', NULL, NULL, NULL, NULL, NULL, '2025-01-09 11:12:18', '2025-01-10 04:07:58', 1),
(14, 'HR Utopia', 'hrdutopia@gmail.com', '$2y$12$/FtWH4YznFM6RoviKfpbK.IHqALFrkYnFbyEYrY8wQkxnv2l/V8mC', 'UTOPIA Security & Safety Solutions INC.', 'N/A', '30 Security Guards', 'http://Utopiasecurity.com', 'ac3be66acfd157cc55785565050d8bc3.png', NULL, NULL, NULL, NULL, NULL, '2025-01-09 11:41:57', '2025-01-10 04:10:09', 1),
(15, 'Cedric Saulog Dejesus', 'petmastersshop@gmail.com', '$2y$12$iIJhRmpPs0oQOX/jfby0JeSOVRP.JMEVzE3gcczPPSqVlIKyLIO0i', 'Petmasters', 'N/A', '10 Staff', 'http://petmaster.com', 'd5fbaa10fb15f5f551067b2a8ccb9191.png', NULL, NULL, NULL, NULL, NULL, '2025-01-09 11:59:33', '2025-01-10 04:11:16', 1),
(16, 'HR Mara Misa', 'recruitment.namitkagsulit@gmail.com', '$2y$12$oyl8GC6JH9UW1YHzo5aH9.aqLffz10aOWK04cVguWd4q8Yz5dI9h2', 'Mang Inasal G. Tuazon', 'N/A', 'Grill, Kitchen, Dining, Assembly (Preferably Male)\r\n', 'http://MangInasal.com', 'b6d1d8a11b69d2d6951e1dcfc056a73e.png', NULL, NULL, NULL, NULL, NULL, '2025-01-09 12:26:16', '2025-01-10 04:12:21', 1),
(17, 'HR Mari', 'recruit.xlr8@gmail.com', '$2y$12$mex3HE8tCU6TVdmNe42AXOWuwWyHIW7Hd1Otv3DgSRdhCQbuE7qaa', 'XLR8 Courier Services Inc.', 'N/A', 'HR Employee Relations, HR Recruitment, HR Timekeeper, Warehouse Supervisor, Branch Supervisor, Customer Service Representative, Quality Assurance Associate\r\n', 'http://xlr8courier.com', 'b93721477e1edef7a31d98f8d7c774aa.png', NULL, NULL, NULL, NULL, NULL, '2025-01-09 12:39:36', '2025-01-10 04:13:04', 1),
(18, 'HR MR. DIY', 'hr@mrdiy.com', '$2y$12$eEeqUuo.65wrSZEw1L5dMeH3ucSYoIsev0LfJkFsih3mTD/4tIdEu', 'MR. DIY', '\"Always Low Prices\"', 'Home and Life Improvement Retailer', 'https://www.facebook.com/mrdiyphcareers', '9331eb406b0d71e0617ff907b0a5b4e8.png', '', 'Home and Life Improvement Retailer', 'Private Company', 'Balic - Balic, Sampaloc, Manila', '', '2025-01-09 13:48:12', '2025-01-10 04:15:29', 1),
(19, 'HR Christine Zucari', 'zucarihrtin@gmail.com', '$2y$12$XwXFo/Z82GQ3uzin7iy9k.yIN5h4kMEESvnoBtMRbbQh7wXvywnjK', 'ZUCARI', '\"\"', 'E-commerce, retail industry', 'https://www.facebook.com/zucari.philippines/', '7f2b9157dcde559519a7a80aa7c12f9d.jpg', '', 'E-commerce, retail industry', 'Private Company', '2114-A Sobriedad St., Balic-balic, Sampaloc, Manila', '', '2025-01-09 14:01:18', '2025-01-10 04:15:57', 1),
(20, 'Miko Fajardo', 'mrbeanzcoffee2022@gmail.com', '$2y$12$nDClOiUvp0IxSRtuO39y9OyT538OoqyL6CpZhePxICIy..TT35FSe', 'MR BEANZ', '\"\"', 'Customer-focused barista serving high-quality espresso and brewed coffee.', 'https://www.facebook.com/MRbeanzcoffee/', '18fe58871d57ca7b6d6616adc0f6bb8f.jpg', '', 'Food', 'Private Company', '791 Roxas St. Cor. Mindanao Ave. Balic-Balic, Sampaloc, Manila', '', '2025-01-09 14:10:37', '2025-01-10 04:16:26', 1),
(21, 'The 20th', 'the20th@gmail.com', '$2y$12$1ovvUfnCMvLgL0bPveJm2.ZqePoeYg8XkuqbpBSBRjR84HxcglYiy', 'The 20th Cafe', '\"\"', 'Customer-focused barista serving high-quality espresso and brewed coffee.', 'https://www.facebook.com/the20thcafe/', '8b6799f6e60bd375ca06bbcdcd2db645.jpg', NULL, NULL, NULL, NULL, NULL, '2025-01-09 14:16:49', '2025-01-10 04:17:02', 1),
(22, 'Vc Bulan', 'v.bulan@powerlane.net', '$2y$12$aiWTgsmQlocKGSjiBCfUMeNJGtBFLs7KW.fZeUeOqLbsJ8PpGosvy', 'Julie\'s Bakeshop', '\"BASTA Julie\'s, Fresh \'Yan!\"', 'Julie\'s Bakeshop has been baking delicious and affordable breads for Filipinos for almost four decades. No merienda or almusal is complete without Julie\'s!', 'https://www.juliesbakeshop.com.ph/', '938a3643d7010c8afd41ff092fc8dfa7.png', '', 'Bakeshop', 'Private Company', 'G. Tuazon, Balic-Balic, Sampaloc, Manila', '', '2025-01-09 14:21:22', '2025-01-10 04:17:29', 1),
(23, 'Emmanuel Ga', 'jdfoodspremiumsauces@gmail.com', '$2y$12$CWI6NsP4ViDLIzH2qqSk0uRXaW6bUZk/lCEkIstQyBqoZ3YV0FO/i', 'JD Foods Premium Sauces Distributor ', 'N/A', 'These JD Foods products are a good way to expand your flavors especially this 2024 to cater to diverse tastes and preference of your customers. Needs 10 Production Worker', 'http://jdfoods.com', '2c9d6395d86860587977952709b2d051.jpg', NULL, NULL, NULL, NULL, NULL, '2025-01-09 17:39:59', '2025-01-10 04:35:25', 1),
(24, 'Justine Mandiya', 'huguardocafe@gmail.com', '$2y$12$83dGxm5zeS6eSczu0YiQUu35H/uBxKnalXvTClpHvm.g7HBCyakOe', 'Huguardo\'s Cafe', 'N/A', 'Huguardo\'s Café is a cozy and inviting spot where community and great coffee meet. Known for its rich brews, freshly baked pastries, and warm ambiance, Huguardo\'s Café offers a perfect space for friends, families, and professionals to gather and unwind', 'http://HuguCafe.com', '91d4af5a107d78df3249abaa80eb015a.jpg', NULL, NULL, NULL, NULL, NULL, '2025-01-09 17:41:24', '2025-01-10 04:36:21', 1),
(25, 'Joy Kritos', 'eBizservices@gmail.com', '$2y$12$j3fTulIKvoiCmrar60Kdb.VaWYXJlaA24ZvrfqTws/gt6US3yJzwK', 'eBIZ (e-Business Services, Inc.)', 'N/A', 'We help individuals and families bridge distances by ensuring their hard-earned money reaches loved ones quickly and safely.', 'http://bizservices.com', '7921d0f5e777915f50231a0de176c30f.jpg', NULL, NULL, NULL, NULL, NULL, '2025-01-09 17:42:33', '2025-01-10 04:37:16', 1),
(26, 'Shane Mae Granse', 'Begraphix@gmail.com', '$2y$12$P24KC8O7UbXG8rOKc/N6deAerPbQLBar5W1PcA2DqhKIGT5U9Is8.', 'Begraphix and Sons Inc.', 'N/A', 'With a commitment to innovation, craftsmanship, and sustainability, we create products that meet the diverse needs of fashion brands, retailers, and customers worldwide.', '', '5042d28483725e1cb22f6a5eeb343eee.jpg', NULL, NULL, NULL, NULL, NULL, '2025-01-09 17:43:34', '2025-01-10 04:38:30', 1),
(27, 'HR Kevin ', 'powersteelmanila@gmail.com', '$2y$12$eQBvcrIMirQPc7EeiLH4UeNkf6E1YZHVKCydnxuM4q65nF0FMGg0y', 'TDT Powersteel Corporation Manila', 'N/A', 'TDT Powersteel Corporation Manila is a leading steel distributor dedicated to providing top-quality steel products for construction, manufacturing, and industrial projects.', 'http://tdtcorp.com', '2a4af081702280f9b7bfbe161cb43119.jpg', NULL, NULL, NULL, NULL, NULL, '2025-01-09 17:44:52', '2025-01-10 04:40:46', 1),
(28, 'Armando  Enriquez', 'csemscorpinc@gmail.com', '$2y$12$tQ2tL6aCMInjeD8vFXbgZOZvy/D9AWCVaKyq.96UFPJE6MxHZD5Ty', 'CSEMSCORP Contractor and Fabricator Inc.', 'N/A', '3 Staff', 'http://CSEMS.com', 'd7da97ed6d6d46332f1c5b271eb04c39.png', NULL, NULL, NULL, NULL, NULL, '2025-01-09 18:00:46', '2025-01-10 04:43:59', 1),
(29, 'Jasmin Lorente', 'dmijunkshop@gmail.com', '$2y$12$/vvY8LoHkjp4NLpX6/YPzuaX6P/68AP9Bq9kRGdvXpFNOzBNk72Zy', 'DMI Recycling Junkshop', 'N/A', 'Staff', 'http://DMI@gmail.com', '814120093ad01c387365766634135dda.jpg', NULL, NULL, NULL, NULL, NULL, '2025-01-09 18:12:05', '2025-01-10 04:45:00', 1),
(30, 'HR Philip', 'redeye@gmail.com', '$2y$12$ODQPuaPayuo1SO38JYZjvOx54N55APxGeCzVo.vWhUtSjGAcm0URW', 'Red Eye II Security Agency and Services Inc', 'N/A', 'Needs 15 Security Guards', 'http://redeyeageny.com', '0e067501af3429bef88334ec0c4f4e85.jpg', NULL, NULL, NULL, NULL, NULL, '2025-01-09 18:18:46', '2025-01-10 04:46:23', 1),
(31, 'James Mesja', 'angkong@gmail.com', '$2y$12$wkUAZP4T8KlYgzZOd6MTIu5BgGXKB0.mJNMRrAoH.0RC8sH/YeVWy', 'Angkong Dimsum House', 'N/A', 'Cook, Cashier', 'http://angkong.com', 'f87df1126c78b84d3cdbf6d37e430fd5.jpg', NULL, NULL, NULL, NULL, NULL, '2025-01-09 18:29:36', '2025-01-10 04:47:26', 1),
(32, 'Angeline Salvorte', 'BN4logistics@gmail.com', '$2y$12$GpLmHXK2gEPgrsnbEH0gV.bvUmncyZwp8uRXSpJBq6.sSKfaHsnTe', 'Big N4 Logistics Sampaloc', 'N/A', 'Needs courier, driver and packer', 'http://bign4.com', '1cd5af2bdb7c746b0a67df939b4d83e0.jpg', NULL, NULL, NULL, NULL, NULL, '2025-01-09 18:34:49', '2025-01-10 04:48:08', 1),
(33, 'John Mark Santos', 'contact@onestopautocare.com', '$2y$12$7R2YRelPoAAMzD37OwNbAO.WG8Zz3EjdRAEmTnjgl6UFM22X0Lkk6', 'One Stop Autocare Center Inc.', 'Your Vehicle, Our Priority', 'One Stop Autocare Center Inc. provides top-notch automotive care, specializing in vehicle maintenance, repair, and servicing. We ensure that your car stays in peak condition with reliable solutions and expert service.', '', '74001c05ddb2d8f9bc2f7f8bf66769ac.jpg', NULL, NULL, NULL, NULL, NULL, '2025-01-10 03:13:59', '2025-01-10 03:13:59', 1),
(34, 'Elizabeth Reyes', 'contact@chilltopmanila.com', '$2y$12$Rnm2Ps2XX9GkSfb2vm.K8OZ5UG1QlYhSzYYJmNRZpNNb/9Id/7vm2', 'Chill Top', 'The Coolest Hangout Spot in Town', 'Chill Top is the newest and coolest hangout spot offering a 360° view of Manila. We provide great food, drinks, and an unforgettable experience for customers.', '', '38b173011b85a4719ffada3a357cbe0a.jpg', NULL, NULL, NULL, NULL, NULL, '2025-01-10 03:21:08', '2025-01-10 03:21:08', 1),
(35, 'Jen Flores', 'contact@foursdance.com', '$2y$12$pIEEPLGUm7ZHO7xIcEOtT.5jagXlOgjAI8cl2MUDrhdDonRLoHXim', 'Four S Dance Studio', 'Dance Your Heart Out', 'Four S Dance Studio provides a rental space for dance classes, rehearsals, and performances, catering to aspiring dancers and enthusiasts.', '', 'afe77a862722985580719fe953a31245.jpg', NULL, NULL, NULL, NULL, NULL, '2025-01-10 03:25:30', '2025-01-10 03:25:30', 1),
(36, 'Lance Ramos', 'contact@dictechshutter.com', '$2y$12$587QoWiYFdxOtshW97vREuU.17xKORMoQjnbso7KiB2ut.rYXWDXS', 'Dictech Shutter Roll Up Door & Glass Installation Services', 'Securing Spaces, Enhancing Views', 'Dictech specializes in premium roll-up doors, shutters, and glass installation services. Combining innovative solutions with durability, we provide security and aesthetic enhancements for commercial and residential spaces.', '', '849bf5efef0d38cbff612e271ab2c900.jpg', NULL, NULL, NULL, NULL, NULL, '2025-01-10 04:22:55', '2025-01-10 04:22:55', 1),
(37, 'Julius Macha', 'contact@petsunlimitedph.com', '$2y$12$jfq5aXSIDmHsJwywM8GCA.WqFspW70IlPXI5v5qE4YpzKvztfOxtS', 'Pets Unlimited PH / Fish and Pets', 'Your Trusted Pet Care Destination', 'Pets Unlimited PH is a one-stop shop for all your pet care needs, offering a wide variety of fish, pets, and quality pet supplies. We provide the essentials to keep your furry and aquatic friends happy and healthy.', '', '64ea49228343d8ecdee96f5c74a14fd0.jpg', NULL, NULL, NULL, NULL, NULL, '2025-01-10 04:58:10', '2025-01-10 04:58:10', 1),
(38, 'Joan Pineda', 'pneumovent@yahoo.com', '$2y$12$xFLK4Cdtnuvx4rYfvDG9p.nX9H85Etv05VJlCLpp96vt.jKAYwW0G', 'Pneumovent Medical Enterprises', 'Delivering Life-Saving Solutions', 'Pneumovent Medical Enterprises is a trusted provider of medical supplies and equipment, dedicated to supporting healthcare professionals with high-quality products that ensure patient care and safety.', '', 'bc40917cebf9616828501f1cb8d9985a.jpg', NULL, NULL, NULL, NULL, NULL, '2025-01-10 05:00:48', '2025-01-10 05:00:48', 1),
(39, 'Andrew De Guzman', 'contact@lunarsbakery.com', '$2y$12$p/P46ck/hqUPXwccuuGAmuRLvWv37I2JS3gXcic2iknG4QJZWVKne', 'Lunar\'s Bakery', 'Freshly Baked, Always Delicious', 'Lunar\'s Bakery is a local favorite known for its homemade donuts and baked goods made fresh daily. We focus on delivering quality treats that bring smiles to every customer.', '', 'a87eac891b0d74ec85a68ea68da0dc21.jpg', NULL, NULL, NULL, NULL, NULL, '2025-01-10 05:03:08', '2025-01-10 05:03:08', 1),
(40, 'Aly Sebastian', 'contact@manilaroseevents.com', '$2y$12$WVnGZVUH64GAbrxRQ3Uly.uNTydMfGQggQzKfOI01uRBCs1OM/o/u', 'Manila Rose', 'Your Event, Our Passion', 'Manila Rose is a premier events place offering a stylish venue for weddings, birthdays, and special celebrations. We aim to make every event unforgettable.', '', '9586da4f0dbf0a08bef073c557f52844.jpg', NULL, NULL, NULL, NULL, NULL, '2025-01-10 05:08:14', '2025-01-10 05:08:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblexperience`
--

CREATE TABLE `tblexperience` (
  `ID` int(10) NOT NULL,
  `UserID` int(10) DEFAULT NULL,
  `EmployerName` varchar(200) DEFAULT NULL,
  `EmployementType` varchar(200) DEFAULT NULL,
  `Designation` varchar(200) DEFAULT NULL,
  `Ctc` decimal(10,0) DEFAULT NULL,
  `FromDate` varchar(200) DEFAULT NULL,
  `ToDate` varchar(200) DEFAULT NULL,
  `Skills` varchar(200) NOT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblexperience`
--

INSERT INTO `tblexperience` (`ID`, `UserID`, `EmployerName`, `EmployementType`, `Designation`, `Ctc`, `FromDate`, `ToDate`, `Skills`, `CreationDate`) VALUES
(1, 1, 'TCS', 'Full Time', 'Software Developer', 100000, '2017-08-01', '2022-12-31', '', '2023-02-25 13:51:46'),
(2, 3, 'CONCENTRIX', 'Full Time', 'Quezon City', 0, '', '', '', '2024-12-09 07:54:51');

-- --------------------------------------------------------

--
-- Table structure for table `tbljobs`
--

CREATE TABLE `tbljobs` (
  `jobId` int(11) NOT NULL,
  `employerId` int(11) NOT NULL,
  `jobCategory` varchar(255) DEFAULT NULL,
  `jobTitle` varchar(255) DEFAULT NULL,
  `jobType` varchar(255) DEFAULT NULL,
  `salaryPackage` char(200) DEFAULT NULL,
  `skillsRequired` varchar(255) DEFAULT NULL,
  `experience` varchar(50) DEFAULT NULL,
  `jobLocation` varchar(255) DEFAULT NULL,
  `jobDescription` mediumtext DEFAULT NULL,
  `JobExpdate` date DEFAULT NULL,
  `postinDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `isActive` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbljobs`
--

INSERT INTO `tbljobs` (`jobId`, `employerId`, `jobCategory`, `jobTitle`, `jobType`, `salaryPackage`, `skillsRequired`, `experience`, `jobLocation`, `jobDescription`, `JobExpdate`, `postinDate`, `updationDate`, `isActive`) VALUES
(1, 1, 'Food Service', 'Butcher', 'Part Time', '15,000 - 20,000 PHP per month', 'Knife Handling, Meat Preparation, Food Safety Knowledge', '1 - 2 years', 'Barangay 566, Zone 55, Balic-Balic, Sampaloc, Manila City', 'Responsible for cutting, trimming, deboning, and packaging meat products. Ensures meat quality and hygiene standards are met. Operates tools such as knives, grinders, and saws to process meat efficiently.', '2024-12-31', '2024-12-15 12:31:17', '2024-12-07 23:31:14', 1),
(2, 1, 'Food Service', 'Dishwasher', 'Full Time', '12,000 - 15,000 PHP per month', 'Attention to Detail, Time Management, Basic Kitchen Operations', '0 - 1 year (Entry-Level)', 'Barangay 568, Zone 55, Balic-Balic, Sampaloc, Manila City', 'Maintains cleanliness in the kitchen by washing dishes, utensils, and cooking equipment. Assists kitchen staff with basic cleaning and sanitization duties while ensuring an organized workspace.', '2024-12-31', '2024-12-15 12:31:17', '2024-12-07 23:21:02', 1),
(3, 1, 'Food Service', 'Kitchen Helper', 'Full Time', '13,000 - 16,000 PHP per month', 'Food Preparation, Multitasking, Teamwork', '0 - 1 year', 'Barangay 559, Zone 55, Balic-Balic, Sampaloc, Manila City', 'Assists chefs in food preparation, chopping vegetables, peeling ingredients, and organizing kitchen tools. Supports kitchen operations by maintaining cleanliness and managing stock of supplies.', '2024-12-31', '2024-12-07 22:45:47', NULL, 1),
(4, 2, 'Manufacturing', 'Factory Worker', 'Contract', '14,000 - 18,000 PHP per month', 'Basic Assembly Skills, Physical Stamina, Attention to Detail', '0 - 1 year', 'Barangay 555, Zone 55, Balic-Balic, Sampaloc, Manila City', 'Performs tasks on the production line, such as assembling products, packaging goods, or inspecting items for quality. Operates simple machinery and ensures production standards are met.', '2024-12-31', '2024-12-07 23:11:42', NULL, 1),
(5, 2, 'Manufacturing', 'Machine Operator', 'Full Time', '15,000 - 20,000 PHP per month', 'Machine Operation, Troubleshooting, Safety Compliance', '1 - 2 years', 'Barangay 560, Zone 55, Balic-Balic, Sampaloc, Manila City', 'Operates and monitors industrial machines to ensure smooth production processes. Performs routine checks, troubleshoots machine issues, and follows safety protocols to maintain efficient operations.', '2024-12-31', '2024-12-07 23:26:52', NULL, 1),
(11, 8, 'Construction ', 'Electrician', 'Full Time', '15,000 PHP per month', 'Proficiency in electrical installation, repair, and maintenance; Ability to read and interpret blueprints and technical diagrams; Knowledge of electrical codes and safety protocols.', '1', 'Barangay 566, Zone 55, Balic-Balic, Sampaloc, Manila City', 'In this role, you will be responsible for installing, maintaining, and repairing electrical systems in residential, commercial, and industrial settings. You will troubleshoot electrical issues, ensure compliance with safety standards, and interpret blueprints or technical diagrams to execute tasks efficiently.', '2025-01-01', '2024-12-08 14:23:45', '2024-12-08 16:13:14', 1),
(12, 7, 'Construction ', 'Construction Worker ', 'Part Time', '15,000 PHP per month', 'Ability to operate and maintain construction tools and machinery.', '1 - 2 years ', 'Barangay 564, Zone 55, Balic-Balic, Sampaloc, Manila City ', '<span lang=\"EN-GB\" style=\"font-size:12.0pt;font-family:\r\n&quot;Arial&quot;,sans-serif;mso-fareast-font-family:&quot;Times New Roman&quot;;color:#1C1E21;\r\nmso-font-kerning:0pt;mso-ligatures:none;mso-ansi-language:EN-GB;mso-fareast-language:\r\nEN-GB;mso-bidi-language:AR-SA\">We are looking for skilled and experienced\r\nConstruction Workers to perform tasks such as masonry, carpentry, and operating\r\nconstruction tools safely and efficiently. Collaboration with team members and\r\nsupervisors is essential to ensure projects are completed on time and within\r\nscope.</span>', '2025-01-22', '2024-12-08 14:32:41', '2024-12-08 16:05:25', 2),
(13, 7, 'Logistics ', 'Truck Driver', 'Full Time', '15,000 - 17,000 PHP per month', 'Valid driver’s license with a clean driving record; Knowledge of road safety regulations and vehicle maintenance', '1 - 2 years ', 'Barangay 564, Zone 55, Balic-Balic, Sampaloc, Manila City ', 'StoneBridge Services is seeking an experienced Truck Driver to join our team on a contract basis. In this role, you will be responsible for safely transporting construction materials, equipment, and other goods to various job sites within and around Manila. You will ensure the truck is well-maintained, follow all traffic laws, and complete necessary documentation for each delivery.', '2025-01-08', '2024-12-08 14:37:37', '2024-12-08 15:56:55', 1),
(14, 7, 'Logistics ', 'Delivery Driver', 'Contract', '15,000 PHP per month', 'Valid driver’s license with a clean driving record; Strong knowledge of road safety regulations', '6 months - 1 year', 'Barangay 564, Zone 55, Balic-Balic, Sampaloc, Manila City ', 'StoneBridge Services is looking for a reliable and responsible Delivery Driver to join our team on a contract basis. In this role, you will be responsible for delivering construction materials, tools, and other items to various job sites within Manila. You will ensure timely and safe delivery, maintain accurate delivery logs, and ensure that all goods are handled with care.', '2025-01-24', '2024-12-08 14:46:32', '2024-12-08 15:56:40', 1),
(15, 9, 'Construction ', 'Janitor', 'Full Time', '14,000', 'Basic cleaning skills and knowledge of cleaning equipment', 'No experience needed', 'Barangay 562, Zone 55, Balic-Balic, Sampaloc, Manila City ', 'StreetSmart Cleaning Co. is looking for a dedicated and hardworking Janitor to join our team. As a Janitor, you will be responsible for cleaning and maintaining facilities, ensuring a safe and tidy environment for employees and visitors. You will perform general cleaning tasks such as sweeping, mopping, dusting, and emptying trash bins, while adhering to safety and cleanliness standards.\r\n\r\n', '2025-02-13', '2024-12-08 14:55:01', '2024-12-08 16:14:03', 1),
(16, 10, 'Logistics ', 'Warehouse Worker', 'Full Time', '15,000 PHP per month', ': Ability to lift and move heavy items; Strong attention to detail and organizational skills; ', 'No experience needed', 'Barangay 561, Zone 55, Balic-Balic, Sampaloc, Manila City ', 'SwiftMove Logistics is hiring a Warehouse Worker to assist with inventory management and warehouse organization. Responsibilities include receiving, sorting, and packaging goods for shipment, while maintaining a clean and efficient workspace. No experience required, as training will be provided. If you are detail-oriented, reliable, and ready to work in a fast-paced environment, we encourage you to apply.', '2025-01-30', '2024-12-08 15:17:52', '2024-12-08 16:11:01', 1),
(17, 10, 'Logistics ', 'Packager', 'Full Time', '15,000 PHP per month', 'Attention to detail to ensure accurate packaging', 'No experience needed', 'Barangay 561, Zone 55, Balic-Balic, Sampaloc, Manila City ', 'SwiftMove Logistics is looking for a Packager to join our team. In this role, you will be responsible for accurately packing products, ensuring they are secure and ready for shipment. You will also assist in labeling and organizing packages within the warehouse. No prior experience is needed, as training will be provided. If you\'re detail-oriented, reliable, and enjoy working in a fast-paced environment, we’d love to have you as part of our team.', '2025-02-27', '2024-12-08 15:20:40', '2024-12-08 16:10:51', 1),
(18, 11, 'Waste Management', 'Garbage Collector', 'Full Time', '12,000 PHP per month', 'Ability to perform physical labor and handle heavy lifting', '0', 'Barangay 567, Zone 55, Balic-Balic, Sampaloc, Manila City', 'In this role, you will be responsible for collecting garbage from residential and commercial areas and ensuring proper disposal. You will also assist in maintaining cleanliness around collection sites and follow safety protocols to ensure efficient service. No prior experience is needed as training will be provided. If you are punctual, hardworking, and ready to contribute to a cleaner environment, we encourage you to apply.', '2025-01-23', '2024-12-08 15:30:10', '2024-12-08 15:41:30', 1),
(19, 11, 'Waste Management', 'Recycling Technician', 'Full Time', '12,000 PHP per month', 'Ability to work with recycling machinery and tools', '1', 'Barangay 567, Zone 55, Balic-Balic, Sampaloc, Manila City', 'In this full-time role, you will be responsible for sorting and processing recyclable materials, ensuring that all waste is properly segregated and prepared for recycling. You will also operate recycling machinery and maintain a clean and safe work environment. No prior experience is needed, as training will be provided. If you are passionate about sustainability and eager to contribute to a greener environment, we encourage you to apply.', '2025-01-29', '2024-12-08 15:32:03', '2024-12-08 15:41:18', 1),
(20, 7, 'Construction ', 'Construction Worker ', 'Full Time', '15,000 PHP per month', 'Ability to operate and maintain construction tools and machinery', '1', 'Barangay 561, Zone 55, Balic-Balic, Sampaloc, Manila City ', 'We are looking for skilled and experienced Construction Workers to perform tasks such as masonry, carpentry, and operating construction tools safely and efficiently. Collaboration with team members and supervisors is essential to ensure projects are completed on time and within scope.', '2025-02-06', '2024-12-08 16:04:48', NULL, 1),
(21, 13, 'Food Service', 'Barista', 'Full Time', '7,000-13,000', 'Barista Skills', '1 year and Above', '2221 G. Tuazon St Corner Cebu St, Sampaloc, Manila, Philippines', '10 Baristas', '2025-01-31', '2025-01-09 11:18:12', NULL, 1),
(22, 14, 'Security', 'Security Guard', 'Full Time', '35,000-40,000', 'Basic Security Skills', '0-3 years', '4th Floor Padavela Bldg, 2011 G. Tuazon Corner Samar St, Balic-Balic, Sampaloc, Manila', '30 Security Guard', '2025-01-31', '2025-01-09 11:49:11', NULL, 1),
(23, 15, 'Retail', 'Retail Staff', 'Full Time', '11,000,-15,000', 'Know Basic Math and Good Communication', '0-3 Years', '2129 G. Tuazon Street, Sampaloc, Manila, Philippines', '10 Retail Staff', '2025-02-12', '2025-01-09 12:06:27', NULL, 1),
(24, 16, 'Food Service', 'Grill, Kitchen, Dining, Assembly', 'Full Time', '8,000-10,000', 'Food Service Skills', '0-3 Years', 'Lower Ground G. Tuazon Street Corner D. Santiago Street, Sampaloc, Manila', 'Grill, Kitchen, Dining, Assembly (Preferably Male)', '2025-03-20', '2025-01-09 12:28:02', NULL, 1),
(25, 17, 'Logistics ', 'HR Employee Relations, HR Recruitment, HR Timekeeper, Warehouse Supervisor, Branch Supervisor, Customer Service Representative, Quality Assurance Associate', 'Full Time', '17,000-30,000', 'Logistics Skills', '1-5 Years', '658 Carlos Palanca St, San Miguel, Manila', 'HR Employee Relations, HR Recruitment, HR Timekeeper, Warehouse Supervisor, Branch Supervisor, Customer Service Representative, Quality Assurance Associate\r\n', '2025-04-17', '2025-01-09 12:41:34', NULL, 1),
(26, 18, 'Retail', 'Store Cashier', 'Full Time', '13,000 - 17,000', '· Candidate must possess bachelor’s degree (on Business course or any 4 year course)  · Has sufficient background in cashiering, preferably with POS experience.  · Has the ability to provide quality customer service  · Trustworthy, detail-oriented and can', '1yr - up', 'Balic - Balic, Sampaloc, Manila', '· Perform basic math functions to collect payments and make change.\r\n\r\n· Operate registers, scanners, scales and credit card/debit card terminals.\r\n\r\n· Balancing the cash register and generating reports for credit and debit sales.\r\n\r\n· Accepting payments, ensuring all prices and quantities are accurate and proving a receipt to every customer.\r\n\r\n· Handle exchanges and refunds in a quick, efficient manner.\r\n\r\n· Maintain accurate cash drawer.\r\n\r\n· Keep the checkout area clean and orderly.\r\n', '2025-01-31', '2025-01-09 13:55:41', NULL, 1),
(27, 19, 'Retail', 'Warehouse Assistant', 'Full Time', '12,000 - 15,000', '· Senior High School Graduate or Undergraduate.  · Strong attention to detail.  · Good organizational and communication skills  · Trustworthy and reliable.', '1yr - up', '2114-A Sobriedad St., Balic-balic, Sampaloc, Manila', 'E-commerce, retail industry', '2025-01-31', '2025-01-09 14:06:37', NULL, 1),
(28, 20, 'Food', 'Barista', 'Full Time', '12,000 - 16,000', '· Male only (at least 18 years old)  · Shift schedule is Tuesday to Sunday (8pm - 2am)  · It is preferable to have prior experience in food and beverage prepartion or customer service.  · Willingness to learn more about food and beverage preparation is re', '2yrs - up', '791 Roxas St. Cor. Mindanao Ave. Balic-Balic, Sampaloc, Manila', 'Customer-focused barista serving high-quality espresso and brewed coffee.', '2025-01-31', '2025-01-09 14:13:27', NULL, 1),
(29, 21, 'Food', 'Coffee Barista', 'Full Time', '12,000 - 16,000', '· Can work an 8-hour shift (2PM - 10PM)  · With pleasing personality  · With good working attitude/professional.  · With basic knowledge in coffee/espresso making  · Willing to be trained and flexible  · Fast Learner  · With good customer service skill', '1yr - up', 'Balic - Balic, Sampaloc, Manila', 'Customer-focused barista serving high-quality espresso and brewed coffee. Reliable team player with a friendly, positive demeanor, who enjoys interacting with customers. Prepared espresso shots, pour overs, French-press and drip coffee.', '2025-01-31', '2025-01-09 14:18:58', NULL, 1),
(30, 22, 'Food', 'Baker', 'Full Time', '15,000 - 17,000', '· Male  · Atleast high school graduate or with TESDA Certificate (Bread and Pastry)  · Preferably with related work experience  · With basic knowledge in coffee/espresso making  · Physically Fit', '2 yrs - up', 'G. Tuazon, Balic-Balic, Sampaloc, Manila', 'Julie\'s Bakeshop bakers are responsible for baking fresh bread and other baked goods in full view of customers', '2025-01-31', '2025-01-09 14:23:17', NULL, 1),
(31, 23, 'Food', 'Production Worker', 'Full Time', '9,000-15,000', 'Food Service Skills', '0-5 Years', 'Balic-Balic, 1090 Negros, Sampaloc, 1008 Metro Manila', '10 Production worker', '2025-04-29', '2025-01-09 17:46:38', NULL, 1),
(32, 24, 'Food', 'Barista', 'Part Time', '20,000-35,000', 'Barista Skills', '1-6 Years', '536 3rd Floor Calabash Rd. Balic Balic Sampaloc Manila Manila, 1008 Metro Manila', '5 Part-Time Barista', '2025-01-27', '2025-01-09 17:48:13', NULL, 1),
(33, 25, 'Cash Handler', 'Cash Handler', 'Full Time', '18,000-32,000', 'Problem-Solving Skills, Sales, and Basic Math Skills', '2 Years and Above', 'Space 3 C/F, WELCOME 1852, Gerardo Tuazon St, Manila', 'Need 3 Cash Handlers', '2025-01-19', '2025-01-09 17:52:54', NULL, 1),
(34, 26, 'Retail', 'Sewing Machine Operator', 'Part Time', '22,000-32,000', 'Sewing Skills', '3 Years and Above', 'Zone 55, 2189 Bohol St, Sampaloc, Manila, 1008 Metro Manila', '2 Sewers', '2025-03-19', '2025-01-09 17:55:12', NULL, 1),
(35, 27, 'Retail', 'Steel Cutter', 'Full Time', '25,600-40,000', 'Steel Cutting Skills', '2 Years and Above', '1017 Vicente Cruz St, Sampaloc, Manila, 1008 Metro Manila', 'Needs 4 Steel Cutter for Retail', '2025-02-22', '2025-01-09 17:57:17', NULL, 1),
(36, 28, 'Construction ', 'Contractor, Fabricator', 'Full Time', '30,000-40,000', 'Knows how to utilize hollow block mold machines.', '2-5 Years', '2252 G. Tuazon cor. Cebu St.,Balic-Balic Sampaloc, Manila', 'Needs 2 Contractors and 3 Fabricators', '2025-02-06', '2025-01-09 18:04:00', NULL, 1),
(37, 29, 'Waste Management', 'Waste Recycler, Truck Driver', 'Full Time', '10,000-20,000', 'recycling skills and driving skills', '0-3 Years', '2447 Isagani St, Santa Cruz, Manila, 1014 Metro Manila', 'Needs Waste Recycler and Driver', '2025-04-08', '2025-01-09 18:13:38', NULL, 1),
(38, 30, 'Security', 'Security Guard', 'Full Time', '30,000-40,000', 'Basic Security Skills and Patrolling Skills', '1-3 Years', '3/F Sanville Bldg 2058 Laon Laan St, Sampaloc, Manila', 'Needs 20 Security Guards', '2025-02-18', '2025-01-09 18:20:19', NULL, 1),
(39, 31, 'Food', 'Cook, Cashier', 'Part Time', '11,000-15,000', 'Cooking Skills, Basic Math ', '1-4 Years', 'Gelinos St, Sampaloc, Manila, 1008 Metro Manila', 'Cook and Cashier', '2025-02-26', '2025-01-09 18:31:18', NULL, 1),
(40, 32, 'Logistics ', 'Courier, Driver, Product Packer', 'Full Time', '20,000-30,000', 'Driving Skills, Packing Skills', '0-5 Years', '836b Antipolo St, Sampaloc, Manila, 1008 Metro Manila', 'Needs 10 Staffs each', '2025-02-20', '2025-01-09 18:36:23', NULL, 1),
(41, 33, 'Automotive Service', 'Auto Mechanic', 'Full Time', '16,000 - 22,000 PHP per month', 'Vehicle Diagnostics, Engine Repair, Preventive Maintenance, Troubleshooting Skills', '1-2 years', ': 1741 Gerardo Tuazon St, 437 Zone 44, Manila, 1008 Metro Manila ', 'Responsible for diagnosing and repairing vehicle issues, including engines, brakes, transmissions, and electrical systems. Conducts routine maintenance and ensures vehicles are safe and roadworthy.', '2025-01-31', '2025-01-10 03:19:30', NULL, 1),
(42, 34, 'Food', 'Kitchen Helper', 'Full Time', '12,000 - 14,000 PHP per month', 'Food Preparation, Dishwashing, Teamwork', '0-1 year', '308 Gen. Geronimo St, Sampaloc, Manila', 'Assists kitchen staff with food preparation, cleaning, and dishwashing. Ensures the kitchen area remains clean and organized.', '2025-01-31', '2025-01-10 03:22:46', NULL, 1),
(43, 35, 'Waste Management', 'Studio Cleaner', 'Full Time', '12,000 PHP per month', 'Cleaning, Time Management, Attention to Detail', '0-1 year', '418 Verdad, Sampaloc, Manila', 'Cleans and maintains the dance studio floors, mirrors, and equipment to ensure a clean and safe environment for dancers.', '2025-01-31', '2025-01-10 03:26:41', NULL, 1),
(44, 36, 'Construction ', 'Shutter Door Installer', 'Full Time', '12,000 PHP per month', 'Metal Fabrication, Installation Tools Handling, Technical Knowledge of Roll-Up Doors, Welding Skills', '0-1 year', '958 Bohol St, Sampaloc, Manila, 1008 Metro Manila', 'Installs, repairs, and maintains roll-up doors, shutters, and glass panels. Ensures proper alignment, functionality, and durability of all installed units. Operates power tools and equipment safely.', '2025-01-31', '2025-01-10 04:25:44', NULL, 1),
(45, 37, 'Cash Handler', 'Assistant', 'Full Time', '12,000 PHP per month', 'Animal Care Knowledge, Cleaning, Customer Service, Basic Inventory Handling', '0-1 year', '1000 Panay St, Sampaloc, Manila', 'Responsible for feeding, grooming, and monitoring pets, including fish and small animals. Maintains cleanliness of pet enclosures and assists customers in choosing appropriate products for their pets.', '2025-01-31', '2025-01-10 04:59:45', NULL, 1),
(46, 38, 'Waste Management', 'General Maintenance', 'Full Time', '12,000 PHP per month', 'Cleaning, Attention to Detail, Time Management, Basic Maintenance Knowledge', '0-1 year', '1024 Panay St, Sampaloc, Manila, 1008 Metro Manila', 'Responsible for cleaning and maintaining the office premises, including sweeping, mopping, dusting, and sanitizing work areas. Ensures that the office remains tidy and organized. Assists in basic maintenance tasks as needed.', '2025-01-31', '2025-01-10 05:01:53', NULL, 1),
(47, 39, 'Food', 'Baker Assistant', 'Full Time', '12,000 PHP per month', 'Baking Knowledge, Dough Preparation, Time Management', '0-1 year', '1091 Leyte St, Sampaloc, Manila, 1008 Metro Manila', 'Assists the head baker with preparing dough, glazing donuts, and maintaining cleanliness in the baking area.', '2025-01-31', '2025-01-10 05:05:06', NULL, 1),
(48, 39, 'Logistics ', 'Delivery Driver', 'Full Time', '12,000 PHP per month', 'Driving License, Route Planning, Customer Service', '0-1 year', '1091 Leyte St, Sampaloc, Manila, 1008 Metro Manila', 'Delivers baked goods to customers and partner stores on time while ensuring product quality during transport.', '2025-01-31', '2025-01-10 05:07:03', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbljobseekers`
--

CREATE TABLE `tbljobseekers` (
  `id` int(11) NOT NULL,
  `FullName` varchar(150) DEFAULT NULL,
  `EmailId` varchar(150) DEFAULT NULL,
  `ContactNumber` bigint(15) DEFAULT NULL,
  `Password` varchar(150) DEFAULT NULL,
  `Resume` varchar(150) DEFAULT NULL,
  `AboutMe` mediumtext DEFAULT NULL,
  `ProfilePic` varchar(200) DEFAULT NULL,
  `Skills` varchar(200) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `LastUpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `IsActive` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbljobseekers`
--

INSERT INTO `tbljobseekers` (`id`, `FullName`, `EmailId`, `ContactNumber`, `Password`, `Resume`, `AboutMe`, `ProfilePic`, `Skills`, `RegDate`, `LastUpdationDate`, `IsActive`) VALUES
(3, 'Aly Hernandez', 'aly@gmail.com', 9732873827, '$2y$12$N8/89KhwY.T8QTWrSVRHl.syHwXatkXnligA7k1FQs4CMMoAmw9nO', '1d0ea5b49a72d4d07df61e1fd281e4d81733723861.pdf', 'From Montalban, Rizal', '175ff93336c3561cd09310590fe311a91733735504.jpg', '', '2024-12-09 05:57:41', '2024-12-09 09:11:45', 1),
(4, 'Elijah Ashley Santiago ', 'elyas@gmail.com', 9922916024, '$2y$12$Rx7whc2tgyqD2qTKatv0ueBcsJ8Z8.BaJTu2OfKwR7dz3OJD.wRIW', 'f97d35f98b760837114756e5ac83f0251733731622.pdf', NULL, NULL, NULL, '2024-12-09 08:07:02', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblmessage`
--

CREATE TABLE `tblmessage` (
  `ID` int(10) NOT NULL,
  `JobID` int(5) DEFAULT NULL,
  `UserID` int(5) DEFAULT NULL,
  `Message` mediumtext DEFAULT NULL,
  `Status` varchar(200) DEFAULT NULL,
  `ResponseDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblmessage`
--

INSERT INTO `tblmessage` (`ID`, `JobID`, `UserID`, `Message`, `Status`, `ResponseDate`) VALUES
(1, 6, 1, 'You are sort listing for the next round.', 'Sort Listed', '2023-02-25 14:12:07'),
(2, 6, 1, 'Congratulations,\r\nYou are hired\r\n', 'Hired', '2023-02-25 16:28:17'),
(4, 19, 3, 'Congratulations, You are Hired! See you soon.', 'Hired', '2024-12-09 08:03:10'),
(5, 18, 3, 'You are qualified.', 'Hired', '2024-12-09 09:18:06'),
(6, 20, 3, 'congrats', 'Hired', '2024-12-09 10:10:36'),
(7, 20, 4, 'Congrats! You\'re hired.', 'Hired', '2025-03-11 16:13:01');

-- --------------------------------------------------------

--
-- Table structure for table `tblpages`
--

CREATE TABLE `tblpages` (
  `ID` int(11) NOT NULL,
  `PageType` varchar(200) DEFAULT NULL,
  `PageTitle` mediumtext DEFAULT NULL,
  `PageDescription` longtext DEFAULT NULL,
  `Email` varchar(200) NOT NULL,
  `MobileNumber` bigint(10) NOT NULL,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpages`
--

INSERT INTO `tblpages` (`ID`, `PageType`, `PageTitle`, `PageDescription`, `Email`, `MobileNumber`, `UpdationDate`) VALUES
(1, 'aboutus', 'Hanap-Kita', '<div style=\"line-height: 1.8; max-width: 700px; margin: auto;\">\r\n    <p class=\"MsoNormal\" style=\"text-align:justify\"><font face=\"verdana\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</font><font color=\"#000000\" style=\"\" face=\"verdana\">Hanap-Kita is a community-focused\r\njob portal dedicated to connecting job seekers and local businesses in\r\nBalic-Balic, Sampaloc, Manila. Our platform simplifies the employment process\r\nby focusing on blue-collar jobs—providing opportunities for skilled workers and\r\nhelping businesses find the right talent efficiently.&nbsp;<o:p></o:p></font></p><p class=\"MsoNormal\" style=\"text-align:justify\"><b><font color=\"#000000\" face=\"verdana\">For Job Seekers<o:p></o:p></font></b></p><p class=\"MsoNormal\" style=\"text-align:justify\"><font color=\"#000000\" face=\"verdana\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Job seekers&nbsp;can register for free and discover local\r\njob opportunities that align with their skills and experience. They can access\r\njob listings in various fields, including construction, manufacturing,\r\nmaintenance, driving, hospitality, retail, and other hands-on industries.\r\nHanap-Kita allows them to connect directly with employers who are searching for\r\nhardworking, skilled, and dependable candidates.<o:p></o:p></font></p><p class=\"MsoNormal\" style=\"text-align:justify\"><b><font color=\"#000000\" face=\"verdana\">For Employers<o:p></o:p></font></b></p><p class=\"MsoNormal\" style=\"text-align:justify\"><font color=\"#000000\" face=\"verdana\">&nbsp; &nbsp; &nbsp; &nbsp;\r\n&nbsp; Employers can post job openings\r\nto attract qualified blue-collar workers from within the community. By using\r\nHanap-Kita, they can save time managing job postings and effectively screen\r\napplicants. This platform helps employers find the right workers who meet their\r\nrequirements and contribute to their business success.<o:p></o:p></font></p><p class=\"MsoNormal\" style=\"text-align:justify\"><b><font color=\"#000000\" face=\"verdana\">Who Can Use Hanap-Kita?<o:p></o:p></font></b></p><p class=\"MsoNormal\" style=\"text-align:justify\"><font color=\"#000000\" face=\"verdana\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Hanap-Kita is designed for both\r\njob seekers looking for reliable blue-collar employment opportunities and\r\nemployers seeking skilled workers for manual, technical, or service-oriented\r\njobs. Local businesses and organizations can use this platform to connect with\r\nthe workforce in their community.<o:p></o:p></font></p><p class=\"MsoNormal\" style=\"text-align:justify\"><b><font color=\"#000000\" face=\"verdana\">Our Mission<o:p></o:p></font></b></p><p class=\"MsoNormal\" style=\"text-align:justify\"><font face=\"verdana\"><font color=\"#000000\">&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;At&nbsp;Hanap-</font><span style=\"color: rgb(0, 0, 0);\">Kita</span><font color=\"#000000\">, we aim to bridge\r\nthe gap between hardworking job seekers and local employers. By focusing on\r\nblue-collar jobs, we empower individuals with hands-on skills and support\r\nbusinesses that drive our local economy.<o:p></o:p></font></font></p><p class=\"MsoNormal\" style=\"text-align:justify\"><font color=\"#000000\" face=\"verdana\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;All job listings are&nbsp;categorized\r\nby industry and field, making it easy for users to navigate opportunities. Whether\r\nyou’re a worker looking to take the next step in your career or a business\r\nneeding dependable staff,&nbsp;Hanap-Kita is here to help.<o:p></o:p></font></p><p style=\"text-align: justify;\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\" style=\"text-align: center;\"><b style=\"\"><font face=\"verdana\"><font color=\"#000000\" style=\"\">Discover local opportunities.\r\nConnect with trusted employers. Build a better future with Hanap-</font><span style=\"color: rgb(0, 0, 0); text-align: justify;\">Kita</span><font color=\"#000000\" style=\"\">!</font></font></b><o:p></o:p></p>\r\n\r\n    \r\n</div>\r\n', '', 0, '2024-12-08 05:56:26'),
(2, 'contactus', 'Contact Us', 'Zone 55, Panay St, Sampalok 560, Sampaloc, 1008 Metro Manila', 'hanapkita@gmail.com', 6397675452110, '2024-12-07 20:59:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblapplyjob`
--
ALTER TABLE `tblapplyjob`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CategoryName` (`CategoryName`);

--
-- Indexes for table `tbleducation`
--
ALTER TABLE `tbleducation`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblemployers`
--
ALTER TABLE `tblemployers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblexperience`
--
ALTER TABLE `tblexperience`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `tbljobs`
--
ALTER TABLE `tbljobs`
  ADD PRIMARY KEY (`jobId`);

--
-- Indexes for table `tbljobseekers`
--
ALTER TABLE `tbljobseekers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `tblmessage`
--
ALTER TABLE `tblmessage`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblpages`
--
ALTER TABLE `tblpages`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblapplyjob`
--
ALTER TABLE `tblapplyjob`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbleducation`
--
ALTER TABLE `tbleducation`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblemployers`
--
ALTER TABLE `tblemployers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tblexperience`
--
ALTER TABLE `tblexperience`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbljobs`
--
ALTER TABLE `tbljobs`
  MODIFY `jobId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tbljobseekers`
--
ALTER TABLE `tbljobseekers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblmessage`
--
ALTER TABLE `tblmessage`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblpages`
--
ALTER TABLE `tblpages`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
