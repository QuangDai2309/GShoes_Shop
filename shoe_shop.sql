-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 15, 2025 lúc 07:33 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `shoe_shop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`) VALUES
(1, 'Sneaker', 'sneaker', '2025-07-14 09:11:36'),
(2, 'Boot', 'boot', '2025-07-14 09:11:36'),
(3, 'Running', 'running', '2025-07-14 09:11:36'),
(5, 'dai', 'aia', '2025-07-15 14:14:33'),
(7, 'Đại', 'ai', '2025-07-15 14:15:44'),
(8, 'ad', 'ad', '2025-07-15 14:16:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `total` decimal(12,2) NOT NULL,
  `status` enum('pending','paid','shipping','completed','cancelled') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `total`, `status`, `created_at`) VALUES
(1, NULL, 'Đại', 'daitdqps38672@gmail.com', '0986944626', 'ads', 4200000.00, 'pending', '2025-07-15 17:11:20'),
(2, 12, 'Đại', 'daitdqps38672@gmail.com', '0986944626', 'da', 4200000.00, 'pending', '2025-07-15 17:14:09'),
(3, 12, 'Đại', 'daitdqps38672@gmail.com', '986944626', 'dá', 2700000.00, 'completed', '2025-07-15 17:20:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `size_eu` tinyint(3) UNSIGNED NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `qty` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`order_id`, `product_id`, `size_eu`, `price`, `qty`) VALUES
(1, 5, 40, 4200000.00, 1),
(2, 5, 40, 4200000.00, 1),
(3, 6, 39, 2700000.00, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `description` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `sku`, `price`, `description`, `thumbnail`, `created_at`) VALUES
(1, 1, 'Nike Air Force 1', 'AF1-WHT', 2200000.00, NULL, '/images/products/af1.jpeg', '2025-07-14 09:11:43'),
(2, 1, 'Adidas Stan Smith', 'STAN-GRN', 2100000.00, NULL, '/images/products/stan.jpeg', '2025-07-14 09:11:43'),
(3, 2, 'Timberland Boot', 'TMB-YLW', 2800000.00, NULL, '/images/products/timber.jpeg', '2025-07-14 09:15:14'),
(4, 1, 'Giày Thể Thao Nike Air Zoom Pegasus 39', 'NIKE-AZP39', 3200000.00, 'Giày chạy bộ Nike Air Zoom Pegasus 39 siêu nhẹ, đệm êm.', '/images/products/nike_pegasus39.jpg', '2025-07-14 15:53:27'),
(5, 1, 'Giày Thể Thao Adidas Ultraboost 22', 'ADIDAS-UB22', 4200000.00, 'Ultraboost 22 - đế Boost siêu êm, thiết kế năng động.', '/images/products/adidas_ultraboost22.jpg', '2025-07-14 15:53:27'),
(6, 1, 'Giày Thể Thao Puma RS-X³', 'PUMA-RSX3', 2700000.00, 'Puma RS-X³ phối màu hiện đại, cực chất.', '/images/products/puma_rsx3.jpg', '2025-07-14 15:53:27'),
(7, 1, 'Giày Sneaker Converse Chuck Taylor', 'CONVERSE-CT70', 1500000.00, 'Giày sneaker kinh điển Converse Chuck Taylor cổ cao.', '/images/products/converse_ct70.jpg', '2025-07-14 15:53:27'),
(8, 1, 'Giày Tập Gym Reebok Nano X2', 'REEBOK-NANOX2', 2800000.00, 'Reebok Nano X2 bền bỉ, thiết kế hỗ trợ tập gym.', '/images/products/reebok_nanox2.jpg', '2025-07-14 15:53:27'),
(9, 1, 'Giày Casual Vans Old Skool', 'VANS-OS', 1800000.00, 'Giày Vans Old Skool với thiết kế cổ điển.', '/images/products/vans_oldskool.jpg', '2025-07-14 15:53:27'),
(10, 1, 'Giày Lười Skechers GOwalk', 'SKECHERS-GOWALK', 2100000.00, 'Giày lười Skechers thoáng khí, nhẹ nhàng.', '/images/products/skechers_gowalk.jpg', '2025-07-14 15:53:27'),
(11, 1, 'Giày Thể Thao New Balance 574', 'NB-574', 2500000.00, 'New Balance 574 thời trang và thoải mái.', '/images/products/nb_574.jpg', '2025-07-14 15:53:27'),
(12, 1, 'Giày Boot Da Nam Timberland', 'TIMBERLAND-BOOT', 3500000.00, 'Giày boot Timberland da thật, bền chắc.', '/images/products/timberland_boot.jpg', '2025-07-14 15:53:27'),
(13, 3, 'Nike Air Max Dn', 'DV3337-403', 4400000.00, 'giày mới thêm nhe', '/images/products/prd_68766cc448b4a.avif', '2025-07-15 14:59:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `alt_text` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `img_path`, `alt_text`) VALUES
(10, 13, '/uploads/products/prd_68766bcf4920c.jpg', 'Nike Air Max Dn'),
(11, 13, '/uploads/products/prd_68766bcf49361.png', 'Nike Air Max Dn'),
(12, 13, '/uploads/products/prd_68766bcf49436.png', 'Nike Air Max Dn');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_stock`
--

CREATE TABLE `product_stock` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `size_eu` tinyint(3) UNSIGNED NOT NULL,
  `quantity` smallint(5) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_stock`
--

INSERT INTO `product_stock` (`product_id`, `size_eu`, `quantity`) VALUES
(4, 35, 0),
(4, 36, 0),
(4, 37, 0),
(4, 40, 0),
(4, 41, 0),
(4, 42, 0),
(4, 43, 0),
(4, 44, 0),
(4, 45, 0),
(13, 35, 0),
(13, 36, 0),
(13, 38, 0),
(13, 39, 0),
(13, 40, 0),
(13, 41, 0),
(13, 42, 0),
(13, 45, 0),
(5, 40, 3),
(6, 39, 3),
(3, 41, 4),
(4, 39, 5),
(12, 39, 5),
(10, 40, 6),
(2, 40, 7),
(4, 38, 7),
(8, 42, 7),
(11, 42, 7),
(1, 40, 8),
(10, 39, 8),
(5, 41, 9),
(7, 41, 9),
(11, 41, 9),
(9, 38, 10),
(12, 38, 10),
(13, 37, 10),
(13, 43, 10),
(13, 44, 10),
(1, 41, 12),
(6, 40, 12);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` char(255) NOT NULL,
  `name` varchar(120) DEFAULT NULL,
  `role` enum('customer','admin') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_verified` tinyint(1) DEFAULT 0,
  `otp_code` varchar(10) DEFAULT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `role`, `created_at`, `is_verified`, `otp_code`, `reset_token`, `reset_token_expiry`) VALUES
(1, 'daidzpro82@gmail.com', '$2y$10$RIiO.XKUUM551pkepox//OwXPqA37En7IarkQ24gQ3jA7Q/yO3joe', 'Đại', 'admin', '2025-07-14 10:07:41', 1, NULL, NULL, NULL),
(12, 'daitdqps38672@gmail.com', '$2y$10$/LlmKdQu1ogmz4nzbn91KuHxv9XDCL2/zAYMYs7bkthpnGWgZqccq', 'Đại', 'customer', '2025-07-14 15:37:34', 1, NULL, '598f84e1518af88a406187d2c552e680', '2025-07-15 12:10:07');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_id`,`product_id`,`size_eu`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `idx_prod_cat` (`category_id`);

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `product_stock`
--
ALTER TABLE `product_stock`
  ADD PRIMARY KEY (`product_id`,`size_eu`),
  ADD KEY `idx_stock_qty` (`quantity`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_stock`
--
ALTER TABLE `product_stock`
  ADD CONSTRAINT `product_stock_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
