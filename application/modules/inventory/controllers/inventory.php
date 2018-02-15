<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inventory extends MX_Controller {

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
        $this->load->view('inventory');
        $this->load->view('commons/footer');
    }
	
    public function getData() {
        $arr = $this->qms_model->getInventory();
		
		foreach($arr as $key => $value){
			$arr[$key]['product'] = $this->qms_model->getProductName($arr[$key]['product_id']);
            $arr[$key]['min_stock'] = (int) $this->qms_model->getMinStock($arr[$key]['product_id']);
		}
		
        echo json_encode($arr);
    }
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
