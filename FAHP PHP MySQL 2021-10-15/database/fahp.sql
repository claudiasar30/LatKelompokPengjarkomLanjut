/*
SQLyog Ultimate v9.50 
MySQL - 5.5.5-10.4.22-MariaDB : Database - fahp
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`fahp` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `fahp`;

/*Table structure for table `tb_admin` */

DROP TABLE IF EXISTS `tb_admin`;

CREATE TABLE `tb_admin` (
  `user` varchar(16) NOT NULL,
  `pass` varchar(16) NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_admin` */

insert  into `tb_admin`(`user`,`pass`) values ('admin','admin');

/*Table structure for table `tb_alternatif` */

DROP TABLE IF EXISTS `tb_alternatif`;

CREATE TABLE `tb_alternatif` (
  `kode_alternatif` varchar(16) NOT NULL,
  `nama_alternatif` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `total` double DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  PRIMARY KEY (`kode_alternatif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_alternatif` */

insert  into `tb_alternatif`(`kode_alternatif`,`nama_alternatif`,`keterangan`,`total`,`rank`) values ('A01','Tanaman 1','',2.8334608162357,5),('A02','Tanaman 2','',3.3785217788961,2),('A03','Tanaman 3','',1.8045216876526,9),('A04','Tanaman 4','',3.7715131220838,1),('A05','Tanaman 5','',2.1975130308403,6),('A06','Tanaman 6','',2.9855304357085,4),('A07','Tanaman 7','',2.0309738470759,8),('A08','Tanaman 8','',3.1830434665487,3),('A09','Tanaman 9','',2.0454434113675,7),('A10','Tanaman 10','',1.6214782211039,10);

/*Table structure for table `tb_kriteria` */

DROP TABLE IF EXISTS `tb_kriteria`;

CREATE TABLE `tb_kriteria` (
  `kode_kriteria` varchar(16) NOT NULL,
  `nama_kriteria` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`kode_kriteria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_kriteria` */

insert  into `tb_kriteria`(`kode_kriteria`,`nama_kriteria`,`keterangan`) values ('C01','Hasil Panen',''),('C02','Harga',''),('C03','Ketahanan Hama','');

/*Table structure for table `tb_rel_alternatif` */

DROP TABLE IF EXISTS `tb_rel_alternatif`;

CREATE TABLE `tb_rel_alternatif` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `kode_alternatif` varchar(16) DEFAULT NULL,
  `kode_kriteria` varchar(16) DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_rel_alternatif` */

insert  into `tb_rel_alternatif`(`ID`,`kode_alternatif`,`kode_kriteria`,`nilai`) values (1,'A01','C01',2),(2,'A01','C02',3),(3,'A01','C03',5),(6,'A02','C01',4),(7,'A02','C02',3),(8,'A02','C03',2),(11,'A03','C01',1),(12,'A03','C02',4),(13,'A03','C03',2),(40,'A04','C01',5),(41,'A04','C02',2),(42,'A04','C03',2),(43,'A05','C01',2),(44,'A05','C02',3),(45,'A05','C03',2),(46,'A06','C01',3),(47,'A06','C02',4),(48,'A06','C03',2),(49,'A07','C01',1),(50,'A07','C02',3),(51,'A07','C03',4),(52,'A08','C01',3),(53,'A08','C02',5),(54,'A08','C03',2),(55,'A09','C01',1),(56,'A09','C02',2),(57,'A09','C03',5),(58,'A10','C01',1),(59,'A10','C02',2),(60,'A10','C03',3);

/*Table structure for table `tb_rel_kriteria` */

DROP TABLE IF EXISTS `tb_rel_kriteria`;

CREATE TABLE `tb_rel_kriteria` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID1` varchar(16) DEFAULT NULL,
  `ID2` varchar(16) DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=197 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_rel_kriteria` */

insert  into `tb_rel_kriteria`(`ID`,`ID1`,`ID2`,`nilai`) values (75,'C01','C01',1),(76,'C02','C01',0.2),(77,'C02','C02',1),(78,'C01','C02',5),(79,'C03','C01',0.333333333),(80,'C03','C02',2),(81,'C03','C03',1),(82,'C01','C03',3),(83,'C02','C03',0.5);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
