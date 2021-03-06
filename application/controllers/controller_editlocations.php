<?php
class Controller_Editlocations extends Controller
{
	function __construct()
	{
		$this->model = new Model_Editlocations();
		$this->view = new View();
	}
	function action_index()
	{	
		$data = $this->model->get_data();
		$count= $this->model->get_count_of_table_rows();
		$this->view->generate('editlocations_view.php', 'template_view.php', $data, $count);
	}
	function action_setdata()
	{
		$location_name=$_POST['location_name'];
		$this->model->set_location($location_name);
		header('Location: http://localhost/editlocations');
		
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