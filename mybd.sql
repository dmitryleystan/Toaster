-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Час створення: Трв 07 2014 р., 10:50
-- Версія сервера: 5.5.35
-- Версія PHP: 5.3.10-1ubuntu3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- БД: `mybd`
--

-- --------------------------------------------------------

--
-- Структура таблиці `tests`
--

CREATE TABLE IF NOT EXISTS `tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'serial',
  `idsub` int(11) NOT NULL COMMENT 'serial_of_subject',
  `name` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'name_of_test',
  `cost1` int(11) NOT NULL DEFAULT '1',
  `cost2` int(11) NOT NULL DEFAULT '1',
  `cost3` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

--
-- Дамп даних таблиці `tests`
--

INSERT INTO `tests` (`id`, `idsub`, `name`, `cost1`, `cost2`, `cost3`) VALUES
(71, 12, 'Студентський тест', 1, 2, 3),
(72, 12, 'Логічний тест', 1, 1, 1),
(73, 12, 'Звичайний тест', 1, 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
