<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_test extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('array');
		$this->load->library('form_validation');
	}
	
	function index()
	{

		$this->load->library('email');
		$this->email->set_newline("\r\n");
		
		$DB1 = $this->load->database('default', TRUE); //ims
		
		$x=0;
		$arr = array();
		$units = "";
		$units2 = "";
		$units3 = "";
		
		//CEK APAKAH ADA OPEN CAR YANG DEADLINE NYA BELUM LEWAT ATAU DILANJUTKAN
		// car D_33 change D_30 ikut di depan
		/*
		car_no
		description
		reporter
		to
		status
		*/$sql= "SELECT car.`car_no` AS `car_no`,
				car.`description` AS `description`,
				car.`reporter` AS `reporter`,
				car.`to` AS `pic_nya`,
				car.`status` AS `status`
				FROM car,car_detail
				WHERE car.`id` = car_detail.`car_id` 
				AND car .`status` = 'DILANJUTKAN'
				AND car_detail.target > NOW()";
		$query = $DB1->query($sql);
		
		if ($query->num_rows() > 0) {
			
			foreach($query->result_array() as $re){
				if($re['status'] == 'DILANJUTKAN'){

					$arr[$x]['pic_nya']=$re['pic_nya'];
					$arr[$x]['status'] = $re['status'];
				}
				$x++;
			}
			
			$this->email->from('QMS', 'QMS');
			$this->email->subject('Correction Action Report (CAR)');
			
			//foreach($arr as $bok){echo 'what the '.$bok['car_no'].'<br>';}
				
			foreach($arr as $ar){
				
				$list = array(); 
				$cc = array();
				
				//AMBIL USERNYA
				
				$sql2 = "SELECT car.`car_no` AS `car_no`,
						(SELECT view_pic_div.email FROM view_pic_div WHERE view_pic_div.`dept_code` = '".$ar['pic_nya']."') AS email,
						(SELECT view_pic_div.nama FROM view_pic_div WHERE view_pic_div.`dept_code` = '".$ar['pic_nya']."') AS nama_pic,
						car.`status` AS `status`
						FROM car,car_detail
						WHERE car.`id` = car_detail.`car_id` 
						AND car .`status` = 'DILANJUTKAN'
						AND car_detail.target > NOW()";
							
				$query2 = $DB1->query($sql2);				
				
				if ($query2->num_rows() > 0) {
					foreach($query2->result_array() as $re){
						
						array_push($list, $re['email']);
					}
					//array_push($list, email);
				}
				//echo '<b>test';print_r($re['nama_pic']);echo '</b>';
				//echo 'no--'; print_r($list); echo '--no';
				echo '<br>';
				$msg = "";
				$car = "";
				//$msg = "<span style='font-family: Arial;'>Dear All</span> <br>";
				$msg = "<br>";
				
				//AMBIL CAR NYA
				$sql3 = "SELECT (`car`.`id`) AS car_id,
						(`car`.`car_no`) AS car_no,
						(`car`.`description`) AS car_description,
						(`car_detail`.`description`) AS car_description_detail,
						(`car`.`status`) AS car_status,
						(`car_detail`.`action`) AS car_action,
						(`car_detail`.`target`) AS car_target,
						(`car`.`to`) AS car_to_pic,
						(`view_pic_div`.`dept_name`) as car_dept_name,
						(`view_pic_div`.`nama`) as car_pic_name,
						(`view_pic_div`.`email`) AS car_pic_email,
						(SELECT DATEDIFF(car_target,NOW()) )  AS car_remaining_day
						FROM `car`, `car_detail`, `view_pic_div`
						WHERE `car`.`id` = `car_detail`.`car_id`
						AND `car_detail`.`pic` = `view_pic_div`.`dept_code` 
						AND `view_pic_div`.`email` = '".$re['email']."' order by car_remaining_day";
				//echo $ar['email'].'NHdi'.$sql3;
				$query3 = $DB1->query($sql3);
				//echo '<br>';
				//print_r($sql3);
				//echo '<br>';
				if ($query3->num_rows() > 0) {
					foreach($query3->result_array() as $item){
						
						$car .= "<tr><td style='font-family: Arial;width:3%;border:1px solid black !important'>".$item['car_no']."</td>";
						$car .= "<td style='font-family: Arial;text-align:justify;width:15%;border:1px solid black !important'>".$item['car_description']."</td>";
						$car .= "<td style='font-family: Arial;text-align:justify;width:5%;border:1px solid black !important'>".$item['car_description_detail']."</td>";//vertical-align:top;
						$car .= "<td style='font-family: Arial;text-align:justify;width:10%;border:1px solid black !important'>".$item['car_action']."</td>";
						$car .= "<td style='font-family: Arial;text-align:center;width:10%;border:1px solid black !important'>".$item['car_target']."</td>";
						$car .= "<td style='font-family: Arial;text-align:center;width:10%;border:1px solid black !important'>".$item['car_remaining_day']."</td>";//car_remaining_day
						$car .= "<td style='font-family: Arial;color:red;text-align:center;width:10%;border:1px solid black !important'>".$item['car_status']."</td>";
					}
					$msg .= "<br><span style='font-family: Arial; font-size: 24px;'><b>Corrective Action Report (CAR)</b> </span><br><br>";
					$msg .= "<table style='border: 0px;border-collapse: collapse;width:40%'>";
					$msg .= "<tr><td style='font-family: Arial;width:20%'>Departement</td><td>:</td><td style='font-family: Arial;'>".$item['car_dept_name']."</td></tr>";
					$msg .= "<tr><td style='font-family: Arial;width:20%'>Reporter</td><td>:</td><td style='font-family: Arial;'>".$item['car_pic_name']."</td></tr>";
					$msg .= "<tr><td style='font-family: Arial;width:20%'>Email P.I.C.</td><td>:</td><td style='font-family: Arial;'>".$item['car_pic_email']."</td></tr>";
					$msg .= "</table><br>";
					$msg .= "<br><span style='font-family: Arial;'>Please be notified that the CAR(s) that are listed below, are still open and needs your attention : </span><br><br>";
					$msg .= "<table style='border: 1px;border-style:solid;border-collapse: collapse;'>
								<tr style='border-bottom:1px solid black'>
									<td style='width:3%;font-family: Arial;text-align:center;border:1px solid black !important'><b>C.A.R. No.</b></td>
									<td style='width:15%;font-family: Arial;text-align:center;border:1px solid black !important'><b>Description</b></td>
									<td style='width:10%;font-family: Arial;text-align:center;border:1px solid black !important'><b>Description Detail</b></td>
									<td style='font-family: Arial;width:5%;text-align:center;border:1px solid black !important'><b>Car Action</b></td>		
									<td style='width:10%;font-family: Arial;text-align:center;border:1px solid black !important'><b>Due Date</b></td>
									<td style='width:3%;font-family: Arial;text-align:center;border:1px solid black !important'><b>Remaining Days</b></td>
									<td style='width:10%;font-family: Arial;text-align:center;border:1px solid black !important'><b>C.A.R. Status</b></td>
								</tr>";
					$msg .= $car."</table><br>";
					
					$msg .= "<span style='font-family: Arial;'>Please update the empty fields of the C.A.R.(s) in the Quality Management System link below : </span><br><br>";
					$msg .= "<a href='http://10.2.2.32/qms/car' target='_blank'>http://10.2.2.32/qms/car</a><br><br>";
					$msg .= "<span style='font-family: Arial;'>This email will stop being sent to you if the <b><i>C.A.R.(s) status</i></b> are <b><i>TUNTAS</i></b> or the <b><i>Due Date</i></b> has passed or both of the those requirements has been compromised</span><br>";
					$msg .= "<span style='font-family: Arial;'>If the message contents are incorrect, please further contact your IT administrator </span><br>";
					$msg .= "<br><span style='font-family: Arial;'>Thank You</span>";
					
				}
				//die(print_r($list));
		
				//$this->email->to($list); 
				//$this->email->to('nur.haryadi@bcs-logistics.co.id'); 
				
				if($ar['dept_id']!="D_18"){
					$sql4 = "SELECT DISTINCT c.`first_name`, c.email FROM audit_internal a
							INNER JOIN users_groups b ON a.`dept_id` = b.`access_group`
							INNER JOIN users c ON c.id = b.`user_id` and a.dept_id = 'D_18'";
							
					$query4 = $DB1->query($sql4);				
					
					if ($query4->num_rows() > 0) {
						foreach($query4->result_array() as $re){
							
							//array_push($cc, $re['email']);
						}	
					}
					//$this->email->cc('nur.haryadi@bcs-logistics.co.id'); 
				}
				echo $msg;
				$this->email->message($msg); 
							
				$result = $this->email->send(); 
			}
		}
		else{
			//kalau tidak ada result
			$this->fb->log('result not found');
			echo $this->email->print_debugger();
			die;
		}

		die('email sent');
		
	}
		
		

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
