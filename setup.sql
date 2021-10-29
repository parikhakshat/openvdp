-- Creating Database for OpenVDP`


CREATE DATABASE IF NOT EXISTS `openvdp` DEFAULT CHARACTER SET utf16 COLLATE utf16_bin;
USE `openvdp`;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` varchar(1000) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `content` text CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `email` varchar(1000) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `date` varchar(1000) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` varchar(1000) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `title` varchar(1000) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `content` varchar(1000) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `cvss` decimal(10,0) NOT NULL,
  `status` varchar(1000) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `createdby` varchar(1000) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `category` varchar(1000) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `date` varchar(1000) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `name` varchar(1000) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `email` varchar(1000) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `password` varchar(1000) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `id` varchar(1000) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `role` tinyint(1) NOT NULL,
  `color` varchar(1000) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;
