<?header("Content-Type: text/html; charset=utf-8"); //правильная кодировка
 include('functions.php');  //подключение библиотеки функций парсера
 include ("config.php"); //конфигурационные параметры
 ?>

<HTML>
<HEAD>
<TITLE>Парсер блять!</TITLE>
</HEAD>
<BODY>
<pre>
	<?php
	ini_set('max_execution_time', 360000); //установка времени скрипта
	ini_set('memory_limit', '6000M'); //выдача количество оперативки php
  echo '<h1>Пиздилка постов запущена. Слава Украине!</h1>';

	$link=mysqli_connect(DB_HOST,DB_LOGIN,DB_PASSWORD,DB_NAME); //соединение с базой данных
  mysqli_query($link,"SET NAMES 'utf8'");
	$query_publics='SELECT public_name, public_link, public_id  FROM public_list ORDER BY id DESC'; //запрос на выборку списка пабликов
	$public_list=mysqli_query($link,$query_publics); //исполнение запроса на выборку списка пабликов

	while($row=mysqli_fetch_array($public_list)){  //в этом цикле поочередно выбираются паблики из списка и подставляются их id в запрос к VKAPI
        $current_public_id=$row['public_id'];
				$current_public_name=$row['public_name'];
				$current_public_link=$row['public_link'];



		for($j=0; $j<=10000; $j+=100){  //в это цикле исполняются запросы к VK APi где $j обозначает параметры поиска, первая $j определяет со скольки постов назад начинать парсить, вторая количество постов минус со скольки постов назад начало парсить
		$post=json_decode(file_get_contents('https://api.vk.com/method/wall.get?owner_id=-'.$current_public_id.'&offset='.$j.'&count=100&v=3.0')); //посылка запроса к VK API куда в переменную $post прилетает объект JSON Содержащий результат запроса получания постов к VK API методом wall.get
    sleep(0.35);
	for($i=0; $i<=100; $i++){  //в этом цикле перебераются объекты JSON присланны в одном запросе, за один запрос от VK приходит 100 постов, эти же 100 постов перебираются в этом цикле
	if($post->response[$i]->reposts->count==0){ //одна из проверок, если количество репостов поста равно 0 то он отбрасывается и цикл итерация цикла переходит к следующему посту
		continue;
	}

	$quality=$post->response[$i]->likes->count/$post->response[$i]->reposts->count;
	$text=clearStr($post->response[$i]->text);

	$photo_vk_link=$post->response[$i]->attachment->photo->src_big;
	$likes=$post->response[$i]->likes->count;
	$reposts=$post->response[$i]->reposts->count;
	$date=$post->response[$i]->date;
	$text_length=strlen($text);
	if( ($quality>5) or (empty($text))  or/*($reposts<50000) or*/ (!$photo_vk_link) or ($text_length>3000)){
		continue;
	}
	else{
	$adfilter=ad_filter($text);
	if($adfilter=="yes"){
	continue;
	}
  $uniq_filter=uniqtext_filter($text);
  if($uniq_filter=="ununiq"){
	continue;
	}
  $imgurl=$photo_vk_link;
  $imgname=basename($imgurl);
  copy($imgurl, 'folder1/'.basename($imgurl));
    sleep(0.35);
  ImageUpload($imgurl, $imgname);
  $photo_file_link='/parser4/folder2/'.$imgname;
	$query="INSERT INTO post_original (public_name, public_link, public_id, post_text, post_photo_vk_link,post_photo_file_link, post_likes,post_reposts, date_vk, quality_post)
  VALUES('$current_public_name', '$current_public_link', '$current_public_id', '$text', '$photo_vk_link', '$photo_file_link', '$likes', '$reposts', '$date', $quality)";
	//echo $query;
	mysqli_query($link,$query);


}}}}

?>
</BODY>
</HTML>
