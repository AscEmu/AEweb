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