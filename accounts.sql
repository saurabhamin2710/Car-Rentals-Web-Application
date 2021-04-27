-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2021 at 02:00 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accounts`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `adminDisplayTransaction` (IN `variable` INT(11))  BEGIN
IF variable = 0 THEN
	SELECT * from transaction;
ELSE
	SELECT * from transaction WHERE DATEDIFF(CURRENT_TIMESTAMP , 			timestampTransaction) <= variable;
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteOffers` (IN `tag` VARCHAR(100))  DELETE FROM offers WHERE offername = tag$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `displayallUserTransactions` (IN `variable` INT(11))  BEGIN
SELECT * from transaction where userid = variable;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `displayAvailableCars` (IN `ch` VARCHAR(1))  BEGIN
SELECT * from cars where availability = ch;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `displayTransactionsAccToDay` (IN `useridd` INT(11))  BEGIN
SELECT * from transaction where userid = useridd and DATEDIFF(CURRENT_TIMESTAMP , timestampTransaction) <= 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `displayTransactionsAccToMonth` (IN `useridd` INT(11))  BEGIN
SELECT * from transaction where userid = useridd and DATEDIFF(CURRENT_TIMESTAMP , timestampTransaction) <= 30;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `displayTransactionsAccToWeek` (IN `useridd` INT(11))  BEGIN
SELECT * from transaction where userid = useridd and DATEDIFF(CURRENT_TIMESTAMP , timestampTransaction) <= 7;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectCar` (IN `num` INT(11))  BEGIN
SELECT * from cars where carid = num;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `checkuser` (`user_name` VARCHAR(100), `email_id` VARCHAR(100)) RETURNS INT(11) BEGIN
DECLARE ans INT;
SELECT Count(*) INTO ans from users where username = user_name or email = email_id;
RETURN ans;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `getCaridFromT` (`id` INT(11), `ch` VARCHAR(1)) RETURNS INT(11) BEGIN
DECLARE ANSWER INT;
SELECT carid INTO ANSWER from alltrips where userid = id and completed = ch;
RETURN ANSWER;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `getDistFromT` (`id` INT(11), `ch` VARCHAR(1)) RETURNS INT(11) BEGIN
DECLARE ANSWER INT;
SELECT tripdist INTO ANSWER from alltrips where userid = id and completed = ch;
RETURN ANSWER;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `getTripidFromT` (`useridd` INT(11), `ch` VARCHAR(1) CHARSET utf8mb4) RETURNS BIGINT(20) BEGIN
DECLARE ANSWER INT;
SELECT tripid INTO ANSWER from alltrips where userid = useridd and completed = ch;
RETURN ANSWER;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `getUserid` (`name` VARCHAR(100)) RETURNS INT(11) BEGIN
DECLARE ANSWER INT;
SELECT id INTO ANSWER FROM users WHERE username = name;
RETURN ANSWER;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `alltrips`
--

CREATE TABLE `alltrips` (
  `tripid` bigint(20) NOT NULL,
  `userid` int(11) NOT NULL,
  `carid` bigint(20) NOT NULL,
  `completed` varchar(1) NOT NULL,
  `timestampbook` timestamp NOT NULL DEFAULT current_timestamp(),
  `timestampreturn` timestamp NULL DEFAULT NULL,
  `tripdist` bigint(11) DEFAULT 0,
  `triprating` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alltrips`
--

INSERT INTO `alltrips` (`tripid`, `userid`, `carid`, `completed`, `timestampbook`, `timestampreturn`, `tripdist`, `triprating`) VALUES
(84, 34, 8, 'R', '2021-04-25 11:42:14', '2021-04-25 11:42:32', 100, 4.7),
(85, 34, 9, 'R', '2021-04-25 11:42:51', '2021-04-25 11:43:22', 200, 3.6),
(86, 33, 12, 'R', '2021-04-25 11:45:17', '2021-04-25 11:46:01', 50, 2.6),
(87, 33, 11, 'R', '2021-04-25 11:46:34', '2021-04-25 11:47:27', 5, 3.9),
(88, 35, 10, 'R', '2021-04-25 11:48:46', '2021-04-25 11:49:25', 100, 4.4),
(89, 35, 12, 'R', '2021-04-25 11:49:36', '2021-04-25 11:49:45', 50, 4.6);

--
-- Triggers `alltrips`
--
DELIMITER $$
CREATE TRIGGER `updaterating` AFTER UPDATE ON `alltrips` FOR EACH ROW BEGIN
DECLARE average FLOAT;
SELECT AVG(triprating) INTO average FROM alltrips WHERE carid = new.carid;
UPDATE cars SET carrating = average WHERE carid = new.carid;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `carid` bigint(20) NOT NULL,
  `carname` varchar(100) NOT NULL,
  `availability` varchar(1) NOT NULL,
  `carpic` varchar(100) NOT NULL,
  `carnum` varchar(100) NOT NULL,
  `cardist` bigint(20) NOT NULL DEFAULT 0,
  `carrating` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`carid`, `carname`, `availability`, `carpic`, `carnum`, `cardist`, `carrating`) VALUES
(8, 'Mustang', 'A', 'cars/Mustang.jpg', 'MH 02 1234', 100, 4.7),
(9, 'Ferrari-LaFerrari', 'A', 'cars/Ferrari-LaFerrari.jpg', 'MH 02 2345', 200, 3.6),
(10, 'BMW', 'A', 'cars/BMW.jpg', 'MH 07 3456', 100, 4.4),
(11, 'Bently', 'A', 'cars/Bently.jpg', 'MH 03 8989', 5, 3.9),
(12, 'sk', 'A', 'cars/Corvette.jfif', 'MH 0245', 100, 3.6);

-- --------------------------------------------------------

--
-- Stand-in structure for view `carstripsview`
-- (See below for the actual view)
--
CREATE TABLE `carstripsview` (
`tripid` bigint(20)
,`userid` int(11)
,`carname` varchar(100)
,`carnum` varchar(100)
,`carrating` float
,`start` timestamp
,`end` timestamp
,`tripdist` bigint(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `offerid` int(11) NOT NULL,
  `offername` varchar(100) NOT NULL,
  `userid` int(11) NOT NULL,
  `discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`offerid`, `offername`, `userid`, `discount`) VALUES
(79, 'NEW USER 100', 27, 100),
(81, 'NEW USER 100', 34, 100),
(82, 'NEW USER 100', 35, 100),
(83, 'NEW USER 100', 41, 100),
(84, 'NEW USER 100', 42, 100),
(85, 'FLAT 200 OFF', 27, 200),
(86, 'FLAT 200 OFF', 33, 200),
(87, 'FLAT 200 OFF', 34, 200),
(88, 'FLAT 200 OFF', 35, 200),
(89, 'FLAT 200 OFF', 41, 200),
(90, 'FLAT 200 OFF', 42, 200);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `tid` int(11) NOT NULL,
  `tripid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `costoftrip` int(11) NOT NULL,
  `timestampTransaction` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`tid`, `tripid`, `userid`, `costoftrip`, `timestampTransaction`) VALUES
(67, 84, 34, 400, '2021-03-25 11:42:32'),
(68, 85, 34, 800, '2021-04-05 11:52:09'),
(69, 86, 33, 250, '2021-04-25 09:46:01'),
(70, 87, 33, 0, '2021-04-23 11:51:39'),
(71, 88, 35, 400, '2021-04-23 11:49:25'),
(72, 89, 35, 250, '2021-04-25 11:49:45');

--
-- Triggers `transaction`
--
DELIMITER $$
CREATE TRIGGER `updatereturntrip` AFTER INSERT ON `transaction` FOR EACH ROW UPDATE alltrips SET completed = 'R' , timestampreturn = new.timestampTransaction WHERE tripid = new.tripid
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `tripstransactionview`
-- (See below for the actual view)
--
CREATE TABLE `tripstransactionview` (
`transactionID` int(11)
,`tripid` bigint(20)
,`userid` int(11)
,`start` timestamp
,`end` timestamp
,`tripdist` bigint(11)
,`costOfTrip` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `wallet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `avatar`, `wallet`) VALUES
(27, 'admin', 'admin@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', 'images/admin-settings-male.png', 1000),
(33, 'prashant', 'prashant@gmail.com', '1c5edc4bbb547c49570f4dce082f8333', 'images/naruto.png', 40),
(34, 'sumeet', 'sumeet@gmail.com', '1c5edc4bbb547c49570f4dce082f8333', 'images/lelouch.jfif', 840),
(35, 'saurabh', 'saurabh@gmail.com', '1c5edc4bbb547c49570f4dce082f8333', 'images/gojoxd.png', 850),
(41, 'Shubham', 'sulli@gamil.com', '1c5edc4bbb547c49570f4dce082f8333', 'images/WhatsApp Image 2021-01-06 at 9.35.50 PM.jpeg', 0),
(42, 'teacher', 'teacher@gmail.com', '1c5edc4bbb547c49570f4dce082f8333', 'images/teacher.png', 100);

-- --------------------------------------------------------

--
-- Stand-in structure for view `usersoffersview`
-- (See below for the actual view)
--
CREATE TABLE `usersoffersview` (
`userid` int(11)
,`username` varchar(100)
,`email` varchar(100)
,`wallet` int(11)
,`offerid` int(11)
,`offername` varchar(100)
,`discount` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `usertransactionview`
-- (See below for the actual view)
--
CREATE TABLE `usertransactionview` (
`tripid` int(11)
,`customer` varchar(100)
);

-- --------------------------------------------------------

--
-- Structure for view `carstripsview`
--
DROP TABLE IF EXISTS `carstripsview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `carstripsview`  AS SELECT `b`.`tripid` AS `tripid`, `b`.`userid` AS `userid`, `a`.`carname` AS `carname`, `a`.`carnum` AS `carnum`, `a`.`carrating` AS `carrating`, `b`.`timestampbook` AS `start`, `b`.`timestampreturn` AS `end`, `b`.`tripdist` AS `tripdist` FROM (`cars` `a` join `alltrips` `b`) WHERE `a`.`carid` = `b`.`carid` ;

-- --------------------------------------------------------

--
-- Structure for view `tripstransactionview`
--
DROP TABLE IF EXISTS `tripstransactionview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tripstransactionview`  AS SELECT `a`.`tid` AS `transactionID`, `b`.`tripid` AS `tripid`, `b`.`userid` AS `userid`, `b`.`timestampbook` AS `start`, `b`.`timestampreturn` AS `end`, `b`.`tripdist` AS `tripdist`, `a`.`costoftrip` AS `costOfTrip` FROM (`transaction` `a` join `alltrips` `b`) WHERE `a`.`tripid` = `b`.`tripid` ;

-- --------------------------------------------------------

--
-- Structure for view `usersoffersview`
--
DROP TABLE IF EXISTS `usersoffersview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `usersoffersview`  AS SELECT `b`.`id` AS `userid`, `b`.`username` AS `username`, `b`.`email` AS `email`, `b`.`wallet` AS `wallet`, `a`.`offerid` AS `offerid`, `a`.`offername` AS `offername`, `a`.`discount` AS `discount` FROM (`offers` `a` join `users` `b`) WHERE `a`.`userid` = `b`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `usertransactionview`
--
DROP TABLE IF EXISTS `usertransactionview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `usertransactionview`  AS SELECT `a`.`tripid` AS `tripid`, `b`.`username` AS `customer` FROM (`transaction` `a` join `users` `b`) WHERE `a`.`userid` = `b`.`id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alltrips`
--
ALTER TABLE `alltrips`
  ADD PRIMARY KEY (`tripid`),
  ADD KEY `carid` (`carid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`carid`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`offerid`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`tid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alltrips`
--
ALTER TABLE `alltrips`
  MODIFY `tripid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `carid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `offerid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alltrips`
--
ALTER TABLE `alltrips`
  ADD CONSTRAINT `alltrips_ibfk_1` FOREIGN KEY (`carid`) REFERENCES `cars` (`carid`),
  ADD CONSTRAINT `alltrips_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
