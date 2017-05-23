<?
class Controller_Editposts extends Controller
{
    function __construct()
    {
        $this->model = new Model_Editposts();
        $this->view  = new View();
    }
    function action_index()
    {
        $data = $this->model->get_data();
        $count= $this->model->get_count_of_table_rows();
        $this->view->generate('editposts_view.php', 'template_view.php', $data, $count);
    }
    function action_setdata()
    {
        $post_name    = $_POST['post_name'];
        $post_address = $_POST['post_address'];
        $location_id  = $_POST['location_id'];
        $post_number  = $_POST['post_number'];
        $this->model->set_post($location_id, $post_name, $post_address, $post_number);
        header('Location: /editposts');
        
    }
    function action_deletepost()
    {
        try {
            $data = $_POST['post_id'];
            
            if (!isset($data)) {
                throw new Exception('Не указан id записи');
            }
            
            
            $result = $this->model->delete_post($data);
            //echo $result;   
            
        }
        catch (Exception $e) {
            echo json_encode(array(
                'err' => 'Ошибка: ' . $e->getMessage()
            ));
        }
    }
    function action_updatepost()
    {
        try {
            $number  = $_POST['number'];
            $name    = $_POST['name'];
            $address = $_POST['address'];
            $id      = $_POST['id'];	
            if (!isset($number) or !isset($name) or !isset($address)) {
                throw new Exception('Не указаны данные записи');
            }
            
            
            
            $note = $this->model->update_post($number, $name, $address, $id);
            echo "success";
        }
        catch (Exception $e) {
            echo 'Ошибка: ' . $e->getMessage();
        }
    }
}
