-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 16, 2025 at 04:19 AM
-- Server version: 5.6.38
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_ter2`
--

-- --------------------------------------------------------

--
-- Table structure for table `ActivityBookingDetails`
--

CREATE TABLE `ActivityBookingDetails` (
  `ActivityBookingID` int(11) NOT NULL,
  `BookingID` int(11) DEFAULT NULL,
  `ActivityID` int(11) DEFAULT NULL,
  `ActivityDate` date DEFAULT NULL,
  `NumberOfTickets` int(11) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ActivityBookingDetails`
--

INSERT INTO `ActivityBookingDetails` (`ActivityBookingID`, `BookingID`, `ActivityID`, `ActivityDate`, `NumberOfTickets`, `Price`) VALUES
(1, 1, 1, '2024-01-17', 2, 10000.00),
(2, 2, 2, '2024-02-22', 4, 20000.00),
(3, 3, 3, '2024-03-13', 5, 25000.00),
(4, 4, 4, '2024-04-06', 2, 15000.00),
(5, 5, 5, '2024-05-02', 3, 10000.00),
(6, 6, 6, '2024-01-21', 2, 12000.00),
(7, 7, 7, '2024-02-26', 3, 16000.00),
(8, 8, 8, '2024-03-16', 4, 20000.00),
(9, 9, 9, '2024-04-11', 2, 18000.00),
(10, 10, 10, '2024-05-07', 1, 7000.00),
(11, 21, 1, '2025-01-14', 2, 10000.00),
(12, 24, 1, '2025-01-19', 1, 5000.00),
(13, 25, 6, '2025-01-30', 0, 0.00),
(14, 26, 1, '2025-01-15', 2, 10000.00),
(15, 52, 6, '2025-01-23', 2, 0.00),
(16, 59, 6, '2025-01-16', 2, 0.00),
(17, 74, 11, '2025-01-16', 2, 50.00),
(18, 88, 2, '2025-01-20', 2, 20000.00);

-- --------------------------------------------------------

--
-- Table structure for table `Bookings`
--

CREATE TABLE `Bookings` (
  `BookingID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TotalCost` decimal(10,2) DEFAULT NULL,
  `BookingDate` date DEFAULT NULL,
  `PaymentStatus` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Bookings`
--

INSERT INTO `Bookings` (`BookingID`, `UserID`, `TotalCost`, `BookingDate`, `PaymentStatus`) VALUES
(1, 1, 30000.00, '2024-01-15', 'مدفوع'),
(2, 2, 15000.00, '2024-02-20', 'مدفوع'),
(3, 3, 25000.00, '2024-03-10', 'قيد الانتظار'),
(4, 4, 40000.00, '2024-04-05', 'مدفوع'),
(5, 5, 10000.00, '2024-05-01', 'مدفوع'),
(6, 6, 28000.00, '2024-01-20', 'مدفوع'),
(7, 7, 12000.00, '2024-02-25', 'مدفوع'),
(8, 8, 20000.00, '2024-03-15', 'قيد الانتظار'),
(9, 9, 35000.00, '2024-04-10', 'مدفوع'),
(10, 10, 9000.00, '2024-05-05', 'مدفوع'),
(11, 1, NULL, '2025-01-13', 'قيد الدفع'),
(12, 1, NULL, '2025-01-13', 'قيد الدفع'),
(13, 1, NULL, '2025-01-13', 'قيد الدفع'),
(14, 1, NULL, '2025-01-13', 'قيد الدفع'),
(15, 1, NULL, '2025-01-13', 'قيد الدفع'),
(16, 1, 0.00, '2025-01-13', 'قيد الدفع'),
(17, 1, 90000.00, '2025-01-13', 'قيد الدفع'),
(18, 1, 0.00, '2025-01-13', 'قيد الدفع'),
(19, 1, 480000.00, '2025-01-13', 'قيد الدفع'),
(20, 1, 0.00, '2025-01-13', 'قيد الدفع'),
(21, 1, 10000.00, '2025-01-13', 'قيد الدفع'),
(22, 1, 45000.00, '2025-01-13', 'قيد الدفع'),
(23, 1, 0.00, '2025-01-13', 'قيد الدفع'),
(24, 1, 5000.00, '2025-01-13', 'قيد الدفع'),
(25, 1, 0.00, '2025-01-13', 'قيد الدفع'),
(26, 1, 10000.00, '2025-01-13', 'قيد الدفع'),
(27, 1, 45000.00, '2025-01-13', 'قيد الدفع'),
(28, 1, 120000.00, '2025-01-13', 'قيد الدفع'),
(29, 1, 60000.00, '2025-01-13', 'قيد الدفع'),
(30, 1, 0.00, '2025-01-13', 'قيد الدفع'),
(31, 1, 60000.00, '2025-01-13', 'قيد الدفع'),
(32, 1, 8000.00, '2025-01-13', 'قيد الدفع'),
(33, 1, 60000.00, '2025-01-13', 'قيد الدفع'),
(34, 1, 90000.00, '2025-01-13', 'قيد الدفع'),
(35, 1, 90000.00, '2025-01-13', 'قيد الدفع'),
(36, 1, 0.00, '2025-01-13', 'قيد الدفع'),
(37, 1, 0.00, '2025-01-13', 'قيد الدفع'),
(38, 1, 0.00, '2025-01-13', 'قيد الدفع'),
(39, 1, 0.00, '2025-01-13', 'قيد الدفع'),
(40, 1, 0.00, '2025-01-13', 'قيد الدفع'),
(41, 1, 0.00, '2025-01-13', 'قيد الدفع'),
(42, 1, 0.00, '2025-01-14', 'قيد الدفع'),
(43, 1, 0.00, '2025-01-14', 'قيد الدفع'),
(44, 1, 0.00, '2025-01-14', 'قيد الدفع'),
(45, 1, 60000.00, '2025-01-14', 'قيد الدفع'),
(46, 1, 0.00, '2025-01-15', 'قيد الدفع'),
(47, 1, 24000.00, '2025-01-15', 'قيد الدفع'),
(48, 1, 0.00, '2025-01-15', 'قيد الدفع'),
(49, 1, 0.00, '2025-01-15', 'قيد الدفع'),
(50, 1, 8000.00, '2025-01-15', 'قيد الدفع'),
(51, 1, 16000.00, '2025-01-15', 'قيد الدفع'),
(52, 1, 0.00, '2025-01-15', 'قيد الدفع'),
(53, 1, 0.00, '2025-01-15', 'قيد الدفع'),
(54, 1, 0.00, '2025-01-15', 'قيد الدفع'),
(55, 1, 0.00, '2025-01-15', 'قيد الدفع'),
(56, 1, 0.00, '2025-01-15', 'قيد الدفع'),
(57, 1, 90000.00, '2025-01-15', 'قيد الدفع'),
(58, 1, 0.00, '2025-01-15', 'قيد الدفع'),
(59, 1, 0.00, '2025-01-15', 'قيد الدفع'),
(60, 1, 72000.00, '2025-01-15', 'قيد الدفع'),
(61, 1, 500.00, '2025-01-15', 'قيد الدفع'),
(62, 1, 0.00, '2025-01-15', 'قيد الدفع'),
(63, 1, 24000.00, '2025-01-15', 'قيد الدفع'),
(64, 1, 0.00, '2025-01-15', 'قيد الدفع'),
(65, 1, 48000.00, '2025-01-15', 'قيد الدفع'),
(66, 1, 24000.00, '2025-01-15', 'قيد الدفع'),
(67, 1, 12000.00, '2025-01-15', 'قيد الدفع'),
(68, 1, 12000.00, '2025-01-15', 'قيد الدفع'),
(69, 1, 0.00, '2025-01-15', 'قيد الدفع'),
(70, 1, 500.00, '2025-01-15', 'قيد الدفع'),
(71, 1, 24000.00, '2025-01-15', 'قيد الدفع'),
(72, 1, 0.00, '2025-01-15', 'قيد الدفع'),
(73, 1, 36000.00, '2025-01-15', 'قيد الدفع'),
(74, 1, 50.00, '2025-01-15', 'قيد الدفع'),
(75, 1, 50000.00, '2025-01-15', 'قيد الدفع'),
(76, 1, 0.00, '2025-01-15', 'قيد الدفع'),
(77, 1, 0.00, '2025-01-15', 'قيد الدفع'),
(78, 1, NULL, '2025-01-16', 'قيد الدفع'),
(79, 1, NULL, '2025-01-16', 'قيد الدفع'),
(80, 1, 0.00, '2025-01-16', 'قيد الدفع'),
(81, 1, 48000.00, '2025-01-16', 'قيد الدفع'),
(82, 1, 3500.00, '2025-01-16', 'قيد الدفع'),
(83, 1, 0.00, '2025-01-16', 'قيد الدفع'),
(84, 1, 305.00, '2025-01-16', 'قيد الدفع'),
(85, 1, 0.00, '2025-01-16', 'قيد الدفع'),
(86, 1, 500.00, '2025-01-16', 'قيد الدفع'),
(87, 1, 14000.00, '2025-01-16', 'قيد الدفع'),
(88, 1, 20000.00, '2025-01-16', 'قيد الدفع'),
(89, 1, 305.00, '2025-01-16', 'قيد الدفع'),
(90, 1, 14000.00, '2025-01-16', 'قيد الدفع'),
(91, 1, 76.00, '2025-01-16', 'قيد الدفع'),
(92, 1, 59500.00, '2025-01-16', 'قيد الدفع'),
(93, 1, 400.00, '2025-01-16', 'قيد الدفع'),
(94, 1, 17000.00, '2025-01-16', 'قيد الدفع'),
(95, 1, 12000.00, '2025-01-16', 'قيد الدفع');

-- --------------------------------------------------------

--
-- Table structure for table `CarBookingDetails`
--

CREATE TABLE `CarBookingDetails` (
  `CarBookingID` int(11) NOT NULL,
  `BookingID` int(11) DEFAULT NULL,
  `CarID` int(11) DEFAULT NULL,
  `CarType` varchar(255) DEFAULT NULL,
  `PickupDate` date DEFAULT NULL,
  `ReturnDate` date DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `CarBookingDetails`
--

INSERT INTO `CarBookingDetails` (`CarBookingID`, `BookingID`, `CarID`, `CarType`, `PickupDate`, `ReturnDate`, `Price`) VALUES
(1, 1, 1, 'سيدان', '2024-01-15', '2024-01-18', 24000.00),
(2, 2, 2, 'سيدان', '2024-02-20', '2024-02-22', 14000.00),
(3, 3, 3, 'دفع رباعي', '2024-03-10', '2024-03-14', 60000.00),
(4, 4, 4, 'دفع رباعي', '2024-04-05', '2024-04-06', 18000.00),
(5, 5, 5, 'بيك أب', '2024-05-01', '2024-05-03', 18000.00),
(6, 6, 6, 'سيدان', '2024-01-20', '2024-01-25', 37500.00),
(7, 7, 7, 'سيدان', '2024-02-25', '2024-02-28', 25500.00),
(8, 8, 8, 'دفع رباعي', '2024-03-15', '2024-03-19', 64000.00),
(9, 9, 9, 'دفع رباعي', '2024-04-10', '2024-04-12', 34000.00),
(10, 10, 10, 'ميني فان', '2024-05-05', '2024-05-08', 28500.00),
(11, 12, 6, 'دفع رباعي', '2025-01-13', '2025-01-15', NULL),
(12, 14, 6, 'هاتشباك', '2025-01-13', '2025-01-16', NULL),
(13, 15, 6, 'هاتشباك', '2025-01-13', '2025-01-16', NULL),
(14, 16, 6, 'سيدان', '2025-01-17', '0000-00-00', 0.00),
(15, 20, 6, 'سيدان', '2025-01-14', '0000-00-00', 0.00),
(16, 40, 6, 'سيدان', '2025-01-16', '0000-00-00', 0.00),
(17, 42, 1, 'سيدان', '0000-00-00', '0000-00-00', 0.00),
(18, 47, 1, 'سيدان', '2025-01-21', '0000-00-00', 24000.00),
(19, 50, 1, 'سيدان', '2025-01-16', '0000-00-00', 8000.00),
(20, 51, 1, 'سيدان', '2025-01-15', '0000-00-00', 16000.00),
(21, 58, 6, 'سيدان', '2025-01-17', '0000-00-00', 0.00),
(22, 90, 2, 'سيدان', '2025-01-20', '0000-00-00', 14000.00),
(23, 92, 7, 'سيدان', '2025-01-24', '0000-00-00', 59500.00),
(24, 94, 7, 'سيدان', '2025-01-24', '0000-00-00', 17000.00);

-- --------------------------------------------------------

--
-- Table structure for table `Cars`
--

CREATE TABLE `Cars` (
  `CarID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Type` varchar(255) DEFAULT NULL,
  `SquareID` int(11) DEFAULT NULL,
  `RentalPrice` decimal(10,2) DEFAULT NULL,
  `RentalPerDay` decimal(10,2) DEFAULT NULL,
  `CarDescription` text,
  `MainImageURL` varchar(255) DEFAULT NULL,
  `AdditionalImageURL1` varchar(255) DEFAULT NULL,
  `AdditionalImageURL2` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Cars`
--

INSERT INTO `Cars` (`CarID`, `Name`, `Type`, `SquareID`, `RentalPrice`, `RentalPerDay`, `CarDescription`, `MainImageURL`, `AdditionalImageURL1`, `AdditionalImageURL2`) VALUES
(1, 'تويوتا كورولا', 'سيدان', 1, 8000.00, 8000.00, 'سيارة سيدان اقتصادية ومريحة.', NULL, NULL, NULL),
(2, 'هيونداي أكسنت', 'سيدان', 2, 7000.00, 7000.00, 'سيارة سيدان صغيرة ومناسبة للمدينة.', 'https://www.hyundai.com/content/dam/hyundai/mynaghi/en/data/content/accent-bn7i/highlights/accent-BN7i-highlights-kv-m.jpg', NULL, NULL),
(3, 'نيسان باترول', 'دفع رباعي', 8, 15000.00, NULL, NULL, NULL, NULL, NULL),
(4, 'تويوتا لاند كروزر', 'دفع رباعي', 5, 18000.00, NULL, NULL, NULL, NULL, NULL),
(5, 'هايلكس', 'بيك أب', 9, 9000.00, NULL, NULL, NULL, NULL, NULL),
(6, 'كيا سيراتو', 'سيدان', 1, 7500.00, NULL, NULL, NULL, NULL, NULL),
(7, 'هوندا سيفيك', 'سيدان', 2, 8500.00, NULL, NULL, 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/73/2012_Honda_Civic_EX_sedan_--_07-07-2011.jpg/1280px-2012_Honda_Civic_EX_sedan_--_07-07-2011.jpg011.jpg', NULL, NULL),
(8, 'جيب رانجلر', 'دفع رباعي', 8, 16000.00, NULL, NULL, NULL, NULL, NULL),
(9, 'ميتسوبيشي باجيرو', 'دفع رباعي', 5, 17000.00, NULL, NULL, NULL, NULL, NULL),
(10, 'تويوتا أفانزا', 'ميني فان', 9, 9500.00, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Districts`
--

CREATE TABLE `Districts` (
  `DistrictID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `HistoricalBackground` text,
  `DistanceFromCenter` decimal(10,2) DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Districts`
--

INSERT INTO `Districts` (`DistrictID`, `Name`, `HistoricalBackground`, `DistanceFromCenter`, `ImageURL`) VALUES
(1, 'المخا', 'تشتهر بتاريخها البحري العريق ومينائها التاريخي.', 90.50, 'https://yemenfuture.net/upimgs/images/YF2024-01-19-1503.jpg'),
(2, 'شرعب السلام', 'منطقة زراعية خصبة ذات طبيعة خلابة.', 35.00, 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b6/Jabal_saber_%2815963903633%29_%28cropped%29.jpg/1280px-Jabal_saber_%2815963903633%29_%28cropped%29.jpg'),
(3, 'التعزية', 'تتميز بوجود العديد من الأسواق الشعبية والقرى القديمة.', 20.20, 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/Taiz_city_-_HDR_%2815356981111%29.jpg/1280px-Taiz_city_-_HDR_%2815356981111%29.jpg'),
(4, 'صالة', 'منطقة جبلية وعرة ذات مناظر طبيعية ساحرة.', 45.80, 'https://lh3.googleusercontent.com/p/AF1QipN81FIJHTjWtwJl-ST-Z5bA2OyQ1KgaQAZjLWtm=s2536-w1322-h2536'),
(5, 'المظفر', 'مركز محافظة تعز، وتضم أهم المعالم التاريخية والأسواق.', 10.00, 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f8/Taiz_%2815182373707%29_%28retouched%29.jpg/1280px-Taiz_%2815182373707%29_%28retouched%29.jpg'),
(8, 'azz', 'azz', 200.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSerZgCT-dqBA2E7sQeGeTkZRZs6ditbDCyeQ&usqp=CAU');

-- --------------------------------------------------------

--
-- Table structure for table `EntertainmentPlaces`
--

CREATE TABLE `EntertainmentPlaces` (
  `PlaceID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Type` varchar(255) DEFAULT NULL,
  `SquareID` int(11) DEFAULT NULL,
  `Description` text,
  `TicketPrice` decimal(10,2) DEFAULT NULL,
  `MainImageURL` varchar(255) DEFAULT NULL,
  `AdditionalImageURL1` varchar(255) DEFAULT NULL,
  `AdditionalImageURL2` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `EntertainmentPlaces`
--

INSERT INTO `EntertainmentPlaces` (`PlaceID`, `Name`, `Type`, `SquareID`, `Description`, `TicketPrice`, `MainImageURL`, `AdditionalImageURL1`, `AdditionalImageURL2`) VALUES
(1, 'حديقة جمال', 'حديقة عامة', 1, 'حديقة واسعة ذات مساحات خضراء وألعاب للأطفال.', 5000.00, NULL, NULL, NULL),
(2, 'منتجع الشلال', 'منتجع سياحي', 2, 'منتجع فاخر يضم مسابح وملاعب رياضية ومطاعم.', 10000.00, 'https://lh3.googleusercontent.com/p/AF1QipOLeJ73LQYZecziX-WnYeIIriHsFTNzLLlqf4XX=s2536-w1322-h2536', NULL, NULL),
(3, 'كورنيش المخا', 'شاطئ عام', 8, 'شاطئ رملي يوفر أنشطة ترفيهية متنوعة.', NULL, NULL, NULL, NULL),
(4, 'ملاهي الضباب', 'مدينة ملاهي', 5, 'مدينة ملاهي تضم ألعابًا كهربائية ومائية.', NULL, NULL, NULL, NULL),
(5, 'منتزه جبل صبر', 'منتزه طبيعي', 9, 'منتزه جبلي يوفر مسارات للمشي ومناظر طبيعية خلابة.', NULL, NULL, NULL, NULL),
(6, 'سينما السلام', 'سينما', 1, 'دار سينما تعرض أحدث الأفلام.', NULL, NULL, NULL, NULL),
(7, 'مركز الألعاب الإلكترونية', 'مركز ألعاب', 2, 'مركز ألعاب فيديو وكمبيوتر.', 200.00, 'https://lh3.googleusercontent.com/p/AF1QipMhqgLMUVE7DUuRM9j9BSqQOZNhazMDOu4fGalZ=s2536-w1322-h2536', 'https://lh3.googleusercontent.com/p/AF1QipMhqgLMUVE7DUuRM9j9BSqQOZNhazMDOu4fGalZ=s2536-w1322-h2536', ''),
(8, 'نادي اليخوت', 'نادي رياضي', 8, 'نادي رياضي يوفر أنشطة بحرية.', NULL, NULL, NULL, NULL),
(9, 'مركز التسوق الضباب', 'مركز تسوق', 5, 'مركز تسوق يضم محلات تجارية ومقاهي.', NULL, NULL, NULL, NULL),
(10, 'مسرح صبر', 'مسرح', 9, 'مسرح يقدم عروض فنية وثقافية.', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `HotelBookingDetails`
--

CREATE TABLE `HotelBookingDetails` (
  `HotelBookingID` int(11) NOT NULL,
  `BookingID` int(11) DEFAULT NULL,
  `HotelID` int(11) DEFAULT NULL,
  `RoomType` varchar(255) DEFAULT NULL,
  `NumberOfRooms` int(11) DEFAULT NULL,
  `NumberOfNights` int(11) DEFAULT NULL,
  `CheckInDate` date DEFAULT NULL,
  `CheckOutDate` date DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `HotelBookingDetails`
--

INSERT INTO `HotelBookingDetails` (`HotelBookingID`, `BookingID`, `HotelID`, `RoomType`, `NumberOfRooms`, `NumberOfNights`, `CheckInDate`, `CheckOutDate`, `Price`) VALUES
(1, 1, 1, 'مزدوجة', 1, 3, '2024-01-15', '2024-01-18', 25000.00),
(2, 2, 2, 'ديلوكس', 1, 2, '2024-02-20', '2024-02-22', 20000.00),
(3, 3, 3, 'مطلة على البحر', 2, 4, '2024-03-10', '2024-03-14', 36000.00),
(4, 4, 4, 'فاخرة', 1, 1, '2024-04-05', '2024-04-06', 16000.00),
(5, 5, 5, 'هادئة', 1, 2, '2024-05-01', '2024-05-03', 28000.00),
(6, 6, 6, 'مفردة', 1, 4, '2024-01-20', '2024-01-24', 10000.00),
(7, 7, 7, 'قياسية', 1, 3, '2024-02-25', '2024-02-28', 9000.00),
(8, 8, 8, 'مطلة على البحر', 1, 2, '2024-03-15', '2024-03-17', 20000.00),
(9, 9, 9, 'اقتصادية', 2, 1, '2024-04-10', '2024-04-11', 14000.00),
(10, 10, 10, 'جبلية', 1, 2, '2024-05-05', '2024-05-07', 15000.00),
(11, 17, 1, 'مزدوجة', 3, 2, '0000-00-00', '2025-01-21', 90000.00),
(12, 19, 1, 'أجنحة', 6, 2, '0000-00-00', '2025-01-31', 480000.00),
(13, 22, 1, 'غرفة', 1, 3, '0000-00-00', '2025-01-24', 45000.00),
(14, 27, 1, 'غرفة', 1, 3, '0000-00-00', '2025-01-31', 45000.00),
(15, 28, 1, 'جناح', 1, 3, '0000-00-00', '2025-01-25', 120000.00),
(16, 29, 1, 'غرفة', 2, 2, '0000-00-00', '2025-01-30', 60000.00),
(17, 43, 6, 'جناح', 1, 3, '0000-00-00', '2025-01-17', 0.00),
(18, 45, 1, 'غرفة', 2, 2, '0000-00-00', '2025-02-02', 60000.00),
(19, 49, 1, 'غرفة', 0, 0, '0000-00-00', NULL, 0.00),
(20, 56, 7, 'غرفة', 1, 2, '0000-00-00', '2025-01-18', 0.00),
(21, 57, 1, 'غرفة', 2, 3, '0000-00-00', '2025-01-20', 90000.00),
(22, 60, 2, 'غرفة', 2, 3, '0000-00-00', '2025-01-26', 72000.00),
(23, 62, 3, 'غرفة', 1, 2, '0000-00-00', '2025-01-26', 0.00),
(24, 63, 2, 'غرفة', 2, 1, '0000-00-00', '2025-01-24', 24000.00),
(25, 65, 2, 'غرفة', 2, 2, '0000-00-00', '2025-01-26', 48000.00),
(26, 66, 2, 'غرفة', 1, 2, '0000-00-00', '2025-01-19', 24000.00),
(27, 67, 2, 'غرفة', 1, 1, NULL, NULL, 12000.00),
(28, 68, 2, 'غرفة', 1, 1, '0000-00-00', '2025-01-18', 12000.00),
(29, 69, 7, 'غرفة', 2, 2, '0000-00-00', '2025-01-23', 0.00),
(30, 71, 2, 'غرفة', 1, 2, '0000-00-00', '2025-01-18', 24000.00),
(31, 72, 7, 'غرفة', 2, 2, '0000-00-00', '2025-01-20', 0.00),
(32, 73, 2, 'غرفة', 3, 1, '0000-00-00', '2025-01-31', 36000.00),
(33, 75, 11, 'غرفة', 1, 2, '0000-00-00', '2025-01-18', 50000.00),
(34, 76, 7, 'غرفة', 5, 2, '0000-00-00', '2025-01-19', 0.00),
(35, 77, 4, 'غرفة', 1, 1, '0000-00-00', '2025-01-13', 0.00),
(36, 80, 7, 'غرفة', 2, 2, '0000-00-00', '2025-01-24', 0.00),
(37, 81, 2, 'غرفة', 2, 2, '0000-00-00', '2025-01-20', 48000.00),
(38, 82, 14, 'غرفة', 1, 1, '0000-00-00', '2025-01-25', 3500.00),
(39, 87, 14, 'غرفة', 2, 2, '0000-00-00', '2025-01-25', 14000.00),
(40, 91, 15, 'غرفة', 2, 1, '0000-00-00', '2025-01-25', 76.00),
(41, 93, 13, 'غرفة', 2, 1, '0000-00-00', '2025-01-24', 400.00),
(42, 95, 2, 'غرفة', 1, 1, '0000-00-00', '2025-01-24', 12000.00);

-- --------------------------------------------------------

--
-- Table structure for table `Hotels`
--

CREATE TABLE `Hotels` (
  `HotelID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `SquareID` int(11) DEFAULT NULL,
  `RoomTypes` text,
  `RoomPrice` decimal(10,2) DEFAULT NULL,
  `SuitePrice` decimal(10,2) DEFAULT NULL,
  `MainImageURL` varchar(255) DEFAULT NULL,
  `AdditionalImageURL1` varchar(255) DEFAULT NULL,
  `AdditionalImageURL2` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Hotels`
--

INSERT INTO `Hotels` (`HotelID`, `Name`, `Address`, `SquareID`, `RoomTypes`, `RoomPrice`, `SuitePrice`, `MainImageURL`, `AdditionalImageURL1`, `AdditionalImageURL2`) VALUES
(1, 'فندق سوفتيل تعز', 'شارع جمال، حي الجمهوري', 1, 'غرف مفردة، مزدوجة، أجنحة', 15000.00, 40000.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQNM9Wybrow33bt1sL4C9y08wpqYwCtS7-UsA&s', NULL, NULL),
(2, 'فندق قصر السلطانة', 'شارع الستين، حي الروضة', 2, 'غرف قياسية، ديلوكس، أجنحة تنفيذية', 12000.00, 35000.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQNM9Wybrow33bt1sL4C9y08wpqYwCtS7-UsA&s', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQNM9Wybrow33bt1sL4C9y08wpqYwCtS7-UsA&s', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQNM9Wybrow33bt1sL4C9y08wpqYwCtS7-UsA&s'),
(3, 'فندق المخا السياحي', 'شارع الكورنيش، حي الشاطئ', 8, 'غرف مطلة على البحر، غرف عائلية', NULL, NULL, NULL, NULL, NULL),
(4, 'فندق الضباب بلازا', 'شارع تعز - عدن، حي الضباب', 5, 'غرف اقتصادية، غرف فاخرة', NULL, NULL, NULL, NULL, NULL),
(5, 'فندق تاج صبر', 'شارع صبر، حي صبر الموادم', 9, 'غرف هادئة، أجنحة جبلية', NULL, NULL, NULL, NULL, NULL),
(6, 'فندق النخيل', 'شارع جمال، حي الجمهوري', 1, 'غرف مفردة، مزدوجة', NULL, NULL, NULL, NULL, NULL),
(7, 'فندق السلام', 'شارع الستين، حي الروضة', 2, 'غرف قياسية، ديلوكس', 1200.00, NULL, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ_MsfEdn4_Wqx2gI3440PwzQ21N1zqg4NupA&s ', 'https://lh3.googleusercontent.com/p/AF1QipN-2yR_K0wf-5wPa2Mn4cUFI3GtDfc2g11ilu-C=s1244-w750-h1244', 'undefined'),
(8, 'منتجع يمن موكا', 'شارع الكورنيش، حي الشاطئ', 8, 'غرف مطلة على البحر', NULL, NULL, NULL, NULL, NULL),
(9, 'فندق قمة الضباب', 'شارع تعز - عدن، حي الضباب', 5, 'غرف اقتصادية', NULL, NULL, NULL, NULL, NULL),
(10, 'فندق جبل صبر', 'شارع صبر، حي صبر الموادم', 9, 'غرف جبلية', NULL, NULL, NULL, NULL, NULL),
(11, 'قصر', NULL, 12, 'فندق VIP', 25000.00, NULL, NULL, NULL, NULL),
(12, 'الجمله', NULL, 6, 'فندق vip', 2000.00, NULL, NULL, NULL, NULL),
(13, 'فندق المدينة', NULL, 2, 'فندق', 200.00, NULL, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSo-6k9IsZiAKs336uNZ0T3C9tVf_mzeOmOGw&s', '', ''),
(14, 'فندق العليان', NULL, 2, 'Vip', 3500.00, NULL, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS6RoYWim1YT-89jPqScrk3K-Y5XaBelOzSpw&s', NULL, NULL),
(15, 'hshh', NULL, 2, 'hg', 38.00, NULL, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQNM9Wybrow33bt1sL4C9y08wpqYwCtS7-UsA&s', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Images`
--

CREATE TABLE `Images` (
  `ImageID` int(11) NOT NULL,
  `ImageUrl` varchar(255) DEFAULT NULL,
  `EntityType` varchar(50) DEFAULT NULL,
  `EntityID` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Images`
--

INSERT INTO `Images` (`ImageID`, `ImageUrl`, `EntityType`, `EntityID`) VALUES
(1, 'https://fakeimg.pl/600x400?text=Hotel+Image+1', 'Hotels', 1),
(2, 'https://fakeimg.pl/600x400?text=Hotel+Image+2', 'Hotels', 2),
(3, 'https://fakeimg.pl/600x400?text=Hotel+Image+3', 'Hotels', 3),
(4, 'https://fakeimg.pl/600x400?text=Hotel+Image+4', 'Hotels', 4),
(5, 'https://fakeimg.pl/600x400?text=Hotel+Image+5', 'Hotels', 5),
(6, 'https://fakeimg.pl/600x400?text=Hotel+Image+6', 'Hotels', 6),
(7, 'https://fakeimg.pl/600x400?text=Hotel+Image+7', 'Hotels', 7),
(8, 'https://fakeimg.pl/600x400?text=Hotel+Image+8', 'Hotels', 8),
(9, 'https://fakeimg.pl/600x400?text=Hotel+Image+9', 'Hotels', 9),
(10, 'https://fakeimg.pl/600x400?text=Hotel+Image+10', 'Hotels', 10),
(11, 'https://fakeimg.pl/600x400?text=Restaurant+Image+1', 'Restaurants', 1),
(12, 'https://fakeimg.pl/600x400?text=Restaurant+Image+2', 'Restaurants', 2),
(13, 'https://fakeimg.pl/600x400?text=Restaurant+Image+3', 'Restaurants', 3),
(14, 'https://fakeimg.pl/600x400?text=Restaurant+Image+4', 'Restaurants', 4),
(15, 'https://fakeimg.pl/600x400?text=Restaurant+Image+5', 'Restaurants', 5),
(16, 'https://fakeimg.pl/600x400?text=Restaurant+Image+6', 'Restaurants', 6),
(17, 'https://fakeimg.pl/600x400?text=Restaurant+Image+7', 'Restaurants', 7),
(18, 'https://fakeimg.pl/600x400?text=Restaurant+Image+8', 'Restaurants', 8),
(19, 'https://fakeimg.pl/600x400?text=Restaurant+Image+9', 'Restaurants', 9),
(20, 'https://fakeimg.pl/600x400?text=Restaurant+Image+10', 'Restaurants', 10),
(21, 'https://fakeimg.pl/600x400?text=Car+Image+1', 'Cars', 1),
(22, 'https://fakeimg.pl/600x400?text=Car+Image+2', 'Cars', 2),
(23, 'https://fakeimg.pl/600x400?text=Car+Image+3', 'Cars', 3),
(24, 'https://fakeimg.pl/600x400?text=Car+Image+4', 'Cars', 4),
(25, 'https://fakeimg.pl/600x400?text=Car+Image+5', 'Cars', 5),
(26, 'https://fakeimg.pl/600x400?text=Car+Image+6', 'Cars', 6),
(27, 'https://fakeimg.pl/600x400?text=Car+Image+7', 'Cars', 7),
(28, 'https://fakeimg.pl/600x400?text=Car+Image+8', 'Cars', 8),
(29, 'https://fakeimg.pl/600x400?text=Car+Image+9', 'Cars', 9),
(30, 'https://fakeimg.pl/600x400?text=Car+Image+10', 'Cars', 10),
(31, 'https://fakeimg.pl/600x400?text=Entertainment+Image+1', 'EntertainmentPlaces', 1),
(32, 'https://fakeimg.pl/600x400?text=Entertainment+Image+2', 'EntertainmentPlaces', 2),
(33, 'https://fakeimg.pl/600x400?text=Entertainment+Image+3', 'EntertainmentPlaces', 3),
(34, 'https://fakeimg.pl/600x400?text=Entertainment+Image+4', 'EntertainmentPlaces', 4),
(35, 'https://fakeimg.pl/600x400?text=Entertainment+Image+5', 'EntertainmentPlaces', 5),
(36, 'https://fakeimg.pl/600x400?text=Entertainment+Image+6', 'EntertainmentPlaces', 6),
(37, 'https://fakeimg.pl/600x400?text=Entertainment+Image+7', 'EntertainmentPlaces', 7),
(38, 'https://fakeimg.pl/600x400?text=Entertainment+Image+8', 'EntertainmentPlaces', 8),
(39, 'https://fakeimg.pl/600x400?text=Entertainment+Image+9', 'EntertainmentPlaces', 9),
(40, 'https://fakeimg.pl/600x400?text=Entertainment+Image+10', 'EntertainmentPlaces', 10),
(41, 'https://fakeimg.pl/600x400?text=Square+Image+1', 'ResidentialSquares', 1),
(42, 'https://fakeimg.pl/600x400?text=Square+Image+2', 'ResidentialSquares', 2),
(43, 'https://fakeimg.pl/600x400?text=Square+Image+3', 'ResidentialSquares', 3),
(44, 'https://fakeimg.pl/600x400?text=Square+Image+4', 'ResidentialSquares', 4),
(45, 'https://fakeimg.pl/600x400?text=Square+Image+5', 'ResidentialSquares', 5),
(46, 'https://fakeimg.pl/600x400?text=Square+Image+6', 'ResidentialSquares', 6),
(47, 'https://fakeimg.pl/600x400?text=Square+Image+7', 'ResidentialSquares', 7),
(48, 'https://fakeimg.pl/600x400?text=Square+Image+8', 'ResidentialSquares', 8),
(49, 'https://fakeimg.pl/600x400?text=Square+Image+9', 'ResidentialSquares', 9),
(50, 'https://fakeimg.pl/600x400?text=Square+Image+10', 'ResidentialSquares', 10),
(51, 'https://fakeimg.pl/600x400?text=District+Image+1', 'Districts', 1),
(52, 'https://images.unsplash.com/photo-1617854818583-09e7f077a156?w=1000&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8dXJsfGVufDB8fDB8fHww', 'Districts', 2),
(53, 'https://images.unsplash.com/photo-1617854818583-09e7f077a156?w=1000&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8dXJsfGVufDB8fDB8fHww', 'Districts', 3),
(54, 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b6/Jabal_saber_%2815963903633%29_%28cropped%29.jpg/1280px-Jabal_saber_%2815963903633%29_%28cropped%29.jpg', 'Districts', 4),
(55, 'https://upload.wikimedia.org/wikipedia/commons/c/cd/Taiz_-_sabir_%2816296315829%29.jpg', 'Districts', 5),
(56, 'https://fakeimg.pl/600x400?text=Attraction+Image+1', 'TouristAttractions', 1),
(57, 'https://fakeimg.pl/600x400?text=Attraction+Image+2', 'TouristAttractions', 2),
(58, 'https://fakeimg.pl/600x400?text=Attraction+Image+3', 'TouristAttractions', 3),
(59, 'https://fakeimg.pl/600x400?text=Attraction+Image+4', 'TouristAttractions', 4),
(60, 'https://fakeimg.pl/600x400?text=Attraction+Image+5', 'TouristAttractions', 5),
(61, 'https://fakeimg.pl/600x400?text=Attraction+Image+6', 'TouristAttractions', 6),
(62, 'https://fakeimg.pl/600x400?text=Attraction+Image+7', 'TouristAttractions', 7),
(63, 'https://fakeimg.pl/600x400?text=Attraction+Image+8', 'TouristAttractions', 8),
(64, 'https://fakeimg.pl/600x400?text=Attraction+Image+9', 'TouristAttractions', 9),
(65, 'https://fakeimg.pl/600x400?text=Attraction+Image+10', 'TouristAttractions', 10);

-- --------------------------------------------------------

--
-- Table structure for table `ResidentialSquares`
--

CREATE TABLE `ResidentialSquares` (
  `SquareID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `DistrictID` int(11) DEFAULT NULL,
  `DistanceFromDistrictCenter` decimal(10,2) DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ResidentialSquares`
--

INSERT INTO `ResidentialSquares` (`SquareID`, `Name`, `DistrictID`, `DistanceFromDistrictCenter`, `ImageURL`) VALUES
(1, 'حي الجمهوري', 5, 1.50, 'https://lh3.googleusercontent.com/p/AF1QipO1-AJjiDGjF7jfivoEj6kuzw1FQ-ERfvCGEPU9=s2536-w1322-h2536'),
(2, 'حي الروضة', 5, 2.80, 'https://images.unsplash.com/photo-1617854818583-09e7f077a156?w=1000&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8dXJsfGVufDB8fDB8fHww'),
(3, 'حي وادي القاضي', 3, 3.10, NULL),
(4, 'حي بير باشا', 3, 4.50, NULL),
(5, 'حي الضباب', 2, 2.20, NULL),
(6, 'حي الحوبان', 2, 1.80, 'https://images.unsplash.com/photo-1617854818583-09e7f077a156?w=1000&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8dXJsfGVufDB8fDB8fHww'),
(7, 'حي المطار', 1, 3.70, NULL),
(8, 'حي الشاطئ', 1, 0.50, NULL),
(9, 'حي صبر الموادم', 4, 5.00, NULL),
(10, 'حي الحصب', 4, 3.30, NULL),
(12, 'الجملة', 7, 20.00, NULL),
(13, 'حي الجحملية', 2, 120.00, NULL),
(14, 'عع', 5, 33.00, 'https://lh3.googleusercontent.com/p/AF1QipN81FIJHTjWtwJl-ST-Z5bA2OyQ1KgaQAZjLWtm=s2536-w1322-h2536'),
(15, '55', 5, 6.00, 'https://lh3.googleusercontent.com/p/AF1QipMqX_HuS3OB4YAdII95Yq91CpCRFn16t_mZf5tf=s2366-w1322-h2366'),
(16, 'المحاضرة ', 5, 1.00, 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f8/Taiz_%2815182373707%29_%28retouched%29.jpg/1280px-Taiz_%2815182373707%29_%28retouched%29.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `RestaurantBookingDetails`
--

CREATE TABLE `RestaurantBookingDetails` (
  `RestaurantBookingID` int(11) NOT NULL,
  `BookingID` int(11) DEFAULT NULL,
  `RestaurantID` int(11) DEFAULT NULL,
  `ReservationDate` datetime DEFAULT NULL,
  `NumberOfGuests` int(11) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `RestaurantBookingDetails`
--

INSERT INTO `RestaurantBookingDetails` (`RestaurantBookingID`, `BookingID`, `RestaurantID`, `ReservationDate`, `NumberOfGuests`, `Price`) VALUES
(1, 1, 1, '2024-01-16 19:00:00', 2, 6000.00),
(2, 2, 2, '2024-02-21 20:30:00', 4, 12000.00),
(3, 3, 3, '2024-03-12 21:00:00', 6, 30000.00),
(4, 4, 4, '2024-04-05 18:00:00', 2, 7000.00),
(5, 5, 5, '2024-05-02 19:30:00', 3, 15000.00),
(6, 6, 6, '2024-01-21 20:00:00', 3, 12000.00),
(7, 7, 7, '2024-02-26 21:30:00', 2, 10000.00),
(8, 8, 8, '2024-03-17 19:30:00', 5, 35000.00),
(9, 9, 9, '2024-04-11 18:30:00', 4, 18000.00),
(10, 10, 10, '2024-05-06 20:00:00', 1, 4000.00),
(11, 13, 1, '2025-01-13 06:05:00', 2, NULL),
(12, 18, 1, '2025-01-22 00:00:00', 0, 0.00),
(13, 23, 1, '2025-01-23 00:00:00', 2, 0.00),
(14, 39, 1, '2025-01-14 00:00:00', 2, 0.00),
(15, 41, 6, '2025-01-15 00:00:00', 2, 0.00),
(16, 44, 1, '2025-01-23 00:00:00', 2, 0.00),
(17, 46, 1, '2025-01-13 00:00:00', 1, 0.00),
(18, 48, 1, '0000-00-00 00:00:00', 0, 0.00),
(19, 53, 1, '2025-01-17 00:00:00', 1, 0.00),
(20, 54, 7, '2025-01-16 00:00:00', 2, 0.00),
(21, 55, 2, '2025-01-24 00:00:00', 1, 0.00),
(22, 61, 7, '2025-01-16 00:00:00', 2, 500.00),
(23, 64, 2, '2025-01-17 00:00:00', 2, 0.00),
(24, 70, 7, '2025-01-16 00:00:00', 2, 500.00),
(25, 78, 2, '2025-01-24 00:00:00', 2, NULL),
(26, 79, 2, '2025-01-24 00:00:00', 2, NULL),
(27, 83, 2, '2025-01-17 00:00:00', 12, 0.00),
(28, 84, 15, '2025-01-17 00:00:00', 2, 305.00),
(29, 85, 2, '2025-01-29 00:00:00', 2, 0.00),
(30, 86, 7, '2025-01-27 00:00:00', 9, 500.00),
(31, 89, 15, '2025-01-23 00:00:00', 1, 305.00);

-- --------------------------------------------------------

--
-- Table structure for table `Restaurants`
--

CREATE TABLE `Restaurants` (
  `RestaurantID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `SquareID` int(11) DEFAULT NULL,
  `Menu` text,
  `Prices` text,
  `Ratings` decimal(3,2) DEFAULT NULL,
  `BookingPrice` decimal(10,2) DEFAULT '0.00',
  `FamilyFriendly` tinyint(1) DEFAULT '0',
  `MainImageURL` varchar(255) DEFAULT NULL,
  `AdditionalImageURL1` varchar(255) DEFAULT NULL,
  `AdditionalImageURL2` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Restaurants`
--

INSERT INTO `Restaurants` (`RestaurantID`, `Name`, `Address`, `SquareID`, `Menu`, `Prices`, `Ratings`, `BookingPrice`, `FamilyFriendly`, `MainImageURL`, `AdditionalImageURL1`, `AdditionalImageURL2`) VALUES
(1, 'مطعم حضرموت', 'شارع جمال، حي الجمهوري', 1, 'مأكولات حضرمية، أطباق يمنية', 'متوسط: 3000 - 6000 ريال', 4.50, 0.00, 0, NULL, NULL, NULL),
(2, 'مطعم الطازج', 'شارع الستين، حي الروضة', 2, 'وجبات سريعة، دجاج مشوي', '250', 4.20, 500.00, 0, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRgrbkddHftcLWKLl7zpsojez6oubJFStbxng&s', 'undefined', 'undefined'),
(3, 'مطعم الميناء', 'شارع الكورنيش، حي الشاطئ', 8, 'مأكولات بحرية، أطباق محلية', 'مرتفع: 5000 - 10000 ريال', 4.80, 0.00, 0, NULL, NULL, NULL),
(4, 'مطعم الضباب', 'شارع تعز - عدن، حي الضباب', 5, 'مأكولات شعبية، لحوم مشوية', 'متوسط: 3500 - 7000 ريال', 4.00, 0.00, 0, NULL, NULL, NULL),
(5, 'مطعم قمة صبر', 'شارع صبر، حي صبر الموادم', 9, 'مأكولات تقليدية، أطباق نباتية', 'متوسط: 2500 - 5000 ريال', 4.30, 0.00, 0, NULL, NULL, NULL),
(6, 'مطعم البلد', 'شارع جمال، حي الجمهوري', 1, 'مأكولات يمنية', 'متوسط: 3000 - 5500 ريال', 4.10, 0.00, 0, NULL, NULL, NULL),
(7, 'مطعم الجوري', 'شارع الستين، حي الروضة', 2, 'مأكولات شرقية', '20', 4.60, 500.00, 0, 'https://lh3.googleusercontent.com/p/AF1QipN-2yR_K0wf-5wPa2Mn4cUFI3GtDfc2g11ilu-C=s1244-w750-h1244', NULL, NULL),
(8, 'مقهى ومطعم الصياد', 'شارع الكورنيش، حي الشاطئ', 8, 'مأكولات بحرية ووجبات خفيفة', 'مرتفع: 4000 - 9000 ريال', 4.70, 0.00, 0, NULL, NULL, NULL),
(9, 'مطعم السهل', 'شارع تعز - عدن، حي الضباب', 5, 'مأكولات شعبية', 'متوسط: 2000 - 4500 ريال', 4.00, 0.00, 0, NULL, NULL, NULL),
(10, 'مطعم الروابي', 'شارع صبر، حي صبر الموادم', 9, 'مأكولات تقليدية', 'متوسط: 2200 - 5000 ريال', 4.40, 0.00, 0, NULL, NULL, NULL),
(11, 'مطعم حمود ', NULL, 12, 'مطعم ', '300', NULL, 0.00, 0, NULL, NULL, NULL),
(12, 'مطعم بيتكم ', NULL, 6, 'cmm', '3000', NULL, 0.00, 0, NULL, NULL, NULL),
(15, 'مطعم الرومانسية ', NULL, 2, 'مشروع ', NULL, NULL, 305.00, 0, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQNM9Wybrow33bt1sL4C9y08wpqYwCtS7-UsA&s', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Reviews`
--

CREATE TABLE `Reviews` (
  `ReviewID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `HotelID` int(11) DEFAULT NULL,
  `RestaurantID` int(11) DEFAULT NULL,
  `ActivityID` int(11) DEFAULT NULL,
  `Rating` decimal(3,2) DEFAULT NULL,
  `Comment` text,
  `ReviewDate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Reviews`
--

INSERT INTO `Reviews` (`ReviewID`, `UserID`, `HotelID`, `RestaurantID`, `ActivityID`, `Rating`, `Comment`, `ReviewDate`) VALUES
(1, 1, 1, NULL, NULL, 4.50, 'فندق ممتاز وخدمة رائعة.', '2024-01-20'),
(2, 2, NULL, 2, NULL, 4.20, 'مطعم جيد ووجبات لذيذة.', '2024-02-25'),
(3, 3, NULL, NULL, 3, 4.80, 'مكان ترفيهي رائع وممتع.', '2024-03-15'),
(4, 4, 4, NULL, NULL, 4.00, 'فندق جيد ولكن يحتاج إلى بعض التحسينات.', '2024-04-10'),
(5, 5, NULL, 5, NULL, 4.30, 'مطعم ممتاز وأنصح به.', '2024-05-05'),
(6, 6, 1, NULL, NULL, 4.70, 'إقامة مريحة وممتازة.', '2024-01-25'),
(7, 7, NULL, 2, NULL, 4.40, 'أعجبني تنوع القائمة.', '2024-02-28'),
(8, 8, NULL, NULL, 3, 4.90, 'قضيت وقتا ممتعا.', '2024-03-19'),
(9, 9, 4, NULL, NULL, 4.10, 'جيد لكنه يحتاج صيانة.', '2024-04-12'),
(10, 10, NULL, 5, NULL, 4.50, 'أحببت الأجواء والطعام.', '2024-05-07');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `TouristAttractions`
--

CREATE TABLE `TouristAttractions` (
  `AttractionID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Description` text,
  `DistrictID` int(11) DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `TouristAttractions`
--

INSERT INTO `TouristAttractions` (`AttractionID`, `Name`, `Description`, `DistrictID`, `ImageURL`) VALUES
(1, 'قلعة القاهرة', 'قلعة تاريخية تعود إلى العصور الوسطى، تطل على مدينة تعز.', 5, 'https://lh3.googleusercontent.com/p/AF1QipO1-AJjiDGjF7jfivoEj6kuzw1FQ-ERfvCGEPU9=s2536-w1322-h2536'),
(2, 'جبل صبر', 'أعلى قمة جبلية في تعز، يوفر إطلالات بانورامية رائعة.', 4, NULL),
(3, 'مدينة المخا القديمة', 'مدينة ساحلية تاريخية ذات مباني قديمة وميناء هام.', 1, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSerZgCT-dqBA2E7sQeGeTkZRZs6ditbDCyeQ&usqp=CAU'),
(4, 'سوق الجند', 'سوق شعبي قديم يعرض المنتجات الحرفية والتقليدية.', 3, NULL),
(5, 'وادي الضباب', 'وادي زراعي ذو طبيعة خلابة وأشجار كثيفة.', 2, 'https://lh3.googleusercontent.com/p/AF1QipN81FIJHTjWtwJl-ST-Z5bA2OyQ1KgaQAZjLWtm=s2536-w1322-h2536'),
(6, 'مسجد الأشرفية', 'مسجد تاريخي يعتبر تحفة معمارية.', 5, 'https://lh3.googleusercontent.com/p/AF1QipO1co4HloiylnsdQtIWjB-9HPjP71pgQwUshtfY=s2536-w1322-h2536'),
(7, 'حصن العروس', 'حصن قديم يقع على قمة جبل، يطل على منطقة واسعة.', 4, NULL),
(8, 'شاطئ المخا', 'شاطئ رملي جميل يوفر أنشطة ترفيهية متنوعة.', 1, 'https://lh3.googleusercontent.com/p/AF1QipMqX_HuS3OB4YAdII95Yq91CpCRFn16t_mZf5tf=s2366-w1322-h2366'),
(9, 'قرية ذي السفال', 'قرية قديمة ذات مباني طينية تقليدية.', 3, NULL),
(10, 'منطقة وادي الحسين', 'منطقة ذات طبيعة خلابة وتشكيلات صخرية غريبة.', 2, 'https://yemenfuture.net/upimgs/images/YF2024-01-19-1503.jpg'),
(11, 'azz', '111', 4, NULL),
(12, 'ثثثث', 'غغغغ', 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `role_id` int(11) DEFAULT '2',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `first_name`, `last_name`, `phone_number`, `role_id`, `created_at`) VALUES
(1, 'Azzam', '$2y$10$Z7N5pPOQFrZxUaTs/yZhO.NRA9TwFv8STWI439pCQH5aj7mUDFjtW', 'd@gmail.com', 'azzam', 'amm', '76666666', 2, '2025-01-14 22:39:26'),
(2, 'aalliii', '$2y$10$0j63XlyleewoJUQF4LGds.cds8RV0.Igri3GsQKylDw5coyzJkvSq', 'aa@aa.aa', 'alll', 'all', '33333366', 2, '2025-01-14 23:20:27'),
(3, 'aa', '$2y$10$Pa/Vm6qwRzrwHw/7rVPx6.jUXEi6tqnqgJ20A0vNn4owI166Me.kK', 'aa@gmail.com', 'aa', 'aa', '7777', 1, '2025-01-16 02:54:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ActivityBookingDetails`
--
ALTER TABLE `ActivityBookingDetails`
  ADD PRIMARY KEY (`ActivityBookingID`),
  ADD KEY `BookingID` (`BookingID`),
  ADD KEY `ActivityID` (`ActivityID`);

--
-- Indexes for table `Bookings`
--
ALTER TABLE `Bookings`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `CarBookingDetails`
--
ALTER TABLE `CarBookingDetails`
  ADD PRIMARY KEY (`CarBookingID`),
  ADD KEY `BookingID` (`BookingID`),
  ADD KEY `CarID` (`CarID`);

--
-- Indexes for table `Cars`
--
ALTER TABLE `Cars`
  ADD PRIMARY KEY (`CarID`),
  ADD KEY `SquareID` (`SquareID`);

--
-- Indexes for table `Districts`
--
ALTER TABLE `Districts`
  ADD PRIMARY KEY (`DistrictID`);

--
-- Indexes for table `EntertainmentPlaces`
--
ALTER TABLE `EntertainmentPlaces`
  ADD PRIMARY KEY (`PlaceID`),
  ADD KEY `SquareID` (`SquareID`);

--
-- Indexes for table `HotelBookingDetails`
--
ALTER TABLE `HotelBookingDetails`
  ADD PRIMARY KEY (`HotelBookingID`),
  ADD KEY `BookingID` (`BookingID`),
  ADD KEY `HotelID` (`HotelID`);

--
-- Indexes for table `Hotels`
--
ALTER TABLE `Hotels`
  ADD PRIMARY KEY (`HotelID`),
  ADD KEY `SquareID` (`SquareID`);

--
-- Indexes for table `Images`
--
ALTER TABLE `Images`
  ADD PRIMARY KEY (`ImageID`),
  ADD KEY `EntityID` (`EntityID`);

--
-- Indexes for table `ResidentialSquares`
--
ALTER TABLE `ResidentialSquares`
  ADD PRIMARY KEY (`SquareID`),
  ADD KEY `DistrictID` (`DistrictID`);

--
-- Indexes for table `RestaurantBookingDetails`
--
ALTER TABLE `RestaurantBookingDetails`
  ADD PRIMARY KEY (`RestaurantBookingID`),
  ADD KEY `BookingID` (`BookingID`),
  ADD KEY `RestaurantID` (`RestaurantID`);

--
-- Indexes for table `Restaurants`
--
ALTER TABLE `Restaurants`
  ADD PRIMARY KEY (`RestaurantID`),
  ADD KEY `SquareID` (`SquareID`);

--
-- Indexes for table `Reviews`
--
ALTER TABLE `Reviews`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `HotelID` (`HotelID`),
  ADD KEY `RestaurantID` (`RestaurantID`),
  ADD KEY `ActivityID` (`ActivityID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `TouristAttractions`
--
ALTER TABLE `TouristAttractions`
  ADD PRIMARY KEY (`AttractionID`),
  ADD KEY `DistrictID` (`DistrictID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ActivityBookingDetails`
--
ALTER TABLE `ActivityBookingDetails`
  MODIFY `ActivityBookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `Bookings`
--
ALTER TABLE `Bookings`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `CarBookingDetails`
--
ALTER TABLE `CarBookingDetails`
  MODIFY `CarBookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `Cars`
--
ALTER TABLE `Cars`
  MODIFY `CarID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Districts`
--
ALTER TABLE `Districts`
  MODIFY `DistrictID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `EntertainmentPlaces`
--
ALTER TABLE `EntertainmentPlaces`
  MODIFY `PlaceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `HotelBookingDetails`
--
ALTER TABLE `HotelBookingDetails`
  MODIFY `HotelBookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `Hotels`
--
ALTER TABLE `Hotels`
  MODIFY `HotelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `Images`
--
ALTER TABLE `Images`
  MODIFY `ImageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `ResidentialSquares`
--
ALTER TABLE `ResidentialSquares`
  MODIFY `SquareID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `RestaurantBookingDetails`
--
ALTER TABLE `RestaurantBookingDetails`
  MODIFY `RestaurantBookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `Restaurants`
--
ALTER TABLE `Restaurants`
  MODIFY `RestaurantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `Reviews`
--
ALTER TABLE `Reviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `TouristAttractions`
--
ALTER TABLE `TouristAttractions`
  MODIFY `AttractionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
