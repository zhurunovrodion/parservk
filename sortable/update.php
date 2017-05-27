<?php
include("db.php");

$items = serialize($_POST['items']);

if ($_POST['update'] == "update") {
        $query = "UPDATE sortable SET listorder = '$items'";
        mysql_query($query) or die($error . 'Ошибка');
        echo $ok . ' Изменения сохранены';
        }
