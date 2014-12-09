-- $Id: install.mysql.utf8.sql 24 2009-11-09 11:56:31Z chdemko $

DROP TABLE IF EXISTS `#__petrocketmailer_templates`;

CREATE TABLE `#__petrocketmailer_templates` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `template` MEDIUMTEXT NOT NULL,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__petrocketmailer_templates` (`title`, `template`) VALUES
	('Test Template', '<p>This is a test email template from {sender}</p>');
