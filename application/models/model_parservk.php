<?php
class Model_Parservk extends Model
{
    public $db;
    public $table_name;
    public $res_public_list;
    
    
    
    public function get_public_list()
    {
        $this->db        = new SafeMySQL();
        $table_name      = 'public_list';
        $res_public_list = $this->db->getAll("SELECT * FROM ?n", $table_name);
        
        return $res_public_list;
    }
    
    
    
    public function clearStr($data)
    {
        
        return trim(strip_tags($data));
    }
    
    
    
    public function get_str_uniq_replace($data)
    {
        
        $str_e = str_replace('е', 'e', $data);
        $str_a = str_replace('а', 'a', $str_e);
        $str_o = str_replace('о', 'o', $str_a);
        $str_p = str_replace('р', 'p', $str_o);
        $str_y = str_replace('у', 'y', $str_p);
        $str_c = str_replace('с', 'c', $str_y);
        return $str_c;
    }
    
    
    public function ad_filter($data)
    {
        
        $stop_words_array = array(
            "[",
            "club",
            "vk",
            "http",
            "https",
            "vk.cc",
            "#",
            "Конкурс",
            "Репост",
            "Музыка",
            "Клип",
            "На стену",
            "На стеночку",
            "Лайк",
            "Альбом",
            "Подборка",
            "Стеночку",
            "Новый год",
            "Осень",
            "Зима",
            "Осенью",
            "Зимой",
            "Подборочка",
            "Праздник",
            "Праздником",
            "Новым годом",
            "Новому году",
            "Новогоднее",
            "Новогодний",
            "Праздником",
            "8 марта",
            "23 февраля",
            "Днем победы",
            "Ветераны",
            "Ветеранам",
            "Рождеством",
            "Рождественоское",
            "Рождеству",
            "Христос",
            "Пасха",
            "Пасху",
            "Пасхи"
        );
        //var_dump($stop_words_array);
        foreach ($stop_words_array as $word) {
            
            
            if ((($substr_count = substr_count($data, $word)) >= 1) or (($substr_count1 = substr_count($data, mb_strtoupper($word))) >= 1) or (($substr_count2 = substr_count($data, mb_strtolower($word))) >= 1)) {
                return "false";
            }
        }
    }
    
    
    
    
    public function parser_posts_query($public_id, $posts_offset)

    {   
        $access_token="cb2cac6c39eaf7e68a16c9cc2c0e798e35c22c4f44d0281bd08dd60a1e7a609dac4345a4dd2f364c8ed47";
        $posts = json_decode(file_get_contents('https://api.vk.com/method/wall.get?owner_id=-' . $public_id . '&offset=' . $posts_offset . '&count=10&v=5.65&access_token='.$access_token));
        return $posts;
    }
    
    
    public function set_post_to_db($public_id, $post_text, $post_likes, $post_reposts, $post_date, $post_attachments, $views)
    {
        
        $this->db = new SafeMySQL();
        
        
        $sql = "INSERT INTO post_original(public_id,post_text,post_likes,post_reposts, date_vk,post_attachments, views) VALUES(?i,?s,?i,?i,?i,?s,?i)";
        $this->db->query($sql, $public_id, $post_text, $post_likes, $post_reposts, $post_date, $post_attachments, $views);
        
        
    }
    
    public function set_shingle_to_db($shingle)
    {
        $this->db = new SafeMySQL();
        $sql      = "INSERT INTO shingles(shingles) VALUES(?s)";
        $this->db->query($sql, $shingle);
    }
    
    
    public function uniq_post_analyze($text)
    {
        $this->db     = new SafeMySQL();
        $table_name   = 'shingles';
        $res_shingles = $this->db->getAll("SELECT * FROM ?n", $table_name);
        
        if (empty($res_shingles)) {
            $words1 = Shingles::canonize($text);
            
            $shingles1 = Shingles::shinglesGen($words1);
            echo "<h1>ХУЙ</h1>";
            return serialize($shingles1);
            
        } else {
            $words1 = Shingles::canonize($text);
            
            $words1_count = count($words1);
            
            $shingles1 = Shingles::shinglesGen($words1);
            foreach ($res_shingles as $value) {
                
                $shingles2 = unserialize($value['shingles']);
                
                
                $result = Shingles::analyze2($shingles1, $shingles2, $words1_count);
                
                if ($result > 20) {
                    echo "<h1>Не уникальное!!! $result процентов совпадений</h1>";
                    return "false";
                }
            }
            return serialize($shingles1);
        }
    }
    
    public function get_posts_from_vk()
    {
        
        ini_set('max_execution_time', 360000); //установка времени скрипта
        ini_set('memory_limit', '6000M'); //выдача количество оперативки php
        echo '<h1>Пиздилка постов запущена. Слава Украине!</h1>';
        
        $public_list = $this->get_public_list();
        $current_date = getdate(time());
        $size_of_the_queries = $current_date['mon'] * 1500;
        foreach ($public_list as $public) {
            
            for ($j = 0; $j < $size_of_the_queries; $j += 100) {
                
                $posts = $this->parser_posts_query($public['public_id'], $j);
                
                for ($i = 0; $i <= 100; $i++) {
                    
                    $post_text          = $this->clearStr($posts->response->items[$i]->text);
                    $post_likes         = $posts->response->items[$i]->likes->count;
                    $post_reposts       = $posts->response->items[$i]->reposts->count;
                    $post_date          = $posts->response->items[$i]->date;
                    $post_attachments = serialize($posts->response->items[$i]->attachments);
                    $post_views = $posts->response->items[$i]->views->count;
                   
                    echo $post_text.'<br>';
                    echo $post_likes.'<br>';
                    echo $post_reposts.'<br>';
                    echo $post_photo_vk_link.'<br>';
                    echo '<hr>';

                    $post_date_tmp=getdate($post_date);

                    if ($post_date_tmp['year'] == 2016){
                        echo "2016 год , пропуск <br>";
                        continue;
                    }

                     if ($post_date_tmp['year']==1970){
                        echo "1970 год , пропуск <br>";
                        continue;
                    }
                    
                    if ($post_reposts < 1) {
                        echo "мало репостов, пропуск<br>";
                        continue;

                    }
                    
                    
                    
                    if (strlen($post_text) < 5) {
                         echo "Маленький размер текста, пропуск<br>";
                        continue;
                    }
                    
                    if (($this->ad_filter($post_text)) == "false") {
                         echo "реклама, пропуск<br>";
                        continue;
                    }
                    
                   

                    $quality=$this->quality_control( $public['public_id'], $post_views, $post_date_tmp['mon']);  
                    if ($quality=="false")
                    {
                        continue;
                    }
                    
                    $shingle = $this->uniq_post_analyze($post_text);
                    
                    if ($shingle == "false") {
                        
                        continue;
                    }
                    $this->set_post_to_db($public['public_id'], $post_text, $post_likes, $post_reposts, $post_date, $post_attachments, $post_views);
                    $this->set_shingle_to_db($shingle);
                    
                }
                
                sleep(0.4);
                
            }
        }
        
    }
    
    public function get_average_coverage($public_id, $month, $year, $counter)
    {
        if ($month > 12 or $month <= 0) {
            echo "Некорректный месяц";
            return false;
        }
        $current_date = getdate(time());
        
        if ($year > $current_date['year'] or $year < $current_date['year']) {
            echo "Некорректный год, должен быть больше 2017 либо равен текущему";
            return false;
        }
        $size_of_the_queries = $current_date['mon'] * 1500;
        
        
       
        $array_of_posts_views = array();
        for ($j=$counter ; $j <= $size_of_the_queries; $j += 100) {
            
            $posts = $this->parser_posts_query($public_id, $j);
             
            for ($i = 0; $i <= 100; $i++) {
                   
                $pinned=$posts->response->items[$i]->is_pinned;
                if ($pinned>=1){
                continue;
                }
               
                $post_date = getdate($posts->response->items[$i]->date);
               
                
                 $post_text = $posts->response->items[$i]->text;
                
                
                $post_views = $posts->response->items[$i]->views->count;
                
                if ($post_date['mon'] == $month and $post_date['year'] == $year) {
                    $array_of_posts_views[] = $post_views;
                }
                
                if ($post_date['year'] == 2016) {
                    $array_of_posts_views_count   = count($array_of_posts_views);
                    $array_of_posts_views_sum     = array_sum($array_of_posts_views);
                    $array_of_posts_views_avarage = $array_of_posts_views_sum / $array_of_posts_views_count;
                    $this->set_average_coverage_to_db($public_id, $year, $month, $array_of_posts_views_avarage);
                    return "true";
                }
                
                  if ($post_date['mon']<$month){
                    if ($post_date['year']==1970){
                        continue;
                    }
                    echo $j;
                    echo "<hr>";
                    echo $post_date['mon']."<".$month;
                    echo "<br>";
                    
                $array_of_posts_views_count=count($array_of_posts_views);
                $array_of_posts_views_sum=array_sum($array_of_posts_views);
                $array_of_posts_views_avarage=$array_of_posts_views_sum/$array_of_posts_views_count;
                $this->set_average_coverage_to_db($public_id, $year, $month, $array_of_posts_views_avarage);
                $month=$month-1;
                
                $k=$j;
                echo "Входим в рекурсию";
                $this->get_average_coverage($public_id, $month, $year, $k);
                echo "<br>Вышли из рекурсии";
                return true;
                } 
                
               
                
            }
            
            sleep(0.4);
            
        }
        
        $array_of_posts_views_count   = count($array_of_posts_views);
        $array_of_posts_views_sum     = array_sum($array_of_posts_views);
        $array_of_posts_views_avarage = $array_of_posts_views_sum / $array_of_posts_views_count;
        $this->set_average_coverage_to_db($public_id, $year, $month, $array_of_posts_views_avarage);
        
        
    }
    
    public function set_average_coverage_to_db($public_id, $year, $month, $average_coverage)
    {
        
        $this->db = new SafeMySQL();
        
        
        $sql = "INSERT INTO public_views_consistency(public_id,year,month, average_coverage) VALUES(?i,?i,?i,?i)";
        $this->db->query($sql, $public_id, $year, $month, $average_coverage);
        
        
    }
    
    public function give_all_public_average_coverage()
    {
        ini_set('max_execution_time', 360000); //установка времени скрипта
        ini_set('memory_limit', '6000M'); //выдача количество оперативки php
        
        
        $public_list  = $this->get_public_list();
        $current_date = getdate(time());
        foreach ($public_list as $public) {
            $j=0;
           
                $this->get_average_coverage($public['public_id'], $current_date['mon'], $current_date['year'], $j);
            
        }
    }

    public function quality_control( $public_id, $post_views, $month ){
         $this->db = new SafeMySQL();
         $public_average_coverage= $this->db->getAll("SELECT average_coverage FROM `public_views_consistency` WHERE public_id=?i and month=?i",$public_id , $month );

         
         $viewers_procent=($post_views*100)/$public_average_coverage[0]['average_coverage'];
         echo "Паблик : $public_id <br>";
         echo "Просмотров поста : $post_views <br>";
         echo "Месяц поста : $month <br>";
         echo 'Средний охват паблика за '.$month.' месяц равен'. $public_average_coverage[0]['average_coverage'].'<br>';
         echo "Процент от среднего поста $viewers_procent  <br>";
          echo "<hr>";
         if ( $viewers_procent>1){
            return "true";
         }else{
            return "false";
         }



    }
    
    public function get_image_from_attachment($attachment){

        $count_of_attachment=count($attachment);
        //var_dump($attachment);
        $resuly_img_link_array=array();
        for($i=0; $i<$count_of_attachment; $i++){
            //echo $attachment[$i]->photo->photo_807."<br>";
            
            $array_size=array();
            foreach ($attachment[$i]->photo as $key => $value) {
               $length= strlen($key);
                $sub_count=substr_count($key, "photo_");
                if ($sub_count){
                $size_img=substr($key, 6);
                $array_size[]=$size_img;    
              
                }
            }
            $max_size=max($array_size);
              
              $name="photo_".$max_size;
              
              $img_link=$attachment[$i]->photo->$name;
              
              $result_img_link_array[]=$img_link;

        }
      //  echo "<h1>Результирующий массив изображений</h1>";
       // var_dump($result_img_link_array);
        return $result_img_link_array;
    }

    public function get_posts_from_db(){
         $this->db = new SafeMySQL();
         $array_posts=$this->db->getAll("SELECT * FROM post_original  LIMIT 1 ");
        
         return unserialize($array_posts[0]['post_attachments']);

    }

    public function show_attachment(){
        vk::set_token("c5ee1581bca9b5c91e5c88820b8c14aeaa93038b8afa44d2caf5abffcb91440e17aa9062f258f0eec71b1");
        $attachment=$this->get_posts_from_db();
        $image_links=$this->get_image_from_attachment($attachment);
        $server_image=$this->copy_image_from_to_dir($image_links);
        foreach ($server_image as  $value) {
           $this->draw_grid_on_image($value);
        }
       echo '<h1>'.$server_image[1].'</h1>';     
        $imgid = $this->upload_image("32753197","http://tapochek.net/images/TN.png");
       // echo '<h1>'.$imgid.'</h1>';
         vk::method("wall.post", array("attachments" => $imgid));
    }


    public function copy_image_from_to_dir($image_links){
        $server_dir=array();
        foreach ($image_links as  $value) {
            $img_url=$value;
              $img_name=basename($img_url);
              copy($img_url, 'images/image_from_vk/'.basename($img_url));
              $server_dir[]="images/image_from_vk/". $img_name;
              
        }
       
       return $server_dir;
        
    }


    public function draw_grid_on_image($image_path){
        list($temp_width, $temp_height, $temp_type) = getimagesize($image_path);
        echo $temp_width.'<br>';
          echo $temp_height.'<br>';
            echo $temp_type.'<br>';
        $img=imagecreatefromjpeg($image_path);
       $red   = imagecolorallocate($img, 255, 0, 0);
         ImageColorTransparent( $img, $red );
          $alpha = 117;
       imagesetthickness($img, 1);
       $alphaColor = ImageColorAllocateAlpha( $img, 255, 0, 0, $alpha );

        for ($i=0; $i<$temp_width; $i+=10){
            imageline ($img, $i, 0, $i, $temp_height, $alphaColor);
           
        }
        for ($i=0; $i<$temp_height; $i+=10){
            imageline ($img, 0, $i ,  $temp_width, $i, $alphaColor);
        }
        imagejpeg($img, $image_path ,100);
    }


         public   function send_image($url, $img)
        {   echo $img;
            echo $url;
            $post_params = array(
            "photo_" => $img);
                    
         
             $ch = curl_init();
             curl_setopt($ch, CURLOPT_URL, $url);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
             curl_setopt($ch, CURLOPT_POST, true);
             curl_setopt($ch, CURLOPT_POSTFIELDS, $post_params);
             $result = curl_exec($ch);   
         
             return $result;      
         }
                 
        // Загрузить картинку на сервера ВК и вернуть ее ID         
        public function upload_image($owner_id,$img)
        {
                     
           // Получаем адрес для загрузки фотографии         
           $upload_url = vk::method("photos.getWallUploadServer")->response->upload_url;
           echo "<h1> $upload_url</h1>";
             echo "<hr>";
            // Загружаем картинку на полученный адрес       
            $r = json_decode($this->send_image($upload_url,"@".$img));
            var_dump($r);
            echo "<hr>";
            $photo_id = vk::method("photos.saveWallPhoto",
            array(
                "user_id" => $owner_id,
                "photo" => $r->photo,
                "server" => $r->server,
                "hash" => $r->hash
                )
              );
               
               var_dump($photo_id);  // Выводим содержимое ответа              
               return $photo_id->response[0]->id; // Возвращаем id изображения
        }
         
         
      //  vk::set_token("cb2cac6c39eaf7e68a16c9cc2c0e798e35c22c4f44d0281bd08dd60a1e7a609dac4345a4dd2f364c8ed47");
         
         
      //  $imgid = upload_image("374254461","1.jpg"); // загружаем картинку
         
     //   // Выкладываем запись на стену и прикрепляем к ней загруженную ранее картинку
    //    vk::method("wall.post", array("attachments" => $imgid));
            
}

