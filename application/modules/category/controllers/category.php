<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category extends MX_Controller {

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
        $this->load->view('category', $data);
        $this->load->view('commons/footer');
    }
	
	public function form() {
		if ($this->uri->segment(3) !== FALSE){
			$mode = "update";
			
			$id = $this->uri->segment(4);
			$arr = $this->qms_model->getCategory($id);
			$data['result'] = $arr;
		}
		
		$data['mode'] = $mode;
		
        $meta = $this->meta;
        $this->load->view('commons/header', $meta);
        $this->load->view('form', $data);
        $this->load->view('commons/footer');
    }

    public function getData() {
        $arr = $this->qms_model->getAllCategory();
        echo json_encode($arr);
    }
	
	public function saveData(){
		foreach($_POST as $key => $value){
			$data[$key] = $this->input->post($key);
		}
		
		if($data['category']=='') die('Category Empty !');
		
		if ($data['id'] == '' || $data['id'] == null){
			//mode insert;
			
			$data['category_id'] = $this->generate_category_no();
			$this->qms_model->submitTableData('m_kategori',$data);
			$res = "Insert Success";
		}
		else{
			//mode update;
			
			$this->db->where('id', $data['id']);
			$query = $this->db->update('m_kategori' ,$data);
			if($query) $res = "Update Success";
			else $res = "Update Error";
		}
		
		die($res);
	}
	
	public function generate_category_no(){
		$code_max = $this->qms_model->getMaxID('m_kategori');
		
		return "C".str_pad("".$code_max."", 5, '0', STR_PAD_LEFT);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
