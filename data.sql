-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        8.0.12 - MySQL Community Server - GPL
-- 服务器操作系统:                      Win64
-- HeidiSQL 版本:                  12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- 导出 cloud 的数据库结构
DROP DATABASE IF EXISTS `cloud`;
CREATE DATABASE IF NOT EXISTS `cloud` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `cloud`;

-- 导出  表 cloud.admin_pwd 结构
DROP TABLE IF EXISTS `admin_pwd`;
CREATE TABLE IF NOT EXISTS `admin_pwd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pwd` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='管理员动态密码';

-- 正在导出表  cloud.admin_pwd 的数据：1 rows
DELETE FROM `admin_pwd`;
/*!40000 ALTER TABLE `admin_pwd` DISABLE KEYS */;
INSERT INTO `admin_pwd` (`id`, `pwd`) VALUES
	(1, 'Lf70');
/*!40000 ALTER TABLE `admin_pwd` ENABLE KEYS */;

-- 导出  表 cloud.feedback 结构
DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `content` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户反馈';

-- 正在导出表  cloud.feedback 的数据：0 rows
DELETE FROM `feedback`;
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;

-- 导出  表 cloud.files 结构
DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `filename` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `filedate` datetime NOT NULL,
  `filesize` int(11) NOT NULL,
  `filepath` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '0正常，1回收站',
  `share` int(11) NOT NULL DEFAULT '1' COMMENT '0已分享，1未分享',
  `share-key` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '未分享' COMMENT '分享链接',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户文件及状态';

-- 正在导出表  cloud.files 的数据：7 rows
DELETE FROM `files`;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` (`id`, `uid`, `filename`, `filedate`, `filesize`, `filepath`, `state`, `share`, `share-key`) VALUES
	(6, 1, 'install-all-users.vbs', '2024-06-11 18:51:58', 2426, '../writable/uploads/1/install-all-users.vbs', 1, 1, '未分享'),
	(8, 1, 'install-current-user.vbs', '2024-06-11 18:51:58', 1811, '../writable/uploads/1/install-current-user.vbs', 0, 1, '未分享'),
	(10, 1, 'uninstall-all-users.vbs', '2024-06-11 18:51:58', 1065, '../writable/uploads/1/uninstall-all-users.vbs', 0, 1, '未分享'),
	(11, 1, 'uninstall-current-user.vbs', '2024-06-11 18:51:59', 749, '../writable/uploads/1/uninstall-current-user.vbs', 1, 1, '未分享'),
	(15, 1, 'sha1sum.txt', '2024-06-11 18:52:47', 2278, '../writable/uploads/1/sha1sum.txt', 0, 1, '未分享'),
	(16, 1, 'settings.xml', '2024-07-07 21:11:57', 10780, '../writable/uploads/1/settings.xml', 0, 1, '未分享'),
	(17, 1, 'toolchains.xml', '2024-07-07 21:16:28', 3645, '../writable/uploads/1/toolchains.xml', 0, 1, '未分享');
/*!40000 ALTER TABLE `files` ENABLE KEYS */;

-- 导出  存储过程 cloud.generate_random_password 结构
DROP PROCEDURE IF EXISTS `generate_random_password`;
DELIMITER //
CREATE PROCEDURE `generate_random_password`()
BEGIN
    DECLARE random_pwd VARCHAR(4);
    
    -- 生成4位由字母和数字组成的随机密码
    SET random_pwd = (
        SELECT CONCAT(
            CHAR(FLOOR(65 + (RAND() * 26))),  -- 随机大写字母
            CHAR(FLOOR(97 + (RAND() * 26))),  -- 随机小写字母
            CHAR(FLOOR(48 + (RAND() * 10))),  -- 随机数字
            CHAR(FLOOR(48 + (RAND() * 10)))   -- 随机数字
        )
    );

    -- 更新密码，假设 id = 1 为你要更新的行
    UPDATE admin_pwd SET pwd = random_pwd WHERE id = 1;
END//
DELIMITER ;

-- 导出  事件 cloud.update_admin_pwd_event 结构
DROP EVENT IF EXISTS `update_admin_pwd_event`;
DELIMITER //
CREATE EVENT `update_admin_pwd_event` ON SCHEDULE EVERY 1 DAY STARTS '2024-09-12 22:09:27' ON COMPLETION NOT PRESERVE ENABLE DO CALL generate_random_password()//
DELIMITER ;

-- 导出  表 cloud.user 结构
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `uemail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `upwd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `udate` date NOT NULL,
  `ulv` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '1',
  `reset_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '找回验证码',
  `reset_code_expiry` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '验证码有效期',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户信息';

-- 正在导出表  cloud.user 的数据：~2 rows (大约)
DELETE FROM `user`;
INSERT INTO `user` (`uid`, `uemail`, `upwd`, `udate`, `ulv`, `reset_code`, `reset_code_expiry`) VALUES
	(1, '1781160263@qq.com', '$2y$10$2Lj7qvqJt0.igAMrvL9mluxKCshiSviuZUwTK4vjsGyswXeZImzPW', '2024-03-24', '3', '574206', '1717579106'),
	(2, 'test@qq.com', '123', '2024-05-13', '1', NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
