<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Billed_transaction extends MX_Controller {
	
	public $mode;
	
    function __construct() {
        parent::__construct();

        // check if user logged in 
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
		
		$this->mode = $this->session->userdata('mode');
		if($this->mode != "pos") die('Invalid Login. Your Mode : '.$this->session->userdata('mode')); 
		
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('qms_model');
    }

    public function index() {
		$data['username'] = $this->qms_model->getUserName(USER_ID);
		
        $header['mode'] = $this->mode;
		
        $this->load->view('commons/header', $header);
        $this->load->view('billed_transaction',$data);
        $this->load->view('commons/footer');
    }
	
    public function getData() {
        $arr = $this->qms_model->getOpenBilledTransaction();
        foreach($arr as $key => $value){
            $arr[$key]['subtotal'] = $this->qms_model->getTotal($arr[$key]['order_no']);
            $arr[$key]['total'] = $arr[$key]['subtotal'] - ($arr[$key]['subtotal'] * $arr[$key]['discount']);
            // print_r($arr[$key]);
            //update header
            //$this->db->where('id', $arr[$key]['id']);
            //$query = $this->db->update('order_header' ,$arr[$key]);

            $arr[$key]['outstanding'] = $arr[$key]['total'] - ($arr[$key]['payment'] + $arr[$key]['down_payment']);
        }
		
        echo json_encode($arr);
    }
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
