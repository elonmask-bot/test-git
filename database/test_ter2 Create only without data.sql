SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `ActivityBookingDetails` (
  `ActivityBookingID` int(11) NOT NULL,
  `BookingID` int(11) DEFAULT NULL,
  `ActivityID` int(11) DEFAULT NULL,
  `ActivityDate` date DEFAULT NULL,
  `NumberOfTickets` int(11) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `Bookings` (
  `BookingID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TotalCost` decimal(10,2) DEFAULT NULL,
  `BookingDate` date DEFAULT NULL,
  `PaymentStatus` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `CarBookingDetails` (
  `CarBookingID` int(11) NOT NULL,
  `BookingID` int(11) DEFAULT NULL,
  `CarID` int(11) DEFAULT NULL,
  `CarType` varchar(255) DEFAULT NULL,
  `PickupDate` date DEFAULT NULL,
  `ReturnDate` date DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE `Districts` (
  `DistrictID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `HistoricalBackground` text,
  `DistanceFromCenter` decimal(10,2) DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE `Images` (
  `ImageID` int(11) NOT NULL,
  `ImageUrl` varchar(255) DEFAULT NULL,
  `EntityType` varchar(50) DEFAULT NULL,
  `EntityID` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `ResidentialSquares` (
  `SquareID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `DistrictID` int(11) DEFAULT NULL,
  `DistanceFromDistrictCenter` decimal(10,2) DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `RestaurantBookingDetails` (
  `RestaurantBookingID` int(11) NOT NULL,
  `BookingID` int(11) DEFAULT NULL,
  `RestaurantID` int(11) DEFAULT NULL,
  `ReservationDate` datetime DEFAULT NULL,
  `NumberOfGuests` int(11) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `TouristAttractions` (
  `AttractionID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Description` text,
  `DistrictID` int(11) DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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


ALTER TABLE `ActivityBookingDetails`
  ADD PRIMARY KEY (`ActivityBookingID`),
  ADD KEY `BookingID` (`BookingID`),
  ADD KEY `ActivityID` (`ActivityID`);

ALTER TABLE `Bookings`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `UserID` (`UserID`);

ALTER TABLE `CarBookingDetails`
  ADD PRIMARY KEY (`CarBookingID`),
  ADD KEY `BookingID` (`BookingID`),
  ADD KEY `CarID` (`CarID`);

ALTER TABLE `Cars`
  ADD PRIMARY KEY (`CarID`),
  ADD KEY `SquareID` (`SquareID`);

ALTER TABLE `Districts`
  ADD PRIMARY KEY (`DistrictID`);

ALTER TABLE `EntertainmentPlaces`
  ADD PRIMARY KEY (`PlaceID`),
  ADD KEY `SquareID` (`SquareID`);

ALTER TABLE `HotelBookingDetails`
  ADD PRIMARY KEY (`HotelBookingID`),
  ADD KEY `BookingID` (`BookingID`),
  ADD KEY `HotelID` (`HotelID`);

ALTER TABLE `Hotels`
  ADD PRIMARY KEY (`HotelID`),
  ADD KEY `SquareID` (`SquareID`);

ALTER TABLE `Images`
  ADD PRIMARY KEY (`ImageID`),
  ADD KEY `EntityID` (`EntityID`);

ALTER TABLE `ResidentialSquares`
  ADD PRIMARY KEY (`SquareID`),
  ADD KEY `DistrictID` (`DistrictID`);

ALTER TABLE `RestaurantBookingDetails`
  ADD PRIMARY KEY (`RestaurantBookingID`),
  ADD KEY `BookingID` (`BookingID`),
  ADD KEY `RestaurantID` (`RestaurantID`);

ALTER TABLE `Restaurants`
  ADD PRIMARY KEY (`RestaurantID`),
  ADD KEY `SquareID` (`SquareID`);

ALTER TABLE `Reviews`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `HotelID` (`HotelID`),
  ADD KEY `RestaurantID` (`RestaurantID`),
  ADD KEY `ActivityID` (`ActivityID`);

ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

ALTER TABLE `TouristAttractions`
  ADD PRIMARY KEY (`AttractionID`),
  ADD KEY `DistrictID` (`DistrictID`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);


ALTER TABLE `ActivityBookingDetails`
  MODIFY `ActivityBookingID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Bookings`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `CarBookingDetails`
  MODIFY `CarBookingID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Cars`
  MODIFY `CarID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Districts`
  MODIFY `DistrictID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `EntertainmentPlaces`
  MODIFY `PlaceID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `HotelBookingDetails`
  MODIFY `HotelBookingID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Hotels`
  MODIFY `HotelID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Images`
  MODIFY `ImageID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ResidentialSquares`
  MODIFY `SquareID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `RestaurantBookingDetails`
  MODIFY `RestaurantBookingID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Restaurants`
  MODIFY `RestaurantID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Reviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `TouristAttractions`
  MODIFY `AttractionID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
