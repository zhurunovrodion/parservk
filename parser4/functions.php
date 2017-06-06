<?
	 /*Функция добавления водяного знака на исходное изображение*/
	function AddWaterMark($source_image_path, $result_image_path)
	{
		// Получаем ширину, высоту и тип исходного изображения
		list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);
		// Если по каким, то причинам неопределн тип, нам не стоит выполнять какие-либо действия с водяным знаком, по скольку это не картинка вовсе
		 if ($source_image_type === NULL) {
			return false;
		 }
		 // Создаем, так называемый ресурс изображения из исходной картинки в зависимости от типа исходной картинки
		 switch ($source_image_type) {
			 case 1: // картинка *.gif
				$source_image = imagecreatefromgif($source_image_path);
				break;
			 case 2: // картинка *.jpeg, *.jpg
				$source_image = imagecreatefromjpeg($source_image_path);
				break;
			 case 3: // картинка *.png
				$source_image = imagecreatefrompng($source_image_path);
				break;
			 default:
				return false; // Если картинка другого формата, или не картинка совсем, то опять же не стоит делать, что либо дальше с водяным знаком
		 }
		 // Создаем ресурс изображения для нашего водяного знака
		 $watermark_image = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].WATERMARK_OVERLAY_IMAGE);
		 // Получаем значения ширины и высоты
		 $watermark_width = imagesx($watermark_image);
		 $watermark_height = imagesy($watermark_image);
		 // Наложение ЦВЗ с прозрачным фоном
		 imagealphablending($source_image, true);
		 imagesavealpha($source_image, true);
		 // Самая важная функция - функция копирования и наложения нашего водяного знака на исходное изображение
		 imagecopy($source_image, $watermark_image, $source_image_width - $watermark_width-10, $source_image_height - $watermark_height-10, 0, 0, $watermark_width, $watermark_height);
      if ($source_image_width<720){
			   $delta_x=720-$source_image_width;
				 $new_source_image_width=$source_image_width+$delta_x;
				 $new_source_image_height=$source_image_height+$delta_x;
				 $apskale_image=imagecreatetruecolor($new_source_image_width,$new_source_image_height);
				 imagecopyresampled($apskale_image, $source_image, 0,0,0,0,$new_source_image_width,$new_source_image_height,$source_image_width, $source_image_height);
			}
		 // Создание и сохранение результирующего изображения с водяным знаком
		 imagejpeg($apskale_image, $result_image_path, WATERMARK_OUTPUT_QUALITY);
		 // Уничтожение всех временных ресурсов
		 imagedestroy($source_image);
		 imagedestroy($apskale_image);
		 imagedestroy($watermark_image);
	}

	/*Функция загрузки изображения*/
	function ImageUpload($temp_path, $temp_name)
	{
		 // Получаем параметры изображения
		 list($temp_width, $temp_height, $temp_type) = getimagesize($temp_path);
		 // Если тип определить не получилось, то возвращаем FALSE
		 if ($temp_type === NULL) {
			return false;
		 }
		 // Если тип загружаемого файла не GIF, JPEG, PNG
		 switch ($temp_type) {
			 case 1:
				break;
			 case 2:
				break;
			 case 3:
				break;
			 default:
				return false;
		 }
		 // Конечные пути для сохранения
		 $upload_image_path = UPLOADED_IMAGE_DESTINATION . $temp_name;
		 $watermark_image_path = WATERMARK_IMAGE_DESTINATION . preg_replace('/\\.[^\\.]+$/', '.jpg', $temp_name);
		 // Загружаем исходное изображение
		 move_uploaded_file($temp_path, $_SERVER['DOCUMENT_ROOT'].$upload_image_path);
		 // Создаем копию изображения и добавляем водяной знак
		 $result = AddWaterMark($_SERVER['DOCUMENT_ROOT'].$upload_image_path, $_SERVER['DOCUMENT_ROOT'].$watermark_image_path);
		 // В случае, если все прошло упешно, возвращаем путь к файлу с ЦВЗ
		 if ($result === false) {
			return false;
		 } else {
			return array($upload_image_path, $watermark_image_path);
		 }
	}

	function ad_filter($data){

		if(($substr_count = substr_count($data,"["))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"club"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"vk"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"http"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"https"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"https"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"vk.cc"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"#"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"конкурс"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"Репост"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"Конкурс"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"РЕПОСТ"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"КОНКУРС"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"Музыка"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"МУЗЫКА"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"Клип"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"КЛИП"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"Альбом"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"На стену"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"подборка"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"ПОДБОРКА"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"Подборка"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"стеночку"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"Стеночку"))>=1){
			return 'yes';
		}
		elseif(($substr_count = substr_count($data,"Стеночку"))>=1){
			return 'yes';
		}
	}

	function clearStr($data){
	  global $link;
	  return mysqli_real_escape_string($link, trim(strip_tags($data)));
	}

	function uniqtext_filter($data){
		global $link;
		$query_uniq='SELECT post_text FROM post_original ORDER BY id';
		$result_uniq=mysqli_query($link,$query_uniq);
		if(!$result_uniq){
			return 0;
		}
		while($row=mysqli_fetch_array($result_uniq)){
			$post_text_f=$row['post_text'];
			$var1 = similar_text($post_text_f, $data, $tmp);
			if ($tmp>85){
				return 'ununiq';
			}
			}
		}
   function str_uniq_replace($data){

		 $str_e=str_replace('е','e', $data);
		 $str_a=str_replace('а','a', $str_e);
		 $str_o=str_replace('о','o', $str_a);
		 $str_p=str_replace('р','p', $str_o);
		 $str_y=str_replace('у','y', $str_p);
		 $str_c=str_replace('с','c', $str_y);
     return $str_c;
	 }

	 function uniqtext_filter_v2($data){
		 global $link;
		 $query_uniq='SELECT post_text FROM post_original ORDER BY id';
		 $result_uniq=mysqli_query($link,$query_uniq);
		 if(!$result_uniq){
			 return 0;
		 }
		 while($row=mysqli_fetch_array($result_uniq)){
		  $post_text_f=$row['post_text'];
			$text1=substr($post_text_f, 0, 255);
      $text2=substr($data, 0, 255);
			$length_post_text=strlen($text1);
			 $var1 = levenshtein($text1, $text2);
			 if ($var1<($length_post_text*0.15)){
				 return 'ununiq';
			 }
			 }
		 }
?>
