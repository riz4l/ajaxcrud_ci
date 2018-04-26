-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 26 Apr 2018 pada 05.16
-- Versi Server: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ajaxcrud_ci`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_article`
--

CREATE TABLE IF NOT EXISTS `table_article` (
`article_id` int(11) NOT NULL,
  `article_title` varchar(300) NOT NULL,
  `article_teaser` text NOT NULL,
  `article_content` longtext NOT NULL,
  `article_slug` varchar(350) NOT NULL,
  `article_createdate` datetime NOT NULL,
  `article_publishdate` datetime NOT NULL,
  `article_image` varchar(250) NOT NULL,
  `article_category_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `table_article`
--

INSERT INTO `table_article` (`article_id`, `article_title`, `article_teaser`, `article_content`, `article_slug`, `article_createdate`, `article_publishdate`, `article_image`, `article_category_id`) VALUES
(1, 'Article ini merupakan untuk test', 'Article ini merupakan untuk test lorem ipsum', '<p>Article ini merupakan untuk test lorem ipsum doler silamet</p>', 'Article-ini-merupakan-untuk-test', '2018-04-26 08:49:08', '2018-04-26 10:49:40', '550px-Kickflip-on-a-Skateboard-Step-11.jpg', 2),
(2, 'article with category', 'articke dengan kategori', '<p>article dengan kategori baru dimuat</p>', 'article-with-category', '2018-04-26 09:31:48', '2018-04-26 09:32:07', 'no_image.png', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_category`
--

CREATE TABLE IF NOT EXISTS `table_category` (
`category_id` int(11) NOT NULL,
  `category_name` varchar(150) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `table_category`
--

INSERT INTO `table_category` (`category_id`, `category_name`) VALUES
(1, 'Wisata'),
(2, 'Sport'),
(3, 'News');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_article`
--
ALTER TABLE `table_article`
 ADD PRIMARY KEY (`article_id`);

--
-- Indexes for table `table_category`
--
ALTER TABLE `table_category`
 ADD PRIMARY KEY (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_article`
--
ALTER TABLE `table_article`
MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `table_category`
--
ALTER TABLE `table_category`
MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
