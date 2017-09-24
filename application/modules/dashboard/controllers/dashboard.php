<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends MX_Controller
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
        $res = $this->qms_model->chart1();
        
        foreach ($res as $row) {
            $chart1[][] = "'".$row['type']."'," . $row['total'];
        }
        
        $res2 = $this->qms_model->chart2();
        
        foreach ($res2 as $row) {
            $chart2[][] = "'".$row['package']."'," . $row['total'];
        }
        
        $data['chart1'] = str_replace('"','',json_encode($chart1));
        $data['chart2'] = str_replace('"','',json_encode($chart2));
		
		$open = $this->qms_model->getOpenTransaction();
		
		$data['open'] = $open;

        $this->load->view('commons/header', $meta);
        $this->load->view('dashboard', $data);
        $this->load->view('commons/footer');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
