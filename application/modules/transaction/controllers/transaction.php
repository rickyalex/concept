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
        $this->load->library('html2pdf');
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
			$data['result']['subtotal2'] = $this->qms_model->getTotal($data['result']['order_no']);
			$data['result']['discount2'] = ($this->qms_model->getDiscountHeader($data['result']['order_no'])/100)*$data['result']['subtotal2'];
			$data['result']['total'] = $data['result']['subtotal2'] - $data['result']['discount2'];
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
		}else{
			$arr = array();
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

		// die(print_r($data));
		if ($data['id'] == '' || $data['id'] == null){
			//mode insert;
			$data['discount'] = ($data['discount']/100); //percentage			
			$data['id'] = $this->qms_model->getOrderID($data['order_no']);
			// print_r($data);
			if ($data['id'] == '' || $data['id'] == null){

				$query = $this->qms_model->submitTableData('order_header',$data);
			}
			else{
				//mode update;
				$this->db->where('id', $data['id']);
				$query = $this->db->update('order_header' ,$data);
			}
		}
		else{
			//mode update;
			// $data['subtotal2'] = $data['subtotal2']; 	
			$data['discount'] = ($data['discount']/100); //percentage	
			// $data['total'] = $this->qms_model->getTotal($data['order_no']) - ( $this->qms_model->getTotal($data['order_no']) * $data['discount']);
			$this->db->where('id', $data['id']);
			$query = $this->db->update('order_header' ,$data);
		}
		
	}
	
	public function saveDetail(){
		foreach($_POST as $key => $value){
			$data[$key] = $this->input->post($key);
		}
		// die(print_r($data));
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
				// echo $tipe;

			$this->db->trans_start();
			if($tipe == 'NP'){
				$cek_kategori = $this->qms_model->getCategoryID($this->qms_model->getTypeID($receive_id));
				// echo 'kategori ' . $cek_kategori;
				$qty = $data['qty'];
				if($cek_kategori == 3){ //SERVICE
					$this->qms_model->submitTableData('order_detail',$data);
				}else{
					$qty_on_hand = $this->qms_model->getQtyOnHand2($receive_id);
					$rsd['qty_on_hand'] = $qty_on_hand - $data['qty'];
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
					// $packMProductId = $this->qms_model->getMProductID($packProduct_id);
					$packMProductId = $packProduct_id;
					$packQtyonHand = $this->qms_model->getQtyOnHand2($packMProductId);
					$receive_id = $packMProductId;
					$data['product_id'] = $packMProductId;
					$data['qty'] = ($qtySimpan * $packQty);
					
					// print_r($data);
					// die;
					$rsd['qty_on_hand'] = $packQtyonHand - $data['qty'];
					$cek_kategori = $this->qms_model->getCategoryID($this->qms_model->getTypeID($receive_id));
					$qty = $data['qty'];
					if($cek_kategori != 3){ //SERVICE
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
			
			
		}
		else{
			//mode update;
			
			$this->db->where('id', $data['id']);
			$query = $this->db->update('order_detail' ,$data);
			// if($query) $res = 'Update Success';
			// else $res = 'Update Error';
		}
		
		$header['subtotal'] = $this->qms_model->getTotal($order_no);
		$header['total'] = $header['subtotal'] - ($header['subtotal']*($header['discount']/100));
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

			$arr[$key]['action'] = "<a class='remove' href='#' onclick='showConfirmation($(this).parent().siblings(\":first\").text())'><i class='glyphicon glyphicon-remove'></a>";
		}
		
        return $arr;
    }	

	public function cancelorder() {
		foreach($_POST as $key => $value){
			$data[$key] = $this->input->post($key);
		}
		// if($data['receive_date'] == ''){
		// 	$data['receive_date'] = $data['date'];
		// }
		$data['down_payment'] 	= str_replace(".", "", $data['down_payment']);
		$data['subtotal'] 		= str_replace(".", "", $data['subtotal']);
		$data['total'] 			= str_replace(".", "", $data['total']);
		$data['payment'] 		= str_replace(".", "", $data['payment']);
		$data['return'] 		= 0;
		
		if($data['id'] == ''){
			$data['id'] = $this->qms_model->getOrderID($data['order_no']);
		}
		
		$data['status'] = 'CANCEL';
		$data['flag_print'] = 'Y';
		$data['cancel_date'] = Date('Y-m-d');
		$data['last_updated'] = Date('Y-m-d');

		$data['subtotal'] = $this->qms_model->getTotal($data['order_no']);
		$data['discount'] = ($data['discount']/100); //percentage

		$this->db->where('order_no', $data['order_no']);
		$this->db->where('date', $data['date']);
		$query = $this->db->update('order_header' ,$data);
	}

	public function checkout() {
		foreach($_POST as $key => $value){
			$data[$key] = $this->input->post($key);
		}
		// if($data['receive_date'] == ''){
		// 	$data['receive_date'] = $data['date'];
		// }
		$data['down_payment'] 	= str_replace(".", "", $data['down_payment']);
		$data['subtotal'] 		= str_replace(".", "", $data['subtotal']);
		$data['total'] 			= str_replace(".", "", $data['total']);
		$data['payment'] 		= str_replace(".", "", $data['payment']);
		$data['return'] 		= str_replace(".", "", $data['return']);
		
		if($data['id'] == ''){
			$data['id'] = $this->qms_model->getOrderID($data['order_no']);
		}
		
		if($data['return'] >= 0){
			$data['status'] = 'CLOSED';
			$data['flag_print'] = 'Y';	
			$data['closed_date'] = Date('Y-m-d');
		}
		elseif($data['return'] < 0){
			// $data['down_payment'] = $data['payment'];
			$data['flag_print'] = 'Y';	
		}
		
		$data['subtotal'] = $this->qms_model->getTotal($data['order_no']);
		$data['discount'] = ($data['discount']/100); //percentage
		// $array = array('order_no', $data['order_no'],'date', $data['date']);
		// $this->db->where($array);
		// print_r($data);
		$this->db->where('order_no', $data['order_no']);
		$this->db->where('date', $data['date']);
		$query = $this->db->update('order_header' ,$data);
	}

	public function print_out() {
		// $header['mode'] = 'checkout';
		// $data['mode'] = 'checkout 2';

		//die(print_r($data));
        // $this->load->view('commons/footer');
			    //Load the library
	    // $this->load->library('html2pdf');
	    
	    //Set folder to save PDF to
	    // $this->html2pdf->folder('./assets/pdfs/');
	    
	    //Set the filename to save/download as
	    // $this->html2pdf->filename('test.pdf');
	    
	    //Set the paper defaults
	    // $this->html2pdf->paper('a4', 'portrait');
	    
		if ($this->uri->segment(3) !== FALSE){
			$order_no = $this->uri->segment(4);
			
			$arr = $this->qms_model->getTransactionDetailByOrderNo2($order_no);
			foreach($arr as $key => $value){
				if($arr[$key]['tipe'] == 'NP')
					$arr[$key]['product'] = $this->qms_model->getProductName($arr[$key]['product_id']);
				elseif($arr[$key]['tipe'] == 'PA')
					$arr[$key]['product'] = $this->qms_model->getPackageName($arr[$key]['product_id']);

			}
			// die(print_r($arr));
		}
		// $data = array();
		$data['order_no']  = $order_no;
		$data['discount_header']  = $this->qms_model->getDiscountHeader($order_no);
		$data['cash']  = $this->qms_model->getCash($order_no);
		$data['DP']  = $this->qms_model->getDP($order_no);
		$data['return']  = $this->qms_model->getReturn($order_no);
		$data['customer']  = $this->qms_model->getCustomer($order_no);
		$data['phone']  = $this->qms_model->getPhone($order_no);
		$data['product']  = $arr;

	    $this->load->view('checkout',$data);
	    // $this->html2pdf->html($this->load->view('checkout',$data, true));
	    
	    // if($this->html2pdf->create('download')) {
	    // 	//PDF was successfully saved or downloaded
	    // 	echo 'PDF saved';
	    // }
    }
	
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

	public function remove(){
		if ($this->uri->segment(3) !== FALSE){
			foreach($_POST as $key => $value){
				$data[$key] = $this->input->post($key);
			}
			// echo $id;
			$id = $this->uri->segment(4);
			$passCek = $this->qms_model->getConfirmPass();

			if($data['password'] != $passCek)
				die('Error: Wrong Passcode!');

			// print_r($id);
			$this->db->trans_start();
			$arr = $this->qms_model->getOrderDetail($id);
			$qty=0;
			foreach($arr as $key => $value){
				$tipe 		= trim($arr[$key]['tipe']);
				$qty 		= $arr[$key]['qty'];
				$receive_id = trim($arr[$key]['product_id']);
				// echo $receive_id;
				if($tipe =='NP'){
					$cek_kategori = $this->qms_model->getCategoryID($this->qms_model->getTypeID($receive_id));
					// echo 'kategori ' . $cek_kategori;
					if($cek_kategori != 3){ //Bukan SERVICE
						$qty_on_hand = $this->qms_model->getQtyOnHand2($receive_id);
						// echo $qty_on_hand;
						$rsd['qty_on_hand'] = $qty_on_hand + $qty;
						
						$this->db->where('product_id', $receive_id);
						// $this->db->where('qty_on_hand >', 0);
						$this->db->order_by("id", "asc");
						$this->db->limit(1);
						$query = $this->db->update('rsd' ,$rsd);

						$this->db->where('product_id', $receive_id);
						$query = $this->db->update('inventory_on_hand' ,$rsd);
						
						$history['document_no'] = $this->qms_model->getDocumentNo('receive_slip',$receive_id);
						$history['product_id'] = $receive_id;
						$history['qty'] = $qty;
						$history['mode'] = "CANCEL";

						// print_r($history);
						
						$query = $this->qms_model->submitTableData('history',$history);
						
						// echo 'Hasil : ' . $query;
						
					}
				}else{
					$arrPackage = $this->qms_model->getPackageDetail($receive_id);
					// echo count($arrPackage);
					// die;
					$qtySimpan = $qty;
					$productSimpan = $receive_id;
					foreach($arrPackage as $key => $value){
						$packProduct_id = $arrPackage[$key]['product_id'];
						$packQty = $arrPackage[$key]['qty'];
						// $packMProductId = $this->qms_model->getMProductID($packProduct_id);
						$packMProductId = $packProduct_id;
						$packQtyonHand = $this->qms_model->getQtyOnHand2($packMProductId);
						$receive_id = $packMProductId;
						$data['product_id'] = $packMProductId;
						$data['qty'] = ($qtySimpan * $packQty);

						$rsd['qty_on_hand'] = $packQtyonHand + $data['qty'];
						$cek_kategori = $this->qms_model->getCategoryID($this->qms_model->getTypeID($receive_id));
						$qty = $data['qty'];
						if($cek_kategori != 3){ //SERVICE
							$this->db->where('product_id', $receive_id);
							// $this->db->where('qty_on_hand >', 0);
							$this->db->order_by("id", "asc");
							$this->db->limit(1);
							$query = $this->db->update('rsd' ,$rsd);

							$this->db->where('product_id', $receive_id);
							$query = $this->db->update('inventory_on_hand' ,$rsd);
							
							$history['document_no'] = $this->qms_model->getDocumentNo('receive_slip',$receive_id);
							$history['product_id'] = $receive_id;
							$history['qty'] = $qty;
							$history['mode'] = "CANCEL";

							// print_r($history);
							
							$query = $this->qms_model->submitTableData('history',$history);
							
							// echo 'Hasil : ' . $query;
						}
					}
				}
			}
			$id_header = '';
			$id_header = $this->qms_model->getIDHeader2($id);
			
			$this->db->where('id', $id);
			$query = $this->db->delete('order_detail');
			// echo $query;

			if($this->db->trans_status() === FALSE){// Check if transaction result successful
			    $this->db->trans_rollback();
			    $res = 'Error: Delete Error';
				die($res);
			}else{
				$this->db->trans_complete();
			    //$res = 'Delete Success';	
				$arr = $this->reload($id_header);
				echo json_encode($arr);	
				die;	   	
			}
		}
		else die('Error: no parameter found !');
		
		// die($res);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
