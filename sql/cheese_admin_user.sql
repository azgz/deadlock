CREATE TABLE `cheese_admin_user` (
  `email` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `update_date` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`email`)
);