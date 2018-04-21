-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 21 2018 г., 14:00
-- Версия сервера: 5.7.20
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ProjectZodiak`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE `Users` (
  `ID` int(11) UNSIGNED NOT NULL,
  `login` varchar(20) NOT NULL,
  `email` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `birth_date` date NOT NULL,
  `registration_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `zodiak_sign` varchar(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Users`
--

INSERT INTO `Users` (`ID`, `login`, `email`, `password`, `first_name`, `last_name`, `gender`, `birth_date`, `registration_date`, `zodiak_sign`) VALUES
(1, 'first', 'first@first', '8b04d5e3775d298e78455efc5ca404d5', 'First FirstName', 'First SecondName', 'male', '2016-11-15', '2018-04-18 00:00:00', NULL),
(2, '111', '111@111', '111', 'FN111', 'LN111', 'male', '1111-11-11', '2018-04-20 09:08:06', NULL),
(3, '222', '111@111', 'bcbe3365e6ac95ea2c0343a2395834dd', 'FN111', 'LN111', 'male', '1111-11-11', '2018-04-20 09:11:13', NULL),
(4, '333', '333@333', '310dcbbf4cce62f762a2aaa148d556bd', '333', '333', 'male', '1111-11-11', '2018-04-20 12:46:08', NULL),
(5, '444', '333@333', '550a141f12de6341fba65b0ad0433500', '333', '333', '', '1111-11-11', '2018-04-20 13:06:35', NULL),
(6, '555', '555@555', '15de21c670ae7c3f6f3f1f37029303c9', '555', '555', 'female', '1111-11-11', '2018-04-20 13:22:08', NULL),
(7, '666', '555@555', '934b535800b1cba8f96a5d72f72f1611', '555', '555', '', '1111-11-11', '2018-04-20 13:39:32', NULL),
(8, '777', '777@777', 'f1c1592588411002af340cbaedd6fc33', '777', '777', 'male', '1111-11-11', '2018-04-21 13:47:49', 'scorpio'),
(9, '888', '777@777', '0a113ef6b61820daa5611c870ed8d5ee', '777', '777', 'male', '1111-11-11', '2018-04-21 13:49:48', 'scorpio'),
(10, '999', '777@777', '0a113ef6b61820daa5611c870ed8d5ee', '777', '777', '', '1111-11-11', '2018-04-21 13:50:28', 'scorpio'),
(11, '1010', '777@777', '0a113ef6b61820daa5611c870ed8d5ee', '777', '777', 'male', '1111-11-11', '2018-04-21 13:51:24', 'scorpio');

-- --------------------------------------------------------

--
-- Структура таблицы `zodiak_sign`
--

CREATE TABLE `zodiak_sign` (
  `ID` int(11) UNSIGNED NOT NULL,
  `sign` varchar(12) NOT NULL,
  `male` text NOT NULL,
  `female` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `zodiak_sign`
--

INSERT INTO `zodiak_sign` (`ID`, `sign`, `male`, `female`) VALUES
(1, 'aquarius', 'Водолей М\r\n', 'Водолей Ж'),
(5, 'gemini', 'Близнец М', 'Близнец Ж'),
(2, 'pisces', 'Рыбы М', 'Рыбы Ж'),
(3, 'aries', 'Овен М', 'Овен Ж'),
(4, 'taurus', 'Телец М', 'Телец Ж'),
(6, 'cancer', 'Рак М', 'Рак Ж'),
(7, 'leo', 'Лев М', 'Лев Ж'),
(8, 'virgo', 'Дева М', 'Дева Ж'),
(9, 'libra', 'Весы М', 'Весы Ж'),
(10, 'scorpio', 'Скорпион М', 'Скорпион Ж'),
(11, 'sagittarius', 'Стрелец М', 'Стрелец Ж'),
(12, 'capricorn', 'Козерог М', 'Козерог Ж');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Login` (`login`);

--
-- Индексы таблицы `zodiak_sign`
--
ALTER TABLE `zodiak_sign`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Users`
--
ALTER TABLE `Users`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `zodiak_sign`
--
ALTER TABLE `zodiak_sign`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
