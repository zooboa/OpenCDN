-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 02 月 02 日 08:11
-- 服务器版本: 5.1.44
-- PHP 版本: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `cdn_info`
--

-- --------------------------------------------------------

--
-- 表的结构 `domain`
--

CREATE TABLE IF NOT EXISTS `domain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain_id` varchar(50) NOT NULL,
  `record_id` varchar(50) NOT NULL,
  `domain_name` varchar(100) NOT NULL,
  `sub_domain` varchar(100) NOT NULL,
  `parent_id` varchar(50) NOT NULL,
  `domain_ip` varchar(50) NOT NULL,
  `node_ip` varchar(50) DEFAULT NULL,
  `record_line` varchar(100) DEFAULT NULL,
  `status` int(1) NOT NULL,
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category` enum('O','D') NOT NULL DEFAULT 'O' COMMENT 'O=openCDN, D=DnsPod',
  `speed` int(5) DEFAULT NULL,
  `remove_url` int(5) DEFAULT NULL,
  `CNAME` varchar(50) DEFAULT NULL,
  `user_mail` varchar(10) DEFAULT NULL,
  `d_status` int(1) NOT NULL DEFAULT '0',
  `monitor_id` varchar(50) NOT NULL,
  `bak_ip` varchar(50) NOT NULL,
  `monitor_interval` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=221 ;

--
-- 转存表中的数据 `domain`
--


-- --------------------------------------------------------

--
-- 表的结构 `domain_conf_loc`
--

CREATE TABLE IF NOT EXISTS `domain_conf_loc` (
  `locf_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `domain_name` varchar(200) NOT NULL,
  `path` varchar(200) NOT NULL,
  `enable` enum('Y','N') NOT NULL DEFAULT 'Y',
  `memo` varchar(300) NOT NULL,
  `tips` varchar(200) DEFAULT NULL,
  `user_mail` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`locf_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=734 ;

--
-- 转存表中的数据 `domain_conf_loc`
--


-- --------------------------------------------------------

--
-- 表的结构 `domain_conf_loc_conf`
--

CREATE TABLE IF NOT EXISTS `domain_conf_loc_conf` (
  `conf_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `conf_loc_id` int(11) NOT NULL,
  `loc_key` varchar(300) NOT NULL,
  `loc_value` text NOT NULL,
  `memo` varchar(300) NOT NULL,
  `enable` enum('Y','N') NOT NULL DEFAULT 'Y',
  `sort` int(11) NOT NULL,
  `user_mail` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`conf_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3181 ;

--
-- 转存表中的数据 `domain_conf_loc_conf`
--


-- --------------------------------------------------------

--
-- 表的结构 `loc_type`
--

CREATE TABLE IF NOT EXISTS `loc_type` (
  `loctype_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) NOT NULL,
  `mome` varchar(100) DEFAULT NULL,
  `enable` enum('Y','N') NOT NULL DEFAULT 'Y',
  `exts` varchar(300) DEFAULT NULL,
  `exts_tips` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`loctype_id`),
  UNIQUE KEY `NewIndex1` (`type_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `loc_type`
--

INSERT INTO `loc_type` (`loctype_id`, `type_name`, `mome`, `enable`, `exts`, `exts_tips`) VALUES
(1, 'cache_one', '缓存开关', 'Y', NULL, NULL),
(2, 'directory', '匹配方式（目录）', 'Y', NULL, NULL),
(3, 'extension', '匹配方式（文件类型）', 'Y', NULL, NULL),
(4, 'cache_all', '全站缓存', 'Y', '/', '/'),
(5, 'dynamic_script', '排除动态脚本', 'Y', '~ .*\\.(php|jsp|cgi|asp|aspx|flv|swf|xml|do|rar|zip|rmvb|mp3|doc|docx|xls|pdf|gz|tgz|rm|exe)?$', 'php|jsp|cgi|asp|aspx|flv|swf|xml|do|rar|zip|rmvb|mp3|doc|docx|xls|pdf|gz|tgz|rm|exe'),
(6, 'ext_jscss', '文件类型（JS/CSS）', 'Y', '~ .*\\.(js|css)$', 'js|css'),
(7, 'ext_frequently', '常用扩展缓存', 'Y', '~ .*\\.(gif|jpg|jpeg|png|bmp|swf|js|css)?$', 'gif|jpg|jpeg|png|bmp|swf|js|css'),
(8, 'dir_=/', '首页/目录缓存', 'Y', '= /', '= /'),
(9, 'ext_htm', 'htm缓存', 'Y', '~ .*\\.(htm|html|shtml|shtm)?$', 'htm|html|shtml|shtm');

-- --------------------------------------------------------

--
-- 表的结构 `loc_type_item`
--

CREATE TABLE IF NOT EXISTS `loc_type_item` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `item_key` varchar(300) NOT NULL,
  `item_value` text NOT NULL,
  `item_memo` varchar(300) DEFAULT NULL,
  `item_enable` enum('Y','N') NOT NULL DEFAULT 'Y',
  `item_sort` int(11) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=48 ;

--
-- 转存表中的数据 `loc_type_item`
--

INSERT INTO `loc_type_item` (`item_id`, `type_id`, `item_key`, `item_value`, `item_memo`, `item_enable`, `item_sort`) VALUES
(1, 1, 'proxy_cache', 'cache_one;', NULL, 'Y', -4),
(2, 1, 'proxy_cache_valid', '200 304 1d;', NULL, 'Y', -3),
(3, 1, 'proxy_cache_key', '$host$uri$is_args$args;', NULL, 'Y', -2),
(4, 1, 'expires', '2d;', NULL, 'Y', -1),
(5, 2, 'proxy_pass', 'http://127.0.0.1;', NULL, 'Y', 1),
(6, 2, 'proxy_redirect', 'off;', NULL, 'Y', 2),
(7, 2, 'proxy_set_header', 'Host $host;', NULL, 'Y', 3),
(8, 2, 'proxy_set_header', 'X-Real-IP $remote_addr;', NULL, 'Y', 4),
(9, 2, 'proxy_set_header', 'X-Forwarded-For $proxy_add_x_forwarded_for;', NULL, 'Y', 5),
(10, 3, 'proxy_pass', 'http://12.0.0.1; ', NULL, 'Y', 1),
(11, 3, 'proxy_redirect', 'off;', NULL, 'Y', 2),
(12, 3, 'proxy_set_header', 'Host $host;', NULL, 'Y', 3),
(13, 3, 'proxy_set_header', 'X-Real-IP $remote_addr;', NULL, 'Y', 4),
(14, 3, 'proxy_set_header', 'X-Forwarded-For $proxy_add_x_forwarded_for;', NULL, 'Y', 5),
(15, 3, 'if (!-f $request_filename)', '{\r\n		proxy_pass	http://127.0.0.1;\r\n		break;\r\n	}', NULL, 'Y', 6),
(16, 4, 'proxy_pass', 'http://12.0.0.1; ', NULL, 'Y', 1),
(17, 4, 'proxy_redirect', 'off;', NULL, 'Y', 2),
(18, 4, 'proxy_set_header', 'Host $host;', NULL, 'Y', 3),
(19, 4, 'proxy_set_header', 'X-Real-IP $remote_addr;', NULL, 'Y', 4),
(20, 4, 'proxy_set_header', 'X-Forwarded-For $proxy_add_x_forwarded_for;', NULL, 'Y', 5),
(21, 4, 'access_log', 'logs/access.pipe access;', NULL, 'Y', 6),
(22, 4, 'if ($http_Cache_Control ~ "no-cache")', '{  \r\n			rewrite ^(.*)$ /purge$1 last;\r\n		}', NULL, 'Y', 7),
(23, 5, 'proxy_pass', 'http://12.0.0.1; ', NULL, 'Y', 1),
(24, 5, 'proxy_redirect', 'off;', NULL, 'Y', 2),
(25, 5, 'proxy_set_header', 'Host $host;', NULL, 'Y', 3),
(26, 5, 'proxy_set_header', 'X-Real-IP $remote_addr;', NULL, 'Y', 4),
(27, 5, 'proxy_set_header', 'X-Forwarded-For $proxy_add_x_forwarded_for;', NULL, 'Y', 5),
(28, 6, 'proxy_set_header', 'Host $host;', NULL, 'Y', 1),
(29, 6, 'if (!-f $request_filename)', '{\r\n		proxy_pass	http://127.0.0.1;\r\n		break;\r\n	}', NULL, 'Y', 2),
(30, 7, 'proxy_pass', 'http://12.0.0.1; ', NULL, 'Y', 1),
(31, 7, 'proxy_redirect', 'off;', NULL, 'Y', 2),
(32, 7, 'proxy_set_header', 'Host $host;', NULL, 'Y', 3),
(33, 7, 'proxy_set_header', 'X-Real-IP $remote_addr;', NULL, 'Y', 4),
(34, 7, 'proxy_set_header', 'X-Forwarded-For $proxy_add_x_forwarded_for;', NULL, 'Y', 5),
(35, 8, 'proxy_pass', 'http://12.0.0.1; ', NULL, 'Y', 1),
(36, 7, 'if (!-f $request_filename)', '{\r\n		proxy_pass	http://127.0.0.1;\r\n		break;\r\n	}', NULL, 'Y', 6),
(37, 8, 'proxy_redirect', 'off;', NULL, 'Y', 2),
(38, 8, 'proxy_set_header', 'Host $host;', NULL, 'Y', 3),
(39, 8, 'proxy_set_header', 'X-Real-IP $remote_addr;', NULL, 'Y', 4),
(40, 8, 'proxy_set_header', 'X-Forwarded-For $proxy_add_x_forwarded_for;', NULL, 'Y', 5),
(41, 8, 'proxy_ignore_headers', '"Cache-Control" "Expires";', NULL, 'Y', 6),
(42, 9, 'proxy_pass', 'http://12.0.0.1; ', NULL, 'Y', 1),
(43, 9, 'proxy_redirect', 'off;', NULL, 'Y', 2),
(44, 9, 'proxy_set_header', 'Host $host;', NULL, 'Y', 3),
(45, 9, 'proxy_set_header', 'X-Real-IP $remote_addr;', NULL, 'Y', 4),
(46, 9, 'proxy_set_header', 'X-Forwarded-For $proxy_add_x_forwarded_for;', NULL, 'Y', 5),
(47, 9, 'if (!-f $request_filename)', '{\r\n		proxy_pass	http://127.0.0.1;\r\n		break;\r\n	}', NULL, 'Y', 6);

-- --------------------------------------------------------

--
-- 表的结构 `node_info`
--

CREATE TABLE IF NOT EXISTS `node_info` (
  `NodeIP` varchar(20) DEFAULT NULL,
  `Status` varchar(10) DEFAULT NULL,
  `IP0` varchar(20) DEFAULT NULL,
  `Netmask0` varchar(20) DEFAULT NULL,
  `IP1` varchar(20) DEFAULT NULL,
  `Netmask1` varchar(20) DEFAULT NULL,
  `System_release` varchar(100) DEFAULT NULL,
  `Kernel_release` varchar(100) DEFAULT NULL,
  `Frequency` varchar(100) DEFAULT NULL,
  `CPU_cores` varchar(100) DEFAULT NULL,
  `Mem_total` varchar(10) DEFAULT NULL,
  `Swap_total` varchar(10) DEFAULT NULL,
  `Disk_total` varchar(10) DEFAULT NULL,
  `cpu` varchar(20) DEFAULT NULL,
  `cpu_free` varchar(20) DEFAULT NULL,
  `eth0` varchar(10) DEFAULT NULL,
  `send_rate0` varchar(20) DEFAULT NULL,
  `recv_rate0` varchar(20) DEFAULT NULL,
  `send_all_rate0` varchar(20) DEFAULT NULL,
  `recv_all_rate0` varchar(20) DEFAULT NULL,
  `eth1` varchar(10) DEFAULT NULL,
  `send_rate1` varchar(20) DEFAULT NULL,
  `recv_rate1` varchar(20) DEFAULT NULL,
  `send_all_rate1` varchar(20) DEFAULT NULL,
  `recv_all_rate1` varchar(20) DEFAULT NULL,
  `Mem_used` varchar(10) DEFAULT NULL,
  `Mem_free` varchar(10) DEFAULT NULL,
  `Mem_per` varchar(10) DEFAULT NULL,
  `Swap_used` varchar(10) DEFAULT NULL,
  `Swap_free` varchar(10) DEFAULT NULL,
  `Swap_per` varchar(10) DEFAULT NULL,
  `Disk_used` varchar(10) DEFAULT NULL,
  `Disk_free` varchar(10) DEFAULT NULL,
  `Disk_per` varchar(10) DEFAULT NULL,
  `cache` varchar(10) DEFAULT NULL,
  UNIQUE KEY `NodeIP_2` (`NodeIP`),
  UNIQUE KEY `NewIndex1` (`NodeIP`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `node_info`
--

INSERT INTO `node_info` (`NodeIP`, `Status`, `IP0`, `Netmask0`, `IP1`, `Netmask1`, `System_release`, `Kernel_release`, `Frequency`, `CPU_cores`, `Mem_total`, `Swap_total`, `Disk_total`, `cpu`, `cpu_free`, `eth0`, `send_rate0`, `recv_rate0`, `send_all_rate0`, `recv_all_rate0`, `eth1`, `send_rate1`, `recv_rate1`, `send_all_rate1`, `recv_all_rate1`, `Mem_used`, `Mem_free`, `Mem_per`, `Swap_used`, `Swap_free`, `Swap_per`, `Disk_used`, `Disk_free`, `Disk_per`, `cache`) VALUES
('199.101.96.70', 'on', '127.0.0.1', '255.255.255.255', '199.101.96.70', '255.255.255.255', 'CentOS release 5.8 (Final)', 'Linux 2.6.32-042stab061.2', 'Intel(R) Xeon(R) CPU           X3470  @ 2.93GHz', '4', '128M', '128M', '20GM', '4%', '96%', 'yes', '1.66 K/s', '749.00 B/s', '821.45 B/s', '723.32 B/s', 'yes', ' B/s', ' B/s', ' B/s', ' B/s', '89M', '38M', '69%', '5M', '122M', '3%', '711MM', '20GM', '4%', '4.0K');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_mail` varchar(300) NOT NULL,
  `user_keycode` varchar(300) NOT NULL,
  `user_role` enum('M','O') NOT NULL DEFAULT 'M',
  `dnspod_user` varchar(100) DEFAULT NULL,
  `dnspod_pass` varchar(200) DEFAULT NULL,
  `tell` int(5) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`user_id`, `user_mail`, `user_keycode`, `user_role`, `dnspod_user`, `dnspod_pass`, `tell`) VALUES
(1, 'admin', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 'M', 'echocom@zoho.com', 'zooboa.com', 1);
