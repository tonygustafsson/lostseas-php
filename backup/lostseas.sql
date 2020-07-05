-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Värd: db
-- Tid vid skapande: 14 jun 2020 kl 09:42
-- Serverversion: 8.0.20
-- PHP-version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `lostseas`
--

CREATE DATABASE lostseas;
USE lostseas;

-- --------------------------------------------------------

--
-- Tabellstruktur `ls_crew`
--

CREATE TABLE `ls_crew` (
  `id` int NOT NULL,
  `user_id` varchar(20) NOT NULL DEFAULT '0',
  `nationality` varchar(15) DEFAULT NULL,
  `gender` varchar(1) NOT NULL,
  `created` int NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `doubloons` int NOT NULL DEFAULT '0',
  `mood` tinyint NOT NULL DEFAULT '10',
  `health` tinyint NOT NULL DEFAULT '100',
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `ls_game`
--

CREATE TABLE `ls_game` (
  `user_id` varchar(20) NOT NULL DEFAULT '0',
  `character_name` varchar(50) NOT NULL,
  `character_avatar` tinyint NOT NULL DEFAULT '1',
  `character_gender` varchar(1) NOT NULL,
  `character_age` tinyint NOT NULL DEFAULT '0',
  `character_description` text,
  `nationality` varchar(20) NOT NULL DEFAULT '0',
  `town` varchar(20) NOT NULL,
  `place` varchar(20) NOT NULL,
  `week` int NOT NULL DEFAULT '1',
  `title` varchar(20) NOT NULL,
  `doubloons` int NOT NULL DEFAULT '300',
  `bank_account` int NOT NULL DEFAULT '0',
  `bank_loan` int NOT NULL DEFAULT '0',
  `cannons` int NOT NULL DEFAULT '2',
  `prisoners` int NOT NULL DEFAULT '0',
  `food` int NOT NULL DEFAULT '20',
  `water` int NOT NULL DEFAULT '40',
  `porcelain` int NOT NULL DEFAULT '0',
  `spices` int NOT NULL DEFAULT '0',
  `silk` int NOT NULL DEFAULT '0',
  `tobacco` int NOT NULL DEFAULT '0',
  `rum` int NOT NULL DEFAULT '0',
  `medicine` int NOT NULL DEFAULT '0',
  `rafts` int NOT NULL DEFAULT '1',
  `victories_england` int NOT NULL DEFAULT '0',
  `victories_france` int NOT NULL DEFAULT '0',
  `victories_spain` int NOT NULL DEFAULT '0',
  `victories_holland` int NOT NULL DEFAULT '0',
  `victories_pirates` int NOT NULL DEFAULT '0',
  `event` text DEFAULT NULL,
  `event_work` varchar(128) DEFAULT NULL,
  `event_ship` varchar(128) DEFAULT NULL,
  `event_ship_won` varchar(256) DEFAULT NULL,
  `event_ocean_trade` varchar(128) DEFAULT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `ls_history`
--

CREATE TABLE `ls_history` (
  `id` int NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `week` int NOT NULL,
  `doubloons` int NOT NULL,
  `ships` int NOT NULL,
  `crew_members` int NOT NULL,
  `crew_mood` int NOT NULL,
  `crew_health` int NOT NULL,
  `cannons` int NOT NULL,
  `stock_value` int NOT NULL,
  `level` int NOT NULL,
  `victories` int NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `ls_log`
--

CREATE TABLE `ls_log` (
  `id` int NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `time` datetime NOT NULL,
  `week` int NOT NULL,
  `entry` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `ls_ship`
--

CREATE TABLE `ls_ship` (
  `id` int NOT NULL,
  `user_id` varchar(20) NOT NULL DEFAULT '0',
  `type` varchar(20) NOT NULL,
  `age` int NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `health` tinyint NOT NULL DEFAULT '100'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `ls_user`
--

CREATE TABLE `ls_user` (
  `id` varchar(20) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(40) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `birthday` datetime DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `new_email` varchar(50) DEFAULT NULL,
  `presentation` text,
  `music_play` tinyint(1) NOT NULL DEFAULT '1',
  `music_volume` tinyint NOT NULL DEFAULT '100',
  `sound_effects_play` tinyint(1) NOT NULL DEFAULT '1',
  `show_gender` tinyint(1) NOT NULL DEFAULT '1',
  `show_age` tinyint(1) NOT NULL DEFAULT '1',
  `notify_new_messages` tinyint(1) NOT NULL DEFAULT '1',
  `new_messages` tinyint NOT NULL DEFAULT '0',
  `password_pin` varchar(32) DEFAULT NULL,
  `email_pin` varchar(32) DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `ls_crew`
--
ALTER TABLE `ls_crew`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `ls_game`
--
ALTER TABLE `ls_game`
  ADD PRIMARY KEY (`user_id`);

--
-- Index för tabell `ls_history`
--
ALTER TABLE `ls_history`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `ls_log`
--
ALTER TABLE `ls_log`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `ls_ship`
--
ALTER TABLE `ls_ship`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `ls_user`
--
ALTER TABLE `ls_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `ls_crew`
--
ALTER TABLE `ls_crew`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4764;

--
-- AUTO_INCREMENT för tabell `ls_history`
--
ALTER TABLE `ls_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3783;

--
-- AUTO_INCREMENT för tabell `ls_log`
--
ALTER TABLE `ls_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11301;

--
-- AUTO_INCREMENT för tabell `ls_ship`
--
ALTER TABLE `ls_ship`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=805;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
