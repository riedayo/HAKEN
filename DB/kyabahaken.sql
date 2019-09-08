-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: 2019 年 9 月 09 日 01:48
-- サーバのバージョン： 5.7.25
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kyabahaken`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `anken`
--

CREATE TABLE `anken` (
  `id` int(11) NOT NULL,
  `anken_date` date NOT NULL,
  `salary` int(11) NOT NULL,
  `bosyu` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `pic` varchar(255) NOT NULL,
  `tenpo_id` int(11) NOT NULL,
  `simekiri_flg` tinyint(1) NOT NULL DEFAULT '0',
  `delete_flg` tinyint(1) NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `anken`
--

INSERT INTO `anken` (`id`, `anken_date`, `salary`, `bosyu`, `start_time`, `comment`, `pic`, `tenpo_id`, `simekiri_flg`, `delete_flg`, `create_date`, `update_date`) VALUES
(1, '2019-08-09', 4000, 3, '19:00:00', '勤務中の携帯電話は禁止', 'uploads/2ec03ce9fefe61ccbd2a7ffa43337bc3f21cf0e5.jpeg', 9, 0, 0, '2019-08-10 18:13:29', '2019-08-28 15:38:12'),
(2, '2019-08-12', 3500, 2, '20:30:00', '浴衣を持参してください。店内で着付けできます。', 'uploads/2ec03ce9fefe61ccbd2a7ffa43337bc3f21cf0e5.jpeg', 9, 1, 0, '2019-08-10 18:21:08', '2019-08-28 16:25:47'),
(3, '2019-08-14', 4000, 3, '20:30:00', 'テスト', 'uploads/2ec03ce9fefe61ccbd2a7ffa43337bc3f21cf0e5.jpeg', 9, 0, 0, '2019-08-11 12:07:32', '2019-08-28 15:38:12'),
(4, '2019-08-14', 4000, 3, '20:30:00', 'テスト', 'uploads/2ec03ce9fefe61ccbd2a7ffa43337bc3f21cf0e5.jpeg', 9, 0, 0, '2019-08-11 12:24:02', '2019-08-28 15:38:12'),
(5, '2019-08-02', 3500, 3, '19:30:00', 'aaaa', 'uploads/2ec03ce9fefe61ccbd2a7ffa43337bc3f21cf0e5.jpeg', 9, 0, 0, '2019-08-11 12:30:09', '2019-08-28 15:38:12'),
(6, '2019-08-08', 3500, 3, '21:00:00', 'あああ', 'uploads/2ec03ce9fefe61ccbd2a7ffa43337bc3f21cf0e5.jpeg', 9, 0, 0, '2019-08-11 12:36:12', '2019-08-28 15:38:12'),
(7, '2019-08-08', 3500, 3, '21:00:00', 'あああ', 'uploads/2ec03ce9fefe61ccbd2a7ffa43337bc3f21cf0e5.jpeg', 9, 0, 0, '2019-08-11 12:58:48', '2019-08-28 15:38:12'),
(8, '2019-08-23', 4000, 4, '21:30:00', 'ストッキング不可', 'uploads/2ec03ce9fefe61ccbd2a7ffa43337bc3f21cf0e5.jpeg', 9, 0, 0, '2019-08-12 16:16:07', '2019-08-28 15:38:12'),
(9, '2019-08-23', 5000, 2, '20:00:00', 'ストール着用禁止', 'uploads/2ec03ce9fefe61ccbd2a7ffa43337bc3f21cf0e5.jpeg', 10, 0, 0, '2019-08-15 22:11:30', '2019-08-28 15:38:12'),
(10, '2019-08-30', 3500, 3, '21:00:00', '浴衣着用してきてください。ヘアメは各自でお願いします。', 'uploads/2ec03ce9fefe61ccbd2a7ffa43337bc3f21cf0e5.jpeg', 10, 0, 0, '2019-08-16 15:05:57', '2019-08-28 15:38:12'),
(11, '2019-08-30', 3000, 2, '19:30:00', '', '', 10, 0, 0, '2019-08-31 14:38:15', '2019-08-31 05:38:15');

-- --------------------------------------------------------

--
-- テーブルの構造 `anken_rireki`
--

CREATE TABLE `anken_rireki` (
  `id` int(11) NOT NULL,
  `anken_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `delete_flg` tinyint(1) NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `delete_flg` tinyint(1) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `category`
--

INSERT INTO `category` (`id`, `category_name`, `delete_flg`, `create_date`, `update_date`) VALUES
(1, 'キャバクラ', 0, '2019-08-15 00:00:00', '2019-08-15 08:16:14'),
(2, 'クラブ', 0, '2019-08-15 00:00:00', '2019-08-15 08:16:53'),
(3, 'スナック', 0, '2019-08-15 00:00:00', '2019-08-15 08:17:15'),
(4, 'ガールズバー', 0, '2019-08-15 00:00:00', '2019-08-15 08:17:31'),
(5, 'ラウンジ', 0, '2019-08-15 00:00:00', '2019-08-15 08:17:50'),
(6, '熟女キャバクラ', 0, '2019-08-15 00:00:00', '2019-08-15 08:18:05'),
(7, 'その他', 0, '2019-08-15 00:00:00', '2019-08-15 08:18:16');

-- --------------------------------------------------------

--
-- テーブルの構造 `oubo`
--

CREATE TABLE `oubo` (
  `id` int(255) NOT NULL,
  `anken_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `delete_flg` tinyint(1) DEFAULT '0',
  `create_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `oubo`
--

INSERT INTO `oubo` (`id`, `anken_id`, `user_id`, `delete_flg`, `create_date`) VALUES
(1, 6, 5, 0, NULL),
(2, 9, 5, 0, NULL),
(3, 9, 5, 0, NULL),
(4, 9, 5, 0, NULL),
(5, 3, 5, 0, NULL),
(6, 2, 5, 0, NULL),
(7, 1, 5, 0, '2019-08-22 12:12:00'),
(8, 1, 5, 0, '2019-08-24 13:29:58'),
(9, 7, 5, 0, '2019-08-25 00:13:52'),
(10, 8, 5, 0, '2019-08-29 01:24:05'),
(11, 2, 5, 0, '2019-08-29 01:25:47'),
(12, 5, 5, 0, '2019-08-30 03:13:33'),
(13, 10, 5, 0, '2019-08-31 14:38:59');

-- --------------------------------------------------------

--
-- テーブルの構造 `tenpo`
--

CREATE TABLE `tenpo` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `tenpo_name` varchar(255) DEFAULT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `tel` varchar(11) NOT NULL,
  `pref` varchar(255) NOT NULL,
  `addr` varchar(255) DEFAULT NULL,
  `station` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `hair` int(11) DEFAULT NULL,
  `arrival_time` varchar(11) DEFAULT NULL,
  `arrival_time_re` varchar(11) DEFAULT NULL,
  `tax` int(11) DEFAULT NULL,
  `kouseihi` int(11) DEFAULT NULL,
  `dress` varchar(11) DEFAULT NULL,
  `car` int(11) DEFAULT NULL,
  `car_hani` varchar(255) DEFAULT NULL,
  `syorui` varchar(255) DEFAULT NULL,
  `login_time` date DEFAULT NULL,
  `delete_flg` tinyint(1) NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `tenpo`
--

INSERT INTO `tenpo` (`id`, `email`, `pass`, `tenpo_name`, `owner_name`, `tel`, `pref`, `addr`, `station`, `category`, `hair`, `arrival_time`, `arrival_time_re`, `tax`, `kouseihi`, `dress`, `car`, `car_hani`, `syorui`, `login_time`, `delete_flg`, `create_date`, `update_date`) VALUES
(1, 'suzukitarou@gmail.com', 'suzukitarou', 'Angel', '鈴木太郎', '0', '', '東京都新宿区歌舞伎町１−１−１　Sビル３階', '新宿', '1', 1000, '19:00', '19:30', 10, 1000, '0', 1000, '23区内', '顔付き身分証', NULL, 0, '2019-07-28 00:00:00', '2019-09-05 14:05:29'),
(2, 'tanakatarou@gmail.com', 'tanakatarou', 'Garden', '田中太郎', '0', '', '神奈川県横浜市西区3-1-1 Gビル5階', '横浜', '1', 1000, '19:00', '19:30', 10, 1000, '0', 1000, '横浜市内', '顔付き身分証', NULL, 0, '2019-07-28 00:00:00', '2019-09-05 14:05:46'),
(3, 'ootatarou@gmail.com', 'ootatarou', 'Heaven', '太田太郎', '0', '', '東京都豊島区池袋１丁目２−３　Hビル５階', '池袋', '1', 1000, '19:00', '19:30', 10, 1000, '0', 1000, '２３区内', '顔付き身分証', NULL, 0, '2019-07-28 00:00:00', '2019-09-05 14:05:50'),
(4, 'test@gmail.com', 'mezase4319', 'club test', '田中一郎', '0311111111', '東京都', '渋谷区恵比寿1-1-1 Fビル３階', '恵比寿', '3', 1000, '60', '30', 1000, 1000, 'あり', 1000, '23区', '顔つきであればOK', NULL, 0, '2019-07-31 00:00:00', '2019-09-05 14:06:07'),
(5, 'suzukitarou@gmail.com', 'suzukitarou', 'Angel', '鈴木太郎', '0', '', '東京都新宿区歌舞伎町１−１−１　Sビル３階', '新宿', '1', 1000, '19:00', '19:30', 10, 1000, '0', 1000, '23区内', '顔付き身分証', NULL, 0, '2019-07-28 00:00:00', '2019-09-05 14:05:54'),
(6, 'test@gmail.com', 'mezase4319', 'club test', '田中一郎', '0311111111', '東京都', '渋谷区恵比寿1-1-1 Fビル３階', '恵比寿', '3', 1000, '60', '30', 1000, 1000, 'あり', 1000, '23区', '顔つきであればOK', NULL, 0, '2019-07-31 00:00:00', '2019-09-05 14:06:11'),
(7, 'testmail@gmail.com', ' rinda', 'rinda', '山本リンダ', '312345678', '東京都', '世田谷区上馬1-1-1 エルビル３F', '世田谷駅', '5', 1000, '60', '30', 1000, 1000, ' あり（有料）', 1000, '23区', '顔付き身分証', '2019-07-28', 0, '2019-07-28 00:00:00', '2019-09-05 14:06:22'),
(8, 'love@gmail.com', '$2y$10$nS.SekPYwlVi0tAfAbNR3./.kub8luINfDld8IQvhXMGidceYmaue', 'club love', '小林一郎', '0312345678', '東京都', '渋谷区東1-3-4 Gビル２階', '渋谷', '6', 500, '60', '30', 1000, 1000, '2', 1000, '23区', '顔つきであればOK', '2019-08-02', 0, '2019-08-02 16:01:37', '2019-09-05 14:06:27'),
(9, 'smile@gmail.com', '$2y$10$qHs9Nxr7BI0.emtq/gfdm.Jad2Fk99eH4NjDgGfSZ.CUcTiz5dquW', 'smile', '近藤雅彦', '0322222222', '埼玉県', '所沢市うんたら3-4-5 Tビル２階', '所沢駅', '1', 1000, '30', '15', 1000, 1000, 'あり（有料）', 2000, 'さいたま市内', '年齢確認のできる身分証必須', '2019-08-04', 0, '2019-08-04 20:01:31', '2019-09-05 14:05:59'),
(10, 'main@gmail.com', '$2y$10$6kuo7ZD1VVFE.1aKg.P8OeklgXI0uUSVxCsvp44LJBSAuwcBblr5G', 'club paradise', '三千院帝', '0321345654', '東京都', '中央区銀座1丁目5-4 オリエンタルビル4F', '銀座駅', '2', 1000, '60', '30', 1000, 1000, 'あり（有料）', 1000, '23区内と横浜市内', '顔付き身分証必須', '2019-08-14', 0, '2019-08-14 23:16:41', '2019-09-05 14:06:32');

-- --------------------------------------------------------

--
-- テーブルの構造 `tenpo_favo`
--

CREATE TABLE `tenpo_favo` (
  `user_id` int(11) NOT NULL,
  `delete_flg` tinyint(1) NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `tenpo_NG`
--

CREATE TABLE `tenpo_NG` (
  `user_id` int(11) NOT NULL,
  `delete_flg` tinyint(1) NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `pref` varchar(255) DEFAULT NULL,
  `addr` varchar(255) DEFAULT NULL,
  `station` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `login_time` datetime NOT NULL,
  `delete_flg` tinyint(1) NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `email`, `pass`, `username`, `year`, `tel`, `pref`, `addr`, `station`, `pic`, `login_time`, `delete_flg`, `create_date`, `update_date`) VALUES
(4, 'テスト', 'testtest', 'テストさん', 1990, '09011111111', '神奈川県', '川崎市麻生くテスト', '新百合ヶ丘', NULL, '2019-06-27 00:00:00', 0, '2019-06-28 00:00:00', '2019-06-27 19:29:23'),
(5, 'hatanorie@gmail.com', '$2y$10$cIFF8tgZmT0H2XhQJyGfs.kc7INWtMmlJh433kObYJIlnrP9ljBdK', '波多野莉恵', 1990, '09090073716', '神奈川県', '横浜市旭区鶴ケ峰, 1-40-5', '鶴ヶ峰駅', '', '2019-07-02 00:00:25', 0, '2019-07-02 00:00:25', '2019-07-22 07:49:06'),
(6, 'yamadagorou@gmail.com', '$2y$10$TVTsILHWq9YLSG80fB4zLul8xoe6ixafKLnDHVxkyTWDpIKins.1e', '山田智子', 1993, '09088888888', '青森県', '適当し適当', '青森駅', NULL, '2019-08-01 14:26:59', 0, '2019-08-01 14:26:59', '2019-08-01 05:26:59');

-- --------------------------------------------------------

--
-- テーブルの構造 `user_favo`
--

CREATE TABLE `user_favo` (
  `user_id` int(11) NOT NULL,
  `tenpo_id` int(11) NOT NULL,
  `delete_flg` tinyint(1) NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anken`
--
ALTER TABLE `anken`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `anken_rireki`
--
ALTER TABLE `anken_rireki`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oubo`
--
ALTER TABLE `oubo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenpo`
--
ALTER TABLE `tenpo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anken`
--
ALTER TABLE `anken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `anken_rireki`
--
ALTER TABLE `anken_rireki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `oubo`
--
ALTER TABLE `oubo`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tenpo`
--
ALTER TABLE `tenpo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
