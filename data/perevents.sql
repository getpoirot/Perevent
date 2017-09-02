-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `perevents`;
CREATE TABLE `perevents` (
  `perevent_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) NOT NULL,
  `exec_map` text NOT NULL,
  `expaired_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`perevent_id`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `perevents` (`perevent_id`, `uid`, `exec_map`, `expaired_at`, `created_at`) VALUES
(82,	'1',	'addmape',	'2017-09-02 17:57:53',	'2017-09-02 17:57:53'),
(83,	'2',	'addmape',	'2017-09-02 17:58:08',	'2017-09-02 17:58:08');

-- 2017-09-02 13:36:09
