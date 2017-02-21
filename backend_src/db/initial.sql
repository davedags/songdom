CREATE TABLE `song` (
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
