-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `perevents_args`;
CREATE TABLE `perevents_args` (
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `perevent_id` int(11) NOT NULL,
  KEY `perevent_id` (`perevent_id`),
  CONSTRAINT `perevents_args_ibfk_1` FOREIGN KEY (`perevent_id`) REFERENCES `perevents` (`perevent_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `perevents_args` (`key`, `value`, `perevent_id`) VALUES
('key1',	'value1',	82),
('key2',	'value2',	82),
('key1',	'value1',	83),
('key2',	'value2',	83);

-- 2017-09-02 13:36:40
