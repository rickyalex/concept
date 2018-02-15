<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Division extends MX_Controller
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
            'activeMenu' => 'master',
            'activeTab' => 'supir'
        );	
	}
	
    public function index()
    {
        $this->load->helper('xcrud');

        $xcrud = xcrud_get_instance();
        $xcrud->table('divisi');
				$xcrud->table_name('divisi');
				$xcrud->default_tab('divisi');
				$xcrud->columns('id,kode_divisi,nama_divisi,keterangan');
				$xcrud->fields('id,kode_divisi,nama_divisi,keterangan');
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
				if ( access != "admin") {
				//$xcrud->where('divisi=',access_group);
				$xcrud->unset_add();
				$xcrud->unset_remove();
				$xcrud->unset_edit();
			}
				$xcrud->unset_csv();
			//	$xcrud->label('hasil_scan','Foto');
				//$xcrud->unset_remove();
				$xcrud->unset_search();
				 $xcrud->benchmark();
				//$xcrud->unset_limit();
				 // $xcrud->set_attr('first_name',array('ReadOnly'=>'True'));
				 // $xcrud->set_attr('last_name',array('disabled'=>'True'));
				 // $xcrud->set_attr('default_group',array('ReadOnly'=>'True'));
				// $xcrud->change_type('foto','image',array('width' => 2, 'height' => 2));
				$xcrud->unset_title();
				//$xcrud->relation('jabatan','jabatan','kode_jabatan','nama_jabatan');
				
				
        $data['content'] = $xcrud->render();
		
		
				$meta = $this->meta;			
				$this->load->view('commons/header',$meta);	
				
        $this->load->view('division', $data);
        $this->load->view('commons/footer');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
