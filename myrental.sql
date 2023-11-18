-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2023 at 10:33 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myrental`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_car`
--

CREATE TABLE `table_car` (
  `car_id` int(11) NOT NULL,
  `car_name` varchar(30) NOT NULL,
  `car_type` varchar(30) NOT NULL,
  `car_state` varchar(20) NOT NULL,
  `car_location` text NOT NULL,
  `car_description` text NOT NULL,
  `car_seat` int(11) NOT NULL,
  `car_price` int(11) NOT NULL,
  `car_image` varchar(30) NOT NULL,
  `car_reg_date` varchar(20) NOT NULL DEFAULT current_timestamp(),
  `owner_id` int(11) NOT NULL,
  `car_status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_car`
--

INSERT INTO `table_car` (`car_id`, `car_name`, `car_type`, `car_state`, `car_location`, `car_description`, `car_seat`, `car_price`, `car_image`, `car_reg_date`, `owner_id`, `car_status`) VALUES
(5, 'Audi A3 Sedan 8Y (2022-Present', 'Sedans', 'Kedah', 'UUM', 'Powerful, fun to drive, and well-built. These are some character-defining traits of the Audi A3 Sedan, which has, in our experience, proven to be the most engaging model in its segment. It falls flat on its face with regards to the lack of advanced driving aids, and its sticker price puts it firmly in the category of statelier executives. Shame, for what is otherwise a validly lovable product.', 0, 30, 'images/64aede45c40e6.png', '', 8, 'Available'),
(6, 'Toyota Vios Price List (Varian', 'Sedans', 'Kedah', 'UUM', 'The 2023 - 2024 Toyota Vios is offered in 2 variants - which are priced from RM 89,600 to RM 95,500, the base model of vios is 2023 Toyota Vios 1.5E AT which is at a price of RM 89,600 and the top variant of Toyota Vios is 2023 Toyota Vios 1.5G AT which is offered at a price of RM 95,500.', 0, 30, 'images/64aedeaeece52.png', '', 8, 'Rented'),
(7, 'Honda HR-V Price List (Variant', 'SUVs (Sports Utility Vehicles)', 'Kedah', 'UUM', 'The 2023 - 2024 Honda HR-V is offered in 4 variants - which are priced from RM 115,900 to RM 141,900, the base model of hr-v is 2022 Honda HR-V 1.5 S which is at a price of RM 115,900 and the top variant of Honda HR-V is 2022 Honda HR-V RS e:HEV which is offered at a price of RM 141,900.', 0, 200, 'images/64aedf2f7e9fc.png', '', 9, 'Available'),
(8, 'Pero2', '', '', '', 'new car', 0, 200, 'images/64ad15dc7e255.png', '', 0, ''),
(9, 'Pero2', '', '', '', 'new car', 0, 200, 'images/64ad15dc7e255.png', '', 0, ''),
(10, 'Pero2', '', '', '', 'new car', 0, 200, 'images/64ad15dc7e255.png', '', 0, ''),
(11, 'Pero2', '', '', '', 'new car', 0, 200, 'images/64ad15dc7e255.png', '', 0, ''),
(12, 'Pero2', '', '', '', 'new car', 0, 200, 'images/64ad15dc7e255.png', '', 0, ''),
(14, 'Pero2', '', '', '', 'new car', 0, 200, 'images/64ad15dc7e255.png', '', 0, ''),
(15, 'Pero2', '', '', '', 'new car', 0, 200, 'images/64ad15dc7e255.png', '', 0, ''),
(16, 'Pero2', '', '', '', 'new car', 0, 200, 'images/64ad15dc7e255.png', '', 0, ''),
(17, 'Pero9', '', '', '', 'new car', 0, 200, 'images/64adfbc9817c5.png', '', 0, ''),
(20, 'Joovis Car', '', '', '', 'new car', 0, 200, 'images/64af0b086d3ec.png', '2023-07-13 04:20:24', 0, 'Available'),
(22, 'lamborgini2', '', '', '', 'Mobil uji coba', 0, 15, 'images/64af0bb3a3bed.png', '2023-07-13 04:23:15', 7, 'Available'),
(23, 'car', '', '', '', 'Some cars just proves that simplicity is king when it comes to certain matters, and the Suzuki Alto is one of the perennial examples of this. There’s not much fluff to the Suzuki Alto, as  you can see from how it looks, but if you’re looking for a car that gets you from point A to point B with the least amount of hassle, then the Suzuki Alto is for you.', 0, 200, 'images/64af0bc130738.png', '2023-07-13 04:23:29', 7, 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `table_cart`
--

CREATE TABLE `table_cart` (
  `cart_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cart_reg_date` varchar(30) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_cart`
--

INSERT INTO `table_cart` (`cart_id`, `car_id`, `user_id`, `cart_reg_date`) VALUES
(1, 1, 7, '2023-07-12 21:23:03'),
(2, 2, 7, '2023-07-12 21:31:30'),
(3, 3, 7, '2023-07-12 21:33:16'),
(4, 1, 7, '2023-07-12 21:23:03'),
(5, 2, 7, '2023-07-12 21:31:30'),
(6, 3, 7, '2023-07-12 21:33:16'),
(7, 1, 7, '2023-07-12 21:23:03'),
(8, 2, 7, '2023-07-12 21:31:30'),
(9, 3, 7, '2023-07-12 21:33:16'),
(10, 1, 7, '2023-07-12 21:23:03'),
(11, 2, 7, '2023-07-12 21:31:30'),
(12, 1, 7, '2023-07-13 01:16:35'),
(14, 1, 0, '2023-07-13 02:06:07'),
(15, 1, 0, '2023-07-13 02:07:29'),
(16, 2, 7, '2023-07-13 03:59:52'),
(24, 0, 7, '2023-07-13 13:20:09'),
(25, 0, 7, '2023-07-13 13:20:11'),
(26, 0, 7, '2023-07-13 13:20:12');

-- --------------------------------------------------------

--
-- Table structure for table `table_rental`
--

CREATE TABLE `table_rental` (
  `rental_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `rental_price` int(11) NOT NULL,
  `rental_start_date` varchar(20) NOT NULL,
  `rental_end_date` varchar(20) NOT NULL,
  `rental_start_time` varchar(20) NOT NULL,
  `rental_end_time` varchar(20) NOT NULL,
  `rental_duration` varchar(20) NOT NULL,
  `rental_reg_time` varchar(20) NOT NULL DEFAULT current_timestamp(),
  `rental_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_rental`
--

INSERT INTO `table_rental` (`rental_id`, `user_id`, `car_id`, `rental_price`, `rental_start_date`, `rental_end_date`, `rental_start_time`, `rental_end_time`, `rental_duration`, `rental_reg_time`, `rental_status`) VALUES
(93, 7, 5, 0, '2023-07-13', '2023-07-13', '04:29', '04:29', '0', '2023-07-13 04:33:25', 'Expired'),
(94, 7, 5, 30, '2023-07-13', '2023-07-13', '05:24', '06:24', '1', '2023-07-13 05:24:35', 'Pending Payment'),
(95, 7, 5, 2910, '2023-07-13', '2023-07-21', '13:09', '15:09', '194', '2023-07-13 13:09:06', ''),
(96, 7, 5, 0, '2023-07-13', '2023-07-13', '14:10', '14:10', '0', '2023-07-13 14:13:31', 'Pending Payment'),
(97, 7, 5, 0, '2023-07-13', '2023-07-13', '14:10', '14:17', '0', '2023-07-13 14:17:11', 'Pending Payment'),
(98, 7, 5, 0, '2023-07-13', '2023-07-13', '14:10', '14:17', '0', '2023-07-13 14:17:54', 'Pending Payment'),
(99, 7, 5, 0, '2023-07-13', '2023-07-13', '14:19', '14:19', '0', '2023-07-13 14:19:16', 'Pending Payment'),
(100, 7, 0, 0, '', '', '', '', '', '2023-07-13 14:58:12', 'Pending Payment');

-- --------------------------------------------------------

--
-- Table structure for table `table_user`
--

CREATE TABLE `table_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_email` varchar(30) NOT NULL,
  `user_password` varchar(30) NOT NULL,
  `user_reg_time` varchar(30) NOT NULL DEFAULT current_timestamp(),
  `user_photo` varchar(30) NOT NULL,
  `user_address` text NOT NULL,
  `user_phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_user`
--

INSERT INTO `table_user` (`user_id`, `user_name`, `user_email`, `user_password`, `user_reg_time`, `user_photo`, `user_address`, `user_phone`) VALUES
(7, 'Joovis Gunawan', 'joovisg@gmail.com', 'asdf1234', '2023-07-11 16:01:28', '', 'Sintok, 06010 Bukit Kayu Hitam, Kedah', '0176494416'),
(8, 'Rayan', 'rayan@gmail.com', 'qwer1234', '2023-07-11 16:03:53', '', '', ''),
(9, 'nakami', 'nakamai@gmail.com', 'nakami123', '2023-07-11 16:04:55', '', '', ''),
(10, 'haikal', 'haikal@gmail.com', 'haikal123', '2023-07-11 16:06:18', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_car`
--
ALTER TABLE `table_car`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `table_cart`
--
ALTER TABLE `table_cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `table_rental`
--
ALTER TABLE `table_rental`
  ADD PRIMARY KEY (`rental_id`);

--
-- Indexes for table `table_user`
--
ALTER TABLE `table_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_car`
--
ALTER TABLE `table_car`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `table_cart`
--
ALTER TABLE `table_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `table_rental`
--
ALTER TABLE `table_rental`
  MODIFY `rental_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `table_user`
--
ALTER TABLE `table_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
