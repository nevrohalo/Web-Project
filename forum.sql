-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2018 at 04:55 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forum`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `content`, `date`, `user_id`, `post_id`) VALUES
(1, 'Commenting something.', '2018-06-08 14:18:26', 4, 1),
(2, 'Commenting something else.', '2018-06-10 16:15:32', 2, 1),
(3, 'Testing comments.', '2018-06-10 18:49:45', 2, 7),
(4, 'Nice. I\'m gonna use this.', '2018-06-11 13:27:24', 2, 1),
(5, 'Testing comments from another account.', '2018-06-11 20:47:15', 3, 8),
(6, 'Very good tool!', '2018-06-11 20:47:41', 3, 1),
(7, 'Nice, gonna check it out!', '2018-06-12 00:00:11', 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` longtext NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `sub_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `title`, `content`, `date`, `user_id`, `sub_id`) VALUES
(1, 'JQuery Validation Plugin', 'This jQuery plugin makes simple clientside form validation easy, whilst still offering plenty of customization options. It makes a good choice if you’re building something new from scratch, but also when you’re trying to integrate something into an existing application with lots of existing markup. The plugin comes bundled with a useful set of validation methods, including URL and email validation, while providing an API to write your own methods. All bundled methods come with default error messages in english and translations into 37 other languages.', '2018-06-06 22:35:18', 1, 1),
(2, 'UML-RSDS', 'UML-RSDS solves the long-standing problem of how to combine declarative high-level specification of model transformations and general software systems, with efficient execution. It does this by enabling users to write their specifications in OCL and class diagrams, and then automatically generating efficient Java code from these specifications.\r\nThe tool can be used to quickly sketch designs in UML and immediately generate working code - even for incomplete models. It can also be used to quickly produce prototypes or test scripts.', '2018-06-10 11:14:20', 2, 1),
(3, 'Defining Information Systems', 'Information Systems is an academic study of systems with a specific reference to information and the complementary networks of hardware and software that people and organizations use to collect, filter, process, create and also distribute data. ... Information systems are also different from business processes.', '2018-06-10 11:16:21', 4, 2),
(4, 'Finance is Easy', 'You all know it.', '2018-06-10 11:18:23', 2, 3),
(5, 'VisuAlgo', 'Visualization of sorting algorithms in a java application. Provides a set of standard sorting algorithms, which can be evaluated and modified.', '2018-06-10 11:23:16', 2, 1),
(6, 'GitHub Inc.', 'GitHub Inc. is a web-based hosting service for version control using Git. It is mostly used for computer code. It offers all of the distributed version control and source code management functionality of Git as well as adding its own features.', '2018-06-10 12:34:59', 3, 1),
(7, 'W3Schools', 'W3Schools is a popular web site for learning web technologies online. Content includes tutorials and references relating to HTML, CSS, JavaScript, JSON, PHP, Python, AngularJS, SQL, Bootstrap, Node.js, jQuery, XQuery, AJAX, and XML.', '2018-06-10 17:12:46', 1, 1),
(8, 'Law and Order', 'Has anyone seen it?', '2018-06-11 20:47:04', 3, 4),
(9, 'Definition of Finance', 'Finance is a field that deals with the study of investments.  It includes the dynamics of assets and liabilities over time under conditions of different degrees of uncertainties and risks.', '2018-06-12 00:10:47', 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sub`
--

CREATE TABLE `sub` (
  `sub_id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub`
--

INSERT INTO `sub` (`sub_id`, `title`, `description`, `user_id`) VALUES
(1, 'Computer Science', 'The official sub for all Computer Science related posts.', 1),
(2, 'Information Systems', 'The official sub for all Information Systems related posts.', 4),
(3, 'Finance', 'The official sub for all Finance related posts.', 2),
(4, 'Law', 'The official sub for all Law related posts.', 2),
(5, 'International Relations', 'The official sub for all International Relations related posts.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `username`, `password`, `description`) VALUES
(1, 'Kurt Cobain', 'kurtcobain', 'smellsliketestaccount', 'Not really a student at UNYT, cause you know... I\'m dead. Just a test account.'),
(2, 'Nevro Halo', 'nevrohalo', 'nevro1234.', 'Student at the University of New York in Tirana. Majoring in Computer Science. Living in the city of Tirana.'),
(3, 'Pamela Halo', 'pamelahalo', 'pamela1234.', 'Student at the University of New York in Tirana. Majoring in Finance. Living in the city of Tirana.'),
(4, 'Kristal Divitku', 'kristaldivitku', 'kristal1234.', 'Student at the University of New York in Tirana. Majoring in Computer Science. Living in the city of Tirana.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_user_fk` (`user_id`),
  ADD KEY `comment_post` (`post_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_user_fk` (`user_id`),
  ADD KEY `post_sub_fk` (`sub_id`);

--
-- Indexes for table `sub`
--
ALTER TABLE `sub`
  ADD PRIMARY KEY (`sub_id`),
  ADD KEY `sub_user_fk` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sub`
--
ALTER TABLE `sub`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_post` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`),
  ADD CONSTRAINT `comment_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_sub_fk` FOREIGN KEY (`sub_id`) REFERENCES `sub` (`sub_id`),
  ADD CONSTRAINT `post_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `sub`
--
ALTER TABLE `sub`
  ADD CONSTRAINT `sub_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
