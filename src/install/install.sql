SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `Photobook_Book` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `Photobook_CMD` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CMD` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE IF NOT EXISTS `Photobook_Element` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PageID` int(11) NOT NULL,
  `Name` varchar(64) COLLATE latin1_german1_ci NOT NULL,
  `X` double NOT NULL,
  `Y` double NOT NULL,
  `Z` int(11) NOT NULL,
  `PictureID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `W` double NOT NULL,
  `H` double NOT NULL,
  `R` double NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE IF NOT EXISTS `Photobook_Feedback` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Time` int(11) NOT NULL,
  `Text` text NOT NULL,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `Photobook_Gallery` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL,
  `Public` tinyint(1) NOT NULL DEFAULT '0',
  `Created` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `Photobook_Page` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `BookID` int(11) NOT NULL,
  `Site` int(11) NOT NULL,
  `Title` varchar(64) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE IF NOT EXISTS `Photobook_Picture` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `W` int(11) NOT NULL,
  `H` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `GalleryID` int(11) NOT NULL,
  `Name` varchar(64) COLLATE latin1_german1_ci NOT NULL,
  `NameOnServer` varchar(64) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE IF NOT EXISTS `Photobook_Session` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Cookie` varchar(64) COLLATE latin1_german1_ci NOT NULL,
  `UserID` int(11) NOT NULL,
  `Code` varchar(8) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE IF NOT EXISTS `Photobook_Text` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PageID` int(11) NOT NULL,
  `Name` varchar(64) COLLATE latin1_german1_ci NOT NULL,
  `X` double NOT NULL,
  `Y` double NOT NULL,
  `Z` int(11) NOT NULL,
  `R` double NOT NULL,
  `Text` text COLLATE latin1_german1_ci NOT NULL,
  `UserID` int(11) NOT NULL,
  `Size` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE IF NOT EXISTS `Photobook_User` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(32) COLLATE latin1_german1_ci NOT NULL,
  `Password_SHA1` varchar(40) COLLATE latin1_german1_ci NOT NULL,
  `Mail` varchar(128) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
