<?php
// Информация для подключения к базе данных
$dbhost							= 'localhost';  // Сервер
$dbname							= 'sortable';  // Имя базы данных
$dbuser							= 'root';  // Имя пользователя
$dbpass							= '';  // Пароль

$error = '<img src="img/error.png" alt="" width="32" height="32" />' ;
$ok = '<img src="img/ok.png" alt="" width="32" height="32" />' ;



mysql_connect($dbhost, $dbuser, $dbpass) or die ($error . ' Ошибка подключение к базе данных - '.mysql_error());
mysql_select_db($dbname) or die ($error . 'Ошибка доступа к базе данных - '.mysql_error());
mysql_query('SET NAMES utf8');
