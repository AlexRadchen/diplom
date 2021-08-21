-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Авг 22 2021 г., 02:55
-- Версия сервера: 8.0.24
-- Версия PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mega8_radchenko`
--

-- --------------------------------------------------------

--
-- Структура таблицы `acts`
--

CREATE TABLE `acts` (
  `id` int NOT NULL,
  `admin` int NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `date` int NOT NULL,
  `modif` int NOT NULL,
  `client` int NOT NULL,
  `tahograf` int NOT NULL,
  `firma` varchar(255) NOT NULL,
  `unp` int NOT NULL,
  `okpo` int NOT NULL,
  `adr` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `bank_bik` varchar(20) NOT NULL,
  `bank_rs` varchar(30) NOT NULL,
  `dog_num` varchar(15) NOT NULL,
  `dog_date` int NOT NULL,
  `marka` varchar(50) NOT NULL COMMENT 'марка авто',
  `model` varchar(50) NOT NULL COMMENT 'модель авто',
  `auto_num` varchar(10) NOT NULL COMMENT 'гос.номер',
  `vin` varchar(30) NOT NULL COMMENT 'номер кузова',
  `name` varchar(100) NOT NULL COMMENT 'марка тахометра',
  `num` varchar(50) NOT NULL COMMENT 'номер тахометра',
  `k` varchar(20) NOT NULL,
  `odometr` int NOT NULL,
  `type` varchar(30) NOT NULL,
  `w` varchar(20) NOT NULL,
  `len` varchar(20) NOT NULL,
  `products` varchar(300) NOT NULL,
  `kols` varchar(300) NOT NULL,
  `prices` varchar(300) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `date` int NOT NULL,
  `modif` int NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` int NOT NULL COMMENT 'тип учетной записи',
  `level` int NOT NULL COMMENT 'статус вкл/откл'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `date`, `modif`, `name`, `email`, `pass`, `phone`, `type`, `level`) VALUES
(1, 1627737527, 1627750783, 'Радченко А.П.', 'al.rad4@yandex.by', 'bc1f1de4e6a5a4344a9ff5365', '+375295987636', 0, 1),
(2, 1627739527, 1627739623, 'Бухгалтер И.И.', 'none@mail.ru', '3878d328fbcd64ec1c32998c4', '', 0, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `auto`
--

CREATE TABLE `auto` (
  `id` int NOT NULL,
  `date` int DEFAULT NULL,
  `modif` int DEFAULT NULL,
  `client` int DEFAULT NULL,
  `marka` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `model` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `num` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'гос.номер ',
  `vin` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `zam` text CHARACTER SET utf8 COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE `clients` (
  `id` int NOT NULL,
  `date` int DEFAULT NULL,
  `modif` int DEFAULT NULL,
  `firma` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `unp` int DEFAULT NULL,
  `okpo` int DEFAULT NULL,
  `adr` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `zam` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'заметки',
  `bank` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_bik` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_rs` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `dog_num` int DEFAULT NULL COMMENT 'номер договора',
  `dog_date` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `date` int NOT NULL,
  `modif` int NOT NULL,
  `type` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `kol` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `date`, `modif`, `type`, `name`, `price`, `kol`) VALUES
(1, 1627758787, 1627814378, '1', 'Установка параметров цифрового тахографа', 77.26, 0),
(2, 1627758932, 1627814385, '1', 'Замена батареи', 7.73, 0),
(3, 1627758975, 1627758989, '0', 'Пломба колпачковая', 1.46, 0),
(4, 1627814424, 1627814437, '0', 'батарея LI 3,6V 1.1AH DTCO A2C59511954', 28.13, 0),
(5, 1627814443, 0, '0', '', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `tahograf`
--

CREATE TABLE `tahograf` (
  `id` int NOT NULL,
  `date` int DEFAULT NULL,
  `modif` int DEFAULT NULL,
  `auto` int DEFAULT NULL,
  `name` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `num` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'серийный номер',
  `k` int DEFAULT NULL,
  `odometr` int DEFAULT NULL,
  `type` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'тип шины',
  `len` double DEFAULT NULL COMMENT 'длина окружности колеса	',
  `w` int DEFAULT NULL COMMENT 'передаточное число',
  `level` int DEFAULT NULL COMMENT 'статус',
  `zam` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'заметки'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `acts`
--
ALTER TABLE `acts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `auto`
--
ALTER TABLE `auto`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tahograf`
--
ALTER TABLE `tahograf`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `acts`
--
ALTER TABLE `acts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `auto`
--
ALTER TABLE `auto`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `tahograf`
--
ALTER TABLE `tahograf`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
