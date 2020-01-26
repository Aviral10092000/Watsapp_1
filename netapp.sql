CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `messagelist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `senderId` varchar(11),
  `reciverId` varchar(255),
  `message` varchar(255),
  `type` varchar(255),
  `status` varchar(255),
  `deleted` int(255),
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `contactlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `senderId` varchar(11),
  `reciverId` varchar(255),
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `images` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `username` varchar(255),
 `imageLocation` varchar(255),
 `description` varchar(255),
 `image` longblob NOT NULL,
 `created` datetime DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

