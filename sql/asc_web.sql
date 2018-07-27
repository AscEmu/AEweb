/*
asc_web database

Date: 2018-07-27 11:07:17
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

-- ----------------------------
-- Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL DEFAULT '1',
  `title` varchar(200) NOT NULL DEFAULT '',
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `text` longtext,
  `image` varchar(300) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `slideshow`
-- ----------------------------
DROP TABLE IF EXISTS `slideshow`;
CREATE TABLE `slideshow` (
  `sort` int(1) NOT NULL AUTO_INCREMENT,
  `imageName` varchar(200) NOT NULL DEFAULT '',
  `caption` varchar(200) NOT NULL DEFAULT '',
  `author` varchar(60) NOT NULL DEFAULT 'Unknown',
  PRIMARY KEY (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of slideshow
-- ----------------------------
INSERT INTO `slideshow` VALUES ('1', 'bg-01.jpg', 'Background 1 :-)', 'schnek');
INSERT INTO `slideshow` VALUES ('2', 'bg-02.jpg', 'Background two.', 'Unknown');
INSERT INTO `slideshow` VALUES ('3', 'bg-03.jpg', 'Background 3', 'schnek');
INSERT INTO `slideshow` VALUES ('4', 'bg-04.jpg', 'Background four ;-(', 'Unknown');