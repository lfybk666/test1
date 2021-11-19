-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 19 2021 г., 19:51
-- Версия сервера: 8.0.24
-- Версия PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `database`
--

-- --------------------------------------------------------

--
-- Структура таблицы `accounts`
--

CREATE TABLE `accounts` (
  `login` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `sex` varchar(6) NOT NULL,
  `date_of_birth` date NOT NULL,
  `id` int NOT NULL,
  `del` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `accounts`
--

INSERT INTO `accounts` (`login`, `password`, `first_name`, `last_name`, `sex`, `date_of_birth`, `id`, `del`) VALUES
('admin', 'admin', '', '', '', '2021-11-19', 1, 1),
('danil', 'danil', 'danil', 'danil', 'male', '2021-11-01', 2, 0),
('danil1', 'danil1', 'danil1', 'danil1', 'female', '2021-11-02', 3, 0),
('danil2', 'danil2', 'danil2', 'danil2', 'male', '2021-11-03', 6, 0),
('danil3', 'danil3', 'danil3', 'danil3', 'female', '2021-11-04', 7, 0),
('danil4', 'danil4', 'danil4', 'danil4', 'male', '2021-11-05', 8, 0),
('danil5', 'danil5', 'danil5', 'danil5', 'female', '2021-11-06', 9, 0),
('danil6', 'danil6', 'danil6', 'danil6', 'male', '2021-11-07', 10, 0),
('danil7', 'danil7', 'danil7', 'danil7', 'female', '2021-11-08', 11, 0),
('danil9', 'danil9', 'danil9', 'danil9', 'male', '2021-11-10', 14, 0),
('danil10', 'danil10', 'danil10', 'danil10', 'female', '2021-11-11', 15, 0),
('danil11', 'danil11', 'danil11', 'danil11', 'male', '2021-11-12', 16, 0),
('danil12', 'danil12', 'danil12', 'danil12', 'female', '2021-11-13', 17, 0),
('danil13', 'danil13', 'danil13', 'danil13', 'male', '2021-11-14', 18, 0),
('danil14', 'danil14', 'danil14', 'danil14', 'female', '2021-11-15', 19, 0),
('danil15', 'danil15', 'danil15', 'danil15', 'male', '2021-11-16', 20, 0),
('danil16', 'danil16', 'danil16', 'danil16', 'female', '2021-11-17', 21, 0),
('danil17', 'danil17', 'danil17', 'danil17', 'male', '2021-11-18', 22, 0),
('danil18', 'danil18', 'danil18', 'danil18', 'female', '2011-11-01', 23, 0),
('danil19', 'danil19', 'danil19', 'danil19', 'male', '2021-11-20', 24, 1),
('danil25', 'danil25', 'danil25', 'danil25', 'male', '2021-11-20', 25, 0),
('danil26', 'danil26', 'danil26', 'danil26', 'male', '2021-11-28', 26, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
