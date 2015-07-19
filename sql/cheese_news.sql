CREATE TABLE `cheese_news` (
  `news_id` int(12) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(64) NOT NULL,
  `news_headline` varchar(128) NOT NULL,
  `news_detail` varchar(1024) NOT NULL,
  `update_date` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`news_id`)
) ;