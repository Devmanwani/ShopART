-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2023 at 08:05 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopart`
--

-- --------------------------------------------------------

--
-- Table structure for table `art`
--

CREATE TABLE `art` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `filePath` varchar(250) NOT NULL,
  `Categories` int(11) NOT NULL,
  `uploadDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Views` int(11) NOT NULL,
  `Price` int(11) NOT NULL,
  `uploadedBy` varchar(50) NOT NULL,
  `ownedBy` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `art`
--

INSERT INTO `art` (`id`, `title`, `description`, `filePath`, `Categories`, `uploadDate`, `Views`, `Price`, `uploadedBy`, `ownedBy`) VALUES
(11, 'Graph is new', 'This is an old graph', 'uploads/videos/6414cb05ab0ednew.png', 4, '2023-03-19 19:02:00', 87, 0, 'devm', 'devm'),
(12, 'Dog', 'This is a raw Artwork', 'uploads/videos/6414e20ae00c9dog_2.jpg', 2, '2023-03-19 19:04:09', 54, 1, 'newhuman', 'devm'),
(13, 'illusion artwork', 'old illusion artwork', 'uploads/videos/6414e7d591712illusion_artwork.jpg', 4, '2023-03-19 18:43:40', 20, 0, 'newhuman', 'newuser'),
(14, 'doodle', 'This is a cool doodle', 'uploads/videos/6414e8ce33566life_doodle.jpg', 2, '2023-03-19 18:44:17', 56, 50, 'newhuman', 'newuser'),
(15, 'NFT', 'This is a nft', 'uploads/videos/64157e0086e79nft-2.jpg', 2, '2023-03-19 18:43:41', 22, 200, 'newhuman', 'devm'),
(16, 'Everyone', 'new Artwork', 'uploads/videos/64161f37576e1everyones_watching.jpg', 2, '2023-03-19 18:44:28', 16, 500, 'newuser', 'devm'),
(18, 'walking man', 'gif artwork', 'uploads/videos/641741e4444begif1.gif', 1, '2023-03-19 19:02:07', 20, 1000, 'devm', 'newuser'),
(19, 'Awkward Elephant', 'This is a picture from the NFT collection Awkward Elephant', 'uploads/videos/641752618a036awkward_elephant.png', 4, '2023-03-19 18:43:39', 7, 250, 'newuser', 'newuser'),
(20, 'Northern Lights', 'Photograph of northern lights', 'uploads/videos/6417546335a86northern_lights.jpg', 3, '2023-03-19 18:48:38', 11, 600, 'newuser', 'newuser'),
(22, 'New Zealand', 'Rach Stewart Photography', 'uploads/videos/64175712a0324New_Zealand.jpg', 3, '2023-03-19 18:44:21', 3, 200, 'newuser', 'newuser'),
(23, 'Cool Walking Guy', 'Cool walking Artwork', 'uploads/videos/64175748461f0cool_walking_guy.gif', 1, '2023-03-19 19:01:50', 4, 300, 'devm', 'devm'),
(24, 'Persistance of time', '3d Modelling art', 'uploads/videos/6417578798b53persistence_of_time.png', 2, '2023-03-19 19:01:45', 2, 200, 'devm', 'devm'),
(25, 'Cool Cat', 'This is an art from the Cool Cat collection', 'uploads/videos/641757d14c4b4cool_cat.png', 4, '2023-03-19 19:00:16', 7, 300, 'devm', 'newhuman'),
(26, 'Marine', 'Digital Artwork', 'uploads/videos/641758339e838marine.jpg', 2, '2023-03-19 18:45:10', 1, 300, 'devm', 'devm'),
(27, 'Bored Ape', 'This is an artwork from the Bored Ape collection', 'uploads/videos/641758668b8e4bored_ape.jpg', 4, '2023-03-19 19:04:33', 3, 300, 'newhuman', 'newhuman'),
(28, 'Doodle', 'Doodles are here', 'uploads/videos/6417588a4208fdoodle.gif', 1, '2023-03-19 18:46:37', 1, 100, 'newhuman', 'newhuman'),
(29, 'Invisible Man', 'Find me if You can!', 'uploads/videos/641758ad9697binvisible_man.gif', 1, '2023-03-19 18:58:33', 5, 500, 'newhuman', 'newhuman'),
(30, 'Robopixie', 'Cool Robo!', 'uploads/videos/641758dca4aadrobopixie.jpg', 4, '2023-03-19 19:01:09', 2, 1500, 'newhuman', 'newhuman');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'gif'),
(2, 'art'),
(3, 'photography'),
(4, 'collectibles');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `artId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `username`, `artId`) VALUES
(4, 'newhuman', 14),
(5, 'devm', 14),
(7, 'devm', 11),
(8, 'newhuman', 13),
(10, 'newuser', 15),
(11, 'newuser', 12),
(12, 'devm', 12),
(13, 'devm', 16),
(14, 'devm', 18),
(15, 'newuser', 18),
(16, 'newuser', 20),
(17, 'newhuman', 27),
(19, 'newhuman', 25),
(20, 'newhuman', 30);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profilePic` varchar(255) NOT NULL,
  `signUpDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `username`, `password`, `profilePic`, `signUpDate`) VALUES
(1, 'Dev', 'Manwani', 'devmanwani@gmail.com', 'devm', 'b109f3bbbc244eb82441917ed06d618b9008dd09b3befd1b5e07394c706a8bb980b1d7785e5976ec049b46df5f1326af5a2ea6d103fd07c95385ffab0cacbc86', 'assets/images/profilePictures/default.png', '2023-03-19 13:18:14'),
(2, 'New', 'Human', 'newhuman@gmail.com', 'newhuman', 'b109f3bbbc244eb82441917ed06d618b9008dd09b3befd1b5e07394c706a8bb980b1d7785e5976ec049b46df5f1326af5a2ea6d103fd07c95385ffab0cacbc86', 'assets/images/profilePictures/default.png', '2023-03-17 21:38:48'),
(3, 'Old', 'User', 'olduser@gmail.com', 'newuser', 'b109f3bbbc244eb82441917ed06d618b9008dd09b3befd1b5e07394c706a8bb980b1d7785e5976ec049b46df5f1326af5a2ea6d103fd07c95385ffab0cacbc86', 'assets/images/profilePictures/default.png', '2023-03-19 17:12:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `art`
--
ALTER TABLE `art`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
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
-- AUTO_INCREMENT for table `art`
--
ALTER TABLE `art`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
