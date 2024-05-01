-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2024 at 05:13 PM
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
-- Database: `pharmalink`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_ID` int(11) NOT NULL,
  `cust_ID` int(11) NOT NULL,
  `prod_ID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cust_ID` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `total_spent` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cust_ID`, `fname`, `lname`, `gender`, `age`, `address`, `email`, `pass`, `total_spent`) VALUES
(6, 'Amanda', 'Davis', 'Female', 29, '303 Cedar Street, Villatown', 'amanda@example.com', 'test123', 895.50),
(7, 'James', 'Miller', 'Male', 45, '404 Birch Street, Citytown', 'james@example.com', '123456', 33.49),
(8, 'Sarah', 'Wilson', 'Female', 31, '505 Walnut Street, Townberg', 'sarah@example.com', 'password', 20.46),
(9, 'David', 'Taylor', 'Male', 27, '606 Pineapple Street, Hamlettown', 'david@example.com', 'david123', 57.47),
(10, 'Jessica', 'Anderson', 'Female', 38, '707 Orange Street, Villaville', 'jessica@example.com', 'jessica', 19.57);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_ID` int(11) NOT NULL,
  `prod_ID` int(11) DEFAULT NULL,
  `cust_ID` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `totalcost` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_ID`, `prod_ID`, `cust_ID`, `quantity`, `totalcost`, `date`, `time`, `status`) VALUES
(1, 11, 6, 2, 19.98, '2024-04-10', '08:30:00', 'Shipped'),
(2, 13, 7, 1, 7.99, '2024-04-11', '10:15:00', 'Processing'),
(3, 15, 8, 3, 11.97, '2024-04-12', '14:45:00', 'Delivered'),
(4, 18, 9, 2, 12.50, '2024-04-12', '16:30:00', 'Processing'),
(5, 20, 10, 1, 9.99, '2024-04-13', '11:00:00', 'Pending'),
(6, 12, 6, 1, 5.49, '2024-04-14', '09:30:00', 'Pending'),
(7, 14, 7, 2, 25.50, '2024-04-14', '11:45:00', 'Processing'),
(8, 16, 8, 1, 8.49, '2024-04-14', '13:20:00', 'Shipped'),
(9, 17, 9, 3, 44.97, '2024-04-14', '15:10:00', 'Processing'),
(10, 19, 10, 2, 9.58, '2024-04-14', '17:00:00', 'Pending');

--
-- Triggers `orders`
--
DELIMITER $$
CREATE TRIGGER `reduce_stock_after_order` AFTER INSERT ON `orders` FOR EACH ROW BEGIN
    DECLARE ordered_quantity INT;
    DECLARE product_id INT;

    -- Get the ordered quantity and product ID from the new order
    SELECT NEW.quantity, NEW.prod_ID INTO ordered_quantity, product_id FROM orders WHERE order_ID = NEW.order_ID;

    -- Update the stock in the products table
    UPDATE products
    SET ProdStock = ProdStock - ordered_quantity
    WHERE prod_ID = product_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_profit` AFTER INSERT ON `orders` FOR EACH ROW BEGIN
    DECLARE product_price DECIMAL(10,2);
    SET product_price = (SELECT ProdP FROM products WHERE prod_ID = NEW.prod_ID);
    
    UPDATE products
    SET total_profit = total_profit + (product_price * NEW.quantity)
    WHERE prod_ID = NEW.prod_ID;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_spent` AFTER INSERT ON `orders` FOR EACH ROW BEGIN
    UPDATE customers
    SET total_spent = total_spent + NEW.totalcost
    WHERE cust_ID = NEW.cust_ID;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pharmacists`
--

CREATE TABLE `pharmacists` (
  `pharmID` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pharmacists`
--

INSERT INTO `pharmacists` (`pharmID`, `fname`, `lname`, `gender`, `age`, `address`, `email`, `pass`) VALUES
(2, 'Jane', 'Smith', 'Female', 28, '456 Elm St', 'jane@example.com', 'password456'),
(3, 'Michael', 'Johnson', 'Male', 42, '789 Oak St', 'michael@example.com', 'password789'),
(4, 'Emily', 'Brown', 'Female', 31, '101 Pine St', 'emily@example.com', 'password101'),
(5, 'David', 'Wilson', 'Male', 38, '222 Maple St', 'david@example.com', 'password222'),
(11, 'Pharmacist', 'Test1', 'female', 24, 'PTAdd1', 'PT1@gmail.com', 'PT1PASSWORD');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prod_ID` int(11) NOT NULL,
  `prod_Cat` varchar(255) DEFAULT NULL,
  `prod_Name` varchar(255) DEFAULT NULL,
  `prod_Desc` text DEFAULT NULL,
  `ProdP` decimal(10,2) DEFAULT NULL,
  `ProdStock` int(11) DEFAULT NULL,
  `total_profit` decimal(10,2) DEFAULT 0.00,
  `img_path` varchar(125) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prod_ID`, `prod_Cat`, `prod_Name`, `prod_Desc`, `ProdP`, `ProdStock`, `total_profit`, `img_path`) VALUES
(11, 'Pain Relief', 'Ibuprofen Tablets', 'Relieves minor aches and pains caused by various conditions such as headache, toothache, menstrual cramps, muscle aches, or arthritis.', 9.99, 100, 769.23, 'uploads/66306acd201e7_ibuprofentablets.jpg'),
(12, 'Cough & Cold', 'Cough Syrup', 'Provides relief from dry cough, nasal congestion, and throat irritation. Suitable for adults and children above 12 years old.', 5.49, 75, 126.27, 'uploads/66306ada86525_coughsyrup.jpg'),
(13, 'Digestive Health', 'Antacid Tablets', 'Helps relieve heartburn, acid indigestion, and sour stomach. Chewable tablets for easy consumption.', 7.99, 120, 7.99, 'uploads/66306adfa763e_antacidtablets.webp'),
(14, 'Allergy Relief', 'Antihistamine Tablets', 'Temporarily relieves symptoms due to hay fever or other upper respiratory allergies, such as runny nose, sneezing, itching of the nose or throat, and itchy, watery eyes.', 12.75, 100, 25.50, 'uploads/66306aef5021e_antihistaminetablets.jpg'),
(15, 'First Aid', 'Bandages', 'Assorted pack of adhesive bandages for minor cuts, scrapes, and wounds. Waterproof and breathable design for comfortable wear.', 3.99, 200, 11.97, 'uploads/66306af73da55_bandages.avif'),
(16, 'Skin Care', 'Moisturizing Cream', 'Hydrates and soothes dry, rough skin. Suitable for daily use on hands, feet, elbows, and knees.', 8.49, 150, 8.49, 'uploads/66306b03daac2_moisturizingcream.webp'),
(17, 'Vitamins & Supplements', 'Multivitamin Tablets', 'Provides essential vitamins and minerals to support overall health and well-being. Suitable for adults.', 14.99, 80, 44.97, 'uploads/66306b0aaf7a4_multivitamintablets.jpg'),
(18, 'Eye Care', 'Artificial Tears', 'Relieves dryness and irritation of the eyes. Lubricating eye drops for immediate comfort.', 6.25, 100, 12.50, 'uploads/66306b12b33f3_artificialtears.webp'),
(19, 'Oral Care', 'Toothpaste', 'Freshens breath and helps prevent cavities. Fluoride toothpaste for effective oral hygiene.', 4.79, 180, 9.58, 'uploads/66306b1bf39c4_toothpaste.webp'),
(20, 'Baby Care', 'Diaper Rash Cream', 'Protects and soothes baby delicate skin from diaper rash. Pediatrician-recommended formula.', 9.99, 70, 9.99, 'uploads/6630d2512d47c_diaperrashcream.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_ID`),
  ADD KEY `cust_ID` (`cust_ID`),
  ADD KEY `prod_ID` (`prod_ID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cust_ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_ID`),
  ADD KEY `prod_ID` (`prod_ID`),
  ADD KEY `cust_ID` (`cust_ID`);

--
-- Indexes for table `pharmacists`
--
ALTER TABLE `pharmacists`
  ADD PRIMARY KEY (`pharmID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prod_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cust_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pharmacists`
--
ALTER TABLE `pharmacists`
  MODIFY `pharmID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prod_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`cust_ID`) REFERENCES `customers` (`cust_ID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`prod_ID`) REFERENCES `products` (`prod_ID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`prod_ID`) REFERENCES `products` (`prod_ID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`cust_ID`) REFERENCES `customers` (`cust_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
