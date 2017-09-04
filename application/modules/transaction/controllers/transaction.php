<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaction extends MX_Controller {
	
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
		
		
    }
	
	public function form(){
		if ($this->uri->segment(3) !== FALSE){
			//mode update
			$mode = "update";
			$data['id'] = $this->uri->segment(4);
			$data['result'] = $this->qms_model->getTransaction($data['id']);
			$data['result']['total'] = $this->qms_model->getTotal($data['result']['order_no']);
		}
		else{
			//mode insert
			$mode = "insert";
			$data['order_no'] = $this->generateOrderNo();
		}
		
		
		
		$arr = $this->qms_model->getInventoryProduct();
		
		foreach($arr as $key => $value){
			$product[$key]['id'] = $arr[$key]['id'];
			$product[$key]['text'] = $this->qms_model->getProductName($arr[$key]['product_id'])." - ".$arr[$key]['total'];
		}
		
		$data['all_product'] = json_encode($product);
		
        $header['mode'] = $this->mode;
		$data['mode'] = $mode;
		//die(print_r($data));
        $this->load->view('commons/header', $header);
        $this->load->view('transaction',$data);
        $this->load->view('commons/footer');
	}
	
    public function getData() {
		if ($this->uri->segment(3) !== FALSE){
			$id_header = $this->uri->segment(4);
			$arr = $this->qms_model->getTransactionDetail($id_header);
			
			foreach($arr as $key => $value){
				$arr[$key]['product'] = $this->qms_model->getProductName($arr[$key]['product_id']);
			}
		}
		
        echo json_encode($arr);
    }
	
	public function getPrice() {
        if ($this->uri->segment(3) !== FALSE){
			$receive_id = $this->uri->segment(4);
			$res = $this->qms_model->getProductPrice($receive_id);
			/* if(substr($receive_id,0,2)=="PA"){
				//package
				$res = 0;
			}
			elseif(substr($receive_id,0,2)=="PR"){
				//product
				
			} */
		
			echo $res;
		}
    }
	
	public function getTotal() {
        if ($this->uri->segment(3) !== FALSE){
			$order_no = $this->uri->segment(4);
			
			$res = $this->qms_model->getTotal($order_no);
		
			echo $res;
		}
    }
	
	public function saveHeader(){
		foreach($_POST as $key => $value){
			$data[$key] = $this->input->post($key);
		}
		
		//die(print_r($data));
		if ($data['id'] == '' || $data['id'] == null){
			//mode insert;
			
			$this->qms_model->submitTableData('order_header',$data);
			//$res = "Insert Success";
		}
		else{
			//mode update;
			
			$this->db->where('id', $data['id']);
			$query = $this->db->update('order_header' ,$data);
			//if($query) $res = 'Update Success';
			//else $res = 'Update Error';
		}
		
	}
	
	public function saveDetail(){
		foreach($_POST as $key => $value){
			$data[$key] = $this->input->post($key);
		}
		//die(print_r($data));
		if ($this->uri->segment(3) !== FALSE){
			$order_no = $this->uri->segment(4);
			
			$data['id_header'] = $this->qms_model->getOrderID($order_no);
		}
		
		if ($data['id'] == '' || $data['id'] == null){
			//mode insert;
			$receive_id = $data['product_id'];
			$qty_on_hand = $this->qms_model->getQtyOnHand($receive_id);
			
			$rsd['qty_on_hand'] = $qty_on_hand - $data['qty'];
				
			if($rsd['qty_on_hand'] >= 0){
				$data['product_id'] = $this->qms_model->getProductID($data['product_id']);
				$this->qms_model->submitTableData('order_detail',$data);
			
				$this->db->where('id', $receive_id);
				$query = $this->db->update('rsd' ,$rsd);
				
				$this->db->where('product_id', $data['product_id']);
				$query = $this->db->update('inventory_on_hand' ,$rsd);
				
				$history['document_no'] = $this->qms_model->getDocumentNo('receive_slip',$receive_id);
				$history['product_id'] = $this->qms_model->getProductID($data['product_id']);
				$history['qty'] = $data['qty'];
				$history['mode'] = "OUT";
				//die(print_r($history));
				$this->qms_model->submitTableData('history',$history);
			}
			else die('Qty is greater than on hand !');
			
			/* if ($data['id'] == '' || $data['id'] == null){
			//mode insert;
			$product_id = $data['product_id'];
			if(substr($product_id,0,2)=="PA"){
				//package
				$package_id = substr($product_id,2);
				//die('package '.$package_id);
				$package = $this->qms_model->getPackageProducts($package_id);
				
				foreach($package as $product => $item){
					$qty_on_hand = $this->qms_model->getQtyOnHand($package[$product]['product_id']);
					
					$rsd['qty_on_hand'] = $qty_on_hand - $package[$product]['qty'];
				
					if($rsd['qty_on_hand'] >= 0){
						$data['product_id'] = $this->qms_model->getProductID($package[$product]['product_id']);
						$this->qms_model->submitTableData('order_detail',$data);
					
						$this->db->where('id', $receive_id);
						$query = $this->db->update('rsd' ,$rsd);
						
						$this->db->where('product_id', $data['product_id']);
						$query = $this->db->update('inventory_on_hand' ,$rsd);
					}
					else die('Qty is greater than on hand !');
				}
			}
			elseif(substr($product_id,0,2)=="PR"){
				//product
				$receive_id = substr($product_id,2);
				die('package '.$receive_id);
				$qty_on_hand = $this->qms_model->getQtyOnHand($receive_id);
			
				$rsd['qty_on_hand'] = $qty_on_hand - $data['qty'];
				
				if($rsd['qty_on_hand'] >= 0){
					$data['product_id'] = $this->qms_model->getProductID($data['product_id']);
					$this->qms_model->submitTableData('order_detail',$data);
				
					$this->db->where('id', $receive_id);
					$query = $this->db->update('rsd' ,$rsd);
					
					$this->db->where('product_id', $data['product_id']);
					$query = $this->db->update('inventory_on_hand' ,$rsd);
				}
				else die('Qty is greater than on hand !');
				
				//$res = "Insert Success";
			} */
			
			
		}
		else{
			//mode update;
			
			$this->db->where('id', $data['id']);
			$query = $this->db->update('order_detail' ,$data);
			// if($query) $res = 'Update Success';
			// else $res = 'Update Error';
		}
		
		$header['subtotal'] = $this->qms_model->getTotal($order_no);
		$this->db->where('id', $data['id_header']);
		$query = $this->db->update('order_header' ,$header);
		
		$arr = $this->reload($data['id_header']);
		echo json_encode($arr);
		//die($res);
	}
	
	public function reload($id_header) {
		$arr = $this->qms_model->getTransactionDetail($id_header);
		
		foreach($arr as $key => $value){
			$arr[$key]['product'] = $this->qms_model->getProductName($arr[$key]['product_id']);
		}
		
        return $arr;
    }
	
	public function checkout() {
		die('Print Out Preview');
    }
	
	// public function getTestData() {
		// $arr = $this->qms_model->getTransactionDetail(1);
		
		// foreach($arr as $key => $value){
			// $arr[$key]['product'] = $this->qms_model->getProductName($arr[$key]['product_id']);
		// }
		
        // echo json_encode($arr);
    // }
	
	public function getDataByOrderNo() {
		if ($this->uri->segment(3) !== FALSE){
			$order_no = $this->uri->segment(4);
			
			$arr = $this->qms_model->getTransactionDetailByOrderNo($order_no);
			die(print_r($arr));
			foreach($arr as $key => $value){
				$arr[$key]['product'] = $this->qms_model->getProductName($arr[$key]['product_id']);
			}
		}
		
        echo json_encode($arr);
    }
	
	public function generateOrderNo() {
        $res = $this->qms_model->generateOrderNo();
		return $res;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
