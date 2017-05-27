-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 16 2017 г., 12:00
-- Версия сервера: 5.7.16
-- Версия PHP: 5.6.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `poverka_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `devices`
--

CREATE TABLE `devices` (
  `device_id` int(11) NOT NULL,
  `device_list_id` int(11) NOT NULL,
  `device_camera_id` int(11) NOT NULL,
  `device_serial_number` int(11) NOT NULL,
  `device_passport_availability` tinyint(1) NOT NULL,
  `device_certificate_verification_number` int(11) NOT NULL,
  `device_release_year` date NOT NULL,
  `device_date_last_calibration` date NOT NULL,
  `device_date_next_calibration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `devices`
--

INSERT INTO `devices` (`device_id`, `device_list_id`, `device_camera_id`, `device_serial_number`, `device_passport_availability`, `device_certificate_verification_number`, `device_release_year`, `device_date_last_calibration`, `device_date_next_calibration`) VALUES
(1, 2, 4, 1, 1, 4, '2017-03-15', '2017-03-23', 2),
(2, 2, 4, 1, 1, 4, '2017-03-15', '2017-03-23', 2),
(3, 32, 312, 123, 123, 13, '2017-03-07', '2017-03-14', 123);

-- --------------------------------------------------------

--
-- Структура таблицы `devices_date_calibration`
--

CREATE TABLE `devices_date_calibration` (
  `devices_date_calibration_id` int(11) NOT NULL,
  `devices_date_calibration_device_id` int(11) NOT NULL,
  `devices_date_calibration_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `device_list`
--

CREATE TABLE `device_list` (
  `device_list_id` int(11) NOT NULL,
  `device_list_name` text COLLATE utf8_bin NOT NULL,
  `device_list_state_registry_number` int(11) NOT NULL,
  `device_list_accuracy_class` int(11) NOT NULL,
  `device_list_measurement_range` text COLLATE utf8_bin NOT NULL,
  `device_list_periodicity_verification` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `device_list`
--

INSERT INTO `device_list` (`device_list_id`, `device_list_name`, `device_list_state_registry_number`, `device_list_accuracy_class`, `device_list_measurement_range`, `device_list_periodicity_verification`) VALUES
(1, 'fsfsfd', 323, 2323, 'fdfsdfsdf', 123);

-- --------------------------------------------------------

--
-- Структура таблицы `directions`
--

CREATE TABLE `directions` (
  `direction_id` int(11) NOT NULL,
  `direction_name` text COLLATE utf8_bin NOT NULL,
  `direction_stripe_count` int(11) NOT NULL,
  `direction_owner_post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `directions`
--

INSERT INTO `directions` (`direction_id`, `direction_name`, `direction_stripe_count`, `direction_owner_post_id`) VALUES
(1, 'От Обл ГИБДД', 3, 1),
(2, 'От Гор. ГИБДД', 3, 1),
(3, 'От СЗ', 3, 2),
(4, 'От Центра', 3, 2),
(5, 'из СЗ', 2, 3),
(6, 'Из ЧМЗ', 2, 3),
(7, 'от ЧТЗ', 4, 4),
(8, 'от Пл. Революции', 4, 4),
(9, 'от Вокзала', 4, 4),
(10, 'От Коммуны', 3, 4),
(11, 'от Центра', 3, 5),
(12, 'От ЧТЗ', 3, 5),
(13, 'от 40 лет Победы', 3, 6),
(14, 'от Молодогвардейцев', 5, 6),
(15, 'от Ленинского р-на', 3, 7),
(16, 'от Доватора', 3, 7),
(17, 'от Свердловского', 3, 8),
(18, 'от Крас Урала', 3, 8),
(19, 'от ЧМЗ', 3, 9),
(20, 'от СЗ', 3, 9),
(21, 'от Центра', 3, 10),
(22, 'от АМЗ', 3, 10),
(23, 'от Ленниского рна', 4, 11),
(24, 'от Доватора', 4, 11);

-- --------------------------------------------------------

--
-- Структура таблицы `direction_post_consistency`
--

CREATE TABLE `direction_post_consistency` (
  `direction_post_consistency_id` int(11) NOT NULL,
  `direction_post_consistency_direction_id` int(11) NOT NULL,
  `direction_post_consistency_post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `locations`
--

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL,
  `location_name` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `locations`
--

INSERT INTO `locations` (`location_id`, `location_name`) VALUES
(1, 'г. Челябинск'),
(2, 'М-5 «Урал»'),
(3, 'г. Златоуст'),
(4, 'г. Магнитогорск'),
(5, 'г. Миасс');

-- --------------------------------------------------------

--
-- Структура таблицы `location_post_consistency`
--

CREATE TABLE `location_post_consistency` (
  `location_post_consistency_id` int(11) NOT NULL,
  `location_post_consistency_location_id` int(11) NOT NULL,
  `location_post_consistency_post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `location_post_consistency`
--

INSERT INTO `location_post_consistency` (`location_post_consistency_id`, `location_post_consistency_location_id`, `location_post_consistency_post_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15),
(16, 1, 16),
(17, 1, 17),
(18, 1, 18),
(19, 1, 19),
(20, 1, 20),
(21, 1, 21),
(22, 1, 22),
(23, 1, 23),
(24, 1, 24),
(25, 1, 25),
(26, 1, 26),
(27, 1, 27),
(28, 1, 28),
(29, 1, 29),
(30, 1, 30),
(31, 1, 31),
(32, 1, 32),
(33, 1, 33),
(34, 1, 34),
(35, 2, 35),
(36, 2, 36),
(37, 2, 37),
(38, 2, 38),
(39, 4, 39),
(40, 4, 40),
(41, 4, 41),
(42, 4, 42),
(43, 3, 43),
(44, 3, 44),
(45, 5, 48),
(46, 5, 49),
(47, 5, 50),
(48, 5, 51);

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `post_number` int(11) NOT NULL,
  `post_name` text COLLATE utf8_bin NOT NULL,
  `post_address` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`post_id`, `post_number`, `post_name`, `post_address`) VALUES
(1, 1, 'пВн № 1 Автодорога Меридиан ул. Дзержинского', 'пересечение автодороги Меридиан с ул. Дзержинского, Меридиан'),
(2, 2, 'пВн № 2 пересечение ул. Бр. Кашириных ул. 8 Марта', 'пересечение ул. Бр. Кашириных и Свердловского пр-та, Перекресток'),
(3, 3, 'пВн № 3 Свердловский тр-т – ул. Автодорожная «Лакокраска» ', 'пересечение Свердловского тр-та и ул. Автодорожной, Лакокраска'),
(4, 12, 'пВн № 12 пересечение ул. Российской и пр. Ленина', 'перекресток пр. Ленина и ул. Российской'),
(5, 15, 'пВн № 15 пересечение пр. Ленина – автодорога Меридиан, БД Спиридонов', 'перекресток пр. Ленина и автодороги Меридиан (БД Спиридонов)'),
(6, 16, 'пВн № 16 пересечение ул. Бр. Кашириных ул. 40 лет Победы', 'ул. Кашириных, у д.110'),
(7, 23, 'пВн № 23 ул. С.Разина – ул. Доватора «Колющенко»', 'ул. Доватора, у завода «Колющенко»'),
(8, 34, 'пВн № 34 Комсомольский пр., 2А', 'Комсомольский пр., у д.4'),
(9, 35, 'пВн № 35 Свердловский тр., 18А, Ветлечебница', 'Свердловский тр., у д. 20, Ветлечебница'),
(10, 36, 'пВн № 36 Блюхера, 95', 'ул. Блюхера, у д. 95'),
(11, 37, 'пВн № 37 Дзержинского-Барбюса', 'перекресток ул. Дзержинского и ул. Барбюса'),
(12, 38, 'пВн № 38 Меридиан-Артема, 195', 'автодорога Меридиан (напротив Артема 195)'),
(13, 39, 'пВн № 39 ул. Мамина Бродокалмакский тр.', 'Перекресток Бродокалмакского тр. И ул. Мамина'),
(14, 40, 'пВн № 40 Комсомольский пр., 83', 'Комсомольский пр., у д.83'),
(15, 41, 'пВн № 41 Меридиан-Потемкина', 'перекресток автодороги Меридиан и ул. Потемкина'),
(16, 42, 'пВн № 42 Троицкий тр., 25', 'Троицкий тр., у д. 25'),
(17, 43, 'пВн № 43 Троицкий тр., 80, поворот на Новосинеглазово', 'Троицкий тр., у д.80, поворот на Новосинеглазово'),
(18, 44, 'пВн № 44 СП ДПС Свердловский тракт', 'СП ДПС Свердловский'),
(19, 45, 'пВн № 45 СП ДПС Уфимский тракт', 'СП ДПС Уфимский'),
(20, 48, 'пВн № 48 ул. Центральная Кольцо на Шершневском водохранилище', 'Кольцо на Шершневском водохранилище'),
(21, 49, 'пВн № 49 Тополиная Аллея – Ул. Северная', 'перекресток Тополиной Аллеи и ул. Северной'),
(22, 50, 'пВн № 50 Салават Юлаева – 250 лет Челябинску', 'перекресток ул. Салават Юлаева и ул. 250 лет Челябинску'),
(23, 51, 'пВн № 51 пр. Победы – Салавата Юлаева', 'перекресток пр. Победы и ул. Салавата Юлаева'),
(24, 52, 'пВн № 52 ул. Чичерина – 40 Лет Победы', 'перекресток ул. Чичерина и 40 Лет Победы'),
(25, 53, 'пВн № 53 ул. Молодогвардейцев – Пиковая Котельная', 'ул. Молодогвардейцев 1Б, у пиковой котельной'),
(26, 54, 'пВн № 54 перекрёсток ул. Дачная–Б. Хмельницкого', 'перекрёсток ул. Дачной и ул. Б. Хмельницкого'),
(27, 55, 'пВн № 55 перекрёсток Павелецкая 2 – Ул. Лазурная', 'перекрёсток ул. 2-ой Павелецкой и ул. Лазурной'),
(28, 56, 'пВн № 56 ул. Морская – Поворот н', 'перекресток ул. Морской и ул. Электродный завод, поворот на Электродный завод'),
(29, 57, 'пВн № 57 Бродокалмакский тракт – ТЭЦ 3', 'Бродокалмакский тракт, у ТЭЦ 3'),
(30, 58, 'пВн № 58 Пр. Ленина – Ул. Линейная', 'начало пр. Ленина и начало ул. Линейной'),
(31, 59, 'пВн № 59ул Новороссийская ул. Машиностроителей', 'перекресток ул Новороссийской и ул. Машиностроителей'),
(32, 60, 'пВн № 60 Копейское шоссе – ул. Енисейская', 'перекресток Копейского шоссе и ул. Енисейской'),
(33, 61, 'пВн № 61 Копейское шоссе, 17', 'Копейское шоссе, у д.17'),
(34, 62, 'пВн № 62 Поворот к троллейбусному Депо №3 (дорога на ул. Енисейская и в ГСК)', 'Копейское шоссе, поворот к Депо №3 (дорога на ул. Енисейскую и в ГСК)'),
(35, 11, 'Стационарный пост видеонаблюдения № 11 на отметке 1822+500 км (кафе Автоланч)', 'Челябинская область, автомобильная дорога М-5 «Урал» на отметке 1822+500 км, кафе Автоланч'),
(36, 6, 'Стационарный пост видеонаблюдения № 06 на отметке 1779+498 км (поворот на г. Миасс)', 'Челябинская область, автомобильная дорога М-5 «Урал» на отметке 1779+498 км, поворот на г. Миасс'),
(37, 8, 'Стационарный пост видеонаблюдения № 08 на участке 1803+232 км (поворот на Пустозерово)', 'Челябинская область, автомобильная дорога М-5 «Урал» на участке 1803+232 км, поворот на Пустозерово'),
(38, 9, 'Стационарный пост видеонаблюдения № 09 на отметке 1811 + 640 км (Травники)', 'Челябинская область, автомобильная дорога М-5 «Урал» на участке 1811 + 640 км, Травники'),
(39, 0, 'Комплекс видеофиксации нарушений ул. Зеленцова (7 проходная)', 'У проходной № 7 ММК.'),
(40, 0, 'Пост видеонаблюдения по ул. Советская 167Б «Стрелка СТ» - 2 шт.', 'Советская 167Б'),
(41, 0, 'Пост видеонаблюдения по Челябинскому тракту, 27, пост ГИБДД «Крис-С»', 'Челябинский тракт, 27'),
(42, 0, 'Пост видеонаблюдения по ул. 9 Мая, 27 (переход ККЦ) «Крис-С»', 'ул. 9 Мая, 27'),
(43, 7, 'Пост видеонаблюдения №7 \"ТК Лера\"', 'г. Златоуст, ул. Гагарина 1-я линия, 12'),
(44, 8, 'Пост видеонаблюдения №8 \"Трампарк\"', 'г. Златоуст, пр. Мира, 32/1 '),
(48, 0, 'Оконечный комплекс «Выезд из города п. Первомайский», путепровод через ж/д, пос. Мелентьевка', 'г. Миасс, перекрёсток ул. Магистральной и ул. Кирова'),
(49, 0, 'Оконечный комплекс «Выезд из города ул. Пушкина»', 'г. Миасс, на перекрестке ул. Казымовой и Охотной, металлоконструкция над дорогой'),
(50, 0, 'Оконечный комплекс «Выезд из города ул. Трактовая»', 'г. Миасс, в районе дома Трактовая, 98'),
(51, 0, 'Оконечный комплекс «Перекресток п. Восточный - Объездная дорога»', 'г. Миасс, на перекрестке у дома ул. Парковая, 90/2');

-- --------------------------------------------------------

--
-- Структура таблицы `stripes`
--

CREATE TABLE `stripes` (
  `stripe_id` int(11) NOT NULL,
  `stripe_number` int(11) NOT NULL,
  `stripe_owner_direction_id` int(11) NOT NULL,
  `stripe_device_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `stripe_device_consistency`
--

CREATE TABLE `stripe_device_consistency` (
  `stripe_device_consistency_id` int(11) NOT NULL,
  `stripe_device_consistency_stripe_id` int(11) NOT NULL,
  `stripe_device_consistency_device_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `stripe_direction_consistency`
--

CREATE TABLE `stripe_direction_consistency` (
  `stripe_direction_consistency_id` int(11) NOT NULL,
  `stripe_direction_consistency_stripe_id` int(11) NOT NULL,
  `stripe_direction_consistency_direction_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`device_id`);

--
-- Индексы таблицы `devices_date_calibration`
--
ALTER TABLE `devices_date_calibration`
  ADD PRIMARY KEY (`devices_date_calibration_id`);

--
-- Индексы таблицы `device_list`
--
ALTER TABLE `device_list`
  ADD PRIMARY KEY (`device_list_id`);

--
-- Индексы таблицы `directions`
--
ALTER TABLE `directions`
  ADD PRIMARY KEY (`direction_id`);

--
-- Индексы таблицы `direction_post_consistency`
--
ALTER TABLE `direction_post_consistency`
  ADD PRIMARY KEY (`direction_post_consistency_id`);

--
-- Индексы таблицы `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Индексы таблицы `location_post_consistency`
--
ALTER TABLE `location_post_consistency`
  ADD PRIMARY KEY (`location_post_consistency_id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Индексы таблицы `stripes`
--
ALTER TABLE `stripes`
  ADD PRIMARY KEY (`stripe_id`);

--
-- Индексы таблицы `stripe_device_consistency`
--
ALTER TABLE `stripe_device_consistency`
  ADD PRIMARY KEY (`stripe_device_consistency_id`);

--
-- Индексы таблицы `stripe_direction_consistency`
--
ALTER TABLE `stripe_direction_consistency`
  ADD PRIMARY KEY (`stripe_direction_consistency_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `devices`
--
ALTER TABLE `devices`
  MODIFY `device_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `devices_date_calibration`
--
ALTER TABLE `devices_date_calibration`
  MODIFY `devices_date_calibration_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `device_list`
--
ALTER TABLE `device_list`
  MODIFY `device_list_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `directions`
--
ALTER TABLE `directions`
  MODIFY `direction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT для таблицы `direction_post_consistency`
--
ALTER TABLE `direction_post_consistency`
  MODIFY `direction_post_consistency_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `location_post_consistency`
--
ALTER TABLE `location_post_consistency`
  MODIFY `location_post_consistency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT для таблицы `stripes`
--
ALTER TABLE `stripes`
  MODIFY `stripe_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `stripe_device_consistency`
--
ALTER TABLE `stripe_device_consistency`
  MODIFY `stripe_device_consistency_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `stripe_direction_consistency`
--
ALTER TABLE `stripe_direction_consistency`
  MODIFY `stripe_direction_consistency_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
