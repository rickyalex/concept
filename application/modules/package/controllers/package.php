<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Package extends MX_Controller {

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
        $this->load->view('package', $data);
        $this->load->view('commons/footer');
    }
	
	public function form() {
		if ($this->uri->segment(3) !== FALSE){
			$mode = "update";
			
			$id = $this->uri->segment(4);
			$arr = $this->qms_model->getPackage($id);
			foreach ($arr as $key => $field) {
				$arr['sel_package'] = "<option value='".$arr['id_package']."'>".$this->qms_model->getPackageName($arr['id_package'])."</option>";
			}
			$data['result'] = $arr;
		}
		
		//die(print_r($data));
		
		$data['mode'] = $mode;
		$data['all_package'] = json_encode($this->getAllPackage());
		
        $meta = $this->meta;
        $this->load->view('commons/header', $meta);
        $this->load->view('form', $data);
        $this->load->view('commons/footer');
    }
	
	public function detail() {
		if ($this->uri->segment(5) !== FALSE){
			$mode = "update";
			
			$id = $this->uri->segment(6);
			$arr = $this->qms_model->getPackageDetail($id);
			foreach ($arr as $key => $field) {
				$arr[$key]['action'] = "<a class='remove' href='#'><i class='glyphicon glyphicon-remove'></a>";
			}
			$data['result'] = $arr;
		}
		
		$data['id'] = $this->uri->segment(4);
		//die(print_r($data));
		
		$data['mode'] = $mode;
		
		$product = $this->qms_model->getAllProduct();
		
		foreach($product as $item => $field){
			$product[$item]['id'] = $product[$item]['id'];
			$product[$item]['text'] = $product[$item]['description'];
		}
		
		$data['all_product'] = json_encode($product);
		
        $meta = $this->meta;
        $this->load->view('commons/header', $meta);
        $this->load->view('detail', $data);
        $this->load->view('commons/footer');
    }

    public function getData() {
        $arr = $this->qms_model->getAllPackage();
        
        foreach ($arr as $key => $field) {
			$arr[$key]['active'] = $arr[$key]['active'] == "Y" ? "<i class='glyphicon glyphicon-ok'>" : "<i class='glyphicon glyphicon-remove'>";
			$arr[$key]['action'] = "<a class='remove' href='#'><i class='glyphicon glyphicon-remove'></a>";
        }
		
        echo json_encode($arr);
    }
	
	public function getDetailData() {
		if ($this->uri->segment(3) !== FALSE){
			$id = $this->uri->segment(4);
			$arr = $this->qms_model->getPackageProducts($id);
			
			//die(print_r($arr));
        
			foreach ($arr as $key => $field) {
				$arr[$key]['product'] = $this->qms_model->getProductName2($arr[$key]['product_id']);
				$arr[$key]['action'] = "<a class='remove' href='#'><i class='glyphicon glyphicon-remove'></a>";
			}
			
			echo json_encode($arr);
		}
		else die('parameter not found');
        
		die();
    }
	
	public function saveData(){
		foreach($_POST as $key => $value){
			$data[$key] = $this->input->post($key);
		}
		
		if($data['package']=='') die('Package Name Empty !');
		
		if ($data['id'] == '' || $data['id'] == null){
			//mode insert;
			
			$data['discount'] = ($data['discount']/100); //percentage
			$data['created_by'] = USER_ID;
			$data['date_created'] = Date('Y-m-d');
			
			$this->qms_model->submitTableData('m_package',$data);
			$res = "Insert Success";
		}
		else{
			//mode update;
			$data['discount'] = ($data['discount']/100); //percentage
			
			// echo $data['discount'];
			// die;
			$this->db->where('id', $data['id']);
			$query = $this->db->update('m_package' ,$data);
			if($query) $res = 'Update Success';
			else $res = 'Update Error';
		}
		
		die($res);
	}
	
	public function saveDetail(){
		foreach($_POST as $key => $value){
			$data[$key] = $this->input->post($key);
		}
		if ($this->uri->segment(3) !== FALSE){
			$data['id_header'] = $this->uri->segment(4);
			
			if($data['product_id']=='') die('Product Empty !');		
			if($data['qty']=='') die('Qty Empty !');

			if($this->qms_model->cekProductPackageById($data['id_header'],$data['product_id'])){
				die('This product already exists!');
			}
			
			if ($data['id'] == '' || $data['id'] == null){
				//mode insert;
				
				$data['created_by'] = USER_ID;
				$data['date_created'] = Date('Y-m-d');
				
				$this->qms_model->submitTableData('mpd',$data);
				$res = "Insert Success";
			}
			else{
				//mode update;
				
				$this->db->where('id', $data['id']);
				$query = $this->db->update('mpd' ,$data);
				if($query) $res = 'Update Success';
				else $res = 'Update Error';
			}
			
			die($res);
		}
		else die('no parameter found !');
	}
	
	public function getAllPackage(){
		$arr = $this->qms_model->getAllPackage();
		
		foreach($arr as $key => $value){
			$res[$key]['id'] = $arr[$key]['id'];
			$res[$key]['text'] = $arr[$key]['package'];
		}
		
		return $res;
	}
	
	public function remove(){
		if ($this->uri->segment(3) !== FALSE){
			$id = $this->uri->segment(4);
			$this->db->where('id', $id);
			$query = $this->db->delete('m_package' ,$id);
			if($query) $res = 'Delete Success';
			else $res = 'Delete Error';
		}
		else die('no parameter found !');
		
		die($res);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
