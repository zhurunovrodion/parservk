<?header("Content-Type: text/html; charset=utf-8");?>
<HTML>
<HEAD>
<TITLE>Парсер блять!</TITLE>
</HEAD>
<BODY>

<?php
include('functions.php');  //подключение библиотеки функций парсера
include ("config.php");
ini_set('max_execution_time', 360000); //установка времени скрипта
ini_set('memory_limit', '6000M'); //выдача количество оперативки php
$link=mysqli_connect(DB_HOST,DB_LOGIN,DB_PASSWORD,DB_NAME);
$query_publics='SELECT  public_id  FROM public_list ORDER BY id'; //запрос на выборку списка пабликов
$public_id=mysqli_query($link,$query_publics); //исполнение запроса на выборку списка пабликов

while($row=mysqli_fetch_array($public_id)){ //в этом цикле поочередно выбираются паблики из списка и подставляются их id в запрос к VKAPI
$current_public_id=$row['public_id'];
$query_id_public="SELECT id, public_name, public_link, public_id, post_text, post_photo_vk_link,post_photo_file_link, post_likes,post_reposts, date_vk, quality_post FROM post_original WHERE public_id='$current_public_id' and post_likes=(SELECT MAX(post_likes) FROM post_original WHERE public_id='$current_public_id')";
$public_id_list=mysqli_query($link,$query_id_public);
  $row1=mysqli_fetch_array($public_id_list);
  $id1=$row1['id'];
  $max_like=$row1['post_likes'];
//  echo $current_public_id.': '.$max_like.'|||'.$id1.'<br>';
$datevk=date("d.m.Y, H:i:s", $row1['date_vk']);
$vk_public_link=$row1["public_link"];
$vk_public_name=trim($row1['public_name']);
$vk_post_id=$row1['id'];
 echo '<p>'.$row1['post_text'].'</p>';
 echo '<br>';
 echo '<image src="'.$row1['post_photo_file_link'].'">';
 echo '<br>';
 echo '<br>';
 echo "<b>Лайков:</b> ".$row1['post_likes'].'      ';
 echo "<b>Репостов:</b> ".$row1['post_reposts'].'      ';
 echo "<b>Качество:</b> ".$row1['quality_post'].':1      ';
 echo "<b>Дата публикации в VK:</b> ".$datevk.'      ';
 echo "<b>Номер поста: </b>".$i++;
 echo '<p>Спизжено с: <a target="_blank" href="'.$vk_public_link.'">'.$vk_public_name.'</a>';
 echo '|||||||||||||||| <b><a href="view_parser_posts.php?del='.	$vk_post_id.'">Удалить пост нахуй</a></b>';
 $queryavg="SELECT AVG(post_likes) as avg_likes FROM post_original WHERE public_id='$current_public_id'";
 $result_avg=mysqli_query($link,$queryavg);
 var_dump($result_avg);
 $rowavg=mysqli_fetch_array($result_avg);
 $avg=$rowavg['avg_likes'];
 echo '<br>Среднее значение поста по лайкам:'.$avg.'<br>';
 echo '</p>';
 echo '<hr>';}


?>
</BODY>
</HTML>
