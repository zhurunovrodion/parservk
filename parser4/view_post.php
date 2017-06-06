
<?php
header("Content-Type: text/html; charset=utf-8");
?>
<HTML>
<HEAD>
<TITLE>fgetc</TITLE>
</HEAD>
<BODY>
<pre>
<?php
ini_set('max_execution_time', 5000);
	ini_set('memory_limit', '6000M');
define('DB_HOST','localhost');
define("DB_LOGIN","root");
define('DB_PASSWORD','');
define('DB_NAME','parser');


$link=mysqli_connect(DB_HOST,DB_LOGIN,DB_PASSWORD,DB_NAME);
include ("config.php");
include ("functions.php");


$query1='SELECT post_text, post_photo, post_likes,post_reposts,quality_post, date_vk FROM post_original ORDER BY id';

$result=mysqli_query($link,$query1);

while($row=mysqli_fetch_array($result)){

   $imgurl=$row['post_photo'];
   $imgname=basename($imgurl);
   copy($imgurl, 'folder1/'.basename($imgurl));
   ImageUpload($imgurl, $imgname);
   $post_copy_url='/develop2/folder2/'.$imgname;
   $post_text=$row['post_text'];
   $post_likes=$row['post_likes'];
   $post_reposts=$row['post_reposts'];
   $date_vk=$row['date_vk'];
   $quality_post=$row['quality_post'];

 $query4="INSERT INTO post_copy (post_text, post_photo, post_likes,post_reposts, date_vk, quality_post) VALUES ('$post_text','$post_copy_url','$post_likes','$post_reposts','$date_vk','$quality_post')";
   mysqli_query($link,$query4);
 }


?>

</BODY>
</HTML>
