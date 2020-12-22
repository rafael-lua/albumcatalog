-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `catalogo`;
CREATE DATABASE `catalogo` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `catalogo`;

DELIMITER ;;

CREATE FUNCTION `calcNotes`(`id` INTEGER) RETURNS float
    DETERMINISTIC
begin
	declare cmedia float;
	select ROUND(AVG(r.note), 2) into cmedia from ranking r where (id = r.albumId);
	return cmedia;
end;;

CREATE FUNCTION `countNotes`(`albumId` INT) RETURNS int
    DETERMINISTIC
begin
	declare totalNotes integer;
	select count(note) into totalNotes from ranking where ranking.albumId = albumId;
	return totalNotes;
end;;

DELIMITER ;

DROP TABLE IF EXISTS `activity`;
CREATE TABLE `activity` (
  `userId` int unsigned NOT NULL,
  `number` bigint unsigned NOT NULL,
  `occurredDate` date NOT NULL,
  `descri` varchar(255) NOT NULL,
  `hide` tinyint(1) NOT NULL DEFAULT '0',
  `collectionReference` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`userId`,`number`),
  CONSTRAINT `activity_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `useraccount` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `activity` (`userId`, `number`, `occurredDate`, `descri`, `hide`, `collectionReference`) VALUES
(1,	1,	'2020-10-23',	'Primeira atividade para testes',	0,	0),
(1,	2,	'2020-10-23',	'Deu nota 10 ao álbum New York City',	0,	0),
(1,	3,	'2020-10-23',	'Deu nota 9 ao álbum New York City',	0,	0),
(1,	4,	'2020-10-23',	'Deu nota 10 ao álbum New York City',	0,	0),
(1,	5,	'2020-10-23',	'Escreveu uma crítica ao álbum New York City',	0,	0),
(1,	6,	'2020-10-23',	'Criou a coleção sadsadasdsa',	0,	38),
(1,	7,	'2020-10-24',	'Esperando lançar o álbum Beijing',	0,	4),
(1,	8,	'2020-10-24',	'Pretende escutar o álbum Beijing',	0,	3),
(1,	9,	'2020-10-24',	'Completou o álbum Beijing',	0,	5),
(1,	10,	'2020-10-24',	'Abandonou o álbum Beijing',	0,	6),
(1,	11,	'2020-10-24',	'Pretende escutar o álbum Beijing',	0,	3),
(1,	12,	'2020-10-28',	'Deu nota 9 ao álbum New York City',	0,	0),
(1,	13,	'2020-10-28',	'Deu nota 10 ao álbum New York City',	0,	0),
(1,	14,	'2020-11-03',	'Deu nota 10 ao álbum Gorillaz',	0,	0),
(1,	15,	'2020-11-03',	'Deu nota 8 ao álbum Abbey Road',	0,	0),
(1,	16,	'2020-11-03',	'Completou o álbum Abbey Road',	0,	5),
(1,	17,	'2020-11-03',	'Deu nota 8 ao álbum Now You\'re Gone – The Album',	0,	0),
(1,	18,	'2020-11-03',	'Deu nota 9 ao álbum Abbey Road',	0,	0),
(1,	19,	'2020-11-03',	'Deu nota 10 ao álbum Gorillaz',	0,	0),
(1,	20,	'2020-11-03',	'Deu nota 9 ao álbum Gorillaz',	0,	0),
(1,	21,	'2020-11-03',	'Deu nota 10 ao álbum Gorillaz',	0,	0),
(1,	22,	'2020-11-03',	'Deu nota 8 ao álbum Gorillaz',	0,	0),
(1,	23,	'2020-11-03',	'Deu nota 10 ao álbum Gorillaz',	0,	0),
(1,	24,	'2020-11-03',	'Deu nota 10 ao álbum Gorillaz',	0,	0),
(1,	25,	'2020-11-03',	'Deu nota 9 ao álbum Gorillaz',	0,	0),
(1,	26,	'2020-11-03',	'Deu nota 10 ao álbum Gorillaz',	0,	0),
(1,	27,	'2020-11-03',	'Deu nota 10 ao álbum Gorillaz',	0,	0),
(1,	28,	'2020-11-03',	'Deu nota 9 ao álbum Gorillaz',	0,	0),
(1,	29,	'2020-11-03',	'Deu nota 10 ao álbum Gorillaz',	0,	0),
(2,	1,	'2020-11-03',	'Deu nota 6 ao álbum Gorillaz',	0,	0),
(2,	2,	'2020-11-03',	'Deu nota 8 ao álbum Gorillaz',	0,	0),
(2,	3,	'2020-11-03',	'Completou o álbum Gorillaz',	0,	11),
(2,	4,	'2020-11-03',	'Deu nota 8 ao álbum Gorillaz',	0,	0),
(2,	5,	'2020-11-03',	'Deu nota 7 ao álbum Gorillaz',	0,	0),
(3,	1,	'2020-11-03',	'Deu nota 8 ao álbum Gorillaz',	0,	0),
(3,	2,	'2020-11-03',	'Deu nota 5 ao álbum Seattle',	0,	0),
(3,	3,	'2020-11-03',	'Deu nota 9 ao álbum Gorillaz',	0,	0),
(3,	4,	'2020-11-03',	'Deu nota 9 ao álbum Gorillaz',	0,	0),
(3,	5,	'2020-11-03',	'Deu nota 8 ao álbum Gorillaz',	0,	0);

DROP TABLE IF EXISTS `album`;
CREATE TABLE `album` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `year` int DEFAULT NULL,
  `duration` time DEFAULT NULL,
  `nSongs` int DEFAULT NULL,
  `rating` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `album` (`id`, `name`, `year`, `duration`, `nSongs`, `rating`) VALUES
(1,	'Tokyo',	1990,	NULL,	NULL,	4.65),
(2,	'Moscow',	1991,	NULL,	NULL,	4.18),
(3,	'Beijing',	1992,	NULL,	NULL,	4.6),
(4,	'London',	1993,	NULL,	NULL,	4.86),
(5,	'Hong Kong',	1995,	NULL,	NULL,	6.3),
(6,	'Madrid',	1998,	NULL,	NULL,	5.54),
(7,	'New York City',	1956,	NULL,	NULL,	7.95),
(8,	'Paris',	2000,	NULL,	NULL,	4.08),
(9,	'Seattle',	2007,	NULL,	NULL,	6.63),
(10,	'Dubai',	2015,	NULL,	NULL,	1.96),
(11,	'Please Please Me',	1963,	NULL,	NULL,	NULL),
(12,	'Abbey Road',	1969,	NULL,	NULL,	NULL),
(13,	'Now You\'re Gone – The Album',	2008,	NULL,	NULL,	NULL),
(14,	'Demon Days',	2005,	NULL,	NULL,	NULL),
(15,	'Gorillaz',	2001,	NULL,	NULL,	8.5),
(16,	'E=MC²',	2007,	NULL,	NULL,	NULL),
(17,	'Memoirs of an Imperfect Angel',	2009,	NULL,	NULL,	NULL),
(18,	'Sinatra & Company',	1971,	NULL,	NULL,	NULL),
(19,	'Duets',	1993,	NULL,	NULL,	NULL),
(20,	'Duets II',	1994,	NULL,	NULL,	NULL),
(21,	'Doo-Wops & Hooligans',	2010,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `artist`;
CREATE TABLE `artist` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `summary` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `artist` (`id`, `name`, `summary`) VALUES
(1,	'Louise',	'Born in somewhere, debuted in this date and is known for all these albuns...'),
(2,	'Erick',	'Born in somewhere, debuted in this date and is known for all these albuns...'),
(3,	'Amy',	'Born in somewhere, debuted in this date and is known for all these albuns...'),
(4,	'Alice',	'Born in somewhere, debuted in this date and is known for all these albuns...'),
(5,	'Jimmy',	'Born in somewhere, debuted in this date and is known for all these albuns...'),
(6,	'The Beatles',	'English rock band formed in Liverpool in 1960...'),
(7,	'Basshunter',	'Jonas Erik Altberg, born 22 December 1984 in Halmstad, better known by his stage name Basshunter, is a Swedish singer, record producer and DJ.'),
(8,	'Gorillaz',	'Gorillaz are a British virtual band created in 1998 by musician Damon Albarn and artist Jamie Hewlett.'),
(9,	'Mariah Carey',	'Mariah Carey is an American singer-songwriter and actress. Known for her five-octave vocal range, melismatic singing style, and signature use of the whistle register, she is referred to as the \"Songbird Supreme\" by Guinness World Records.'),
(10,	'Frank Sinatra',	'Francis Albert Sinatra was an American singer, actor and producer who was one of the most popular and influential musical artists of the 20th century.'),
(11,	'Bruno Mars',	'Peter Gene Hernandez (born October 8, 1985), known professionally as Bruno Mars, is an American singer, songwriter, record producer, multi-instrumentalist, and dancer.');

DROP TABLE IF EXISTS `artistalbum`;
CREATE TABLE `artistalbum` (
  `artistId` int unsigned NOT NULL,
  `albumId` int unsigned NOT NULL,
  PRIMARY KEY (`artistId`,`albumId`),
  KEY `albumId` (`albumId`),
  CONSTRAINT `artistalbum_ibfk_1` FOREIGN KEY (`artistId`) REFERENCES `artist` (`id`),
  CONSTRAINT `artistalbum_ibfk_2` FOREIGN KEY (`albumId`) REFERENCES `album` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `artistalbum` (`artistId`, `albumId`) VALUES
(1,	1),
(2,	1),
(3,	2),
(4,	3),
(5,	4),
(4,	5),
(5,	6),
(3,	7),
(2,	8),
(2,	9),
(1,	10),
(6,	11),
(6,	12),
(7,	13),
(8,	14),
(8,	15),
(9,	16),
(9,	17),
(10,	18),
(10,	19),
(10,	20),
(11,	21);

DROP TABLE IF EXISTS `collection`;
CREATE TABLE `collection` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `visible` enum('show','hide') NOT NULL,
  `userId` int unsigned NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `baseid` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`userId`),
  KEY `userId` (`userId`),
  CONSTRAINT `collection_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `useraccount` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `collection` (`id`, `title`, `visible`, `userId`, `locked`, `baseid`) VALUES
(1,	'Álbuns Críticados',	'show',	1,	1,	0),
(2,	'Álbuns Classificados',	'show',	1,	1,	1),
(3,	'Pretende Ouvir',	'show',	1,	2,	2),
(4,	'Esperando Lançamento',	'show',	1,	2,	3),
(5,	'Completo',	'show',	1,	2,	4),
(6,	'Abandonado',	'show',	1,	2,	5),
(7,	'Álbuns Críticados',	'show',	2,	1,	0),
(8,	'Álbuns Classificados',	'show',	2,	1,	1),
(9,	'Pretende Ouvir',	'show',	2,	2,	2),
(10,	'Esperando Lançamento',	'show',	2,	2,	3),
(11,	'Completo',	'show',	2,	2,	4),
(12,	'Abandonado',	'show',	2,	2,	5),
(13,	'Álbuns Críticados',	'show',	3,	1,	0),
(14,	'Álbuns Classificados',	'show',	3,	1,	1),
(15,	'Pretende Ouvir',	'show',	3,	2,	2),
(16,	'Esperando Lançamento',	'show',	3,	2,	3),
(17,	'Completo',	'show',	3,	2,	4),
(18,	'Abandonado',	'show',	3,	2,	5),
(19,	'Álbuns Críticados',	'show',	4,	1,	0),
(20,	'Álbuns Classificados',	'show',	4,	1,	1),
(21,	'Pretende Ouvir',	'show',	4,	2,	2),
(22,	'Esperando Lançamento',	'show',	4,	2,	3),
(23,	'Completo',	'show',	4,	2,	4),
(24,	'Abandonado',	'show',	4,	2,	5),
(25,	'Álbuns Críticados',	'show',	5,	1,	0),
(26,	'Álbuns Classificados',	'show',	5,	1,	1),
(27,	'Pretende Ouvir',	'show',	5,	2,	2),
(28,	'Esperando Lançamento',	'show',	5,	2,	3),
(29,	'Completo',	'show',	5,	2,	4),
(30,	'Abandonado',	'show',	5,	2,	5),
(31,	'Coleção Genérica Sem Gêneros',	'show',	1,	0,	9),
(32,	'Coleção Genérica Com Gêneros',	'show',	1,	0,	9);

DROP TABLE IF EXISTS `collectionalbum`;
CREATE TABLE `collectionalbum` (
  `collectionId` bigint unsigned NOT NULL,
  `albumId` int unsigned NOT NULL,
  PRIMARY KEY (`collectionId`,`albumId`),
  KEY `albumId` (`albumId`),
  CONSTRAINT `collectionalbum_ibfk_1` FOREIGN KEY (`collectionId`) REFERENCES `collection` (`id`),
  CONSTRAINT `collectionalbum_ibfk_2` FOREIGN KEY (`albumId`) REFERENCES `album` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `collectionalbum` (`collectionId`, `albumId`) VALUES
(7,	1),
(8,	1),
(12,	1),
(14,	1),
(17,	1),
(20,	1),
(23,	1),
(25,	1),
(29,	1),
(2,	2),
(5,	2),
(11,	2),
(13,	2),
(14,	2),
(17,	2),
(20,	2),
(24,	2),
(26,	2),
(29,	2),
(1,	3),
(2,	3),
(3,	3),
(8,	3),
(11,	3),
(14,	3),
(17,	3),
(20,	3),
(23,	3),
(26,	3),
(29,	3),
(2,	4),
(5,	4),
(8,	4),
(11,	4),
(13,	4),
(14,	4),
(18,	4),
(20,	4),
(23,	4),
(26,	4),
(30,	4),
(1,	5),
(2,	5),
(5,	5),
(8,	5),
(12,	5),
(14,	5),
(17,	5),
(20,	5),
(23,	5),
(25,	5),
(26,	5),
(29,	5),
(1,	6),
(2,	6),
(5,	6),
(8,	6),
(11,	6),
(13,	6),
(14,	6),
(17,	6),
(20,	6),
(23,	6),
(26,	6),
(30,	6),
(1,	7),
(2,	7),
(5,	7),
(7,	7),
(8,	7),
(11,	7),
(17,	7),
(20,	7),
(23,	7),
(29,	7),
(1,	8),
(5,	8),
(8,	8),
(11,	8),
(14,	8),
(17,	8),
(19,	8),
(20,	8),
(24,	8),
(26,	8),
(30,	8),
(31,	8),
(1,	9),
(2,	9),
(5,	9),
(8,	9),
(11,	9),
(14,	9),
(17,	9),
(23,	9),
(26,	9),
(29,	9),
(7,	10),
(8,	10),
(11,	10),
(14,	10),
(17,	10),
(20,	10),
(23,	10),
(25,	10),
(26,	10),
(29,	10),
(2,	12),
(5,	12),
(2,	13),
(2,	15),
(8,	15),
(11,	15),
(14,	15);

DROP TABLE IF EXISTS `collectiongenre`;
CREATE TABLE `collectiongenre` (
  `collectionId` bigint unsigned NOT NULL,
  `genreName` varchar(25) NOT NULL,
  PRIMARY KEY (`collectionId`,`genreName`),
  KEY `genreName` (`genreName`),
  CONSTRAINT `collectiongenre_ibfk_1` FOREIGN KEY (`collectionId`) REFERENCES `collection` (`id`),
  CONSTRAINT `collectiongenre_ibfk_2` FOREIGN KEY (`genreName`) REFERENCES `genre` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `collectiongenre` (`collectionId`, `genreName`) VALUES
(32,	'classical'),
(32,	'jazz'),
(32,	'rock');

DROP TABLE IF EXISTS `genre`;
CREATE TABLE `genre` (
  `name` varchar(25) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `origin` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `genre` (`name`, `description`, `origin`) VALUES
('Classical',	'A genre that explores these instruments and have these characteristics...',	'The roots of classical comes from...'),
('Electronic',	'A genre that explores these instruments and have these characteristics...',	'The roots of electronic comes from...'),
('Jazz',	'A genre that explores these instruments and have these characteristics...',	'The roots of jazz comes from...'),
('Pop',	'A genre that explores these instruments and have these characteristics...',	'The roots of pop comes from...'),
('Rock',	'A genre that explores these instruments and have these characteristics...',	'The roots of rock comes from...');

DROP TABLE IF EXISTS `genrealbum`;
CREATE TABLE `genrealbum` (
  `genreName` varchar(20) NOT NULL,
  `albumId` int unsigned NOT NULL,
  PRIMARY KEY (`genreName`,`albumId`),
  KEY `albumId` (`albumId`),
  CONSTRAINT `genrealbum_ibfk_1` FOREIGN KEY (`genreName`) REFERENCES `genre` (`name`),
  CONSTRAINT `genrealbum_ibfk_2` FOREIGN KEY (`albumId`) REFERENCES `album` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `genrealbum` (`genreName`, `albumId`) VALUES
('Electronic',	1),
('Rock',	1),
('Pop',	2),
('Rock',	2),
('Jazz',	3),
('Pop',	3),
('Classical',	4),
('Classical',	5),
('Electronic',	5),
('Jazz',	5),
('Electronic',	6),
('Rock',	6),
('Pop',	7),
('Rock',	7),
('Jazz',	8),
('Pop',	8),
('Classical',	9),
('Jazz',	9),
('Classical',	10),
('Electronic',	10),
('Rock',	11),
('Rock',	12),
('Electronic',	13),
('Electronic',	14),
('Rock',	14),
('Electronic',	15),
('Rock',	15),
('Pop',	16),
('Pop',	17),
('Jazz',	18),
('Jazz',	19),
('Jazz',	20),
('Pop',	21);

DROP TABLE IF EXISTS `music`;
CREATE TABLE `music` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `duration` time NOT NULL,
  `albumId` int unsigned NOT NULL,
  PRIMARY KEY (`id`,`albumId`),
  KEY `albumId` (`albumId`),
  CONSTRAINT `music_ibfk_1` FOREIGN KEY (`albumId`) REFERENCES `album` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `music` (`id`, `name`, `duration`, `albumId`) VALUES
(1,	'Track 1',	'00:01:00',	1),
(2,	'Track 2',	'00:00:30',	1),
(3,	'Track 3',	'00:01:30',	1),
(4,	'Track 4',	'00:01:11',	1),
(5,	'Track 5',	'00:01:23',	1),
(6,	'Track 1',	'00:02:00',	2),
(7,	'Track 2',	'00:00:48',	2),
(8,	'Track 3',	'00:02:10',	2),
(9,	'Track 4',	'00:02:22',	2),
(10,	'Track 5',	'00:03:21',	2),
(11,	'Track 1',	'00:03:00',	3),
(12,	'Track 2',	'00:00:31',	3),
(13,	'Track 3',	'00:03:20',	3),
(14,	'Track 4',	'00:03:33',	3),
(15,	'Track 5',	'00:06:01',	3),
(16,	'Track 1',	'00:04:00',	4),
(17,	'Track 2',	'00:00:14',	4),
(18,	'Track 3',	'00:04:50',	4),
(19,	'Track 4',	'00:04:44',	4),
(20,	'Track 5',	'00:03:59',	4),
(21,	'Track 1',	'00:05:00',	5),
(22,	'Track 2',	'00:00:05',	5),
(23,	'Track 3',	'00:05:40',	5),
(24,	'Track 4',	'00:05:55',	5),
(25,	'Track 5',	'00:02:31',	5),
(26,	'Track 1',	'00:04:00',	6),
(27,	'Track 2',	'00:00:08',	6),
(28,	'Track 3',	'00:01:10',	6),
(29,	'Track 4',	'00:01:55',	6),
(30,	'Track 5',	'00:01:22',	6),
(31,	'Track 1',	'00:03:00',	7),
(32,	'Track 2',	'00:00:59',	7),
(33,	'Track 3',	'00:06:40',	7),
(34,	'Track 4',	'00:02:44',	7),
(35,	'Track 5',	'00:03:03',	7),
(36,	'Track 1',	'00:02:00',	8),
(37,	'Track 2',	'00:00:12',	8),
(38,	'Track 3',	'00:02:30',	8),
(39,	'Track 4',	'00:03:33',	8),
(40,	'Track 5',	'00:05:01',	8),
(41,	'Track 1',	'00:01:00',	9),
(42,	'Track 2',	'00:00:11',	9),
(43,	'Track 3',	'00:04:20',	9),
(44,	'Track 4',	'00:04:22',	9),
(45,	'Track 5',	'00:06:31',	9),
(46,	'Track 1',	'00:00:00',	10),
(47,	'Track 2',	'00:00:01',	10),
(48,	'Track 3',	'00:03:30',	10),
(49,	'Track 4',	'00:05:11',	10),
(50,	'Track 5',	'00:00:53',	10),
(51,	'I Saw Her Standing There',	'00:02:55',	11),
(52,	'Misery',	'00:01:49',	11),
(53,	'Anna (Go to Him)',	'00:02:55',	11),
(54,	'Chains',	'00:02:23',	11),
(55,	'Boys',	'00:02:24',	11),
(56,	'Ask Me Why',	'00:02:24',	11),
(57,	'Please Please Me',	'00:01:59',	11),
(58,	'Love Me Do',	'00:02:21',	11),
(59,	'P.S. I Love You',	'00:02:04',	11),
(60,	'Baby It\'s You',	'00:02:40',	11),
(61,	'Do You Want to Know a Secret',	'00:01:56',	11),
(62,	'A Taste of Honey',	'00:02:03',	11),
(63,	'There\'s a Place',	'00:01:51',	11),
(64,	'Twist and Shout',	'00:02:32',	11),
(65,	'Come Together',	'00:04:19',	12),
(66,	'Something',	'00:03:02',	12),
(67,	'Maxwell\'s Silver Hammer',	'00:03:27',	12),
(68,	'Oh! Darling',	'00:03:27',	12),
(69,	'Octopus\'s Garden',	'00:02:51',	12),
(70,	'I Want You (She\'s So Heavy)',	'00:07:47',	12),
(71,	'Here Comes the Sun',	'00:03:05',	12),
(72,	'Because',	'00:02:45',	12),
(73,	'You Never Give Me Your Money',	'00:04:03',	12),
(74,	'Sun King',	'00:02:26',	12),
(75,	'Mean Mr. Mustard',	'00:01:06',	12),
(76,	'Polythene Pam',	'00:01:13',	12),
(77,	'She Came In Through the Bathroom Window',	'00:01:58',	12),
(78,	'Golden Slumbers',	'00:01:31',	12),
(79,	'Carry That Weight',	'00:01:36',	12),
(80,	'The End',	'00:02:05',	12),
(81,	'Her Majesty',	'00:00:23',	12),
(82,	'Now You\'re Gone',	'00:02:30',	13),
(83,	'All I Ever Wanted',	'00:02:58',	13),
(84,	'Please Don\'t Go',	'00:02:50',	13),
(85,	'I Miss You',	'00:03:47',	13),
(86,	'Angel in the Night',	'00:03:23',	13),
(87,	'In Her Eyes',	'00:03:14',	13),
(88,	'Love You More',	'00:03:52',	13),
(89,	'Camilla',	'00:03:16',	13),
(90,	'Dream Girl',	'00:04:28',	13),
(91,	'I Can Walk on Water',	'00:03:46',	13),
(92,	'Bass Creator',	'00:05:02',	13),
(93,	'Russia Privjet',	'00:04:05',	13),
(94,	'Intro',	'00:01:03',	14),
(95,	'Last Living Souls',	'00:03:10',	14),
(96,	'Kids with Guns',	'00:03:46',	14),
(97,	'O Green World',	'00:04:32',	14),
(98,	'Dirty Harry',	'00:03:44',	14),
(99,	'Feel Good Inc.',	'00:03:41',	14),
(100,	'El Mañana',	'00:03:50',	14),
(101,	'Every Planet We Reach Is Dead',	'00:04:53',	14),
(102,	'November Has Come',	'00:02:41',	14),
(103,	'All Alone',	'00:03:30',	14),
(104,	'White Light',	'00:02:08',	14),
(105,	'Dare',	'00:04:04',	14),
(106,	'Fire Coming Out of the Monkey\'s Head',	'00:03:16',	14),
(107,	'Don\'t Get Lost in Heaven',	'00:02:12',	14),
(108,	'Demon Days',	'00:04:29',	14),
(109,	'Track 01',	'00:00:01',	15),
(110,	'Track 02',	'00:00:39',	15),
(111,	'Track 03',	'00:03:13',	15),
(112,	'Track 04',	'00:02:08',	15),
(113,	'Track 05',	'00:01:01',	15),
(114,	'Track 06',	'00:04:40',	15),
(115,	'Track 01',	'00:02:20',	16),
(116,	'Track 02',	'00:03:41',	16),
(117,	'Track 03',	'00:05:24',	16),
(118,	'Track 04',	'00:04:00',	16),
(119,	'Track 05',	'00:03:46',	16),
(120,	'Track 06',	'00:00:51',	16),
(121,	'Track 01',	'00:04:56',	17),
(122,	'Track 02',	'00:04:10',	17),
(123,	'Track 03',	'00:00:02',	17),
(124,	'Track 04',	'00:05:41',	17),
(125,	'Track 05',	'00:04:20',	17),
(126,	'Track 06',	'00:04:37',	17),
(127,	'Track 01',	'00:04:06',	18),
(128,	'Track 02',	'00:00:40',	18),
(129,	'Track 03',	'00:03:01',	18),
(130,	'Track 04',	'00:01:06',	18),
(131,	'Track 05',	'00:02:28',	18),
(132,	'Track 06',	'00:03:02',	18),
(133,	'Track 01',	'00:01:47',	19),
(134,	'Track 02',	'00:05:50',	19),
(135,	'Track 03',	'00:05:51',	19),
(136,	'Track 04',	'00:05:44',	19),
(137,	'Track 05',	'00:05:06',	19),
(138,	'Track 06',	'00:02:18',	19),
(139,	'Track 01',	'00:02:15',	20),
(140,	'Track 02',	'00:04:21',	20),
(141,	'Track 03',	'00:03:02',	20),
(142,	'Track 04',	'00:02:04',	20),
(143,	'Track 05',	'00:01:17',	20),
(144,	'Track 06',	'00:00:15',	20),
(145,	'Track 01',	'00:03:23',	21),
(146,	'Track 02',	'00:04:09',	21),
(147,	'Track 03',	'00:04:39',	21),
(148,	'Track 04',	'00:04:48',	21),
(149,	'Track 05',	'00:04:05',	21),
(150,	'Track 06',	'00:00:01',	21);

DROP TABLE IF EXISTS `ranking`;
CREATE TABLE `ranking` (
  `note` float NOT NULL,
  `userId` int unsigned NOT NULL,
  `albumId` int unsigned NOT NULL,
  `rankingDate` date NOT NULL,
  PRIMARY KEY (`userId`,`albumId`),
  KEY `albumId` (`albumId`),
  CONSTRAINT `ranking_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `useraccount` (`id`),
  CONSTRAINT `ranking_ibfk_2` FOREIGN KEY (`albumId`) REFERENCES `album` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `ranking` (`note`, `userId`, `albumId`, `rankingDate`) VALUES
(6,	1,	1,	'0000-00-00'),
(3.4,	1,	2,	'2020-01-24'),
(5,	1,	3,	'2020-03-20'),
(8,	1,	4,	'2020-02-09'),
(9,	1,	5,	'2020-02-01'),
(10,	1,	6,	'2020-04-21'),
(10,	1,	7,	'2020-06-24'),
(5,	1,	8,	'2020-09-11'),
(3.2,	1,	9,	'2020-04-06'),
(1,	1,	10,	'2020-05-30'),
(10,	1,	15,	'0000-00-00'),
(1,	2,	1,	'2020-06-27'),
(2,	2,	3,	'2020-05-29'),
(5.8,	2,	4,	'2020-10-10'),
(1.5,	2,	5,	'2019-11-26'),
(1.6,	2,	6,	'2020-05-01'),
(9,	2,	7,	'2020-03-08'),
(4.4,	2,	8,	'2020-02-13'),
(9.5,	2,	9,	'2020-03-29'),
(2.3,	2,	10,	'2020-01-22'),
(7,	2,	15,	'0000-00-00'),
(4.8,	3,	1,	'2020-10-01'),
(5,	3,	2,	'2019-11-03'),
(6,	3,	3,	'2020-02-05'),
(1.5,	3,	4,	'2020-03-05'),
(7,	3,	5,	'2020-10-14'),
(8,	3,	6,	'2020-08-24'),
(9,	3,	8,	'2020-02-03'),
(5,	3,	9,	'2020-09-04'),
(3,	3,	10,	'2020-05-11'),
(6.8,	4,	1,	'2019-12-19'),
(2.3,	4,	2,	'2019-12-06'),
(8,	4,	3,	'2019-12-12'),
(9,	4,	4,	'2020-02-21'),
(6,	4,	5,	'2020-01-30'),
(6,	4,	6,	'2020-03-05'),
(5,	4,	7,	'2019-11-07'),
(0.3,	4,	8,	'2019-11-27'),
(2,	4,	10,	'2020-03-04'),
(6,	5,	2,	'2020-05-14'),
(2,	5,	3,	'2020-07-12'),
(0,	5,	4,	'2020-10-03'),
(8,	5,	5,	'2020-06-01'),
(2.1,	5,	6,	'2020-01-05'),
(1.7,	5,	8,	'2019-12-30'),
(8.8,	5,	9,	'2020-02-18'),
(1.5,	5,	10,	'2019-11-22');

DELIMITER ;;

CREATE TRIGGER `updateRatingInsert` AFTER INSERT ON `ranking` FOR EACH ROW
BEGIN 
	DECLARE totalNotes integer;
DECLARE ratingCheck float;
        SET totalNotes = countNotes(NEW.albumId);
        
        
        SELECT album.rating INTO ratingCheck FROM album WHERE album.id = NEW.albumId;
        IF (ratingCheck IS NULL) THEN
            UPDATE album SET album.rating = 0 WHERE album.id = NEW.albumId;
        END IF;

	IF (totalNotes > 1) THEN
		UPDATE album SET album.rating = ROUND(album.rating + ((NEW.note - album.rating) / totalNotes), 2) WHERE album.id = NEW.albumId;
	ELSE
		UPDATE album SET album.rating = NEW.note WHERE album.id = NEW.albumId;
	END IF;
END;;

CREATE TRIGGER `updateRatingUpdate` AFTER UPDATE ON `ranking` FOR EACH ROW
BEGIN
        DECLARE totalNotes integer;
	DECLARE ratingCheck float;

    	SET totalNotes = countNotes(OLD.albumId);

        SELECT album.rating INTO ratingCheck FROM album WHERE album.id = NEW.albumId;
        IF (ratingCheck IS NULL) THEN
            UPDATE album SET album.rating = 0 WHERE album.id = NEW.albumId;
        END IF;

	IF (totalNotes > 1) THEN
		UPDATE album SET album.rating = ROUND(((((album.rating*totalNotes) - OLD.note) + NEW.note) / totalNotes), 2) WHERE album.id = NEW.albumId;
	ELSE
		UPDATE album SET album.rating = NEW.note WHERE album.id = NEW.albumId;
	END IF;

END;;

CREATE TRIGGER `updateRatingDelete` AFTER DELETE ON `ranking` FOR EACH ROW
BEGIN
	DECLARE totalNotes integer;
    SET totalNotes = countNotes(OLD.albumId);
	UPDATE album SET album.rating = ROUND((((album.rating * totalNotes) - OLD.note) / totalNotes-1), 2) WHERE album.id = OLD.albumId;
END;;

DELIMITER ;

DROP TABLE IF EXISTS `review`;
CREATE TABLE `review` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `userId` int unsigned NOT NULL,
  `albumId` int unsigned NOT NULL,
  `wording` varchar(5000) NOT NULL,
  `title` varchar(50) NOT NULL,
  `creationDate` date NOT NULL,
  PRIMARY KEY (`id`,`userId`,`albumId`),
  KEY `userId` (`userId`),
  KEY `albumId` (`albumId`),
  CONSTRAINT `review_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `useraccount` (`id`),
  CONSTRAINT `review_ibfk_2` FOREIGN KEY (`albumId`) REFERENCES `album` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `review` (`id`, `userId`, `albumId`, `wording`, `title`, `creationDate`) VALUES
(1,	1,	1,	'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sit amet dolor in lacus aliquam blandit. Nulla justo mauris, tempus nec porttitor nec, convallis sit amet ex. Maecenas dapibus ornare tristique. Etiam vehicula mauris id est dictum, in auctor urna tincidunt. Donec ante purus, pretium eu enim ac, iaculis rutrum magna. Sed imperdiet ante nec dignissim malesuada. Vivamus feugiat nisi in pellentesque dignissim. Praesent in nulla ut leo semper laoreet. Suspendisse lacinia laoreet porta. Proin magna ligula, pellentesque nec lorem lobortis, vehicula sagittis lacus. Phasellus id imperdiet nibh. Nunc bibendum arcu id odio imperdiet tincidunt. Aliquam at rhoncus libero. Morbi imperdiet magna vitae tellus dapibus, vitae ultricies justo luctus. Fusce varius metus a mollis interdum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nullam eu nulla sed dolor sollicitudin mollis congue tincidunt velit. Nunc nunc orci, tempus varius velit nec.',	'Lorem ipsum dolor sit amet, consectetur adipiscing',	'2020-01-07'),
(2,	1,	3,	'Mauris pretium venenatis leo, a pellentesque neque placerat vitae. Fusce sagittis urna id tellus tempus, id lacinia elit placerat. Ut semper, ante quis vulputate tempus, ex enim pellentesque purus, a imperdiet sapien risus quis tellus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis ornare id augue vel placerat. Nunc vehicula faucibus neque id egestas. Integer lacinia ante ac nibh vestibulum, quis placerat urna faucibus. Aenean molestie, nisl id laoreet fermentum, ante justo pharetra nisl, vitae ullamcorper dui risus quis quam. Maecenas varius interdum justo at euismod. Nam pretium consequat accumsan. Integer aliquam eros tempor lorem lobortis lobortis. Nullam feugiat metus quis velit sodales, ut pretium magna luctus. Aenean suscipit, turpis non condimentum iaculis, ex nulla venenatis velit, dapibus fringilla velit ex vel quam. Curabitur consequat, nisl vitae venenatis convallis, urna mauris dapibus massa, quis viverra nulla massa morbi.',	'Lorem ipsum dolor sit amet, consectetur adipiscing',	'2020-02-13'),
(3,	1,	5,	'Vestibulum metus mi, eleifend nec gravida nec, egestas nec magna. Quisque aliquam libero nec placerat sodales. Proin lobortis orci vulputate odio blandit porta. Phasellus pellentesque velit et tincidunt dictum. Aliquam erat volutpat. In quis tellus nisl. Sed euismod quis felis vel venenatis. Donec ligula diam, volutpat eu dui eu, dignissim sodales orci. In ut mollis ante. Sed mollis orci vitae tincidunt rutrum. Sed condimentum et metus nec hendrerit. Ut dignissim massa at tortor condimentum malesuada ut ut magna. Cras porta, eros in laoreet molestie, nibh ex gravida justo, a rutrum tellus ante pellentesque mi. Cras eu mattis augue, id porttitor libero.',	'Lorem ipsum dolor sit amet, consectetur adipiscing',	'2020-09-29'),
(5,	1,	9,	'Sed ac vehicula lorem, vel convallis ex. Fusce tincidunt urna leo, ut cursus felis porta ac. Curabitur tempor porttitor convallis. Vivamus eget malesuada justo, nec iaculis mi. Fusce vulputate augue sit amet ullamcorper sodales. Nam placerat diam dapibus eros maximus, sit amet posuere neque malesuada. Curabitur elementum egestas enim. Suspendisse venenatis consectetur turpis tortor.',	'Lorem ipsum dolor sit amet, consectetur adipiscing',	'2020-08-11'),
(6,	2,	1,	'Etiam a nunc elit. Praesent eget est ut lacus fermentum ultrices. Etiam vehicula, ligula eu imperdiet posuere, tellus tortor aliquam massa, id tincidunt turpis libero sit amet augue. Fusce a malesuada est, a feugiat turpis. Fusce ac congue velit, sit amet convallis lectus. Vestibulum blandit euismod lorem vel faucibus. Pellentesque ut magna vulputate, sollicitudin nunc quis, ornare orci. Suspendisse in lacinia orci. Proin finibus, turpis quis tempus consequat, ipsum est tempus lacus, non gravida sem dui sit amet elit. Pellentesque faucibus libero in tortor sodales, vitae ultricies mauris viverra. Maecenas in magna nec turpis interdum bibendum hendrerit at arcu. Vivamus tortor lectus, fermentum nec convallis ac, vulputate ut mi. In ornare volutpat felis, vitae molestie nulla ultrices non. Integer consequat nec mauris ac congue. Nulla condimentum at augue id vestibulum.',	'Lorem ipsum dolor sit amet, consectetur adipiscing',	'2020-01-12'),
(7,	2,	10,	'Nam turpis magna, accumsan sed blandit vitae, bibendum ac eros. Sed facilisis ultricies magna, nec congue leo mattis vel. In hac habitasse platea dictumst. Nullam vestibulum turpis et magna imperdiet, non dignissim sapien tincidunt. Nunc eget consequat sem. Mauris sit amet euismod dolor. Integer efficitur tempor tempor. Vivamus sit amet accumsan metus. Ut scelerisque dapibus efficitur. Nunc facilisis libero in interdum tempor. Aliquam vehicula efficitur nisi sed luctus. Proin aliquet, ligula et venenatis tincidunt, tellus mauris mattis dui, eget auctor lorem tellus sed lectus. Morbi turpis orci, blandit vel tempor ac, laoreet sed magna. Proin molestie sem quis volutpat viverra. Suspendisse tortor lacus, ultricies ut scelerisque vitae, convallis ac dolor. Donec fermentum eu arcu a condimentum.',	'Lorem ipsum dolor sit amet, consectetur adipiscing',	'2020-06-30'),
(8,	3,	2,	'Mauris id mollis purus. Integer id hendrerit dui. Aenean convallis diam in ex efficitur, ac laoreet nunc tincidunt. Praesent nec placerat odio, id lacinia mauris. Suspendisse quis rhoncus accumsan.',	'Lorem ipsum dolor sit amet, consectetur adipiscing',	'2020-08-09'),
(9,	3,	4,	'Nullam tincidunt dui a gravida commodo. Duis gravida elit eu libero fermentum imperdiet in ac massa. Aenean scelerisque justo ac velit molestie vulputate. Aenean vulputate felis nulla, sed interdum risus pretium ac. Nullam auctor nulla vel nibh pretium sollicitudin. Maecenas massa diam, vehicula eu ullamcorper porta, lacinia in arcu. Suspendisse commodo faucibus ex volutpat interdum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla ut diam mattis, tincidunt lacus sed, consectetur nisl. Morbi vestibulum risus pellentesque leo ullamcorper, vel imperdiet orci dictum. Integer malesuada enim vitae risus volutpat, ultrices auctor arcu lobortis. Donec vestibulum velit mauris, vitae vestibulum lectus eleifend quis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aliquam sed venenatis leo.',	'Lorem ipsum dolor sit amet, consectetur adipiscing',	'2020-10-05'),
(10,	3,	6,	'Cras lobortis auctor urna eu dictum. Donec rhoncus mi commodo turpis euismod, in lacinia est dictum. Suspendisse ac.',	'Lorem ipsum dolor sit amet, consectetur adipiscing',	'2020-03-17'),
(11,	4,	8,	'Vivamus nec iaculis urna. Proin tincidunt non urna eget placerat. Pellentesque placerat id leo in tempus. Nam quis erat sit amet lectus lacinia cursus. Aliquam nec elementum ipsum, eu semper diam. In mollis massa nibh, in pharetra orci porta eu. Phasellus fermentum dolor at est placerat, quis tristique justo sodales. Proin quis malesuada justo. Etiam vulputate dapibus nulla, non semper dolor ultrices non. Morbi eget mauris sed purus blandit volutpat. Donec ultricies nunc molestie elit fermentum pharetra.',	'Lorem ipsum dolor sit amet, consectetur adipiscing',	'2019-12-13'),
(12,	5,	1,	'Mauris pulvinar condimentum mi, in ultrices nisl semper at. Curabitur purus elit, auctor vel congue ut, fermentum posuere nisl. Sed nec quam sit amet ipsum rhoncus posuere. Donec rutrum lacinia augue, vitae ultricies erat commodo eu. Aliquam quis ipsum rhoncus, eleifend urna a, dictum massa. In nec consectetur libero. Proin vitae egestas velit, a varius ipsum. Maecenas feugiat vitae urna ut tempor. Nunc non elit pharetra, vestibulum magna ac, pharetra mauris. Nunc ultrices pulvinar nec.',	'Lorem ipsum dolor sit amet, consectetur adipiscing',	'2020-04-17'),
(13,	5,	5,	'Phasellus elementum quis dui vel congue. Aenean sit amet ipsum eget lectus volutpat volutpat. Maecenas egestas mi hendrerit enim condimentum fringilla. Donec placerat magna finibus lectus posuere ornare. Duis efficitur elit dui, eget pretium dui egestas in. Suspendisse porttitor placerat erat at faucibus. Duis ac suscipit mauris, ut sagittis mauris. Etiam pellentesque, nulla nec convallis commodo, sem neque ullamcorper quam, vitae rhoncus lectus nibh vel erat. Donec quis quam a eros ultricies tristique non id arcu. Praesent hendrerit neque eros, in commodo nisl accumsan sit amet. Aliquam faucibus vitae nunc quis congue. Suspendisse dapibus pretium nisi a porttitor. Vestibulum ut risus vel risus fringilla consectetur vitae aliquet arcu. Curabitur a bibendum sem. Aliquam at pellentesque ligula.',	'Lorem ipsum dolor sit amet, consectetur adipiscing',	'2019-11-07'),
(14,	5,	10,	'Nullam pharetra ligula eu velit porttitor tincidunt. Mauris sed sapien eu magna blandit fringilla ac id leo. Vivamus cursus ipsum vitae viverra maximus. Cras eleifend nulla ac magna lobortis proin.',	'Lorem ipsum dolor sit amet, consectetur adipiscing',	'2020-07-14'),
(16,	1,	7,	'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean elit odio, laoreet placerat feugiat a, laoreet et urna. Nulla sit amet pharetra nibh. Phasellus eu est interdum, vulputate lacus ac, auctor ante. Praesent ut leo a metus auctor tempus. Fusce dignissim eget ante id molestie. Duis sit amet nunc nec quam fermentum iaculis. Curabitur ac euismod lectus.aaa',	'This is a random title for my review',	'2020-05-16'),
(17,	2,	7,	'Praesent ac scelerisque tortor. Proin felis libero, ultrices eget rhoncus vitae, pulvinar quis orci. Integer imperdiet metus ut augue ornare, at suscipit orci tempor. Vivamus ac placerat sem. Nulla hendrerit augue a molestie convallis. Mauris sollicitudin elit a arcu placerat accumsan. Curabitur eget mollis erat, ut ultricies nunc. Fusce cursus, risus et sollicitudin volutpat, lectus ex euismod nisi, at auctor leo eros id arcu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Ut vitae turpis venenatis, volutpat justo quis, vehicula odio. Suspendisse ac urna a mauris dictum iaculis. Nulla a ultricies velit. Morbi dictum felis et consectetur efficitur. Fusce vel volutpat elit. Curabitur accumsan orci sem, eu auctor orci finibus nec. Donec consectetur sagittis imperdiet.',	'Lorem ipsum dolor sit amet, consectetur adipiscing',	'2020-06-14'),
(18,	1,	8,	'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla et ultricies eros. Maecenas et luctus mauris, in sodales dolor. Vestibulum porttitor interdum arcu id blandit. Donec eget urna velit. Proin ullamcorper iaculis suscipit. Nam nisi tortor, tempus sed varius quis, gravida ut eros. Proin at eros fermentum odio varius tempus ac ut quam. Maecenas pharetra fringilla sagittis. Ut tellus velit, tristique vitae finibus sit amet, tempor non felis.',	'Crítica genérica para paris',	'0000-00-00'),
(19,	1,	6,	'This album is really amazing... This album is really amazing... This album is really amazing... This album is really amazing... This album is really amazing... This album is really amazing... This album is really amazing... This album is really amazing... This album is really amazing... This album is really amazing... This album is really amazing... ',	'This is amazing',	'2020-10-23');

DROP TABLE IF EXISTS `reviewrating`;
CREATE TABLE `reviewrating` (
  `state` enum('That is it','Kind of','Not quite') NOT NULL,
  `userId` int unsigned NOT NULL,
  `reviewId` int unsigned NOT NULL,
  PRIMARY KEY (`userId`,`reviewId`),
  KEY `reviewId` (`reviewId`),
  CONSTRAINT `reviewrating_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `useraccount` (`id`),
  CONSTRAINT `reviewrating_ibfk_2` FOREIGN KEY (`reviewId`) REFERENCES `review` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `statusalbum`;
CREATE TABLE `statusalbum` (
  `state` enum('none','wanting','waiting','dumped','completed') NOT NULL DEFAULT 'none',
  `userId` int unsigned NOT NULL,
  `albumId` int unsigned NOT NULL,
  PRIMARY KEY (`userId`,`albumId`),
  KEY `albumId` (`albumId`),
  CONSTRAINT `statusalbum_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `useraccount` (`id`),
  CONSTRAINT `statusalbum_ibfk_2` FOREIGN KEY (`albumId`) REFERENCES `album` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `statusalbum` (`state`, `userId`, `albumId`) VALUES
('completed',	1,	1),
('completed',	1,	2),
('wanting',	1,	3),
('completed',	1,	4),
('completed',	1,	5),
('completed',	1,	6),
('completed',	1,	7),
('completed',	1,	8),
('completed',	1,	9),
('dumped',	1,	10),
('completed',	1,	12),
('dumped',	2,	1),
('completed',	2,	2),
('completed',	2,	3),
('completed',	2,	4),
('dumped',	2,	5),
('completed',	2,	6),
('completed',	2,	7),
('completed',	2,	8),
('completed',	2,	9),
('completed',	2,	10),
('completed',	2,	15),
('completed',	3,	1),
('completed',	3,	2),
('completed',	3,	3),
('dumped',	3,	4),
('completed',	3,	5),
('completed',	3,	6),
('completed',	3,	7),
('completed',	3,	8),
('completed',	3,	9),
('completed',	3,	10),
('completed',	4,	1),
('dumped',	4,	2),
('completed',	4,	3),
('completed',	4,	4),
('completed',	4,	5),
('completed',	4,	6),
('completed',	4,	7),
('dumped',	4,	8),
('completed',	4,	9),
('completed',	4,	10),
('completed',	5,	1),
('completed',	5,	2),
('completed',	5,	3),
('dumped',	5,	4),
('completed',	5,	5),
('dumped',	5,	6),
('completed',	5,	7),
('dumped',	5,	8),
('completed',	5,	9),
('completed',	5,	10);

DROP TABLE IF EXISTS `studio`;
CREATE TABLE `studio` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `summary` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `studio` (`id`, `name`, `summary`) VALUES
(1,	'North America Studios',	'A studio created in North America focused in all genres.'),
(2,	'Europe Studios',	'A studio created in Europe focused in all genres.'),
(3,	'Asia Studios',	'A studio created in Japan focused in all genres.'),
(4,	'South America Studios',	'A studio created in Brazil focused in all genres.'),
(5,	'Australia Studios',	'A studio created in Australia focused in all genres.'),
(6,	'EMI',	'Abbey Road Studios (formerly EMI Recording Studios) is a recording studio at 3 Abbey Road, St John\'s Wood, City of Westminster, London, England.'),
(7,	'Olympic Studios',	'Olympic Sound Studios was an independent commercial recording studio in London, best known for the many rock, pop and sound stage recordings made during late 1960s onwards.'),
(8,	'Trident Studios',	'Trident Studios was a British recording facility, located at 17 St Anne\'s Court in London\'s Soho district between 1968 and 1981.'),
(9,	'Hard2Beat Records',	'Dance Nation was a British independent record label which was a subsidiary of Ministry of Sound. When founded in 2007 it was known as Hard2Beat Records, and was rebranded to its current name in 2010.'),
(10,	'Studio 13',	'Studio 13 is a truly unique studio in the heart of West London. It is the centrepiece studio in a creative hub housing some of the UK\'s top producers.');

DROP TABLE IF EXISTS `studioalbum`;
CREATE TABLE `studioalbum` (
  `studioId` int unsigned NOT NULL,
  `albumId` int unsigned NOT NULL,
  PRIMARY KEY (`studioId`,`albumId`),
  KEY `albumId` (`albumId`),
  CONSTRAINT `studioalbum_ibfk_1` FOREIGN KEY (`studioId`) REFERENCES `studio` (`id`),
  CONSTRAINT `studioalbum_ibfk_2` FOREIGN KEY (`albumId`) REFERENCES `album` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `studioalbum` (`studioId`, `albumId`) VALUES
(1,	1),
(3,	2),
(4,	3),
(5,	4),
(4,	5),
(5,	6),
(3,	7),
(2,	8),
(2,	9),
(1,	10),
(6,	11),
(7,	12),
(8,	12),
(9,	13),
(10,	14),
(10,	15);

DROP TABLE IF EXISTS `useraccount`;
CREATE TABLE `useraccount` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `creationDate` date NOT NULL,
  `accessLevel` enum('basic','special') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `useraccount` (`id`, `username`, `password`, `email`, `creationDate`, `accessLevel`) VALUES
(1,	'user1',	'123',	'user1@email.com',	'2020-07-02',	'basic'),
(2,	'user2',	'123',	'user2@email.com',	'2020-07-02',	'basic'),
(3,	'user3',	'123',	'user3@email.com',	'2020-07-02',	'basic'),
(4,	'user4',	'123',	'user4@email.com',	'2020-07-02',	'basic'),
(5,	'user5',	'123',	'user5@email.com',	'2020-07-02',	'basic');

-- 2020-11-04 20:20:55