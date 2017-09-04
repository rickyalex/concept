<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Receive_slip extends MX_Controller {

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
            'activeTab' => 'Receive_slip'
        );
    }

    public function index() {
        $meta = $this->meta;
        $this->load->view('commons/header', $meta);
        $this->load->view('receive_slip', $data);
        $this->load->view('commons/footer');
    }
	
	public function form() {
		
		if ($this->uri->segment(3) !== FALSE){
		
			$mode = $this->uri->segment(4);
			
			if ($mode == "update"){
				//mode update
				if ($this->uri->segment(5) !== FALSE){
					
					if ($this->uri->segment(7) !== FALSE){
						//update detail
						
						$id = $this->uri->segment(8);
						$arr = $this->qms_model->getReceiveSlipDetail($id);
						$form = 'form_detail';
					}
					else{
						//update header
						
						$id = $this->uri->segment(6);
						$arr = $this->qms_model->getReceiveSlipDetail($id);
						$form = 'form_header';
					}
				}
			}
			elseif ($mode == "add") {
				//mode add
				
				if ($this->uri->segment(5) !== FALSE){
					//add detail
					$data['id'] = $this->uri->segment(6);
					$form = 'form_detail';
					$arr = $this->qms_model->getAllProduct();
					
					
					foreach($arr as $key => $value){
						$product[$key]['id'] = $arr[$key]['product_id'];
						$product[$key]['text'] = $arr[$key]['description'];
					}
					$data['all_product'] = json_encode($product);
					//die(print_r($data));
				}
				else{
					//add header
					$arr['document_no'] = $this->generate_slip_no();
					$form = 'form_header';
				}
				
			}
			else {
				die('no parameter found');
			}
			
			$data['result'] = $arr;
		}
		else {
			die('no parameter found');
		}
		
		$vendor = $this->qms_model->getAllVendor();
						
		foreach($vendor as $key => $value){
			$all_vendor[$key]['id'] = $vendor[$key]['id'];
			$all_vendor[$key]['text'] = $vendor[$key]['vendor'];
		}
		
		//die(print_r($data));
		$data['all_vendor'] = json_encode($all_vendor);
		$data['mode'] = $mode;
		
        $meta = $this->meta;
        $this->load->view('commons/header', $meta);
        $this->load->view($form, $data);
        $this->load->view('commons/footer');
    }
	
	public function view_detail() {
		if ($this->uri->segment(3) !== FALSE){
			
			$data['id'] = $this->uri->segment(4);
			$arr = $this->qms_model->getReceiveSlip($data['id']);
			$arr['vendor'] = $this->qms_model->getVendorName($arr['vendor']);
			
			$data['result'] = $arr;
		}
		else die('no parameter found');
		
        $meta = $this->meta;
        $this->load->view('commons/header', $meta);
        $this->load->view('view_detail', $data);
        $this->load->view('commons/footer');
    }

    public function getData() {
        $arr = $this->qms_model->getAllReceiveSlip();
        
        foreach ($arr as $key => $field) {
            $arr[$key]['vendor'] = $this->qms_model->getVendorName($arr[$key]['vendor']);
			$arr[$key]['created_by'] = $this->qms_model->getUserName($arr[$key]['created_by']);
			//$arr[$key]['action'] = "<a class='remove' href='#'><i class='glyphicon glyphicon-remove'></a>";
        }
		
        echo json_encode($arr);
    }
	
	public function getDetailData() {
		if ($this->uri->segment(3) !== FALSE){
		
			$id = $this->uri->segment(4);
			
			$arr = $this->qms_model->getReceiveSlipDetail($id);
			
			foreach ($arr as $key => $field) {
				$arr[$key]['product_id'] = $this->qms_model->getProductName($arr[$key]['product_id']);
			}
			//die(print_r($arr));
		}
		else $arr = array();
		
        echo json_encode($arr);
    }
	
	public function saveData(){
		foreach($_POST as $key => $value){
			$data[$key] = $this->input->post($key);
		}
		
		if ($this->uri->segment(3) !== FALSE) $mode = $this->uri->segment(4);
				
		
		
		if($mode == "header"){
			//save header
			
			if($data['date']=='') die('Date Empty !');
			if($data['vendor']=='') die('Vendor Empty !');
		
			if ($data['id'] == '' || $data['id'] == null){
				//mode insert;
				
				$data['created_by'] = USER_ID;
				$data['date_created'] = Date('Y-m-d');
				
				$this->qms_model->submitTableData('receive_slip',$data);
				$res = "Insert Success";
			}
			else{
				//mode update;
				
				$this->db->where('id', $data['id']);
				$query = $this->db->update('receive_slip' ,$data);
				if($query) $res = 'Update Success';
				else $res = 'Update Error';
			}
		}
		else{
			//save detail
			
			if ($this->uri->segment(5) !== FALSE) $data['id_header'] = $this->uri->segment(6);
			else die('id header not found');
			
			if ($data['id'] == '' || $data['id'] == null){
				//mode insert;
				
				//die(print_r($data));
				$data['qty_on_hand'] = $data['qty'];
				$this->qms_model->submitTableData('rsd',$data);
				
				$inventory['qty_on_hand'] = $this->qms_model->getProductOnHand($data['product_id']);
				$inventory['last_updated'] = Date('Y-m-d h:i:s');
				
				$this->db->where('product_id', $data['product_id']);
				$query = $this->db->update('inventory_on_hand' ,$inventory);
				
				$history['document_no'] = $this->qms_model->getDocumentNo('receive_slip',$data['id_header']);
				$history['product_id'] = $data['product_id'];
				$history['qty'] = $data['qty'];
				$history['mode'] = "IN";
				//die(print_r($history));
				$this->qms_model->submitTableData('history',$history);
				
				$res = "Insert Success";
			}
			else{
				//mode update;
				//die(print_r($data));
				$this->db->where('id', $data['id']);
				$query = $this->db->update('rsd' ,$data);
				if($query) $res = 'Update Success';
				else $res = 'Update Error';
			}
		}
		
		die($res);
	}
	
	public function getAllType(){
		$arr = $this->qms_model->getAllType();
		
		foreach($arr as $key => $value){
			$res[$key]['id'] = $arr[$key]['id'];
			$res[$key]['text'] = $arr[$key]['type'];
		}
		
		return $res;
	}
	
	public function generate_slip_no(){
		$code_max = $this->qms_model->getMaxID('receive_slip');
		
		return "RS"."/".Date('m')."/".str_pad($code_max, 4, '0', STR_PAD_LEFT);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
