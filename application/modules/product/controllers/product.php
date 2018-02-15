<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product extends MX_Controller {

    function __construct() {
        parent::__construct();

        // check if user logged in 
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }

        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('qms_model');
        $this->meta = array(
            //'activeMenu' => 'master',
            'activeTab' => 'fatigue'
        );
    }

    public function index() {
        $meta = $this->meta;
        $this->load->view('commons/header', $meta);
        $this->load->view('product', $data);
        $this->load->view('commons/footer');
    }
	
	public function form() {
		if ($this->uri->segment(3) !== FALSE){
			$mode = "update";
			
			$id = $this->uri->segment(4);
			$arr = $this->qms_model->getProduct($id);
			foreach ($arr as $key => $field) {
				$arr['sel_type'] = "<option value='".$arr['id_type']."'>".$this->qms_model->getTypeName($arr['id_type'])." - ".$this->qms_model->getCategoryName($this->qms_model->getCategoryID($arr['id_type']))."</option>";
				$arr['sel_package'] = "<option value='".$arr['id_package']."'>".$this->qms_model->getPackageName($arr['id_package'])."</option>";
			}
			$data['result'] = $arr;
		}
		
		//die(print_r($data));
		
		$data['mode'] = $mode;
		$data['all_type'] = json_encode($this->getAllType());
		$data['all_package'] = json_encode($this->getAllPackage());
		
        $meta = $this->meta;
        $this->load->view('commons/header', $meta);
        $this->load->view('form', $data);
        $this->load->view('commons/footer');
    }

    public function getData() {
        $arr = $this->qms_model->getAllProduct();
        
        foreach ($arr as $key => $field) {
            $arr[$key]['type'] = $this->qms_model->getTypeName($arr[$key]['id_type']);
			$arr[$key]['package_id'] = $this->qms_model->getPackageName($arr[$key]['package_id']);
			$arr[$key]['active'] = $arr[$key]['active'] == "Y" ? "<i class='glyphicon glyphicon-ok'>" : "<i class='glyphicon glyphicon-remove'>";
			$arr[$key]['action'] = "<a class='remove' href='#'><i class='glyphicon glyphicon-remove'></a>";
        }
		
        echo json_encode($arr);
    }
	
	public function saveData(){
		foreach($_POST as $key => $value){
			$data[$key] = $this->input->post($key);
		}
		
		if($data['id_type']=='') die('Type Empty !');
		if($data['description']=='') die('Name Empty !');
		
		if ($data['id'] == '' || $data['id'] == null){
			//mode insert;
			
			$data['product_id'] = $this->generate_product_no();
			$data['created_by'] = USER_ID;
			$data['date_created'] = Date('Y-m-d');
			
			$this->qms_model->submitTableData('m_product',$data);

			if($data['id_type']==1){
				$inventory['product_id'] = $data['product_id'];
				$inventory['qty_on_hand'] = 0;
				$inventory['last_updated'] = Date('Y-m-d');
				$this->qms_model->submitTableData('inventory_on_hand',$inventory);
			}
			$res = "Insert Success";
		}
		else{
			//mode update;
			
			$this->db->where('id', $data['id']);
			$query = $this->db->update('m_product' ,$data);
			if($query) $res = 'Update Success';
			else $res = 'Update Error';
		}
		
		die($res);
	}
	
	public function getAllType(){
		$arr = $this->qms_model->getAllType();
		
		foreach($arr as $key => $value){
			$res[$key]['id'] = $arr[$key]['id'];
			$res[$key]['text'] = $arr[$key]['type'] .  " - " . $arr[$key]['category_name'];
		}
		
		return $res;
	}
	
	public function getAllPackage(){
		$arr = $this->qms_model->getAllPackage();
		
		foreach($arr as $key => $value){
			$res[$key]['id'] = $arr[$key]['id'];
			$res[$key]['text'] = $arr[$key]['package'];
		}
		
		return $res;
	}
	
	public function generate_product_no(){
		$code_max = $this->qms_model->getMaxProductID('m_product');
		
		// return str_pad("".$code_max."", 5, '0', STR_PAD_LEFT);
		return sprintf("%03s", $code_max);
	}
	
	public function remove(){
		if ($this->uri->segment(3) !== FALSE){
			$id = $this->uri->segment(4);
			$this->db->where('id', $id);
			$query = $this->db->delete('m_product');
			if($query) $res = 'Delete Success';
			else $res = 'Delete Error';
		}
		else die('no parameter found !');
		
		die($res);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
