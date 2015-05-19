-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 18 2015 г., 17:01
-- Версия сервера: 5.5.11
-- Версия PHP: 5.4.34

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `statistic`
--

CREATE TABLE IF NOT EXISTS `statistic` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `day` char(3) DEFAULT NULL,
  `dt` char(8) DEFAULT NULL,
  `tm` char(5) DEFAULT NULL,
  `refer` text,
  `ip` char(64) DEFAULT NULL,
  `proxy` char(64) DEFAULT NULL,
  `host` char(64) DEFAULT NULL,
  `lang` char(2) DEFAULT NULL,
  `user` text,
  `req` text,
  `timestamp` int(11) unsigned DEFAULT NULL,
  `userhash` varchar(255) DEFAULT NULL,
  `robot` varchar(60) DEFAULT NULL,
  `country` varchar(200) DEFAULT NULL,
  `region` varchar(200) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `timestamp` (`timestamp`),
  KEY `ip` (`ip`),
  KEY `lang` (`lang`),
  KEY `refer` (`refer`(255)),
  KEY `req` (`req`(255)),
  KEY `user` (`user`(255)),
  KEY `host` (`host`),
  KEY `userhash` (`userhash`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=537 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
