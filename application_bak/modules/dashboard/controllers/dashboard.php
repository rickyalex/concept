<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends MX_Controller
{

 	/**
	 * @author entol
	 * @see more  http://www.entol.net
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
	
	function __construct()
	{
		parent::__construct();
		
		// check if user logged in 
		// if (!$this->ion_auth->logged_in())
	  	// {
			// redirect('auth/login');
	  	// }
		$this->load->helper('url');
		$this->load->model('qms_model');
		$this->load->library('form_validation');
	}
	
    public function index()
    {	
		$res = $this->getLabaProduk();
		$res2 = $this->getLabaJasa();
		$res3 = $this->getModalProduk();
		$low = $this->qms_model->countMinStock();
		$data['res'] = $res;
		$data['res2'] = $res2;
		$data['res3'] = $res3;
		$data['low'] = $low;
        $this->load->view('commons/header', $meta);
        $this->load->view('dashboard', $data);
        $this->load->view('commons/footer');
    }
	
	public function getLabaProduk() {

		$mon = Date('m');
		$reports = $this->qms_model->getDashboard($mon);

		
		foreach ($reports as $key => $value) {
                $LabaStudio = 0;
                $LabaProduk = 0;
                $ModalProduk = 0;
                $Total = $reports[$key]['total'];

                if ($reports[$key]['tipe'] == 'NP'){
                    $reports[$key]['product'] = $this->qms_model->getProductName($reports[$key]['product_id']);
                    $TypeID = $this->qms_model->getTypeID($reports[$key]['product_id']);
                    if($TypeID != 3){
                        $LabaProduk = $reports[$key]['qty'] * $this->qms_model->getLaba($reports[$key]['product_id']);
                        $ModalProduk = $reports[$key]['qty'] * $this->qms_model->getModal($reports[$key]['product_id']);
                    }
                    else
                        $LabaStudio = $reports[$key]['qty'] * $this->qms_model->getLabaService($reports[$key]['product_id']);
                }
                elseif ($reports[$key]['tipe'] == 'PA'){
                    $prod = $this->qms_model->getPackageDetail($reports[$key]['product_id']);
                    foreach($prod as $key1 => $value){
                        $productdetail = "";
                        $qtydetail = 1;

                        $productdetail = $prod[$key1]['product_id'];
                        $qtydetail = $prod[$key1]['qty'];
                        $TypeID = $this->qms_model->getTypeID($productdetail);

                        if($TypeID != 3){
                            $LabaProduk = $LabaProduk + $reports[$key]['qty'] * $qtydetail * $this->qms_model->getLaba($productdetail);
                            $ModalProduk = $ModalProduk + $reports[$key]['qty'] * $qtydetail * $this->qms_model->getModal($productdetail);
                        }
                        else
                            $LabaStudio = $LabaStudio + $reports[$key]['qty'] * $qtydetail * $this->qms_model->getLabaService($productdetail);



                    }

                  
                }
				$arr[$key]['date'] = $reports[$key]['closed_date'];
				$arr[$key]['laba_produk'] = $LabaProduk;
		}
		
		$a = array();
		foreach ($arr as $ar) {
			$a[] = $ar['date'];
		}
		$uniqueDates = array_unique($a);
		
		$x=0;
		foreach($uniqueDates as $key){
			$dates[$x] = $key;
			$x++;
		}
		
		for($x=0;$x<count($dates);$x++){
			$date = $dates[$x];
			$laba_produk = 0;
			for($y=0;$y<count($arr);$y++){
				if($arr[$y]['date'] == $date) $laba_produk = $laba_produk + $arr[$y]['laba_produk'];
			}
			$res[$x]['date'] = $date;
			$res[$x]['laba_produk'] = $laba_produk;
		}

		foreach($res as $data => $field){
			$chart[][]="'".$res[$data]['date']."',".$res[$data]['laba_produk'];
		}

		if($chart==null||$chart=="") $chart = json_encode($chart);
		else $chart = str_replace('"','',json_encode($chart));
		
		return $chart;
    }

    public function getLabaJasa() {

		$mon = Date('m');
		$reports = $this->qms_model->getDashboard($mon);
		
		foreach ($reports as $key => $value) {
                $LabaStudio = 0;
                $LabaProduk = 0;
                $ModalProduk = 0;
                $Total = $reports[$key]['total'];

                if ($reports[$key]['tipe'] == 'NP'){
                    $reports[$key]['product'] = $this->qms_model->getProductName($reports[$key]['product_id']);
                    $TypeID = $this->qms_model->getTypeID($reports[$key]['product_id']);
                    if($TypeID != 3){
                        $LabaProduk = $reports[$key]['qty'] * $this->qms_model->getLaba($reports[$key]['product_id']);
                        $ModalProduk = $reports[$key]['qty'] * $this->qms_model->getModal($reports[$key]['product_id']);
                    }
                    else
                        $LabaStudio = $reports[$key]['qty'] * $this->qms_model->getLabaService($reports[$key]['product_id']);
                }
                elseif ($reports[$key]['tipe'] == 'PA'){
                    $prod = $this->qms_model->getPackageDetail($reports[$key]['product_id']);
                    foreach($prod as $key1 => $value){
                        $productdetail = "";
                        $qtydetail = 1;

                        $productdetail = $prod[$key1]['product_id'];
                        $qtydetail = $prod[$key1]['qty'];
                        $TypeID = $this->qms_model->getTypeID($productdetail);

                        if($TypeID != 3){
                            $LabaProduk = $LabaProduk + $reports[$key]['qty'] * $qtydetail * $this->qms_model->getLaba($productdetail);
                            $ModalProduk = $ModalProduk + $reports[$key]['qty'] * $qtydetail * $this->qms_model->getModal($productdetail);
                        }
                        else
                            $LabaStudio = $LabaStudio + $reports[$key]['qty'] * $qtydetail * $this->qms_model->getLabaService($productdetail);



                    }

                  
                }
				$arr[$key]['date'] = $reports[$key]['closed_date'];
				$arr[$key]['laba_studio'] = $LabaStudio;
		}
		
		$a = array();
		foreach ($arr as $ar) {
			$a[] = $ar['date'];
		}
		$uniqueDates = array_unique($a);
		
		$x=0;
		foreach($uniqueDates as $key){
			$dates[$x] = $key;
			$x++;
		}
		
		for($x=0;$x<count($dates);$x++){
			$date = $dates[$x];
			$laba_studio = 0;
			for($y=0;$y<count($arr);$y++){
				if($arr[$y]['date'] == $date) $laba_studio = $laba_studio + $arr[$y]['laba_studio'];
			}
			$res[$x]['date'] = $date;
			$res[$x]['laba_studio'] = $laba_studio;
		}

		foreach($res as $data => $field){
			$chart[][]="'".$res[$data]['date']."',".$res[$data]['laba_studio'];
		}

		if($chart==null||$chart=="") $chart = json_encode($chart);
		else $chart = str_replace('"','',json_encode($chart));
		
		return $chart;
    }

    public function getModalProduk() {

		$mon = Date('m');
		$reports = $this->qms_model->getDashboard($mon);

		foreach ($reports as $key => $value) {
                $LabaStudio = 0;
                $LabaProduk = 0;
                $ModalProduk = 0;
                $Total = $reports[$key]['total'];

                if ($reports[$key]['tipe'] == 'NP'){
                    $reports[$key]['product'] = $this->qms_model->getProductName($reports[$key]['product_id']);
                    $TypeID = $this->qms_model->getTypeID($reports[$key]['product_id']);
                    if($TypeID != 3){
                        $LabaProduk = $reports[$key]['qty'] * $this->qms_model->getLaba($reports[$key]['product_id']);
                        $ModalProduk = $reports[$key]['qty'] * $this->qms_model->getModal($reports[$key]['product_id']);
                    }
                    else
                        $LabaStudio = $reports[$key]['qty'] * $this->qms_model->getLabaService($reports[$key]['product_id']);
                }
                elseif ($reports[$key]['tipe'] == 'PA'){
                    $prod = $this->qms_model->getPackageDetail($reports[$key]['product_id']);
                    foreach($prod as $key1 => $value){
                        $productdetail = "";
                        $qtydetail = 1;

                        $productdetail = $prod[$key1]['product_id'];
                        $qtydetail = $prod[$key1]['qty'];
                        $TypeID = $this->qms_model->getTypeID($productdetail);

                        if($TypeID != 3){
                            $LabaProduk = $LabaProduk + $reports[$key]['qty'] * $qtydetail * $this->qms_model->getLaba($productdetail);
                            $ModalProduk = $ModalProduk + $reports[$key]['qty'] * $qtydetail * $this->qms_model->getModal($productdetail);
                        }
                        else
                            $LabaStudio = $LabaStudio + $reports[$key]['qty'] * $qtydetail * $this->qms_model->getLabaService($productdetail);



                    }

                  
                }
				$arr[$key]['date'] = $reports[$key]['closed_date'];
				$arr[$key]['modal_produk'] = $ModalProduk;
		}
		
		$a = array();
		foreach ($arr as $ar) {
			$a[] = $ar['date'];
		}
		$uniqueDates = array_unique($a);
		
		$x=0;
		foreach($uniqueDates as $key){
			$dates[$x] = $key;
			$x++;
		}
		
		for($x=0;$x<count($dates);$x++){
			$date = $dates[$x];
			$modal_produk = 0;
			for($y=0;$y<count($arr);$y++){
				if($arr[$y]['date'] == $date) $modal_produk = $modal_produk + $arr[$y]['modal_produk'];
			}
			$res[$x]['date'] = $date;
			$res[$x]['modal_produk'] = $modal_produk;
		}

		foreach($res as $data => $field){
			$chart[][]="'".$res[$data]['date']."',".$res[$data]['modal_produk'];
		}

		if($chart==null||$chart=="") $chart = json_encode($chart);
		else $chart = str_replace('"','',json_encode($chart));
		
		return $chart;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
