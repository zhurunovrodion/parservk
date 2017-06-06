<?header("Content-Type: text/html; charset=utf-8"); //правильная кодировка
 include('functions.php');  //подключение библиотеки функций парсера
 include ("config.php"); //конфигурационные параметры
 ?>

<HTML>
<HEAD>
<TITLE>Парсер блять!</TITLE>
</HEAD>
<BODY>

	<?php
	ini_set('max_execution_time', 360000); //установка времени скрипта
	ini_set('memory_limit', '6000M'); //выдача количество оперативки php
  echo '<h1>Пиздилка постов запущена. Слава Украине!</h1>';

	$link=mysqli_connect(DB_HOST,DB_LOGIN,DB_PASSWORD,DB_NAME); //соединение с базой данных

	$query_publics='SELECT public_name, public_link, public_id, public_avg_likes  FROM public_list ORDER BY id'; //запрос на выборку списка пабликов
	$public_list=mysqli_query($link,$query_publics); //исполнение запроса на выборку списка пабликов

	while($row=mysqli_fetch_array($public_list)){  //в этом цикле поочередно выбираются паблики из списка и подставляются их id в запрос к VKAPI
        $current_public_id=$row['public_id'];
				$current_public_name=$row['public_name'];
				$current_public_link=$row['public_link'];
        $current_public_avg_likes=$row['public_avg_likes'];
        echo 	$current_public_name.'<br>';
        $query_posts="SELECT id, public_name, public_link, public_id, post_text, post_photo_vk_link, post_photo_file_link, post_likes,post_reposts, date_vk, quality_post FROM post_original WHERE public_id='$current_public_id'";
        $allposts=mysqli_query($link,$query_posts);
        while($row_allposts=mysqli_fetch_array($allposts)){
            $public_name= $row_allposts['public_name'];
            $public_link= $row_allposts['public_link'];
            $public_id=$row_allposts['public_id'];
            $post_text=str_uniq_replace($row_allposts['post_text']);
            $post_photo_vk_link=$row_allposts['post_photo_vk_link'];
            $post_photo_file_link=$row_allposts['post_photo_file_link'];
            $post_likes=$row_allposts['post_likes'];
            $post_repost=$row_allposts['post_reposts'];
            $date_vk=$row_allposts['date_vk'];
            $quality_post=$row_allposts['quality_post'];
            $text_length=strlen($post_text);
           if( ($quality_post>3) or  ($post_repost<30) or ($text_length>2000)){
              continue;
          }
            $query_insert="INSERT INTO best_posts (public_name, public_link, public_id, post_text, post_photo_vk_link,post_photo_file_link, post_likes,post_reposts, date_vk, quality_post)
            VALUES('$public_name', '$public_link', '$public_id', '$post_text','$post_photo_vk_link', '$post_photo_file_link', '$post_likes', '$post_repost', '$date_vk', '$quality_post')";
            mysqli_query($link,$query_insert);
        }
}

?>
</BODY>
</HTML>
