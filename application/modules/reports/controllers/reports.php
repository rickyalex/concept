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
	}
	
    public function index()
    {	
        $this->load->view('commons/header', $meta);
        $this->load->view('reports', $data);
        $this->load->view('commons/footer');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
