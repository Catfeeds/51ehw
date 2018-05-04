# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 192.168.10.139 (MySQL 5.7.12)
# Database: 9thleaf_51ehw
# Generation Time: 2018-05-04 07:00:33 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table 9thleaf_action_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_action_log`;

CREATE TABLE `9thleaf_action_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `id_account` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID，如果用户未登录，则为0',
  `from_url` varchar(800) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '来源，来源为空时是直接访问',
  `current_url` varchar(800) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '当前页',
  `created_at` datetime NOT NULL COMMENT '发生时间',
  `user_agent` varchar(400) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '访问浏览器的头数据',
  `server_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '访问地址',
  `request_uri` varchar(800) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '参数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='前台运行日志';



# Dump of table 9thleaf_activity
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_activity`;

CREATE TABLE `9thleaf_activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `activity_title` varchar(64) NOT NULL DEFAULT '' COMMENT '活动名称',
  `activity_start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activity_end_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bg_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '背景类型0颜色1图片',
  `bg_color` varchar(128) NOT NULL DEFAULT '#cccccc' COMMENT '背景颜色',
  `bg_img` varchar(128) NOT NULL DEFAULT '' COMMENT '背景图片',
  `activity_type` varchar(32) NOT NULL DEFAULT '1' COMMENT '活动内容扩展类型（表名）1.activity_details',
  `activity_temp_path` varchar(64) NOT NULL DEFAULT '' COMMENT '活动模板路径（每个活动都不同）',
  `base_temp_id` int(11) DEFAULT NULL COMMENT '模板路径（基层）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='活动列表（使用模板）';



# Dump of table 9thleaf_activity_details
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_activity_details`;

CREATE TABLE `9thleaf_activity_details` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) DEFAULT NULL COMMENT '活动id',
  `model` int(11) DEFAULT NULL COMMENT '模块',
  `display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示0否1是',
  `model_title` varchar(64) NOT NULL DEFAULT '' COMMENT '标题',
  `model_date` date NOT NULL COMMENT '活动日期',
  `coupon_item` text NOT NULL COMMENT '优惠券，json格式{[“title”:””,“images”:””,”price”:””,”url”:””,”package_id”:””,start_time:””,”end_time”:””]}',
  `product_item` text NOT NULL COMMENT '商品，json格式{[“title”:””,“images”:””,”price”:””,”url”:””,”market_price”:””]}',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='活动列表详情';



# Dump of table 9thleaf_activity_record
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_activity_record`;

CREATE TABLE `9thleaf_activity_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `activity_num` varchar(128) DEFAULT '' COMMENT '活动编号',
  `type` tinyint(2) DEFAULT '1' COMMENT '1:拼团活动',
  `product_id` int(11) DEFAULT NULL COMMENT '商品ID',
  `start_time` datetime DEFAULT NULL COMMENT '活动开始时间',
  `end_time` datetime DEFAULT NULL COMMENT '活动结束时间',
  `status` tinyint(2) DEFAULT '2' COMMENT '1:通过 2:新建 3:申请中 4:不通过',
  `groupbuy_price` decimal(9,2) DEFAULT NULL COMMENT '团购价',
  `menber_num` int(11) DEFAULT NULL COMMENT '成团人数',
  `corporation_id` int(11) DEFAULT NULL COMMENT '申请店铺ID',
  `remarks` text COMMENT '活动说明',
  `set_limit` tinyint(2) DEFAULT '0' COMMENT '0:不限购 1:限购',
  `least_purchase` int(11) DEFAULT NULL COMMENT '最小购买数量',
  `most_purchase` int(11) DEFAULT NULL COMMENT '最大购买数量',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='活动申请记录表';



# Dump of table 9thleaf_activity_template
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_activity_template`;

CREATE TABLE `9thleaf_activity_template` (
  `template_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `template_name` varchar(128) NOT NULL COMMENT '模板名称',
  `base_temp_path` varchar(96) NOT NULL DEFAULT '' COMMENT '模板路径',
  `cover_image` varchar(64) NOT NULL DEFAULT '' COMMENT '预览图片',
  `app_id` int(11) NOT NULL DEFAULT '0' COMMENT '公司id',
  `zip_name` varchar(11) NOT NULL DEFAULT '',
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='活动模板表【供新建活动时选择】';



# Dump of table 9thleaf_ad_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_ad_info`;

CREATE TABLE `9thleaf_ad_info` (
  `ad_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `po_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '位置',
  `title` varchar(120) DEFAULT '' COMMENT '广告标题',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '连接地址',
  `img_url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  `is_blank` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否弹开新窗口',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `section_id` int(11) DEFAULT '0',
  `app_id` int(11) DEFAULT '-1' COMMENT '应用ID',
  `corporation_id` int(11) NOT NULL DEFAULT '-1' COMMENT '企业ID',
  `act_start_time` datetime DEFAULT NULL COMMENT '活动开始时间',
  `act_end_time` datetime DEFAULT NULL COMMENT '活动结束时间',
  `url2` varchar(255) NOT NULL DEFAULT '' COMMENT '连接地址2',
  `img_url2` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址2',
  `url3` varchar(255) NOT NULL DEFAULT '' COMMENT '连接地址3',
  `img_url3` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址3',
  `url4` varchar(255) NOT NULL DEFAULT '' COMMENT '连接地址4',
  `img_url4` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址4',
  `url5` varchar(255) NOT NULL DEFAULT '' COMMENT '连接地址5',
  `img_url5` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址5',
  PRIMARY KEY (`ad_id`),
  KEY `po_id_index` (`po_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告信息表';



# Dump of table 9thleaf_ad_position
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_ad_position`;

CREATE TABLE `9thleaf_ad_position` (
  `po_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `po_name` varchar(90) NOT NULL DEFAULT '' COMMENT '位置名称',
  `po_sign` varchar(60) NOT NULL DEFAULT '' COMMENT '位置标识',
  `width` mediumint(5) DEFAULT NULL COMMENT '宽度',
  `height` mediumint(5) DEFAULT NULL COMMENT '高度',
  PRIMARY KEY (`po_id`),
  KEY `po_id_index` (`po_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告位置表';



# Dump of table 9thleaf_admin_action
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_admin_action`;

CREATE TABLE `9thleaf_admin_action` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(6) NOT NULL COMMENT '上级ID',
  `action_code` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '行为代码',
  `cn_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '中文名',
  `module_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='权限操作代码表';



# Dump of table 9thleaf_admin_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_admin_history`;

CREATE TABLE `9thleaf_admin_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL COMMENT '管理员ID',
  `module_id` int(11) NOT NULL DEFAULT '0' COMMENT '系统模块ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作历史纪录';



# Dump of table 9thleaf_admin_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_admin_log`;

CREATE TABLE `9thleaf_admin_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `log_info` text NOT NULL,
  `ip_address` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`log_id`),
  KEY `log_time` (`log_time`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员操作日志';



# Dump of table 9thleaf_admin_log_copy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_admin_log_copy`;

CREATE TABLE `9thleaf_admin_log_copy` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `log_info` text NOT NULL,
  `ip_address` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`log_id`),
  KEY `log_time` (`log_time`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员操作日志';



# Dump of table 9thleaf_admin_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_admin_sessions`;

CREATE TABLE `9thleaf_admin_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table 9thleaf_admin_sessions1
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_admin_sessions1`;

CREATE TABLE `9thleaf_admin_sessions1` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='前台Session记录表';



# Dump of table 9thleaf_admin_sessions2
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_admin_sessions2`;

CREATE TABLE `9thleaf_admin_sessions2` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='前台Session记录表';



# Dump of table 9thleaf_admin_usage
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_admin_usage`;

CREATE TABLE `9thleaf_admin_usage` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL COMMENT '管理员ID',
  `system_module_id` int(11) NOT NULL DEFAULT '0' COMMENT '系统模块ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员常用功能表';



# Dump of table 9thleaf_admin_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_admin_user`;

CREATE TABLE `9thleaf_admin_user` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_bin NOT NULL,
  `email` varchar(32) COLLATE utf8_bin NOT NULL,
  `password` varchar(32) COLLATE utf8_bin NOT NULL,
  `role_id` smallint(6) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `last_login_ip` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `is_first_login` tinyint(1) NOT NULL DEFAULT '0',
  `app_id` int(11) NOT NULL DEFAULT '0',
  `app_label_id` int(11) DEFAULT NULL COMMENT '商会一级标签ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`app_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='后台管理员';



# Dump of table 9thleaf_agent
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_agent`;

CREATE TABLE `9thleaf_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_name` varchar(64) DEFAULT NULL COMMENT '合伙人名称',
  `email` varchar(32) DEFAULT NULL COMMENT '邮箱',
  `password` varchar(64) DEFAULT NULL COMMENT '密码',
  `corp_name` varchar(128) DEFAULT NULL COMMENT '????',
  `nick_name` varchar(64) DEFAULT NULL COMMENT '??',
  `app_id` int(11) DEFAULT NULL COMMENT '???',
  `created_at` datetime DEFAULT NULL COMMENT '????',
  `created_by` int(11) DEFAULT NULL COMMENT '???',
  `agent_status` int(11) DEFAULT '1' COMMENT '1:???2:??',
  `type` tinyint(2) DEFAULT '0' COMMENT '0:合伙人 1:合作伙伴',
  `intro_id` int(11) DEFAULT NULL COMMENT '介绍人（本表自增ID）',
  `ser_id` int(11) DEFAULT NULL COMMENT '服务者（本表自增ID）',
  `intro_rebate` float DEFAULT NULL COMMENT '介绍人比率',
  `ser_rebate` float DEFAULT NULL COMMENT '服务者比率',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_agent_copy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_agent_copy`;

CREATE TABLE `9thleaf_agent_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_name` varchar(64) DEFAULT NULL COMMENT '合伙人名称',
  `email` varchar(32) DEFAULT NULL COMMENT '邮箱',
  `password` varchar(64) DEFAULT NULL COMMENT '密码',
  `corp_name` varchar(128) DEFAULT NULL COMMENT '????',
  `nick_name` varchar(64) DEFAULT NULL COMMENT '??',
  `app_id` int(11) DEFAULT NULL COMMENT '???',
  `created_at` datetime DEFAULT NULL COMMENT '????',
  `created_by` int(11) DEFAULT NULL COMMENT '???',
  `agent_status` int(11) DEFAULT '1' COMMENT '1:???2:??',
  `type` tinyint(2) DEFAULT '0' COMMENT '0:合伙人 1:合作伙伴',
  `intro_id` int(11) DEFAULT NULL COMMENT '介绍人（本表自增ID）',
  `ser_id` int(11) DEFAULT NULL COMMENT '服务者（本表自增ID）',
  `intro_rebate` float DEFAULT NULL COMMENT '介绍人比率',
  `ser_rebate` float DEFAULT NULL COMMENT '服务者比率',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_alipay_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_alipay_log`;

CREATE TABLE `9thleaf_alipay_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `body` varchar(128) DEFAULT NULL COMMENT '商品描述',
  `buyer_email` varchar(32) DEFAULT NULL COMMENT '买家支付宝账号',
  `buyer_id` char(16) DEFAULT NULL COMMENT '买家支付宝账户号（纯16位数字）',
  `notify_id` varchar(255) DEFAULT NULL COMMENT '通知校验ID',
  `notify_time` datetime DEFAULT NULL COMMENT '通知时间',
  `notify_type` varchar(64) DEFAULT NULL COMMENT '通知类型',
  `out_trade_no` varchar(32) DEFAULT NULL COMMENT '对应chargeno',
  `payment_type` tinyint(1) DEFAULT NULL COMMENT '支付类型',
  `seller_email` varchar(32) DEFAULT NULL COMMENT '卖家支付宝账号',
  `seller_id` char(16) DEFAULT NULL COMMENT '卖家支付宝账户号（纯16位数字）',
  `subject` varchar(128) DEFAULT NULL COMMENT '商品名称',
  `total_fee` decimal(10,2) DEFAULT NULL COMMENT '金额',
  `trade_no` varchar(64) DEFAULT NULL COMMENT '支付宝交易号',
  `trade_status` varchar(32) DEFAULT NULL COMMENT '交易状态',
  `sign` varchar(64) DEFAULT NULL COMMENT '签名',
  `sign_type` char(5) DEFAULT NULL COMMENT '签名方式',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table 9thleaf_api_account
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_api_account`;

CREATE TABLE `9thleaf_api_account` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shop_number` varchar(32) DEFAULT NULL COMMENT '商户号',
  `key` varchar(32) DEFAULT NULL COMMENT '密匙',
  `customer_id` int(11) DEFAULT NULL COMMENT '对应用户ID',
  `type` tinyint(1) DEFAULT NULL COMMENT '1:广告商',
  `corporation_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL COMMENT '商品ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_app_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_app_category`;

CREATE TABLE `9thleaf_app_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `level` int(11) DEFAULT NULL COMMENT '层级',
  `parent_id` int(11) NOT NULL COMMENT '父节点',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名字',
  `img_path` varchar(128) DEFAULT NULL COMMENT '图片路径',
  `link` varchar(128) DEFAULT NULL COMMENT '链接地址',
  `app_id` int(11) DEFAULT NULL COMMENT 'app id',
  `cat_id` int(11) NOT NULL COMMENT '分类ID',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '链接类型:0-url,1-cat_id',
  `is_show` int(11) NOT NULL DEFAULT '0' COMMENT '显示状态：1-显示，0-隐藏',
  `sort` int(4) DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_app_homeplate_level
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_app_homeplate_level`;

CREATE TABLE `9thleaf_app_homeplate_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level_name` varchar(64) DEFAULT NULL COMMENT '楼层名称',
  `is_show` int(11) DEFAULT '1' COMMENT '是否顯示1：顯示 0：不顯示',
  `app_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='移动端首页楼层';



# Dump of table 9thleaf_app_homeplate_level2
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_app_homeplate_level2`;

CREATE TABLE `9thleaf_app_homeplate_level2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level_name` varchar(64) DEFAULT NULL COMMENT '層名稱',
  `level_temp` int(11) DEFAULT NULL COMMENT '層模板',
  `temp_info` varchar(512) DEFAULT NULL COMMENT '層模板信息',
  `is_show` int(11) DEFAULT '1' COMMENT '是否顯示1：顯示 0：不顯示',
  `app_id` int(11) DEFAULT NULL,
  `corporation_id` int(11) DEFAULT NULL,
  `level_morelink` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='移动端首页楼层';



# Dump of table 9thleaf_app_homeplate_set
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_app_homeplate_set`;

CREATE TABLE `9thleaf_app_homeplate_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level_id` int(11) NOT NULL COMMENT '楼层ID',
  `temp_id` int(11) DEFAULT NULL COMMENT '模板ID',
  `position` int(11) DEFAULT NULL COMMENT '位置',
  `img_path` varchar(128) DEFAULT '' COMMENT '图片路径',
  `desc` varchar(128) DEFAULT NULL COMMENT '文字说明',
  `link_path` varchar(256) DEFAULT NULL COMMENT '链接地址',
  `is_show` int(11) DEFAULT '1' COMMENT '是否顯示1：顯示 0：不顯示',
  `corporation_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;



# Dump of table 9thleaf_app_homeplate_set2
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_app_homeplate_set2`;

CREATE TABLE `9thleaf_app_homeplate_set2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `corporation_id` int(11) NOT NULL COMMENT '企业ID',
  `template_id` int(11) NOT NULL COMMENT '模板ID',
  `temp_key` varchar(64) NOT NULL DEFAULT '' COMMENT 'KEY',
  `img_path` varchar(128) DEFAULT NULL COMMENT '图片路径',
  `desc` varchar(128) DEFAULT NULL COMMENT '文字说明',
  `brief_statement` varchar(128) DEFAULT NULL COMMENT '简短描述',
  `link_path` varchar(256) DEFAULT NULL COMMENT '链接地址',
  `app_id` int(11) DEFAULT '0',
  `is_show` int(11) NOT NULL DEFAULT '1' COMMENT '是否顯示 0：不顯示 1：顯示',
  `product_id` int(11) DEFAULT NULL COMMENT '产品ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_app_homeplate_temp
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_app_homeplate_temp`;

CREATE TABLE `9thleaf_app_homeplate_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `temp_name` varchar(64) DEFAULT NULL COMMENT '模板名称',
  `temp_info` varchar(512) DEFAULT NULL COMMENT '層模板信息',
  `num` int(11) DEFAULT NULL COMMENT '模版的字段数',
  `level_id` int(11) DEFAULT NULL COMMENT '楼层',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='移动端首页楼层模板';



# Dump of table 9thleaf_app_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_app_info`;

CREATE TABLE `9thleaf_app_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_name` varchar(50) NOT NULL,
  `description` text,
  `site_url` varchar(150) DEFAULT NULL COMMENT '网站地址',
  `admin_url` varchar(200) DEFAULT NULL COMMENT '后台地址',
  `site_logo` varchar(200) DEFAULT NULL COMMENT '网站LOGO',
  `customer_id` int(10) DEFAULT NULL COMMENT '用户id',
  `company_name` varchar(100) DEFAULT NULL COMMENT '公司名',
  `company_keyman` varchar(50) DEFAULT NULL COMMENT '公司负责人',
  `keyman_phone` varchar(20) DEFAULT NULL COMMENT '负责人电话',
  `company_address` varchar(255) DEFAULT NULL COMMENT '公司地址',
  `seo_keyword` varchar(255) DEFAULT NULL COMMENT 'SEO关键字',
  `seo_description` text COMMENT 'SEO描述',
  `author` varchar(40) DEFAULT NULL COMMENT '作者',
  `icp_num` varchar(40) DEFAULT NULL COMMENT 'ICP备案号',
  `copy_right` varchar(255) NOT NULL DEFAULT '© 2009-2015 Powered by NINTH·LEAF™. All Rights Reserved.' COMMENT '版权声明',
  `domain` varchar(150) DEFAULT NULL COMMENT '域名',
  `theme` varchar(50) NOT NULL DEFAULT 'default' COMMENT '前台模板',
  `wechat_appid` varchar(50) DEFAULT NULL COMMENT '微信APP_ID',
  `wechat_appsecret` varchar(50) DEFAULT NULL COMMENT '微信密匙',
  `wechat_access_token` varchar(200) DEFAULT NULL COMMENT '微信通话TOKEN',
  `wechat_token_timestamp` bigint(30) DEFAULT NULL,
  `wechat_jsapi_ticket` varchar(100) DEFAULT NULL,
  `wechat_jsapi_timestamp` bigint(30) DEFAULT NULL,
  `wechat_encrypt` tinyint(1) NOT NULL DEFAULT '0',
  `wechat_last_time` timestamp NULL DEFAULT NULL,
  `app_flag` tinyint(4) DEFAULT '0' COMMENT '0:普通;1:推荐',
  `cs_phone` varchar(20) DEFAULT NULL,
  `welcome_words` varchar(255) DEFAULT NULL,
  `app_name_en` varchar(100) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL COMMENT '地区表',
  `letter` varchar(10) DEFAULT NULL COMMENT '站点首拼音',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公司信息表';



# Dump of table 9thleaf_app_label
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_app_label`;

CREATE TABLE `9thleaf_app_label` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '标签名',
  `label_sn` varchar(32) NOT NULL DEFAULT '' COMMENT 'label编号',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `tribe_id` int(11) DEFAULT NULL COMMENT '总商会',
  `color` varchar(8) NOT NULL DEFAULT '#61c3d0' COMMENT '色值',
  PRIMARY KEY (`id`),
  KEY `label_sn` (`label_sn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商会一级标签';



# Dump of table 9thleaf_app_label_banner
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_app_label_banner`;

CREATE TABLE `9thleaf_app_label_banner` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(32) NOT NULL COMMENT '标题',
  `app_label_id` int(4) DEFAULT NULL COMMENT '标签ID',
  `banner_path` varchar(256) DEFAULT NULL COMMENT '轮播图地址',
  `remark` varchar(256) DEFAULT NULL COMMENT '备注',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `sort` int(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `link` varchar(256) DEFAULT NULL COMMENT '链接',
  `load_app` tinyint(1) DEFAULT '0' COMMENT '是否调用原生app页面，H5忽略此参数 0调用H5页面 1调用原生app页面',
  PRIMARY KEY (`id`),
  KEY `label_id` (`app_label_id`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商会banner设置';



# Dump of table 9thleaf_app_label_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_app_label_category`;

CREATE TABLE `9thleaf_app_label_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `level` int(11) DEFAULT NULL COMMENT '层级',
  `parent_id` int(11) NOT NULL COMMENT '父节点',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名字',
  `img_path` varchar(128) DEFAULT NULL COMMENT '图片路径',
  `link` varchar(128) DEFAULT NULL COMMENT '链接地址',
  `app_id` int(11) DEFAULT '0' COMMENT 'app id',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '链接类型:0-url,1-cat_id',
  `is_show` int(11) NOT NULL DEFAULT '0' COMMENT '显示状态：1-显示，0-隐藏',
  `sort` int(4) DEFAULT NULL COMMENT '排序',
  `app_label_id` int(11) NOT NULL COMMENT '商会ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_app_label_member
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_app_label_member`;

CREATE TABLE `9thleaf_app_label_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `m_name` varchar(32) DEFAULT NULL COMMENT '会员名称',
  `sex` varchar(20) DEFAULT NULL COMMENT '性别',
  `card_id` varchar(32) DEFAULT NULL COMMENT '身份证号码',
  `year` int(11) DEFAULT NULL COMMENT '出生年份',
  `day` int(11) DEFAULT NULL COMMENT '出生月份',
  `duty` varchar(32) DEFAULT NULL COMMENT '职务',
  `native_provice` int(11) DEFAULT NULL COMMENT '省份',
  `native_city` int(11) DEFAULT NULL COMMENT '城市',
  `nation` varchar(32) DEFAULT NULL COMMENT '民族',
  `education` varchar(20) DEFAULT NULL COMMENT '文化程度',
  `political_status` varchar(20) DEFAULT NULL COMMENT '政治面貌',
  `social_duty` varchar(32) DEFAULT NULL COMMENT '社会职务',
  `resume` varchar(256) DEFAULT NULL COMMENT '个人简介',
  `company` varchar(32) DEFAULT NULL COMMENT '公司名称',
  `address` varchar(100) DEFAULT NULL COMMENT '联系地址',
  `phone` varchar(20) DEFAULT NULL COMMENT '手机',
  `email` varchar(100) DEFAULT NULL COMMENT 'e-mail',
  `m_duty` varchar(32) DEFAULT NULL COMMENT '入会岗位',
  `comany_detail` varchar(100) DEFAULT NULL COMMENT '企业情况',
  `app_label_id` int(11) DEFAULT NULL COMMENT '商会',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `customer_id` int(11) DEFAULT NULL COMMENT '提交的用户id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商会会员表';



# Dump of table 9thleaf_app_label_nav
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_app_label_nav`;

CREATE TABLE `9thleaf_app_label_nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(32) DEFAULT NULL COMMENT '名称',
  `image` varchar(256) DEFAULT NULL COMMENT '图片',
  `app_label_id` int(4) DEFAULT NULL COMMENT '标签',
  `sort` int(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `link` varchar(256) DEFAULT NULL COMMENT '链接',
  `load_app` tinyint(1) DEFAULT '0' COMMENT '是否调用原生app页面，H5忽略此参数 0调用H5页面 1调用原生app页面',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_app_label_recomended_shop
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_app_label_recomended_shop`;

CREATE TABLE `9thleaf_app_label_recomended_shop` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL COMMENT '店铺id',
  `shop_img` varchar(256) DEFAULT NULL COMMENT '推荐店铺图片',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `label_id` int(11) DEFAULT NULL COMMENT '商会标签',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `status` tinyint(1) DEFAULT '0' COMMENT '是否删除，1是，0否',
  `delete_at` datetime DEFAULT NULL COMMENT '删除时间',
  `link` varchar(120) DEFAULT NULL COMMENT '链接',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='店铺推荐表';



# Dump of table 9thleaf_app_module
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_app_module`;

CREATE TABLE `9thleaf_app_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `enabledflag` tinyint(4) NOT NULL DEFAULT '1',
  `sequence` smallint(6) NOT NULL DEFAULT '50',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公司对应系统功能表';



# Dump of table 9thleaf_app_version
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_app_version`;

CREATE TABLE `9thleaf_app_version` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `version_num` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '版本号',
  `update_time` datetime DEFAULT NULL COMMENT '版本更新日期',
  `update_content` varchar(500) DEFAULT NULL COMMENT '版本更新内容',
  `type` tinyint(1) DEFAULT '1' COMMENT '1:Android 2:iOS',
  `create_time` datetime DEFAULT NULL COMMENT '记录创建时间',
  `rewrite` tinyint(1) DEFAULT '0' COMMENT '1:需要重装 0:不需要重装',
  `url` varchar(255) DEFAULT 'http://www.51ehw.com/index.php/api/' COMMENT '接口地址整体',
  `img_url` varchar(255) DEFAULT 'http://image.51ehw.com/' COMMENT '图片服务器地址',
  `api_url` varchar(255) DEFAULT 'index.php/api/' COMMENT '接口拆分地址',
  `site_url` varchar(255) DEFAULT 'http://www.51ehw.com/' COMMENT '服务器地址',
  `showupdate` int(11) DEFAULT '0' COMMENT '0不提示更新1提示更新',
  `forceupdate` int(11) DEFAULT '0' COMMENT '强制更新 0 否 1 是',
  `app_label_id` int(11) NOT NULL COMMENT '标签id 0默认',
  `app_download_url` varchar(128) NOT NULL DEFAULT '' COMMENT '应用下载链接',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='app版本日志';



# Dump of table 9thleaf_apply_rebate_identity
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_apply_rebate_identity`;

CREATE TABLE `9thleaf_apply_rebate_identity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL COMMENT '申请用户ID',
  `identity_id` int(11) DEFAULT NULL COMMENT '要申请的身份ID',
  `identity_name` varchar(32) DEFAULT NULL COMMENT '要申请的身份名称',
  `current_identity_id` int(11) DEFAULT NULL COMMENT '当前身份ID',
  `current_identity_name` varchar(32) DEFAULT NULL COMMENT '当前身份名称',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '申请时间',
  `app_name` varchar(50) NOT NULL,
  `app_id` int(11) DEFAULT NULL COMMENT '站点id',
  `status` tinyint(1) DEFAULT '0' COMMENT '0:审核中 1:通过 2:不通过',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='分成身份申请记录表';



# Dump of table 9thleaf_area_region
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_area_region`;

CREATE TABLE `9thleaf_area_region` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shipping_area_id` smallint(6) unsigned NOT NULL,
  `region_id` smallint(6) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='地区表';



# Dump of table 9thleaf_attr_filter
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_attr_filter`;

CREATE TABLE `9thleaf_attr_filter` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) unsigned NOT NULL,
  `att_id` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `parent_id` smallint(4) unsigned NOT NULL,
  `level` tinyint(3) NOT NULL DEFAULT '1' COMMENT '层次',
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '路径',
  `is_root` tinyint(1) NOT NULL DEFAULT '1' COMMENT '根节点?',
  `is_leaf` tinyint(1) NOT NULL DEFAULT '1' COMMENT '叶节点?',
  `app_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='属性筛选表';



# Dump of table 9thleaf_card_batch
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_card_batch`;

CREATE TABLE `9thleaf_card_batch` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '批次ID',
  `batch_num` varchar(32) DEFAULT '' COMMENT '批次号',
  `corporation_id` int(11) NOT NULL COMMENT '商家ID',
  `app_id` int(11) NOT NULL COMMENT '区域',
  `sale_corporation_id` int(11) NOT NULL COMMENT '销售方ID',
  `total_account` decimal(10,2) DEFAULT NULL COMMENT '总金额',
  `alarm_account` decimal(10,2) DEFAULT NULL COMMENT '报警金额',
  `balance` decimal(10,2) DEFAULT NULL COMMENT '余额',
  `alarm_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未报警1报警',
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '开始时间',
  `end_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '结束时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='实体卡批次';



# Dump of table 9thleaf_cart
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_cart`;

CREATE TABLE `9thleaf_cart` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '客户ID',
  `product_id` int(11) NOT NULL COMMENT '产品ID',
  `quantity` int(11) NOT NULL DEFAULT '1' COMMENT '数量',
  `product_name` varchar(80) DEFAULT NULL COMMENT '产品名称',
  `img_goods` varchar(255) DEFAULT NULL COMMENT '产品缩略图',
  `sku_id` int(11) NOT NULL DEFAULT '0',
  `vip_price` decimal(10,2) DEFAULT NULL COMMENT '价格（特价，部落价，易货价）',
  `corporation_name` varchar(50) NOT NULL DEFAULT '' COMMENT '企业名称',
  `sku` varchar(50) NOT NULL DEFAULT '' COMMENT 'sku属性',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '商品库存',
  `price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  `freight` decimal(9,2) DEFAULT NULL COMMENT '运费',
  `m_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='前台购物车表';



# Dump of table 9thleaf_cash_shop
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_cash_shop`;

CREATE TABLE `9thleaf_cash_shop` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL COMMENT '用户ID',
  `corporation_id` int(11) DEFAULT NULL COMMENT '企业ID',
  `charge_no` varchar(32) DEFAULT NULL,
  `cash` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `transaction_no` varchar(64) NOT NULL DEFAULT '' COMMENT '第三方交易流水号',
  `payment_name` varchar(32) NOT NULL DEFAULT '' COMMENT '第三方平台名称',
  `remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  `status` tinyint(1) DEFAULT '0' COMMENT '用户是否完善资料  0：否，1：是',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '缴费时间',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `corporation_id` (`corporation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='现金开店记录表';



# Dump of table 9thleaf_certification_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_certification_log`;

CREATE TABLE `9thleaf_certification_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '真实姓名',
  `idcard` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '身份证',
  `bankcard` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '银行卡',
  `bankmobile` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `return_msg` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '备注',
  `ordersn` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '订单号',
  `status` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '状态',
  `return_desc` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '返回json',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='第三方京东万象实名认证';



# Dump of table 9thleaf_channel
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_channel`;

CREATE TABLE `9thleaf_channel` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `channel_name` varchar(50) DEFAULT NULL,
  `pid` int(11) NOT NULL DEFAULT '0',
  `app_id` int(11) NOT NULL DEFAULT '0',
  `sequence` smallint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `channel_type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '栏目类型：1为网站信息，2网站关联',
  `fpath` varchar(128) DEFAULT NULL COMMENT '父级ID集合',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='功能栏目表';



# Dump of table 9thleaf_charge
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_charge`;

CREATE TABLE `9thleaf_charge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '客户ID',
  `amount` decimal(16,2) NOT NULL COMMENT '支付金额',
  `chargeno` varchar(32) NOT NULL DEFAULT '' COMMENT '支付订单号',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0:未支付，1:已支付，2:确认支付',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '生成日期',
  `pay_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '支付日期',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `payment_id` tinyint(2) NOT NULL DEFAULT '0' COMMENT '支付方式ID',
  `type1` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0:前台充值 1:后台充值',
  `order_sn` varchar(32) DEFAULT NULL,
  `order_source` int(11) DEFAULT NULL COMMENT '1:PC支付 2:H5支付 3:安卓 4:IOS 5后台',
  `commission` decimal(16,2) DEFAULT '0.00' COMMENT '手续费(支付金额中占有多少)',
  `is_merchant` tinyint(1) unsigned DEFAULT '0' COMMENT '是否支付保证金，0：否，1，是',
  `third_party_no` varchar(60) DEFAULT NULL COMMENT '第三方生成的订单流水号',
  `app_sign` varchar(64) DEFAULT NULL COMMENT 'app标识',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='充值表';



# Dump of table 9thleaf_charge_currency
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_charge_currency`;

CREATE TABLE `9thleaf_charge_currency` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `charge_no` varchar(32) DEFAULT '' COMMENT '充值订单号',
  `amount` decimal(16,2) DEFAULT NULL COMMENT '充值M卷数量',
  `create_date` datetime DEFAULT NULL COMMENT '充值时间',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户ID',
  `pay_relation_id` int(11) DEFAULT NULL COMMENT '充值账户中间表ID',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='M卷充值记录表';



# Dump of table 9thleaf_charge_set
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_charge_set`;

CREATE TABLE `9thleaf_charge_set` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `charge_unit` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '单元',
  `charge_plus` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '送',
  `plus_product_id` int(11) NOT NULL DEFAULT '0' COMMENT '送产品',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='充值优惠设置表';



# Dump of table 9thleaf_chat_channel
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_chat_channel`;

CREATE TABLE `9thleaf_chat_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL COMMENT '创建人ID/后台(部落首领id）',
  `tribe_id` int(10) DEFAULT '0' COMMENT '部落ID',
  `huanxin_group_id` varchar(255) COLLATE utf8mb4_bin DEFAULT '0' COMMENT '环信聊天室ID',
  `create_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `tribe_id` (`tribe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='聊天室表';



# Dump of table 9thleaf_chat_channel_member
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_chat_channel_member`;

CREATE TABLE `9thleaf_chat_channel_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chat_channel_id` int(11) DEFAULT NULL COMMENT '聊天室ID',
  `customer_id` int(11) DEFAULT NULL COMMENT '成员ID',
  `create_at` datetime DEFAULT NULL COMMENT '加入时间',
  `huanxin_group_id` varchar(255) COLLATE utf8mb4_bin DEFAULT '0' COMMENT '环信聊天室ID',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `chat_channel_id` (`chat_channel_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='聊天室成员表';



# Dump of table 9thleaf_chat_list
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_chat_list`;

CREATE TABLE `9thleaf_chat_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(255) COLLATE utf8mb4_bin DEFAULT '' COMMENT '接收人ID',
  `chat_channel_id` int(11) DEFAULT NULL COMMENT '聊天室ID',
  `is_read` tinyint(2) DEFAULT '1' COMMENT '是否已阅读消息 1表示是，0表示不是',
  `is_show` tinyint(2) DEFAULT '1' COMMENT '是否在列表显示 0表示不显示，1表示显示',
  `create_at` datetime DEFAULT NULL COMMENT '创建时间',
  `update_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `chat_channel_id` (`chat_channel_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='用户聊天列表';



# Dump of table 9thleaf_chat_message
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_chat_message`;

CREATE TABLE `9thleaf_chat_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_customer_id` varchar(255) COLLATE utf8mb4_bin DEFAULT '' COMMENT '发送人ID',
  `chat_channel_id` int(11) DEFAULT NULL COMMENT '聊天室ID',
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '聊天内容',
  `message_url` varchar(225) COLLATE utf8mb4_bin DEFAULT '' COMMENT '发送的图片路径',
  `message_type` tinyint(2) DEFAULT '0' COMMENT '0表示文本消息包含表情，1表示图片消息，2表示外链信息',
  `is_delete` tinyint(2) DEFAULT '0' COMMENT '0表示显示，1表示删除',
  `create_at` datetime DEFAULT NULL COMMENT '发送时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `from_customer_id` (`from_customer_id`),
  KEY `chat_channel_id` (`chat_channel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='聊天内容表';



# Dump of table 9thleaf_chat_read_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_chat_read_log`;

CREATE TABLE `9thleaf_chat_read_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chat_channel_id` int(11) DEFAULT NULL COMMENT '聊天室ID',
  `chat_message_id` varchar(255) COLLATE utf8mb4_bin DEFAULT '' COMMENT '消息ID',
  `customer_id` varchar(255) COLLATE utf8mb4_bin DEFAULT '' COMMENT '接收人ID',
  `create_at` datetime DEFAULT NULL COMMENT '阅读时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `chat_channel_id` (`chat_channel_id`),
  KEY `chat_message_id` (`chat_message_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='聊天记录阅读表';



# Dump of table 9thleaf_ci_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_ci_sessions`;

CREATE TABLE `9thleaf_ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='前台Session记录表';



# Dump of table 9thleaf_CIB_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_CIB_log`;

CREATE TABLE `9thleaf_CIB_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '用户id',
  `real_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '真实姓名',
  `mobile` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '手机号码',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新建日期',
  `appid` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='兴业银行活动信息记录表';



# Dump of table 9thleaf_complain
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_complain`;

CREATE TABLE `9thleaf_complain` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '客户ID',
  `customer_name` varchar(32) NOT NULL DEFAULT '' COMMENT '客户名称',
  `contact` varchar(16) DEFAULT NULL COMMENT '联系方式',
  `email` varchar(32) DEFAULT NULL COMMENT '电邮',
  `complain_reason` tinyint(1) DEFAULT NULL COMMENT '投诉原因',
  `complain_reason_other` varchar(120) DEFAULT NULL COMMENT '投诉原因的其他内容',
  `complain_desc` tinytext COMMENT '详细描述',
  `image` varchar(255) DEFAULT NULL COMMENT '图片',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `status` int(1) DEFAULT '0' COMMENT '处理状态：0未处理，1已处理',
  `app_id` int(11) DEFAULT '0' COMMENT '分站点',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='投诉表';



# Dump of table 9thleaf_conect
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_conect`;

CREATE TABLE `9thleaf_conect` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '创建人ID',
  `url_long` varchar(255) DEFAULT NULL COMMENT '长连接',
  `url_short` varchar(255) DEFAULT NULL COMMENT '短连接',
  `url_key` varchar(32) DEFAULT NULL COMMENT '短连接key值',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `source` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '来源 1:PC 2:微信 3:安卓 4:ios 5:后台',
  `type` int(1) unsigned DEFAULT '1' COMMENT '类型 1:部落短信邀请 2:部落二维码邀请',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='短信连接log';



# Dump of table 9thleaf_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_config`;

CREATE TABLE `9thleaf_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '事件',
  `value` varchar(16) NOT NULL DEFAULT '' COMMENT '值',
  `remarks` varchar(256) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `name_index` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配置表';



# Dump of table 9thleaf_content
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_content`;

CREATE TABLE `9thleaf_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL COMMENT '应用ID',
  `id_channel` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `subtitle` varchar(255) NOT NULL DEFAULT '' COMMENT '短标题',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `last_updated_time` datetime DEFAULT NULL COMMENT '最后更新时间',
  `release_time` datetime NOT NULL COMMENT '发布时间',
  `content` text COMMENT '内容',
  `author` varchar(50) DEFAULT NULL COMMENT '作者',
  `belong` varchar(50) DEFAULT NULL COMMENT '出处',
  `is_share` tinyint(4) DEFAULT NULL COMMENT '是否分享，0表示否，1表示是，默认否',
  `in_wechat` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否微信中显示，0表示否，1表示是，默认否',
  `title_img` varchar(255) NOT NULL DEFAULT 'uploads/content/images/default_img_s.jpg',
  PRIMARY KEY (`id`),
  KEY `id_channel_index` (`id_channel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='资讯内容表';



# Dump of table 9thleaf_corporation_cooperation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_corporation_cooperation`;

CREATE TABLE `9thleaf_corporation_cooperation` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '申请人id',
  `corporation_name` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '企业名称',
  `corporation_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '企业性质',
  `applicant_name` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '申请人',
  `applicant_duty` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '申请人职务',
  `coo_direction` varchar(512) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '合作方向',
  `mobile` varchar(16) COLLATE utf8_bin DEFAULT NULL COMMENT '联系方式',
  `remarks` varchar(512) COLLATE utf8_bin DEFAULT NULL COMMENT '备注',
  `status` int(11) DEFAULT '0' COMMENT '狀態 0:未处理 1:已处理',
  `created_at` datetime DEFAULT NULL COMMENT '申请日期',
  `app_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='商务合作表';



# Dump of table 9thleaf_corporation_credit_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_corporation_credit_log`;

CREATE TABLE `9thleaf_corporation_credit_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_corporation` int(11) NOT NULL COMMENT '企业ID',
  `created_at` datetime DEFAULT NULL COMMENT '发生日期',
  `credit` decimal(16,2) DEFAULT NULL COMMENT '信用额度（转入）',
  `create_user` int(11) DEFAULT NULL COMMENT '受信人ID',
  `reason` int(11) DEFAULT NULL COMMENT '转入原因／1.普通1:1授信,2.合伙人授信，3.担保公司',
  `examine_id` int(11) DEFAULT NULL COMMENT '可审批编号',
  `remarks` text COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_corporation_detail
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_corporation_detail`;

CREATE TABLE `9thleaf_corporation_detail` (
  `corporation_id` int(11) NOT NULL COMMENT '企业ID',
  `Industrial_Info` int(11) DEFAULT '0' COMMENT '企业行业',
  `nature` int(11) DEFAULT '0' COMMENT '企业性质',
  `legal_person` varchar(64) DEFAULT NULL COMMENT '法人',
  `idcard` varchar(64) DEFAULT NULL COMMENT '身份证',
  `company_registration` varchar(128) DEFAULT NULL COMMENT '工商注册号',
  `bus_licence_img` varchar(256) DEFAULT NULL COMMENT '营业执照图片,用;分隔多张',
  `idcard_img` varchar(256) DEFAULT NULL COMMENT '身份证图片',
  `proxy_img` varchar(256) DEFAULT NULL COMMENT '平台委托书图片',
  `regist_date` datetime DEFAULT NULL COMMENT '注册日期',
  `entry_requirements` varchar(128) DEFAULT NULL COMMENT '易入需求',
  `company_size` varchar(64) DEFAULT NULL COMMENT '公司规模',
  `company_wechat` varchar(100) DEFAULT NULL COMMENT '公司微信号',
  `company_web` varchar(64) DEFAULT NULL COMMENT '公司网址',
  `Registered_Capital` decimal(10,2) DEFAULT NULL COMMENT '公司注册资本',
  `company_establish` int(11) DEFAULT NULL COMMENT '公司成立年份',
  `license_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '证照类型0:旧版；1:新版',
  `license_province_id` varchar(20) DEFAULT NULL COMMENT '营业执照所在省份',
  `licecse_city_id` varchar(20) DEFAULT NULL COMMENT '营业执照所在城市',
  `license_address` varchar(64) DEFAULT NULL COMMENT '执照详细地址',
  `license_range` text COMMENT '营业执照经营范围',
  `license_date_from` timestamp NULL DEFAULT NULL COMMENT '执照有效期',
  `license_date_to` timestamp NULL DEFAULT NULL COMMENT '执照有效期',
  `organization_code_num` varchar(32) DEFAULT NULL COMMENT '组织机构代码证编号',
  `organization_date_from` timestamp NULL DEFAULT NULL COMMENT '组织机构代码证有效期',
  `organization_date_to` timestamp NULL DEFAULT NULL COMMENT '组织机构代码证有效期',
  `tax_number` varchar(32) DEFAULT NULL COMMENT '税务登记证号',
  `is_taxplayer` int(1) NOT NULL DEFAULT '1' COMMENT '是否为一般纳税人0:否；1:是',
  `legal_person_place` int(2) DEFAULT '1' COMMENT '法人代表归属地，1-大陆；2-港澳；3-台湾；4-外籍',
  `industry_qua` varchar(256) DEFAULT NULL COMMENT '行业资质，多张图片用；分隔',
  `organization_code_image` varchar(256) DEFAULT NULL COMMENT '组织机构代码证复印件,用;分隔',
  `tax_images` varchar(256) DEFAULT NULL COMMENT '税务登记证复印件',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`corporation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_corporation_freight
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_corporation_freight`;

CREATE TABLE `9thleaf_corporation_freight` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT '活动名称',
  `corporation_id` int(11) DEFAULT NULL COMMENT '企业id',
  `price_floor` decimal(12,2) DEFAULT NULL COMMENT '价格下限，满多少包邮',
  `description` varchar(255) DEFAULT NULL COMMENT '详情说明',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `corporation_id` (`corporation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家运费设置表';



# Dump of table 9thleaf_corporation_functions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_corporation_functions`;

CREATE TABLE `9thleaf_corporation_functions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_corporation_image
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_corporation_image`;

CREATE TABLE `9thleaf_corporation_image` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `corporation_id` int(11) NOT NULL COMMENT '店铺ID',
  `image_name` varchar(64) CHARACTER SET latin1 NOT NULL DEFAULT '' COMMENT '图片名',
  `type` varchar(32) DEFAULT NULL COMMENT '类型',
  `title` varchar(64) DEFAULT NULL COMMENT '标题',
  `number` tinyint(1) DEFAULT NULL COMMENT '编号',
  PRIMARY KEY (`id`),
  KEY `IDX_CORPORATION_ID` (`corporation_id`),
  KEY `TYPE` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_corporation_image_verify
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_corporation_image_verify`;

CREATE TABLE `9thleaf_corporation_image_verify` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `corporation_id` int(11) NOT NULL COMMENT '店铺ID',
  `image_name` varchar(64) CHARACTER SET latin1 DEFAULT NULL COMMENT '图片名',
  `type` varchar(32) DEFAULT NULL COMMENT '类型',
  `title` varchar(64) DEFAULT NULL COMMENT '标题',
  `number` tinyint(1) DEFAULT NULL COMMENT '编号',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态0通过，1申请中，2不通过',
  `description` varchar(600) DEFAULT NULL COMMENT '企业简介',
  PRIMARY KEY (`id`),
  KEY `IDX_CORPORATION_ID` (`corporation_id`),
  KEY `TYPE` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='企业更新信息审核表';



# Dump of table 9thleaf_corporation_module
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_corporation_module`;

CREATE TABLE `9thleaf_corporation_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上层ID',
  `path` varchar(64) DEFAULT NULL COMMENT '路径',
  `module_name` varchar(50) NOT NULL DEFAULT '' COMMENT '模块名称',
  `directory` varchar(255) NOT NULL DEFAULT '/' COMMENT '实际目录路径',
  `url` varchar(255) NOT NULL DEFAULT '/' COMMENT '访问路径',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家系统模块表';



# Dump of table 9thleaf_corporation_privilege
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_corporation_privilege`;

CREATE TABLE `9thleaf_corporation_privilege` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_corporation_resource
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_corporation_resource`;

CREATE TABLE `9thleaf_corporation_resource` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `recommend_company` varchar(32) DEFAULT NULL COMMENT '推荐单位',
  `logo` varchar(128) DEFAULT NULL COMMENT '单位LOGO',
  `certificate` varchar(128) DEFAULT NULL COMMENT '证书图片',
  `recommend_content` varchar(256) DEFAULT NULL COMMENT '推荐描述',
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `approve_date` datetime DEFAULT NULL,
  `approve_status` tinyint(4) DEFAULT NULL COMMENT '审核状态0审核中1通过2未通过3隐藏',
  `proposal` varchar(128) DEFAULT NULL COMMENT '不通过意见',
  `id_corporation` int(11) unsigned NOT NULL,
  `company_brief` varchar(256) DEFAULT NULL COMMENT '单位介绍',
  `recommend_name` varchar(12) DEFAULT NULL COMMENT '背书人姓名',
  `recommend_language` varchar(512) DEFAULT NULL COMMENT '推荐语',
  `recommend_img` varchar(128) DEFAULT NULL COMMENT '推荐说明书拍照',
  `title` varchar(128) DEFAULT NULL COMMENT '头衔',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_corporation_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_corporation_role`;

CREATE TABLE `9thleaf_corporation_role` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '职位',
  `module_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '功能权限',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改日期',
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='企业角色表';



# Dump of table 9thleaf_corporation_staff
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_corporation_staff`;

CREATE TABLE `9thleaf_corporation_staff` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `corporation_id` int(11) DEFAULT NULL COMMENT '企业id',
  `customer_id` int(11) DEFAULT NULL COMMENT '员工id',
  `corp_role_id` tinyint(11) DEFAULT NULL COMMENT '角色id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `status` int(11) DEFAULT '0' COMMENT '员工状态:0待邀请1邀请中2在职3冻结',
  `remark` text COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `corporation_id` (`corporation_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='企业员工表';



# Dump of table 9thleaf_corporation_template_level
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_corporation_template_level`;

CREATE TABLE `9thleaf_corporation_template_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level_name` varchar(64) DEFAULT NULL COMMENT '層名稱',
  `level_temp` int(11) DEFAULT NULL COMMENT '層模板',
  `temp_info` varchar(512) DEFAULT NULL COMMENT '層模板信息',
  `is_show` int(11) DEFAULT '1' COMMENT '是否顯示1：顯示 0：不顯示',
  `app_id` int(11) DEFAULT NULL,
  `corporation_id` int(11) DEFAULT NULL,
  `level_morelink` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='首页楼层';



# Dump of table 9thleaf_corporation_template_set
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_corporation_template_set`;

CREATE TABLE `9thleaf_corporation_template_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `corporation_id` int(11) NOT NULL COMMENT '企业ID',
  `template_id` int(11) NOT NULL COMMENT '模板ID',
  `temp_key` varchar(64) NOT NULL DEFAULT '' COMMENT 'KEY',
  `img_path` varchar(128) DEFAULT NULL COMMENT '图片路径',
  `desc` varchar(128) DEFAULT NULL COMMENT '文字说明',
  `brief_statement` varchar(128) DEFAULT NULL COMMENT '简短描述',
  `link_path` varchar(256) DEFAULT NULL COMMENT '链接地址',
  `m_price` decimal(16,2) DEFAULT '0.00' COMMENT '零销价',
  `vip_price` decimal(16,2) DEFAULT '0.00' COMMENT 'M券',
  `app_id` int(11) DEFAULT '0',
  `is_show` int(11) NOT NULL DEFAULT '1' COMMENT '是否顯示 0：不顯示 1：顯示',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_corporationstyle_comment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_corporationstyle_comment`;

CREATE TABLE `9thleaf_corporationstyle_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '评论者ID',
  `obj_id` int(11) NOT NULL COMMENT '评论对象ID',
  `to_customer_id` int(11) DEFAULT NULL COMMENT '被回复id',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '评论内容',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未删除 1:删除',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `obj_id` (`obj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='企业形象内容评论表';



# Dump of table 9thleaf_corporationstyle_message
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_corporationstyle_message`;

CREATE TABLE `9thleaf_corporationstyle_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_customer_id` int(11) NOT NULL COMMENT '触发人ID',
  `to_customer_id` int(11) NOT NULL COMMENT '接收人ID',
  `obj_id` int(11) NOT NULL COMMENT '对象ID',
  `content_obj_id` int(11) NOT NULL COMMENT '内容的对象ID',
  `content` text COMMENT '消息内容',
  `type` tinyint(1) NOT NULL COMMENT '1:评论 2:点赞 3:系统消息',
  `is_read` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:未读 2:已读',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `merge_customer_id_key` (`to_customer_id`,`form_customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='企业形象消息推送';



# Dump of table 9thleaf_corporationstyle_topic
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_corporationstyle_topic`;

CREATE TABLE `9thleaf_corporationstyle_topic` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '作者id',
  `images` text COMMENT '多图片用;号分割1',
  `content` text COMMENT '内容',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:不显示   1:正常 ',
  `sort` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1:置顶 ',
  `remark` varchar(128) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='企业形象话题表';



# Dump of table 9thleaf_corporationstyle_upvote
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_corporationstyle_upvote`;

CREATE TABLE `9thleaf_corporationstyle_upvote` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '点赞用户',
  `obj_id` int(11) NOT NULL COMMENT '点赞对象',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `obj_id` (`obj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='企业话题点赞表';



# Dump of table 9thleaf_coupon_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_coupon_user`;

CREATE TABLE `9thleaf_coupon_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `coupon_id` int(11) NOT NULL COMMENT '优惠券ID',
  `account_id` int(11) NOT NULL COMMENT '用户ID',
  `getdate` datetime NOT NULL COMMENT '领券日期',
  `effectdate` datetime NOT NULL COMMENT '到期日期',
  `changedate` datetime DEFAULT NULL COMMENT '使用日期',
  `order_id` int(11) DEFAULT NULL COMMENT '关联订单号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户优惠券表';



# Dump of table 9thleaf_coupons
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_coupons`;

CREATE TABLE `9thleaf_coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coupontype` int(11) NOT NULL COMMENT '优惠券类型',
  `couponname` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '优惠券名称',
  `usertype` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '会员类型',
  `begindate` datetime NOT NULL COMMENT '开始日期',
  `enddate` datetime NOT NULL COMMENT '结束日期',
  `amount_limit_up` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT '价格上限',
  `amount_limit_down` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT '价格下限',
  `usagemode` tinyint(1) DEFAULT '0' COMMENT '使用方式（0为现金，1为百分比）',
  `usagevalue` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '使用数值',
  `applicationmode` tinyint(2) DEFAULT '0' COMMENT '适用对象类型（0：类型，1：品牌，2：产品）',
  `applicatevalue` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '对象值',
  `app_id` int(11) NOT NULL COMMENT '公司ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='优惠券';



# Dump of table 9thleaf_credit
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_credit`;

CREATE TABLE `9thleaf_credit` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '用户id',
  `credit` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `actual_credit` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '实际发放金额',
  `status` tinyint(1) DEFAULT '1' COMMENT '1待审核2通过3不通过',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `effective_at` datetime DEFAULT NULL COMMENT '发放时间',
  `is_effective` tinyint(1) DEFAULT NULL COMMENT '通过了才发放 1待发放 2已发放',
  `remark` varchar(100) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='授信申请表';



# Dump of table 9thleaf_currency_remarks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_currency_remarks`;

CREATE TABLE `9thleaf_currency_remarks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` varchar(32) NOT NULL DEFAULT '0' COMMENT '订单号',
  `remark` varchar(300) NOT NULL DEFAULT '""' COMMENT '注释内容',
  `admin_id` int(11) unsigned DEFAULT '0' COMMENT '后台管理员ID',
  `create_at` datetime NOT NULL COMMENT '创建时间',
  `app_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='M券转移注释(废除)';



# Dump of table 9thleaf_customer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer`;

CREATE TABLE `9thleaf_customer` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '账号名',
  `email` varchar(32) COLLATE utf8_bin DEFAULT '' COMMENT '邮箱',
  `password` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '密码',
  `password_auto` varchar(32) COLLATE utf8_bin DEFAULT NULL COMMENT '自动密码',
  `dob` date DEFAULT NULL COMMENT '生日',
  `wechat_account` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '微信账号',
  `real_name` varchar(32) COLLATE utf8_bin DEFAULT NULL COMMENT '真实姓名',
  `nick_name` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '昵称',
  `mobile` varchar(16) COLLATE utf8_bin DEFAULT NULL,
  `credit1` decimal(14,2) NOT NULL DEFAULT '0.00' COMMENT 'M券',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID',
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '首次购买后改为1，新注册全部为0',
  `grade` smallint(4) NOT NULL DEFAULT '0' COMMENT '0为原始等级，随着等级而变',
  `priority_shipping_id` int(11) DEFAULT NULL,
  `priority_payment_id` smallint(6) DEFAULT NULL,
  `login_count` smallint(6) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `last_login_at` datetime NOT NULL COMMENT '最后登录时间',
  `last_login_ip` text COLLATE utf8_bin,
  `is_lock` tinyint(1) NOT NULL DEFAULT '0',
  `is_sendemail` tinyint(1) NOT NULL DEFAULT '0',
  `registry_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新建日期',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '修改日期',
  `sex` tinyint(1) unsigned DEFAULT NULL COMMENT 'NULL为未填写，0为女，1为男',
  `birthday` datetime DEFAULT NULL,
  `job` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '职业',
  `is_vip` tinyint(1) NOT NULL DEFAULT '0',
  `is_mc` tinyint(1) NOT NULL DEFAULT '0',
  `phone` varchar(16) COLLATE utf8_bin DEFAULT NULL,
  `registry_by` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `parent_shared` int(3) NOT NULL DEFAULT '0',
  `is_valid` tinyint(1) NOT NULL DEFAULT '1' COMMENT '有效会员:1有效',
  `qq_account` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT 'QQ账号',
  `weibo_account` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '微博账号',
  `alipay_account` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '支付宝账号',
  `app_info` int(11) NOT NULL DEFAULT '0',
  `img_avatar` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `app_id` int(11) NOT NULL DEFAULT '0',
  `safety_password` int(11) DEFAULT NULL,
  `old_id` int(11) DEFAULT NULL,
  `pay_passwd` varchar(64) COLLATE utf8_bin DEFAULT NULL COMMENT '支付密码',
  `wechat_avatar` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '微信頭像',
  `wechat_nickname` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT '微信昵稱',
  `openid` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '微信openid',
  `credit_ceiling` decimal(14,2) NOT NULL DEFAULT '0.00' COMMENT '授信上限',
  `rebate_app_id` int(11) DEFAULT NULL COMMENT '分成所属站点',
  `rebate_role_id` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '所属角色，存储分成角色id,以,分隔',
  `wechat_subscribe` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否关注微信公告号 0否1是',
  `bg_img` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT '用户个人简介背景图片',
  `merit` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '用户个人亮点',
  `brief` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '用户个人简介',
  `brief_avatar` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '个人简介頭像',
  `webim_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否环信注册 0:否 1:是',
  `idcard` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '身份证号码',
  `bankcard` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '银行卡号',
  `bankmobile` varchar(32) COLLATE utf8_bin DEFAULT NULL COMMENT '预留手机号码',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE,
  KEY `wechat_account_index` (`wechat_account`),
  KEY `parent_id_index` (`parent_id`),
  KEY `join_mobile` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='客户信息表';



# Dump of table 9thleaf_customer_address
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer_address`;

CREATE TABLE `9thleaf_customer_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '客户ID',
  `address_name` varchar(64) COLLATE utf8_bin DEFAULT NULL COMMENT '地址名称',
  `consignee` varchar(64) COLLATE utf8_bin DEFAULT NULL COMMENT '联系人',
  `phone` varchar(16) COLLATE utf8_bin DEFAULT NULL COMMENT '电话',
  `mobile` varchar(16) COLLATE utf8_bin DEFAULT NULL COMMENT '手机',
  `fax` varchar(16) COLLATE utf8_bin DEFAULT NULL COMMENT '传真',
  `postcode` varchar(16) COLLATE utf8_bin DEFAULT NULL COMMENT '邮编',
  `address` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '地址',
  `province_id` smallint(6) DEFAULT NULL COMMENT '省份',
  `city_id` smallint(6) DEFAULT NULL COMMENT '城市',
  `district_id` smallint(6) DEFAULT NULL COMMENT '地区',
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否默认地址，1为是',
  `invoice_head` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '发票抬头',
  `remark` text COLLATE utf8_bin COMMENT '备注',
  `email` varchar(32) COLLATE utf8_bin DEFAULT NULL COMMENT '电邮',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新建日期',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '修改日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='客户地址表';



# Dump of table 9thleaf_customer_album
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer_album`;

CREATE TABLE `9thleaf_customer_album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '客户ID',
  `from_customer_id` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '其它用户ID',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `update_at` datetime DEFAULT NULL COMMENT '编辑时间',
  `remark` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '备注',
  `tribe_id` int(5) DEFAULT NULL COMMENT '部落ID',
  `is_show` tinyint(1) DEFAULT '0' COMMENT '是否公开 0不公开 1公开',
  `tribe_staff_id` varchar(16) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户相册关联表';



# Dump of table 9thleaf_customer_album_img
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer_album_img`;

CREATE TABLE `9thleaf_customer_album_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '客户ID',
  `album_id` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '相册关联ID',
  `path` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '路径',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `album_id` (`album_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户相册表';



# Dump of table 9thleaf_customer_balance
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer_balance`;

CREATE TABLE `9thleaf_customer_balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '建立时间',
  `customerid` int(11) DEFAULT NULL COMMENT '客户ID',
  `balancetotal` decimal(9,2) DEFAULT NULL COMMENT '结算总额',
  `bankname` varchar(128) DEFAULT NULL COMMENT '银行名称',
  `banksubname` varchar(128) DEFAULT NULL,
  `bankaccount` varchar(64) DEFAULT NULL COMMENT '银行账号',
  `status` int(11) DEFAULT '0' COMMENT '状态',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `realname` varchar(125) DEFAULT NULL COMMENT '真实姓名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户银行账号表';



# Dump of table 9thleaf_customer_browsing_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer_browsing_history`;

CREATE TABLE `9thleaf_customer_browsing_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品分类id',
  `p_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '商品名称',
  `p_price` decimal(9,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `created_at` datetime DEFAULT NULL COMMENT '浏览日期',
  `goods_thumb` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '缩略图',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='浏览记录表';



# Dump of table 9thleaf_customer_comment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer_comment`;

CREATE TABLE `9thleaf_customer_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_customer_id` int(11) NOT NULL COMMENT '评论者用户ID',
  `to_customer_id` int(11) DEFAULT NULL COMMENT '被评论者用户ID',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '评价内容',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未删除 1:删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='用户评价表';



# Dump of table 9thleaf_customer_corporation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer_corporation`;

CREATE TABLE `9thleaf_customer_corporation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '企业管理员ID',
  `corporation_name` varchar(50) NOT NULL DEFAULT '' COMMENT '企业名称',
  `corporation_area` varchar(30) DEFAULT NULL COMMENT '企业所在地',
  `address` varchar(400) DEFAULT NULL COMMENT '地址',
  `postcode` varchar(8) DEFAULT NULL COMMENT '邮编',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `contact_name` varchar(20) DEFAULT NULL COMMENT '联系人',
  `contact_mobile` varchar(20) DEFAULT NULL COMMENT '联系人手机',
  `deposit` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '保证金',
  `expired_date` date DEFAULT NULL COMMENT '到期日',
  `img_url` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺图片',
  `grade` tinyint(2) DEFAULT '1' COMMENT '企业等级 1 易货会员 2专卖店会员 3旗舰店会员 ',
  `corporation_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '企业性质',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '企业状态 0:未生效　1:生效      2：冻结',
  `template_type` int(11) DEFAULT NULL COMMENT '企业模版类型',
  `template_url` varchar(128) DEFAULT NULL COMMENT '企业模版URL',
  `approval_desc` varchar(512) DEFAULT NULL COMMENT '审核备注',
  `approval_date` datetime DEFAULT NULL COMMENT '审核日期',
  `approval_user` int(11) DEFAULT NULL COMMENT '审核人',
  `description` varchar(600) DEFAULT NULL COMMENT '企业简介',
  `province_id` int(11) DEFAULT NULL COMMENT '省份',
  `city_id` int(11) DEFAULT NULL COMMENT '城市',
  `district_id` int(11) DEFAULT NULL COMMENT '地區',
  `approval_status` int(11) DEFAULT '0' COMMENT '企业审核 0:未绑定 1:审核中 2:通过 3:不通过',
  `QR_code` varchar(255) DEFAULT NULL COMMENT '企业二维码',
  `credit` decimal(16,2) DEFAULT NULL,
  `auto_order_amount` decimal(9,2) DEFAULT '0.00' COMMENT '自动接单金额',
  `agent_id` int(11) DEFAULT NULL COMMENT '合伙人ID',
  `superiors_id` int(11) DEFAULT NULL,
  `app_id` int(11) DEFAULT NULL,
  `commission_rate` float NOT NULL DEFAULT '5' COMMENT '手续费比率',
  `privilege_id` int(11) NOT NULL DEFAULT '0' COMMENT '企业的角色权限',
  `responsible_mobile` varchar(20) DEFAULT NULL COMMENT '负责人联系方式',
  `responsible` varchar(20) DEFAULT NULL COMMENT '负责人姓名',
  `is_service` tinyint(1) DEFAULT '0' COMMENT '是否有权限设置服务：0否1是',
  `tel_num` varchar(20) DEFAULT NULL COMMENT '企业固定电话',
  `tel_num_extension` varchar(20) DEFAULT NULL COMMENT '企业分机号，可选',
  `contact_email` varchar(100) DEFAULT NULL COMMENT '联系人邮箱',
  `is_paied` tinyint(1) DEFAULT '0' COMMENT '保证金是否已经支付：0待支付，1已支付',
  `order_no` varchar(32) DEFAULT NULL COMMENT '保证金支付编号',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `user_id` int(16) DEFAULT NULL COMMENT '最后修改人ID',
  `agent_customer_id` int(32) DEFAULT NULL COMMENT '开通企业合伙人的ID',
  `open_type` int(2) NOT NULL DEFAULT '1' COMMENT '开通类型：1、正常开通  2、一键开店',
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='企业表';



# Dump of table 9thleaf_customer_corporation_view
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer_corporation_view`;

CREATE TABLE `9thleaf_customer_corporation_view` (
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `corp_id` int(11) unsigned NOT NULL DEFAULT '0',
  `admin_user` int(11) NOT NULL,
  `corp_name` varchar(50) NOT NULL DEFAULT '',
  `img_url` varchar(255) NOT NULL DEFAULT '',
  `corp_area` varchar(30) DEFAULT NULL,
  `grade` tinyint(2) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table 9thleaf_customer_credit_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer_credit_log`;

CREATE TABLE `9thleaf_customer_credit_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `credit` decimal(14,2) DEFAULT NULL COMMENT '授信额度',
  `relation_id` int(11) DEFAULT NULL COMMENT '关联支付账户表的ID',
  `id_event` int(11) DEFAULT NULL COMMENT '查询操作类型',
  `created_at` datetime DEFAULT NULL COMMENT '发生日期',
  `credit_start_time` datetime DEFAULT NULL COMMENT '开始日期',
  `credit_end_time` datetime DEFAULT NULL COMMENT '结束日期',
  `remark` text COMMENT '备注',
  `type` int(11) DEFAULT '1' COMMENT '1:收入 2:支出',
  `customer_id` int(10) DEFAULT NULL COMMENT '支付方的用户ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='授信表';



# Dump of table 9thleaf_customer_currency_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer_currency_log`;

CREATE TABLE `9thleaf_customer_currency_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `relation_id` int(11) NOT NULL COMMENT '关联支付账户表的ID',
  `id_event` int(11) DEFAULT NULL COMMENT '请查询datadictionary表 TYPE=3',
  `created_at` datetime DEFAULT NULL COMMENT '日期',
  `remark` varchar(128) DEFAULT NULL COMMENT '备注',
  `app_id` int(11) DEFAULT '0' COMMENT 'APP_ID',
  `amount` decimal(16,2) DEFAULT NULL COMMENT '金額',
  `order_no` varchar(32) DEFAULT NULL COMMENT '订单号',
  `beginning_balance` decimal(16,2) DEFAULT NULL COMMENT '期初余额',
  `ending_balance` decimal(16,2) DEFAULT NULL COMMENT '最终余额',
  `state` int(1) DEFAULT '1' COMMENT '1：正常 2：异常（对比该账户本次操作的期初余额跟该上一条记录的最终金额）',
  `type` tinyint(2) NOT NULL COMMENT '1:收入 2:支出',
  `customer_id` int(11) NOT NULL COMMENT '收入来源和支付方的ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='M卷日志表';



# Dump of table 9thleaf_customer_demand_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer_demand_history`;

CREATE TABLE `9thleaf_customer_demand_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
  `keyword` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '关键词',
  `type` tinyint(2) DEFAULT '0' COMMENT '0:关键字搜索 1:分类搜索',
  `created_at` datetime NOT NULL COMMENT '搜索日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='需求搜索记录表';



# Dump of table 9thleaf_customer_identity
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer_identity`;

CREATE TABLE `9thleaf_customer_identity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '用户ID',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:商业机构 2:非商业机构 3:社会组织',
  `organization_name` varchar(64) COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '机构(组织)名称',
  `organizationl_duties` varchar(64) COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '机构(组织)职务',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='用户身份表';



# Dump of table 9thleaf_customer_label
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer_label`;

CREATE TABLE `9thleaf_customer_label` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `customer_id` int(11) NOT NULL COMMENT '用户id',
  `label_id` int(11) NOT NULL COMMENT '标签id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='标签关注表';



# Dump of table 9thleaf_customer_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer_menu`;

CREATE TABLE `9thleaf_customer_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(50) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员ID',
  `url` varchar(300) DEFAULT NULL COMMENT '跳转连接',
  `sequence` mediumint(9) NOT NULL DEFAULT '1' COMMENT '排序',
  `app_id` int(11) DEFAULT NULL COMMENT '企业号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_customer_message
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer_message`;

CREATE TABLE `9thleaf_customer_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL DEFAULT '' COMMENT '消息标题',
  `customer_id` int(11) DEFAULT NULL COMMENT '用户id',
  `obj_id` int(11) DEFAULT NULL COMMENT '对象id',
  `message` text COMMENT '消息内容',
  `is_read` tinyint(1) DEFAULT '0' COMMENT '是否阅读0否1是',
  `is_detele` tinyint(1) DEFAULT '0' COMMENT '1:已删除 0:未删除',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  `type` tinyint(1) DEFAULT NULL COMMENT '类型1系统通知2订单通知3我的资产(优惠券)4部落通知',
  `template_id` int(11) DEFAULT NULL COMMENT '使用的模板ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户消息表';



# Dump of table 9thleaf_customer_money_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer_money_log`;

CREATE TABLE `9thleaf_customer_money_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `relation_id` int(11) NOT NULL COMMENT '关联支付账户表的ID',
  `id_event` int(11) DEFAULT NULL COMMENT '请查询datadictionary表 TYPE=3',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `remark` varchar(128) DEFAULT NULL COMMENT '备注',
  `app_id` int(11) DEFAULT NULL COMMENT 'APP_id',
  `cash` decimal(16,2) DEFAULT NULL COMMENT '支出现金',
  `charge_no` varchar(32) DEFAULT NULL COMMENT '单号',
  `beginning_balance` decimal(16,2) DEFAULT NULL COMMENT '期初余额',
  `ending_balance` decimal(16,2) DEFAULT NULL COMMENT '最终余额',
  `state` int(1) DEFAULT '1' COMMENT '1：正常 2：异常（对比该账户本次操作的期初余额跟该上一条记录的最终金额）',
  `type` tinyint(2) NOT NULL COMMENT '1:收入 2:支出',
  `customer_id` int(11) NOT NULL COMMENT '收入来源和支付方的用户ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='现金日志表';



# Dump of table 9thleaf_customer_rebate
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer_rebate`;

CREATE TABLE `9thleaf_customer_rebate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL COMMENT '用户id',
  `template_id` int(11) DEFAULT NULL COMMENT '分成模板id',
  `config_data` text COMMENT '角色：对象(customer_id/app_id)，json格式{“role_id”:角色id'':''"obj_id":对象id''}',
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(5) DEFAULT NULL COMMENT '后台用户id',
  PRIMARY KEY (`id`),
  KEY `customer_template` (`customer_id`,`template_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户分成表';



# Dump of table 9thleaf_customer_rebate_identity
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer_rebate_identity`;

CREATE TABLE `9thleaf_customer_rebate_identity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '用户id',
  `identity_id` int(11) NOT NULL COMMENT '身份id',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `user_id` tinyint(4) NOT NULL COMMENT '修改用户',
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id` (`customer_id`),
  KEY `identity_id` (`identity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户分成身份表';



# Dump of table 9thleaf_customer_upvote
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_customer_upvote`;

CREATE TABLE `9thleaf_customer_upvote` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_customer_id` int(11) NOT NULL COMMENT '点赞用户',
  `to_customer_id` int(11) NOT NULL COMMENT '被点赞用户',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `to_customer_id` (`to_customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户点赞表';



# Dump of table 9thleaf_datadictionary
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_datadictionary`;

CREATE TABLE `9thleaf_datadictionary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL COMMENT '名称',
  `type` int(11) NOT NULL COMMENT '类型 1:行业2:企业性质',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='事件表';



# Dump of table 9thleaf_easy_charge
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_easy_charge`;

CREATE TABLE `9thleaf_easy_charge` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `charge_no` varchar(11) DEFAULT NULL COMMENT '单号',
  `amount` decimal(16,2) DEFAULT '0.00' COMMENT '支付金额',
  `customer_id` int(11) NOT NULL COMMENT '用户ID',
  `payment_id` tinyint(2) DEFAULT '1' COMMENT '1:微信H5 2:支付宝 3:银联',
  `status` tinyint(2) DEFAULT '0' COMMENT '0:未支付，1:已支付，2:确认支付',
  `third_party_no` varchar(60) DEFAULT NULL COMMENT '第三方返回单号',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `source` tinyint(1) DEFAULT '2' COMMENT '1:PC 2:H5  3:安卓 4:IOS 5后台',
  `obj_type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1:简易店订单支付(order_sn)',
  `obj_no` varchar(32) NOT NULL DEFAULT '' COMMENT '对象号',
  `obj_id` int(11) DEFAULT NULL COMMENT '对象id',
  `app_sign` varchar(64) DEFAULT '51ehw' COMMENT 'app标识',
  PRIMARY KEY (`id`),
  UNIQUE KEY `charge_no` (`charge_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table 9thleaf_easy_charge_item
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_easy_charge_item`;

CREATE TABLE `9thleaf_easy_charge_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `easy_charge_id` int(11) DEFAULT NULL COMMENT '主表ID',
  `amount` decimal(16,2) DEFAULT '0.00' COMMENT '金额',
  `obj_id` tinyint(2) DEFAULT NULL COMMENT '事件对象ID（order_id）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table 9thleaf_easy_complain
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_easy_complain`;

CREATE TABLE `9thleaf_easy_complain` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '客户ID',
  `order_id` int(11) DEFAULT NULL COMMENT '订单ID',
  `contact` varchar(16) DEFAULT NULL COMMENT '联系方式',
  `email` varchar(32) DEFAULT NULL COMMENT '联系邮箱',
  `complain_reason` tinyint(1) DEFAULT NULL COMMENT '投诉原因',
  `complain_reason_other` varchar(120) DEFAULT NULL COMMENT '投诉原因的其他内容',
  `complain_desc` tinytext COMMENT '详细描述',
  `image` varchar(255) DEFAULT NULL COMMENT '图片',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `status` int(1) DEFAULT '0' COMMENT '处理状态：0未处理，1已处理',
  `customer_name` varchar(32) NOT NULL DEFAULT '' COMMENT '客户名称',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `remark` text COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='简易店投诉表';



# Dump of table 9thleaf_easy_corporation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_easy_corporation`;

CREATE TABLE `9thleaf_easy_corporation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL COMMENT '用户ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `real_name` varchar(16) NOT NULL DEFAULT '' COMMENT '卖家真实姓名',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1正常',
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='简易店';



# Dump of table 9thleaf_easy_order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_easy_order`;

CREATE TABLE `9thleaf_easy_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(32) NOT NULL DEFAULT '' COMMENT '订单号',
  `product_name` varchar(30) DEFAULT NULL COMMENT '产品名称',
  `product_price` decimal(9,2) DEFAULT NULL COMMENT '产品单价',
  `product_img` varchar(255) DEFAULT NULL COMMENT '产品主图',
  `quantity` mediumint(9) DEFAULT NULL COMMENT '购买数量',
  `product_id` int(11) DEFAULT NULL COMMENT '产品ID',
  `tribe_id` int(11) NOT NULL COMMENT '订单所属部落ID',
  `customer_id` int(11) NOT NULL COMMENT '买家用户ID',
  `status` tinyint(1) NOT NULL COMMENT '1:待付款 2:已付款  3:已发货 4:已完成未评价 5:已完成并评价 6:订单取消 7:订单取消待退款 8:订单取消已退款 9订单异常',
  `total_price` decimal(9,2) NOT NULL DEFAULT '0.00' COMMENT '订单总价',
  `order_source` tinyint(1) DEFAULT '0' COMMENT '订单来源 0:H5 1:IOS 2:安卓',
  `is_delete` tinyint(1) DEFAULT '0' COMMENT '0:未删除 1:已删除',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `easy_corp_id` int(11) NOT NULL COMMENT '卖家简易店ID',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `tribe_id` (`tribe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='简易店订单表';



# Dump of table 9thleaf_easy_order_delivery
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_easy_order_delivery`;

CREATE TABLE `9thleaf_easy_order_delivery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单流水号',
  `consignee` varchar(32) NOT NULL DEFAULT '' COMMENT '收货人',
  `contact_name` varchar(32) DEFAULT NULL COMMENT '联系人姓名',
  `contact_mobile` varchar(11) DEFAULT NULL COMMENT '联系人手机',
  `contact_phone` varchar(32) DEFAULT NULL COMMENT '联系人电话',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `province` varchar(32) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(32) NOT NULL DEFAULT '' COMMENT '城市',
  `district` varchar(32) NOT NULL DEFAULT '' COMMENT '县区',
  `province_id` smallint(6) NOT NULL COMMENT '省份ID',
  `city_id` smallint(6) NOT NULL COMMENT '城市ID',
  `district_id` smallint(6) NOT NULL COMMENT '县区ID',
  `postcode` varchar(16) DEFAULT NULL COMMENT '邮政编码',
  `shipping_remark` text COMMENT '备注',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_ORDER_ID` (`order_id`) USING BTREE,
  KEY `IDX_PROVINCE_ID` (`province_id`) USING BTREE,
  KEY `IDX_CITY_ID` (`city_id`) USING BTREE,
  KEY `IDX_DISTRICT_ID` (`district_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='订单配送明细表';



# Dump of table 9thleaf_easy_order_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_easy_order_log`;

CREATE TABLE `9thleaf_easy_order_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL COMMENT '订单ID',
  `status` tinyint(1) DEFAULT NULL COMMENT '1:待付款 2:已付款  3:已发货 4:已完成未评价 5:已完成并评价 6:订单取消 7:订单取消待退款 8:订单取消已退款 9订单异常',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `remark` varchar(11) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='简易店订单状态更新表';



# Dump of table 9thleaf_easy_product
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_easy_product`;

CREATE TABLE `9thleaf_easy_product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `easy_corp_id` int(11) NOT NULL COMMENT '简易店ID',
  `tribe_id` int(11) DEFAULT NULL COMMENT '产品所属部落',
  `product_name` varchar(50) NOT NULL DEFAULT '' COMMENT '产品名称',
  `price` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '单价',
  `desc` text COMMENT '产品描述',
  `stock` mediumint(9) NOT NULL DEFAULT '0' COMMENT '库存',
  `is_on_sale` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:下架 1:上架 3:删除',
  `remarks` text COMMENT '备注',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否置顶 0否 1是',
  PRIMARY KEY (`id`),
  KEY `easy_corp_id` (`easy_corp_id`),
  KEY `tribe_id` (`tribe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='简易店的产品';



# Dump of table 9thleaf_easy_product_img
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_easy_product_img`;

CREATE TABLE `9thleaf_easy_product_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `product_id` int(11) NOT NULL COMMENT '商品ID',
  `pic_rank` smallint(6) NOT NULL DEFAULT '0' COMMENT '轮播图排序1,2,3,4,5',
  `path` varchar(500) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '轮播图路径',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '图片类型，0轮播图，1封面图',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='简易商品图片表';



# Dump of table 9thleaf_easy_refund_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_easy_refund_log`;

CREATE TABLE `9thleaf_easy_refund_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` tinyint(2) NOT NULL DEFAULT '0' COMMENT '支付方式ID',
  `charge_no` varchar(32) NOT NULL DEFAULT '' COMMENT '充值号',
  `order_sn` varchar(32) NOT NULL DEFAULT '' COMMENT '订单号',
  `third_party_no` varchar(255) NOT NULL DEFAULT '' COMMENT '第三方充值订单号',
  `out_refund_no` varchar(32) NOT NULL DEFAULT '' COMMENT '退款单号（自定义）',
  `third_party_refund_no` varchar(255) DEFAULT NULL COMMENT '第三方退款单号',
  `refund_fee` decimal(16,2) DEFAULT NULL COMMENT '退款金额',
  `remark` text COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0处理中1成功2失败',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '生成日期',
  `refund_date` datetime DEFAULT NULL COMMENT '退款日期',
  `txnTime` varchar(14) NOT NULL DEFAULT '' COMMENT '订单发送时间（银联）',
  `app_sign` varchar(64) NOT NULL DEFAULT '' COMMENT '应用标识',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='简易退款日志表';



# Dump of table 9thleaf_easy_wechat_pay_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_easy_wechat_pay_log`;

CREATE TABLE `9thleaf_easy_wechat_pay_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `appid` varchar(50) DEFAULT NULL,
  `bank_type` varchar(20) DEFAULT NULL,
  `cash_fee` varchar(30) DEFAULT NULL,
  `fee_type` varchar(10) DEFAULT NULL,
  `is_subscribe` varchar(10) DEFAULT NULL,
  `mch_id` varchar(30) DEFAULT NULL,
  `nonce_str` varchar(50) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL,
  `out_trade_no` varchar(50) DEFAULT NULL,
  `result_code` varchar(25) DEFAULT NULL,
  `return_code` varchar(25) DEFAULT NULL,
  `sign` varchar(50) DEFAULT NULL,
  `time_end` varchar(50) DEFAULT NULL,
  `total_fee` int(11) DEFAULT NULL,
  `trade_type` varchar(30) DEFAULT NULL,
  `transaction_id` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_entity_card
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_entity_card`;

CREATE TABLE `9thleaf_entity_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '实体卡ID',
  `card_number` varchar(32) CHARACTER SET latin1 NOT NULL COMMENT '卡的编号',
  `batch_id` int(11) NOT NULL COMMENT '批次ID',
  `card_account` decimal(10,2) DEFAULT NULL COMMENT '金额',
  `card_balance` decimal(10,2) DEFAULT NULL COMMENT '余额',
  `order_id` int(11) DEFAULT NULL COMMENT '销售单号',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `start_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '开始时间',
  `end_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '结束时间',
  `send_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '发送状态0未发送',
  `excel_url` varchar(64) DEFAULT NULL COMMENT '导入文件路径',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='实体卡表';



# Dump of table 9thleaf_event
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_event`;

CREATE TABLE `9thleaf_event` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `event_name` varchar(40) NOT NULL DEFAULT '',
  `uri` varchar(255) NOT NULL DEFAULT '/',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='事件操作表';



# Dump of table 9thleaf_external_order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_external_order`;

CREATE TABLE `9thleaf_external_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `external_number` varchar(50) DEFAULT NULL COMMENT '第三方编号',
  `order_sn` varchar(22) NOT NULL,
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  `type` tinyint(1) DEFAULT NULL COMMENT '1:广告商',
  `shop_number` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_sn` (`order_sn`),
  UNIQUE KEY `external_number` (`external_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_faq
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_faq`;

CREATE TABLE `9thleaf_faq` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(120) NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '详细内容',
  `source` varchar(60) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新建日期',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '修改日期',
  `app_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='FAQ表';



# Dump of table 9thleaf_favourites
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_favourites`;

CREATE TABLE `9thleaf_favourites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '客户ID',
  `product_id` int(11) NOT NULL COMMENT '产品ID',
  `product_name1` varchar(128) NOT NULL DEFAULT '0' COMMENT '产品名称',
  `goods_thumb1` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '缩略图',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收藏夹';



# Dump of table 9thleaf_favourites_corporation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_favourites_corporation`;

CREATE TABLE `9thleaf_favourites_corporation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '用户账户',
  `corporation_id` int(11) NOT NULL COMMENT '企业ID',
  `created_at` datetime DEFAULT NULL COMMENT '收藏日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='企业收藏表';



# Dump of table 9thleaf_game_lucky_setting
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_game_lucky_setting`;

CREATE TABLE `9thleaf_game_lucky_setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `start_time` time DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT '20.00',
  `total_num` smallint(4) NOT NULL DEFAULT '10',
  `method` tinyint(4) DEFAULT '0' COMMENT '0为随机，1为定额',
  `app_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='幸运转盘游戏设置表';



# Dump of table 9thleaf_groupbuy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_groupbuy`;

CREATE TABLE `9thleaf_groupbuy` (
  `buy_num` int(11) NOT NULL AUTO_INCREMENT COMMENT '團購單號',
  `create_date` datetime NOT NULL COMMENT '開單日期',
  `enddate` datetime DEFAULT NULL COMMENT '結束日期',
  `menber_num` int(11) DEFAULT '0' COMMENT '成團人數',
  `status` int(11) DEFAULT '0' COMMENT '狀態 0:未成團 1:成團 2:無效訂單',
  `productid` int(11) NOT NULL COMMENT '產品ID',
  `activity_num` varchar(128) DEFAULT NULL COMMENT '活動編號',
  `head_menber` int(11) NOT NULL COMMENT '團長',
  PRIMARY KEY (`buy_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购';



# Dump of table 9thleaf_guarantee
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_guarantee`;

CREATE TABLE `9thleaf_guarantee` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL COMMENT '被担保人用户名',
  `customer_id` int(11) DEFAULT NULL COMMENT '被担保人ID',
  `nick_name` varchar(32) DEFAULT NULL COMMENT '被担保人昵称',
  `tribe_id` int(11) DEFAULT NULL COMMENT '部落ID',
  `guarantee_total` decimal(12,2) DEFAULT '0.00' COMMENT '担保总额',
  `begin_time` date DEFAULT NULL COMMENT '开始日期',
  `end_time` date DEFAULT NULL COMMENT '结束日期',
  `Invalid_time` date DEFAULT NULL COMMENT '修改为失效状态的日期',
  `is_effective` tinyint(1) DEFAULT '1' COMMENT '1:生效 2:失效',
  `effective_user_id` int(11) DEFAULT NULL COMMENT '记录生效操作者ID',
  `Invalid_user_id` int(11) DEFAULT NULL COMMENT '记录失效操作者ID',
  `insert_time` datetime DEFAULT NULL COMMENT '添加记录时间',
  PRIMARY KEY (`id`),
  KEY `tribe_id` (`tribe_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='担保记录表';



# Dump of table 9thleaf_guarantee_detail
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_guarantee_detail`;

CREATE TABLE `9thleaf_guarantee_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `guarantee_id` int(11) DEFAULT NULL COMMENT '担保记录ID',
  `customer_id` int(11) DEFAULT NULL COMMENT '担保人ID',
  `guarantee_money` decimal(10,2) DEFAULT NULL COMMENT '担保金额',
  `app_id1` int(11) DEFAULT NULL COMMENT '担保人站点ID',
  PRIMARY KEY (`id`),
  KEY `guarantee_id` (`guarantee_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='担保详情表';



# Dump of table 9thleaf_guarantee_rebate
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_guarantee_rebate`;

CREATE TABLE `9thleaf_guarantee_rebate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_rebate_id` int(11) DEFAULT NULL COMMENT '分成表ID',
  `customer_id` int(11) DEFAULT NULL COMMENT '担保人ID(分到钱的用户)',
  `rebaterate` float DEFAULT NULL COMMENT '比率',
  `rebate` decimal(9,2) DEFAULT NULL COMMENT '分到的金额',
  `guarantee_money` decimal(12,2) DEFAULT NULL COMMENT '担保额',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `order_rebate_id` (`order_rebate_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='担保人分成明细表';



# Dump of table 9thleaf_guarantee_request
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_guarantee_request`;

CREATE TABLE `9thleaf_guarantee_request` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '申请担保人id',
  `guarantee_er_id` int(11) NOT NULL COMMENT '担保人id',
  `tribe_id` int(11) DEFAULT NULL COMMENT '部落ID(为了跟踪)',
  `member_mobile` varchar(16) DEFAULT NULL COMMENT '申请人手机号码',
  `member_name` varchar(32) DEFAULT NULL COMMENT '申请担保人名称',
  `corporation_name` varchar(128) DEFAULT NULL COMMENT '申请人企业名称',
  `duties` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '申请人企业职务',
  `provice` varchar(128) DEFAULT NULL COMMENT '申请人所属省份',
  `city` varchar(32) DEFAULT NULL COMMENT '申请人所属地区',
  `tribe_name` varchar(32) DEFAULT NULL COMMENT '部落名称',
  `role_name` varchar(32) DEFAULT NULL COMMENT '申请人部落职务',
  `guarantee_name` varchar(32) DEFAULT NULL COMMENT '担保人名称',
  `guarantee_mobile` varchar(16) DEFAULT NULL COMMENT '担保人手机号码',
  `money` decimal(12,2) NOT NULL COMMENT '担保金额',
  `actual_money` decimal(12,2) DEFAULT '0.00' COMMENT '实际担保金额',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `update_at` datetime DEFAULT NULL COMMENT '发放时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1待审核2通过3拒绝',
  `is_grant` tinyint(1) DEFAULT '1' COMMENT '1:待发放 2:已发放',
  `contract_sn` varchar(64) DEFAULT NULL COMMENT '合约编号',
  `remark` varchar(256) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `tribe_id` (`tribe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='担保申请记录表';



# Dump of table 9thleaf_hot_keywords
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_hot_keywords`;

CREATE TABLE `9thleaf_hot_keywords` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `customer_id` int(11) DEFAULT NULL COMMENT '用户id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `frequency` int(11) DEFAULT '0' COMMENT '搜索次数',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1商品2部落',
  PRIMARY KEY (`id`),
  KEY `keyword` (`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='热门搜索';



# Dump of table 9thleaf_integral_after_sales
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_integral_after_sales`;

CREATE TABLE `9thleaf_integral_after_sales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单主键id',
  `integral_item_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单产品表id',
  `barcode_id` int(11) NOT NULL DEFAULT '0' COMMENT '售后码主键id',
  `product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品表主键id',
  `source` tinyint(1) NOT NULL DEFAULT '1' COMMENT '售后来源 1:订单售后 2:售后码售后 3:商品码售后',
  `number` int(11) NOT NULL COMMENT '产品数量',
  `customer_id` int(11) NOT NULL COMMENT '用户id',
  `application_time` datetime NOT NULL COMMENT '申请时间',
  `update_time` datetime NOT NULL COMMENT '售后状态更新时间',
  `reason` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '售后原因',
  `type` tinyint(4) NOT NULL COMMENT '售后类型 1:退货退积分 2:退货换货 3:维修',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '售后状态 1.待审核2.审核通过待收货3.平台已收货(退积分)4.平台已换货／维修5.售后完成6.商家审核不通过7.用户取消售后',
  `app_id` int(11) NOT NULL COMMENT '公司id',
  `contact_mobile` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT '收货人手机',
  `consignee` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '详细地址',
  `province` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '省份',
  `city` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '城市',
  `district` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '县区',
  `province_id` smallint(6) NOT NULL COMMENT '省份ID',
  `city_id` smallint(6) NOT NULL COMMENT '城市ID',
  `district_id` smallint(6) NOT NULL COMMENT '县区ID',
  `total_integral` decimal(9,2) NOT NULL DEFAULT '0.00' COMMENT '售后积分',
  `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `IDX_ORDER_ID` (`order_id`) USING BTREE,
  KEY `IDX_INTEGRAL_ITEM_ID` (`integral_item_id`) USING BTREE,
  KEY `IDX_CUSTOMER_ID` (`customer_id`) USING BTREE,
  KEY `IDX_APP_ID` (`app_id`) USING BTREE,
  KEY `IDX_BARCODE_ID` (`barcode_id`) USING BTREE,
  KEY `IDX_STATU` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='积分商城售后表记录表';



# Dump of table 9thleaf_integral_aftersales_delievry
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_integral_aftersales_delievry`;

CREATE TABLE `9thleaf_integral_aftersales_delievry` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `after_sales_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '售后id',
  `shipping_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配送方式id',
  `name` varchar(32) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '配送方式名称',
  `waybill` varchar(32) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '运单号',
  `from` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '发货方： 1 买家 2 商城',
  `send_time` datetime NOT NULL COMMENT '发货时间',
  PRIMARY KEY (`id`),
  KEY `order_id` (`after_sales_id`),
  KEY `shipping_id` (`shipping_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='售后配送表';



# Dump of table 9thleaf_integral_order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_integral_order`;

CREATE TABLE `9thleaf_integral_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '购买用户id',
  `total_integral` int(11) NOT NULL COMMENT '实付积分',
  `message` varchar(255) NOT NULL DEFAULT '' COMMENT '用户留言',
  `amount` int(11) NOT NULL DEFAULT '1' COMMENT '购买数量',
  `order_num` varchar(255) NOT NULL DEFAULT '' COMMENT '订单号',
  `created_at` datetime NOT NULL COMMENT '下单时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '订单状态1.待发货2.已发货3.收货并完成4已取消',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `app_id` int(11) NOT NULL COMMENT '公司',
  `recycle` tinyint(1) NOT NULL DEFAULT '1' COMMENT '回收站 1正常 0回收站',
  `delivery_id` int(10) DEFAULT NULL COMMENT '收货人信息',
  `shipping_id` int(11) DEFAULT NULL COMMENT '物流id',
  `shipping_sn` varchar(255) DEFAULT NULL COMMENT '货运单号',
  `send_time` datetime DEFAULT NULL COMMENT '发货时间',
  `note` text COMMENT '状态修改备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='积分商城订单表';



# Dump of table 9thleaf_integral_order_delivery
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_integral_order_delivery`;

CREATE TABLE `9thleaf_integral_order_delivery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单流水号',
  `consignee` varchar(32) NOT NULL DEFAULT '' COMMENT '收货人',
  `contact_name` varchar(32) DEFAULT NULL COMMENT '联系人姓名',
  `contact_mobile` varchar(11) DEFAULT NULL COMMENT '联系人手机',
  `contact_phone` varchar(32) DEFAULT NULL COMMENT '联系人电话',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `province` varchar(32) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(32) NOT NULL DEFAULT '' COMMENT '城市',
  `district` varchar(32) NOT NULL DEFAULT '' COMMENT '县区',
  `province_id` smallint(6) NOT NULL COMMENT '省份ID',
  `city_id` smallint(6) NOT NULL COMMENT '城市ID',
  `district_id` smallint(6) NOT NULL COMMENT '县区ID',
  `postcode` varchar(16) DEFAULT NULL COMMENT '邮政编码',
  `shipping_remark` text COMMENT '备注',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_ORDER_ID` (`order_id`) USING BTREE,
  KEY `IDX_PROVINCE_ID` (`province_id`) USING BTREE,
  KEY `IDX_CITY_ID` (`city_id`) USING BTREE,
  KEY `IDX_DISTRICT_ID` (`district_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单配送明细表';



# Dump of table 9thleaf_integral_order_item
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_integral_order_item`;

CREATE TABLE `9thleaf_integral_order_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) NOT NULL COMMENT '用户id',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `product_id` int(11) NOT NULL COMMENT '商品id',
  `product_name` varchar(128) NOT NULL DEFAULT '' COMMENT '商品名称',
  `quantity` mediumint(9) DEFAULT '0' COMMENT '产品数量',
  `integral` int(11) NOT NULL COMMENT '购买积分',
  `warranty` int(11) DEFAULT '30' COMMENT '保修天数（自收货日起）',
  `after_sale_deadline` datetime DEFAULT NULL COMMENT '售后服务到期时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='积分商城订单明细产品表';



# Dump of table 9thleaf_integral_order_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_integral_order_log`;

CREATE TABLE `9thleaf_integral_order_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单状态',
  `log_date` datetime DEFAULT NULL COMMENT '状态改变时间',
  PRIMARY KEY (`id`),
  KEY `check_out` (`orderid`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单状态修改日志表';



# Dump of table 9thleaf_integral_pic
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_integral_pic`;

CREATE TABLE `9thleaf_integral_pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `product_id` int(11) NOT NULL COMMENT '商品ID',
  `pic_rank` smallint(6) NOT NULL DEFAULT '0' COMMENT '轮播图排序1,2,3,4,5',
  `path` varchar(500) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '轮播图路径',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '图片类型，0轮播图，1封面图',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='积分商品图片表';



# Dump of table 9thleaf_integral_product
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_integral_product`;

CREATE TABLE `9thleaf_integral_product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '积分商品名称',
  `product_desc` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '积分商品描述',
  `integral` int(11) NOT NULL COMMENT '兑换积分',
  `stock` int(11) NOT NULL COMMENT '库存',
  `exchange_limit` int(11) DEFAULT '0' COMMENT '兑换限制，0不限制',
  `detail_desc` text CHARACTER SET utf8 COMMENT '手机端图文说明',
  `recommend` tinyint(1) DEFAULT '0' COMMENT '0不推荐，1推荐',
  `rank` int(10) NOT NULL DEFAULT '0' COMMENT '商品排序',
  `status` tinyint(1) DEFAULT '0' COMMENT '0仓库中，1上架',
  `app_id` int(11) NOT NULL COMMENT '站点',
  `recycle` int(1) NOT NULL DEFAULT '1' COMMENT '0放入回收站，1正常',
  `quantity` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '已兑数量',
  `quantity_extra` int(11) NOT NULL DEFAULT '0' COMMENT '默认销量',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='积分商城商品表';



# Dump of table 9thleaf_label
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_label`;

CREATE TABLE `9thleaf_label` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '标签名',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_lottery
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_lottery`;

CREATE TABLE `9thleaf_lottery` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '关联手机',
  `openid` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '第三方关联openid',
  `customer_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '51客户ID',
  `is_valid` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效 1有效 0无效',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='51易货投票抽奖表';



# Dump of table 9thleaf_lottery_award
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_lottery_award`;

CREATE TABLE `9thleaf_lottery_award` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lottery_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '投票抽奖表ID',
  `customer_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '51客户ID',
  `award` varchar(225) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '奖品',
  `item` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'item值',
  `package_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券ID',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为领取,1已领取',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `lottery_id` (`lottery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='51易货投票抽奖奖品表';



# Dump of table 9thleaf_lottery_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_lottery_config`;

CREATE TABLE `9thleaf_lottery_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '事件',
  `value` varchar(16) NOT NULL DEFAULT '' COMMENT '值',
  `remarks` varchar(256) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `name_index` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='抽奖系统配置表';



# Dump of table 9thleaf_lottery_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_lottery_log`;

CREATE TABLE `9thleaf_lottery_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lottery_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '投票抽奖表ID',
  `vote_num` int(3) DEFAULT '0' COMMENT '投票总次数',
  `total_num` int(3) DEFAULT '0' COMMENT '可抽奖次数',
  `numbers` int(3) DEFAULT '0' COMMENT '已抽奖次数',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `vote_at` timestamp NULL DEFAULT NULL COMMENT '投票更新时间',
  PRIMARY KEY (`id`),
  KEY `lottery_id` (`lottery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='51易货投票抽奖记录表';



# Dump of table 9thleaf_message_template
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_message_template`;

CREATE TABLE `9thleaf_message_template` (
  `template_id` int(11) unsigned NOT NULL COMMENT '事件Id',
  `name` varchar(128) DEFAULT NULL COMMENT '模版名称',
  `parameter` varchar(256) DEFAULT NULL COMMENT '参数',
  `message` text COMMENT '消息内容',
  `content` text COMMENT '图文内容',
  `type` tinyint(1) DEFAULT NULL COMMENT '类型1系统通知2订单通知3我的资产(优惠券)4部落通知',
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更改日期',
  `user_id` int(11) DEFAULT NULL COMMENT '操作者ID',
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='消息模版表';



# Dump of table 9thleaf_notice
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_notice`;

CREATE TABLE `9thleaf_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL COMMENT '发布标题',
  `n_content` text COMMENT '发布内容',
  `create_at` datetime DEFAULT NULL COMMENT '发布日期',
  `create_by` int(11) DEFAULT NULL COMMENT '发布人',
  `n_flag` int(11) DEFAULT NULL COMMENT '公告标签',
  `app_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_order`;

CREATE TABLE `9thleaf_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(32) DEFAULT NULL COMMENT '订单流水号',
  `customer_id` int(11) NOT NULL COMMENT '客户ID',
  `payment_id` smallint(6) NOT NULL DEFAULT '0' COMMENT '支付ID',
  `shipping_id` smallint(6) NOT NULL DEFAULT '0' COMMENT '物流ID',
  `total_product_price` decimal(9,2) NOT NULL DEFAULT '0.00' COMMENT '产品总价',
  `total_weight` mediumint(9) NOT NULL DEFAULT '0' COMMENT '总重量',
  `auto_freight_fee` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '运费',
  `actual_freight_fee` decimal(6,2) DEFAULT NULL COMMENT '实际运费',
  `payment_fee` decimal(6,2) DEFAULT NULL,
  `total_cost` decimal(9,2) DEFAULT NULL,
  `total_price` decimal(9,2) NOT NULL COMMENT '总价（M券）',
  `commission` decimal(12,2) unsigned DEFAULT '0.00' COMMENT '需支付的现金手续费（买家付）',
  `need_pay` decimal(9,2) DEFAULT NULL COMMENT '需付',
  `already_pay` decimal(9,2) DEFAULT NULL COMMENT '已付',
  `is_need_invoice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否需要发票',
  `customer_remark` text COMMENT '客户标记',
  `status` tinyint(4) NOT NULL COMMENT '状态1:商家未确认2:商家已确认3:确认客户付款4:已付款5:货到付款6:已发货7:订单完成(已废除)8:收货并付款9:订单完成10:已取消11:已退款12:已退货13:已存货14:订单完成已评价(已废除)',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已删除',
  `place_at` datetime NOT NULL COMMENT '发生时间',
  `corporation_id` int(11) DEFAULT NULL COMMENT '企业ID',
  `app_id` int(11) NOT NULL COMMENT '公司ID',
  `sendmethod` tinyint(2) DEFAULT NULL,
  `order_type` tinyint(1) DEFAULT NULL,
  `status_yugou` tinyint(4) DEFAULT NULL,
  `activity_type` int(11) DEFAULT '0' COMMENT '活動類型',
  `activity_id` varchar(128) DEFAULT NULL COMMENT '活動NUM',
  `order_source` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '订单来源 1:PC 2:微信 3:安卓 4:ios 5:其它',
  `pay_time` datetime DEFAULT NULL COMMENT '付款时间',
  `source` tinyint(11) DEFAULT NULL COMMENT '来源0默认1部落',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_ORDER_SN` (`order_sn`) USING BTREE,
  KEY `IDX_CUSTOMER_ID` (`customer_id`) USING BTREE,
  KEY `IDX_IS_DELETE` (`is_delete`) USING BTREE,
  KEY `IDX_IS_NEED_INVOICE` (`is_need_invoice`) USING BTREE,
  KEY `IDX_STATUS` (`status`) USING BTREE,
  KEY `IND_CORPORATION_ID` (`corporation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表';



# Dump of table 9thleaf_order_comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_order_comments`;

CREATE TABLE `9thleaf_order_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderitem_id` int(11) DEFAULT NULL COMMENT '订单子项ID',
  `product_score` int(11) DEFAULT NULL COMMENT '产品评分',
  `service_score` int(11) DEFAULT NULL COMMENT '服务评分',
  `content` varchar(512) DEFAULT NULL COMMENT '评论',
  `create_by` int(11) DEFAULT NULL COMMENT '评论客户ID',
  `create_at` datetime DEFAULT NULL COMMENT '评论日期',
  `status` int(11) DEFAULT NULL COMMENT '评价状态',
  `reply_content` varchar(1024) DEFAULT NULL COMMENT '商家回复',
  `reply_by` int(11) DEFAULT NULL COMMENT '商家回复人ID',
  `reply_at` datetime DEFAULT NULL COMMENT '商家回复日期',
  `ext_content` varchar(512) DEFAULT NULL COMMENT '评论追加',
  `ext_at` datetime DEFAULT NULL COMMENT '追加日期',
  PRIMARY KEY (`id`),
  KEY `orderitem_id_index` (`orderitem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单评论表';



# Dump of table 9thleaf_order_delivery
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_order_delivery`;

CREATE TABLE `9thleaf_order_delivery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单流水号',
  `consignee` varchar(32) NOT NULL DEFAULT '' COMMENT '收货人',
  `contact_name` varchar(32) DEFAULT NULL COMMENT '联系人姓名',
  `contact_mobile` varchar(11) DEFAULT NULL COMMENT '联系人手机',
  `contact_phone` varchar(32) DEFAULT NULL COMMENT '联系人电话',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `province` varchar(32) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(32) NOT NULL DEFAULT '' COMMENT '城市',
  `district` varchar(32) NOT NULL DEFAULT '' COMMENT '县区',
  `province_id` smallint(6) NOT NULL COMMENT '省份ID',
  `city_id` smallint(6) NOT NULL COMMENT '城市ID',
  `district_id` smallint(6) NOT NULL COMMENT '县区ID',
  `postcode` varchar(16) DEFAULT NULL COMMENT '邮政编码',
  `shipping_remark` text COMMENT '备注',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_ORDER_ID` (`order_id`) USING BTREE,
  KEY `IDX_PROVINCE_ID` (`province_id`) USING BTREE,
  KEY `IDX_CITY_ID` (`city_id`) USING BTREE,
  KEY `IDX_DISTRICT_ID` (`district_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单配送明细表';



# Dump of table 9thleaf_order_feedback
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_order_feedback`;

CREATE TABLE `9thleaf_order_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名字',
  `subject` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `content` mediumtext NOT NULL COMMENT '内容',
  `created_at` datetime NOT NULL COMMENT '评论日期',
  PRIMARY KEY (`id`),
  KEY `IDX_ORDER_ID` (`order_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单评论表';



# Dump of table 9thleaf_order_item
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_order_item`;

CREATE TABLE `9thleaf_order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(128) NOT NULL,
  `quantity` mediumint(9) NOT NULL,
  `price` decimal(9,2) NOT NULL,
  `weight` mediumint(9) NOT NULL,
  `sku_id` int(11) NOT NULL DEFAULT '0',
  `sku_value` varchar(255) DEFAULT NULL COMMENT 'SKU属性值',
  `goods_thumb` varchar(255) DEFAULT NULL COMMENT '图片',
  `source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0普通销售1部落销售',
  PRIMARY KEY (`id`),
  KEY `IDX_PRODUCT_ID` (`product_id`) USING BTREE,
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单明细产品表';



# Dump of table 9thleaf_order_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_order_log`;

CREATE TABLE `9thleaf_order_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `log_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单状态修改日志表';



# Dump of table 9thleaf_order_rebate
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_order_rebate`;

CREATE TABLE `9thleaf_order_rebate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL,
  `order_sn` varchar(32) DEFAULT NULL COMMENT '订单流水号',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rebate_1_id` int(11) DEFAULT NULL COMMENT '上级用户ID',
  `rebate_1` decimal(9,2) DEFAULT '0.00' COMMENT '上级分成',
  `rebaterate_1` float NOT NULL COMMENT '上级的分成比率',
  `rebate_2_id` int(11) DEFAULT NULL COMMENT '上上级用户ID',
  `rebate_2` decimal(9,2) DEFAULT '0.00' COMMENT '上上级分成',
  `rebaterate_2` float DEFAULT NULL COMMENT '上上级的分成比率',
  `rebate_3_id` int(11) DEFAULT NULL COMMENT '合伙人ID',
  `rebate_3` decimal(9,2) DEFAULT '0.00' COMMENT '合伙人',
  `rebaterate_3` float NOT NULL COMMENT '合伙人的分成比率',
  `rebate_4_id` int(11) DEFAULT '0' COMMENT '分站点ID',
  `rebate_4` decimal(9,2) DEFAULT '0.00' COMMENT '分站点',
  `rebaterate_4` float NOT NULL COMMENT '分站点分成比率',
  `rebate_5_id` int(11) DEFAULT '0' COMMENT '易货网ID',
  `rebate_5` decimal(9,2) DEFAULT '0.00' COMMENT '易货网',
  `rebaterate_5` float NOT NULL COMMENT '易货网分成比率',
  `rebate_6_id` int(11) DEFAULT NULL COMMENT '介绍人ID',
  `rebate_6` decimal(9,2) DEFAULT '0.00' COMMENT '介绍人',
  `rebaterate_6` float NOT NULL COMMENT '介绍人分成比率',
  `rebate_7_id` int(11) DEFAULT NULL COMMENT '服务者ID',
  `rebate_7` decimal(9,2) unsigned DEFAULT '0.00' COMMENT '服务者',
  `rebaterate_7` float NOT NULL COMMENT '服务者分成比率',
  `rebate_8` decimal(9,2) DEFAULT '0.00' COMMENT '担保人总额',
  `rebaterate_8` float(9,2) DEFAULT NULL COMMENT '担保人分成比率',
  `customer_id` int(11) DEFAULT NULL COMMENT '支出这笔分成的用户',
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '可分成总额',
  `rebate_type` tinyint(1) DEFAULT '2' COMMENT '分成类型1:会员加盟2:会员消费',
  `template_id` tinyint(3) DEFAULT '1' COMMENT '模板id',
  `app_id` int(11) DEFAULT '0' COMMENT '用户企业所属站点',
  `is_transfer` tinyint(1) DEFAULT '0' COMMENT '0:未转移数据，1:数据已经转移',
  PRIMARY KEY (`id`),
  KEY `customer_id_index` (`customer_id`),
  KEY `rebate_1_id_index` (`rebate_1_id`),
  KEY `rebate_2_id_index` (`rebate_2_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单计提表';



# Dump of table 9thleaf_order_rebate_detail
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_order_rebate_detail`;

CREATE TABLE `9thleaf_order_rebate_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_rebate_new_id` int(11) DEFAULT NULL COMMENT '分成表ID',
  `role_id` int(11) DEFAULT NULL COMMENT '角色id',
  `obj_id` int(11) DEFAULT NULL COMMENT '分成对象id',
  `rebate` decimal(9,2) DEFAULT '0.00' COMMENT '分成',
  `rebaterate` decimal(6,4) DEFAULT '0.0000' COMMENT '分成比率',
  `app_id` int(11) DEFAULT '0' COMMENT '分成用户站点id',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发生时间',
  `level` tinyint(1) DEFAULT '0' COMMENT '0:一级角色，1:二级角色',
  PRIMARY KEY (`id`),
  KEY `order_rebate_new_id` (`order_rebate_new_id`),
  KEY `role_id` (`role_id`),
  KEY `obj_id_index` (`obj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单计提表(详细分成)';



# Dump of table 9thleaf_order_rebate_new
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_order_rebate_new`;

CREATE TABLE `9thleaf_order_rebate_new` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL,
  `order_sn` varchar(32) DEFAULT NULL COMMENT '订单流水号',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(11) DEFAULT NULL COMMENT '支出这笔分成的用户',
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '可分成总额',
  `rebate_type` tinyint(1) DEFAULT '2' COMMENT '分成类型1:会员加盟2:会员消费',
  `template_id` tinyint(3) DEFAULT '1' COMMENT '模板id',
  `app_id` int(11) DEFAULT '0' COMMENT '用户企业所属站点ID',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未分成1已分成',
  PRIMARY KEY (`id`),
  KEY `customer_id_index` (`customer_id`),
  KEY `status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单计提表(新版)';



# Dump of table 9thleaf_order_temp
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_order_temp`;

CREATE TABLE `9thleaf_order_temp` (
  `id` int(11) NOT NULL DEFAULT '0',
  `order_sn` varchar(32) CHARACTER SET utf8 DEFAULT NULL COMMENT '订单流水号',
  `customer_id` int(11) NOT NULL COMMENT '客户ID',
  `total_price` decimal(9,2) NOT NULL COMMENT '总价',
  `commission` decimal(12,2) unsigned DEFAULT '0.00' COMMENT '需支付的现金手续费',
  `status` varchar(32) CHARACTER SET utf8 DEFAULT NULL COMMENT '状态1:商家未确认2:商家已确认4:已付款6:已发货9:订单完成(未评价)10:已取消11:已退款14:订单完成(已经评价)',
  `corp_customer_id` int(11) COMMENT '企业管理员ID'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table 9thleaf_order_verify
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_order_verify`;

CREATE TABLE `9thleaf_order_verify` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `verify_number` varchar(32) DEFAULT NULL COMMENT '核销编号',
  `verify_by` int(11) DEFAULT NULL COMMENT '核销员',
  `verify_time` datetime DEFAULT NULL COMMENT '核销时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单核销表';



# Dump of table 9thleaf_outstanding
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_outstanding`;

CREATE TABLE `9thleaf_outstanding` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `type` tinyint(1) NOT NULL COMMENT '类型1:杰出商会',
  `tribe_id` int(11) DEFAULT NULL COMMENT '部落ID',
  `grade` int(4) DEFAULT NULL COMMENT '10个等级',
  PRIMARY KEY (`id`),
  KEY `tribe_id` (`tribe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_package
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_package`;

CREATE TABLE `9thleaf_package` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `package_sn` varchar(32) NOT NULL DEFAULT '' COMMENT '货包流水号',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '货包名称',
  `corporation_id` int(11) DEFAULT NULL COMMENT '店铺id',
  `customer_id` int(11) NOT NULL COMMENT '发送人id',
  `specified_type` tinyint(1) NOT NULL COMMENT '类型：1商品2品类',
  `discount_type` tinyint(1) NOT NULL COMMENT '优惠方式：1折扣2满减3现场核销',
  `overtop_price` decimal(9,2) DEFAULT NULL COMMENT '金额要求',
  `deduction_price` decimal(9,2) DEFAULT NULL COMMENT '优惠金额',
  `discount` float DEFAULT NULL COMMENT '折扣',
  `give_type` int(11) NOT NULL COMMENT '赠送方式1所有人2数量',
  `number` int(11) DEFAULT '0' COMMENT '库存数量',
  `created_at` datetime NOT NULL COMMENT '创建日期',
  `update_at` datetime DEFAULT NULL COMMENT '审核日期',
  `grant_start_at` date NOT NULL COMMENT '发放开始日期',
  `grant_end_at` date NOT NULL COMMENT '发放过期日期',
  `coupon_start_at` date NOT NULL COMMENT '优惠有效日期',
  `coupon_end_at` date NOT NULL COMMENT '优惠过期日期',
  `describe` text COMMENT '说明',
  `coupon_image` varchar(64) DEFAULT NULL COMMENT '优惠卷图片',
  `ad_image` varchar(64) DEFAULT NULL COMMENT '广告图',
  `donation` tinyint(32) NOT NULL DEFAULT '2' COMMENT '转赠：1可以2不可以',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态：0新建1审核中2不通过3通过4已删除',
  `is_show` tinyint(32) NOT NULL DEFAULT '1' COMMENT '是否显示：0不显示1显示',
  `is_activity` tinyint(1) NOT NULL DEFAULT '0' COMMENT '转赠：0不活动1活动',
  PRIMARY KEY (`id`),
  KEY `IDX_CORP_ID` (`corporation_id`),
  KEY `IDX_CUSTOMER_ID` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='货包表';



# Dump of table 9thleaf_package_accredit
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_package_accredit`;

CREATE TABLE `9thleaf_package_accredit` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `p_id` int(11) NOT NULL COMMENT '货包关联id',
  `customer_id` int(11) NOT NULL COMMENT '授权人',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '授权数量',
  `status` tinyint(11) NOT NULL DEFAULT '1' COMMENT '状态1授权2取消',
  PRIMARY KEY (`id`),
  KEY `IDX_PACKAGE_ID` (`p_id`),
  KEY `IDX_CUSTOMER_ID` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='货包授权表';



# Dump of table 9thleaf_package_detail
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_package_detail`;

CREATE TABLE `9thleaf_package_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `p_id` int(11) NOT NULL COMMENT '货包关联id',
  `sender_id` int(11) NOT NULL COMMENT '发送人',
  `customer_id` int(11) DEFAULT NULL COMMENT '接受人',
  `created_at` datetime NOT NULL COMMENT '创建日期',
  `order_sn` varchar(32) DEFAULT NULL COMMENT '订单流水号',
  `status` tinyint(1) DEFAULT '2' COMMENT '状态1已使用2未使用3已退回4未领取',
  `collection_at` datetime DEFAULT NULL COMMENT '领取日期',
  `use_at` datetime DEFAULT NULL COMMENT '使用日期',
  PRIMARY KEY (`id`),
  KEY `IDX_PACKAGE_ID` (`p_id`),
  KEY `IDX_USER_ID` (`customer_id`),
  KEY `sender_id` (`sender_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='货包领取';



# Dump of table 9thleaf_package_item
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_package_item`;

CREATE TABLE `9thleaf_package_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `package_id` int(11) NOT NULL COMMENT '卡包id',
  `product_id` int(11) DEFAULT NULL COMMENT '商品id',
  `cate_id` int(11) DEFAULT NULL COMMENT '分类id',
  PRIMARY KEY (`id`),
  KEY `IDX_PACKAGE` (`package_id`),
  KEY `IDX_PRODUCT_ID` (`product_id`),
  KEY `IDX_CATE_ID` (`cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='货包关联表';



# Dump of table 9thleaf_pay_account
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_pay_account`;

CREATE TABLE `9thleaf_pay_account` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '支付用户',
  `passwd` varchar(64) DEFAULT NULL COMMENT '登录密码',
  `credit` decimal(14,2) DEFAULT '0.00' COMMENT '授信',
  `cash` decimal(14,2) DEFAULT '0.00' COMMENT '现金',
  `pay_passwd` varchar(64) DEFAULT NULL COMMENT '支付密码',
  `M_credit` decimal(14,2) DEFAULT '0.00' COMMENT 'M卷',
  `fingerprint_passwd` varchar(64) DEFAULT NULL COMMENT '指纹支付密码',
  `gesture_passwd` varchar(64) DEFAULT NULL COMMENT '手势支付密码',
  `credit_start_time` datetime DEFAULT NULL COMMENT '授信开始时间',
  `credit_end_time` datetime DEFAULT NULL COMMENT '授信结束时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='支付账户表';



# Dump of table 9thleaf_pay_relation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_pay_relation`;

CREATE TABLE `9thleaf_pay_relation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_pay` int(11) DEFAULT NULL COMMENT '支付账户ID',
  `customer_id` int(11) DEFAULT NULL COMMENT '用户ID',
  `cteated_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='关联 9thleaf_pay_account 表\n支付账号与用户或者店铺关联表';



# Dump of table 9thleaf_payment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_payment`;

CREATE TABLE `9thleaf_payment` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8_bin NOT NULL,
  `name` varchar(120) COLLATE utf8_bin NOT NULL,
  `fee` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `desc` text COLLATE utf8_bin NOT NULL,
  `charge_date` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `account` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `order` tinyint(3) unsigned DEFAULT '0',
  `pay_config` text COLLATE utf8_bin NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_cod` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_online` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='支付方式表';



# Dump of table 9thleaf_platform_rebate
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_platform_rebate`;

CREATE TABLE `9thleaf_platform_rebate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `obj_id` int(11) NOT NULL COMMENT '对象ID',
  `obj_type` int(11) NOT NULL COMMENT '对象类型1:51易货2:分站3:合伙人',
  `rebate_rate` float DEFAULT NULL COMMENT '分成比率',
  `total` decimal(16,2) DEFAULT NULL COMMENT '总价',
  `rebate` decimal(10,2) DEFAULT NULL COMMENT '分成金额',
  `rebate_type` int(11) DEFAULT NULL COMMENT '分成类型1:会员加盟2:会员消费',
  `order_id` int(11) DEFAULT NULL COMMENT '订单号',
  `corporation_id` int(11) DEFAULT NULL COMMENT '店铺ID',
  `created_at` datetime DEFAULT NULL COMMENT '新建日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分成表';



# Dump of table 9thleaf_product
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_product`;

CREATE TABLE `9thleaf_product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cat_id` int(11) DEFAULT NULL COMMENT '分类ID',
  `market_price` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '参考价',
  `vip_price` decimal(12,2) unsigned DEFAULT '0.00' COMMENT '换货价',
  `tribe_price` decimal(9,2) NOT NULL COMMENT '部落价格',
  `special_price` decimal(9,2) DEFAULT '0.00' COMMENT '特价',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '商品名称',
  `desc` text CHARACTER SET utf8 COLLATE utf8_bin COMMENT '详细描述',
  `stock` mediumint(9) unsigned DEFAULT NULL COMMENT '库存',
  `is_on_sale` tinyint(1) NOT NULL DEFAULT '0' COMMENT '产品状态0:下架 1:上架 2:申请上架 3:审核通过 4:审核不通过',
  `short_desc` tinytext CHARACTER SET utf8 COLLATE utf8_bin COMMENT '简短描述',
  `on_sale_at` datetime DEFAULT '1970-01-01 08:00:00' COMMENT '上架日期',
  `meta_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'Meta标题',
  `meta_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'Meta关键字',
  `meta_desc` text CHARACTER SET utf8 COLLATE utf8_bin COMMENT 'Meta描述',
  `is_new` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否新品，0表示否，1表示是，默认是',
  `is_hot` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否热销，0表示否，1表示是，默认否',
  `is_special_price` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否特价，0表示否，1表示是，默认否',
  `special_price_start_at` datetime DEFAULT '1970-01-01 08:00:00' COMMENT '特价日期开始',
  `special_price_end_at` datetime DEFAULT '1970-01-01 08:00:00' COMMENT '特价日期结束',
  `is_commend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否推荐，0表示否，1表示是，默认否',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除，0表示否，1表示是，默认否',
  `created_at` datetime NOT NULL DEFAULT '1970-01-01 08:00:00' COMMENT '添加日期',
  `updated_at` datetime NOT NULL DEFAULT '1970-01-01 08:00:00' COMMENT '更新日期',
  `sales_count` int(11) NOT NULL DEFAULT '0' COMMENT '销量',
  `sequence` smallint(6) NOT NULL DEFAULT '50' COMMENT '排序',
  `is_mc` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否MC区，0表示否，1表示是，默认否',
  `goods_thumb` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `goods_img` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `corporation_id` int(11) NOT NULL DEFAULT '0' COMMENT '企业ID',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '发布会员ID',
  `groupbuy_price` decimal(9,2) DEFAULT '0.00' COMMENT '團購價',
  `groupbuy_start_at` datetime DEFAULT NULL COMMENT '團購開始時間',
  `groupbuy_end_at` datetime DEFAULT NULL COMMENT '團購結束日期',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '地址',
  `hits` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '访问量',
  `is_groupbuy` int(1) DEFAULT NULL COMMENT '是否團購0:不是1:是',
  `app_id` int(11) DEFAULT NULL,
  `fav_count` int(11) NOT NULL DEFAULT '0' COMMENT '收藏数',
  `productnum` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '编号',
  `menber_num` int(11) DEFAULT '0' COMMENT '成團人數',
  `is_freight` int(1) DEFAULT '0' COMMENT '1:设置了运费 0:免运费',
  `activity_num` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '活動編號',
  `default_item` int(11) DEFAULT NULL COMMENT '默认多少件内使用默认的运费',
  `latitude` double DEFAULT NULL COMMENT '纬度',
  `longitude` double DEFAULT NULL COMMENT '经度',
  `add_item` int(11) DEFAULT NULL COMMENT '每增加多少件',
  `default_freight` decimal(9,2) DEFAULT NULL COMMENT '默认运费',
  `add_freight` decimal(9,2) DEFAULT NULL COMMENT '每增加X件使用运费',
  `section_ids` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '频道ID，多个，以逗号分割',
  `is_reveal` tinyint(1) DEFAULT '0' COMMENT '1仅部落显示',
  `unit` varchar(32) DEFAULT NULL COMMENT '单位',
  `m_price1` decimal(12,2) unsigned DEFAULT '0.00' COMMENT '零售价',
  `brand_id1` mediumint(9) DEFAULT NULL COMMENT '品牌ID',
  `short_name1` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '短名称',
  `price1` decimal(9,2) NOT NULL DEFAULT '0.00',
  `weight1` int(9) unsigned NOT NULL DEFAULT '0' COMMENT '重量',
  `tag1` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '标签',
  `is_vip1` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否上架VIP，0表示否，1表示是，默认否',
  `profits1` decimal(9,2) DEFAULT '0.00' COMMENT '利润',
  `commission1` decimal(9,2) DEFAULT '0.00' COMMENT '佣金',
  `in_wechat1` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否微信中显示，0表示否，1表示是，默认否',
  `is_gift1` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为非赠品，1为赠品',
  `main_section1` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '全局前台显示标签',
  `mix_rmb_price1` decimal(9,2) DEFAULT NULL COMMENT '混合现金',
  `url_alias1` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'URL别名',
  `mix_m_price1` decimal(9,2) DEFAULT NULL COMMENT '混合Ｍ币',
  `is_nationwide1` int(10) DEFAULT NULL COMMENT '是否列入全国',
  `attr_set_id` smallint(6) DEFAULT NULL COMMENT '属性组ID（暂时没用）',
  PRIMARY KEY (`id`),
  KEY `corp_id_index` (`corporation_id`),
  KEY `cat_id_index` (`cat_id`),
  KEY `customer_id_index` (`customer_id`),
  KEY `is_on_sale` (`is_on_sale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品表';



# Dump of table 9thleaf_product_advisory
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_product_advisory`;

CREATE TABLE `9thleaf_product_advisory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `created_content` varchar(1024) DEFAULT NULL COMMENT '提问内容',
  `created_by` int(11) DEFAULT NULL COMMENT '提问人',
  `created_at` datetime DEFAULT NULL COMMENT '提问时间',
  `created_approve_status` int(11) DEFAULT '0' COMMENT '提问审核状态:0为未审核，1为通过',
  `created_approve_at` datetime DEFAULT NULL COMMENT '提问审核时间',
  `reply_by` int(11) DEFAULT NULL COMMENT '回复人员ID',
  `reply_at` datetime DEFAULT NULL COMMENT '回复日期',
  `replay_content` varchar(1024) DEFAULT NULL COMMENT '回复内容',
  `replay_approve_status` int(11) DEFAULT '0' COMMENT '回复审核状态,0为未审核，1为已审核,2为审核不通过',
  `replay_approve_at` datetime DEFAULT NULL COMMENT '回复审核日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='咨询审核表';



# Dump of table 9thleaf_product_attr
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_product_attr`;

CREATE TABLE `9thleaf_product_attr` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `attr_set_id` smallint(6) unsigned DEFAULT NULL COMMENT '分组ID',
  `attr_name` varchar(32) COLLATE utf8_bin NOT NULL COMMENT '名称',
  `attr_type` varchar(16) COLLATE utf8_bin DEFAULT NULL COMMENT '类型',
  `option_values` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '可选值',
  `default_value` varchar(96) COLLATE utf8_bin DEFAULT NULL COMMENT '默认值',
  `sequence` int(11) DEFAULT '0',
  `iscondition` int(11) DEFAULT '0' COMMENT '是否搜索条件',
  PRIMARY KEY (`id`),
  KEY `set_id_index` (`attr_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='商品属性表';



# Dump of table 9thleaf_product_attr_set
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_product_attr_set`;

CREATE TABLE `9thleaf_product_attr_set` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '分组名',
  `app_id` int(11) DEFAULT NULL COMMENT '公司ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='商品属性分组表';



# Dump of table 9thleaf_product_attr_value
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_product_attr_value`;

CREATE TABLE `9thleaf_product_attr_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `product_id` int(11) NOT NULL COMMENT '商品ID',
  `attr_id` mediumint(9) NOT NULL COMMENT '属性ID',
  `attr_value` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '属性值',
  PRIMARY KEY (`id`),
  KEY `product_id_index` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='商品-属性值表';



# Dump of table 9thleaf_product_brand1
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_product_brand1`;

CREATE TABLE `9thleaf_product_brand1` (
  `id` mediumint(1) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_bin NOT NULL COMMENT '名称',
  `byname` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `logo_path` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT 'Logo路径',
  `logo` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `desc` text COLLATE utf8_bin COMMENT '描述',
  `sort_order` tinyint(1) NOT NULL DEFAULT '0' COMMENT '排序',
  `website` varchar(32) COLLATE utf8_bin DEFAULT NULL COMMENT '官方网址',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新建日期',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '修改日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='商品品牌表';



# Dump of table 9thleaf_product_cat
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_product_cat`;

CREATE TABLE `9thleaf_product_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '分类名',
  `parent_id` int(11) DEFAULT NULL COMMENT '父ID',
  `level` tinyint(3) NOT NULL DEFAULT '1' COMMENT '层次',
  `path` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '路径',
  `is_root` tinyint(1) NOT NULL DEFAULT '1' COMMENT '根节点?',
  `is_leaf` tinyint(1) NOT NULL DEFAULT '1' COMMENT '叶节点?',
  `sort_order` tinyint(1) NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加日期',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新日期',
  `cate_img` varchar(256) COLLATE utf8_bin DEFAULT NULL COMMENT '分类图片',
  `is_nav` tinyint(1) DEFAULT '0',
  `is_filter` tinyint(1) DEFAULT '0',
  `app_id` int(11) NOT NULL DEFAULT '0',
  `attr_set_id` int(11) NOT NULL DEFAULT '0',
  `brand_path1` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '品牌ID',
  PRIMARY KEY (`id`),
  KEY `cat_search` (`app_id`,`parent_id`,`path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='商品分类表';



# Dump of table 9thleaf_product_image
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_product_image`;

CREATE TABLE `9thleaf_product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `product_id` int(11) NOT NULL COMMENT '商品ID',
  `image_name` varchar(64) COLLATE utf8_bin NOT NULL COMMENT '图片名称',
  `file` varchar(64) COLLATE utf8_bin NOT NULL COMMENT '文件',
  `file_ext` varchar(8) COLLATE utf8_bin NOT NULL COMMENT '文件后缀',
  `file_mime` varchar(32) COLLATE utf8_bin NOT NULL COMMENT '文件MIME类型',
  `width` smallint(6) NOT NULL COMMENT '宽',
  `height` smallint(6) NOT NULL COMMENT '高',
  `file_size` mediumint(9) NOT NULL COMMENT '大小',
  `is_base` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1为主图，0为非主图',
  `sort_order` tinyint(3) DEFAULT '0' COMMENT '排序',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新建日期',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '修改日期',
  `original_name1` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '文件原名',
  `client_name1` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id_index` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='商品图片表';



# Dump of table 9thleaf_product_label
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_product_label`;

CREATE TABLE `9thleaf_product_label` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `product_id` int(11) NOT NULL COMMENT '产品id',
  `label_id` int(11) NOT NULL COMMENT '标签id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品标签表';



# Dump of table 9thleaf_product_rating
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_product_rating`;

CREATE TABLE `9thleaf_product_rating` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '产品ID',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户ID',
  `rating_date` date DEFAULT NULL COMMENT '点赞日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品点赞表';



# Dump of table 9thleaf_product_related
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_product_related`;

CREATE TABLE `9thleaf_product_related` (
  `owner_id` int(11) NOT NULL COMMENT '主商品',
  `target_id` int(11) NOT NULL COMMENT '关联商品'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='商品关联表';



# Dump of table 9thleaf_product_sales_view
# ------------------------------------------------------------

DROP VIEW IF EXISTS `9thleaf_product_sales_view`;

CREATE TABLE `9thleaf_product_sales_view` (
   `id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
   `sales` DECIMAL(30) NULL DEFAULT NULL,
   `tribe_sales` DECIMAL(30) NULL DEFAULT NULL
) ENGINE=MyISAM;



# Dump of table 9thleaf_product_sku
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_product_sku`;

CREATE TABLE `9thleaf_product_sku` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `attr_id` int(11) NOT NULL,
  `sku_id` int(11) NOT NULL COMMENT 'SKU键，',
  `val_id` int(11) NOT NULL COMMENT '关联product_sku_value表',
  `sku_name` varchar(255) NOT NULL COMMENT '例如：颜色',
  PRIMARY KEY (`id`),
  KEY `PRODUCT_ID` (`product_id`),
  KEY `VAL_ID_INDEX` (`val_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;



# Dump of table 9thleaf_product_sku_set
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_product_sku_set`;

CREATE TABLE `9thleaf_product_sku_set` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL COMMENT '所属分类ID',
  `key` varchar(50) NOT NULL DEFAULT '' COMMENT 'SKU健',
  `value` varchar(50) NOT NULL DEFAULT '' COMMENT 'SKU值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='SKU键值对表';



# Dump of table 9thleaf_product_sku_value
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_product_sku_value`;

CREATE TABLE `9thleaf_product_sku_value` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `price1` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '现金价格',
  `m_price` decimal(10,2) DEFAULT '0.00' COMMENT 'M币价',
  `mix_m_price1` decimal(10,2) DEFAULT '0.00' COMMENT '混合M币价',
  `mix_rmb_price1` decimal(10,2) DEFAULT '0.00' COMMENT '混合现金价',
  `plus_no` varchar(10) DEFAULT NULL COMMENT '附加编码',
  `special_offer` decimal(10,2) DEFAULT '0.00' COMMENT '特价',
  `tribe_price` decimal(12,2) DEFAULT '0.00' COMMENT '部落价格',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='SKU详细内容表';



# Dump of table 9thleaf_product_tribe
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_product_tribe`;

CREATE TABLE `9thleaf_product_tribe` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL COMMENT '商品id',
  `tribe_id` varchar(64) DEFAULT NULL COMMENT '部落id',
  `status` tinyint(1) NOT NULL DEFAULT '2' COMMENT '状态1上架2下架',
  `sort` tinyint(4) NOT NULL DEFAULT '1' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部落产品表';



# Dump of table 9thleaf_rebate
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_rebate`;

CREATE TABLE `9thleaf_rebate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rebate1` float DEFAULT '0' COMMENT '上级分成',
  `rebate2` float DEFAULT '0' COMMENT '上上级分成',
  `rebate3` float DEFAULT '0' COMMENT '合伙人分成比例',
  `rebate4` float DEFAULT '0' COMMENT '分站点',
  `rebate5` float DEFAULT '0' COMMENT '易货网',
  `rebate8` float DEFAULT '0' COMMENT '担保人比率',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_user` int(11) DEFAULT NULL,
  `app_id` int(11) DEFAULT NULL COMMENT '分站id',
  `sort` int(11) DEFAULT NULL COMMENT '1会员费分成比率2 易货手续费分成比率',
  `rate1` int(11) DEFAULT NULL COMMENT '手续费比率（已废）',
  PRIMARY KEY (`id`),
  UNIQUE KEY `站点下的分成比例唯一` (`app_id`,`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统提成设置';



# Dump of table 9thleaf_rebate_identity
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_rebate_identity`;

CREATE TABLE `9thleaf_rebate_identity` (
  `identity_id` int(11) unsigned NOT NULL COMMENT '身份ID',
  `identity_name` varchar(64) NOT NULL DEFAULT '' COMMENT '身份名称',
  `intro` text NOT NULL COMMENT '简介',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '等级',
  `rebaterate_description` text COMMENT 'JSON : 比率说明',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '参考价格',
  PRIMARY KEY (`identity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='身份表';



# Dump of table 9thleaf_rebate_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_rebate_role`;

CREATE TABLE `9thleaf_rebate_role` (
  `role_id` int(11) unsigned NOT NULL COMMENT '角色id',
  `name` varchar(50) DEFAULT NULL COMMENT '角色名称',
  `type` tinyint(2) DEFAULT '1' COMMENT '0读取1设置2虚拟',
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分成角色表';



# Dump of table 9thleaf_rebate_template
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_rebate_template`;

CREATE TABLE `9thleaf_rebate_template` (
  `template_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '模板id',
  `name` varchar(50) DEFAULT NULL COMMENT '模板名称',
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL COMMENT '操作者ID',
  `config` text COMMENT '后台显示配置',
  `role_ids` varchar(50) NOT NULL DEFAULT '' COMMENT '存在角色',
  PRIMARY KEY (`template_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分成模板表';



# Dump of table 9thleaf_red_envelope
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_red_envelope`;

CREATE TABLE `9thleaf_red_envelope` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `originator` int(11) NOT NULL COMMENT '红包发起人',
  `type` int(11) DEFAULT '1' COMMENT '类型:平均1,随机2',
  `num` int(11) DEFAULT '1' COMMENT '数量',
  `total` decimal(16,2) DEFAULT '0.00' COMMENT '金额',
  `desc` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '描述',
  `title` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '标题',
  `create_at` datetime NOT NULL COMMENT '新建日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='红包表';



# Dump of table 9thleaf_red_envelope_detail
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_red_envelope_detail`;

CREATE TABLE `9thleaf_red_envelope_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `r_id` int(11) NOT NULL COMMENT '主表ID',
  `customer_id` int(11) DEFAULT NULL COMMENT '接收人',
  `amount` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `recipient1` varchar(30) DEFAULT NULL COMMENT '接收人（废除）',
  `receive_at` datetime DEFAULT NULL COMMENT '接收日期',
  `remark` varchar(256) DEFAULT NULL COMMENT '接收备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='红包接收表';



# Dump of table 9thleaf_refund_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_refund_log`;

CREATE TABLE `9thleaf_refund_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` tinyint(2) NOT NULL DEFAULT '0' COMMENT '支付方式ID',
  `charge_no` varchar(32) NOT NULL DEFAULT '' COMMENT '充值号',
  `order_sn` varchar(32) NOT NULL DEFAULT '' COMMENT '订单号',
  `third_party_no` varchar(255) NOT NULL DEFAULT '' COMMENT '第三方充值订单号',
  `out_refund_no` varchar(32) NOT NULL DEFAULT '' COMMENT '退款单号（自定义）',
  `third_party_refund_no` varchar(255) DEFAULT NULL COMMENT '第三方退款单号',
  `refund_fee` decimal(16,2) DEFAULT NULL COMMENT '退款金额',
  `remark` text COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0处理中1成功2失败',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '生成日期',
  `refund_date` datetime DEFAULT NULL COMMENT '退款日期',
  `txnTime` varchar(14) NOT NULL DEFAULT '' COMMENT '订单发送时间（银联）',
  `app_sign` varchar(64) NOT NULL DEFAULT '' COMMENT '应用标识',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='退款日志表';



# Dump of table 9thleaf_region
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_region`;

CREATE TABLE `9thleaf_region` (
  `region_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `region_name` varchar(120) NOT NULL DEFAULT '',
  `region_type` tinyint(1) NOT NULL DEFAULT '2',
  PRIMARY KEY (`region_id`),
  KEY `parent_id` (`parent_id`) USING BTREE,
  KEY `region_type` (`region_type`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='区域关系表';



# Dump of table 9thleaf_requirement
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_requirement`;

CREATE TABLE `9thleaf_requirement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) NOT NULL COMMENT '类型',
  `p_count` decimal(16,2) DEFAULT '0.00' COMMENT '产品数量',
  `m_price` decimal(16,2) DEFAULT '0.00' COMMENT 'M 价格',
  `vip_price` decimal(16,2) DEFAULT '0.00' COMMENT '零售价',
  `p_content` varchar(1024) DEFAULT NULL COMMENT '产品描述',
  `create_at` datetime DEFAULT NULL COMMENT '发布日期',
  `create_by` int(11) DEFAULT NULL COMMENT '发布人',
  `update_at` datetime DEFAULT NULL COMMENT '更新日期',
  `update_by` int(11) DEFAULT NULL COMMENT '更新人',
  `ispublish` int(11) DEFAULT NULL COMMENT '1待审核2通过3不通过5删除',
  `receiptdate` datetime DEFAULT NULL COMMENT '期望收货日期',
  `effectdate` datetime DEFAULT NULL COMMENT '报价截止日期',
  `contactuser` varchar(32) DEFAULT NULL COMMENT '联系人',
  `contactphone` varchar(32) DEFAULT NULL COMMENT '联系电话',
  `remark` varchar(512) DEFAULT NULL COMMENT '备注',
  `title` varchar(128) DEFAULT NULL COMMENT '需求标题',
  `unit` varchar(32) DEFAULT NULL COMMENT '单位',
  `max_vip_price` decimal(16,2) DEFAULT NULL COMMENT 'M 价格(区间)',
  `min_vip_price` decimal(16,2) DEFAULT '0.00' COMMENT 'M 价格(区间)',
  `img_path` varchar(1024) DEFAULT '' COMMENT '图片路径',
  `province_id` int(11) DEFAULT NULL COMMENT '省',
  `city_id` int(11) DEFAULT NULL COMMENT '市',
  `district_id` int(11) DEFAULT NULL COMMENT '区',
  `shippingaddress` varchar(128) DEFAULT NULL COMMENT '街道',
  `app_id` int(11) DEFAULT NULL,
  `standard1` varchar(100) DEFAULT NULL COMMENT '规格类型',
  `brand_id1` int(11) DEFAULT NULL COMMENT '品牌ID',
  `datadictionary_id1` int(11) DEFAULT NULL COMMENT '行业ID',
  `tax_freight1` tinyint(1) DEFAULT '0' COMMENT '0不含运费和税1含运费2含税3含运费和税',
  `is_putaway` int(11) DEFAULT '0' COMMENT '0未上架1上架',
  `total_price` decimal(16,2) DEFAULT '0.00' COMMENT '需求总价',
  `needtax` tinyint(1) DEFAULT '0' COMMENT '是否需要交税，０:不含税 1:含税',
  `freight` tinyint(1) DEFAULT '0' COMMENT '运费，０:免运费 1:需要运费',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='需求信息';



# Dump of table 9thleaf_requirement_barter
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_requirement_barter`;

CREATE TABLE `9thleaf_requirement_barter` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contactuser` varchar(32) DEFAULT NULL COMMENT '买家电话',
  `customer_id` int(11) DEFAULT NULL COMMENT '买家id',
  `remark` varchar(512) DEFAULT NULL COMMENT '备注',
  `requirement_id` int(11) DEFAULT NULL COMMENT '需求id',
  `create_at` datetime DEFAULT NULL COMMENT '发布日期',
  `state` int(1) DEFAULT '0' COMMENT '处理状态0:未处理，1:已处理',
  `app_id` int(11) DEFAULT '0',
  `days` int(11) DEFAULT NULL COMMENT '交货期(天数)',
  `tax_freight` int(11) DEFAULT '0' COMMENT '0不含运费和税1含运费2含税3含运费和税',
  `accessory_url` varchar(1024) DEFAULT NULL COMMENT '附件路径',
  `offer` decimal(16,2) DEFAULT '0.00' COMMENT '我的报价',
  `freight` tinyint(1) DEFAULT '0' COMMENT '是否需要交税，０:不含税 1:含税',
  `needtax` tinyint(1) DEFAULT '0' COMMENT '运费，０:免运费 1:需要运费',
  `price` decimal(16,2) DEFAULT '0.00' COMMENT '报价单价',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='需求';



# Dump of table 9thleaf_requirement_cate
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_requirement_cate`;

CREATE TABLE `9thleaf_requirement_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(64) NOT NULL COMMENT '类型名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_requirement_label
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_requirement_label`;

CREATE TABLE `9thleaf_requirement_label` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `requirement_id` int(11) NOT NULL COMMENT '需求id',
  `label_id` int(11) NOT NULL COMMENT '标签id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='需求标签表';



# Dump of table 9thleaf_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_role`;

CREATE TABLE `9thleaf_role` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  `action_list` text COLLATE utf8_bin,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `app_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='角色表';



# Dump of table 9thleaf_score_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_score_log`;

CREATE TABLE `9thleaf_score_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '客户ID',
  `event_id` int(11) NOT NULL DEFAULT '0' COMMENT '事件ID',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '获得积分',
  `log_date` datetime DEFAULT NULL COMMENT '得分时间',
  `remark` varchar(100) DEFAULT NULL COMMENT '标记内容',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '使用还是获得，0为使用，1为获得',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分日志表';



# Dump of table 9thleaf_section
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_section`;

CREATE TABLE `9thleaf_section` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `section_name` varchar(50) DEFAULT NULL,
  `pid` int(11) NOT NULL DEFAULT '0',
  `app_id` int(11) NOT NULL DEFAULT '0',
  `sequence` smallint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `section_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '栏目类型：0为产品，1为文章',
  `fpath` varchar(128) DEFAULT NULL COMMENT '父级ID集合',
  `corporation_id` int(11) NOT NULL DEFAULT '0' COMMENT '企业ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='栏目表';



# Dump of table 9thleaf_shipping
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_shipping`;

CREATE TABLE `9thleaf_shipping` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '''''' COMMENT '代表字符',
  `name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '邮递方式名称',
  `desc` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '''''' COMMENT '概述',
  `insure` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '保险费吗？',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '0 未启用 1 启用',
  `url` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '查询地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='物流表';



# Dump of table 9thleaf_shipping_area
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_shipping_area`;

CREATE TABLE `9thleaf_shipping_area` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `shipping_id` tinyint(3) unsigned NOT NULL,
  `configure` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='物流配送区域表';



# Dump of table 9thleaf_shortmsg_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_shortmsg_log`;

CREATE TABLE `9thleaf_shortmsg_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL COMMENT '建立时间',
  `mobile_number` varchar(11) NOT NULL DEFAULT '' COMMENT '发送号码',
  `content` varchar(150) DEFAULT NULL COMMENT '发送内容',
  `msg_type` varchar(32) DEFAULT NULL COMMENT '供应商',
  `status` varchar(32) DEFAULT NULL COMMENT '返回状态',
  `return_msg` varchar(100) DEFAULT NULL COMMENT '返回信息',
  `source` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '来源 1:PC 2:微信 3:安卓 4:ios 5:后台',
  `taskID` varchar(32) DEFAULT NULL COMMENT '序列ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='短信log';



# Dump of table 9thleaf_sign
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_sign`;

CREATE TABLE `9thleaf_sign` (
  `sign_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sign_name` varchar(120) NOT NULL DEFAULT '',
  `cate_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sign_img` varchar(255) DEFAULT '',
  `sign_url` varchar(255) DEFAULT NULL,
  `level` tinyint(3) NOT NULL DEFAULT '1' COMMENT '层次',
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '路径',
  `is_root` tinyint(1) NOT NULL DEFAULT '1' COMMENT '根节点?',
  `is_leaf` tinyint(1) NOT NULL DEFAULT '1' COMMENT '叶节点?',
  PRIMARY KEY (`sign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_sign_cate
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_sign_cate`;

CREATE TABLE `9thleaf_sign_cate` (
  `cate_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(120) NOT NULL DEFAULT '',
  `cate_name_show` varchar(120) NOT NULL DEFAULT '',
  `cate_cateid` int(11) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `parent_cate_id` smallint(5) DEFAULT '0',
  `sort` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_sms_supplier
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_sms_supplier`;

CREATE TABLE `9thleaf_sms_supplier` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(50) NOT NULL DEFAULT '' COMMENT '供应商名称',
  `supplier_class` varchar(50) NOT NULL DEFAULT '' COMMENT '供应商的接口类',
  `supplier_account_name` varchar(50) DEFAULT NULL COMMENT '供应商提供的用户名',
  `supplier_account_passwd` varchar(50) DEFAULT NULL COMMENT '供应商提供的密码',
  `supplier_api_url` varchar(255) DEFAULT NULL COMMENT '供应商提供的接口地址',
  `in_use` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否正在使用，1为正在使用，0未不在使用',
  `type` tinyint(1) DEFAULT '0' COMMENT '类型1行业2营销',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='短信供应商表';



# Dump of table 9thleaf_staff_album
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_staff_album`;

CREATE TABLE `9thleaf_staff_album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tribe_staff_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '部落成员ID',
  `from_customer_id` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '用户表ID',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `update_at` datetime DEFAULT NULL COMMENT '编辑时间',
  `remark` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '备注',
  `tribe_id` int(5) DEFAULT NULL COMMENT '部落ID',
  PRIMARY KEY (`id`),
  KEY `tribe_staff_id` (`tribe_staff_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='预录入族员相册关联表';



# Dump of table 9thleaf_staff_album_img
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_staff_album_img`;

CREATE TABLE `9thleaf_staff_album_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tribe_staff_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '部落族员ID',
  `staff_album_id` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '预录入相册关联ID',
  `path` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '路径',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `staff_album_id` (`staff_album_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='预录入族员相册表';



# Dump of table 9thleaf_system_module
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_system_module`;

CREATE TABLE `9thleaf_system_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上层ID',
  `module_name` varchar(50) NOT NULL DEFAULT '' COMMENT '后台模块名称',
  `directory` varchar(255) NOT NULL DEFAULT '/' COMMENT '实际目录路径',
  `url` varchar(255) NOT NULL DEFAULT '/' COMMENT '访问路径',
  `default_content` int(11) NOT NULL DEFAULT '0' COMMENT '默认内容',
  `logo_url` varchar(255) DEFAULT NULL COMMENT 'LOGO图片连接',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `showflag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示（全局）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台系统模块表';



# Dump of table 9thleaf_system_module2
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_system_module2`;

CREATE TABLE `9thleaf_system_module2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上层ID',
  `module_name` varchar(50) NOT NULL DEFAULT '' COMMENT '后台模块名称',
  `directory` varchar(255) NOT NULL DEFAULT '/' COMMENT '实际目录路径',
  `url` varchar(255) NOT NULL DEFAULT '/' COMMENT '访问路径',
  `default_content` int(11) NOT NULL DEFAULT '0' COMMENT '默认内容',
  `logo_url` varchar(255) DEFAULT NULL COMMENT 'LOGO图片连接',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `showflag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示（全局）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台系统模块表';



# Dump of table 9thleaf_temp_order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_temp_order`;

CREATE TABLE `9thleaf_temp_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `created_at` varchar(32) DEFAULT NULL COMMENT '创建时间',
  `fee` varchar(32) DEFAULT NULL COMMENT '手续费',
  `business_income` varchar(32) DEFAULT NULL COMMENT '卖家收入',
  `total` varchar(32) DEFAULT NULL COMMENT '总额',
  `status` varchar(32) DEFAULT NULL COMMENT '状态1:商家未确认2:商家已确认4:已付款6:已发货9:订单完成(未评价)10:已取消11:已退款14:订单完成(已经评价)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_temporary_order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_temporary_order`;

CREATE TABLE `9thleaf_temporary_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `corporation_id` int(11) NOT NULL COMMENT '商家iD',
  `customer_id` int(11) NOT NULL COMMENT '买家ID',
  `product_id` int(11) NOT NULL COMMENT '商品ID',
  `product_name` varchar(128) DEFAULT NULL COMMENT '商品名称',
  `product_price` decimal(12,2) DEFAULT NULL COMMENT '商品单价',
  `product_num` int(11) DEFAULT NULL COMMENT '商品数量',
  `total_price` int(11) DEFAULT NULL COMMENT '总额',
  `place_at` datetime DEFAULT NULL COMMENT '下单时间',
  `pay_time` datetime DEFAULT NULL COMMENT '付款时间',
  `dispatch_time` datetime DEFAULT NULL COMMENT '发货时间',
  `receipt_time` datetime DEFAULT NULL COMMENT '收货时间',
  `consignee` varchar(32) DEFAULT NULL COMMENT '收货人',
  `address` varchar(255) DEFAULT NULL COMMENT '收货地址',
  `mobile` varchar(32) DEFAULT NULL COMMENT '收货手机',
  `status` tinyint(11) DEFAULT '1' COMMENT '1:未处理 2:已处理到支付 3：处理完成 （程序使用）',
  `order_id` int(11) DEFAULT NULL COMMENT '已经生产订单的表ID（程序使用）',
  `order_sn` varchar(32) DEFAULT NULL COMMENT '订单号（程序使用）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='临时订单生成表';



# Dump of table 9thleaf_theme
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_theme`;

CREATE TABLE `9thleaf_theme` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL COMMENT '专题标题',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态0未使用1使用中',
  `updatetime` varchar(100) DEFAULT NULL COMMENT '更新日期',
  `headcolor` varchar(50) NOT NULL DEFAULT '000' COMMENT '头部色值',
  `footcolor` varchar(50) NOT NULL DEFAULT '000' COMMENT '底部色值',
  `mimg1` varchar(255) NOT NULL DEFAULT '' COMMENT '中间导航第1个图标',
  `murl1` varchar(255) NOT NULL DEFAULT '' COMMENT '中间导航第1个链接',
  `mimg2` varchar(255) NOT NULL DEFAULT '' COMMENT '中间导航第2个图标',
  `murl2` varchar(255) NOT NULL DEFAULT '' COMMENT '中间导航第2个链接',
  `mimg3` varchar(255) NOT NULL DEFAULT '' COMMENT '中间导航第3个图标',
  `murl3` varchar(255) NOT NULL DEFAULT '' COMMENT '中间导航第3个链接',
  `mimg4` varchar(255) NOT NULL DEFAULT '' COMMENT '中间导航第4个图标',
  `murl4` varchar(255) NOT NULL DEFAULT '' COMMENT '中间导航第4个链接',
  `mNavColor` varchar(50) NOT NULL DEFAULT '000' COMMENT '中间导航栏默认色值',
  `bios1` varchar(255) NOT NULL DEFAULT '' COMMENT 'ios底部样式640*98',
  `bios2` varchar(255) NOT NULL DEFAULT '' COMMENT 'ios底部样式750*98',
  `bios3` varchar(255) NOT NULL DEFAULT '' COMMENT 'ios底部样式1242*147',
  `bcios1` varchar(255) NOT NULL DEFAULT '' COMMENT 'ios底部选中样式640*98',
  `bcios2` varchar(255) NOT NULL DEFAULT '' COMMENT 'ios底部选中样式750*98',
  `bcios3` varchar(255) NOT NULL DEFAULT '' COMMENT 'ios底部选中样式1242*147',
  `bandroid1` varchar(255) NOT NULL DEFAULT '' COMMENT '安卓底部样式android，112*720',
  `bcandroid1` varchar(255) NOT NULL DEFAULT '' COMMENT '安卓底部选中样式 112*720',
  `bandroid2` varchar(255) NOT NULL COMMENT '安卓底部样式android168*1080',
  `bcandroid2` varchar(255) NOT NULL COMMENT '安卓底部选中样式168*1080',
  `bNavColor` varchar(50) NOT NULL DEFAULT '000' COMMENT '底部导航栏默认色值',
  `bcNavColor` varchar(50) NOT NULL DEFAULT '000' COMMENT '底部导航栏选中色值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='app专题表';



# Dump of table 9thleaf_third_account
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_third_account`;

CREATE TABLE `9thleaf_third_account` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联公司',
  `third_name` varchar(50) NOT NULL DEFAULT '',
  `appid` varchar(40) DEFAULT NULL COMMENT '第三方应用ID',
  `appsecret` varchar(100) DEFAULT NULL COMMENT '第三方应用密匙串',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='第三方关联管理表';



# Dump of table 9thleaf_tribe
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe`;

CREATE TABLE `9thleaf_tribe` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '部落名称',
  `bg_img` text COMMENT '首页banner图片',
  `shop_img` varchar(255) DEFAULT NULL COMMENT '商城背景图片',
  `content` text NOT NULL COMMENT '简介',
  `content_img` text COMMENT '简介图片(富文本)',
  `content_url1` varchar(150) DEFAULT NULL COMMENT '简介url',
  `logo` varchar(128) DEFAULT NULL COMMENT 'logo',
  `discount1` float(1,1) DEFAULT NULL COMMENT '折扣',
  `provice` varchar(20) DEFAULT NULL COMMENT '所属地区-省份',
  `city` varchar(20) DEFAULT NULL COMMENT '所属地区-城市',
  `liveness` varchar(100) DEFAULT NULL COMMENT '活跃度',
  `customer_id` int(11) DEFAULT NULL COMMENT '第一个义工委-用户id',
  `industry` varchar(256) DEFAULT NULL COMMENT '行业',
  `update_at` datetime DEFAULT NULL COMMENT '更新时间',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '1待审核2通过3不通过',
  `reject_reason` text COMMENT '审核不通过，原因',
  `staff_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '族员是否需要审核0否1是',
  `source` tinyint(1) DEFAULT NULL COMMENT '创建来源 1:PC 2:微信 3:安卓 4:ios 5:后台',
  `show_mobile` tinyint(1) DEFAULT '0' COMMENT '是否预录入用户手机号 0不显示1显示',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部落表';



# Dump of table 9thleaf_tribe_activity
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_activity`;

CREATE TABLE `9thleaf_tribe_activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '活动名称',
  `banner_img` varchar(255) NOT NULL DEFAULT '' COMMENT 'banner',
  `content` text NOT NULL,
  `tribe_id` int(11) DEFAULT NULL COMMENT '部落id,-1全平台，-2全平台不显示，-3默认活动模板',
  `status` tinyint(2) DEFAULT '0' COMMENT '0审核中1通过2不通过3删除',
  `start_time` datetime DEFAULT NULL COMMENT '开始时间',
  `end_time` datetime DEFAULT NULL COMMENT '结束时间',
  `remark` varchar(255) NOT NULL DEFAULT '',
  `update_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `display` tinyint(2) DEFAULT '0' COMMENT '是否受部落ID限制0否1是',
  `type` int(2) NOT NULL DEFAULT '0' COMMENT '活动类型0、默认  1、政策法规 2、行业动态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='部落活动列表';



# Dump of table 9thleaf_tribe_activity_staff
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_activity_staff`;

CREATE TABLE `9thleaf_tribe_activity_staff` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) DEFAULT NULL COMMENT '部落活动id',
  `customer_id` int(11) DEFAULT NULL COMMENT '用户id',
  `apply_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '申请时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='部落活动申请人员';



# Dump of table 9thleaf_tribe_app_label
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_app_label`;

CREATE TABLE `9thleaf_tribe_app_label` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `app_label_id` int(32) DEFAULT NULL COMMENT '标签id',
  `sec_name` varchar(32) NOT NULL DEFAULT '' COMMENT '二级标签名',
  `sort` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `tribe_ids` varchar(255) NOT NULL DEFAULT '' COMMENT '标签下的部落',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `sec_img` varchar(128) NOT NULL DEFAULT '' COMMENT '图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商会二级标签';



# Dump of table 9thleaf_tribe_comment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_comment`;

CREATE TABLE `9thleaf_tribe_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tribe_id` int(11) NOT NULL COMMENT '部落ID',
  `customer_id` int(11) NOT NULL COMMENT '评论者ID',
  `obj_id` int(11) NOT NULL COMMENT '评论对象ID',
  `to_customer_id` int(11) DEFAULT NULL COMMENT '被回复id',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:动态评论 2:活动评论',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '评论内容',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未删除 1:删除',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `obj_id` (`obj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='部落内容评论表';



# Dump of table 9thleaf_tribe_complaints
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_complaints`;

CREATE TABLE `9thleaf_tribe_complaints` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '投诉人ID',
  `tribe_id` int(11) NOT NULL COMMENT '所属部落ID',
  `obj_id` int(11) NOT NULL COMMENT '对象ID',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '投诉内容',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:动态 2:活动',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部落投诉表';



# Dump of table 9thleaf_tribe_content
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_content`;

CREATE TABLE `9thleaf_tribe_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tribe_id` int(11) NOT NULL COMMENT '部落ID -1：全平台-3默认公告模板',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `title_img` varchar(255) NOT NULL DEFAULT '' COMMENT '公告封面图',
  `content` text COMMENT '内容',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `last_updated_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0申请中1已发布2已下架3被删除11',
  `sendee_id` varchar(255) DEFAULT NULL COMMENT '短信接收人id',
  `display` tinyint(2) DEFAULT '0' COMMENT '是否受部落ID限制0否1是',
  PRIMARY KEY (`id`),
  KEY `tribe_id` (`tribe_id`),
  KEY `display` (`display`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='部落公告';



# Dump of table 9thleaf_tribe_manager
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_manager`;

CREATE TABLE `9thleaf_tribe_manager` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '角色',
  `module_id` varchar(64) NOT NULL DEFAULT '' COMMENT '模块id(1,2,3)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `remark` varchar(256) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='部落权限角色表';



# Dump of table 9thleaf_tribe_message
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_message`;

CREATE TABLE `9thleaf_tribe_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_customer_id` int(11) NOT NULL COMMENT '触发人ID',
  `to_customer_id` int(11) NOT NULL COMMENT '接收人ID',
  `tribe_id` int(11) NOT NULL COMMENT '部落ID',
  `obj_id` int(11) NOT NULL COMMENT '对象ID',
  `content_obj_id` int(11) NOT NULL COMMENT '内容的对象ID',
  `content` text COMMENT '消息内容',
  `type` tinyint(1) NOT NULL COMMENT '1:评论 2:点赞 3:系统消息',
  `is_read` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:未读 2:已读',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `merge_customer_id_key` (`to_customer_id`,`form_customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部落中的圈子推送消息';



# Dump of table 9thleaf_tribe_module
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_module`;

CREATE TABLE `9thleaf_tribe_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(64) NOT NULL DEFAULT '' COMMENT '模块名称',
  `url` varchar(255) NOT NULL DEFAULT '/' COMMENT '访问路径',
  `remark` text COMMENT '备注',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部落系统模块表';



# Dump of table 9thleaf_tribe_package
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_package`;

CREATE TABLE `9thleaf_tribe_package` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '货包名称',
  `number` int(5) DEFAULT NULL COMMENT '库存数量',
  `grant_start_at` datetime NOT NULL COMMENT '发放开始时间',
  `grant_end_at` datetime DEFAULT NULL COMMENT '发放结束时间',
  `update_at` datetime DEFAULT NULL COMMENT '修改日期',
  `coupon_at` tinyint(4) NOT NULL DEFAULT '24' COMMENT '有效时间（小时）',
  `desc` text COMMENT '活动说明',
  `image` varchar(64) DEFAULT NULL COMMENT '图片',
  `tribe_id` int(5) DEFAULT NULL COMMENT '加入部落',
  `customer_ids` varchar(64) DEFAULT NULL COMMENT '授权发放用户',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态0冻结1生效',
  `created_at` datetime NOT NULL COMMENT '创建日期',
  `surplus_num` int(5) NOT NULL DEFAULT '0' COMMENT '剩余库存数量',
  `gift_name` varchar(100) NOT NULL DEFAULT '' COMMENT '货包绑定礼物名称',
  `reply` text NOT NULL COMMENT '货包回复模板，用;分隔',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='部落货包';



# Dump of table 9thleaf_tribe_package_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_package_log`;

CREATE TABLE `9thleaf_tribe_package_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `package_share_id` int(11) DEFAULT NULL COMMENT '领取货包分享ID',
  `tribe_package_id` int(11) NOT NULL COMMENT '领取部落货包ID',
  `customer_id` int(11) DEFAULT NULL COMMENT '领取人id',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '联系人',
  `mobile` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '手机',
  `address` varchar(400) DEFAULT NULL COMMENT '地址',
  `place_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '领取部落货包日期',
  `type` tinyint(1) DEFAULT '0' COMMENT '0：未领取  1：已领取(已填写收货信息) 2：已领取(未填写收货信息) 3：已退回',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='部落货包领取';



# Dump of table 9thleaf_tribe_package_share
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_package_share`;

CREATE TABLE `9thleaf_tribe_package_share` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `desc` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `tribe_package_id` int(11) NOT NULL COMMENT '分享部落货包ID',
  `customer_id` int(11) NOT NULL COMMENT '分享人id',
  `quanity` int(5) DEFAULT NULL COMMENT '分享数量',
  `place_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '分享部落货包日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='部落货包分享';



# Dump of table 9thleaf_tribe_read
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_read`;

CREATE TABLE `9thleaf_tribe_read` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '用户id',
  `obj_id` int(11) NOT NULL COMMENT '对象id',
  `tribe_id` int(11) DEFAULT NULL COMMENT '部落id',
  `type` tinyint(1) NOT NULL COMMENT '1公告2活动',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='部落阅读表';



# Dump of table 9thleaf_tribe_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_role`;

CREATE TABLE `9thleaf_tribe_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(32) DEFAULT NULL COMMENT '部落角色',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `tribe_id` int(4) DEFAULT NULL COMMENT '部落id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部落角色表';



# Dump of table 9thleaf_tribe_staff
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_staff`;

CREATE TABLE `9thleaf_tribe_staff` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL COMMENT '用户id',
  `grade` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1个人会员2企业会员',
  `member_name` varchar(32) DEFAULT '' COMMENT '族员名称',
  `tribe_role_id` int(11) DEFAULT NULL COMMENT '部落角色ID',
  `is_host` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是义工委（0否1是）',
  `corporation_name` varchar(128) DEFAULT NULL COMMENT '企业名称',
  `tribe_id` int(11) NOT NULL COMMENT '部落id',
  `duties` varchar(32) DEFAULT NULL COMMENT '职务',
  `provice` varchar(128) DEFAULT NULL COMMENT '所属地区（省）',
  `city` varchar(50) DEFAULT NULL COMMENT '所属地区（城市）',
  `mobile` varchar(16) DEFAULT NULL COMMENT '手机号码',
  `credit` decimal(10,2) DEFAULT '0.00' COMMENT '授信额（可维护列表显示）',
  `remain_guarantee_price` decimal(10,2) DEFAULT NULL COMMENT '剩余担保额（可维护列表显示）',
  `guarantee_ceiling` decimal(12,2) DEFAULT '0.00' COMMENT '单笔可担保额度',
  `guarantee_from_ceiling` decimal(10,2) DEFAULT '0.00' COMMENT '担保上限',
  `hope_offer` int(11) DEFAULT NULL COMMENT '希望贡献度',
  `guarantee_to_ceiling` decimal(10,2) DEFAULT '0.00' COMMENT '被担保上限',
  `excel_url` varchar(150) DEFAULT NULL COMMENT '导入文件路径',
  `liveness` varchar(100) DEFAULT NULL COMMENT '活跃度',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '1待审核2通过3不通过4已删除',
  `send_msg_status` tinyint(1) DEFAULT '0' COMMENT '0未发送邀请信息1已发送邀请信息',
  `logo` varchar(128) DEFAULT NULL COMMENT '成员logo',
  `scope` varchar(128) DEFAULT NULL COMMENT '经营范围',
  `bg_img` varchar(128) DEFAULT NULL COMMENT '成员背景图片',
  `own_goods` varchar(255) NOT NULL DEFAULT '' COMMENT '自有商品描述',
  `industry` varchar(32) NOT NULL DEFAULT '' COMMENT '所属行业',
  `show_mobile` tinyint(1) DEFAULT '2' COMMENT '显示部落成员手机号码是否显示：1显示,2不显示',
  `replacement_intention` varchar(255) NOT NULL DEFAULT '' COMMENT '置换意向',
  `tribe_manager_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色id',
  `delete_at` datetime DEFAULT NULL COMMENT '删除时间',
  `is_pre_record` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是预录入,0:否  1:是',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `tribe_role_id` (`tribe_role_id`),
  KEY `tribe_id` (`tribe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部落用户表';



# Dump of table 9thleaf_tribe_staff_comment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_staff_comment`;

CREATE TABLE `9thleaf_tribe_staff_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tribe_id` int(11) NOT NULL COMMENT '部落ID',
  `from_customer_id` int(11) NOT NULL COMMENT '评论者用户ID',
  `tribe_staff_id` int(11) NOT NULL COMMENT '被评价部落成员ID',
  `to_customer_id` int(11) DEFAULT NULL COMMENT '被评论者用户ID',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '评价内容',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未删除 1:删除',
  PRIMARY KEY (`id`),
  KEY `tribe_id` (`tribe_id`),
  KEY `tribe_staff_id` (`tribe_staff_id`),
  KEY `from_customer_id` (`from_customer_id`),
  KEY `to_customer_id` (`to_customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='部落成员评价表';



# Dump of table 9thleaf_tribe_staff_identity
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_staff_identity`;

CREATE TABLE `9thleaf_tribe_staff_identity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(16) DEFAULT NULL COMMENT '手机号码',
  `type` int(11) DEFAULT NULL COMMENT '类型',
  `organization_name` varchar(64) DEFAULT NULL COMMENT '企业／公司',
  `organizationl_duties` varchar(64) DEFAULT NULL COMMENT '职务',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部落族员预录入社会身份表';



# Dump of table 9thleaf_tribe_staff_sort
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_staff_sort`;

CREATE TABLE `9thleaf_tribe_staff_sort` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL COMMENT '用户id',
  `tribe_id` int(11) NOT NULL COMMENT '部落id',
  `sort` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1:置顶 ',
  `sort_at` datetime DEFAULT NULL COMMENT '置顶时间',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '用户最新浏览时间',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `tribe_id` (`tribe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部落用户置顶排序表';



# Dump of table 9thleaf_tribe_tips
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_tips`;

CREATE TABLE `9thleaf_tribe_tips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tip_num` int(11) DEFAULT NULL COMMENT '弹框弹出次数',
  `mobile` varchar(20) COLLATE utf8_bin DEFAULT NULL COMMENT '手机号码',
  `status` tinyint(1) DEFAULT '1' COMMENT '是否弹窗，1是，0否',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='部落消息设置表';



# Dump of table 9thleaf_tribe_topic
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_topic`;

CREATE TABLE `9thleaf_tribe_topic` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tribe_id` int(11) NOT NULL COMMENT '部落id',
  `customer_id` int(11) NOT NULL COMMENT '作者id',
  `images` text NOT NULL COMMENT '多图片用;号分割',
  `content` text NOT NULL COMMENT '内容',
  `upvote_num` int(11) NOT NULL DEFAULT '0' COMMENT '可维护点赞数量',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:不显示   1:正常 ',
  `sort` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1:置顶 ',
  `remark` varchar(128) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `tribe_id` (`tribe_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部落中的圈子话题';



# Dump of table 9thleaf_tribe_upvote
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_tribe_upvote`;

CREATE TABLE `9thleaf_tribe_upvote` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '点赞用户',
  `obj_id` int(11) NOT NULL COMMENT '点赞对象',
  `type` tinyint(11) NOT NULL DEFAULT '1' COMMENT '1:动态 2:活动',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `obj_id` (`obj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部落内容点赞表';



# Dump of table 9thleaf_vote
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_vote`;

CREATE TABLE `9thleaf_vote` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '投票标题',
  `banner` varchar(255) DEFAULT NULL,
  `option_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '选项类型0单选1多选',
  `multi_nums` int(11) NOT NULL DEFAULT '0' COMMENT '多选数量上限0代表不限制',
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `start_time` datetime NOT NULL COMMENT '开始时间',
  `end_time` datetime NOT NULL COMMENT '结束时间',
  `tribe_id` int(11) DEFAULT NULL COMMENT '发布到的部落',
  `authority` tinyint(1) NOT NULL DEFAULT '0' COMMENT '投票权限0仅对部落1公开',
  `result` tinyint(1) NOT NULL DEFAULT '1' COMMENT '投票结果0投票后可见1任何人可见',
  `vote_platform` tinyint(1) NOT NULL DEFAULT '3' COMMENT '投票平台0app和H5,1app,2H5',
  `vote_time` tinyint(4) NOT NULL DEFAULT '0' COMMENT '投票间隔0只能投一次1每天可投',
  `rule` text NOT NULL COMMENT '规则（3000字以内）',
  `abstract` text NOT NULL COMMENT '简介（3000字以内）',
  `vote_type` tinyint(11) NOT NULL DEFAULT '0' COMMENT '投票类型0文字1图片',
  `visits` int(11) DEFAULT '0' COMMENT '访问次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='投票表';



# Dump of table 9thleaf_vote_option
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_vote_option`;

CREATE TABLE `9thleaf_vote_option` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `vote_id` int(11) DEFAULT NULL COMMENT '投票ID',
  `option_title` varchar(32) NOT NULL DEFAULT '' COMMENT '项目名称',
  `option_img` varchar(255) NOT NULL DEFAULT '' COMMENT '项目图片',
  `introduce` text COMMENT '项目介绍',
  `visits` int(11) DEFAULT '0' COMMENT '项目访问次数',
  `index` tinyint(1) NOT NULL COMMENT '下标值,排序',
  PRIMARY KEY (`id`),
  KEY `vote_id` (`vote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='投票选项表';



# Dump of table 9thleaf_vote_staff
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_vote_staff`;

CREATE TABLE `9thleaf_vote_staff` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `vote_id` int(11) DEFAULT NULL COMMENT '投票ID',
  `option_id` int(11) DEFAULT NULL COMMENT '选项ID',
  `customer_id` int(11) DEFAULT NULL COMMENT '投票用户',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '投票时间',
  `wechat_head` varchar(255) NOT NULL DEFAULT '' COMMENT '微信头像路径',
  `wechat_nick_name` varchar(32) NOT NULL DEFAULT '' COMMENT '微信昵称',
  `unionId` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `vote_id` (`vote_id`),
  KEY `option_id` (`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='投票成员表';



# Dump of table 9thleaf_wechat_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_wechat_config`;

CREATE TABLE `9thleaf_wechat_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `app_sign` varchar(64) NOT NULL DEFAULT '0' COMMENT 'app标识，商会标签用商会编号',
  `APPID` varchar(50) NOT NULL DEFAULT '',
  `MCHID` varchar(50) NOT NULL DEFAULT '',
  `KEY` varchar(128) NOT NULL DEFAULT '',
  `APPSECRET` varchar(128) NOT NULL DEFAULT '',
  `JS_API_CALL_URL` varchar(255) NOT NULL DEFAULT '',
  `SSLCERT_PATH` varchar(255) NOT NULL DEFAULT '' COMMENT '证书pem路径',
  `SSLKEY_PATH` varchar(255) NOT NULL DEFAULT '' COMMENT '证书密钥pem路径',
  `NOTIFY_URL` varchar(255) NOT NULL DEFAULT '',
  `remark` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `app_sign` (`app_sign`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信配置表';



# Dump of table 9thleaf_wechat_cs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_wechat_cs`;

CREATE TABLE `9thleaf_wechat_cs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL COMMENT '客户ID',
  `create_time` datetime DEFAULT NULL COMMENT '发生时间',
  `content` text COMMENT '发送内容',
  `is_reply` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已回复',
  `app_id` int(11) NOT NULL DEFAULT '0' COMMENT '公司ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信客服表';



# Dump of table 9thleaf_wechat_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_wechat_menu`;

CREATE TABLE `9thleaf_wechat_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(20) DEFAULT NULL,
  `pid` int(11) DEFAULT '0',
  `menutype` enum('click','view','scancode_push','scancode_waitmsg','pic_sysphoto','pic_photo_or_album','pic_weixin','location_select') DEFAULT 'view' COMMENT '消息类型',
  `url` varchar(200) DEFAULT NULL COMMENT '链接地址',
  `clickkey` varchar(20) DEFAULT NULL COMMENT '事件KEY',
  `menuorder` int(11) DEFAULT NULL COMMENT '排序',
  `submenu` tinyint(2) DEFAULT '0' COMMENT '是否第二层MENU',
  `app_id` int(11) DEFAULT NULL COMMENT '应用ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信菜单表';



# Dump of table 9thleaf_wechat_pay_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_wechat_pay_log`;

CREATE TABLE `9thleaf_wechat_pay_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `appid` varchar(50) DEFAULT NULL,
  `bank_type` varchar(20) DEFAULT NULL,
  `cash_fee` varchar(30) DEFAULT NULL,
  `fee_type` varchar(10) DEFAULT NULL,
  `is_subscribe` varchar(10) DEFAULT NULL,
  `mch_id` varchar(30) DEFAULT NULL,
  `nonce_str` varchar(50) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL,
  `out_trade_no` varchar(50) DEFAULT NULL,
  `result_code` varchar(25) DEFAULT NULL,
  `return_code` varchar(25) DEFAULT NULL,
  `sign` varchar(50) DEFAULT NULL,
  `time_end` varchar(50) DEFAULT NULL,
  `total_fee` int(11) DEFAULT NULL,
  `trade_type` varchar(30) DEFAULT NULL,
  `transaction_id` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table 9thleaf_wechat_reply
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_wechat_reply`;

CREATE TABLE `9thleaf_wechat_reply` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL COMMENT '客户ID',
  `cs_id` int(11) DEFAULT NULL COMMENT '对应回复内容',
  `reply_time` datetime DEFAULT NULL COMMENT '回复时间',
  `content` text COMMENT '回复内容',
  `msgtype` varchar(10) DEFAULT NULL COMMENT '消息类型',
  `media_id` varchar(32) DEFAULT NULL COMMENT '多媒体ID',
  `thumb_media_id` varchar(32) DEFAULT NULL COMMENT '视频缩略图ID',
  `title` varchar(255) DEFAULT NULL COMMENT '视频标题',
  `description` text COMMENT '视频描述',
  `musicurl` varchar(255) DEFAULT NULL COMMENT '音频路径',
  `hqmusicurl` varchar(255) DEFAULT NULL COMMENT '高清音频路径',
  `url` varchar(255) DEFAULT NULL COMMENT '点击后跳转的链接',
  `picurl` varchar(255) DEFAULT NULL COMMENT '图文消息的图片链接，支持JPG、PNG格式，较好的效果为大图640*320，小图80*80',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信回复表';



# Dump of table 9thleaf_wechat_tigergame
# ------------------------------------------------------------

DROP TABLE IF EXISTS `9thleaf_wechat_tigergame`;

CREATE TABLE `9thleaf_wechat_tigergame` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `playdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gamenum` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `playtimes` tinyint(4) DEFAULT NULL,
  `isplay` tinyint(4) DEFAULT '0',
  `nickname` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `player` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='老虎机管理表';



# Dump of table databases
# ------------------------------------------------------------

DROP TABLE IF EXISTS `databases`;

CREATE TABLE `databases` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table sss1
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sss1`;

CREATE TABLE `sss1` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;





# Replace placeholder table for 9thleaf_product_sales_view with correct view syntax
# ------------------------------------------------------------

DROP TABLE `9thleaf_product_sales_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`51ehwuser`@`%` SQL SECURITY DEFINER VIEW `9thleaf_product_sales_view` AS (select `a`.`id` AS `id`,coalesce(sum(`b`.`quantity`),0) AS `sales`,sum(if((`b`.`source` = 1),`b`.`quantity`,0)) AS `tribe_sales` from (`9thleaf_51ehw`.`9thleaf_product` `a` left join (select `a`.`id` AS `id`,`a`.`order_id` AS `order_id`,`a`.`product_id` AS `product_id`,`a`.`product_name` AS `product_name`,`a`.`quantity` AS `quantity`,`a`.`price` AS `price`,`a`.`weight` AS `weight`,`a`.`sku_id` AS `sku_id`,`a`.`sku_value` AS `sku_value`,`a`.`goods_thumb` AS `goods_thumb`,`a`.`source` AS `source` from (`9thleaf_51ehw`.`9thleaf_order_item` `a` join `9thleaf_51ehw`.`9thleaf_order` `b` on(((`a`.`order_id` = `b`.`id`) and (`b`.`status` in (9,14)))))) `b` on((`a`.`id` = `b`.`product_id`))) group by `a`.`id`);

--
-- Dumping routines (PROCEDURE) for database '9thleaf_51ehw'
--
DELIMITER ;;

# Dump of PROCEDURE currency_logreset
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `currency_logreset` */;;
/*!50003 SET SESSION SQL_MODE="ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`51ehwuser`@`%`*/ /*!50003 PROCEDURE `currency_logreset`(relationid int,begindate datetime)
BEGIN
	declare f_id int default 1;
	declare cnt int default 0;
	declare endingbalance decimal(16,2);
	select count(*) into cnt from 9thleaf_customer_currency_log where id > f_id and relation_id = relationid and created_at >= begindate;
	select cnt;
	REPEAT
		select id , ending_balance into f_id, endingbalance from 9thleaf_customer_currency_log where id > f_id and relation_id = relationid and created_at >= begindate order by id limit 1;
		set cnt = cnt-1;
		select f_id,endingbalance;
		update 9thleaf_customer_currency_log set beginning_balance = endingbalance,ending_balance = endingbalance+IF(type = 1,`amount`, concat('-',amount)),`state` = 1 where id > f_id  and relation_id = relationid  order by id limit 1;
	UNTIL cnt=0
	END REPEAT;
    END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE money_logreset
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `money_logreset` */;;
/*!50003 SET SESSION SQL_MODE="ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`51ehwuser`@`%`*/ /*!50003 PROCEDURE `money_logreset`(relationid int,begindate datetime)
BEGIN
	declare f_id int default 1;
	declare cnt int default 0;
	declare endingbalance decimal(16,2);
	select count(*) into cnt from 9thleaf_customer_money_log where id > f_id and relation_id = relationid and created_at >= begindate;
	select cut;
	REPEAT
		select id , ending_balance into f_id, endingbalance from 9thleaf_customer_money_log where id > f_id and relation_id = relationid and created_at >= begindate order by id limit 1;
		set cnt = cnt-1;
		select f_id,endingbalance;
		update 9thleaf_customer_money_log set beginning_balance = endingbalance,ending_balance = endingbalance+IF(type = 1,cash, concat('-',cash)),state=1 where id > f_id  and relation_id = relationid  order by id limit 1;
	UNTIL cnt=0
	END REPEAT;
    END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE pro_logreset
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `pro_logreset` */;;
/*!50003 SET SESSION SQL_MODE=""*/;;
DELIMITER ;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
