<?php
/**
 * Скрипт удаляет запись из БД.
 *
 * @author Стаценко Владимир
 * @link http://www.simplecoding.org/
 */
try {
	if (!isset($_POST['id'])) {
		throw new Exception('Не указан id записи');
	}
	//подключаемся к базе
	require_once('db.php');
	//удаляем запись (id записи приходит в формате note_id, приставку note_ вырезаем)
	$dbh->exec('DELETE FROM notes WHERE id='.$dbh->quote(substr($_POST['id'], 5)));
	$result = array(); 
	$result['id'] = $_POST['id'];
	//отправляет отчет браузеру
	echo json_encode($result);
} catch(Exception $e) {
	echo json_encode(array('err'=>'Ошибка: '.$e->getMessage()));
}