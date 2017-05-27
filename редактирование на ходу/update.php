<?php

$text = $_POST['text'];
$id = mysql_escape_string($_POST['id']);


echo stripslashes($text);

?>