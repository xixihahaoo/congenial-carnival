/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50538
Source Host           : localhost:3306
Source Database       : jhpay

Target Server Type    : MYSQL
Target Server Version : 50538
File Encoding         : 65001

Date: 2016-08-08 21:30:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `jhpay_wx_user`
-- ----------------------------
DROP TABLE IF EXISTS `jhpay_wx_user`;
CREATE TABLE `jhpay_wx_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) DEFAULT NULL,
  `score` int(10) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `sex` int(2) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `headimgurl` varchar(255) DEFAULT NULL,
  `privilege` varchar(255) DEFAULT NULL,
  `unionid` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jhpay_wx_user
-- ----------------------------
