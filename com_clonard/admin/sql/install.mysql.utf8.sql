CREATE TABLE IF NOT EXISTS `#__clonard_parents` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(4) NOT NULL,
  `name` varchar(40) NOT NULL,
  `surname` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL default '',
  `cell` int(12) default NULL,
  `phone` int(13) NOT NULL,
  `fax` int(13) default NULL,
  `city` varchar(40) NOT NULL default '',
  `province` varchar(40) NOT NULL default '',
  `address` text NOT NULL,
  `code` varchar(10) NOT NULL,
  `postaladd` text NOT NULL,
  `postalcode` varchar(10) NOT NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__clonard_students` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL,
  `grade` int(11) NOT NULL,
  `gradepassed` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `surname` varchar(40) NOT NULL,
  `dob` varchar(12) NOT NULL,
  `gender` varchar(4) NOT NULL,
  `afrikaans` varchar(6) default NULL,
  `maths` varchar(11) default NULL,
  `choice` varchar(40) default NULL,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__clonard_grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grade` tinyint(2) NOT NULL,
  `price` int(11) NOT NULL,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__cld_grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grade` int(2) NOT NULL,
  `academic_year` int(4) NOT NULL,
  `price` int(11) NOT NULL,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__clonard_refundables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `grade` int(2) NOT NULL,
  `choice_subject` varchar(40) NOT NULL default '', 
  `academic_year` int(4) NOT NULL,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__clonard_refunds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bookid` int(11) NOT NULL,
  `gradeid` int(11) NOT NULL,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__clonard_books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `grade` tinyint(2) NOT NULL,
  `price` int(11) NOT NULL,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__clonard_orders` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL,
  `child` int(11) NOT NULL,
  `grade` tinyint(1) NOT NULL,
  `books` mediumtext NOT NULL,
  `paid` tinyint(1) NOT NULL default '0',
  `comments` mediumtext default '',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `child` (`child`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;