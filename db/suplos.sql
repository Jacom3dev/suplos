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


CREATE TABLE `process_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object` varchar(15) NOT NULL,
  `description` text NOT NULL,
  `currency_id` int(11) NOT NULL,
  `budget` DECIMAL(10, 2) NOT NULL, 
  `activity` text NOT NULL,
  `start_date` DATE NOT NULL,
  `start_time` TIME NOT NULL,
  `end_date` DATE NOT NULL,
  `end_time` TIME NOT NULL,
  `status` text DEFAULT 'ACTIVE',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `currency_id` (`currency_id`),
  CONSTRAINT `process_event_ibfk_1` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`)
);


INSERT INTO `process_event` (`object`, `description`, `currency_id`, `activity`, `budget`, `start_date`, `start_time`, `end_date`, `end_time`) VALUES
  ('Objeto 1', 'Descripción 1', 1, 'Actividad 1', 100.00, '2023-09-11', '09:00:00', '2023-09-11', '17:00:00'),
  ('Objeto 2', 'Descripción 2', 2, 'Actividad 2', 250.50, '2023-09-12', '10:30:00', '2023-09-12', '16:45:00'),
  ('Objeto 3', 'Descripción 3', 1, 'Actividad 3', 75.25, '2023-09-13', '08:15:00', '2023-09-13', '14:30:00'),
  ('Objeto 4', 'Descripción 4', 3, 'Actividad 4', 300.00, '2023-09-14', '11:00:00', '2023-09-14', '18:00:00'),
  ('Objeto 5', 'Descripción 5', 2, 'Actividad 5', 50.75, '2023-09-15', '13:45:00', '2023-09-15', '19:30:00');
