SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `Photobook_CMD` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CMD` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE IF NOT EXISTS `Photobook_Element` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Seite_ID` int(11) NOT NULL,
  `Session_ID` int(11) NOT NULL,
  `Name` varchar(64) COLLATE latin1_german1_ci NOT NULL,
  `X` double NOT NULL,
  `Y` double NOT NULL,
  `Z` int(11) NOT NULL,
  `Bild_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `W` double NOT NULL,
  `H` double NOT NULL,
  `R` double NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE IF NOT EXISTS `Photobook_Page` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Seite` int(11) NOT NULL,
  `Titel` varchar(64) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE IF NOT EXISTS `Photobook_Picture` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `W` int(11) NOT NULL,
  `H` int(11) NOT NULL,
  `Session_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Name` varchar(64) COLLATE latin1_german1_ci NOT NULL,
  `NameOnServer` varchar(64) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE IF NOT EXISTS `Photobook_Session` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Cookie` varchar(64) COLLATE latin1_german1_ci NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Code` varchar(8) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE IF NOT EXISTS `Photobook_Text` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Seite_ID` int(11) NOT NULL,
  `Session_ID` int(11) NOT NULL,
  `Name` varchar(64) COLLATE latin1_german1_ci NOT NULL,
  `X` double NOT NULL,
  `Y` double NOT NULL,
  `Z` int(11) NOT NULL,
  `R` double NOT NULL,
  `Text` text COLLATE latin1_german1_ci NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Size` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE IF NOT EXISTS `Photobook_User` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(32) COLLATE latin1_german1_ci NOT NULL,
  `Password_SHA1` varchar(40) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
