<?header("Content-Type: text/html; charset=utf-8");

include('functions.php');  //подключение библиотеки функций парсера
include ("config.php");
ob_start();
?>

<HTML>
<HEAD>
<TITLE>Вывод постов из парсера</TITLE>
</HEAD>
<BODY>
<pre>


	<?php
ini_set('max_execution_time', 1700);
ini_set('memory_limit', '6000M');



$link=mysqli_connect(DB_HOST,DB_LOGIN,DB_PASSWORD,DB_NAME);
if($_SERVER['REQUEST_METHOD']=='GET'){
  $del=$_GET['del'];
  $querydel="DELETE FROM best_posts WHERE id=$del";
  mysqli_query($link,$querydel);

}
$query_view='SELECT id, public_name, public_link, public_id, post_text, post_photo_vk_link,post_photo_file_link, post_likes,post_reposts, date_vk, quality_post FROM best_posts  ORDER BY RAND() LIMIT 1 ';

$result=mysqli_query($link,$query_view);

$i=1;
while($row=mysqli_fetch_array($result)){

  $datevk=date("d.m.Y, H:i:s", $row['date_vk']);
	$vk_public_link=$row["public_link"];
	$vk_public_name=trim($row['public_name']);
	$vk_post_id=$row['id'];
   echo '<p>'.$row['post_text'].'</p>';
	 echo '<br>';
	 echo '<image src="'.$row['post_photo_file_link'].'">';
	 echo '<br>';
	 echo '<br>';
	 echo "<b>Лайков:</b> ".$row['post_likes'].'      ';
	 echo "<b>Репостов:</b> ".$row['post_reposts'].'      ';
	 echo "<b>Качество:</b> ".$row['quality_post'].':1      ';
	 echo "<b>Дата публикации в VK:</b> ".$datevk.'      ';
   echo "<b>Номер поста: </b>".$i++;
	 echo '<p>Спизжено с: <a target="_blank" href="'.$vk_public_link.'">'.$vk_public_name.'</a>';
	 echo '|||||||||||||||| <b><a href="view_best_posts.php?del='.	$vk_post_id.'">Удалить пост нахуй</a></b>';
	 echo '</p>';
	 echo '<hr>';
}
?>
</BODY>
</HTML>
