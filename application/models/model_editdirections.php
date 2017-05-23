<?php
class Model_Editdirections extends Model
{	
	public $db;
	 public $table_posts;
    public $table_locations;
    public $table_location_post_consistency;
    public $res_posts;
    public $res_location;
    public $res_location_post_consistency;
	
	public function get_data()
	{
		$this->db                              = new SafeMySQL();
        $this->table_posts                     = 'posts';
        $this->table_locations                 = 'locations';
        $this->table_location_post_consistency = 'location_post_consistency';
        $this->res_location_post_consistency   = $this->db->getAll("SELECT * FROM ?n", $this->table_location_post_consistency);
        $this->res_posts                       = $this->db->getAll("SELECT * FROM ?n", $this->table_posts);
        $this->res_locations                   = $this->db->getAll("SELECT * FROM ?n", $this->table_locations);
        //var_dump($this->res_location_post_consistency);
        
        
        $result = array(
            $this->res_locations,
            $this->res_posts,
            $this->res_location_post_consistency
        );
        return $result;
		}
	public function set_location($data){

		
	}
	
	public function delete_location($data){
		
		
		
	}
	public function update_location($id, $value){
		
	}

	public  function get_select_data($data){
		$this->db                              = new SafeMySQL();
        $this->table_posts                     = 'posts';
        $this->table_locations                 = 'locations';
        $this->table_location_post_consistency = 'location_post_consistency';
        $this->res_location_post_consistency   = $this->db->getAll("SELECT * FROM ?n", $this->table_location_post_consistency);
        $this->res_posts                       = $this->db->getAll("SELECT * FROM ?n", $this->table_posts);
        $this->res_locations                   = $this->db->getAll("SELECT * FROM ?n", $this->table_locations);
        //var_dump($this->res_location_post_consistency);
        global $merde;
        $result_select=array();
        foreach ($this->res_locations as $location) {

        	foreach ($this->res_posts as $posts) {
        	        		foreach ($this->res_location_post_consistency as $location_post_consistency) {
        	        			if($location_post_consistency['location_post_consistency_location_id']==$location['location_id'] and 
        	        				$location_post_consistency['location_post_consistency_post_id']==$posts['post_id']){
        	        				$merge[$posts['post_id']]=$posts['post_name'];
        	        				
        	        			}
        	        		}
        	        	}
        	        	$merde[$location['location_id']]=$merge;
        	        	$merge=array();        	
        }
       
        $query = trim($data); // Очищаем от лишних пробелов
                
                          
                    $type_id = trim($data);
                    
                     // Очистим его от лишних пробелов
                    // Формируем массив с ответом
                    $result = NULL;
                    $i = 0;
                    foreach ($merde[$type_id] as $kind_id => $kind) {
                        $result[$i]['kind_id'] = $kind_id;
                        $result[$i]['kind'] = $kind;
                        $i++;
                    }
                    
                    echo json_encode($result);

	}
}