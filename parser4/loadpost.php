<?
header("Content-Type: text/html; charset=utf-8");
include('functions.php');  //подключение библиотеки функций парсера
include ('config.php');
require_once('vkontakte.php');
ob_start();
?>
<?php
ini_set('max_execution_time', 1700);
ini_set('memory_limit', '6000M');



$link=mysqli_connect(DB_HOST,DB_LOGIN,DB_PASSWORD,DB_NAME);

$query_view='SELECT id, public_name, public_link, public_id, post_text, post_photo_vk_link,post_photo_file_link, post_likes,post_reposts, date_vk, quality_post FROM post_original ORDER BY RAND() LIMIT 1';
mysqli_query($link,"SET NAMES 'utf8'");

$result=mysqli_query($link,$query_view);

$i=1;
while($row=mysqli_fetch_array($result)){

  $datevk=date("d.m.Y, H:i:s", $row['date_vk']);
	$vk_public_link=$row["public_link"];
	$vk_public_name=trim($row['public_name']);
	$vk_post_id=$row['id'];
    $row['post_text'];
	
	$row['post_photo_file_link'];
	

$accessToken = '90f2a68f4b8d4954a93930968dec6fb3d5129424a7d6b638ef5a7c253648aab71a960ab59ae9ae5c3c407';
$vkAPI = new \BW\Vkontakte(['access_token' => $accessToken]);
$publicID = 32753197;
$image='/var/www/html'.$row['post_photo_file_link'];
if ($vkAPI->postToPublic($publicID, $row['post_text'] , $image)) {

    echo "Ура! Всё работает, пост добавлен\n";

} else {

    echo "Фейл, пост не добавлен(( ищите ошибку\n";
}
}
?>
