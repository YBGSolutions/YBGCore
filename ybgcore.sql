/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : 127.0.0.1:3306
 Source Schema         : ybgcore

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 10/04/2021 17:23:01
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `menu_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `parent_id` smallint(6) NOT NULL DEFAULT 0 COMMENT '0: Label',
  `route_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` smallint(1) NOT NULL DEFAULT 0,
  `sort` smallint(2) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES (1, 'tachometer-alt', 'Trang chủ', 0, '/admin', 1, 0, '2020-12-26 02:41:33', '2021-03-09 00:23:48');
INSERT INTO `menus` VALUES (2, 'th', 'Cấu hình', 0, '/', 1, 0, '2020-12-26 02:41:44', '2020-12-29 01:47:39');
INSERT INTO `menus` VALUES (3, 'list', 'Quản lý danh mục', 2, '/admin/menus/index', 1, 0, '2020-12-26 02:58:23', '2021-03-03 23:00:21');
INSERT INTO `menus` VALUES (7, 'route', 'Quản lý Route', 2, '/admin/routes/index', 1, 1, '2020-12-29 01:40:20', '2021-03-03 23:00:34');
INSERT INTO `menus` VALUES (8, 'users', 'Users', 0, '/admin/users/index', 1, 3, '2020-12-30 01:02:17', '2021-04-04 17:05:17');
INSERT INTO `menus` VALUES (10, '', 'Quản lý', -1, '/', 1, 2, '2020-12-30 01:42:03', NULL);
INSERT INTO `menus` VALUES (11, 'users-cog', 'Nhóm người dùng', 0, '/admin/user-groups/index', 1, 4, '2020-12-30 01:46:10', '2021-04-04 17:05:05');
INSERT INTO `menus` VALUES (12, 'bug', 'Gii', 2, '/gii', 1, 1, '2020-12-30 01:49:12', NULL);
INSERT INTO `menus` VALUES (13, 'plug', 'Plugin', 0, '/plugins/index', 1, 5, '2021-01-04 00:27:33', '2021-01-04 00:28:21');

-- ----------------------------
-- Table structure for migration
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration`  (
  `version` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `apply_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`version`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', 1608229817);
INSERT INTO `migration` VALUES ('m201218_184009_create_table_user', 1608230557);

-- ----------------------------
-- Table structure for plugins
-- ----------------------------
DROP TABLE IF EXISTS `plugins`;
CREATE TABLE `plugins`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `plugin_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `state` smallint(1) NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for routes
-- ----------------------------
DROP TABLE IF EXISTS `routes`;
CREATE TABLE `routes`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `route_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` smallint(1) NOT NULL DEFAULT 0 COMMENT '0: disable, 1:enable',
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of routes
-- ----------------------------
INSERT INTO `routes` VALUES (1, 'site/index', 1, '2020-12-23 01:36:03', NULL);
INSERT INTO `routes` VALUES (2, 'routes/index', 1, '2020-12-23 01:42:45', NULL);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `group_id` smallint(6) NOT NULL DEFAULT -1,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE,
  UNIQUE INDEX `email`(`phone`) USING BTREE,
  UNIQUE INDEX `password_reset_token`(`password_reset_token`) USING BTREE,
  INDEX `fk_users_0`(`group_id`) USING BTREE,
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `user_groups` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', '', '$2y$13$C5hfiuNPF08dVs4KeH.54OS7sU9Nv731hXnphyjVUELhVVtfIkhB2', NULL, 'ngovihai.it@gmail.com', 1, 1, '2020-12-19 02:01:05', '2021-04-08 16:11:57');
INSERT INTO `user` VALUES (2, 'nghia123', 'e10adc3949ba59abbe56e057f20f883e', '$2y$13$0ytwFeA.H1cMdjd3t3Jqfe6meDELSHRIvvDt7qVAZxEJAYHGaun7O', NULL, '0888888888', 1, 1, '2021-04-05 19:17:15', '2021-04-08 16:13:03');

-- ----------------------------
-- Table structure for user_groups
-- ----------------------------
DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE `user_groups`  (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_groups
-- ----------------------------
INSERT INTO `user_groups` VALUES (1, 'Quản trị viên', 'Quản trị viên');
INSERT INTO `user_groups` VALUES (2, 'Vận hành', 'Vận hành');

SET FOREIGN_KEY_CHECKS = 1;
