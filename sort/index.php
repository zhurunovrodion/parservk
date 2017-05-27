<?php
/**
 * Скрипт создаёт страницу со списком.
 *
 * @author Стаценко Владимир
 * @link http://www.simplecoding.org/
 */
try {
	//подключаемся к базе
	require_once('db.php');
	//получаем все записи
	$query = $dbh->query('SELECT * FROM notes ORDER BY note_order DESC');
	$result = $query->fetchAll();
	$dbh = null;
} catch(Exception $e) {
	$error = 'Ошибка: '.$e->getMessage();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>jQuery Sortable Notes</title>
	
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
	
	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery.jeditable.mini.js"></script>
	<script type="text/javascript" src="js/jquery.json-2.2.min.js"></script>
	<script type="text/javascript" src="js/init.js"></script>
</head>
<body>
	<h1>Заметки</h1>
	<p>Вы можете менять местами элементы списка. Двойной клик по тексту записи позволяет её отредактировать.</p>
	<p>Подробное описание читайте в статье <a href="http://www.simplecoding.org/jquery-plaginy-sortirovka-i-redaktirovanie-spiska.html">jQuery + плагины: сортировка и редактирование списка</a></p>

	<form action="addnew.php" method="post" id="addNewNote">
		<p>
		<input type="text" name="notetext" id="notetext" size="40" />
		<input type="submit" value="Добавить заметку" />
		</p>
	</form>
<?php
	//выводим сообщение об ошибке или формируем список записей
	if (isset($error)) {
		echo '<h2>'.$error.'</h2>';
	} else {
		if (count($result) > 0) {
			echo '<ul id="sortable">';
			foreach ($result as $row) {
				echo '<li id="note_'.$row['id'].'" class="editable"><span class="note" id="n_'.$row['id'].'">'.$row['note'].'</span><a href="#"><img src="images/delete.png" alt="Удалить" /></a></li>';
			}
			echo '</ul>';
?>
	<form id="changeOrder" method="post" action="changeorder.php">
		<p><input type="submit" value="Сохранить сортировку" /></p>
	</form>
<?php
		} else {
			echo '<h2>Записи отстутствуют</h2>';
		}
	}
?>
</body>
</html>