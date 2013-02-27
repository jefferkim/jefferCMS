-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 02 月 25 日 16:37
-- 服务器版本: 5.1.46
-- PHP 版本: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `zjl`
--

-- --------------------------------------------------------

--
-- 表的结构 `t_admin`
--

CREATE TABLE IF NOT EXISTS `t_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) NOT NULL DEFAULT '',
  `PassWord` varchar(50) NOT NULL DEFAULT '',
  `IsLock` tinyint(4) NOT NULL DEFAULT '0',
  `UserCalled` varchar(255) NOT NULL DEFAULT '',
  `UserRole` text NOT NULL,
  `UserRoleCalled` varchar(50) NOT NULL DEFAULT '',
  `UserId` int(11) NOT NULL DEFAULT '0',
  `Space` int(10) unsigned NOT NULL DEFAULT '0',
  `DataBase` int(10) unsigned NOT NULL DEFAULT '0',
  `ServiceStart` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ServiceEnd` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `IsPointing` varchar(125) NOT NULL DEFAULT '',
  `Industry` int(10) unsigned NOT NULL DEFAULT '0',
  `Key` tinytext NOT NULL,
  `IsCase` tinyint(4) NOT NULL DEFAULT '0',
  `Amount` varchar(20) NOT NULL DEFAULT '',
  `UserType` tinyint(4) NOT NULL DEFAULT '0',
  `DbName` varchar(20) NOT NULL DEFAULT '',
  `RedirectUrl` varchar(50) NOT NULL DEFAULT '',
  `Status` tinyint(4) NOT NULL DEFAULT '1',
  `SiteType` int(11) NOT NULL DEFAULT '0',
  `DesignContact` tinytext NOT NULL,
  `area` varchar(100) NOT NULL,
  `coder` varchar(100) NOT NULL,
  `designer` varchar(100) NOT NULL,
  `infoer` varchar(100) NOT NULL,
  `PointDate` datetime NOT NULL,
  `SalesMan` varchar(60) NOT NULL,
  `LoginTime` datetime NOT NULL,
  `ServerName` varchar(20) NOT NULL,
  `ServerTel` varchar(20) NOT NULL,
  `ServerQQ` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `UserName` (`UserName`,`IsLock`,`UserCalled`),
  FULLTEXT KEY `UserName_2` (`UserName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5948 ;

--
-- 转存表中的数据 `t_admin`
--

INSERT INTO `t_admin` (`id`, `UserName`, `PassWord`, `IsLock`, `UserCalled`, `UserRole`, `UserRoleCalled`, `UserId`, `Space`, `DataBase`, `ServiceStart`, `ServiceEnd`, `IsPointing`, `Industry`, `Key`, `IsCase`, `Amount`, `UserType`, `DbName`, `RedirectUrl`, `Status`, `SiteType`, `DesignContact`, `area`, `coder`, `designer`, `infoer`, `PointDate`, `SalesMan`, `LoginTime`, `ServerName`, `ServerTel`, `ServerQQ`) VALUES
(5869, 'beiji', '123456', 0, '测试', 'D0:D1:D2:D3:D4:F0:F1:F2:F3:F4:F5:F6:F7:F8:F9:F10:F11:F12:E0:E1:E2:E3:E4:E5:E6:E7:E8:E9:E10:E11:G0:G1:G2:G3:G4:G13:G5:G6:G7:G8:G11:K0:K1:K2:K3:K4:K13:K5:K11:H0:H1:H2:H3:H4:H13:H5:H6:H7:H8:H11:J0:J1:J2:J3:J4:J11:L0:L1:L2:I0:I1:I2:I3:I4:O1:O2:S0:S1:T0:T1:T2:T3:T4:T5:T6:T7:B0:B1:B2:B3:B4:B5:B6:B7:A0:A1:A2:A3:M0:P0', 'beiji', 4806, 100, 100, '2012-03-22 00:00:00', '2012-03-22 00:00:00', '', 0, '', 0, '0', 2, 'beiji', 'cn/index.php', 4, 1, '', '无', '钟洁梁', '', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `t_career`
--

CREATE TABLE IF NOT EXISTS `t_career` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Content` longtext NOT NULL,
  `NoteTime` datetime NOT NULL,
  `Language` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Language` (`Language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_career`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_config`
--

CREATE TABLE IF NOT EXISTS `t_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `code` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- 转存表中的数据 `t_config`
--

INSERT INTO `t_config` (`id`, `name`, `code`, `value`) VALUES
(1, '产品分类排序方式', 'producttypeorder', 'true'),
(2, '推荐产品显示个数', 'productcommendlines', '15'),
(3, '推荐产品排序方式', 'productcommendorder', 'true'),
(4, '推荐产品打开方式', 'productcommendopentype', 'new'),
(5, '弹出窗口方式顶值', 'productcommendpoptop', '0'),
(6, '弹出窗口方式左值', 'productcommendpopleft', '0'),
(7, '弹出窗口方式窗口宽度', 'productcommendpopwidth', '800'),
(8, '弹出窗口方式窗口高度', 'productcommendpopheight', '600'),
(9, '是否显示小图片', 'productcommendshowpic', 'true'),
(10, '是否显示产品名称', 'productcommendshowname', 'true'),
(11, '是否显示产品简介', 'productcommendshowmemo', 'false'),
(12, '是否显示产品内容', 'productcommendshowcontent', 'false'),
(13, '每页显示产品行数', 'productlines', '3'),
(14, '每页显示产品列数', 'productcols', '3'),
(15, '产品排序方式', 'productorder', 'true'),
(16, '产品打开方式', 'productopentype', 'new'),
(17, '弹出窗口顶值', 'productpoptop', '0'),
(18, '弹出窗口左值', 'productpopleft', '0'),
(19, '弹出窗口宽度', 'productpopwidth', '800'),
(20, '弹出窗口高度', 'productpopheight', '600'),
(21, '是否显示小图片', 'productshowpic', 'true'),
(22, '是否显示产品名称', 'productshowname', 'true'),
(23, '是否显示产品简介', 'productshowmemo', 'false'),
(24, '是否显示产品内容', 'productshowcontent', 'false'),
(25, '推荐新闻显示个数', 'newscommendlines', '5'),
(26, '推荐新闻排序方式', 'newscommendorder', 'true'),
(27, '推荐新闻打开方式', 'newscommendopentype', 'new'),
(28, '弹出窗口顶值', 'newscommendpoptop', '0'),
(29, '弹出窗口左值', 'newscommendpopleft', '0'),
(30, '弹出窗口宽度', 'newscommendpopwidth', '800'),
(31, '弹出窗口高度', 'newscommendpopheight', '600'),
(32, '每页显示新闻条数', 'newslines', '10'),
(33, '新闻排序方式', 'newsorder', '10'),
(34, '新闻打开方式', 'newsopentype', 'new'),
(35, '弹出窗口顶值', 'newspoptop', '0'),
(36, '弹出窗口左值', 'newspopleft', '0'),
(37, '弹出窗口宽度', 'newspopwidth', '800'),
(38, '弹出窗口高度', 'newspopheight', '600'),
(39, '每页显示图片行数', 'picturelines', '3'),
(40, '每页显示图片列数', 'picturecols', '3'),
(41, '图片排序方式', 'pictureorder', 'true'),
(42, '图片打开方式', 'pictureopentype', 'new'),
(43, '弹出窗口顶值', 'picturepoptop', '0'),
(44, '弹出窗口左值', 'picturepopleft', '0'),
(45, '弹出窗口宽度', 'picturepopwidth', '800'),
(46, '弹出窗口高度', 'picturepopheight', '600'),
(47, '每页显示招聘条数', 'joblines', '5'),
(48, '招聘排序方式', 'joborder', 'true'),
(49, '每页显示下载条数', 'downlines', '10'),
(50, '下载排序方式', 'downorder', 'true'),
(51, '每页显示留言条数', 'guestlines', '10');

-- --------------------------------------------------------

--
-- 表的结构 `t_content`
--

CREATE TABLE IF NOT EXISTS `t_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Called` varchar(120) NOT NULL DEFAULT '',
  `NoteTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Content` longtext NOT NULL,
  `Language` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `Called` (`Called`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_content`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_custom`
--

CREATE TABLE IF NOT EXISTS `t_custom` (
  `id` int(10) unsigned DEFAULT NULL,
  `custom1` varchar(50) NOT NULL,
  `Custom2` varchar(50) CHARACTER SET ucs2 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_custom`
--

INSERT INTO `t_custom` (`id`, `custom1`, `Custom2`) VALUES
(1, '自定义功能一', '自定义功能二');

-- --------------------------------------------------------

--
-- 表的结构 `t_custom1`
--

CREATE TABLE IF NOT EXISTS `t_custom1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Called` varchar(120) NOT NULL DEFAULT '',
  `NoteTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Content` longtext NOT NULL,
  `Language` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `Called` (`Called`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_custom1`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_custom2`
--

CREATE TABLE IF NOT EXISTS `t_custom2` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Called` varchar(120) NOT NULL DEFAULT '',
  `NoteTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Content` longtext NOT NULL,
  `Language` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `Called` (`Called`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_custom2`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_dict`
--

CREATE TABLE IF NOT EXISTS `t_dict` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Called` varchar(255) NOT NULL DEFAULT '',
  `Code` varchar(20) NOT NULL DEFAULT '',
  `OrderBy` int(10) unsigned NOT NULL DEFAULT '0',
  `IsShow` tinyint(4) NOT NULL DEFAULT '0',
  `Type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `Type` (`Type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

--
-- 转存表中的数据 `t_dict`
--

INSERT INTO `t_dict` (`id`, `Called`, `Code`, `OrderBy`, `IsShow`, `Type`) VALUES
(1, '中文', 'cn', 2, 1, 1),
(2, '英文', 'en', 3, 1, 1),
(3, '日文', 'jp', 4, 1, 1),
(4, '韩文', 'kr', 5, 1, 1),
(5, '法文', 'fr', 6, 1, 1),
(6, '德语', 'ge', 7, 1, 1),
(7, '繁体', 'tw', 8, 1, 1),
(8, '全部', 'all', 9, 1, 2),
(9, '是', 'true', 10, 1, 2),
(10, '否', 'false', 11, 1, 2),
(11, '5000', '1', 12, 1, 3),
(12, '3000', '2', 13, 1, 3),
(13, '2000', '3', 14, 1, 3),
(14, '入门型', '4', 15, 1, 3),
(16, '普通', '2', 17, 1, 4),
(17, '中等', '3', 18, 1, 4),
(18, '首席', '4', 19, 1, 4),
(20, '礼品', '2', 21, 1, 5),
(21, '日用品类', '3', 22, 1, 5),
(22, '美发类', '4', 23, 1, 5),
(23, '娱乐用品', '5', 24, 1, 5),
(24, '电子电器类', '6', 25, 1, 5),
(25, '风机系列', '7', 26, 1, 5),
(26, '物流类', '8', 27, 1, 5),
(27, '食品类', '9', 28, 1, 5),
(28, '汽车类', '10', 29, 1, 5),
(29, '美容化妆类', '11', 30, 1, 5),
(30, '服务类', '12', 31, 1, 5),
(31, '家居装饰类', '13', 32, 1, 5),
(32, '文体类', '14', 33, 1, 5),
(33, '机械制造类', '15', 34, 1, 5),
(34, '医药化学类', '16', 35, 1, 5),
(35, '纺织服饰类', '17', 36, 1, 5),
(36, '外贸类', '18', 37, 1, 5),
(37, '综合类', '19', 38, 1, 5),
(38, '儿童用品类', '20', 39, 1, 5),
(39, '定制', '5', 40, 1, 3),
(40, '入门型定制', '7', 41, 1, 3),
(41, '俄文', 'ru', 42, 1, 1),
(43, '阿拉伯语', 'ar', 43, 1, 1),
(44, '克罗地亚语', 'hr', 44, 1, 1),
(45, '丹麦语', 'da', 45, 1, 1),
(46, '芬兰语', 'fi', 46, 1, 1),
(47, '希伯来语', 'he', 47, 0, 1),
(48, '匈牙利语', 'hu', 48, 0, 1),
(49, '印度尼西亚语', 'in', 49, 0, 1),
(50, '朝鲜语', 'ko', 50, 1, 1),
(51, '拉丁语系', 'rm', 51, 0, 1),
(52, '斯洛伐克语', 'sk', 52, 0, 1),
(53, '瑞典语', 'sv', 53, 1, 1),
(54, '泰语', 'th', 54, 0, 1),
(55, '乌克兰语', 'uk', 55, 0, 1),
(56, '保加利亚语', 'bg', 56, 0, 1),
(57, '捷克语', 'cs', 57, 0, 1),
(58, '荷兰语', 'nl', 58, 1, 1),
(59, '波斯语', 'fa', 59, 0, 1),
(60, '希腊语', 'el', 60, 0, 1),
(61, '意大利语', 'it', 61, 1, 1),
(62, '立陶宛语', 'lt', 62, 0, 1),
(63, '马来西亚语', 'ms', 63, 1, 1),
(64, '波兰语', 'pl', 64, 1, 1),
(65, '葡萄牙语', 'pt', 65, 1, 1),
(66, '西班牙语', 'es', 66, 1, 1),
(67, '香港', 'hk', 67, 1, 1),
(68, '印地语', 'hi', 68, 1, 1),
(69, '土耳其语', 'tu', 69, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `t_download`
--

CREATE TABLE IF NOT EXISTS `t_download` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Called` varchar(120) NOT NULL,
  `NoteTime` datetime NOT NULL,
  `FileURL` varchar(120) NOT NULL,
  `Memo` text NOT NULL,
  `IsShow` tinyint(4) NOT NULL,
  `IsCommend` tinyint(4) NOT NULL,
  `OrderBy` int(11) NOT NULL,
  `TypeID` int(11) NOT NULL,
  `FileSize` int(11) NOT NULL,
  `Language` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `TypeID` (`TypeID`,`OrderBy`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_download`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_downloadtype`
--

CREATE TABLE IF NOT EXISTS `t_downloadtype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Called` varchar(120) NOT NULL,
  `NoteTime` datetime NOT NULL,
  `Memo` text NOT NULL,
  `Language` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Called` (`Called`,`Language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_downloadtype`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_feedback`
--

CREATE TABLE IF NOT EXISTS `t_feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL DEFAULT '',
  `Content` text NOT NULL,
  `NoteTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `IP` varchar(20) NOT NULL DEFAULT '',
  `Language` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `Language` (`Language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_feedback`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_fields`
--

CREATE TABLE IF NOT EXISTS `t_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Called` varchar(255) NOT NULL DEFAULT '',
  `FieldName` varchar(100) NOT NULL DEFAULT '',
  `DataType` varchar(20) NOT NULL DEFAULT '',
  `UiType` varchar(20) NOT NULL DEFAULT '',
  `DefaultValue` tinytext NOT NULL,
  `TypeName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `TypeName` (`TypeName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_fields`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_flow`
--

CREATE TABLE IF NOT EXISTS `t_flow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NoteTime` datetime NOT NULL,
  `IP` varchar(20) NOT NULL,
  `ViewPage` varchar(255) NOT NULL,
  `RefPage` varchar(255) NOT NULL,
  `OS` varchar(20) NOT NULL,
  `Browser` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `t_flow`
--

INSERT INTO `t_flow` (`id`, `NoteTime`, `IP`, `ViewPage`, `RefPage`, `OS`, `Browser`) VALUES
(1, '2012-09-19 00:00:00', '61.153.145.202', '/zjl/cn/index.php', 'http://testweb4.iecworld.com/admin/customer.php', 'Windows XP', 'Netscape Navigator 5'),
(2, '2012-09-19 00:00:00', '113.142.9.34', '/zjl/cn/index.php', '直接输入网址访问', 'Windows 2000', 'Internet Explorer 61'),
(3, '2012-09-19 00:00:00', '180.153.206.35', '/zjl/cn/index.php', '直接输入网址访问', 'Unknown', 'Netscape Navigator 4'),
(4, '2012-10-14 00:00:00', '115.215.226.33', '/zjl/cn/index.php', '直接输入网址访问', 'Windows NT', 'Netscape Navigator 5'),
(5, '2012-10-14 00:00:00', '111.161.54.50', '/zjl/cn/index.php', '直接输入网址访问', 'Windows 2000', 'Internet Explorer 61'),
(6, '2012-10-14 00:00:00', '111.161.54.52', '/zjl/cn/produce.php', '直接输入网址访问', 'Windows 2000', 'Internet Explorer 61'),
(7, '2012-10-14 00:00:00', '180.153.163.227', '/zjl/cn/quality.php', '直接输入网址访问', 'Windows 2000', 'Internet Explorer 61'),
(8, '2012-10-14 00:00:00', '113.142.24.93', '/zjl/cn/about.php', '直接输入网址访问', 'Windows 2000', 'Internet Explorer 61'),
(9, '2012-10-14 00:00:00', '113.142.24.69', '/zjl/cn/index.php', '直接输入网址访问', 'Windows 2000', 'Internet Explorer 61'),
(10, '2012-10-14 00:00:00', '180.153.0.15', '/zjl/cn/about.php', '直接输入网址访问', 'Windows 2000', 'Internet Explorer 61'),
(11, '2012-10-14 00:00:00', '180.153.163.228', '/zjl/cn/contact.php', '直接输入网址访问', 'Windows 2000', 'Internet Explorer 61'),
(12, '2012-10-14 00:00:00', '180.153.214.182', '/zjl/cn/index.php', '直接输入网址访问', 'Unknown', 'Netscape Navigator 4'),
(13, '2012-10-14 00:00:00', '112.65.193.15', '/zjl/cn/index.php', '直接输入网址访问', 'Unknown', 'Netscape Navigator 4'),
(14, '2012-10-14 00:00:00', '101.226.51.228', '/zjl/cn/index.php', '直接输入网址访问', 'Unknown', 'Netscape Navigator 4'),
(15, '2012-10-14 00:00:00', '180.153.163.189', '/zjl/cn/produce.php', '直接输入网址访问', 'Unknown', 'Netscape Navigator 4'),
(16, '2012-10-14 00:00:00', '180.153.214.199', '/zjl/cn/quality.php', '直接输入网址访问', 'Unknown', 'Netscape Navigator 4'),
(17, '2012-10-14 00:00:00', '101.226.66.181', '/zjl/cn/contact.php', '直接输入网址访问', 'Unknown', 'Netscape Navigator 4'),
(18, '2012-10-14 00:00:00', '180.153.163.209', '/zjl/cn/about.php', '直接输入网址访问', 'Unknown', 'Netscape Navigator 4'),
(19, '2012-10-30 00:00:00', '61.153.145.202', '/zjl/cn/index.php', '直接输入网址访问', 'Windows XP', 'Netscape Navigator 5');

-- --------------------------------------------------------

--
-- 表的结构 `t_global`
--

CREATE TABLE IF NOT EXISTS `t_global` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Webname` varchar(500) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Keywords` varchar(500) NOT NULL,
  `Description` varchar(500) NOT NULL,
  `Beian` varchar(100) NOT NULL,
  `Upload` varchar(50) NOT NULL,
  `Web` varchar(50) NOT NULL,
  `Language` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_global`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_guestbook`
--

CREATE TABLE IF NOT EXISTS `t_guestbook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Subject` varchar(255) NOT NULL,
  `UserName` varchar(60) NOT NULL,
  `Mail` varchar(120) NOT NULL,
  `Company` varchar(255) NOT NULL,
  `Web` varchar(120) NOT NULL,
  `Content` text NOT NULL,
  `IsShow` tinyint(4) NOT NULL,
  `NoteTime` datetime NOT NULL,
  `IP` varchar(20) NOT NULL,
  `Reply` text NOT NULL,
  `Language` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IsShow` (`IsShow`,`Language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_guestbook`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_img`
--

CREATE TABLE IF NOT EXISTS `t_img` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ProName` varchar(120) NOT NULL,
  `PicUrl` varchar(120) NOT NULL,
  `BigUrl` varchar(120) NOT NULL,
  `NoteTime` datetime NOT NULL,
  `IsShow` tinyint(4) NOT NULL,
  `IsCommend` tinyint(4) NOT NULL,
  `OrderBy` int(11) NOT NULL,
  `ProID` int(11) NOT NULL,
  `Language` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ProID` (`ProID`,`OrderBy`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_img`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_job`
--

CREATE TABLE IF NOT EXISTS `t_job` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Position` varchar(100) NOT NULL,
  `Specialty` varchar(100) NOT NULL,
  `Sex` varchar(10) NOT NULL,
  `Num` varchar(20) NOT NULL,
  `Age` varchar(20) NOT NULL,
  `Educational` varchar(100) NOT NULL,
  `Experience` varchar(100) NOT NULL,
  `Salary` varchar(100) NOT NULL,
  `Memo` text NOT NULL,
  `NoteTime` datetime NOT NULL,
  `EndTime` date NOT NULL,
  `IsShow` tinyint(4) NOT NULL,
  `IsCommend` tinyint(4) NOT NULL,
  `OrderBy` int(11) NOT NULL,
  `Language` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `OrderBy` (`OrderBy`,`Language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_job`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_language`
--

CREATE TABLE IF NOT EXISTS `t_language` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Called` varchar(255) NOT NULL DEFAULT '',
  `ModelId` int(10) unsigned NOT NULL DEFAULT '0',
  `SelModel` int(10) unsigned NOT NULL DEFAULT '0',
  `UserId` int(10) unsigned NOT NULL DEFAULT '0',
  `Html` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `Called` (`Called`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4721 ;

--
-- 转存表中的数据 `t_language`
--

INSERT INTO `t_language` (`id`, `Called`, `ModelId`, `SelModel`, `UserId`, `Html`) VALUES
(4693, 'cn', 0, 2586, 5869, 0),
(4694, 'en', 0, 2586, 5869, 0);

-- --------------------------------------------------------

--
-- 表的结构 `t_log`
--

CREATE TABLE IF NOT EXISTS `t_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `IP` varchar(20) NOT NULL DEFAULT '',
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_log`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_news`
--

CREATE TABLE IF NOT EXISTS `t_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) NOT NULL DEFAULT '',
  `NoteTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Content` longtext NOT NULL,
  `UserName` varchar(100) NOT NULL DEFAULT '',
  `IsShow` tinyint(4) NOT NULL DEFAULT '0',
  `IsCommend` tinyint(4) NOT NULL DEFAULT '0',
  `OrderBy` int(11) NOT NULL DEFAULT '0',
  `NewType` int(10) unsigned NOT NULL DEFAULT '0',
  `Hits` int(10) unsigned NOT NULL DEFAULT '0',
  `Language` varchar(10) NOT NULL DEFAULT '',
  `Parent` int(11) NOT NULL DEFAULT '0',
  `SmallPic` varchar(100) NOT NULL DEFAULT '',
  `WebTitle` varchar(255) NOT NULL,
  `WebKey` varchar(255) NOT NULL,
  `WebDesc` varchar(255) NOT NULL,
  `ShowTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `NewType` (`NewType`,`Title`,`OrderBy`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_news`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_newtype`
--

CREATE TABLE IF NOT EXISTS `t_newtype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Called` varchar(100) NOT NULL DEFAULT '',
  `Language` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `Called` (`Called`,`Language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_newtype`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_order`
--

CREATE TABLE IF NOT EXISTS `t_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Company` varchar(255) NOT NULL DEFAULT '',
  `Name` varchar(60) NOT NULL DEFAULT '',
  `Tel` varchar(40) NOT NULL DEFAULT '',
  `Mobile` varchar(40) NOT NULL DEFAULT '',
  `Mail` varchar(120) NOT NULL DEFAULT '',
  `Address` varchar(255) NOT NULL DEFAULT '',
  `Memo` text NOT NULL,
  `IP` varchar(20) NOT NULL DEFAULT '',
  `NoteTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Language` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `Language` (`Language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_order`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_orderdetail`
--

CREATE TABLE IF NOT EXISTS `t_orderdetail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `OrderID` int(10) unsigned NOT NULL DEFAULT '0',
  `ProductID` int(10) unsigned NOT NULL DEFAULT '0',
  `ProductName` varchar(120) NOT NULL DEFAULT '',
  `Nums` int(11) NOT NULL DEFAULT '0',
  `Price` float NOT NULL DEFAULT '0',
  `Memo` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `OrderID` (`OrderID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_orderdetail`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_pic`
--

CREATE TABLE IF NOT EXISTS `t_pic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PicName` varchar(120) NOT NULL,
  `PicUrl` varchar(120) NOT NULL,
  `BigUrl` varchar(120) NOT NULL,
  `NoteTime` datetime NOT NULL,
  `IsShow` tinyint(4) NOT NULL,
  `IsCommend` tinyint(4) NOT NULL,
  `OrderBy` int(11) NOT NULL,
  `TypeID` int(11) NOT NULL,
  `Language` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `TypeID` (`TypeID`,`OrderBy`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_pic`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_pictype`
--

CREATE TABLE IF NOT EXISTS `t_pictype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Called` varchar(80) NOT NULL DEFAULT '',
  `NoteTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Memo` text NOT NULL,
  `Language` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `Called` (`Called`,`Language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_pictype`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_plugin`
--

CREATE TABLE IF NOT EXISTS `t_plugin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Called` varchar(40) NOT NULL DEFAULT '',
  `Point` varchar(255) NOT NULL DEFAULT '',
  `Type` tinyint(4) NOT NULL DEFAULT '0',
  `Description` tinytext NOT NULL,
  `PowerDescription` text NOT NULL,
  `Power` text NOT NULL,
  `DbScript` text NOT NULL,
  `ZipURL` varchar(40) NOT NULL DEFAULT '',
  `OrderBy` int(11) NOT NULL DEFAULT '0',
  `IsShow` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `t_plugin`
--

INSERT INTO `t_plugin` (`id`, `Called`, `Point`, `Type`, `Description`, `PowerDescription`, `Power`, `DbScript`, `ZipURL`, `OrderBy`, `IsShow`) VALUES
(1, '产品管理', 'products/products.php', 0, '产品分类,产品管理', '产品查看|产品添加|产品修改|产品删除|显示设置|推荐设置|产品分类查看|产品分类添加|产品分类修改|产品分类删除|产品分类显示设置|产品自定义字段查看|分类自定义字段', 'F0|F1|F2|F3|F4|F5|F6|F7|F8|F9|F10|F11|F12', '', '', 1, 1),
(2, '网站内容管理', 'html/main.php', 0, '网站单块html内容管理', '内容查看|内容添加|内容修改|内容删除|内容自定义字段', 'D0|D1|D2|D3|D4', '', '', 0, 1),
(3, '新闻管理', 'news/main.php', 0, '新闻分类及新闻管理', '分类查看|分类添加|分类修改|分类删除|新闻查看|新闻添加|新闻修改|新闻删除|新闻排序|显示设置|推荐设置|自定义字段', 'E0|E1|E2|E3|E4|E5|E6|E7|E8|E9|E10|E11', '', '', 2, 1),
(4, '网站留言管理', 'guest/main.php', 0, '客户网站前台留言管理员', '留言查看|留言回复|留言删除|留言显示设置|自定义字段', 'I0|I1|I2|I3|I4', '', '', 8, 1),
(5, '会员管理', 'member/member.php', 0, '网站会员管理模块', '会员查看|会员添加|会员修改|会员删除|会员锁定设置|会员自定义字段管理', 'J0|J1|J2|J3|J4|J11', '', '', 6, 1),
(6, '人才招聘', 'job/job.php', 0, '网站人才招聘模块', '招聘查看|招聘添加|招聘修改|招聘删除|显示设置|推荐设置|简历查看|自定义字段', 'K0|K1|K2|K3|K4|K13|K5|K11', '', '', 4, 1),
(7, '订单管理', 'order/order.php', 0, '网站订单管理', '订单查看|订单删除|自定义字段', 'L0|L1|L2', '', '', 7, 1),
(8, '流量统计表', 'stat/stat.php', 0, '网站流量统计表', '流量查看', 'M0', '', '', 10, 0),
(9, '图片管理', 'picture/picture.php', 0, '网站荣誉证书，厂房设备等图片的管理', '图片查看|图片添加|图片修改|图片删除|显示设置|推荐设置|分类查看|分类添加|分类修改|分类删除|图片自定义字段管理', 'G0|G1|G2|G3|G4|G13|G5|G6|G7|G8|G11', '', '', 3, 1),
(10, '下载管理', 'download/download.php', 0, '网站下载内容管理', '下载查看|下载添加|下载修改|下载删除|显示设置|推荐设置|分类查看|分类添加|分类修改|分类删除|自定义字段管理', 'H0|H1|H2|H3|H4|H13|H5|H6|H7|H8|H11', '', '', 5, 1),
(11, '产品管理', 'ppgproducts/products.php', 0, '服装展示类型产品管理', '产品查看|产品添加|产品修改|产品删除|显示设置|推荐设置|产品分类查看|产品分类添加|产品分类修改|产品分类删除|产品分类显示设置', 'N0|N1|N2|N3|N4|N5|N6|N7|N8|N9|N10|N11', '', '', 11, 0),
(12, '客户反馈', 'feedback/feed.php', 0, '查看网站客户反馈', '查看反馈信息|删除反馈信息', 'O1|O2', '', '', 9, 1),
(14, '行业分类', 'comtype/type.php', 1, '行业网站分类', '查看分类|添加分类|修改分类|删除分类|自定义字段', 'CT1|CT2|CT3|CT4|CT5', '', '', 12, 0),
(15, '行业会员管理', 'comuser/member.php', 1, '行业会员管理', '会员管理|删除会员|锁定会员|解锁会员|推荐会员|优秀会员|自定义字段管理', 'CU1|CU2|CU3|CU4|CU5|CU6|CU7', '', '', 13, 0),
(16, '行业供应信息管理', 'comsupply/supply.php', 1, '行业网站供应信息管理', '供应信息管理|删除信息|推荐信息|自定义字段管理', 'CS1|CS2|CS3|CS4', '', '', 14, 0),
(17, '行业求购信息管理', 'combuy/buy.php', 1, '行业网站求购信息管理', '信息管理|删除信息|自定义字段管理', 'CB1|CB2|CB3', '', '', 15, 0),
(18, '四明琴行考级查询', 'kg/member.php', 1, '四明琴行考级查询', '考级管理', 'SMJ0', '', '', 16, 0),
(19, '网页设置', 'configpage.php', 0, '修改网页名称，网页标题，关键字', '修改', 'CFG', '', '', 17, 0),
(20, 'SEO信息管理', 'file_manage/index.php', 0, 'SEO关键字设置,SEO数据统计分析', 'SEO关键字管理|访问量数据分析', 'S0|S1', '', '', 10, 1),
(21, '投票信息管理', 'vote/result.php', 0, '投票问题,投票答案', '投票答案查看|投票答案添加|投票答案修改|投票答案删除|投票问题查看|投票问题添加|投票问题修改|投票问题删除', 'T0|T1|T2|T3|T4|T5|T6|T7', '', '', 11, 1),
(22, '系统公告管理', 'admin_news/index.php', 0, '系统公告查看', '系统公告查看', 'M0', '', '', 15, 1),
(23, '系统自定义功能', 'custom1/main.php', 0, '系统自定义功能添加', '自定义功能一查看|自定义功能一添加|自定义功能一修改|自定义功能一删除|自定义功能二查看|自定义功能二添加|自定义功能二修改|自定义功能二删除', 'B0|B1|B2|B3|B4|B5|B6|B7', '', '', 13, 1),
(24, '系统管理员管理', 'sys_user/sys_user.php', 0, '系统管理员列表,系统管理员添加', '系统管理员查看|系统管理员添加|系统管理员修改|系统管理员删除', 'A0|A1|A2|A3', '', '', 14, 1),
(25, '数据统计', 'stat1/stat.php', 0, '新闻,产品,等统计信息', '数据统计', 'P0', '', '', 16, 1);

-- --------------------------------------------------------

--
-- 表的结构 `t_products`
--

CREATE TABLE IF NOT EXISTS `t_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ProName` varchar(200) NOT NULL DEFAULT '',
  `Content` longtext NOT NULL,
  `Memo` text NOT NULL,
  `NoteTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `SmallPic` varchar(100) NOT NULL DEFAULT '',
  `IsShow` tinyint(4) NOT NULL DEFAULT '0',
  `IsCommend` tinyint(4) NOT NULL DEFAULT '0',
  `OrderBy` int(11) NOT NULL DEFAULT '0',
  `TypeID` int(11) NOT NULL DEFAULT '0',
  `Hits` int(11) NOT NULL DEFAULT '0',
  `Language` varchar(10) NOT NULL DEFAULT '',
  `WebTitle` varchar(255) NOT NULL,
  `WebKey` varchar(255) NOT NULL,
  `WebDesc` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ProName` (`ProName`,`TypeID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_products`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_protype`
--

CREATE TABLE IF NOT EXISTS `t_protype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Called` varchar(100) NOT NULL DEFAULT '',
  `PicUrl` varchar(100) NOT NULL DEFAULT '',
  `OrderBy` int(11) NOT NULL DEFAULT '0',
  `IsShow` tinyint(4) NOT NULL DEFAULT '0',
  `Memo` text NOT NULL,
  `PID` int(11) NOT NULL DEFAULT '0',
  `TypeLevel` tinyint(4) NOT NULL DEFAULT '0',
  `Language` varchar(10) NOT NULL DEFAULT '',
  `ParentPath` varchar(255) NOT NULL DEFAULT '',
  `NoteTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `PID` (`PID`,`Called`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_protype`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_result`
--

CREATE TABLE IF NOT EXISTS `t_result` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Result` varchar(255) NOT NULL COMMENT '投票答案标题',
  `NoteTime` datetime NOT NULL COMMENT '插入时间',
  `VoteTime` datetime NOT NULL COMMENT '投票时间',
  `VoteId` int(10) NOT NULL COMMENT '投票问题ID',
  `Language` varchar(10) NOT NULL COMMENT '语言',
  `num` int(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_result`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_seo`
--

CREATE TABLE IF NOT EXISTS `t_seo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) NOT NULL,
  `Keywords` varchar(1000) NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `Url` varchar(255) NOT NULL,
  `Language` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_seo`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_user`
--

CREATE TABLE IF NOT EXISTS `t_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserName` varchar(40) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `NoteTime` datetime NOT NULL,
  `IsLock` tinyint(4) NOT NULL,
  `Called` varchar(60) NOT NULL,
  `Company` varchar(255) NOT NULL,
  `Tel` varchar(40) NOT NULL,
  `Mobile` varchar(40) NOT NULL,
  `Mail` varchar(120) NOT NULL,
  `Language` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `UserName` (`UserName`,`Password`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_user`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_viewnum`
--

CREATE TABLE IF NOT EXISTS `t_viewnum` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nums` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_viewnum`
--


-- --------------------------------------------------------

--
-- 表的结构 `t_vote`
--

CREATE TABLE IF NOT EXISTS `t_vote` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `Subject` varchar(255) NOT NULL COMMENT '标题',
  `NoteTime` datetime NOT NULL COMMENT '添加日期',
  `Language` varchar(10) NOT NULL COMMENT '语言',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_vote`
--

