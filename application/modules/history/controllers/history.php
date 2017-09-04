<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class History extends MX_Controller {

    function __construct() {
        parent::__construct();

        // check if user logged in 
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }

        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('qms_model');
    }

    public function index() {
        $meta = $this->meta;
        $this->load->view('commons/header', $meta);
        $this->load->view('history');
        $this->load->view('commons/footer');
    }
	
    public function getData() {
        $arr = $this->qms_model->getAllHistory();
		
		foreach($arr as $key => $value){
			$arr[$key]['product_id'] = $this->qms_model->getProductName($arr[$key]['product_id']);
			$arr[$key]['created_by'] = $this->qms_model->getUserName($arr[$key]['created_by']);
		}
		
        echo json_encode($arr);
    }
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
