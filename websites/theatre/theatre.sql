-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 14 2017 г., 16:06
-- Версия сервера: 5.5.53
-- Версия PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `theatre`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(20) NOT NULL,
  `price` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `price`) VALUES
(1, 'амфитеатр', '170.00'),
(2, 'партер', '200.00'),
(3, 'балкон', '300.00'),
(4, 'ложа балкона левая', '250.00'),
(5, 'ложа балкона правая', '250.00'),
(6, 'ложа бельэтаж', '400.00');

-- --------------------------------------------------------

--
-- Структура таблицы `order_information`
--

CREATE TABLE `order_information` (
  `information_id` int(11) NOT NULL,
  `information_name` varchar(255) NOT NULL,
  `information_value` varchar(255) NOT NULL,
  `information_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order_information`
--

INSERT INTO `order_information` (`information_id`, `information_name`, `information_value`, `information_desc`) VALUES
(1, 'max_ordered', '5', 'Максимальное количество покупки билетов');

-- --------------------------------------------------------

--
-- Структура таблицы `order_status`
--

CREATE TABLE `order_status` (
  `order_status_id` int(2) NOT NULL,
  `order_status_name` varchar(20) NOT NULL,
  `order_status_availability` varchar(20) NOT NULL,
  `order_status_hint` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order_status`
--

INSERT INTO `order_status` (`order_status_id`, `order_status_name`, `order_status_availability`, `order_status_hint`) VALUES
(1, 'В обработке', 'NA', 'Заказ ожидает обработки менеджером'),
(2, 'Активен', 'NA', 'Заказ подтвержден'),
(3, 'Отозван', '', 'Заказ отменен по желанию клиента либо решению администрации театра'),
(4, 'Закрыт', '', 'Мероприятие по данному заказу уже прошло');

-- --------------------------------------------------------

--
-- Структура таблицы `seat`
--

CREATE TABLE `seat` (
  `seat_id` int(11) NOT NULL,
  `seat_row` int(2) NOT NULL,
  `seat_number` int(2) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `seat`
--

INSERT INTO `seat` (`seat_id`, `seat_row`, `seat_number`, `category_id`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 1, 4, 1),
(5, 1, 5, 1),
(6, 1, 6, 1),
(7, 1, 7, 1),
(8, 1, 8, 1),
(9, 1, 9, 1),
(10, 1, 10, 1),
(11, 1, 11, 1),
(12, 1, 12, 1),
(13, 2, 1, 1),
(14, 2, 2, 1),
(15, 2, 3, 1),
(16, 2, 4, 1),
(17, 2, 5, 1),
(18, 2, 6, 1),
(19, 2, 7, 1),
(20, 2, 8, 1),
(21, 2, 9, 1),
(22, 2, 10, 1),
(23, 2, 11, 1),
(24, 2, 12, 1),
(25, 3, 1, 1),
(26, 3, 2, 1),
(27, 3, 3, 1),
(28, 3, 4, 1),
(29, 3, 5, 1),
(30, 3, 6, 1),
(31, 3, 7, 1),
(32, 3, 8, 1),
(33, 3, 9, 1),
(34, 3, 10, 1),
(35, 3, 11, 1),
(36, 3, 12, 1),
(37, 4, 1, 1),
(38, 4, 2, 1),
(39, 4, 3, 1),
(40, 4, 4, 1),
(41, 4, 5, 1),
(42, 4, 6, 1),
(43, 4, 7, 1),
(44, 4, 8, 1),
(45, 4, 9, 1),
(46, 4, 10, 1),
(47, 4, 11, 1),
(48, 4, 12, 1),
(49, 1, 1, 2),
(50, 1, 2, 2),
(51, 1, 3, 2),
(52, 1, 4, 2),
(53, 1, 5, 2),
(54, 1, 6, 2),
(55, 1, 7, 2),
(56, 1, 8, 2),
(57, 1, 9, 2),
(58, 1, 10, 2),
(59, 1, 11, 2),
(60, 1, 12, 2),
(61, 2, 1, 2),
(62, 2, 2, 2),
(63, 2, 3, 2),
(64, 2, 4, 2),
(65, 2, 5, 2),
(66, 2, 6, 2),
(67, 2, 7, 2),
(68, 2, 8, 2),
(69, 2, 9, 2),
(70, 2, 10, 2),
(71, 2, 11, 2),
(72, 2, 12, 2),
(73, 3, 1, 2),
(74, 3, 2, 2),
(75, 3, 3, 2),
(76, 3, 4, 2),
(77, 3, 5, 2),
(78, 3, 6, 2),
(79, 3, 7, 2),
(80, 3, 8, 2),
(81, 3, 9, 2),
(82, 3, 10, 2),
(83, 3, 11, 2),
(84, 3, 12, 2),
(85, 1, 1, 3),
(86, 1, 2, 3),
(87, 1, 3, 3),
(88, 1, 4, 3),
(89, 1, 5, 3),
(90, 1, 6, 3),
(91, 1, 7, 3),
(92, 1, 8, 3),
(93, 1, 9, 3),
(94, 1, 10, 3),
(95, 1, 1, 4),
(96, 1, 2, 4),
(97, 1, 3, 4),
(98, 1, 4, 4),
(99, 1, 5, 4),
(100, 1, 6, 4),
(103, 1, 1, 5),
(104, 1, 2, 5),
(105, 1, 3, 5),
(106, 1, 4, 5),
(107, 1, 5, 5),
(108, 1, 6, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `order_name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL,
  `order_status_id` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `order_name`, `user_id`, `seat_id`, `order_status_id`) VALUES
(2, '1503490434_11', 11, 4, 2),
(3, '1503490434_11', 11, 19, 1),
(4, '1503490434_11', 11, 33, 3),
(5, '1503490434_11', 11, 44, 1),
(11, '1503490764_13', 13, 16, 1),
(12, '1503490764_13', 13, 28, 3),
(13, '1503490822_14', 14, 2, 3),
(14, '1503490896_15', 15, 3, 1),
(15, '1503490896_15', 15, 5, 1),
(16, '1503490896_15', 15, 6, 1),
(17, '1503490896_15', 15, 7, 1),
(18, '1503493156_11', 11, 8, 1),
(19, '1505390629_1', 1, 42, 3),
(20, '1505390629_1', 1, 43, 3),
(21, '1505390692_16', 16, 33, 1),
(22, '1505390692_16', 16, 34, 1),
(23, '1505390692_16', 16, 45, 1),
(24, '1505394317_1', 1, 80, 1),
(25, '1505394317_1', 1, 81, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `login` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(64) NOT NULL,
  `name` varchar(32) NOT NULL,
  `surname` varchar(64) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`user_id`, `login`, `password`, `phone`, `email`, `name`, `surname`, `type`) VALUES
(1, 'admin', 'admin', '0', 'admin@mail.com', 'maxim', '', 'admin'),
(4, 'asdasdasd', 'asdasdasd', '0', 'asd@asdasd', '', '', 'user'),
(5, 'asdasd', 'asdasd', '0', 'asd@asd', '', '', 'user'),
(6, 'newuser', 'newuser', '0', 'new@user', '', '', 'user'),
(7, 'user1111', 'user1111', '0', 'user@1111', '', '', 'user'),
(8, 'user1234', 'user1234', '0', 'user@1234', '', '', 'user'),
(9, 'user2222', 'user2222', '0', 'user@2222', '', '', 'user'),
(10, 'newuser123', 'newuser123', '0', 'newuser@123', '', '', 'user'),
(11, 'newnewuser', 'newnewuser', '0635600426', 'newnew@user.comic', 'Maxim', 'Maxim', 'user'),
(12, 'papapam', 'papapam', '0', 'papapa@m', '', '', 'user'),
(13, 'fuberge', 'fuberge', '0', 'fuber@ge', '', '', 'user'),
(14, 'userous', 'userous', '0', 'user@ous', '', '', 'user'),
(15, 'olololo', 'olololo', '0', 'olo@lo', '', '', 'user'),
(16, 'markopolo', 'markopolo', '', 'marko@polo', '', '', 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Индексы таблицы `order_information`
--
ALTER TABLE `order_information`
  ADD PRIMARY KEY (`information_id`);

--
-- Индексы таблицы `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`order_status_id`);

--
-- Индексы таблицы `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`seat_id`);

--
-- Индексы таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `order_information`
--
ALTER TABLE `order_information`
  MODIFY `information_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `order_status`
--
ALTER TABLE `order_status`
  MODIFY `order_status_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `seat`
--
ALTER TABLE `seat`
  MODIFY `seat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
--
-- AUTO_INCREMENT для таблицы `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
