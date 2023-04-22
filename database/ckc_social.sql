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

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `avatar`, `cover_image`, `date_of_birth`, `sex`, `went_to`, `live_in`, `relationship`, `phone`, `address`, `token`, `email_verified_at`, `created_at`, `updated_at`, `deleted_at`, `isAdmin`) VALUES
(1, 'Samanta Cronin', 'Mario Pfannerstill', 'brycen.nolan@example.net', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 1, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(2, 'Mrs. Valentine Moore DVM', 'Raquel Schamberger', 'eichmann.jenifer@example.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 1, 'Vĩnh Long', 'Thành phố Hồ Chí Minh', 0, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(3, 'Leon Streich', 'Clare Kilback III', 'zboncak.arturo@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 1, 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 1, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(4, 'Trevion Gusikowski', 'Ms. Ebony Schinner', 'arno83@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 1, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(5, 'Daryl Ernser', 'Jimmy Reilly IV', 'dayna01@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 1, 'Vĩnh Long', 'Thành phố Hồ Chí Minh', 0, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(6, 'Miss Ivory Boyer', 'Werner Koss', 'zora86@example.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Vĩnh Long', 'Thành phố Hồ Chí Minh', 0, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(7, 'Prof. Ford Wunsch III', 'Eloise Christiansen', 'wrodriguez@example.net', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 0, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(8, 'Prof. Sebastian Feest', 'Mario Leuschke', 'iharvey@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 1, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(9, 'Demarco Kuvalis', 'Layla Jerde', 'henderson04@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 0, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(10, 'Paul Stracke', 'Caleigh Conn', 'hill.norval@example.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Vĩnh Long', 'Thành phố Hồ Chí Minh', 1, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(11, 'Jake Bashirian', 'Julius Hettinger', 'legros.carissa@example.net', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 0, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(12, 'Isom Bergstrom', 'Guillermo Cummings', 'euna.spencer@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Vĩnh Long', 'Thành phố Hồ Chí Minh', 0, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(13, 'Michaela Leannon Sr.', 'Mrs. Gracie Becker', 'jakubowski.louie@example.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Vĩnh Long', 'Thành phố Hồ Chí Minh', 0, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(14, 'Skye Kiehn III', 'Dr. Maybell Douglas', 'laisha.keeling@example.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 0, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(15, 'Tina Will', 'Leif Marvin', 'quigley.amara@example.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 1, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(16, 'Christina Sauer', 'Dr. Roma Sanford', 'lora.jakubowski@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 1, 'Vĩnh Long', 'Thành phố Hồ Chí Minh', 1, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(17, 'Dr. Austin Sawayn Sr.', 'Jillian Reynolds', 'bria90@example.net', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Vĩnh Long', 'Thành phố Hồ Chí Minh', 0, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(18, 'Prof. Milo Dibbert', 'Mr. Wallace Daniel DVM', 'boyle.gillian@example.net', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Vĩnh Long', 'Thành phố Hồ Chí Minh', 0, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(19, 'Prof. Bella Walsh', 'Annabel Tremblay', 'demarco31@example.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Vĩnh Long', 'Thành phố Hồ Chí Minh', 1, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(20, 'Jordan Rippin', 'Wilton Turner', 'kali59@example.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 1, 'Vĩnh Long', 'Thành phố Hồ Chí Minh', 1, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(21, 'Mrs. Bridie Williamson', 'Alyce Labadie', 'kutch.lorenzo@example.net', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 0, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(22, 'Prof. Sabina Padberg', 'Emerald Tillman', 'allison06@example.net', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 1, 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 1, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(23, 'Dallin Wolf', 'Connor Lemke', 'keely28@example.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 0, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(24, 'Sylvia Hessel', 'Mr. Mekhi Kihn V', 'macey.mclaughlin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Vĩnh Long', 'Thành phố Hồ Chí Minh', 1, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(25, 'Magnolia Hoppe II', 'Daron Hintz', 'effertz.leonor@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 1, 'Vĩnh Long', 'Thành phố Hồ Chí Minh', 0, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(26, 'Kayleigh Dibbert', 'Lloyd Hintz', 'zthompson@example.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 1, 'Vĩnh Long', 'Thành phố Hồ Chí Minh', 1, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(27, 'Ambrose Schulist', 'Elmo Weber', 'antonia.mohr@example.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Vĩnh Long', 'Thành phố Hồ Chí Minh', 0, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(28, 'Mr. Corbin Jast PhD', 'Mrs. Maxie Ledner Sr.', 'bell92@example.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Vĩnh Long', 'Thành phố Hồ Chí Minh', 0, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0),
(29, 'Prof. Lue Towne', 'Cassandra VonRueden', 'considine.maynard@example.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2023-04-21', 0, 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 0, NULL, 'Thanh Pho Ho Chi Minh', NULL, '2023-04-21 11:50:10', '2023-04-21 11:50:10', '2023-04-21 11:50:10', NULL, 0);
COMMIT;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `album_name`, `user_id`, `privacy`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Ảnh đại diện', 1, 1, '2023-04-19 00:00:28', NULL, NULL),
(2, 'Ảnh bìa', 1, 1, '2023-04-19 00:00:35', NULL, NULL),
(3, 'TEST', 1, 1, '2023-04-19 00:00:56', NULL, NULL);

--
-- Dumping data for table `comment_posts`
--

INSERT INTO `comment_posts` (`id`, `comment_content`, `post_id`, `user_id`, `parent_comment`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Oke', 10, 1, NULL, NULL, '2023-04-20 05:49:06', NULL);

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `privacy`, `avatar`, `cover_image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Group bóng đá', 0, '1681995378d8EhHJnTl1.jpg', NULL, '2023-04-18 23:58:10', NULL, NULL),
(2, 'Đồ án tốt nghiệp 2023', 0, '1681995412Om2IlXczBf.jpg', NULL, '2023-04-19 00:10:38', NULL, NULL),
(3, 'Người chơi điện tử', 1, '1682013317suD8pzpSMn.jpg', NULL, '2023-04-20 10:27:26', NULL, NULL),
(4, 'ffg', 0, NULL, NULL, '2023-04-21 02:04:59', NULL, NULL);

--
-- Dumping data for table `like_posts`
--

INSERT INTO `like_posts` (`id`, `user_id`, `post_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 5, '2023-04-19 00:01:53', NULL, NULL),
(2, 1, 4, '2023-04-19 00:01:54', NULL, NULL),
(3, 8, 1, '2023-04-19 05:17:15', NULL, NULL),
(4, 1, 9, '2023-04-19 11:15:44', NULL, NULL),
(5, 1, 1, '2023-04-20 01:52:14', NULL, '2023-04-19 18:52:15'),
(6, 1, 1, '2023-04-20 01:52:15', NULL, '2023-04-19 18:52:16'),
(7, 1, 1, '2023-04-20 01:52:16', NULL, '2023-04-19 18:52:17'),
(8, 1, 1, '2023-04-20 01:52:18', NULL, '2023-04-19 18:52:32'),
(9, 1, 1, '2023-04-20 01:52:46', NULL, '2023-04-19 18:53:29'),
(10, 1, 10, '2023-04-20 05:49:10', NULL, NULL),
(11, 1, 32, '2023-04-20 10:56:25', NULL, NULL),
(12, 1, 31, '2023-04-20 10:56:26', NULL, NULL),
(13, 1, 30, '2023-04-20 10:56:28', NULL, NULL),
(14, 1, 29, '2023-04-20 10:56:28', NULL, NULL),
(15, 1, 27, '2023-04-20 10:56:30', NULL, NULL),
(16, 1, 15, '2023-04-20 10:56:46', NULL, NULL),
(17, 11, 33, '2023-04-20 21:05:22', NULL, NULL),
(18, 11, 32, '2023-04-20 21:05:28', NULL, NULL);

--
-- Dumping data for table `list_friend`
--

INSERT INTO `list_friend` (`id`, `user_request`, `user_accept`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(1, 1, 2, '2023-04-18 23:58:53', NULL, NULL, 1),
(2, 1, 3, '2023-04-18 23:58:54', NULL, NULL, 1),
(3, 1, 4, '2023-04-18 23:58:55', NULL, NULL, 1),
(4, 8, 1, '2023-04-18 23:58:55', NULL, NULL, 1),
(5, 1, 11, '2023-04-20 21:09:43', NULL, NULL, 1);


--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `post_content`, `user_id`, `privacy`, `parent_post`, `group_id`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(1, 'Đã tạo nhóm.', 1, 1, NULL, 1, '2023-04-18 23:58:10', NULL, NULL, 1),
(2, 'Đã cập nhật ảnh đại diện.', 1, 1, NULL, NULL, '2023-04-19 00:00:28', NULL, NULL, 1),
(3, 'Đã cập nhật ảnh bìa.', 1, 1, NULL, NULL, '2023-04-19 00:00:35', NULL, NULL, 1),
(4, 'Đã tạo một album ảnh mới.', 1, 1, NULL, NULL, '2023-04-19 00:00:56', NULL, NULL, 1),
(5, 'Đã thêm ảnh mới vào album.', 1, 1, NULL, NULL, '2023-04-19 00:01:07', NULL, NULL, 1),
(6, 'Đã tạo nhóm.', 1, 0, NULL, 2, '2023-04-19 00:10:38', NULL, NULL, 1),
(7, 'Lịch báo cáo: Thứ 6, ngày 21/04/2023 vào lúc 18h00.', 1, 1, NULL, 1, '2023-04-20 02:17:22', NULL, NULL, 1),
(8, 'Đây là bài viết ở chế đô công khai', 1, 1, NULL, NULL, '2023-04-20 05:59:04', NULL, NULL, 1),
(9, 'Đây là bài viết ở chế độ bạn bè', 1, 2, NULL, NULL, '2023-04-20 05:59:21', NULL, NULL, 1),
(10, 'Đây là bài viết ở chế độ chỉ mình tôi', 1, 1, NULL, NULL, '2023-04-20 05:59:30', NULL, NULL, 1),
(11, 'Đã tạo nhóm.', 1, 0, NULL, 3, '2023-04-20 10:27:26', NULL, NULL, 1),
(12, 'Hello moi nguoi', 1, 1, NULL, NULL, '2023-04-20 10:28:53', NULL, NULL, 1),
(13, 'TEST GROUP', 1, 1, NULL, NULL, '2023-04-20 10:33:10', NULL, NULL, 1),
(14, 'HI', 1, 1, NULL, NULL, '2023-04-20 10:34:07', NULL, NULL, 1),
(15, 'HELLO MOI NGUOI NHE', 1, 1, NULL, 3, '2023-04-20 10:37:09', NULL, NULL, 1),
(16, 'LOAD POST NAY ???', 1, 1, NULL, 3, '2023-04-20 10:37:41', NULL, NULL, 1),
(17, '??????', 1, 1, NULL, 3, '2023-04-20 10:39:03', NULL, NULL, 1),
(18, 'Hom nay co tran bong nao khong nhi?', 1, 1, NULL, 1, '2023-04-20 10:39:58', NULL, NULL, 1),
(19, 'TEST', 1, 1, NULL, NULL, '2023-04-20 10:41:00', NULL, NULL, 1),
(20, 'Hom nay den han bao cao roi kia!', 1, 1, NULL, 2, '2023-04-20 10:41:22', NULL, NULL, 1),
(21, 'ITTO NOOOOOO\nistg Itto let the poor onikabuto go', 1, 1, NULL, NULL, '2023-04-21 18:51:03', NULL, NULL, 1),
(22, 'Sirin ✨\nLove HoV and this beautiful outfit had to snatch it when it reran', 1, 1, NULL, NULL, '2023-04-21 18:51:03', NULL, NULL, 1),
(23, '𝓘\'𝓶 𝓷𝓸𝓽 𝓵𝓪𝔃𝔂, 𝓘 𝓳𝓾𝓼𝓽 𝓴𝓷𝓸𝔀 𝓽𝓸 𝓼𝓪𝓿𝓮 𝓶𝔂 𝓮𝓷𝓮𝓻𝓰𝔂 𝓯𝓸𝓻 𝔀𝓱𝓮𝓷 𝓘 𝓷𝓮𝓮𝓭 𝓲𝓽 𝓶𝓸𝓼𝓽.\nLisa is such a mood *sent by a tired uni stundent* ✨\n\nI found this book at a flea marker and I\'ve been using it in every Lisa photoshoot ever since, but it\'s just sooo pretty. 📖\n.\nPh: nekos.creativeart (IG)', 1, 1, NULL, NULL, '2023-04-21 18:51:03', NULL, NULL, 1),
(24, 'Happy Birthday Yelan!! ♡', 1, 1, NULL, NULL, '2023-04-21 18:51:03', NULL, NULL, 1),
(25, 'how to unlock this?\nim afraid of missing out this image\'s', 1, 1, NULL, NULL, '2023-04-21 18:51:03', NULL, NULL, 1),
(26, 'Diluc Red Dead of Night cosplay\n\"I still have a lot to do at the Guild. How about you take a rest while I go back?\"\n\nI will be grateful for your support🔥✨', 1, 1, NULL, NULL, '2023-04-21 18:51:03', NULL, NULL, 1),
(27, 'Support units be like\nThat oil prince in your friendlist on day one..', 1, 1, NULL, NULL, '2023-04-21 18:51:04', NULL, NULL, 1),
(28, 'happy birthday xiao !!\nmy beloved', 1, 1, NULL, NULL, '2023-04-21 18:51:04', NULL, NULL, 1),
(29, 'Xiao’s birthday\nTo celebrate Xiao’s birthday, here’s a photo I took  at a con.\n\nLittle story : just before that photo, I drank a bubble tea that I spilled all over my costume. \nI spent the day trying to hide the big stain of tea on my white shirt… this is how clumsy I am.\n\nTbh I don’t like taking pictures at con because most of the time the background is pretty ugly and it’s so hard to do an edit to match the character. So it’s really rare for me to have some pictures.\n\nPhoto took by : olwecospic\n3d mask and spear printed by ziitrofactory', 1, 1, NULL, NULL, '2023-04-21 18:51:04', NULL, NULL, 1),
(30, 'Now, give us little timido.\nlittle adam chapter 24-01, little lyle New atra chapter 33, little carole meow-meow town event.', 1, 1, NULL, NULL, '2023-04-21 18:51:04', NULL, NULL, 1),
(31, 'Bennett\nMy precious baby~', 1, 1, NULL, NULL, '2023-04-21 18:51:04', NULL, NULL, 1),
(32, 'i finally finished it\nsorry im kinda late haha been busy with life lately', 1, 1, NULL, NULL, '2023-04-21 18:51:04', NULL, NULL, 1),
(33, 'Lush Green 🍃\nCongrats on your rerun~!', 1, 1, NULL, NULL, '2023-04-21 18:51:04', NULL, NULL, 1),
(34, 'ill just say i think i found my type\ni feel like this post will either be controversial or end up being a success.', 1, 1, NULL, NULL, '2023-04-21 18:51:04', NULL, NULL, 1),
(35, '🫠\nLike, fav and follow for more~', 1, 1, NULL, NULL, '2023-04-21 18:51:04', NULL, NULL, 1),
(36, 'Sumeru Underground Maps by Teyvat Map Institute - All-In-One Edition\nHi again Fellow Travelers! We, we are the Teyvat Map Institute (提瓦特图研所 on Bilibili). We shared our work on the previous Sumeru underground maps with you in several updates, and you all loved it! So to', 1, 1, NULL, NULL, '2023-04-21 18:51:04', NULL, NULL, 1),
(37, 'Nice\n:)', 1, 1, NULL, NULL, '2023-04-21 18:51:04', NULL, NULL, 1),
(38, 'Why do people like this sm 😭\nAAAAA 😭😭😭', 1, 1, NULL, NULL, '2023-04-21 18:51:16', NULL, NULL, 1),
(39, 'Shenhe\nwell, since the contest has passed, here\'s my Shenhe that I submitted. Didn\'t win but I think I did a pretty okay job on drawing her fanart. \n\n\nThis was posted on my twitter first @zerisenpai. Now to hoyolab. o7', 1, 1, NULL, NULL, '2023-04-21 18:51:16', NULL, NULL, 1),
(40, '[Genshin impact] comic: Hug\nAlyn on Twitter', 1, 1, NULL, NULL, '2023-04-21 18:51:16', NULL, NULL, 1),
(41, 'Nahida Fanart Contest\ndone nahida for fanart contest \nhope u like it', 1, 1, NULL, NULL, '2023-04-21 18:51:16', NULL, NULL, 1),
(42, '🎲 It\'s Yelan Birthday! 🎲\n2004 Happy Birthday, Yelan! 💙\n\n「... 𝒕𝒐𝒅𝒂𝒚, 𝑰\'𝒎 𝒋𝒖𝒔𝒕 𝒕𝒉𝒆 𝒃𝒐𝒔𝒔 𝒐𝒇 𝒕𝒉𝒊𝒔 𝒕𝒆𝒂𝒉𝒐𝒖𝒔𝒆, 𝒊𝒏𝒗𝒊𝒕𝒊𝒏𝒈 𝒚𝒐𝒖 𝒊𝒏 𝒇𝒐𝒓 𝒂 𝒕𝒂𝒔𝒕𝒆 𝒐𝒇 𝒐𝒖𝒓 𝒇𝒊𝒏𝒆𝒔𝒕 𝒗𝒂𝒓𝒊𝒆𝒕𝒊𝒆𝒔. 𝑻𝒉𝒆𝒓𝒆\'𝒔 𝒏𝒐 𝒏𝒆𝒆𝒅 𝒇𝒐𝒓 𝒕𝒐𝒐 𝒎𝒂𝒏𝒚 𝒕𝒓𝒊𝒇𝒍𝒆𝒔 𝒐𝒓 𝒕𝒓𝒊𝒏𝒌𝒆𝒕𝒔.\n𝑪𝒐𝒎𝒆 𝒂𝒍𝒐𝒏𝒈 𝒏𝒐𝒘, 𝒕𝒉𝒆𝒓𝒆\'𝒔 𝑽𝑰𝑷 𝒔𝒆𝒂𝒕𝒔 𝒘𝒂𝒊𝒕𝒊𝒏𝒈 𝒖𝒑𝒔𝒕𝒂𝒊𝒓𝒔.\n𝑻𝒆𝒂 𝒑𝒆𝒓𝒔𝒐𝒏𝒂𝒍𝒍𝒚 𝒑𝒓𝒆𝒑𝒂𝒓𝒆𝒅 𝒃𝒚 𝒕𝒉𝒆 𝒃𝒐𝒔𝒔. 𝑵𝒐𝒕 𝒋𝒖𝒔𝒕 𝒂𝒏𝒚𝒐𝒏𝒆 𝒄𝒂𝒏 𝒉𝒂𝒗𝒆 𝒂 𝒔𝒊𝒑, 𝒉𝒆𝒉𝒆.」\n\nIt\'s almost the end of Yelan\'s birthday! Wishing the Happiest Birthday to Yanshang Teahouse\'s boss 🎊\n\n🎲: @/KuroyoriHaruka (Instagram)\n📸: @/melvin858 (Instagram)', 1, 1, NULL, NULL, '2023-04-21 18:51:16', NULL, NULL, 1),
(43, 'Venti memes', 1, 1, NULL, NULL, '2023-04-21 18:51:16', NULL, NULL, 1),
(44, 'Meme ;)\nLol (not mine)', 1, 1, NULL, NULL, '2023-04-21 18:51:16', NULL, NULL, 1),
(45, 'Pardo in lore vs pardo in game\nNot mine', 1, 1, NULL, NULL, '2023-04-21 18:51:16', NULL, NULL, 1),
(46, 'Nahida 🦋', 1, 1, NULL, NULL, '2023-04-21 18:51:16', NULL, NULL, 1),
(47, 'Happy Birthday The Mysterious Yelan\nYelan is the character that I always bring to the team. For me, she is like an upgraded version of young master Xinqiu. And again, my friend who cos Xinqiu asked me to shoot her as Yelan. How fortunately we are.\nIf you like her as Yelan, please support her at this link | https://www.facebook.com/kxumii', 1, 1, NULL, NULL, '2023-04-21 18:51:16', NULL, NULL, 1),
(48, 'Artem why...\nthey really said yes go to the last possible chance 🫠', 1, 1, NULL, NULL, '2023-04-21 18:51:16', NULL, NULL, 1),
(49, 'Yep, that\'s me~~~\nI\'ll bring you home, Sir!!!\nJust wait!!\nI don\'t care what it\'ll take!!\nI don\'t care if I have to force you!!', 1, 1, NULL, NULL, '2023-04-21 18:51:16', NULL, NULL, 1),
(50, 'Desert’s dance🪷\nMy entry for the contest!! I hope you like it!!', 1, 1, NULL, NULL, '2023-04-21 18:51:16', NULL, NULL, 1),
(51, 'jenna. ortega.\nshe\'s just\njust so\nzkznjskwnwjskznsksn 💗💓💞💕💖💘💝', 1, 1, NULL, NULL, '2023-04-21 18:51:16', NULL, NULL, 1),
(52, '🐰\nOoh, what\'s happening over there? Can we take a sneaky peek, huh? Can we? 🐰\n\n📸: at.field.photo', 1, 1, NULL, NULL, '2023-04-21 18:51:16', NULL, NULL, 1),
(53, 'Mentally I am here\nArtem sends this to you while you\'re on break', 1, 1, NULL, NULL, '2023-04-21 18:51:16', NULL, NULL, 1),
(54, 'About Cyno\'s Cooking Skills【 Genshin Impact Animation 】\nHappy Birthday, Yelan!\n\n▪︎▪︎▪︎ CREDITS ▪︎▪︎▪︎\n\nAnimation by PodEli\nModels by HoYoverse, 观海 \n\n▪︎▪︎▪︎ MY SOCIAL MEDIA ▪︎▪︎▪︎\n\nTikTok (@podeli) : https://vm.tiktok.com/ZSeJjWRgP/\n\nInstagram (@podeli_project) : https://www.instagram.com/podeli_project\n\nBiliBili (podeli): https://space.bilibili.com/1968676839 \n\n▪︎▪︎▪︎ TAGS (no need to read) ▪︎▪︎▪︎\n#genshinanime #hoyocreators #genshinimpact #genshin #animation #mmd #cyno #yelan #dehya #podeli', 1, 1, NULL, NULL, '2023-04-21 18:51:16', NULL, NULL, 1),
(55, 'Comic-esque Summary of \'Khvarena of Good and Evil\' [Spoilers Ahead!]\nGenshin\'s writing can be pretty confusing. There were a couple of lore drops in the latest world quest, Khvarena of Good and Evil. But the information was presented in a roundabout way, and some missi', 1, 1, NULL, NULL, '2023-04-21 18:51:21', NULL, NULL, 1),
(56, 'For my sister: I breath for itto\n:) I made your itto:)', 1, 1, NULL, NULL, '2023-04-21 18:51:21', NULL, NULL, 1),
(57, 'I want him bad. I want him hard. I want him now.\n...This has been Biba\'s Down Bad Hour. Thanks for tuning in!   And now a word from our sponsor...      (you already know broskis cause I didn\'t need a cover but you got one anyway for fun. enjoy!)', 1, 1, NULL, NULL, '2023-04-21 18:51:21', NULL, NULL, 1),
(58, 'Human life is worthless...\nScaramouche will forever be my fave! I can\'t wait for my Wanderer cosplay to arrive. 👉👈\n\npsst click here for more scaramouche content wink wink > https://www.instagram.com/dejikocosplay/\n\nphoto by NeonCosplayPhotography\ncosplay is from DokiDoki', 1, 1, NULL, NULL, '2023-04-21 18:51:21', NULL, NULL, 1),
(59, 'Nahida\nMy entry for Nahida fanart contest. I always wanted to draw the little radish archon!', 1, 1, NULL, NULL, '2023-04-21 18:51:21', NULL, NULL, 1),
(60, 'is this legal\ngiving this to my yelan right away🤩🫰', 1, 1, NULL, NULL, '2023-04-21 18:51:21', NULL, NULL, 1),
(61, 'Ayaka Springbloom Missive cosplay\nSharing here my Ayaka Springbloom Missive cosplay! I felt really royal in her costume 😆', 1, 1, NULL, NULL, '2023-04-21 18:51:21', NULL, NULL, 1),
(62, 'Yae 🪷🌸\nThis is her best outfit IMO I think it’s just so slay', 1, 1, NULL, NULL, '2023-04-21 18:51:21', NULL, NULL, 1),
(63, 'what if bailu becomes the new qiqi?\ni mean... they\'re both chibi... and both healers... and obviously you can lose your 50/50 to both of them... [pic] [emoji]', 1, 1, NULL, NULL, '2023-04-21 18:51:21', NULL, NULL, 1);

--
-- Dumping data for table `media_file_posts`
--

INSERT INTO `media_file_posts` (`id`, `media_file_name`, `media_type`, `post_id`, `user_id`, `isAvatar`, `isCover`, `album_id`, `status`, `created_at`, `updated_at`) VALUES
(1, '1681887628gr5pk3hPIy.jpg', 'jpg', 2, 1, 1, NULL, 1, 1, '2023-04-19 00:00:28', NULL),
(2, '1681887635B8RyIM6tXq.jpg', 'jpg', 3, 1, NULL, 1, 2, 1, '2023-04-19 00:00:35', NULL),
(3, '16818876568jwmq3loao.png', 'png', 4, 1, NULL, NULL, 3, 1, '2023-04-19 00:00:56', NULL),
(4, '1681887656yUyqpoGaB6.jpg', 'jpg', 4, 1, NULL, NULL, 3, 1, '2023-04-19 00:00:56', NULL),
(5, '16818876671T9Lqx9EGi.jpg', 'jpg', 5, 1, NULL, NULL, 3, 1, '2023-04-19 00:01:07', NULL),
(6, '1681887667HEBxcalobo.jpg', 'jpg', 5, 1, NULL, NULL, 3, 1, '2023-04-19 00:01:07', NULL),
(7, '1681928127ldS5FVc54t.jpg', 'jpg', 7, 1, NULL, NULL, NULL, 1, '2023-04-19 11:15:27', NULL),
(8, '1681928127GFImwm0vgN.png', 'png', 7, 1, NULL, NULL, NULL, 1, '2023-04-19 11:15:27', NULL),
(9, '1681928127gwlSLuUKII.jpg', 'jpg', 7, 1, NULL, NULL, NULL, 1, '2023-04-19 11:15:27', NULL),
(10, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/170391485/ea949f35e1a6ff3ad7fea80c126eb338_2471180880582403332.jpg', 'jpg', 21, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:03', NULL),
(11, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/241509357/3715bd14f141a1229dd59764ac84f884_2795810303896016324.png', 'png', 22, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:03', NULL),
(12, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/241509357/2c3e3e69ff5d989e37d68666ab1db743_8462303249267939682.png', 'png', 22, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:03', NULL),
(13, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/241509357/2f8648008d8ffb808f1069bc060b9493_722020499644850994.png', 'png', 22, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:03', NULL),
(14, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/241509357/90090a25fc1235ca5f2a6a70458d2b92_8643875368465470235.png', 'png', 22, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:03', NULL),
(15, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/241509357/ca9dd7d23c285e10104a5e0afc540500_1234153307895492046.png', 'png', 22, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:03', NULL),
(16, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/241509357/5991c989cfdce9aaf9f4d5a94f2e53ab_4399426929596337917.png', 'png', 22, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:03', NULL),
(17, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/241509357/a2c5d786036690f39390bbdb04170f6a_6486250188375801770.png', 'png', 22, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:03', NULL),
(18, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/241509357/80ab1bd8118ef2ec5542b2ffe2ec4277_768506174431986316.png', 'png', 22, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:03', NULL),
(19, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/20/102840738/effba42aa701fddccd8ef2e5adb93a7b_4486872896435301635.jpg', 'jpg', 23, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:03', NULL),
(20, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/20/102840738/7ac6ab39bdf0ae1f112f4e56d2668c74_5340180686289517556.jpg', 'jpg', 23, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:03', NULL),
(21, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/205940982/b8300c9c701fe2b75334c41f9b3a65c1_5222164363479935435.jpg', 'jpg', 24, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:03', NULL),
(22, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/20/195512677/14ad2fdd15ab0d0a30dd8b2e0c2a5f8e_8991456033077788548.png', 'png', 25, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:03', NULL),
(23, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/20/92134619/626e97c2148f89231664b4972fccf1d0_4492853621332513769.jpg', 'jpg', 26, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:03', NULL),
(24, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/20/10289068/a774bdbe230b1f73dc9138447a966857_7994359930286471222.jpg', 'jpg', 27, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(25, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/17/110634369/d6b4ba5969fb5f08362b082938ceaf2e_4511818899932015060.png', 'png', 28, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(26, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/17/110634369/b952a213f75f4ab6613a518936f5a699_7034386829492187901.png', 'png', 28, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(27, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/17/90855248/2f70492b2354b7512d07642c353af74f_261318134174291671.jpg', 'jpg', 29, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(28, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/240782522/699834205e1624d42e2f6bf3f256a969_5605284338009264501.png', 'png', 30, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(29, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/240782522/6283b2c1bdb688d7c8a7ea6becb1b2d1_249247441679390572.png', 'png', 30, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(30, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/240782522/8b389a575274ddc1fa424b2cfab07b25_6299209254031685769.png', 'png', 30, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(31, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/240782522/7bec6feeddd6eebb1245a78030b7b80f_1769354476987436854.gif', 'gif', 30, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(32, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/18/51906685/56873a92e36115062d1a5f0dcfbc408c_5568128742724287528.jpg', 'jpg', 31, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(33, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/17/297601907/a4e9cd2ff13a16448222a63bfffd5ae8_5450437280328680180.jpg', 'jpg', 32, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(34, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/17/297601907/8e575c1c224b9192bc4ebeafb6ba82f3_7373680818497933212.jpg', 'jpg', 32, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(35, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/17/297601907/0b2ad4fe339dd1cdb8db96d79e58a37d_3283620649575193156.jpg', 'jpg', 32, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(36, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/17/297601907/59e11844b800fd2bd9a8a850eb6bde07_2575385294610720989.jpg', 'jpg', 32, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(37, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/8507720/700c0066e5a74a7c01072da072e7864a_3760178597044867858.jpg', 'jpg', 33, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(38, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/8507720/e3fd303179f84e99aedce74359b0371a_3067417179585123351.jpg', 'jpg', 33, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(39, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/317642707/1e8d22f6f94160e930ebade3cabf0d2e_6265109987184491400.png', 'png', 34, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(40, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/17/255024371/48eb9ceab1405eb5ebad5fc390448269_3873085622361705408.jpg', 'jpg', 35, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(41, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/17/255024371/afa32abeb2c1ce443c402b2d3bd3705d_2613199958421791111.jpg', 'jpg', 35, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(42, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/17/203947042/392522924f84a692a9924460b5847eed_5650735638371703811.jpg', 'jpg', 37, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(43, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/17/203947042/cbb550a4858440d1e962c1cc6f591729_3951019503856163674.jpg', 'jpg', 37, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:04', NULL),
(44, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/292754532/d93e5cc46848ad569e386aa56dc77ec0_5634982215139934538.jpg', 'jpg', 38, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(45, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/18/295924296/f971e0e344fcbf2808bd993b25edde70_2006669432886270388.jpg', 'jpg', 39, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(46, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/83984823/d08cc34cffbbd9e4cf0db1ce8a9ce6c3_1134193764637441013.jpg', 'jpg', 40, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(47, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/295452504/b795ec8aac1cd97472715cd2f0e408dc_3450970119115067620.jpg', 'jpg', 41, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(48, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/295452504/8cb80e7e37771b8de3c64d78856699f3_6409981041119727301.jpg', 'jpg', 41, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(49, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/20/77042738/10a8979c97867ebbae9b026811f909d4_7113932974585079780.jpg', 'jpg', 42, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(50, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/18/297163891/03d27ec8b54de2e9ef0f15a2b909374b_6804335491714779073.webp', 'webp', 43, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(51, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/20/250312406/348a2c43bbcfef29472fe84de6a3094e_4102366664109287203.jpeg', 'jpeg', 44, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(52, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/18/297163891/8937eb760c876f8ddf4c053d2266891a_2242189232113248307.jpeg', 'jpeg', 45, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(53, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/17/31419421/4029d02a1978a0e6eebe27a528cbd008_9059833681464694887.jpg', 'jpg', 46, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(54, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/20/26628133/f5bcc664aaa94ee0aa9ea1ef388412b5_1827294333156866735.jpg', 'jpg', 47, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(55, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/20/26628133/eb9fd31183adef0eb4a8b3a628375f56_5744323691717486986.jpg', 'jpg', 47, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(56, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/20/26628133/5a399e2f9057723911c0e8674a5ba597_4364062695137056256.jpg', 'jpg', 47, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(57, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/20/26628133/f6250fc4e4c6293841726d238d0f7611_8624893206323325785.jpg', 'jpg', 47, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(58, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/20/26628133/a46b97e131d513117a7f89b006dcd9bb_4800982497440768828.jpg', 'jpg', 47, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(59, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/13946328/4baf12e384e94b72f54f572147506eb7_874616055753732719.jpg', 'jpg', 48, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(60, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/13946328/9438a8f9acc6462f7ce350f82a6358ad_4364908132048326680.jpg', 'jpg', 48, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(61, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/13946328/8bfc98d6fb8dd736f1d5f9842a361a3a_4763913364109920688.jpg', 'jpg', 48, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(62, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/27945082/a7489e3c0cd88ed7e5a68957b5dbb440_5562866523691788096.jpg', 'jpg', 49, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(63, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/27945082/945775c5fc51a192bfa44668a346b52e_2963649583274889851.jpg', 'jpg', 49, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(64, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/27945082/728ab6d7a2143dabfcc0c50f802b2244_1173461834539580835.jpg', 'jpg', 49, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(65, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/27945082/88fc13f38e25d323c747b899c78cc99a_8113700843638243485.jpg', 'jpg', 49, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(66, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/16/6492507/4bf227a8f9f201d12c1cb537aa5bf833_613090313450099091.jpg', 'jpg', 50, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(67, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/16/6492507/517551443f3460c7a895c1d8b7079628_9022048378714136516.jpg', 'jpg', 50, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(68, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/16/6492507/0c41266a2895da32c9e2c0f8c8b7632e_4301557725376061868.jpg', 'jpg', 50, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(69, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/16/6492507/8b208b72ff5b5ead44145d91b345c13c_4318050419434838459.jpg', 'jpg', 50, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(70, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/144589923/067534df8cbf37c7b67b6a1b230cf914_6232143554492800045.jpg', 'jpg', 51, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(71, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/144589923/ce1158a8e6478c847ef101d19535cceb_5032878145257784340.jpg', 'jpg', 51, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(72, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/144589923/123226858d8c9bdc91c742118d1c236c_4008030338153356415.jpg', 'jpg', 51, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(73, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/144589923/00df2eb9e8908712045296a1e2d85922_82120141538607196.jpg', 'jpg', 51, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(74, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/144589923/2282d85cea89401a1ff00f3da0545e62_8481771024603690373.jpg', 'jpg', 51, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(75, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/144589923/5e910bfb3af622c77246e5a367153f1a_5285269693225382752.jpg', 'jpg', 51, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(76, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/144589923/5acbf897b1d2a9a3e05d43d903b4e856_7600722190812857827.jpg', 'jpg', 51, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(77, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/144589923/21f670626a25c4ced1933f5e72e84254_6930667228371557650.jpg', 'jpg', 51, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(78, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/144589923/c9b082d88e559f3c881e8250ac6e21ff_7932324130732454146.jpg', 'jpg', 51, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(79, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/144589923/f1ded68ab389cfb85e1ed87483361c90_3403930337492789182.jpg', 'jpg', 51, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(80, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/144589923/f588b525eef530bd92dabe47ae0cece9_8520561162007656874.jpg', 'jpg', 51, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(81, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/144589923/c41d9e1f5398c94730b4dbe8349cf267_5194441460062309083.png', 'png', 51, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(82, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/18/104567213/19c332fd8739ffb543d5e4eceef74575_3594268958288801230.jpg', 'jpg', 52, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(83, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/20/204447452/c35d6f24b70be4bc06dfb2e43895ea2f_7707261455021322586.png', 'png', 53, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:16', NULL),
(84, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/18/263248163/f075f7735ecc7a009c59173480f60ad1_9122747573070903054.jpg', 'jpg', 56, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:21', NULL),
(85, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/16/106839430/d74c096f645e0c025f0bba24eb400f02_1203847594545884677.jpg', 'jpg', 58, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:21', NULL),
(86, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/170607517/6a8e5df129af80fdde143f86fe9e24a7_4611383460248203847.png', 'png', 59, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:21', NULL),
(87, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/21/170607517/3db02a2e0b09563f420296f5ddb83620_8031651013399587182.png', 'png', 59, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:21', NULL),
(88, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/18/214243391/7164231fefacbc6be8802e5a41d176ba_3708505768430473679.jpg', 'jpg', 60, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:21', NULL),
(89, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/18/214243391/8c960adbd4a5dbc9a13b1e1641177fe5_6745122077611996977.jpg', 'jpg', 60, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:21', NULL),
(90, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/18/44018995/0d40e3d4d93c0f7945d3e72a50279de6_1669220321882185665.jpg', 'jpg', 61, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:21', NULL),
(91, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/18/44018995/75ccd6e2212924d7ea7a03eb3d61d085_2557095529906744788.jpg', 'jpg', 61, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:21', NULL),
(92, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/18/44018995/baab01a5993c72138bc8706f05848aa7_5784959789578954062.jpg', 'jpg', 61, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:21', NULL),
(93, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/18/44018995/40417580e89c1f4986a4fc314055d110_1793105110337755101.jpg', 'jpg', 61, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:21', NULL),
(94, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/241509357/560f6be54758ef72752a61a48db695ce_8426336683519410696.png', 'png', 62, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:21', NULL),
(95, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/241509357/67d4d2f9714257e0ba12db8bbddb4bcb_4874936887390064605.jpg', 'jpg', 62, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:21', NULL),
(96, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/241509357/7729a1cf48f20c56709a8b13c82fc23b_9109533856358748329.png', 'png', 62, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:21', NULL),
(97, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/241509357/973f29c73b5dbfba90cf4a230c2311f8_3170019762117790956.png', 'png', 62, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:21', NULL),
(98, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/241509357/0e9058c1483db0c9c72e8338897e5468_8314927162132563070.jpg', 'jpg', 62, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:21', NULL),
(99, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/241509357/acca3e087c0025c6d5839166371c5381_1175840054815530314.png', 'png', 62, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:21', NULL),
(100, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/241509357/de25cda4c687c962aafbb6f05289960c_6634379615050758114.jpg', 'jpg', 62, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:21', NULL),
(101, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/241509357/36b36b1d1a027ff718b4219c1c97f91d_5839346877790454976.jpg', 'jpg', 62, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:21', NULL),
(102, 'https://upload-os-bbs.hoyolab.com/upload/2023/04/19/241509357/66ddbb3d204182f5154e0214d866014d_4473388859017719285.jpg', 'jpg', 62, 1, NULL, NULL, NULL, 1, '2023-04-21 18:51:21', NULL);

--
-- Dumping data for table `member_group`
--

INSERT INTO `member_group` (`id`, `user_id`, `group_id`, `isAdminGroup`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, 1, '2023-04-18 23:58:10', NULL, NULL),
(2, 2, 1, 0, 1, '2023-04-18 23:59:36', NULL, NULL),
(3, 3, 1, 0, 1, '2023-04-18 23:59:37', NULL, NULL),
(4, 4, 1, 0, 2, '2023-04-18 23:59:37', NULL, NULL),
(5, 1, 2, 1, 1, '2023-04-19 00:10:38', NULL, NULL),
(6, 2, 2, 0, 2, '2023-04-19 00:10:58', NULL, NULL),
(7, 3, 2, 0, 2, '2023-04-19 00:11:00', NULL, NULL),
(8, 4, 2, 0, 2, '2023-04-19 00:11:01', NULL, NULL),
(9, 8, 1, 0, 1, '2023-04-19 05:13:35', NULL, NULL),
(10, 8, 2, 0, 1, '2023-04-19 07:35:07', NULL, NULL),
(11, 1, 3, 1, 1, '2023-04-20 10:27:26', NULL, NULL),
(12, 2, 3, 1, 1, '2023-04-20 10:48:55', NULL, NULL),
(13, 3, 3, 0, 1, '2023-04-20 10:48:56', NULL, NULL),
(14, 4, 3, 0, 1, '2023-04-20 10:48:56', NULL, NULL),
(15, 8, 3, 1, 1, '2023-04-20 10:48:57', NULL, NULL),
(16, 11, 2, 0, 1, '2023-04-20 21:10:41', NULL, NULL),
(17, 11, 4, 1, 1, '2023-04-21 02:04:59', NULL, NULL);

--
-- Dumping data for table `social_account`
--

INSERT INTO `social_account` (`id`, `provider`, `provider_id`, `email`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'google.com', 's8HtGXPL7LUJvvkklWD72WzZ4nh2', 'tranduongchihieu@gmail.com', 1, '2023-04-18 23:58:00', '2023-04-18 16:58:00');



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
