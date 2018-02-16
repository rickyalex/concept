<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports extends MX_Controller {

    /**
     * @author entol
     * @see more  http://www.entol.net
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {
        parent::__construct();

        // check if user logged in 
        // if (!$this->ion_auth->logged_in())
        // {
        // redirect('auth/login');
        // }
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('PHPExcel');
        $this->load->model('qms_model');
    }

    public function index() {
        $this->load->view('commons/header', $meta);
        $this->load->view('reports', $data);
        $this->load->view('commons/footer');
    }
	
	public function daily_orders() {

        $this->load->view('commons/header', $meta);
        $this->load->view('daily_orders');
        $this->load->view('commons/footer');
    }
	
    public function daily_reports() {

        $this->load->view('commons/header', $meta);
        $this->load->view('daily_reports', $data);
        $this->load->view('commons/footer');
    }
	
	public function outstanding_report() {

        $this->load->view('commons/header', $meta);
        $this->load->view('outstanding_report', $data);
        $this->load->view('commons/footer');
    }
	
	public function cancel_report() {

        $this->load->view('commons/header', $meta);
        $this->load->view('cancel_report', $data);
        $this->load->view('commons/footer');
    }

    public function monthly_reports() {

        $this->load->view('commons/header', $meta);
        $this->load->view('monthly_reports', $data);
        $this->load->view('commons/footer');
    }
	
	public function monthly_income() {
		$data['res'] = $this->getMonthlyIncome();
		//die($data['chart']);
		
        $this->load->view('commons/header', $meta);
        $this->load->view('monthly_income', $data);
        $this->load->view('commons/footer');
    }
	
	public function getDailyOrders() {
        if ($this->uri->segment(3) !== FALSE){
			$date = $this->uri->segment(4);

			$reports = $this->qms_model->getDailyOrders($date);
			foreach ($reports as $key => $value) {
				if ($reports[$key]['tipe'] == 'NP'){
					$reports[$key]['product'] = $this->qms_model->getProductName($reports[$key]['product_id']);
				}
				elseif ($reports[$key]['tipe'] == 'PA')
					$reports[$key]['product'] = $this->qms_model->getPackageName($reports[$key]['product_id']);
			}
        }
		else{
			$reports = null;
		}
        echo json_encode($reports);
    }
	
	public function getOutstanding() {
        if ($this->uri->segment(3) !== FALSE){
			$datefrom = $this->uri->segment(4);
			$dateto = $this->uri->segment(6);

			$reports = $this->qms_model->getOutstandingReport($datefrom,$dateto);
        }
		else{
			$reports = null;
		}
        echo json_encode($reports);
    }
	
	public function getCancel() {
        if ($this->uri->segment(3) !== FALSE){
			$datefrom = $this->uri->segment(4);
			$dateto = $this->uri->segment(6);

			$reports = $this->qms_model->getCancelReport($datefrom,$dateto);
        }
		else{
			$reports = null;
		}
        echo json_encode($reports);
    }
	
	public function getMonthlyIncome() {
        //if ($this->uri->segment(3) !== FALSE){
			//$datefrom = $this->uri->segment(4);
			//$dateto = $this->uri->segment(6);

			//$income = $this->qms_model->getMonthlyIncome($datefrom,$dateto);
			$mon = Date('m');
			$income = $this->qms_model->getMonthlyIncome($mon);
		
			foreach($income as $row){
				$chart[][]="'".$row['date']."',".$row['total'];
			}
        //}
		//else{
			//$chart = null;
		//}
		$chart = str_replace('"','',json_encode($chart));
        
		//die(print_r($chart));
		return $chart;
    }
	
    public function getDailyReports() {
        foreach ($_POST as $key => $value) {
            $result[$key] = $this->input->post($key);
        }
        $date = $result['datefrom'];

        $reports = $this->qms_model->getDailyReportsAll($date);
        foreach ($reports as $key => $value) {
            if ($reports[$key]['tipe'] == 'NP'){
                $reports[$key]['product'] = $this->qms_model->getProductName($reports[$key]['product_id']);
            }
            elseif ($reports[$key]['tipe'] == 'PA')
                $reports[$key]['product'] = $this->qms_model->getPackageName($reports[$key]['product_id']);
        }
        
        // echo json_encode($reports);
    }

    public function getMonthlyReports() {
        foreach ($_POST as $key => $value) {
            $result[$key] = $this->input->post($key);
        }
        $month = $result['month'];

        $reports = $this->qms_model->getDailyReportsMonthly($month);
        foreach ($reports as $key => $value) {
            if ($reports[$key]['tipe'] == 'NP'){
                $reports[$key]['product'] = $this->qms_model->getProductName($reports[$key]['product_id']);
            }
            elseif ($reports[$key]['tipe'] == 'PA')
                $reports[$key]['product'] = $this->qms_model->getPackageName($reports[$key]['product_id']);
        }
        
        // echo json_encode($reports);
    }

    public function getDailyReportsTable(){
        $datefrom = $this->uri->segment(3);
        $dateto = $this->uri->segment(4);

        $reports = $this->qms_model->getDailyReportsRange($datefrom,$dateto);

        foreach ($reports as $key => $value) {
            $LabaStudio = 0;
            $LabaProduk = 0;
            $ModalProduk = 0;
            $Total = $reports[$key]['total'];

            if ($reports[$key]['tipe'] == 'NP'){
                $reports[$key]['type_name'] = 'Barang';
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
                $reports[$key]['type_name'] = 'Paket';
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
                $reports[$key]['product'] = $this->qms_model->getPackageName($reports[$key]['product_id']);
            }
            
            $reports[$key]['laba_studio'] = $LabaStudio;
            $reports[$key]['laba_produk'] = $LabaProduk;
            $reports[$key]['modal_produk'] = $ModalProduk;

        }
        echo json_encode($reports);
    }

    public function downloadExcel()
        {
            //load librarynya terlebih dahulu
            //jika digunakan terus menerus lebih baik load ini ditaruh di auto load
            // $this->load->library("PHPExcel");
 
            //membuat objek PHPExcel
            $objPHPExcel = new PHPExcel();
 
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);


            // $newSheet = clone $objPHPExcel->getSheet(0);
            // /** Rename worksheet */
            // $newSheet->setTitle('Laporan Harian Cancel');

            // $addSheet = 1;
            // $newSheetIndex = $addSheet;
            // $objPHPExcel->addSheet($newSheet,$newSheetIndex);
            // $objWorksheet2 = $objPHPExcel->getSheet($addSheet);
            //set Sheet yang akan diolah 
            // $objPHPExcel->setActiveSheetIndex(0)
            //         //mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya 
            //         //Hello merupakan isinya
            //                             ->setCellValue('A1', 'Hello')
            //                             ->setCellValue('B2', 'Ini')
            //                             ->setCellValue('C1', 'Excel')
            //                             ->setCellValue('D2', 'Pertamaku');

            // foreach ($_POST as $key => $value) {
            //     $result[$key] = $this->input->post($key);
            // }
            // $datefrom = $result['datefrom'];
            // $dateto = $result['dateto'];
            // $date = '2017-09-02';

            $styleArray = array(
                  'borders' => array(
                      'allborders' => array(
                          'style' => PHPExcel_Style_Border::BORDER_THIN
                      )
                  )
              );

            $objWorksheet->setCellValue('A4', 'Tanggal')
                         ->setCellValue('B4', 'Produk')
                         ->setCellValue('C4', 'Qty Order')
                         ->setCellValue('D4', 'Qty Produk')
						 ->setCellValue('E4', 'Harga Paket')
                         ->setCellValue('F4', 'Subtotal')
                         ->setCellValue('G4', 'Laba Studio')
                         ->setCellValue('H4', 'Laba Produk')
                         ->setCellValue('I4', 'Modal Produk');

            $reports = $this->qms_model->getDailyReportsAll();

            $ReceiveDate = "-";
            $row=5;
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
                        $LabaStudio = $Total * $this->qms_model->getLabaService($reports[$key]['product_id']);
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
                            $LabaStudio = $LabaStudio + $Total * $qtydetail * $this->qms_model->getLabaService($productdetail);



                    }

                    $reports[$key]['product'] = $this->qms_model->getPackageName($reports[$key]['product_id']);
                }

                if($ReceiveDate == "-"){
                    $ReceiveDate = $reports[$key]['date'];
                    $row1 = $row;
                }
                else if($reports[$key]['date'] != $ReceiveDate ){
                    $objWorksheet->mergeCells('A'.$row1.':A'.($row-1))->setCellValue('A'.$row1, $ReceiveDate)
                                 ->mergeCells('A'.$row.':D'.$row)->setCellValue('A'.$row, "Total ".$ReceiveDate)
                                 ->setCellValue('F'.$row, '=SUM(F'.$row1.':F'.($row-1).')')
                                 ->setCellValue('G'.$row, '=SUM(G'.$row1.':G'.($row-1).')')
                                 ->setCellValue('H'.$row, '=SUM(H'.$row1.':H'.($row-1).')')
								 ->setCellValue('I'.$row, '=SUM(I'.$row1.':I'.($row-1).')');
                    $row++;

                    $ReceiveDate = $reports[$key]['date'];
                    $row1 = $row;
                }


                $objWorksheet->setCellValue('A'.$row, $ReceiveDate)
                             ->setCellValue('B'.$row, $reports[$key]['product'])
                             ->setCellValue('C'.$row, $reports[$key]['total'])
                             ->setCellValue('D'.$row, $reports[$key]['qty'])
                             ->setCellValue('E'.$row, $reports[$key]['price'])
                             ->setCellValue('F'.$row, $reports[$key]['subtotal'])
							 ->setCellValue('G'.$row, $LabaStudio)
                             ->setCellValue('H'.$row, $LabaProduk)
                             ->setCellValue('I'.$row, $ModalProduk);

                $objWorksheet->getColumnDimension('A')->setWidth(20);//->setAutoSize(true);
                $objWorksheet->getColumnDimension('B')->setWidth(30);//->setAutoSize(true);
                $objWorksheet->getColumnDimension('C')->setWidth(10);//->setAutoSize(true);
                $objWorksheet->getColumnDimension('D')->setWidth(12);//->setAutoSize(true);
                $objWorksheet->getColumnDimension('E')->setWidth(15);//->setAutoSize(true);
                $objWorksheet->getColumnDimension('F')->setWidth(15);//->setAutoSize(true);
                $objWorksheet->getColumnDimension('G')->setWidth(15);//->setAutoSize(true);
				$objWorksheet->getColumnDimension('H')->setWidth(15);//->setAutoSize(true);
				$objWorksheet->getColumnDimension('I')->setWidth(15);//->setAutoSize(true);

                $row++;
            }
            $objWorksheet->mergeCells('A'.$row1.':A'.($row-1))->setCellValue('A'.$row1, $ReceiveDate)
                         ->mergeCells('A'.$row.':D'.$row)->setCellValue('A'.$row, "Total ".$ReceiveDate)
                                 ->setCellValue('E'.$row, '=SUM(E'.$row1.':E'.($row-1).')')
                                 ->setCellValue('F'.$row, '=SUM(F'.$row1.':F'.($row-1).')')
                                 ->setCellValue('G'.$row, '=SUM(G'.$row1.':G'.($row-1).')')
								 ->setCellValue('H'.$row, '=SUM(H'.$row1.':H'.($row-1).')')
								 ->setCellValue('I'.$row, '=SUM(I'.$row1.':I'.($row-1).')');

            $objWorksheet->getStyle("A4:I".$row)->applyFromArray($styleArray);
            
            //set title pada sheet (me rename nama sheet)
            $objPHPExcel->getActiveSheet()->setTitle('Laporan Harian');

            $objWorksheet2->setCellValue('A4', 'Tanggal')
                         ->setCellValue('B4', 'Produk')
                         ->setCellValue('C4', 'Qty Order')
                         ->setCellValue('D4', 'Qty Produk')
                         ->setCellValue('E4', 'Harga Paket')
                         ->setCellValue('F4', 'Subtotal')
                         ->setCellValue('G4', 'Laba Studio')
                         ->setCellValue('H4', 'Laba Produk')
                         ->setCellValue('I4', 'Modal Produk');


            //Sheet 2
            // $reports = $this->qms_model->getDailyReportsAll2();

            // $ReceiveDate = "-";
            // $row=5;
            // foreach ($reports as $key => $value) {
            //     $LabaStudio = 0;
            //     $LabaProduk = 0;
            //     $ModalProduk = 0;
            //     $Total = $reports[$key]['total'];

            //     if ($reports[$key]['tipe'] == 'NP'){
            //         $reports[$key]['product'] = $this->qms_model->getProductName($reports[$key]['product_id']);
            //         $TypeID = $this->qms_model->getTypeID($reports[$key]['product_id']);
            //         if($TypeID != 3){
            //             $LabaProduk = $reports[$key]['qty'] * $this->qms_model->getLaba($reports[$key]['product_id']);
            //             $ModalProduk = $reports[$key]['qty'] * $this->qms_model->getModal($reports[$key]['product_id']);
            //         }
            //         else
            //             $LabaStudio = $Total * $this->qms_model->getLabaService($reports[$key]['product_id']);
            //     }
            //     elseif ($reports[$key]['tipe'] == 'PA'){
            //         $prod = $this->qms_model->getPackageDetail($reports[$key]['product_id']);
            //         foreach($prod as $key1 => $value){
            //             $productdetail = "";
            //             $qtydetail = 1;

            //             $productdetail = $prod[$key1]['product_id'];
            //             $qtydetail = $prod[$key1]['qty'];
            //             $TypeID = $this->qms_model->getTypeID($productdetail);

            //             if($TypeID != 3){
            //                 $LabaProduk = $LabaProduk + $reports[$key]['qty'] * $qtydetail * $this->qms_model->getLaba($productdetail);
            //                 $ModalProduk = $ModalProduk + $reports[$key]['qty'] * $qtydetail * $this->qms_model->getModal($productdetail);
            //             }
            //             else
            //                 $LabaStudio = $LabaStudio + $Total * $qtydetail * $this->qms_model->getLabaService($productdetail);



            //         }

            //         $reports[$key]['product'] = $this->qms_model->getPackageName($reports[$key]['product_id']);
            //     }

            //     if($ReceiveDate == "-"){
            //         $ReceiveDate = $reports[$key]['date'];
            //         $row1 = $row;
            //     }
            //     else if($reports[$key]['date'] != $ReceiveDate ){
            //         $objWorksheet2->mergeCells('A'.$row1.':A'.($row-1))->setCellValue('A'.$row1, $ReceiveDate)
            //                      ->mergeCells('A'.$row.':D'.$row)->setCellValue('A'.$row, "Total ".$ReceiveDate)
            //                      ->setCellValue('F'.$row, '=SUM(F'.$row1.':F'.($row-1).')')
            //                      ->setCellValue('G'.$row, '=SUM(G'.$row1.':G'.($row-1).')')
            //                      ->setCellValue('H'.$row, '=SUM(H'.$row1.':H'.($row-1).')')
            //                      ->setCellValue('I'.$row, '=SUM(I'.$row1.':I'.($row-1).')');
            //         $row++;

            //         $ReceiveDate = $reports[$key]['date'];
            //         $row1 = $row;
            //     }


            //     $objWorksheet2->setCellValue('A'.$row, $ReceiveDate)
            //                  ->setCellValue('B'.$row, $reports[$key]['product'])
            //                  ->setCellValue('C'.$row, $reports[$key]['total'])
            //                  ->setCellValue('D'.$row, $reports[$key]['qty'])
            //                  ->setCellValue('E'.$row, $reports[$key]['price'])
            //                  ->setCellValue('F'.$row, $reports[$key]['subtotal'])
            //                  ->setCellValue('G'.$row, $LabaStudio)
            //                  ->setCellValue('H'.$row, $LabaProduk)
            //                  ->setCellValue('I'.$row, $ModalProduk);

            //     $objWorksheet2->getColumnDimension('A')->setWidth(20);//->setAutoSize(true);
            //     $objWorksheet2->getColumnDimension('B')->setWidth(30);//->setAutoSize(true);
            //     $objWorksheet2->getColumnDimension('C')->setWidth(10);//->setAutoSize(true);
            //     $objWorksheet2->getColumnDimension('D')->setWidth(12);//->setAutoSize(true);
            //     $objWorksheet2->getColumnDimension('E')->setWidth(15);//->setAutoSize(true);
            //     $objWorksheet2->getColumnDimension('F')->setWidth(15);//->setAutoSize(true);
            //     $objWorksheet2->getColumnDimension('G')->setWidth(15);//->setAutoSize(true);
            //     $objWorksheet2->getColumnDimension('H')->setWidth(15);//->setAutoSize(true);
            //     $objWorksheet2->getColumnDimension('I')->setWidth(15);//->setAutoSize(true);

            //     $row++;
            // }
            // $objWorksheet2->mergeCells('A'.$row1.':A'.($row-1))->setCellValue('A'.$row1, $ReceiveDate)
            //              ->mergeCells('A'.$row.':D'.$row)->setCellValue('A'.$row, "Total ".$ReceiveDate)
            //                      ->setCellValue('E'.$row, '=SUM(E'.$row1.':E'.($row-1).')')
            //                      ->setCellValue('F'.$row, '=SUM(F'.$row1.':F'.($row-1).')')
            //                      ->setCellValue('G'.$row, '=SUM(G'.$row1.':G'.($row-1).')')
            //                      ->setCellValue('H'.$row, '=SUM(H'.$row1.':H'.($row-1).')')
            //                      ->setCellValue('I'.$row, '=SUM(I'.$row1.':I'.($row-1).')');

            // $objWorksheet2->getStyle("A4:I".$row)->applyFromArray($styleArray);

             /** Set active sheet index to the first sheet, so Excel opens this as the first sheet */
            $objPHPExcel->setActiveSheetIndex(0);

            //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
 
            //sesuaikan headernya 
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            //ubah nama file saat diunduh
            header('Content-Disposition: attachment;filename="Harian.xlsx"');
            //unduh file
            $objWriter->save("php://output");
 
            //Mulai dari create object PHPExcel itu ada dokumentasi lengkapnya di PHPExcel, 
            // Folder Documentation dan Example
            // untuk belajar lebih jauh mengenai PHPExcel silakan buka disitu
 
        }
    
    public function downloadExcelRange()
        {
            //load librarynya terlebih dahulu
            //jika digunakan terus menerus lebih baik load ini ditaruh di auto load
            // $this->load->library("PHPExcel");
 
            //membuat objek PHPExcel
            $objPHPExcel = new PHPExcel();
 
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);


            // $newSheet = clone $objPHPExcel->getSheet(0);
            // /** Rename worksheet */
            // $newSheet->setTitle('Laporan Harian Cancel');

            // $addSheet = 1;
            // $newSheetIndex = $addSheet;
            // $objPHPExcel->addSheet($newSheet,$newSheetIndex);
            // $objWorksheet2 = $objPHPExcel->getSheet($addSheet);
            //set Sheet yang akan diolah 
            // $objPHPExcel->setActiveSheetIndex(0)
            //         //mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya 
            //         //Hello merupakan isinya
            //                             ->setCellValue('A1', 'Hello')
            //                             ->setCellValue('B2', 'Ini')
            //                             ->setCellValue('C1', 'Excel')
            //                             ->setCellValue('D2', 'Pertamaku');

            // $id = $this->uri->segment(6);
            $datefrom = $this->uri->segment(4);
            $dateto = $this->uri->segment(5);
            // $date = '2017-09-02';
            // echo $datefrom . ' - ' . $dateto;
            // die;

            $styleArray = array(
                  'borders' => array(
                      'allborders' => array(
                          'style' => PHPExcel_Style_Border::BORDER_THIN
                      )
                  )
              );

            $objWorksheet->setCellValue('A1', 'LAPORAN HARIAN')
                         ->setCellValue('A2', 'PERIODE')
                         ->setCellValue('B2', $datefrom . ' s/d ' . $dateto);

            $objWorksheet->setCellValue('A4', 'Tanggal')
                         ->setCellValue('B4', 'Produk')
                         ->setCellValue('C4', 'Qty Order')
                         ->setCellValue('D4', 'Qty Produk')
						 ->setCellValue('E4', 'Harga Paket')
                         ->setCellValue('F4', 'Subtotal')
                         ->setCellValue('G4', 'Laba Studio')
                         ->setCellValue('H4', 'Laba Produk')
                         ->setCellValue('I4', 'Modal Produk');

            // $reports = $this->qms_model->getDailyReportsAll();

            $reports = $this->qms_model->getDailyReportsRange($datefrom,$dateto);

            $ReceiveDate = "-";
            $row=5;
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

                    $reports[$key]['product'] = $this->qms_model->getPackageName($reports[$key]['product_id']);
                }

                if($ReceiveDate == "-"){
                    //$ReceiveDate = $reports[$key]['date'];
                    $ReceiveDate = $reports[$key]['closed_date'];
                    $row1 = $row;
                }
                else if($reports[$key]['date'] != $ReceiveDate ){
                    $objWorksheet->mergeCells('A'.$row1.':A'.($row-1))->setCellValue('A'.$row1, $ReceiveDate)
                                 ->mergeCells('A'.$row.':D'.$row)->setCellValue('A'.$row, "Total ".$ReceiveDate)
                                 ->setCellValue('E'.$row, '=SUM(E'.$row1.':E'.($row-1).')')
                                 ->setCellValue('F'.$row, '=SUM(F'.$row1.':F'.($row-1).')')
                                 ->setCellValue('G'.$row, '=SUM(G'.$row1.':G'.($row-1).')')
								 ->setCellValue('H'.$row, '=SUM(H'.$row1.':H'.($row-1).')')
								 ->setCellValue('I'.$row, '=SUM(I'.$row1.':I'.($row-1).')');
                    $row++;

                    // $ReceiveDate = $reports[$key]['date'];
                    $ReceiveDate = $reports[$key]['closed_date'];
                    $row1 = $row;
                }


                $objWorksheet->setCellValue('A'.$row, $ReceiveDate)
                             ->setCellValue('B'.$row, $reports[$key]['product'])
                             ->setCellValue('C'.$row, $reports[$key]['total'])
                             ->setCellValue('D'.$row, $reports[$key]['qty'])
                             ->setCellValue('E'.$row, $reports[$key]['price'])
                             ->setCellValue('F'.$row, $reports[$key]['subtotal'])
                             ->setCellValue('G'.$row, $LabaStudio)
							 ->setCellValue('H'.$row, $LabaProduk)
							 ->setCellValue('I'.$row, $ModalProduk);

                $objWorksheet->getColumnDimension('A')->setWidth(20);//->setAutoSize(true);
                $objWorksheet->getColumnDimension('B')->setWidth(30);//->setAutoSize(true);
                $objWorksheet->getColumnDimension('C')->setWidth(10);//->setAutoSize(true);
                $objWorksheet->getColumnDimension('D')->setWidth(12);//->setAutoSize(true);
                $objWorksheet->getColumnDimension('E')->setWidth(15);//->setAutoSize(true);
                $objWorksheet->getColumnDimension('F')->setWidth(15);//->setAutoSize(true);
                $objWorksheet->getColumnDimension('G')->setWidth(15);//->setAutoSize(true);
				$objWorksheet->getColumnDimension('H')->setWidth(15);//->setAutoSize(true);
				$objWorksheet->getColumnDimension('I')->setWidth(15);//->setAutoSize(true);

                $row++;
            }
            $objWorksheet->mergeCells('A'.$row1.':A'.($row-1))->setCellValue('A'.$row1, $ReceiveDate)
                         ->mergeCells('A'.$row.':D'.$row)->setCellValue('A'.$row, "Total ".$ReceiveDate)
                                 ->setCellValue('E'.$row, '=SUM(E'.$row1.':E'.($row-1).')')
                                 ->setCellValue('F'.$row, '=SUM(F'.$row1.':F'.($row-1).')')
                                 ->setCellValue('G'.$row, '=SUM(G'.$row1.':G'.($row-1).')')
								 ->setCellValue('H'.$row, '=SUM(H'.$row1.':H'.($row-1).')')
								 ->setCellValue('I'.$row, '=SUM(I'.$row1.':I'.($row-1).')');

            $objWorksheet->getStyle("A4:I".$row)->applyFromArray($styleArray);

            //set title pada sheet (me rename nama sheet)
            $objPHPExcel->getActiveSheet()->setTitle('Laporan Harian');
 

            //Sheet2
            // $objWorksheet2->setCellValue('A1', 'LAPORAN HARIAN CANCEL')
            //              ->setCellValue('A2', 'PERIODE')
            //              ->setCellValue('B2', $datefrom . ' s/d ' . $dateto);

            // $objWorksheet2->setCellValue('A4', 'Tanggal')
            //              ->setCellValue('B4', 'Produk')
            //              ->setCellValue('C4', 'Qty Order')
            //              ->setCellValue('D4', 'Qty Produk')
            //              ->setCellValue('E4', 'Harga Paket')
            //              ->setCellValue('F4', 'Subtotal')
            //              ->setCellValue('G4', 'Laba Studio')
            //              ->setCellValue('H4', 'Laba Produk')
            //              ->setCellValue('I4', 'Modal Produk');

            // $reports = $this->qms_model->getDailyReportsRange2($datefrom,$dateto);

            // $ReceiveDate = "-";
            // $row=5;
            // foreach ($reports as $key => $value) {
            //     $LabaStudio = 0;
            //     $LabaProduk = 0;
            //     $ModalProduk = 0;
            //     $Total = $reports[$key]['total'];

            //     if ($reports[$key]['tipe'] == 'NP'){
            //         $reports[$key]['product'] = $this->qms_model->getProductName($reports[$key]['product_id']);
            //         $TypeID = $this->qms_model->getTypeID($reports[$key]['product_id']);
            //         if($TypeID != 3){
            //             $LabaProduk = $reports[$key]['qty'] * $this->qms_model->getLaba($reports[$key]['product_id']);
            //             $ModalProduk = $reports[$key]['qty'] * $this->qms_model->getModal($reports[$key]['product_id']);
            //         }
            //         else
            //             $LabaStudio = $reports[$key]['qty'] * $this->qms_model->getLabaService($reports[$key]['product_id']);
            //     }
            //     elseif ($reports[$key]['tipe'] == 'PA'){
            //         $prod = $this->qms_model->getPackageDetail($reports[$key]['product_id']);
            //         foreach($prod as $key1 => $value){
            //             $productdetail = "";
            //             $qtydetail = 1;

            //             $productdetail = $prod[$key1]['product_id'];
            //             $qtydetail = $prod[$key1]['qty'];
            //             $TypeID = $this->qms_model->getTypeID($productdetail);

            //             if($TypeID != 3){
            //                 $LabaProduk = $LabaProduk + $reports[$key]['qty'] * $qtydetail * $this->qms_model->getLaba($productdetail);
            //                 $ModalProduk = $ModalProduk + $reports[$key]['qty'] * $qtydetail * $this->qms_model->getModal($productdetail);
            //             }
            //             else
            //                 $LabaStudio = $LabaStudio + $reports[$key]['qty'] * $qtydetail * $this->qms_model->getLabaService($productdetail);



            //         }

            //         $reports[$key]['product'] = $this->qms_model->getPackageName($reports[$key]['product_id']);
            //     }

            //     if($ReceiveDate == "-"){
            //         $ReceiveDate = $reports[$key]['date'];
            //         $row1 = $row;
            //     }
            //     else if($reports[$key]['date'] != $ReceiveDate ){
            //         $objWorksheet2->mergeCells('A'.$row1.':A'.($row-1))->setCellValue('A'.$row1, $ReceiveDate)
            //                      ->mergeCells('A'.$row.':D'.$row)->setCellValue('A'.$row, "Total ".$ReceiveDate)
            //                      ->setCellValue('E'.$row, '=SUM(E'.$row1.':E'.($row-1).')')
            //                      ->setCellValue('F'.$row, '=SUM(F'.$row1.':F'.($row-1).')')
            //                      ->setCellValue('G'.$row, '=SUM(G'.$row1.':G'.($row-1).')')
            //                      ->setCellValue('H'.$row, '=SUM(H'.$row1.':H'.($row-1).')')
            //                      ->setCellValue('I'.$row, '=SUM(I'.$row1.':I'.($row-1).')');
            //         $row++;

            //         $ReceiveDate = $reports[$key]['date'];
            //         $row1 = $row;
            //     }


            //     $objWorksheet2->setCellValue('A'.$row, $ReceiveDate)
            //                  ->setCellValue('B'.$row, $reports[$key]['product'])
            //                  ->setCellValue('C'.$row, $reports[$key]['total'])
            //                  ->setCellValue('D'.$row, $reports[$key]['qty'])
            //                  ->setCellValue('E'.$row, $reports[$key]['price'])
            //                  ->setCellValue('F'.$row, $reports[$key]['subtotal'])
            //                  ->setCellValue('G'.$row, $LabaStudio)
            //                  ->setCellValue('H'.$row, $LabaProduk)
            //                  ->setCellValue('I'.$row, $ModalProduk);

            //     $objWorksheet2->getColumnDimension('A')->setWidth(20);//->setAutoSize(true);
            //     $objWorksheet2->getColumnDimension('B')->setWidth(30);//->setAutoSize(true);
            //     $objWorksheet2->getColumnDimension('C')->setWidth(10);//->setAutoSize(true);
            //     $objWorksheet2->getColumnDimension('D')->setWidth(12);//->setAutoSize(true);
            //     $objWorksheet2->getColumnDimension('E')->setWidth(15);//->setAutoSize(true);
            //     $objWorksheet2->getColumnDimension('F')->setWidth(15);//->setAutoSize(true);
            //     $objWorksheet2->getColumnDimension('G')->setWidth(15);//->setAutoSize(true);
            //     $objWorksheet2->getColumnDimension('H')->setWidth(15);//->setAutoSize(true);
            //     $objWorksheet2->getColumnDimension('I')->setWidth(15);//->setAutoSize(true);

            //     $row++;
            // }
            // $objWorksheet2->mergeCells('A'.$row1.':A'.($row-1))->setCellValue('A'.$row1, $ReceiveDate)
            //              ->mergeCells('A'.$row.':D'.$row)->setCellValue('A'.$row, "Total ".$ReceiveDate)
            //                      ->setCellValue('E'.$row, '=SUM(E'.$row1.':E'.($row-1).')')
            //                      ->setCellValue('F'.$row, '=SUM(F'.$row1.':F'.($row-1).')')
            //                      ->setCellValue('G'.$row, '=SUM(G'.$row1.':G'.($row-1).')')
            //                      ->setCellValue('H'.$row, '=SUM(H'.$row1.':H'.($row-1).')')
            //                      ->setCellValue('I'.$row, '=SUM(I'.$row1.':I'.($row-1).')');

            // $objWorksheet2->getStyle("A4:I".$row)->applyFromArray($styleArray);

             /** Set active sheet index to the first sheet, so Excel opens this as the first sheet */
            $objPHPExcel->setActiveSheetIndex(0);

            //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
 
            //sesuaikan headernya 
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            //ubah nama file saat diunduh
            header('Content-Disposition: attachment;filename="Harian.xlsx"');
            //unduh file
            $objWriter->save("php://output");
 
            //Mulai dari create object PHPExcel itu ada dokumentasi lengkapnya di PHPExcel, 
            // Folder Documentation dan Example
            // untuk belajar lebih jauh mengenai PHPExcel silakan buka disitu
 
        }
    
    public function downloadExcelCancel()
        {
            //load librarynya terlebih dahulu
            //jika digunakan terus menerus lebih baik load ini ditaruh di auto load
            // $this->load->library("PHPExcel");
 
            //membuat objek PHPExcel
            $objPHPExcel = new PHPExcel();
 
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            //set Sheet yang akan diolah 
            // $objPHPExcel->setActiveSheetIndex(0)
            //         //mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya 
            //         //Hello merupakan isinya
            //                             ->setCellValue('A1', 'Hello')
            //                             ->setCellValue('B2', 'Ini')
            //                             ->setCellValue('C1', 'Excel')
            //                             ->setCellValue('D2', 'Pertamaku');

            // $id = $this->uri->segment(6);
            $datefrom = $this->uri->segment(4);;
            $dateto = $this->uri->segment(5);;
            // $date = '2017-09-02';
            // echo $datefrom . ' - ' . $dateto;
            // die;

            $styleArray = array(
                  'borders' => array(
                      'allborders' => array(
                          'style' => PHPExcel_Style_Border::BORDER_THIN
                      )
                  )
              );

            $objWorksheet->setCellValue('A1', 'LAPORAN HARIAN')
                         ->setCellValue('A2', 'PERIODE CANCEL')
                         ->setCellValue('B2', $datefrom . ' s/d ' . $dateto);

            $objWorksheet->setCellValue('A4', 'Tanggal Cancel')
                         ->setCellValue('B4', 'Tanggal Order')
                         ->setCellValue('C4', 'Order No')
                         ->setCellValue('D4', 'Customer')
                         ->setCellValue('E4', 'Down Payment');

            // $reports = $this->qms_model->getDailyReportsAll();

            $reports = $this->qms_model->getCancelReport($datefrom,$dateto);

            $ReceiveDate = "-";
            $row=5;
            foreach ($reports as $key => $value) {
                $LabaStudio = 0;
                $LabaProduk = 0;
                $Total = $reports[$key]['total'];

                if($ReceiveDate == "-"){
                    $ReceiveDate = $reports[$key]['cancel_date'];
                    $row1 = $row;
                }
                else if($reports[$key]['cancel_date'] != $ReceiveDate ){
                    $objWorksheet->mergeCells('A'.$row1.':A'.($row-1))->setCellValue('A'.$row1, $ReceiveDate)
                                 ->mergeCells('A'.$row.':D'.$row)->setCellValue('A'.$row, "Total ".$ReceiveDate)
                                 ->setCellValue('E'.$row, '=SUM(E'.$row1.':E'.($row-1).')');
                    $row++;

                    $ReceiveDate = $reports[$key]['cancel_date'];
                    $row1 = $row;
                }


                $objWorksheet->setCellValue('A'.$row, $ReceiveDate)
                             ->setCellValue('B'.$row, $reports[$key]['date'])
                             ->setCellValue('C'.$row, $reports[$key]['order_no'])
                             ->setCellValue('D'.$row, $reports[$key]['customer_name'])
                             ->setCellValue('E'.$row, $reports[$key]['down_payment']);

                $objWorksheet->getColumnDimension('A')->setWidth(20);//->setAutoSize(true);
                $objWorksheet->getColumnDimension('B')->setWidth(20);//->setAutoSize(true);
                $objWorksheet->getColumnDimension('C')->setWidth(10);//->setAutoSize(true);
                $objWorksheet->getColumnDimension('D')->setWidth(30);//->setAutoSize(true);
                $objWorksheet->getColumnDimension('E')->setWidth(15);//->setAutoSize(true);

                $row++;
            }
            $objWorksheet->mergeCells('A'.$row1.':A'.($row-1))->setCellValue('A'.$row1, $ReceiveDate)
                         ->mergeCells('A'.$row.':D'.$row)->setCellValue('A'.$row, "Total ".$ReceiveDate)
                         ->setCellValue('E'.$row, '=SUM(E'.$row1.':E'.($row-1).')');

            $objWorksheet->getStyle("A4:E".$row)->applyFromArray($styleArray);

            //set title pada sheet (me rename nama sheet)
            $objPHPExcel->getActiveSheet()->setTitle('Laporan Cancel');
 
            //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
 
            //sesuaikan headernya 
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            //ubah nama file saat diunduh
            header('Content-Disposition: attachment;filename="Harian.xlsx"');
            //unduh file
            $objWriter->save("php://output");
 
            //Mulai dari create object PHPExcel itu ada dokumentasi lengkapnya di PHPExcel, 
            // Folder Documentation dan Example
            // untuk belajar lebih jauh mengenai PHPExcel silakan buka disitu
 
        }
    
    public function downloadExcelMonthly()
        {
            //load librarynya terlebih dahulu
            //jika digunakan terus menerus lebih baik load ini ditaruh di auto load
            // $this->load->library("PHPExcel");
 
            //membuat objek PHPExcel
            // $objPHPExcel = new PHPExcel();
            // $objPHPExcel = PHPExcel_IOFactory::load("../templates/Templates_Monthly.xlsx");
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = $objReader->load("./templates/Templates_Monthly.xlsx");

            $objWorksheet = $objPHPExcel->getSheet(0);
            //set Sheet yang akan diolah 
            // $objPHPExcel->setActiveSheetIndex(0)
            //         //mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya 
            //         //Hello merupakan isinya
            //                             ->setCellValue('A1', 'Hello')
            //                             ->setCellValue('B2', 'Ini')
            //                             ->setCellValue('C1', 'Excel')
            //                             ->setCellValue('D2', 'Pertamaku');

            $month = $this->uri->segment(3);
            $year = $this->uri->segment(4);
            
            // echo date("F", mktime(0,0,0,$month,1,2017));
            // die;

            // die;

            // $objWorksheet->setCellValue('A4','PENDAPATAN')
            //              ->setCellValue('A6', 'PENDAPATAN STUDIO')
            //              ->setCellValue('A7', 'PENDAPATAN PRODUK');

            // $reports = $this->qms_model->getDailyReportsAll();

            $reports = $this->qms_model->getDailyReportsMonthly($month,$year);

            // print_r($reports);
            // die;

            $LabaStudio = 0;
            $LabaProduk = 0;
            $ModalProduk = 0;
            foreach ($reports as $key => $value) {
                $Total = $reports[$key]['total'];

                if ($reports[$key]['tipe'] == 'NP'){
                    $reports[$key]['product'] = $this->qms_model->getProductName($reports[$key]['product_id']);
                    $TypeID = $this->qms_model->getTypeID($reports[$key]['product_id']);
                    if($TypeID != 3){
                        $LabaProduk = $LabaProduk + $reports[$key]['qty'] * $this->qms_model->getLaba($reports[$key]['product_id']);
                        $ModalProduk = $ModalProduk + $reports[$key]['qty'] * $this->qms_model->getModal($reports[$key]['product_id']);
                    }
                    else
                        $LabaStudio = $LabaStudio + $reports[$key]['qty'] * $this->qms_model->getLabaService($reports[$key]['product_id']);
                }
                elseif ($reports[$key]['tipe'] == 'PA'){
                    $prod = $this->qms_model->getPackageDetail($reports[$key]['product_id']);
                    foreach($prod as $key1 => $value){
                        $productdetail = "";
                        $qtydetail = 1;

                        $productdetail = $prod[$key1]['product_id'];
                        $qtydetail = $prod[$key1]['qty'];
                        $TypeID = $this->qms_model->getTypeID($productdetail);

                        if($TypeID !=3){
                            $LabaProduk = $LabaProduk + $reports[$key]['qty'] * $qtydetail * $this->qms_model->getLaba($productdetail);
                            $ModalProduk = $ModalProduk + $reports[$key]['qty'] * $qtydetail * $this->qms_model->getModal($productdetail);
                        }
                        else
                            $LabaStudio = $LabaStudio + $reports[$key]['qty'] * $qtydetail * $this->qms_model->getLabaService($productdetail);



                    }
                }
            }
            $objWorksheet->setCellValue('B2', date("F", mktime(0,0,0,$month,1,2017)));
            $objWorksheet->setCellValue('D6', $LabaStudio)
                         ->setCellValue('D7', $LabaProduk);

            // $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);//->setAutoSize(true);
            // $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);//->setAutoSize(true);
            // $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);//->setAutoSize(true);
            // $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);//->setAutoSize(true);

            // $objWorksheet->getStyle("A4:D".$row)->applyFromArray($styleArray);

            //set title pada sheet (me rename nama sheet)
            $objPHPExcel->getActiveSheet()->setTitle('Laporan Bulanan');
 
            //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
 
            //sesuaikan headernya 
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            //ubah nama file saat diunduh
            header('Content-Disposition: attachment;filename="Bulanan.xlsx"');
            //unduh file
            $objWriter->save("php://output");
 
            //Mulai dari create object PHPExcel itu ada dokumentasi lengkapnya di PHPExcel, 
            // Folder Documentation dan Example
            // untuk belajar lebih jauh mengenai PHPExcel silakan buka disitu
 
        }
    
    public function viewDailyReports(){
        $this->load->view('commons/header', $meta);
        $this->load->view('view_daily_reports', $data);
        $this->load->view('commons/footer');
    }



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
