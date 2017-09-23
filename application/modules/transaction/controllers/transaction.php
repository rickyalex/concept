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
		
		
		
		$arr = $this->qms_model->getInventoryProduct3();
		
		foreach($arr as $key => $value){
			$product[$key]['id'] = $arr[$key]['product_id'];
			if($arr[$key]['tipe'] == 'Non Package')
				$product_name = $this->qms_model->getProductName(substr($arr[$key]['product_id'],2));
			else
				$product_name = $this->qms_model->getPackageName(substr($arr[$key]['product_id'],2));

			$product[$key]['text'] = $product_name." - ".$arr[$key]['tipe']." - ".$arr[$key]['total'];
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
			$arr = $this->reload($id_header);
		}else
			$arr = array();
		
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
	
	public function getPrice2() {
        if ($this->uri->segment(3) !== FALSE){
			$receive_id = $this->uri->segment(4);
			$res = $this->qms_model->getAllPrice2($receive_id);

			echo json_encode($res);
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

		// echo $data['id'];
		// die;
		
		if ($data['id'] == '' || $data['id'] == null){
			//mode insert;
			$receive_id = $data['product_id'];
			$tipe = substr($receive_id,0,2);
			$receive_id = substr($receive_id,2);

			$data['tipe'] = $tipe;
			$data['product_id'] = $receive_id;
			$this->db->trans_start();
			if($tipe == 'NP'){
				$qty_on_hand = $this->qms_model->getQtyOnHand2($receive_id);
				$rsd['qty_on_hand'] = $qty_on_hand - $data['qty'];
				$qty = $data['qty'];
				// die(echo $receive_id);
				if($rsd['qty_on_hand'] >= 0){
					// $data['product_id'] = $this->qms_model->getProductID($data['product_id']);
					$this->qms_model->submitTableData('order_detail',$data);
					
					for($i=0;$i<100;$i++){
						//Update looping disini
						$cek_qty_on_hand = $this->qms_model->cekQtyOnHand($receive_id);					
						$last_qty = $cek_qty_on_hand - $qty;
						if($last_qty < 0){
							$rsd['qty_on_hand'] = 0;
						}else{
							$rsd['qty_on_hand'] = $last_qty;
						}

						$this->db->where('product_id', $receive_id);
						$this->db->where('qty_on_hand >', 0);
						$this->db->order_by("id", "asc");
						$this->db->limit(1);
						$query = $this->db->update('rsd' ,$rsd);

						if($last_qty >= 0){
							break;
							// $i = 100;
						}
						$qty= $last_qty * (-1);
					}
					
					$rsd['qty_on_hand'] = $qty_on_hand - $data['qty'];
					$this->db->where('product_id', $data['product_id']);
					$query = $this->db->update('inventory_on_hand' ,$rsd);
					
					$history['document_no'] = $this->qms_model->getDocumentNo('receive_slip',$receive_id);
					$history['product_id'] = $this->qms_model->getProductID($data['product_id']);
					$history['qty'] = $data['qty'];
					$history['mode'] = "OUT";
					//die(print_r($history));
					$this->qms_model->submitTableData('history',$history);
				}
				else{ 
					$data = array();
					array_push($data, array(
												'product' => 'Error: Qty is greater than on hand !'
											));
					echo json_encode($data);
					die;
				}
			}elseif($tipe == 'PA'){
				$arrPackage = $this->qms_model->getPackageDetail($receive_id);
				// echo count($arrPackage);
				// die;
				$qtySimpan = $data['qty'];
				$productSimpan = $receive_id;
				//Cek start
				// foreach($arrPackage as $key => $value){
				// 	$packProduct_id = $arrPackage[$key]['product_id'];
				// 	$packQty = $arrPackage[$key]['qty'];
				// 	$packMProductId = $this->qms_model->getMProductID($packProduct_id);
				// 	$packQtyonHand = $this->qms_model->getQtyOnHand2($packMProductId);
				// 	$receive_id = $packMProductId;
				// 	$data['product_id'] = $packMProductId;
				// 	$data['qty'] = ($qtySimpan * $packQty);

				// 	$rsd['qty_on_hand'] = $packQtyonHand - $data['qty'];
				// 	$qty = $data['qty'];
				// 	// die(echo $rsd['qty_on_hand']);
				// 	if($rsd['qty_on_hand'] < 0){						
				// 		$data = array();
				// 		array_push($data, array(
				// 									'product' => 'Error: Qty '.$this->qms_model->getProductName($packMProductId).'('.$packMProductId.') is greater than on hand! Please select other package!'
				// 								));
				// 		echo json_encode($data);
				// 		die;
				// 	}
				// }
				//cek akhir
				foreach($arrPackage as $key => $value){
					$packProduct_id = $arrPackage[$key]['product_id'];
					$packQty = $arrPackage[$key]['qty'];
					$packMProductId = $this->qms_model->getMProductID($packProduct_id);
					$packQtyonHand = $this->qms_model->getQtyOnHand2($packMProductId);
					$receive_id = $packMProductId;
					$data['product_id'] = $packMProductId;
					$data['qty'] = ($qtySimpan * $packQty);

					$rsd['qty_on_hand'] = $packQtyonHand - $data['qty'];
					$qty = $data['qty'];
					
					if($rsd['qty_on_hand'] < 0){						
						$data = array();
						array_push($data, array(
													'product' => 'Error: Qty '.$this->qms_model->getProductName($packMProductId).'('.$packMProductId.') is greater than on hand! Please select other package!'
												));
						echo json_encode($data);
						die;
					}
					// die(echo $rsd['qty_on_hand']);
					for($i=0;$i<100;$i++){
						//Update looping disini
						$cek_qty_on_hand = $this->qms_model->cekQtyOnHand($receive_id);					
						$last_qty = $cek_qty_on_hand - $qty;
						if($last_qty < 0){
							$rsd['qty_on_hand'] = 0;
						}else{
							$rsd['qty_on_hand'] = $last_qty;
						}

						$this->db->where('product_id', $receive_id);
						$this->db->where('qty_on_hand >', 0);
						$this->db->order_by("id", "asc");
						$this->db->limit(1);
						$query = $this->db->update('rsd' ,$rsd);

						$rsd['qty_on_hand'] = $packQtyonHand - $data['qty'];
						$this->db->where('product_id', $data['product_id']);
						$query = $this->db->update('inventory_on_hand' ,$rsd);
						
						if($last_qty >= 0){
							break;
							// $i = 100;
						}
						$qty= $last_qty * (-1);
					}

				}

				$data['qty'] = $qtySimpan;
				$data['product_id'] = $productSimpan;
				$this->qms_model->submitTableData('order_detail',$data);

				$history['document_no'] = $this->qms_model->getDocumentNo('receive_slip',$receive_id);
				$history['product_id'] = $this->qms_model->getProductID($data['product_id']);
				$history['qty'] = $data['qty'];
				$history['mode'] = "OUT";
				//die(print_r($history));
				$this->qms_model->submitTableData('history',$history);
				
			}
			
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
		// $this->db->trans_complete();

		if($this->db->trans_status() === FALSE){// Check if transaction result successful
		    $this->db->trans_rollback();
		    $data = array();
			array_push($data, array(
										'product' => 'Error: Cannot save data!'
									));
			echo json_encode($data);
			die;
		}else{
		   	$this->db->trans_complete();
		   	$arr = $this->reload($data['id_header']);
			echo json_encode($arr);
		}

		
		//die($res);
	}
	
	public function reload($id_header) {
		$arr = $this->qms_model->getTransactionDetail($id_header);
		
		foreach($arr as $key => $value){
			if($arr[$key]['tipe'] == 'NP'){
				$arr[$key]['product'] = $this->qms_model->getProductName($arr[$key]['product_id']);
				$arr[$key]['package'] = 'Non Package';
			}elseif($arr[$key]['tipe'] == 'PA'){
				$arr[$key]['product'] = $this->qms_model->getPackageName($arr[$key]['product_id']);
				$arr[$key]['package'] = 'Package';
			}
		}
		
        return $arr;
    }
	
	public function checkout() {
		$header['mode'] = 'checkout';
		$data['mode'] = 'checkout 2';
		//die(print_r($data));
        // $this->load->view('commons/header', $header);
        $this->load->view('checkout',$data);
        // $this->load->view('commons/footer');
		// die('Print Out Preview');
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
