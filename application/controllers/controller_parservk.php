<?php
class Controller_Parservk extends Controller
{
	function __construct()
	{
		$this->model = new Model_Parservk();
		$this->view = new View();
	}
	function action_index()
	{	
		$this->model->get_posts_from_vk();
	}
	function action_setdata()
	{
		$this->model->give_all_public_average_coverage();
		
	}
	function action_deletelocation(){
		try {
		    if (!isset($_POST['location_id'])) {
		        throw new Exception('Не указан id записи');
		    }
		    $data=$_POST['location_id'];
		    
   		 
         $result=$this->model->delete_location($data);
		 echo $result;   
		    
		} catch(Exception $e) {
		    echo json_encode(array('err'=>'Ошибка: '.$e->getMessage()));
		}
   	}
   	function action_updatelocation(){
        try {
            
            $name    = $_POST['name'];
           
            $id      = $_POST['id'];	
            if ( !isset($name) ) {
                throw new Exception('Не указаны данные записи');
            }
            
            
            
            $note = $this->model->update_location($id, $name);
            echo "success";
        }
        catch (Exception $e) {
            echo 'Ошибка: ' . $e->getMessage();
        }
    }
}