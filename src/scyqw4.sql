-- File name: scyqw4.sql
-- Functionality: script of database for SMS
-- Author: Qingyu WANG
-- Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
-- All rights reserved.

-- http://cslinux.nottingham.edu.cn/phpmyadmin/
-- username: scyqw4
-- password: scyqw4
-- dbname: scyqw4


-- account

CREATE TABLE IF NOT EXISTS `account` (
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` enum('customer','salesrep','manager') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `account` (`username`, `password`, `user_type`) VALUES
('manager', '123456', 'manager');

-- PRIMARY KEY for account

ALTER TABLE `account`
  ADD PRIMARY KEY (`username`);


-- customer

CREATE TABLE IF NOT EXISTS `customer` (
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `passport_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `region` enum('China','UK','Thailand','Korea') COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- PRIMARY KEY for customer

ALTER TABLE `customer`
  ADD PRIMARY KEY (`username`);

-- FOREIGN KEY for customer

ALTER TABLE `customer`
  ADD CONSTRAINT `customer_username_fk` FOREIGN KEY (`username`) REFERENCES `account` (`username`);


-- salesrep

CREATE TABLE IF NOT EXISTS `salesrep` (
  `employee_id` int(11) NOT NULL,
  `first_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `region` enum('China','UK','Thailand','Korea') COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `quota` int(11) NOT NULL,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- PRIMARY KEY for salesrep

ALTER TABLE `salesrep`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `unique_account` (`username`);

-- FOREIGN KEY for salesrep

ALTER TABLE `salesrep`
  ADD CONSTRAINT `salesrep_username_fk` FOREIGN KEY (`username`) REFERENCES `account` (`username`);

-- AUTO_INCREMENT for salesrep

ALTER TABLE `salesrep`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT;


-- mask

CREATE TABLE IF NOT EXISTS `mask` (
  `mask_type` enum('N95','S','SN95') COLLATE utf8_unicode_ci NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `mask` (`mask_type`, `unit_price`) VALUES
('N95', 10.00),
('S', 1.50),
('SN95', 18.80);

-- PRIMARY KEY for mask

ALTER TABLE `mask`
  ADD PRIMARY KEY (`mask_type`);


-- ordering

CREATE TABLE IF NOT EXISTS `ordering` (
  `ordering_id` int(11) NOT NULL,
  `mask_type` enum('N95','S','SN95') COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `sales_amount` decimal(10,2) NOT NULL,
  `creation_time` datetime NOT NULL,
  `status` enum('N','A') COLLATE utf8_unicode_ci NOT NULL,
  `customer_username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `salesrep_employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- PRIMARY KEY for ordering

ALTER TABLE `ordering`
  ADD PRIMARY KEY (`ordering_id`);

-- FOREIGN KEY for ordering
ALTER TABLE `ordering`
  ADD CONSTRAINT `ordering_username_fk` FOREIGN KEY (`customer_username`) REFERENCES `customer` (`username`),
  ADD CONSTRAINT `salesrep_employee_id_fk` FOREIGN KEY (`salesrep_employee_id`) REFERENCES `salesrep` (`employee_id`),
  ADD CONSTRAINT `mask_type_fk` FOREIGN KEY (`mask_type`) REFERENCES `mask` (`mask_type`);

-- AUTO_INCREMENT for ordering

ALTER TABLE `ordering`
  MODIFY `ordering_id` int(11) NOT NULL AUTO_INCREMENT;
