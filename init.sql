-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2020 at 03:03 PM
-- Server version: 10.4.11-MariaDB
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
-- Database: `webproject`
--
DROP DATABASE IF EXISTS `webproject`;
CREATE DATABASE IF NOT EXISTS `webproject` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `webproject`;

-- --------------------------------------------------------

--
-- Table structure for table `contactlist`
--

CREATE TABLE `contactlist` (
  `userId` int(11) NOT NULL,
  `contactId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contactlist`
--

INSERT INTO `contactlist` (`userId`, `contactId`) VALUES
(1, 2),
(1, 3),
(2, 3),
(1, 6),
(6, 1),
(6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_title` varchar(64) NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `groupId` int(11) NOT NULL,
  `leaderId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`groupId`, `leaderId`) VALUES
(2, 5),
(1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE `inbox` (
  `inboxId` int(11) NOT NULL,
  `ownerId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inbox`
--

INSERT INTO `inbox` (`inboxId`, `ownerId`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7);

-- --------------------------------------------------------

--
-- Table structure for table `inboxmessages`
--

CREATE TABLE `inboxmessages` (
  `inboxId` int(11) NOT NULL,
  `msgId` int(11) NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inboxmessages`
--

-- --------------------------------------------------------

--
-- Table structure for table `invites`
--

CREATE TABLE `invites` (
  `leaderId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `msgId` int(11) NOT NULL,
  `msgType` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `content` varchar(2048) NOT NULL,
  `senderId` int(11) DEFAULT NULL,
  `time_sent` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password_hash` varchar(256) NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `faculty_number` int(11) NOT NULL,
  `number_theme` int(11) DEFAULT NULL,
  `recension_number` int(11) DEFAULT NULL,
  `member_of` int(11) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `ban_until` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `password_hash`, `first_name`, `last_name`, `faculty_number`, `number_theme`, `recension_number`, `member_of`, `is_admin`, `ban_until`) VALUES
(1, 'dragPeev', '$2y$10$M6nTwlV3MDy0h5uWpIwlS.0.boJLvGKUwJhy7zrmkhIH8A9di0JdS', 'Драган', 'Пеевски', 12, 3, NULL, 2, 0, NULL),
(2, 'lubtl', '$2y$10$M6nTwlV3MDy0h5uWpIwlS.0.boJLvGKUwJhy7zrmkhIH8A9di0JdS', 'Любомир', 'Тлаченски', 112, 1, NULL, 1, 0, NULL),
(3, 'ivIv', '$2y$10$M6nTwlV3MDy0h5uWpIwlS.0.boJLvGKUwJhy7zrmkhIH8A9di0JdS', 'Иван', 'Иванов', 512, 4, NULL, 2, 0, NULL),
(4, 'doiZl', '$2y$10$M6nTwlV3MDy0h5uWpIwlS.0.boJLvGKUwJhy7zrmkhIH8A9di0JdS', 'Дойчин', 'Златаров', 0, NULL, NULL, NULL, 1, NULL),
(5, 'minaZl', '$2y$10$M6nTwlV3MDy0h5uWpIwlS.0.boJLvGKUwJhy7zrmkhIH8A9di0JdS', 'Минаил', 'Златев', 76, 6, NULL, 2, 0, NULL),
(6, 'hoseto', '$2y$10$M6nTwlV3MDy0h5uWpIwlS.0.boJLvGKUwJhy7zrmkhIH8A9di0JdS', 'Хосе', 'Еспаниоло', 6585, 2, NULL, 1, 0, NULL),
(7, 'machoto', '$2y$10$M6nTwlV3MDy0h5uWpIwlS.0.boJLvGKUwJhy7zrmkhIH8A9di0JdS', 'Мачо', 'Пикчо', 8362, 5, NULL, NULL, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contactlist`
--
ALTER TABLE `contactlist`
  ADD KEY `userId` (`userId`),
  ADD KEY `contactId` (`contactId`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`groupId`),
  ADD KEY `leaderId` (`leaderId`);

--
-- Indexes for table `inbox`
--
ALTER TABLE `inbox`
  ADD PRIMARY KEY (`inboxId`),
  ADD KEY `ownerId` (`ownerId`);

--
-- Indexes for table `inboxmessages`
--
ALTER TABLE `inboxmessages`
  ADD KEY `inboxId` (`inboxId`),
  ADD KEY `msgId` (`msgId`);

--
-- Indexes for table `invites`
--
ALTER TABLE `invites`
  ADD KEY `leaderId` (`leaderId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`msgId`),
  ADD KEY `senderId` (`senderId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `faculty_number` (`faculty_number`),
  ADD UNIQUE KEY `number_theme` (`number_theme`),
  ADD KEY `member_of` (`member_of`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `groupId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inbox`
--
ALTER TABLE `inbox`
  MODIFY `inboxId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `msgId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contactlist`
--
ALTER TABLE `contactlist`
  ADD CONSTRAINT `contactlist_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `contactlist_ibfk_2` FOREIGN KEY (`contactId`) REFERENCES `users` (`userID`);

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`leaderId`) REFERENCES `users` (`userID`);

--
-- Constraints for table `inbox`
--
ALTER TABLE `inbox`
  ADD CONSTRAINT `inbox_ibfk_1` FOREIGN KEY (`ownerId`) REFERENCES `users` (`userID`);

--
-- Constraints for table `inboxmessages`
--
ALTER TABLE `inboxmessages`
  ADD CONSTRAINT `inboxmessages_ibfk_1` FOREIGN KEY (`inboxId`) REFERENCES `inbox` (`inboxId`),
  ADD CONSTRAINT `inboxmessages_ibfk_2` FOREIGN KEY (`msgId`) REFERENCES `message` (`msgId`);

--
-- Constraints for table `invites`
--
ALTER TABLE `invites`
  ADD CONSTRAINT `invites_ibfk_1` FOREIGN KEY (`leaderId`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `invites_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`userID`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`senderId`) REFERENCES `users` (`userID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`member_of`) REFERENCES `groups` (`groupId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
