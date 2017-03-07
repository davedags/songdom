CREATE TABLE if not exists `song` (
  `song_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `lyrics` text,
  `keywords` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`song_id`),
  KEY `title_key` (`title`),
  KEY `keywords_key` (`keywords`),
  KEY `url_key` (`url`),
  FULLTEXT idx (`lyrics`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE if not exists `user` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `username` (`username`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

