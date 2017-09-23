<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Draft extends MX_Controller
{
    /**
	 * @author entol
	 * @see more  http://www.entol.net
	 * @email fudel.07@gmail.com 
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
	
	function __construct()
	{
		parent::__construct();
		
			// // check if user logged in 
			// if (!$this->ion_auth->logged_in())
			// {
				// redirect('auth/login');
			// }
			
		$this->load->helper('url');
		$this->load->library('form_validation');
		//$this->load->model('dn_model');
		$this->meta = array(
            //'activeMenu' => 'master',
            'activeTab' => 'message'
        );	
	}
	
    public function index()
    {
        $this->load->helper('xcrud');

        $xcrud = xcrud_get_instance();
        $xcrud->table('message');
				$xcrud->table_name('message');
				$xcrud->default_tab('message');
				$xcrud->columns('date,from,subject,message,document');
				$xcrud->fields('from,subject,message', false, 'Text Message');
				$xcrud->fields('description,image,document,remark', false, 'Attachment');
				$idn=id;
				$sent ="sent";
				$xcrud->where("message.from_id ='$idn' AND message.status_pesan !='$sent' ");
				$xcrud->order_by('date','desc');
				$xcrud->column_width('message','50%');
				//$xcrud->column_cut(100,'message');
				
				$xcrud->button('http://10.2.2.32/qms/draft/drafts?dari={id}', 'Forward',  'glyphicon glyphicon-send');
			
				$xcrud->column_class('from','align-center font-bold');
				$xcrud->column_pattern('date', '<a href="#" class="xcrud-action" data-task="view" data-primary="{id}">{value}</a>');
				$xcrud->column_pattern('from', '<a href="#" class="xcrud-action" data-task="view" data-primary="{id}">{value}</a>');
				$xcrud->buttons_position('left');
				//$xcrud->fields('description,image,document,remark', false, 'Add Document');
				$xcrud->label('document','Attachment');
				$xcrud->change_type('image','image');
				$xcrud->change_type('document','file');
				$xcrud->unset_add();
				// $xcrud->unset_remove();
				 $xcrud->unset_edit();
			// //}
				$xcrud->unset_csv();
			//	$xcrud->label('hasil_scan','Foto');
				//$xcrud->unset_remove();
				//$xcrud->unset_search();
				 $xcrud->benchmark();
				// $xcrud->pass_var('from',USER_NAME,'create');
				// echo USER_NAME ;
				//$xcrud->unset_limit();
				// $xcrud->p('first_name',array('ReadOnly'=>'True'));
				 $xcrud->set_attr('from',array('ReadOnly'=>'True' ,'value'=>USER_NAME));
				 // $xcrud->set_attr('last_name',array('disabled'=>'True'));
				 // $xcrud->set_attr('default_group',array('ReadOnly'=>'True'));
				// $xcrud->change_type('foto','image',array('width' => 2, 'height' => 2));
				$xcrud->unset_title();
				//$xcrud->relation('to','view_users','id','nama');
		//S$this->db->from('view_users');		
		$data['view_users'] = $this->db->get('view_users');				
        $data['content'] = $xcrud->render();
		$meta = $this->meta;			
		$this->load->view('commons/header',$meta);
        $this->load->view('draft', $data);
        $this->load->view('commons/footer');
    }
		function drafts()
   {
	   $data['view_users'] = $this->db->get('view_users');
		$id= $_GET['dari'];
		$this->load->library('lib_pagination');                         //Load the "lib_pagination" library
        $pg_config['sql']      = "SELECT * FROM message WHERE id='".$id."'";              //your SQL, don't add ";" in your SQL query
        $pg_config['per_page'] = 1;                                     //Display items per page
        $data = $this->lib_pagination->create_pagination($pg_config);   //Load function in "lib_pagination" libraryfor create pagination. 
	    $this->load->view('commons/header',$data);		
        $this->load->view('edit',$data);
        $this->load->view('commons/footer');
   
   }
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
