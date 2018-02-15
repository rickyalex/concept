<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sent_item extends MX_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -  
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
	
	function __construct()
	{
		parent::__construct();
		
		// check if user logged in 
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
		
		$this->load->helper('url');
		$this->load->library('form_validation');
		//$this->load->model('dn_model');
		$this->meta = array(
            //'activeMenu' => 'master',
            'activeTab' => 'sent_item'
        );	
	}
	
    public function index()
    {
        $this->load->helper('xcrud');

        $xcrud = xcrud_get_instance();
	
        $xcrud->table('sent_item');
				$xcrud->table_name('sent_item');
				$xcrud->default_tab('message');
				$xcrud->columns('date,to,subject,message');
				$xcrud->fields('to,subject,message', false, 'Text Message');
				$xcrud->fields('description,image,document,remark', false, 'Attachment');
				$xcrud->fields('to,subject,message');
				$xcrud->order_by('date','desc');
				$xcrud->column_width('message','70%');
				$idn=id;
				$sent ="sent";
				$xcrud->where("sent_item.from_id ='$idn' AND sent_item.status_pesan ='$sent'");
				// $idn=id;
				// $sent ="sent";
			    // $cond = array('from_id =' => id, 'status_pesan =' => $sent);
				// $xcrud->where($cond);
				//$xcrud->where("from_id ='$idn' AND status_pesan ='$sent'");
				$xcrud->column_pattern('date', '<a href="#" class="xcrud-action" data-task="view" data-primary="{id}">{value}</a>');
				$xcrud->buttons_position('left');
				//$xcrud->change_type('hasil_scan', 'image');
				//
			//	if ( access == "admin") {
				//$xcrud->where('nik=',nik);
			//	}
		//$section ="<section class="content-header"><h1>Profile<small>Profile</small></h1><ol class="breadcrumb"></section>";
		//$data['section'];		// $xcrud->unset_add();
				// $xcrud->unset_pagination();
				// $xcrud->unset_print();
				// $xcrud->unset_limitlist();
				//if ( access != "admin") {
				//$xcrud->where('divisi=',access_group);
				$xcrud->unset_add();
				//$xcrud->unset_remove();
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
				$xcrud->relation('to','view_users','id','nama_lengkap');
				
				
        $data['content'] = $xcrud->render();
		
		
				$meta = $this->meta;			
				$this->load->view('commons/header',$meta);	
				
        $this->load->view('sent_item', $data);
        $this->load->view('commons/footer');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
