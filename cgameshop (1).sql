-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2024 at 03:55 PM
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
-- Database: `cgameshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'PlayStation'),
(2, 'Xbox'),
(3, 'Nintendo Switch');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `name`, `email`, `phone`, `subject`, `message`) VALUES
(1, 'awdawd', 'awdawdawd@gmail.com', 'awdawd', 'awdawd', 'awdawd');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `order_date` datetime NOT NULL,
  `tel` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `product` text NOT NULL,
  `quantity` int(6) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(30) NOT NULL,
  `status` varchar(50) DEFAULT 'รอดำเนินการ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders_complete`
--

CREATE TABLE `orders_complete` (
  `orders_complete_id` int(6) NOT NULL,
  `order_id` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  `order_date` datetime NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `products` text NOT NULL,
  `quantity` int(6) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(30) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'รอดำเนินการ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders_complete`
--

INSERT INTO `orders_complete` (`orders_complete_id`, `order_id`, `user_id`, `order_date`, `fullname`, `tel`, `address`, `products`, `quantity`, `amount`, `total_amount`, `payment_method`, `status`) VALUES
(15, 44, 2, '2024-05-09 14:49:44', 'Nontprawitch SaeTang', '025746986', '224/8 ซ.สุขุมวิท 22 เขตคลองเขต', 'Sony PlayStation 5 Slim Digital Edition', 1, 17900.00, 17900.00, 'Credit card', 'ชำระเงินเรียบร้อย'),
(16, 45, 2, '2024-05-09 14:49:44', 'Nontprawitch SaeTang', '025746986', '224/8 ซ.สุขุมวิท 22 เขตคลองเขต', 'Xbox Series X', 4, 18990.00, 75960.00, 'Credit card', 'ชำระเงินเรียบร้อย'),
(17, 49, 11, '2024-05-11 15:21:10', 'tester non saet', '0678912546', 'sXXXX', 'Sony PlayStation 5 Slim Disc Edition', 1, 18900.00, 18900.00, 'Credit card', 'รอดำเนินการ'),
(18, 50, 11, '2024-05-11 15:21:10', 'tester non saet', '0678912546', 'sXXXX', 'Nintendo Switch Ring Fit adventure', 3, 2590.00, 7770.00, 'Credit card', 'รอดำเนินการ'),
(19, 51, 11, '2024-05-11 15:21:10', 'tester non saet', '0678912546', 'sXXXX', 'Sony Tekken 8', 1, 1890.00, 1890.00, 'Credit card', 'รอดำเนินการ'),
(20, 52, 12, '2024-05-12 09:04:06', 'aaa bbb', '0687451289', '555/5 Bangkok', 'Sony Controller PlayStation5', 1, 2390.00, 2390.00, 'Credit card', 'รอดำเนินการ'),
(21, 53, 2, '2024-05-12 14:48:21', 'Nontprawitch SaeTang', '025746986', '224/8 ซ.สุขุมวิท 22 เขตคลองเขต', 'Sony PlayStation 5 Slim Digital Edition', 1, 17900.00, 17900.00, ' Cash on delivery', 'รอดำเนินการ');

-- --------------------------------------------------------

--
-- Table structure for table `pattern`
--

CREATE TABLE `pattern` (
  `pattern_id` int(11) NOT NULL,
  `pattern_name` varchar(255) DEFAULT NULL,
  `pattern_media` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `type_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pattern`
--

INSERT INTO `pattern` (`pattern_id`, `pattern_name`, `pattern_media`, `category_id`, `type_id`) VALUES
(5, 'dragon ball', 'dragonball.png', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_type`
--

CREATE TABLE `payment_type` (
  `payment_id` int(6) NOT NULL,
  `payment_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_type`
--

INSERT INTO `payment_type` (`payment_id`, `payment_name`) VALUES
(1, 'Credit card'),
(2, 'Transfer money'),
(3, ' Cash on delivery');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `type_id` int(3) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `added_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `price`, `quantity`, `category_id`, `type_id`, `image_url`, `status`, `added_date`) VALUES
(3, 'Sony PlayStation 5 Slim Disc Edition', 'CPU: มี CPU ที่มาพร้อมกับเทคโนโลยี AMD Zen 2 แบบ 8-core\r\nGPU: มี GPU ที่ใช้งานร่วมกับ AMD RDNA 2 ที่สามารถสร้างกราฟิกที่คมชัดและรายละเอียดสูงได้\r\nRAM: มี RAM ขนาด 16GB GDDR6\r\nStorage: มี SSD ความจุในตัวเครื่องที่อยู่ในช่วง 825GB ที่มีความเร็วการอ่านและเขียนข้อมูลที่เร็วมาก\r\nResolution: รองรับการแสดงผลความละเอียดสูงสุด 4K\r\nBackward Compatibility: PS5 ยังสามารถเล่นเกม PS4 ได้\r\nRay Tracing: มีการสนับสนุนเทคโนโลยี Ray Tracing สำหรับกราฟิกที่มีความสวยงามและเรียบเนียนมากขึ้น\r\nเทคโนโลยีเสียง: มีเทคโนโลยีเสียง 3D Audio ที่ช่วยสร้างประสบการณ์เสียงรอบทิศทางที่สมจริง', 18900.00, 14, 1, 2, 'Sony-PlayStation-5-Slim-Disc-Edition.jpg', 'In stock', '2024-03-18'),
(4, 'Sony Controller PlayStation5', 'ค้นพบประสบการณ์การเล่นเกมที่ล้ําลึกขึ้น ด้วยคอนโทรลเลอร์ PS5 ที่ปรับปรุงใหม่, คอนโทรลเลอร์ไร้สาย DualSense สําหรับคอนโซล PS5 มอบการตอบสนองแบบสัมผัส อย่างสมจริง? ทั้งยังมีเอฟเฟกต์ทริกเกอร์แบบไดนามิก? และไมโครโฟนในตัว ทั้งหมด รวมอยู่ในการออกแบบอันเป็นเอกลักษณ์', 2390.00, 30, 1, 1, 'Controller-PlayStation5.jpg', 'In stock', '2024-03-18'),
(10, 'Sony PlayStation 5 Slim Digital Edition', '', 17900.00, 3, 1, 2, 'Sony-PlayStation-5-Slim-Digital-Edition.jpg', 'In stock', '2024-04-07'),
(11, 'Xbox Series X', 'เครื่องเล่นเกม Xbox Series X\r\nเป็นเครื่องเล่นเกมรุ่นใหม่ที่มีประสิทธิภาพสูงและความเร็วสูง มีดีไซน์ที่สวยงาม, ความจุขนาดใหญ่, และสามารถเล่นเกมในความละเอียด 4K', 18990.00, 26, 2, 2, 'Microsoft-XBox-Series-X.jpg', 'In stock', '2024-04-10'),
(15, 'Nintendo Switch Animal Crossing New Horizons', 'Game nintendo switch', 1890.00, 5, 3, 3, 'Animal-Crossing-New_Horizons.jpg', 'In stock', '2024-04-16'),
(17, 'Nintendo Switch Ring Fit adventure', 'เกมออกกำลังกาย', 2590.00, 10, 3, 3, 'Ring-Fit.jpg', 'In stock', '2024-04-30'),
(18, 'Sony Tekken 8', 'game', 1890.00, 155, 1, 3, 'Tekken8.jpg', 'In stock', '2024-05-17');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `reviews_id` int(6) NOT NULL,
  `orders_complete_id` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `products` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `review_date` datetime NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'ชำระเงินเรียบร้อย'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`reviews_id`, `orders_complete_id`, `user_id`, `fullname`, `products`, `content`, `review_date`, `status`) VALUES
(1, 15, 2, 'Nontprawitch SaeTang', 'Sony PlayStation 5 Slim Digital Edition', 'จัดส่งสินค้าได้ไว', '2024-05-11 15:05:52', 'ชำระเงินเรียบร้อย');

-- --------------------------------------------------------

--
-- Table structure for table `tranfer_payment`
--

CREATE TABLE `tranfer_payment` (
  `tranfer_id` int(6) NOT NULL,
  `orders_complete_id` int(6) NOT NULL,
  `slip` varchar(255) NOT NULL,
  `user_id` int(6) NOT NULL,
  `fullname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tranfer_payment`
--

INSERT INTO `tranfer_payment` (`tranfer_id`, `orders_complete_id`, `slip`, `user_id`, `fullname`) VALUES
(1, 15, 'slip1.jpg', 2, 'Nontprawitch SaeTang'),
(2, 16, 'slip1.jpg', 2, 'Nontprawitch SaeTang');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `type_id` int(10) NOT NULL,
  `type_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`type_id`, `type_name`) VALUES
(1, 'Controller'),
(2, 'Console'),
(3, 'Game');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `gender` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `user_type` varchar(15) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `firstname`, `lastname`, `gender`, `email`, `tel`, `address`, `user_type`) VALUES
(1, 'admin', 'admin123', 'Admin', 'Tester', 'men', 'admin@gmail.com', '0123456789', 'LA', 'admin'),
(2, 'tester', 'test123', 'Nontprawitch', 'SaeTang', 'men', 'Nontprawitch@gmail.com', '025746986', '224/8 ซ.สุขุมวิท 22 เขตคลองเขต', 'user'),
(10, 'xxx', 'xxxxxxxx', 'xxx', 'xxx', 'men', 'xxx@gmail.com', '0258741369', '', 'user'),
(11, 'tester123', 'test1234', 'tester non', 'saet', 'men', 'tester123@gmail.com', '0678912546', 'sXXXX', 'user'),
(12, 'aaaa', '1234567890', 'aaa', 'bbb', 'men', 'aaa@gmail.com', '0687451289', '555/5 Bangkok', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders_complete`
--
ALTER TABLE `orders_complete`
  ADD PRIMARY KEY (`orders_complete_id`);

--
-- Indexes for table `pattern`
--
ALTER TABLE `pattern`
  ADD PRIMARY KEY (`pattern_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `fk_type_id` (`type_id`);

--
-- Indexes for table `payment_type`
--
ALTER TABLE `payment_type`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviews_id`);

--
-- Indexes for table `tranfer_payment`
--
ALTER TABLE `tranfer_payment`
  ADD PRIMARY KEY (`tranfer_id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `orders_complete`
--
ALTER TABLE `orders_complete`
  MODIFY `orders_complete_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pattern`
--
ALTER TABLE `pattern`
  MODIFY `pattern_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment_type`
--
ALTER TABLE `payment_type`
  MODIFY `payment_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `reviews_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tranfer_payment`
--
ALTER TABLE `tranfer_payment`
  MODIFY `tranfer_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `type_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `pattern`
--
ALTER TABLE `pattern`
  ADD CONSTRAINT `fk_type_id` FOREIGN KEY (`type_id`) REFERENCES `type` (`type_id`),
  ADD CONSTRAINT `pattern_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
