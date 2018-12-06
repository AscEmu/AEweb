SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `board_categories`
-- ----------------------------
DROP TABLE IF EXISTS `board_categories`;
CREATE TABLE `board_categories` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of board_categories
-- ----------------------------
INSERT INTO `board_categories` VALUES ('1', 'Announcements', 'All announcements');
INSERT INTO `board_categories` VALUES ('2', 'Class Discussion', 'Everything about classes');

-- ----------------------------
-- Table structure for `board_posts`
-- ----------------------------
DROP TABLE IF EXISTS `board_posts`;
CREATE TABLE `board_posts` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `topic_id` int(8) NOT NULL,
  `user_id` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of board_posts
-- ----------------------------

-- ----------------------------
-- Table structure for `board_topics`
-- ----------------------------
DROP TABLE IF EXISTS `board_topics`;
CREATE TABLE `board_topics` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `category_id` int(8) NOT NULL,
  `user_id` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of board_topics
-- ----------------------------
INSERT INTO `board_topics` VALUES ('1', 'Server Opening', '2018-12-06 16:32:09', '1', '1');
INSERT INTO `board_topics` VALUES ('2', 'Looking for Staff', '2018-12-06 16:32:31', '1', '1');
INSERT INTO `board_topics` VALUES ('3', 'Mage OP', '2018-12-06 16:32:47', '2', '1');
