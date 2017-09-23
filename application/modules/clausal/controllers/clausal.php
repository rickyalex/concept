<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Clausal extends MX_Controller
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
        $xcrud->table('clausal');
		$xcrud->table_name('clausal');
		$xcrud->default_tab('clausal');
		$xcrud->unset_title();
		//$xcrud->relation('jabatan','jabatan','kode_jabatan','nama_jabatan');
				
				
        $data['content'] = $xcrud->render();
		
		
		$meta = $this->meta;			
		$this->load->view('commons/header',$meta);	
				
        $this->load->view('clausal', $data);
        $this->load->view('commons/footer');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
