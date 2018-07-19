/*
asc_web database

Date: 2018-07-20 00:45:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(6) NOT NULL COMMENT 'account id',
  `displayName` varchar(20) DEFAULT '' COMMENT 'The displayed name (not account name!)',
  `avatar` varchar(200) DEFAULT 'default.jpg' COMMENT 'name of the avatar in uploads/avatars',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;