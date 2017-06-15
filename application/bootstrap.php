<?php
// подключаем файлы ядра
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once "lib/safemysql.class.php";
//require_once "lib/vkontakte.class.php";
require_once "lib/shingles.class.php";
require_once "lib/vk_api_class.php";
/*
Здесь обычно подключаются дополнительные модули, реализующие различный функционал:
	> аутентификацию
	> кеширование
	> работу с формами
	> абстракции для доступа к данным
	> ORM
	> Unit тестирование
	> Benchmarking
	> Работу с изображениями
	> Backup
	> и др.
*/

require_once 'core/route.php';
Route::start(); // запускаем маршрутизатор
