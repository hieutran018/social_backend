-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 21, 2023 at 08:54 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ckc_social`
--

-- create function to generate random UNIX_TIMESTAMP (from-to) for mysql
DROP FUNCTION IF EXISTS RAND_UNIX_TIMESTAMP;
CREATE FUNCTION RAND_UNIX_TIMESTAMP(from_date DATETIME, to_date DATETIME)
RETURNS DATETIME
RETURN (SELECT FROM_UNIXTIME(RAND() * (UNIX_TIMESTAMP(from_date) - UNIX_TIMESTAMP(to_date)) + UNIX_TIMESTAMP(to_date)));

-- create random number function
DROP FUNCTION IF EXISTS RAND_NUMBER;
CREATE FUNCTION RAND_NUMBER(from_number INT, to_number INT)
RETURNS INT
RETURN (SELECT FLOOR(RAND() * (from_number - to_number + 1)) + to_number);

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `displayName`, `email`, `password`, `avatar`, `cover_image`, `date_of_birth`, `sex`, `went_to`, `live_in`, `relationship`, `phone`, `address`, `token`, `device_token`, `email_verified_at`, `created_at`, `updated_at`, `deleted_at`, `isAdmin`) VALUES
(1, 'Chí Hiếu', 'tranduongchihieu@gmail.com', '$2y$10$6dFml3lMiLVezbaKRONpqOw8HVUR6k/UvkrCK8nvhegp0ytIVd7aK', '1689398725KvjGIbhTaJ.jpg', '1689392869cTfXeWB4Du.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-13 16:26:02', '2023-07-13 09:25:44', '2023-07-14 22:25:25', NULL, 1),
(2, 'Lee NGÁO', 'nooneever2504@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-13 16:26:31', '2023-07-13 16:26:31', '2023-07-13 09:26:31', NULL, 0),
(3, 'Tran Duong Chi Hieu', '0306191024@caothang.edu.vn', '$2y$10$6dFml3lMiLVezbaKRONpqOw8HVUR6k/UvkrCK8nvhegp0ytIVd7aK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-13 16:26:02', '2023-07-13 09:25:44', '2023-07-13 09:26:02', NULL, 0),
(4, 'Phạm Hoàng Thư', 'phamhoangthu@gmail.com', '$2y$10$6dFml3lMiLVezbaKRONpqOw8HVUR6k/UvkrCK8nvhegp0ytIVd7aK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-01 01:27:25', '2023-07-01 01:25:44', '2023-07-01 01:27:25', NULL, 0),
(5, 'Đặng Như Gia Nghị', 'gianghi2008@gmail.com', '$2y$10$6dFml3lMiLVezbaKRONpqOw8HVUR6k/UvkrCK8nvhegp0ytIVd7aK', '1689268746qF5nSj3KAw.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-01 11:17:35', '2023-07-01 11:19:48', '2023-07-13 10:19:06', NULL, 0),
(6, 'Lê Thanh Phong', 'phonglethanh@gmail.com', '$2y$10$6dFml3lMiLVezbaKRONpqOw8HVUR6k/UvkrCK8nvhegp0ytIVd7aK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-01 13:20:10', '2023-07-01 13:21:48', '2023-07-01 13:20:10', NULL, 0),
(7, 'Đình Vân', 'dinhvanyako@gmail.com', '$2y$10$6dFml3lMiLVezbaKRONpqOw8HVUR6k/UvkrCK8nvhegp0ytIVd7aK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-08 07:06:10', '2023-07-08 07:05:04', '2023-07-08 07:06:10', NULL, 0),
(8, 'Thủ', '0306191085@caothang.edu.vn', NULL, '1689400109gRQRZJQGtH.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-15 05:40:02', '2023-07-15 05:40:02', '2023-07-14 23:02:39', NULL, 0),
(9, 'Min', '0306201257@caothang.edu.vn', '$2y$10$DAOhrnIBud06IBVkoc.F7e7VpaO4BOoS0taS5VTW5aDCkrJQeCjlq', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-15 05:42:50', '2023-07-14 22:42:27', '2023-07-14 22:42:50', NULL, 0),
(10, 'Phong Nguyễn', 'phong19092001@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-15 06:01:20', '2023-07-15 06:01:20', '2023-07-14 23:01:20', NULL, 0),
(11, 'Anh Huỳnh', 'hnvanh18@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-15 10:19:27', '2023-07-15 10:19:27', '2023-07-15 03:19:27', NULL, 0);


INSERT INTO `albums` (`id`, `album_name`, `user_id`, `privacy`, `isDefault`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Ảnh đại diện', 5, 1, 1, '2023-07-13 17:16:41', NULL, NULL),
(2, 'Ảnh bìa', 1, 1, 1, '2023-07-15 03:47:50', NULL, NULL),
(3, 'Ảnh đại diện', 1, 1, 1, '2023-07-15 05:25:27', NULL, NULL),
(4, 'Ảnh đại diện', 8, 1, 1, '2023-07-15 05:48:30', NULL, NULL),
(5, 'Game chill', 1, 1, 0, '2023-07-15 06:55:01', NULL, NULL);


--
-- Dumping data for table `comment_posts`
--

INSERT INTO `comment_posts` (`id`, `comment_content`, `post_id`, `user_id`, `parent_comment`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'hello', 2, 3, NULL, NULL, '2023-07-13 18:00:02', NULL),
(2, 'my friend', 11, 1, NULL, NULL, '2023-07-14 04:29:29', NULL),
(3, 'brooo', 11, 1, 2, NULL, '2023-07-14 04:29:40', NULL),
(4, 'không sao em à, thua keo này ta bày keo khác @@', 27, 1, NULL, NULL, '2023-07-15 05:48:25', NULL);

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `privacy`, `avatar`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'DATN 2023', 1, NULL, NULL, '2023-07-13 17:33:13', NULL, NULL),
(2, 'VCS meme', 1, NULL, NULL, '2023-07-15 05:13:10', NULL, NULL),
(3, 'Cộng đồng Liên minh huyền thoại Việt Nam', 1, '16893984244mf1L9vAuY.jpg', NULL, '2023-07-15 05:17:36', NULL, NULL),
(4, 'WIBU Chúa', 1, NULL, NULL, '2023-07-15 05:54:40', NULL, NULL);

--
-- Dumping data for table `list_friends`
--

INSERT INTO `list_friends` (`id`, `user_request`, `user_accept`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(1, 2, 1, '2023-07-13 16:26:49', NULL, NULL, 1),
(2, 3, 2, '2023-07-13 16:55:33', NULL, NULL, 1),
(5, 3, 1, '2023-07-13 16:55:33', NULL, NULL, 1),
(6, 1, 7, '2023-07-13 17:13:18', NULL, NULL, 1),
(7, 1, 6, '2023-07-13 17:13:19', NULL, NULL, 1),
(8, 1, 5, '2023-07-13 17:13:20', NULL, NULL, 1),
(9, 1, 4, '2023-07-13 17:13:21', NULL, NULL, 1),
(11, 1, 8, '2023-07-15 05:41:43', NULL, NULL, 1),
(12, 1, 9, '2023-07-15 05:45:59', NULL, NULL, 1),
(13, 1, 11, '2023-07-15 10:20:26', NULL, NULL, 0);


--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `post_content`, `user_id`, `privacy`, `parent_post`, `group_id`, `feel_activity_id`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(1, 'Chao moi nguoi, toi den roi day', 1, 1, NULL, NULL, NULL, '2023-07-13 16:51:37', NULL, NULL, 1),
(2, 'mấy đứa học nguuu sao mà hiểu được', 2, 1, NULL, NULL, NULL, '2023-07-13 16:52:38', NULL, NULL, 1),
(3, 'Chào mọi người!', 4, 1, NULL, NULL, NULL, '2023-07-13 17:14:35', NULL, NULL, 1),
(4, NULL, 4, 1, NULL, NULL, NULL, '2023-07-13 17:15:13', NULL, NULL, 1),
(5, 'Đã cập nhật ảnh đại diện.', 5, 1, NULL, NULL, NULL, '2023-07-13 17:16:40', NULL, NULL, 1),
(6, 'Đã cập nhật ảnh đại diện.', 5, 1, NULL, NULL, NULL, '2023-07-13 17:19:06', NULL, NULL, 1),
(7, 'KT đang vào “phom” lập lại tỉ số ở lượt đi bằng việc đả bại HLE 2-1 tại Tuần 6 LCK Mùa Hè 2023\r\nThắng chín trận liền và chuẩn bị đương đầu với DRX, KT có lẽ sẽ nâng chuỗi lên 10. Thứ Bảy tuần sau, KT (10-1) đụng GEN (11-0) long trời lở đất!', 6, 1, NULL, NULL, NULL, '2023-07-13 17:20:55', NULL, NULL, 1),
(8, 'Phim này cũng hay thật đấy!', 7, 1, NULL, NULL, NULL, '2023-07-13 17:22:31', NULL, '2023-07-13 10:22:53', 1),
(9, NULL, 7, 1, NULL, NULL, NULL, '2023-07-13 17:23:08', NULL, NULL, 1),
(10, NULL, 1, 1, 9, NULL, NULL, '2023-07-13 17:27:20', NULL, NULL, 1),
(11, 'Đã tạo nhóm.', 1, 1, NULL, 1, NULL, '2023-07-13 17:33:13', NULL, NULL, 1),
(12, NULL, 3, 1, NULL, NULL, NULL, '2023-07-13 18:02:45', NULL, NULL, 1),
(13, 'Đã cập nhật ảnh bìa.', 1, 1, NULL, NULL, NULL, '2023-07-15 03:47:49', NULL, NULL, 1),
(14, 'Đã tạo nhóm.', 6, 1, NULL, 2, NULL, '2023-07-15 05:13:10', NULL, NULL, 1),
(15, 'Cuộc đối đầu giữa Hasmed và Kiaya trong trận đấu tối nay 😳 Liệu ai sẽ là người Gánh Team hay là người Gánh Nặng sẽ được quyết định 🐧💪', 6, 1, NULL, 2, NULL, '2023-07-15 05:15:14', NULL, NULL, 1),
(16, 'Đã tạo nhóm.', 1, 1, NULL, 3, NULL, '2023-07-15 05:17:36', NULL, NULL, 1),
(17, 'Đã cập nhật ảnh của nhóm.', 1, 1, NULL, 3, NULL, '2023-07-15 05:20:24', NULL, NULL, 1),
(18, 'Chào mừng đến với ngồi nhà mới của cộng đồng Liên Minh Huyền Thoại!', 1, 1, NULL, 3, NULL, '2023-07-15 05:21:34', NULL, NULL, 1),
(19, '- Các tướng liên minh qua bàn tay của các Fap sư TQ !?! 🔥 \r\nC : in pic', 1, 1, NULL, 3, NULL, '2023-07-15 05:24:28', NULL, NULL, 1),
(20, 'Đã cập nhật ảnh đại diện.', 1, 1, NULL, NULL, NULL, '2023-07-15 05:25:26', NULL, NULL, 1),
(21, 'số 6 kiểu: nước đi này hơi sai, cho mình đi lại nha 🥹', 4, 1, NULL, NULL, NULL, '2023-07-15 05:34:24', NULL, NULL, 1),
(22, 'Hôm nay tôi buồn một mình trên phố đông', 8, 1, NULL, NULL, 1, '2023-07-15 05:40:33', NULL, NULL, 1),
(23, 'Cay lắm friend ơi !!!', 8, 1, NULL, NULL, NULL, '2023-07-15 05:45:51', NULL, NULL, 1),
(24, 'Đếu thuốc tàn bên ly cafe cạn\r\nThấy trong đầu có hàng vạn suy tư\r\nNhấc bút lên ta cố viết mấy từ\r\nMượn dòng thơ để rửa trôi suy nghĩ\r\nCuộc đời kia sao mà quá vô vị', 8, 1, NULL, NULL, NULL, '2023-07-15 05:47:27', NULL, NULL, 1),
(25, 'đang đi làm', 9, 1, NULL, NULL, NULL, '2023-07-15 05:47:37', NULL, NULL, 1),
(26, 'học ckc', 9, 1, NULL, NULL, NULL, '2023-07-15 05:47:48', NULL, NULL, 1),
(27, 'rớt hqt csdl rồi', 9, 1, NULL, NULL, NULL, '2023-07-15 05:48:06', NULL, NULL, 1),
(28, 'Đã cập nhật ảnh đại diện.', 8, 1, NULL, NULL, NULL, '2023-07-15 05:48:29', NULL, NULL, 1),
(29, 'abc', 9, 1, NULL, NULL, NULL, '2023-07-15 05:48:30', NULL, NULL, 1),
(30, 'đang rãnh', 9, 1, NULL, NULL, NULL, '2023-07-15 05:48:47', NULL, NULL, 1),
(31, 'Tiền không mua được tất cả nhưng không có tiền thì vất vả, thế thôi.', 8, 1, NULL, NULL, NULL, '2023-07-15 05:50:17', NULL, NULL, 1),
(32, 'Mãi iuuuuu', 8, 1, NULL, NULL, NULL, '2023-07-15 05:50:58', NULL, NULL, 1),
(33, 'Đã tạo nhóm.', 8, 1, NULL, 4, NULL, '2023-07-15 05:54:40', NULL, NULL, 1),
(34, 'hom nay troi dep', 10, 1, NULL, NULL, NULL, '2023-07-15 06:01:38', NULL, NULL, 1),
(35, 'buon qua', 10, 1, NULL, NULL, NULL, '2023-07-15 06:02:10', NULL, NULL, 1),
(36, 'huhhuuh', 10, 1, NULL, NULL, NULL, '2023-07-15 06:02:21', NULL, NULL, 1),
(37, NULL, 1, 1, 31, NULL, NULL, '2023-07-15 06:18:35', NULL, NULL, 1),
(38, 'Ay-yo', 8, 1, NULL, NULL, NULL, '2023-07-15 06:19:07', NULL, NULL, 1),
(39, 'Mấy đứa ổn không', 1, 1, NULL, NULL, NULL, '2023-07-15 06:22:05', NULL, NULL, 1),
(40, NULL, 1, 1, NULL, NULL, NULL, '2023-07-15 06:50:59', NULL, NULL, 1),
(41, NULL, 1, 1, 24, NULL, NULL, '2023-07-15 06:51:57', NULL, NULL, 1),
(42, 'Đã tạo một album ảnh mới.', 1, 1, NULL, NULL, NULL, '2023-07-15 06:55:01', NULL, NULL, 1);

--
-- Dumping data for table `media_file_posts`
--

INSERT INTO `media_file_posts` (`id`, `media_file_name`, `media_type`, `post_id`, `user_id`, `group_id`, `post_history_id`, `isAvatar`, `isCover`, `album_id`, `status`, `created_at`, `updated_at`) VALUES
(1, '1689267098QCdapyjxAt.jpg', 'jpg', 1, 1, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-13 16:51:38', NULL),
(2, '1689267158Nhfp8ySCxj.jpg', 'jpg', 2, 2, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-13 16:52:38', NULL),
(3, '1689268513kjRNJh3oWL.jpg', 'jpg', 4, 4, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-13 17:15:13', NULL),
(4, '1689268600fUNiYKFxnz.jpg', 'jpg', 5, 5, NULL, NULL, 1, NULL, 1, 1, '2023-07-13 17:16:41', NULL),
(5, '1689268746qF5nSj3KAw.png', 'png', 6, 5, NULL, NULL, 1, NULL, 1, 1, '2023-07-13 17:19:06', NULL),
(6, '1689268855xeANsmCQaw.jpg', 'jpg', 7, 6, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-13 17:20:55', NULL),
(9, '1689268951TiXZCo5tYw.jpg', 'jpg', 8, 7, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-13 17:22:31', NULL),
(10, '168926895115RxCb7deq.jpg', 'jpg', 8, 7, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-13 17:22:31', NULL),
(12, '1689268989UQ9vWwBaXs.jpg', 'jpg', 9, 7, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-13 17:23:09', NULL),
(13, '168926898986osbQj1sj.jpg', 'jpg', 9, 7, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-13 17:23:09', NULL),
(14, '1689268989y6Pq7zY5uw.jpg', 'jpg', 9, 7, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-13 17:23:09', NULL),
(15, '1689392869cTfXeWB4Du.jpg', 'jpg', 13, 1, NULL, NULL, NULL, 1, 2, 1, '2023-07-15 03:47:50', NULL),
(16, '16893981153MMUbFpSEd.jpg', 'jpg', 15, 6, 2, NULL, NULL, NULL, NULL, 1, '2023-07-15 05:15:15', NULL),
(17, '16893984244mf1L9vAuY.jpg', 'jpg', 17, 1, 3, NULL, NULL, NULL, NULL, 1, '2023-07-15 05:20:24', NULL),
(18, '1689398495dDcFjeso0O.jpg', 'jpg', 18, 1, 3, NULL, NULL, NULL, NULL, 1, '2023-07-15 05:21:35', NULL),
(19, '1689398668dblBmKiw2r.jpg', 'jpg', 19, 1, 3, NULL, NULL, NULL, NULL, 1, '2023-07-15 05:24:28', NULL),
(20, '1689398668IRjPVdVcSO.jpg', 'jpg', 19, 1, 3, NULL, NULL, NULL, NULL, 1, '2023-07-15 05:24:28', NULL),
(21, '1689398668n5PU9lxUd3.jpg', 'jpg', 19, 1, 3, NULL, NULL, NULL, NULL, 1, '2023-07-15 05:24:28', NULL),
(22, '1689398668cbwzemJJgs.jpg', 'jpg', 19, 1, 3, NULL, NULL, NULL, NULL, 1, '2023-07-15 05:24:28', NULL),
(23, '1689398668XcDvDuEq74.jpg', 'jpg', 19, 1, 3, NULL, NULL, NULL, NULL, 1, '2023-07-15 05:24:28', NULL),
(24, '1689398725KvjGIbhTaJ.jpg', 'jpg', 20, 1, NULL, NULL, 1, NULL, 3, 1, '2023-07-15 05:25:28', NULL),
(25, '16893992641Hv0HP12VK.jpg', 'jpg', 21, 4, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-15 05:34:24', NULL),
(26, '1689399951M5AHtWnn5X.jpg', 'jpg', 23, 8, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-15 05:45:51', NULL),
(27, '1689400047fRn8sr6PZ2.jpg', 'jpg', 24, 8, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-15 05:47:27', NULL),
(28, '1689400109gRQRZJQGtH.png', 'png', 28, 8, NULL, NULL, 1, NULL, 4, 1, '2023-07-15 05:48:30', NULL),
(29, '1689400218tYGZ8zoBiH.jpg', 'jpg', 31, 8, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-15 05:50:18', NULL),
(30, '1689400259mdEIE9gE1t.jpg', 'jpg', 32, 8, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-15 05:50:59', NULL),
(31, '1689403860lMSTiI8LL3.jpg', 'jpg', 40, 1, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-15 06:51:00', NULL),
(32, '1689404101jUscyTXaQF.jpg', 'jpg', 42, 1, NULL, NULL, NULL, NULL, 5, 1, '2023-07-15 06:55:01', NULL),
(33, '1689404101aB4KSKIIKf.jpg', 'jpg', 42, 1, NULL, NULL, NULL, NULL, 5, 1, '2023-07-15 06:55:01', NULL),
(34, '168940410157NRdKwj83.jpg', 'jpg', 42, 1, NULL, NULL, NULL, NULL, 5, 1, '2023-07-15 06:55:01', NULL),
(35, '168940410127nMMU3zbn.jpg', 'jpg', 42, 1, NULL, NULL, NULL, NULL, 5, 1, '2023-07-15 06:55:01', NULL);

--
-- Dumping data for table `member_groups`
--

INSERT INTO `member_groups` (`id`, `user_id`, `group_id`, `isAdminGroup`, `isAccept`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, NULL, 1, '2023-07-13 17:33:13', NULL, NULL),
(2, 2, 1, 0, NULL, 1, '2023-07-13 17:34:07', NULL, NULL),
(3, 6, 2, 1, NULL, 1, '2023-07-15 05:13:10', NULL, NULL),
(4, 1, 3, 1, NULL, 1, '2023-07-15 05:17:36', NULL, NULL),
(6, 3, 3, 0, NULL, 1, '2023-07-15 05:21:41', NULL, NULL),
(7, 7, 3, 0, NULL, 1, '2023-07-15 05:21:41', NULL, NULL),
(8, 6, 3, 0, NULL, 1, '2023-07-15 05:21:42', NULL, NULL),
(9, 5, 3, 0, NULL, 1, '2023-07-15 05:21:43', NULL, NULL),
(10, 4, 3, 0, NULL, 1, '2023-07-15 05:21:44', NULL, NULL),
(11, 8, 4, 1, NULL, 1, '2023-07-15 05:54:40', NULL, NULL),
(12, 1, 4, 0, NULL, 2, '2023-07-15 05:54:47', NULL, NULL);


--
-- Dumping data for table `social_accounts`
--

INSERT INTO `social_accounts` (`id`, `provider`, `provider_id`, `email`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'google.com', 'KsQoSiuCESNd1xIwnAiTVqQhsUi1', 'nooneever2504@gmail.com', 2, '2023-07-13 16:26:31', '2023-07-13 09:26:31'),
(2, 'google.com', 'NEAFpVY0CJhexnhJa2J36xw2CIG2', '0306191085@caothang.edu.vn', 8, '2023-07-15 05:40:02', '2023-07-14 22:40:02'),
(3, 'google.com', 'oIPuOw5fLSV6SqdZ83ZU4WeObg92', 'phong19092001@gmail.com', 10, '2023-07-15 06:01:20', '2023-07-14 23:01:20'),
(4, 'google.com', 'cpxTY9lLLYbnVjFr6DHnUkLnboj2', 'hnvanh18@gmail.com', 11, '2023-07-15 10:19:27', '2023-07-15 03:19:27');



INSERT INTO `stories` (`id`, `expiration_timestamp`, `user_id`, `viewer_count`, `type`, `file_name_story`, `created_at`, `updated_at`) VALUES
(1, '2023-07-13 23:52:59', 1, 0, 'image', '1689267179MHJDjZqYxf.jpg', '2023-07-13 16:52:59', '2023-07-13 09:52:59'),
(2, '2023-07-13 23:53:14', 2, 0, 'image', '16892671947lQgSnCs4e.jpg', '2023-07-13 16:53:14', '2023-07-13 09:53:14'),
(3, '2023-07-14 00:03:55', 1, 0, 'video', '1689267835jRrTqix7qm.mp4', '2023-07-13 17:03:55', '2023-07-13 10:03:55'),
(4, '2023-07-14 00:04:26', 3, 0, 'video', NULL, '2023-07-13 17:04:26', '2023-07-13 10:04:26'),
(5, '2023-07-14 00:14:22', 4, 0, 'image', '1689268462eezgI2Cf12.jpg', '2023-07-13 17:14:22', '2023-07-13 10:14:22'),
(6, '2023-07-14 00:16:15', 5, 0, 'image', '1689268575XYwVd4UQiy.png', '2023-07-13 17:16:15', '2023-07-13 10:16:15'),
(7, '2023-07-14 00:23:37', 7, 0, 'image', '1689269017WfwaPzUzXA.jpg', '2023-07-13 17:23:37', '2023-07-13 10:23:37'),
(8, '2023-07-14 00:25:27', 3, 0, 'image', '1689269127R3eGR7APri.jpg', '2023-07-13 17:25:27', '2023-07-13 10:25:27'),
(9, '2023-07-15 12:16:27', 6, 0, 'image', '1689398187QslHNZMUVV.jpg', '2023-07-15 05:16:27', '2023-07-14 22:16:27'),
(10, '2023-07-15 12:41:39', 8, 0, 'image', '1689399699UEnsLlcDQP.jpg', '2023-07-15 05:41:39', '2023-07-14 22:41:39'),
(11, '2023-07-15 14:33:54', 1, 0, 'image', '1689406434K0wdBbvBo2.jpg', '2023-07-15 07:33:54', '2023-07-15 00:33:54');



INSERT INTO `feeling_and_activity_posts` (`id`, `icon_name`, `patch`, `status`, `created_at`, `updated_at`) VALUES
(1, 'tức giận', '1689270943YlDHejTp5j.png', 1, '2023-07-13 17:55:43', NULL);


INSERT INTO `conversations` (`id`, `conversation_name`, `conversation_type`, `user_one`, `user_two`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 0, 2, 1, '2023-07-13 09:27:34', '2023-07-13 09:27:34', NULL),
(2, NULL, 0, 3, 1, '2023-07-13 10:06:41', '2023-07-13 10:06:41', NULL),
(3, NULL, 0, 1, 8, '2023-07-14 23:07:24', '2023-07-14 23:07:24', NULL),
(4, NULL, 0, 1, 4, '2023-07-14 23:51:29', '2023-07-14 23:51:29', NULL);

INSERT INTO `media_file_messages` (`id`, `media_file_name`, `media_type`, `message_id`, `conversation_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '1689401730ZIG5Qg9dXW.jpg', 'jpg', 24, 3, 1, '2023-07-15 06:15:30', NULL);



INSERT INTO `messages` (`id`, `user_id`, `conversation_id`, `content`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, 'hello', '2023-07-13 16:27:49', '2023-07-13 09:27:49', NULL),
(2, 1, 1, '?', '2023-07-13 16:27:58', '2023-07-13 09:27:58', NULL),
(3, 1, 1, 'Ban la ai z', '2023-07-13 16:28:07', '2023-07-13 09:28:07', NULL),
(4, 2, 1, 'toi ne', '2023-07-13 16:28:15', '2023-07-13 09:28:15', NULL),
(5, 2, 1, 'ngoi cung ban voi ban day', '2023-07-13 16:28:20', '2023-07-13 09:28:20', NULL),
(6, 2, 1, ':))', '2023-07-13 16:28:22', '2023-07-13 09:28:22', NULL),
(7, 3, 2, 'Chào bạn nhé.', '2023-07-13 10:06:41', '2023-07-13 10:06:41', NULL),
(8, 1, 2, 'chào', '2023-07-13 17:07:17', '2023-07-13 10:07:17', NULL),
(9, 1, 3, 'hi', '2023-07-15 06:07:29', '2023-07-14 23:07:29', NULL),
(10, 1, 3, 'thủ', '2023-07-15 06:08:02', '2023-07-14 23:08:02', NULL),
(11, 1, 3, 'm đâu rồi', '2023-07-15 06:08:06', '2023-07-14 23:08:06', NULL),
(12, 1, 3, 'alo', '2023-07-15 06:08:21', '2023-07-14 23:08:21', NULL),
(13, 1, 3, 'có đó không vậy ?', '2023-07-15 06:08:26', '2023-07-14 23:08:26', NULL),
(14, 1, 3, 'alo', '2023-07-15 06:10:29', '2023-07-14 23:10:29', NULL),
(15, 1, 3, 'thủ', '2023-07-15 06:12:06', '2023-07-14 23:12:06', NULL),
(16, 8, 3, 'có', '2023-07-15 06:12:15', '2023-07-14 23:12:15', NULL),
(17, 8, 3, 'M đâu', '2023-07-15 06:12:18', '2023-07-14 23:12:18', NULL),
(18, 1, 3, 'nghe rõ không', '2023-07-15 06:12:23', '2023-07-14 23:12:23', NULL),
(19, 1, 3, 'hơi to', '2023-07-15 06:12:28', '2023-07-14 23:12:28', NULL),
(20, 1, 3, '@@', '2023-07-15 06:12:29', '2023-07-14 23:12:29', NULL),
(21, 8, 3, 'Ồn quá', '2023-07-15 06:13:02', '2023-07-14 23:13:02', NULL),
(22, 8, 3, 'Tml ơi', '2023-07-15 06:13:05', '2023-07-14 23:13:05', NULL),
(23, 8, 3, 'ay-ya', '2023-07-15 06:13:15', '2023-07-14 23:13:15', NULL),
(24, 1, 3, NULL, '2023-07-15 06:15:30', '2023-07-14 23:15:30', NULL);



INSERT INTO `notifications` (`id`, `to`, `from`, `title`, `unread`, `object_type`, `object_id`, `icon_url`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'đã gửi cho bạn lời mời kết bạn.', 1, 'FrInvitation', 1, 'icon.png', '2023-07-13 16:26:49', NULL),
(2, 2, 1, 'đã chấp nhận yêu cầu kết bạn.', 1, 'FrAccept', 1, 'icon.png', '2023-07-13 16:27:05', NULL),
(3, 2, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 1, 'icon.png', '2023-07-13 16:51:37', NULL),
(4, 1, 2, 'đã đăng một bài viết mới.', 1, 'crPost', 2, 'icon.png', '2023-07-13 16:52:38', NULL),
(5, 2, 1, 'đã đăng bản tin mới.', 1, 'crStory', 1, 'icon.png', '2023-07-13 16:52:59', NULL),
(6, 1, 2, 'đã đăng bản tin mới.', 1, 'crStory', 2, 'icon.png', '2023-07-13 16:53:14', NULL),
(7, 2, 3, 'đã gửi cho bạn lời mời kết bạn.', 1, 'FrInvitation', 2, 'icon.png', '2023-07-13 16:55:33', NULL),
(8, 3, 1, 'đã gửi cho bạn lời mời kết bạn.', 1, 'FrInvitation', 3, 'icon.png', '2023-07-13 16:56:16', NULL),
(9, 2, 1, 'đã gửi cho bạn lời mời kết bạn.', 1, 'FrInvitation', 4, 'icon.png', '2023-07-13 16:56:17', NULL),
(10, 1, 3, 'đã chấp nhận yêu cầu kết bạn.', 1, 'FrAccept', 3, 'icon.png', '2023-07-13 16:56:27', NULL),
(11, 2, 1, 'đã đăng bản tin mới.', 1, 'crStory', 3, 'icon.png', '2023-07-13 17:03:55', NULL),
(12, 3, 1, 'đã đăng bản tin mới.', 1, 'crStory', 3, 'icon.png', '2023-07-13 17:03:56', NULL),
(13, 2, 3, 'đã đăng bản tin mới.', 1, 'crStory', 4, 'icon.png', '2023-07-13 17:04:26', NULL),
(14, 1, 3, 'đã đăng bản tin mới.', 1, 'crStory', 4, 'icon.png', '2023-07-13 17:04:27', NULL),
(15, 7, 1, 'đã gửi cho bạn lời mời kết bạn.', 1, 'FrInvitation', 6, 'icon.png', '2023-07-13 17:13:18', NULL),
(16, 6, 1, 'đã gửi cho bạn lời mời kết bạn.', 1, 'FrInvitation', 7, 'icon.png', '2023-07-13 17:13:19', NULL),
(17, 5, 1, 'đã gửi cho bạn lời mời kết bạn.', 1, 'FrInvitation', 8, 'icon.png', '2023-07-13 17:13:20', NULL),
(18, 4, 1, 'đã gửi cho bạn lời mời kết bạn.', 1, 'FrInvitation', 9, 'icon.png', '2023-07-13 17:13:21', NULL),
(19, 3, 1, 'đã gửi cho bạn lời mời kết bạn.', 1, 'FrInvitation', 10, 'icon.png', '2023-07-13 17:13:23', NULL),
(20, 1, 4, 'đã đăng bản tin mới.', 1, 'crStory', 5, 'icon.png', '2023-07-13 17:14:22', NULL),
(21, 1, 4, 'đã đăng một bài viết mới.', 1, 'crPost', 3, 'icon.png', '2023-07-13 17:14:35', NULL),
(22, 1, 4, 'đã đăng một bài viết mới.', 1, 'crPost', 4, 'icon.png', '2023-07-13 17:15:13', NULL),
(23, 1, 5, 'đã đăng bản tin mới.', 1, 'crStory', 6, 'icon.png', '2023-07-13 17:16:15', NULL),
(24, 1, 5, 'đã đăng một bài viết mới.', 1, 'crPost', 5, 'icon.png', '2023-07-13 17:16:40', NULL),
(25, 1, 5, 'đã đăng một bài viết mới.', 1, 'crPost', 6, 'icon.png', '2023-07-13 17:19:06', NULL),
(26, 1, 6, 'đã đăng một bài viết mới.', 1, 'crPost', 7, 'icon.png', '2023-07-13 17:20:55', NULL),
(27, 1, 7, 'đã đăng một bài viết mới.', 1, 'crPost', 8, 'icon.png', '2023-07-13 17:22:31', NULL),
(28, 1, 7, 'đã đăng một bài viết mới.', 1, 'crPost', 9, 'icon.png', '2023-07-13 17:23:08', NULL),
(29, 1, 7, 'đã đăng bản tin mới.', 1, 'crStory', 7, 'icon.png', '2023-07-13 17:23:37', NULL),
(30, 2, 3, 'đã đăng bản tin mới.', 1, 'crStory', 8, 'icon.png', '2023-07-13 17:25:27', NULL),
(31, 1, 3, 'đã đăng bản tin mới.', 1, 'crStory', 8, 'icon.png', '2023-07-13 17:25:28', NULL),
(32, 2, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 10, 'icon.png', '2023-07-13 17:27:20', NULL),
(33, 3, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 10, 'icon.png', '2023-07-13 17:27:20', NULL),
(34, 7, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 10, 'icon.png', '2023-07-13 17:27:20', NULL),
(35, 6, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 10, 'icon.png', '2023-07-13 17:27:20', NULL),
(36, 5, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 10, 'icon.png', '2023-07-13 17:27:20', NULL),
(37, 4, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 10, 'icon.png', '2023-07-13 17:27:20', NULL),
(38, 2, 3, 'đã bình luận về bài viết của bạn.', 1, 'comment', 2, 'icon.png', '2023-07-13 18:00:02', NULL),
(39, 2, 3, 'đã đăng một bài viết mới.', 1, 'crPost', 12, 'icon.png', '2023-07-13 18:02:45', NULL),
(40, 1, 3, 'đã đăng một bài viết mới.', 1, 'crPost', 12, 'icon.png', '2023-07-13 18:02:46', NULL),
(41, 1, 1, 'đã bình luận về bài viết của bạn.', 1, 'comment', 11, 'icon.png', '2023-07-14 04:29:29', NULL),
(42, 2, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 13, 'icon.png', '2023-07-15 03:47:49', NULL),
(43, 3, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 13, 'icon.png', '2023-07-15 03:47:49', NULL),
(44, 7, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 13, 'icon.png', '2023-07-15 03:47:49', NULL),
(45, 6, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 13, 'icon.png', '2023-07-15 03:47:49', NULL),
(46, 5, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 13, 'icon.png', '2023-07-15 03:47:49', NULL),
(47, 4, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 13, 'icon.png', '2023-07-15 03:47:50', NULL),
(48, 1, 6, 'đã đăng một bài viết mới.', 1, 'crPost', 15, 'icon.png', '2023-07-15 05:15:14', NULL),
(49, 1, 6, 'đã đăng bản tin mới.', 1, 'crStory', 9, 'icon.png', '2023-07-15 05:16:27', NULL),
(50, 6, 1, 'đã bày tỏ cảm xúc về bài viết của bạn', 1, 'reaction', 15, 'icon.png', '2023-07-15 05:16:53', NULL),
(51, 2, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 18, 'icon.png', '2023-07-15 05:21:34', NULL),
(52, 3, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 18, 'icon.png', '2023-07-15 05:21:34', NULL),
(53, 7, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 18, 'icon.png', '2023-07-15 05:21:34', NULL),
(54, 6, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 18, 'icon.png', '2023-07-15 05:21:34', NULL),
(55, 5, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 18, 'icon.png', '2023-07-15 05:21:35', NULL),
(56, 4, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 18, 'icon.png', '2023-07-15 05:21:35', NULL),
(57, 2, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 19, 'icon.png', '2023-07-15 05:24:28', NULL),
(58, 3, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 19, 'icon.png', '2023-07-15 05:24:28', NULL),
(59, 7, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 19, 'icon.png', '2023-07-15 05:24:28', NULL),
(60, 6, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 19, 'icon.png', '2023-07-15 05:24:28', NULL),
(61, 5, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 19, 'icon.png', '2023-07-15 05:24:28', NULL),
(62, 4, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 19, 'icon.png', '2023-07-15 05:24:28', NULL),
(63, 2, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 20, 'icon.png', '2023-07-15 05:25:26', NULL),
(64, 3, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 20, 'icon.png', '2023-07-15 05:25:26', NULL),
(65, 7, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 20, 'icon.png', '2023-07-15 05:25:27', NULL),
(66, 6, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 20, 'icon.png', '2023-07-15 05:25:27', NULL),
(67, 5, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 20, 'icon.png', '2023-07-15 05:25:27', NULL),
(68, 4, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 20, 'icon.png', '2023-07-15 05:25:27', NULL),
(69, 1, 4, 'đã đăng một bài viết mới.', 1, 'crPost', 21, 'icon.png', '2023-07-15 05:34:24', NULL),
(70, 8, 1, 'đã gửi cho bạn lời mời kết bạn.', 1, 'FrInvitation', 11, 'icon.png', '2023-07-15 05:41:43', NULL),
(71, 1, 8, 'đã chấp nhận yêu cầu kết bạn.', 1, 'FrAccept', 11, 'icon.png', '2023-07-15 05:41:51', NULL),
(72, 1, 8, 'đã chấp nhận yêu cầu kết bạn.', 1, 'FrAccept', 11, 'icon.png', '2023-07-15 05:42:00', NULL),
(73, 1, 8, 'đã đăng một bài viết mới.', 1, 'crPost', 23, 'icon.png', '2023-07-15 05:45:51', NULL),
(74, 9, 1, 'đã gửi cho bạn lời mời kết bạn.', 1, 'FrInvitation', 12, 'icon.png', '2023-07-15 05:45:59', NULL),
(75, 1, 8, 'đã đăng một bài viết mới.', 1, 'crPost', 24, 'icon.png', '2023-07-15 05:47:27', NULL),
(76, 1, 9, 'đã đăng một bài viết mới.', 1, 'crPost', 26, 'icon.png', '2023-07-15 05:47:48', NULL),
(77, 1, 9, 'đã đăng một bài viết mới.', 1, 'crPost', 27, 'icon.png', '2023-07-15 05:48:06', NULL),
(78, 9, 1, 'đã bình luận về bài viết của bạn.', 1, 'comment', 27, 'icon.png', '2023-07-15 05:48:25', NULL),
(79, 1, 8, 'đã đăng một bài viết mới.', 1, 'crPost', 28, 'icon.png', '2023-07-15 05:48:29', NULL),
(80, 1, 9, 'đã đăng một bài viết mới.', 1, 'crPost', 29, 'icon.png', '2023-07-15 05:48:30', NULL),
(81, 1, 9, 'đã đăng một bài viết mới.', 1, 'crPost', 30, 'icon.png', '2023-07-15 05:48:47', NULL),
(82, 1, 8, 'đã đăng một bài viết mới.', 1, 'crPost', 31, 'icon.png', '2023-07-15 05:50:17', NULL),
(83, 1, 8, 'đã đăng một bài viết mới.', 1, 'crPost', 32, 'icon.png', '2023-07-15 05:50:58', NULL),
(84, 2, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 37, 'icon.png', '2023-07-15 06:18:35', NULL),
(85, 3, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 37, 'icon.png', '2023-07-15 06:18:35', NULL),
(86, 7, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 37, 'icon.png', '2023-07-15 06:18:35', NULL),
(87, 6, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 37, 'icon.png', '2023-07-15 06:18:36', NULL),
(88, 5, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 37, 'icon.png', '2023-07-15 06:18:36', NULL),
(89, 4, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 37, 'icon.png', '2023-07-15 06:18:36', NULL),
(90, 8, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 37, 'icon.png', '2023-07-15 06:18:36', NULL),
(91, 9, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 37, 'icon.png', '2023-07-15 06:18:36', NULL),
(92, 1, 8, 'đã đăng một bài viết mới.', 1, 'crPost', 38, 'icon.png', '2023-07-15 06:19:07', NULL),
(93, 2, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 39, 'icon.png', '2023-07-15 06:22:05', NULL),
(94, 3, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 39, 'icon.png', '2023-07-15 06:22:06', NULL),
(95, 7, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 39, 'icon.png', '2023-07-15 06:22:06', NULL),
(96, 6, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 39, 'icon.png', '2023-07-15 06:22:06', NULL),
(97, 5, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 39, 'icon.png', '2023-07-15 06:22:06', NULL),
(98, 4, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 39, 'icon.png', '2023-07-15 06:22:06', NULL),
(99, 8, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 39, 'icon.png', '2023-07-15 06:22:06', NULL),
(100, 9, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 39, 'icon.png', '2023-07-15 06:22:06', NULL),
(101, 2, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 40, 'icon.png', '2023-07-15 06:50:59', NULL),
(102, 3, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 40, 'icon.png', '2023-07-15 06:50:59', NULL),
(103, 7, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 40, 'icon.png', '2023-07-15 06:50:59', NULL),
(104, 6, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 40, 'icon.png', '2023-07-15 06:50:59', NULL),
(105, 5, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 40, 'icon.png', '2023-07-15 06:50:59', NULL),
(106, 4, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 40, 'icon.png', '2023-07-15 06:50:59', NULL),
(107, 8, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 40, 'icon.png', '2023-07-15 06:51:00', NULL),
(108, 9, 1, 'đã đăng một bài viết mới.', 1, 'crPost', 40, 'icon.png', '2023-07-15 06:51:00', NULL),
(109, 2, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 41, 'icon.png', '2023-07-15 06:51:57', NULL),
(110, 3, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 41, 'icon.png', '2023-07-15 06:51:57', NULL),
(111, 7, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 41, 'icon.png', '2023-07-15 06:51:57', NULL),
(112, 6, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 41, 'icon.png', '2023-07-15 06:51:57', NULL),
(113, 5, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 41, 'icon.png', '2023-07-15 06:51:57', NULL),
(114, 4, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 41, 'icon.png', '2023-07-15 06:51:57', NULL),
(115, 8, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 41, 'icon.png', '2023-07-15 06:51:57', NULL),
(116, 9, 1, 'đã chia sẻ bài viết của bạn.', 1, 'crPost', 41, 'icon.png', '2023-07-15 06:51:57', NULL),
(117, 2, 1, 'đã đăng bản tin mới.', 1, 'crStory', 11, 'icon.png', '2023-07-15 07:33:54', NULL),
(118, 3, 1, 'đã đăng bản tin mới.', 1, 'crStory', 11, 'icon.png', '2023-07-15 07:33:55', NULL),
(119, 7, 1, 'đã đăng bản tin mới.', 1, 'crStory', 11, 'icon.png', '2023-07-15 07:33:55', NULL),
(120, 6, 1, 'đã đăng bản tin mới.', 1, 'crStory', 11, 'icon.png', '2023-07-15 07:33:55', NULL),
(121, 5, 1, 'đã đăng bản tin mới.', 1, 'crStory', 11, 'icon.png', '2023-07-15 07:33:55', NULL),
(122, 4, 1, 'đã đăng bản tin mới.', 1, 'crStory', 11, 'icon.png', '2023-07-15 07:33:55', NULL),
(123, 8, 1, 'đã đăng bản tin mới.', 1, 'crStory', 11, 'icon.png', '2023-07-15 07:33:55', NULL),
(124, 9, 1, 'đã đăng bản tin mới.', 1, 'crStory', 11, 'icon.png', '2023-07-15 07:33:55', NULL),
(125, 11, 1, 'đã gửi cho bạn lời mời kết bạn.', 1, 'FrInvitation', 13, 'icon.png', '2023-07-15 10:20:26', NULL);



INSERT INTO `participant` (`id`, `user_id`, `conversation_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2023-07-13 09:27:34', '2023-07-13 09:27:34', NULL),
(2, 2, 1, '2023-07-13 09:27:34', '2023-07-13 09:27:34', NULL),
(3, 3, 2, '2023-07-13 10:06:41', '2023-07-13 10:06:41', NULL),
(4, 1, 2, '2023-07-13 10:06:41', '2023-07-13 10:06:41', NULL),
(5, 8, 3, '2023-07-14 23:07:24', '2023-07-14 23:07:24', NULL),
(6, 1, 3, '2023-07-14 23:07:24', '2023-07-14 23:07:24', NULL),
(7, 4, 4, '2023-07-14 23:51:29', '2023-07-14 23:51:29', NULL),
(8, 1, 4, '2023-07-14 23:51:29', '2023-07-14 23:51:29', NULL);



INSERT INTO `post_histories` (`id`, `post_id`, `post_content`, `user_id`, `privacy`, `parent_post`, `group_id`, `feel_activity_id`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(1, 8, 'Phim này cũng hay thật đấy!', 7, 1, NULL, NULL, NULL, '2023-07-13 17:22:47', NULL, NULL, 1),
(2, 9, NULL, 7, 1, NULL, NULL, NULL, '2023-07-13 17:23:20', NULL, NULL, 1);



INSERT INTO `post_tags` (`id`, `user_id`, `post_id`, `created_at`, `updated_at`) VALUES
(1, 1, 38, NULL, NULL),
(2, 8, 39, NULL, NULL),
(3, 3, 39, NULL, NULL),
(4, 4, 40, NULL, NULL);



INSERT INTO `reports` (`id`, `user_id`, `object_type`, `object_id`, `conent_report`, `isProcessed`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 2, 'Quấy rối', 0, '2023-07-13 17:58:09', '2023-07-13 10:58:09');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
