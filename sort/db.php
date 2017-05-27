<?php
/**
 * Создаём подключение к БД
 * В данном случае используется sqlite, но можно заменить на любую
 * базу, которую поддерживает PDO, например, MySQL
 *
 * @author Стаценко Владимир
 * @link http://www.simplecoding.org/
 */
$dbh = new PDO('sqlite:data/data.sqlite');
