<?
class Controller_Editdirections extends Controller
{
    function __construct()
    {
        $this->model = new Model_Editdirections();
        $this->view  = new View();
    }
    function action_index()
    {
        $data = $this->model->get_data();
        $count= $this->model->get_count_of_table_rows();
        $this->view->generate('editdirections_view.php', 'template_view.php', $data, $count);
    }
    function action_setdata()
    {
       
        
    }
    function action_deletedirection()
    {
       
    }
    function action_updatedirection()
    {
        
        }
    function action_getselectdata(){

        
        if (!isset($_POST['type_id']) || !$_POST['type_id']) {
                exit("Нет данных определяющих тип запроса");
            }
            else {
                $this->model->get_select_data($_POST['type_id']);
                    
                
                
                }
            }
       
       



    
}

