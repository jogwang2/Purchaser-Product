CREATE DATABASE IF NOT EXISTS `test` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `test`;

CREATE TABLE `products` (
	`id` INT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`created_date` DATETIME NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `name` (`name`)
);

CREATE TABLE `purchasers` (
	`id` INT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`created_date` DATETIME NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `name` (`name`)
);

CREATE TABLE `purchases` (
	`id` INT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`purchaser_id` INT(20) UNSIGNED NOT NULL,
	`product_id` INT(20) UNSIGNED NOT NULL,
	`purchase_timestamp` DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
	PRIMARY KEY (`id`),
	INDEX `FK_purchases_purchasers` (`purchaser_id`),
	INDEX `FK_purchases_products` (`product_id`),
	CONSTRAINT `FK_purchases_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
	CONSTRAINT `FK_purchases_purchasers` FOREIGN KEY (`purchaser_id`) REFERENCES `purchasers` (`id`)
);
