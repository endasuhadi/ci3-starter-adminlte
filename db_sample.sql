-- --------------------------------------------------------
-- Host:                         localhost
-- Versi server:                 5.6.21 - MySQL Community Server (GPL)
-- OS Server:                    Win32
-- HeidiSQL Versi:               10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- membuang struktur untuk table db_promote.tbl_user_group
DROP TABLE IF EXISTS `tbl_user_group`;
CREATE TABLE IF NOT EXISTS `tbl_user_group` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `id_group` int(11) DEFAULT NULL,
  `nama_user` varchar(225) DEFAULT NULL,
  `username` varchar(225) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `create_by` varchar(225) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_promote.tbl_user_group: ~1 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_user_group` DISABLE KEYS */;
INSERT INTO `tbl_user_group` (`id_user`, `id_group`, `nama_user`, `username`, `email`, `password`, `create_by`, `create_date`) VALUES
	(7, 23, 'dasd1', 'sad', 'admin@admin.com', '*94BA5C5C8C92EAA6BAA449491DD346D301F07578', NULL, '2020-06-29 16:03:03'),
	(10, 23, 'sadasfa', 'sadascas3w', 'admin@admin.com', '*6BB4837EB74329105EE4568DDA7DC67ED2CA2AD9', NULL, '2020-06-29 16:03:42');
/*!40000 ALTER TABLE `tbl_user_group` ENABLE KEYS */;

-- membuang struktur untuk table db_promote.tbl_user_roles
DROP TABLE IF EXISTS `tbl_user_roles`;
CREATE TABLE IF NOT EXISTS `tbl_user_roles` (
  `id_roles` int(11) NOT NULL AUTO_INCREMENT,
  `nama_roles` varchar(225) NOT NULL DEFAULT '0',
  `roles` text NOT NULL,
  `create_date` datetime DEFAULT NULL,
  `create_by` varchar(225) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_roles`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_promote.tbl_user_roles: ~2 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_user_roles` DISABLE KEYS */;
INSERT INTO `tbl_user_roles` (`id_roles`, `nama_roles`, `roles`, `create_date`, `create_by`) VALUES
	(23, 'super admin', 'user_group,user_roles', '2020-06-29 07:30:32', '0');
/*!40000 ALTER TABLE `tbl_user_roles` ENABLE KEYS */;

-- membuang struktur untuk table db_promote.visitors_table
DROP TABLE IF EXISTS `visitors_table`;
CREATE TABLE IF NOT EXISTS `visitors_table` (
  `id_visitor` int(11) NOT NULL AUTO_INCREMENT,
  `visitor_ip` varchar(225) DEFAULT NULL,
  `visitor_browser` varchar(225) DEFAULT NULL,
  `visitor_hour` varchar(225) DEFAULT NULL,
  `visitor_minute` varchar(225) DEFAULT NULL,
  `visitor_date` varchar(225) DEFAULT NULL,
  `visitor_day` varchar(225) DEFAULT NULL,
  `visitor_month` varchar(225) DEFAULT NULL,
  `visitor_year` varchar(225) DEFAULT NULL,
  `visitor_refferer` varchar(225) DEFAULT NULL,
  `visitor_page` varchar(225) DEFAULT NULL,
  `os` varchar(225) DEFAULT NULL,
  `duration` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id_visitor`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_promote.visitors_table: ~2 rows (lebih kurang)
/*!40000 ALTER TABLE `visitors_table` DISABLE KEYS */;
INSERT INTO `visitors_table` (`id_visitor`, `visitor_ip`, `visitor_browser`, `visitor_hour`, `visitor_minute`, `visitor_date`, `visitor_day`, `visitor_month`, `visitor_year`, `visitor_refferer`, `visitor_page`, `os`, `duration`) VALUES
	(1, '127.0.0.1', 'Mozilla Firefox v.77.0', '12', '59', '2020-06-29 12:59:45', '29', '06', '2020', '192.168.74.2', 'http://localhost/promote/', 'Windows 10', '1593413985'),
	(2, '127.0.0.1', 'Mozilla Firefox v.77.0', '16', '39', '2020-06-29 16:39:05', '29', '06', '2020', '192.168.74.2', 'http://localhost/promote/', 'Windows 10', '1593427145');
/*!40000 ALTER TABLE `visitors_table` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
