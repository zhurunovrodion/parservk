<?php
/**
 * Скрипт изменяет порядок записей.
 *
 * @author Стаценко Владимир
 * @link http://www.simplecoding.org/
 */
try {
	//проверяем полученные данные
	if (!isset($_POST['neworder']) || count($_POST['neworder']) > 5000) {
		throw new Exception('Недопустимые данные');
	}
	//подключаемся к БД
	require_once('db.php');
	//создаём запрос на обновление
	$stmt = $dbh->prepare('UPDATE notes SET note_order=:note_order WHERE id=:id');
	//преобразовываем строку в JSON формате в массив объектов
	$data = json_decode($_POST['neworder']);
	if (null == $data) {
		throw new Exception('Недопустимый формат');
	}
	//обновляем записи
	foreach ($data as $note) {
		$stmt->execute(array(':note_order'=>$note->order, ':id'=>substr($note->id, 5)));
	}
	$dbh = null;
	//отправляем отчет браузеру
	echo json_encode(array('status'=>'OK'));
} catch(Exception $e) {
	echo json_encode(array('status'=>'ERR', 'mes'=>'Ошибка: '.$e->getMessage()));
}
