<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports extends MX_Controller
{

 	/**
	 * @author entol
	 * @see more  http://www.entol.net
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
	
	function __construct()
	{
		parent::__construct();
		
		// check if user logged in 
		// if (!$this->ion_auth->logged_in())
	  	// {
			// redirect('auth/login');
	  	// }
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->model('qms_model');
	}
	
    public function index()
    {	
		
		
        $this->load->view('commons/header', $meta);
        $this->load->view('reports');
        $this->load->view('commons/footer');
    }
	
	public function getNonServiceData(){
		$res = $this->qms_model->getNonServiceData();
		
		echo json_encode($res);
	}
	
	public function getServiceData(){
		$res = $this->qms_model->getServiceData();
		
		echo json_encode($res);
	}
	
	public function getPackageData(){
		$res = $this->qms_model->getPackageData();
		
		echo json_encode($res);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
