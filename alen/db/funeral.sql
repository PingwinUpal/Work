-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 18 2024 г., 23:51
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `funeral`
--

-- --------------------------------------------------------

--
-- Структура таблицы `funeral_agencies`
--

CREATE TABLE `funeral_agencies` (
  `id` int(11) NOT NULL,
  `name_agency` text NOT NULL,
  `services` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`services`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `funeral_agencies`
--

INSERT INTO `funeral_agencies` (`id`, `name_agency`, `services`) VALUES
(1, 'Ритуальное Агентство 1', '{\n  \"additional_services\": [\n    {\n      \"id\": 1,\n      \"name\": \"Услуга 1\",\n      \"price\": 3000\n    },\n    {\n      \"id\": 2,\n      \"name\": \"Услуга 2\",\n      \"price\": 1500\n    },\n    {\n      \"id\": 3,\n      \"name\": \"Услуга 3\",\n      \"price\": 500\n    },\n    {\n      \"id\": 4,\n      \"name\": \"Услуга 4\",\n      \"price\": 15000\n    }\n  ]\n}'),
(2, 'Ритуальное Агентство 2', '{\n  \"additional_services\": [\n    {\n      \"id\": 1,\n      \"name\": \"Услуга 1\",\n      \"price\": 5000\n    },\n    {\n      \"id\": 2,\n      \"name\": \"Услуга 2\",\n      \"price\": 1300\n    },\n    {\n      \"id\": 3,\n      \"name\": \"Услуга 3\",\n      \"price\": 200\n    }\n  ]\n}'),
(3, 'Ритуальное Агентство 3', '{\r\n  \"additional_services\": [\r\n    {\r\n      \"id\": 1,\r\n      \"name\": \"Услуга 1\",\r\n      \"price\": 1000\r\n    },\r\n    {\r\n      \"id\": 2,\r\n      \"name\": \"Услуга 2\",\r\n      \"price\": 5000\r\n    },\r\n    {\r\n      \"id\": 3,\r\n      \"name\": \"Услуга 3\",\r\n      \"price\": 1500\r\n    },\r\n    {\r\n      \"id\": 4,\r\n      \"name\": \"Услуга 4\",\r\n      \"price\": 1000\r\n    },\r\n    {\r\n      \"id\": 5,\r\n      \"name\": \"Услуга 5\",\r\n      \"price\": 8900\r\n    }\r\n  ]\r\n}'),
(4, 'Ритуальное Агентство 4', '{\r\n  \"additional_services\": [\r\n    {\r\n      \"id\": 1,\r\n      \"name\": \"Услуга 1\",\r\n      \"price\": 8000\r\n    },\r\n    {\r\n      \"id\": 2,\r\n      \"name\": \"Услуга 2\",\r\n      \"price\": 1000\r\n    }\r\n  ]\r\n}');

-- --------------------------------------------------------

--
-- Структура таблицы `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_funeral` int(11) NOT NULL,
  `services` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `requests`
--

INSERT INTO `requests` (`id`, `id_client`, `id_funeral`, `services`) VALUES
(1, 1, 1, '1,3,4'),
(2, 1, 3, '1,3,5'),
(3, 1, 4, '1');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `fullname` text NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `fullname`, `email`) VALUES
(1, 'asd', '$2y$10$JVUOe62FPo.XuOGtQtAPh.A3dRSVFMnNUfRj3mahOnU4XUOjxLSQ2', 'Пупкин Василий Васильевич', 'asd@asd.ru');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `funeral_agencies`
--
ALTER TABLE `funeral_agencies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `funeral_agencies`
--
ALTER TABLE `funeral_agencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
