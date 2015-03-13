-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Erstellungszeit: 13. Mrz 2015 um 03:13
-- Server Version: 5.1.73-community
-- PHP-Version: 5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `dbwork`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ue4am_apps`
--

CREATE TABLE IF NOT EXISTS `ue4am_apps` (
`appid` int(255) NOT NULL COMMENT 'the id of the ue4 game',
  `token` varchar(255) NOT NULL COMMENT 'the assigned security token',
  `company` varchar(255) NOT NULL COMMENT 'the company behind',
  `contactemail` varchar(255) NOT NULL COMMENT 'the contact email'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table handles all apps by UE4AM_AppHandler' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ue4am_characters`
--

CREATE TABLE IF NOT EXISTS `ue4am_characters` (
`characterid` int(255) NOT NULL COMMENT 'The ID of the Character',
  `userid` int(255) NOT NULL COMMENT 'The associated User Account',
  `appid` int(255) NOT NULL COMMENT 'The associated AppID',
  `CharacterName` varchar(255) NOT NULL COMMENT 'The Name of the Character'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This is a base table for your game characters' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ue4am_messages`
--

CREATE TABLE IF NOT EXISTS `ue4am_messages` (
`messageid` int(255) NOT NULL COMMENT 'The Message ID',
  `userid_sender` int(255) NOT NULL COMMENT 'The Sender UID',
  `userid_receiver` int(255) NOT NULL COMMENT 'The Receiver UID',
  `title` varchar(255) NOT NULL COMMENT 'The Title of the Message',
  `text` text NOT NULL COMMENT 'The Text of the Message',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp when message has been sent',
  `hasRead` tinyint(1) NOT NULL COMMENT 'Boolean if message has been read'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Message Table for handling ingame messages (not chat)' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ue4am_users`
--

CREATE TABLE IF NOT EXISTS `ue4am_users` (
`userid` int(255) NOT NULL COMMENT 'The ID associated to the user',
  `appid` int(255) NOT NULL COMMENT 'The App ID this user account has been registered for',
  `username` varchar(255) NOT NULL COMMENT 'The name of the user',
  `email` varchar(255) NOT NULL COMMENT 'The contact E-Mail',
  `password` varchar(255) NOT NULL COMMENT 'The encrypted password',
  `userlevel` int(11) DEFAULT NULL COMMENT 'The Level of the user, default is 0',
  `regtimestamp` int(11) NOT NULL COMMENT 'The Registration Timestamp',
  `lastlogintimestamp` int(11) NOT NULL COMMENT 'The Last Login Timestamp',
  `lastpingtimestamp` int(11) NOT NULL COMMENT 'The Last Ping Timestamp',
  `active` tinyint(1) NOT NULL COMMENT 'Boolean if account is enabled/disabled or banned'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table handles all user accounts - UE4AM_AccountHandler' AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ue4am_apps`
--
ALTER TABLE `ue4am_apps`
 ADD PRIMARY KEY (`appid`);

--
-- Indexes for table `ue4am_characters`
--
ALTER TABLE `ue4am_characters`
 ADD PRIMARY KEY (`characterid`);

--
-- Indexes for table `ue4am_messages`
--
ALTER TABLE `ue4am_messages`
 ADD PRIMARY KEY (`messageid`);

--
-- Indexes for table `ue4am_users`
--
ALTER TABLE `ue4am_users`
 ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ue4am_apps`
--
ALTER TABLE `ue4am_apps`
MODIFY `appid` int(255) NOT NULL AUTO_INCREMENT COMMENT 'the id of the ue4 game';
--
-- AUTO_INCREMENT for table `ue4am_characters`
--
ALTER TABLE `ue4am_characters`
MODIFY `characterid` int(255) NOT NULL AUTO_INCREMENT COMMENT 'The ID of the Character';
--
-- AUTO_INCREMENT for table `ue4am_messages`
--
ALTER TABLE `ue4am_messages`
MODIFY `messageid` int(255) NOT NULL AUTO_INCREMENT COMMENT 'The Message ID';
--
-- AUTO_INCREMENT for table `ue4am_users`
--
ALTER TABLE `ue4am_users`
MODIFY `userid` int(255) NOT NULL AUTO_INCREMENT COMMENT 'The ID associated to the user';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
