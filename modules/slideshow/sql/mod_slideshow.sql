/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : asc_web

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-07-21 13:54:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `mod_slideshow`
-- ----------------------------
DROP TABLE IF EXISTS `mod_slideshow`;
CREATE TABLE `mod_slideshow` (
  `sort` int(1) NOT NULL AUTO_INCREMENT,
  `imageName` varchar(200) NOT NULL DEFAULT '',
  `caption` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_slideshow
-- ----------------------------
INSERT INTO `mod_slideshow` VALUES ('1', 'bg-01.jpg', 'Background 1 :-)');
INSERT INTO `mod_slideshow` VALUES ('2', 'bg-02.jpg', 'Background two.');
INSERT INTO `mod_slideshow` VALUES ('3', 'bg-03.jpg', 'Background 3');
INSERT INTO `mod_slideshow` VALUES ('4', 'bg-04.jpg', 'Background four ;-(');
