-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for stugate
CREATE
DATABASE IF NOT EXISTS `stugate` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE
`stugate`;

-- Dumping structure for table stugate.admins
CREATE TABLE IF NOT EXISTS `admins`
(
    `admin_id` int
(
    255
) NOT NULL AUTO_INCREMENT,
    `admin_name` varchar
(
    255
) NOT NULL,
    `admin_email` varchar
(
    255
) NOT NULL,
    `admin_cell` varchar
(
    255
) NOT NULL,
    `admin_password` varchar
(
    255
) NOT NULL,
    `admin_address` text NOT NULL,
    `admin_status` int
(
    5
) NOT NULL DEFAULT '1',
    `admin_type` varchar
(
    255
) NOT NULL DEFAULT 'backend',
    `admin_image` varchar
(
    255
) NOT NULL DEFAULT '',
    PRIMARY KEY
(
    `admin_id`
),
    UNIQUE KEY `admin_email`
(
    `admin_email`
)
    ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table stugate.admins: ~2 rows (approximately)
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` (`admin_id`, `admin_name`, `admin_email`, `admin_cell`, `admin_password`, `admin_address`,
                      `admin_status`, `admin_type`, `admin_image`)
VALUES (1, 'Admin', 'admin@gmail.com', '+62123456789', 'ZzVkcTBNai8xY25WY1JzdUI3eklsdz09', 'Bandung', 1, 'admin', '');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;

-- Dumping structure for table stugate.schools
CREATE TABLE IF NOT EXISTS `schools`
(
    `school_id` int
(
    11
) NOT NULL AUTO_INCREMENT,
    `school_name` varchar
(
    255
) NOT NULL,
    `school_logo` varchar
(
    255
) NOT NULL DEFAULT '',
    `school_contact` varchar
(
    255
) NOT NULL,
    `school_email` varchar
(
    255
) NOT NULL,
    `school_address` varchar
(
    255
) NOT NULL,
    `currency_symbol` varchar
(
    20
) NOT NULL,
    `school_status` varchar
(
    255
) NOT NULL,
    `school_admin_id` int
(
    255
) NOT NULL,
    PRIMARY KEY
(
    `school_id`
)
    ) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table stugate.schools: 3 rows
/*!40000 ALTER TABLE `schools` DISABLE KEYS */;
INSERT INTO `schools` (`school_id`, `school_name`, `school_logo`, `school_contact`, `school_email`, `school_address`,
                       `currency_symbol`, `school_status`, `school_admin_id`)
VALUES (5, 'Android University', '1646912861.png', '+628988938787', 'university@android.com', 'CA', '$', 'OPEN', 1),
       (4, 'Apple University', '1646912819.png', '+6289889388499', 'university@apple.com', 'CA', '$', 'OPEN', 1);
/*!40000 ALTER TABLE `schools` ENABLE KEYS */;

-- Dumping structure for table stugate.students
CREATE TABLE IF NOT EXISTS `students`
(
    `student_id` int
(
    11
) NOT NULL AUTO_INCREMENT,
    `student_name` varchar
(
    255
) NOT NULL,
    `student_code` varchar
(
    255
) NOT NULL,
    `student_phone` varchar
(
    255
) NOT NULL,
    `student_email` varchar
(
    255
) NOT NULL,
    `student_address` varchar
(
    255
) NOT NULL,
    `student_department` varchar
(
    255
) NOT NULL,
    `student_level` varchar
(
    255
) NOT NULL,
    `student_session_paid` varchar
(
    255
) NOT NULL,
    `student_transaction_id` varchar
(
    255
) NOT NULL,
    `student_date_paid` varchar
(
    255
) NOT NULL,
    `student_passport` varchar
(
    255
) NOT NULL,
    `student_barcode` varchar
(
    255
) NOT NULL DEFAULT '',
    `student_status` varchar
(
    255
) NOT NULL DEFAULT '',
    `student_image` varchar
(
    255
) NOT NULL DEFAULT '',
    `school_id` int
(
    255
) NOT NULL,
    `admin_id` int
(
    255
) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `student_payment_bank` varchar
(
    255
) NOT NULL DEFAULT '',
    PRIMARY KEY
(
    `student_id`
)
    ) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table stugate.students: 4 rows
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` (`student_id`, `student_name`, `student_code`, `student_phone`, `student_email`,
                        `student_address`, `student_department`, `student_level`, `student_session_paid`,
                        `student_transaction_id`, `student_date_paid`, `student_passport`, `student_barcode`,
                        `student_status`, `student_image`, `school_id`, `admin_id`, `timestamp`, `student_payment_bank`)
VALUES (6,'Student 1','366c32350c76791d914b','+628003882983','student1@gmail.com','ID','EEE','100','2021/2022','','','','977ee77f63fa30f7ea4f','UNPAID','image_placeholder.png',5,1,'2022-03-10 20:03:33','');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;

-- Dumping structure for table stugate.superusers
CREATE TABLE IF NOT EXISTS `superusers`
(
    `superuser_id` int
(
    11
) NOT NULL AUTO_INCREMENT,
    `superuser_name` varchar
(
    255
) NOT NULL,
    `superuser_email` varchar
(
    255
) NOT NULL,
    `superuser_cell` varchar
(
    20
) NOT NULL,
    `superuser_password` varchar
(
    255
) NOT NULL,
    `superuser_type` varchar
(
    255
) NOT NULL,
    `superuser_image` varchar
(
    255
) NOT NULL DEFAULT '',
    PRIMARY KEY
(
    `superuser_id`
),
    UNIQUE KEY `superuser_email`
(
    `superuser_email`
)
    ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table stugate.superusers: ~0 rows (approximately)
/*!40000 ALTER TABLE `superusers` DISABLE KEYS */;
INSERT INTO `superusers` (`superuser_id`, `superuser_name`, `superuser_email`, `superuser_cell`, `superuser_password`,
                          `superuser_type`, `superuser_image`)
VALUES (1,'Rizki Wisnuaji','superuser@gmail.com','+6288908892560','ZzVkcTBNai8xY25WY1JzdUI3eklsdz09','superadmin','');
/*!40000 ALTER TABLE `superusers` ENABLE KEYS */;

-- Dumping structure for table stugate.users
CREATE TABLE IF NOT EXISTS `users`
(
    `id` int
(
    11
) NOT NULL AUTO_INCREMENT,
    `name` varchar
(
    255
) NOT NULL,
    `cell` varchar
(
    255
) NOT NULL,
    `email` varchar
(
    255
) NOT NULL,
    `password` varchar
(
    255
) NOT NULL,
    `user_status` int
(
    5
) NOT NULL DEFAULT '1',
    `user_type` varchar
(
    255
) NOT NULL,
    `user_image` varchar
(
    255
) NOT NULL DEFAULT '',
    `school_id` int
(
    255
) NOT NULL,
    `admin_id` int
(
    255
) NOT NULL,
    PRIMARY KEY
(
    `id`
)
    ) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table stugate.users: 3 rows
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `cell`, `email`, `password`, `user_status`, `user_type`, `user_image`, `school_id`,
                     `admin_id`)
VALUES (1,'Examiner 1','123456789','ex1@gmail.com','cmN5WlcxMG1VUFVSMDJGcVhQTDVqZz09',1,'examiner','image_placeholder.png',1,1),
       (2,'Invigilator 1','777888','iv1@gmail.com','cmN5WlcxMG1VUFVSMDJGcVhQTDVqZz09',1,'invigilator','image_placeholder.png',1,1),
       (3,'Examiner 2','76543211','ex2@gmail.com','ZzVkcTBNai8xY25WY1JzdUI3eklsdz09',0,'examiner','image_placeholder.png',1,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
