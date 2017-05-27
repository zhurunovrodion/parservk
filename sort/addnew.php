<?php
/**
 * Скрипт добавления новой записи в БД.
 *
 * @author Стаценко Владимир
 * @link http://www.simplecoding.org/
 */
try {
	//проверяем, пришел текст записи или нет
	if (!isset($_POST['notetext']) || '' == $_POST['notetext']) {
		throw new Exception('Не указан текст записи');
	}
	//подключаемся к БД
	require_once('db.php');
	//находим запись с максимальным значением в поле order
	$query = $dbh->query('SELECT note_order FROM notes ORDER BY note_order DESC LIMIT 1');
	$result = $query->fetchAll();
	if (0 == count($result)) {
		$order = 1;
	} else {
		$order = $result[0]['note_order'] + 1;
	}
	//вставляем новую запись, поле note_order новой записи будет на единицу больше,
	//чем у найденной записи
	$notetext = htmlspecialchars($_POST['notetext']);
	$dbh->exec('INSERT INTO notes (note, note_order) VALUES ('.$dbh->quote($notetext).', '.$order.')');
	$result = array();
	//получаем id созданной записи
	$result['id'] = $dbh->lastInsertId();
	$result['note'] = $notetext;
	$result['note_order'] = $order;
	$dbh = null;
	//отправляем результаты браузеру
	echo json_encode($result);
} catch(Exception $e) {
	echo json_encode(array('err'=>'Ошибка: '.$e->getMessage()));
}
