-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2021 at 08:27 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `market`
--

-- --------------------------------------------------------

--
-- Table structure for table `backend_user`
--

CREATE TABLE `backend_user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `backend_user`
--

INSERT INTO `backend_user` (`id`, `name`, `username`, `details`, `email`, `password`, `role`) VALUES
(1, 'Protap Mistry', 'adminpro', '', 'admin@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 0),
(2, '', 'Author', '', 'sarwar.cse@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1);

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brandName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brandName`) VALUES
(1, 'iPhone'),
(3, 'Acer'),
(4, 'HP'),
(5, 'Canon');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `price` float(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `categoryName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `categoryName`) VALUES
(1, 'Laptop'),
(2, 'Desktop'),
(3, 'Mobile'),
(4, 'Accessories'),
(5, 'Software'),
(6, 'Sports and Fitness'),
(7, 'Footwares'),
(8, 'Jewelry'),
(9, 'Clothing'),
(13, 'Beauty and Health-care'),
(15, 'Toys, Kids and Babies');

-- --------------------------------------------------------

--
-- Table structure for table `comparison`
--

CREATE TABLE `comparison` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `customerName` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `customerName`, `country`, `city`, `zipcode`, `address`, `phone`, `email`, `password`) VALUES
(1, 'Protap Mistry', 'BD', 'Khulna', '9351', 'Mongla', '01728145671', 'pro.cse4.bu@gmail.com', 'cc7d744dd71d2f11276b6cf44a19efe0'),
(2, 'Protap Mistry', 'BD', 'Khulna', '9351', 'Mongla', '01728145671', 'protapmstr@gmail.com', 'cc7d744dd71d2f11276b6cf44a19efe0');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `footer`
--

CREATE TABLE `footer` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `footer`
--

INSERT INTO `footer` (`id`, `text`) VALUES
(1, '#Tech_PRO. All rights reserved.');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `price` float(10,2) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `productName`, `category_id`, `brand_id`, `image`, `body`, `price`, `type`, `date`) VALUES
(1, 'PROBOOK 450 G1 ', 1, 4, 'upload/2bcf952658.jpg', '<p><span>4</span><span>th</span><span>&nbsp;generation Intel Core Processors</span></p>\r\n<p><span>Mobile Intel HM87 Express</span></p>\r\n<div class=\"para\">Integrated graphics</div>\r\n<div class=\"para\">\r\n<ul class=\"with-bullets\">\r\n<li>Intel HD Graphics 4600 (4th Generation Intel Quad-Core i7 and Dual-Core i5 and i3)</li>\r\n<li>Intel HD Graphics (Celeron and Pentium configurations)</li>\r\n<li>AMD Radeon&trade; HD** 8750M, with 1 or 2 GB dedicated DDR3 video memory</li>\r\n</ul>\r\n<ul class=\"with-bullets\">\r\n<li>\r\n<div class=\"para\"><strong class=\"bold\">nternal</strong>: 15.6\" diagonal LED-backlit HD Touch Display is shatter, scratch, reflection and smudge resistant (1366 x 768)</div>\r\n</li>\r\n<li>\r\n<div class=\"para\">15.6\" diagonal LED-backlit HD anti-glare (1366 x 768)</div>\r\n</li>\r\n<li>\r\n<div class=\"para\"><strong class=\"bold\">External</strong>: Up to 32-bit per pixel color depth</div>\r\n</li>\r\n<li>\r\n<div class=\"para\"><strong class=\"bold\">VGA</strong>: Port supports resolutions up to 1920 x 1080 external resolution @60 Hz</div>\r\n</li>\r\n<li>\r\n<div class=\"para\"><strong class=\"bold\">HDMI</strong>: Supports direct connection to high-definition displays with up to 1920 x 1200@60Hz resolution and 7-channel audio with one convenient cable (not included)</div>\r\n</li>\r\n</ul>\r\n</div>', 52.00, 1, '2021-07-09 18:33:41'),
(3, 'Symphony', 3, 5, 'upload/549870d8e5.png', '<p>sdrftrguyhjkl;rdrftghjkm,lrftgyuhjkl</p>', 5.00, 0, '2021-07-16 17:53:28'),
(4, 'Mac', 2, 1, 'upload/ac0cfd65ad.png', '<p>dfvgbhjnmkedfghjkl;</p>', 52.00, 0, '2021-07-16 17:58:40'),
(6, 'Camera', 4, 5, 'upload/c17a8010fd.jpg', '<p>xcvbnm,.dfgvhjnkml,dfcgvbhjnmk,</p>', 5.00, 1, '2021-07-16 18:00:01'),
(7, 'Laptop', 5, 3, 'upload/84a6c1eb14.jpg', '<p>sdrtfgyhjnmkxdfgvbhjnmksdfvgbhjnmk</p>', 5500.00, 0, '2021-07-17 05:15:23'),
(8, 'Desktop', 2, 4, 'upload/f736d4b04e.jpg', '<p>xdcfvgbhnjedrtfghjkl</p>', 52.00, 1, '2021-07-17 05:17:58'),
(9, 'iPhone-XR', 3, 1, 'upload/9f59d7b614.jpg', '<p><span>mobile was launched in September 2018. The phone comes with a 6.10-inch touchscreen display with a resolution of 828x1792 pixels at a pixel&nbsp;</span></p>', 70000.00, 0, '2021-07-24 04:52:00'),
(10, 'iPhone 11', 3, 1, 'upload/fc19dc6008.jpg', '<p><span>Get up to $180 off a new iPhone 11 when you trade in your current iPhone. Personal setup available. Buy now with free delivery</span></p>', 80000.00, 0, '2021-07-24 04:53:55'),
(11, 'iPhone 12', 3, 1, 'upload/fc3a41cb39.png', '<p><span>Get iPhone 12 or iPhone 12 mini for an amazing price with special carrier trade-in offers. Pay over time with low monthly payments. Buy Now</span></p>', 90000.00, 0, '2021-07-24 04:55:34'),
(12, 'iPhone 12 pro', 3, 1, 'upload/c4ade8f1d8.png', '<p><span>Get iPhone 12 Pro or iPhone 12 Pro Max for an amazing price with special carrier trade-in offers. Pay over time with low monthly payments. Buy Now.</span></p>', 100000.00, 0, '2021-07-24 04:57:00');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `title`, `image`) VALUES
(1, 'iPhone', 'upload/slider/eaceb04a53.jpg'),
(2, 'HP Brand', 'upload/slider/e3bb768758.jpg'),
(3, 'Canon', 'upload/slider/a76aa97908.jpg'),
(4, 'Acer', 'upload/slider/9f08be611e.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `customer_id`, `product_id`, `productName`, `image`, `price`) VALUES
(1, 1, 1, 'PC- HP PROBOOK 450 G1 ', 'upload/2bcf952658.jpg', 52.00),
(2, 1, 7, 'VSCode', 'upload/84a6c1eb14.jpg', 5500.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backend_user`
--
ALTER TABLE `backend_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comparison`
--
ALTER TABLE `comparison`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footer`
--
ALTER TABLE `footer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `backend_user`
--
ALTER TABLE `backend_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `comparison`
--
ALTER TABLE `comparison`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `footer`
--
ALTER TABLE `footer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
