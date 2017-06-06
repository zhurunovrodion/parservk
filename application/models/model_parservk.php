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
        $posts = json_decode(file_get_contents('https://api.vk.com/method/wall.get?owner_id=-' . $public_id . '&offset=' . $posts_offset . '&count=100&v=5.65'));
        return $posts;
    }
    
    
    public function set_post_to_db($public_id, $post_text, $post_likes, $post_reposts, $post_date, $post_photo_vk_link, $quality)
    {
        
        $this->db = new SafeMySQL();
        
        
        $sql = "INSERT INTO post_original(public_id,post_text,post_likes,post_reposts, date_vk,post_photo_vk_link, quality_post) VALUES(?i,?s,?i,?i,?i,?s,?i)";
        $this->db->query($sql, $public_id, $post_text, $post_likes, $post_reposts, $post_date, $post_photo_vk_link, $quality);
        
        
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
        var_dump($public_list);
        $t = 1;
        foreach ($public_list as $public) {
            
            for ($j = 0; $j < 10000; $j += 100) {
                
                $posts = $this->parser_posts_query($public['public_id'], $j);
                
                for ($i = 0; $i <= 100; $i++) {
                    
                    $post_text          = $this->clearStr($posts->response->items[$i]->text);
                    $post_likes         = $posts->response->items[$i]->likes->count;
                    $post_reposts       = $posts->response->items[$i]->reposts->count;
                    $post_date          = $posts->response->items[$i]->date;
                    $post_photo_vk_link = $posts->response->items[$i]->attachment->photo->src_big;
                    $post_views = $posts->response->items[$i]->views->count;
                    
                    
                    if ($post_reposts < 1) {
                        continue;
                    }
                    
                    $quality = $post_likes / $post_reposts;
                    if ($quality > 50) {
                        continue;
                    }
                    
                    if (strlen($post_text) < 5) {
                        continue;
                    }
                    
                    if (($this->ad_filter($post_text)) == "false") {
                        continue;
                    }
                    
                    if (empty($post_photo_vk_link)) {
                        continue;
                    }
                    
                    $shingle = $this->uniq_post_analyze($post_text);
                    
                    if ($shingle == "false") {
                        
                        continue;
                    }
                    $this->set_post_to_db($public['public_id'], $post_text, $post_likes, $post_reposts, $post_date, $post_photo_vk_link, $quality);
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
            // var_dump($posts);
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
    
}