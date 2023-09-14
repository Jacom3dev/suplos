CREATE DATABASE `suplos` CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `suplos`;

CREATE TABLE `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency` varchar(5) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

INSERT INTO `currency` (`currency`) VALUES
  ('COP'),
  ('USD'),
  ('EUR');

CREATE TABLE `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `document` varchar(15) UNIQUE NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

INSERT INTO `client` (`name`,`document`) VALUES
  ('client 1', '123456789'),
  ('client 2', '987654321');



CREATE TABLE `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

INSERT INTO `activity` (`name`) VALUES
('Activity 1'),
('Activity 2'),
('Activity 3'),
('Activity 4'),
('Activity 5');


CREATE TABLE `process_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `object` varchar(15) NOT NULL,
  `description` text NOT NULL,
  `currency_id` int(11) NOT NULL,
  `budget` DECIMAL(10, 2) NOT NULL, 
  `activity_id` int(11) NOT NULL,
  `start_date` DATE NOT NULL,
  `start_time` TIME NOT NULL,
  `end_date` DATE NOT NULL,
  `end_time` TIME NOT NULL,
  `status` text DEFAULT 'ACTIVE',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `currency_id` (`currency_id`),
  CONSTRAINT `fk_currency_id` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `fk_client_id` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  KEY `activity_id` (`activity_id`),
  CONSTRAINT `fk_activity_id` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`id`)
);


INSERT INTO `process_event` (`client_id`,`object`, `description`, `currency_id`, `activity_id`, `budget`, `start_date`, `start_time`, `end_date`, `end_time`)
VALUES
  (1, 'CE6263KP3G9HBSO', 'Descripción 1', 1, 1, 100.00, '2023-09-11', '09:00:00', '2023-09-15', '17:00:00'),
  (1, 'X8WQ0N4Z7D2M1R6', 'Descripción 2', 2, 1, 250.50, '2023-09-12', '10:30:00', '2023-09-15', '16:45:00'),
  (1, 'Y3T5J9F6O7R8E2Q', 'Descripción 3', 1, 1, 75.25, '2023-09-13', '08:15:00', '2023-09-15', '14:30:00'),
  (1, 'A1B2C3D4E5F6G7H', 'Descripción 4', 3, 1, 300.00, '2023-09-14', '11:00:00', '2023-09-14', '18:00:00'),
  (1, 'K8P3G9H6Q0M4Z7', 'Descripción 5', 2, 2, 50.75, '2023-09-15', '13:45:00', '2023-09-12', '19:30:00'),
  (1, 'E4X2A1M9P3L0E8S', 'Descripción 6', 1, 1, 125.00, '2023-09-16', '09:30:00', '2023-09-18', '16:15:00'),
  (1, 'Z0X2V9A3Q7K4L6M', 'Descripción 7', 2, 1, 200.50, '2023-09-17', '12:45:00', '2023-09-19', '14:00:00'),
  (1, 'R2B3A4C5E6D7F8G', 'Descripción 8', 1, 1, 45.75, '2023-09-18', '08:00:00', '2023-09-20', '17:30:00'),
  (1, 'K9P3R0T5A7I6O8L', 'Descripción 9', 3, 1, 150.00, '2023-09-19', '10:15:00', '2023-09-21', '19:45:00'),
  (1, 'S7U5P8L0O8S2Z9', 'Descripción 10', 2,3, 75.25, '2023-09-20', '14:00:00', '2023-09-22', '16:00:00');

SET GLOBAL event_scheduler = ON;

DELIMITER $$
CREATE EVENT check_event_status
ON SCHEDULE EVERY 1 MINUTE 
DO
BEGIN
    UPDATE process_event
    SET status = 'EVALUATION'
    WHERE (end_date < DATE(NOW()) OR (end_date = DATE(NOW()) AND end_time <= CURTIME()))
    AND status = 'PUBLISHED';
END;
$$
DELIMITER ;

