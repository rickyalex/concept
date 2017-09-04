<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Type extends MX_Controller {

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
        $this->load->view('type', $data);
        $this->load->view('commons/footer');
    }
	
	public function form() {
		if ($this->uri->segment(3) !== FALSE){
			$mode = "update";
			
			$id = $this->uri->segment(4);
			$arr = $this->qms_model->getType($id);
			foreach ($arr as $key => $field) {
				$arr['sel_category'] = "<option value='".$arr['id_category']."'>".$this->qms_model->getCategoryName($arr['id_category'])."</option>";
			}
			$data['result'] = $arr;
		}
		
		$data['mode'] = $mode;
		$data['all_category'] = json_encode($this->getAllCategory());
		
        $meta = $this->meta;
        $this->load->view('commons/header', $meta);
        $this->load->view('form', $data);
        $this->load->view('commons/footer');
    }
	
	public function getAllCategory(){
		$arr = $this->qms_model->getAllCategory();
		
		foreach($arr as $key => $value){
			$res[$key]['id'] = $arr[$key]['id'];
			$res[$key]['text'] = $arr[$key]['category'];
		}
		
		return $res;
	}

    public function getData() {
        $arr = $this->qms_model->getAllType();
        // //die(print_r($arr));
        foreach ($arr as $key => $field) {
            $arr[$key]['category'] = $this->qms_model->getCategoryName($arr[$key]['id_category']);
        }
        echo json_encode($arr);
    }
	
	public function saveData(){
		foreach($_POST as $key => $value){
			$data[$key] = $this->input->post($key);
		}
		
		if($data['id_category']=='') die('Category Empty !');
		if($data['type']=='') die('Type Empty !');
		
		if ($data['id'] == '' || $data['id'] == null){
			//mode insert;
			
			$data['type_id'] = $this->generate_type_no();
			$this->qms_model->submitTableData('m_type',$data);
			$res = "Insert Success";
		}
		else{
			//mode update;
			
			$this->db->where('id', $data['id']);
			$query = $this->db->update('m_type' ,$data);
			if($query) $res = "Update Success";
			else $res = "Update Error";
		}
		
		die($res);
	}
	
	public function generate_type_no(){
		$code_max = $this->qms_model->getMaxID('m_type');
		
		return "T".str_pad("".$code_max."", 5, '0', STR_PAD_LEFT);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
