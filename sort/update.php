<?php
/**
 * Скрипт изменяет текст записи в БД.
 *
 * @author Стаценко Владимир
 * @link http://www.simplecoding.org/
 */
try {
	//проверяем, пришли данные или нет
	if (!isset($_POST['value'])
			|| '' == $_POST['value']
			|| !isset($_POST['id'])
			|| '' == $_POST['id']) {
		throw new Exception('Не указаны данные записи');
	}
	//подключаемся к базе
	require_once('db.php');
	//защита от XSS
	$note = htmlspecialchars($_POST['value']);
	//формируем запрос на изменение записи...
	$stmt = $dbh->prepare('UPDATE notes SET note=:note WHERE id=:id');
	//... и выполняем его
	$stmt->execute(array(':note'=>$note, ':id'=>substr($_POST['id'], 2)));
	$dbh = null;
	//тут мы не используем JSON формат, т.к. это требование плагина jeditable
	echo $note;
} catch(Exception $e) {
	echo 'Ошибка: '.$e->getMessage();
}