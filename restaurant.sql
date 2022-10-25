-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2022 at 06:43 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `location`) VALUES
(1, 'Main Course', 'main_course.php'),
(2, 'Drinks', 'drinks.php'),
(3, 'Dessert', 'desserts.php');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cost` double NOT NULL,
  `category_id` int(11) NOT NULL,
  `image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`id`, `name`, `cost`, `category_id`, `image`) VALUES
(1, 'Beef Kaldereta', 49.99, 1, './Assets/Uploadedimg/237581a8375949c6b6c9e8525e7a8663Beef Kaldereta.png'),
(2, 'Bulalo', 69.99, 1, './Assets/Uploadedimg/c0309d7fca840851ae382f857d34bbb0Bulalo.png'),
(3, 'Clam Toast with Pancetta', 49.99, 1, './Assets/Uploadedimg/b8481fbfe4d933862eb973bf392fdfadClam Toasts with Pancetta.png'),
(4, 'Crockpot Chicken and Dumplings', 75.99, 1, './Assets/Uploadedimg/3c0da934e576f521c097fbd2b7d296a2Crockpot Chicken and Dumplings.png'),
(5, 'Grilled Garlic and Black Pepper Shrimp', 65.99, 1, './Assets/Uploadedimg/39ab378b2dd1651a3191eb353c62409cGrilled Garlic-and-Black Pepper Shrimp.png'),
(6, 'Easy Buffalo Chicken Enchiladas with Celery', 89.99, 1, './Assets/Uploadedimg/8677ba8afb8e3e8c680612d9f4e78f7bEasy Buffalo Chicken Enchiladas with Celery Salsa.png'),
(7, 'Bourbon Fig', 24.99, 2, './Assets/Uploadedimg/aa83d34a979e618676dcb93c93ecd490Bourbon Fig.png'),
(8, 'Ginger Fizz', 19.99, 2, './Assets/Uploadedimg/75fbd44526a35fa8ed0f86a4114e3786Ginger Fizz.png'),
(9, 'Pan Thandai', 14.99, 2, './Assets/Uploadedimg/42e434fd250b3782bf61b606a0a78fefPan Thandai.png'),
(10, 'Nutriboost Smoothie', 17.99, 2, './Assets/Uploadedimg/9d32a581a2e8c93b55da0d207ad962a3Nutriboost Smoothie.png'),
(11, 'Rose & Arrak Mastani', 12.99, 2, './Assets/Uploadedimg/075816d3aabb0aede4473785a55b25c9Rose & Arrak Mastani.png'),
(12, 'Irish Coffee', 9.99, 2, './Assets/Uploadedimg/1922e1a0b8667afb3d7f02a7e1b35cf6Irish Coffee.png'),
(14, 'Chocolate Chess Pie', 39.99, 3, './Assets/Uploadedimg/87c4634f2552fe2e1a31e131975cedadChocolateChessPie.png'),
(15, 'Cookie Butter Pie', 34.99, 3, './Assets/Uploadedimg/3c56fce47ed6e1380b2f46429dc6f960CookieButterPie.png');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dishes_id` int(11) NOT NULL,
  `date_ordered` datetime NOT NULL DEFAULT current_timestamp(),
  `date_finished` datetime NOT NULL,
  `status` enum('finished','on Progress','canceled') NOT NULL DEFAULT 'on Progress'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `dishes_id`, `date_ordered`, `date_finished`, `status`) VALUES
(9, 2, 14, '2022-10-25 23:34:51', '2022-10-25 06:42:01', 'canceled'),
(10, 2, 14, '2022-10-25 23:37:14', '2022-10-25 06:42:04', 'canceled'),
(11, 2, 1, '2022-10-25 23:51:42', '2022-10-25 06:42:06', 'canceled'),
(12, 1, 1, '2022-10-26 00:04:39', '2022-10-25 06:41:11', 'canceled');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `firstName` varchar(150) NOT NULL,
  `lastName` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `firstName`, `lastName`) VALUES
(1, 'don', '12345', 'Don', 'Curativo'),
(2, 'admin', 'admin', 'admin', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dishes`
--
ALTER TABLE `dishes`
  ADD CONSTRAINT `dishes_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
