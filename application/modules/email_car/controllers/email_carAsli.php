<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_car extends MX_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -  
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
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
		$this->load->helper('array');
		$this->load->library('form_validation');
		//$this->load->model('dn_model');
	}
	
	function index()
	{
		
		//die;
		//ob_start();
		$this->load->library('email');
		$this->email->set_newline("\r\n");
		
		$DB1 = $this->load->database('default', TRUE); //ims
		
		$x=0;
		$arr = array();
		$units = "";
		$units2 = "";
		$units3 = "";
		
		//CEK APAKAH ADA CAR YANG MASIH BELUM TUNTAS
		// $sql = "SELECT dept_id, lead_auditor, auditor, IFNULL(b.total_open,0) AS total_open
					// FROM audit_internal a 
					// LEFT JOIN (SELECT audit_id, COUNT(id) AS total_open FROM ncr WHERE action_recommendation = 'OPEN' AND (action_deadline > NOW() OR action_deadline IS NULL) GROUP BY audit_id) b ON a.id = b.audit_id ";
		$sql = "SELECT "
		$query = $DB1->query($sql);
		
		
		if ($query->num_rows() > 0) {
			foreach($query->result_array() as $re){
				if($re['total_open'] > 0){
					$arr[$x]['dept_id'] = $re['dept_id'];
					$arr[$x]['lead_auditor'] = $re['lead_auditor'];
					$arr[$x]['auditor'] = $re['auditor'];
				}
				$x++;
			}
			
			$this->email->from('QMS', 'QMS');
			$this->email->subject('Audit Internal Notification');
			
			
				
			foreach($arr as $ar){
				
				$list = array(); 
				$cc = array();
				
				//AMBIL USERNYA
				$sql2 = "SELECT DISTINCT c.`first_name`, c.email FROM audit_internal a
							INNER JOIN users_groups b ON a.`dept_id` = b.`access_group`
							INNER JOIN users c ON c.id = b.`user_id` and a.dept_id = '".$ar['dept_id']."' OR c.id = '".$ar['lead_auditor']."' OR c.id = '".$ar['auditor']."'";
							
				$query2 = $DB1->query($sql2);				
				
				if ($query2->num_rows() > 0) {
					foreach($query2->result_array() as $re){
						
						array_push($list, $re['email']);
					}
					//array_push($list, email);
				}
				
				$msg = "";
				$ncr = "";
				
				//$msg = "<span style='font-family: Arial;'>Dear All</span> <br>";
				$msg = "<br>";
				
				//AMBIL NCR NYA
				$sql3 = "SELECT a.created_by AS auditor, b.`date`, b.`reg_no`, b.`type`, b.`description`, b.`procedure_title`, b.`requirement_no`, b.`category`, b.`clausal_factor`, 
							b.`action`, b.`action_deadline`, b.`action_recommendation`, c.dept_name FROM audit_internal a, ncr b, hris.m_dept c 
							WHERE a.id = b.audit_id AND a.dept_id = '".$ar['dept_id']."' AND a.`dept_id` = c.`dept_code` AND (b.action_deadline >= NOW() OR b.`action_deadline` IS NULL)";
				
				$query3 = $DB1->query($sql3);
				
				if ($query3->num_rows() > 0) {
					foreach($query3->result_array() as $item){
						
						$ncr .= "<tr><td style='font-family: Arial;width:5%;border:1px solid black !important'>".$item['reg_no']."</td>";
						$ncr .= "<td style='font-family: Arial;text-align:center;width:5%;border:1px solid black !important'>".$item['type']."</td>";
						$ncr .= "<td style='font-family: Arial;width:10%;border:1px solid black !important'>".$item['description']."</td>";
						$ncr .= "<td style='font-family: Arial;width:10%;border:1px solid black !important'>".$item['procedure_title']."</td>";
						$ncr .= "<td style='font-family: Arial;text-align:center;width:5%;border:1px solid black !important'>".$item['requirement_no']."</td>";
						$ncr .= "<td style='font-family: Arial;text-align:center;width:10%;border:1px solid black !important'>".$item['category']."</td>";
						$ncr .= "<td style='font-family: Arial;width:10%;border:1px solid black !important'>".$item['clausal_factor']."</td>";
						$ncr .= "<td style='font-family: Arial;width:10%;border:1px solid black !important'>".$item['action']."</td>";
						$ncr .= "<td style='font-family: Arial;width:10%;text-align:center;border:1px solid black !important'>".$item['action_deadline']."</td>";
						$ncr .= "<td style='font-family: Arial;text-align:center;width:5%;text-align:center;border:1px solid black !important'>".$item['action_recommendation']."</td>";
					}
					$msg .= "<br><span style='font-family: Arial; font-size: 24px;'><b>Audit Internal</b> </span><br><br>";
					$msg .= "<table style='border: 0px;border-collapse: collapse;width:40%'>";
					$msg .= "<tr><td style='font-family: Arial;width:20%'>Auditor</td><td>:</td><td style='font-family: Arial;'>".$item['auditor']."</td></tr>";
					$msg .= "<tr><td style='font-family: Arial;width:20%'>Audit Date</td><td>:</td><td style='font-family: Arial;'>".$item['date']."</td></tr>";
					$msg .= "<tr><td style='font-family: Arial;width:20%'>Dept. Auditee</td><td>:</td><td style='font-family: Arial;'>".$item['dept_name']."</td></tr>";
					$msg .= "</table><br>";
					$msg .= "<br><span style='font-family: Arial;'>Please be notified that the NCR(s) that are listed below, are still open and needs your attention : </span><br><br>";
					$msg .= "<table style='border: 1px;border-style:solid;border-collapse: collapse;'>
								<tr style='border-bottom:1px solid black'>
									<td style='width:5%;font-family: Arial;text-align:center;border:1px solid black !important'><b>Reg. No</b></td> <td style='width:5%;font-family: Arial;text-align:center;border:1px solid black !important'><b>Type</b></td>
									<td style='width:10%;font-family: Arial;text-align:center;border:1px solid black !important'><b>Description</b></td><td style='width:10%;font-family: Arial;text-align:center;border:1px solid black !important'><b>Procedure Title</b></td><td style='font-family: Arial;width:5%;text-align:center;border:1px solid black !important'><b>Requirement No</b></td><td style='width:10%;font-family: Arial;text-align:center;border:1px solid black !important'><b>Category</b></td><td style='width:10%;font-family: Arial;text-align:center;border:1px solid black !important'><b>Clausal Factor</b></td><td style='width:10%;font-family: Arial;text-align:center;border:1px solid black !important'><b>Action</b></td><td style='width:10%;font-family: Arial;text-align:center;border:1px solid black !important'><b>Deadline</b></td><td style='width:5%;font-family: Arial;text-align:center;border:1px solid black !important'><b>Status</b></td>
								</tr>";
					$msg .= $ncr."</table><br>";
					
					$msg .= "<span style='font-family: Arial;'>Please update the empty fields of the NCR(s) in the Quality Management System link below : </span><br><br>";
					$msg .= "<a href='http://10.2.2.32/qms'>http://10.2.2.32/qms</a><br><br>";
					$msg .= "<span style='font-family: Arial;'>This email will stop being sent to you if the documents status are closed or the due date has passed or both of the those requirements has been compromised</span><br>";
					$msg .= "<span style='font-family: Arial;'>If the message contents are incorrect, please further contact your IT administrator </span><br>";
					$msg .= "<br><span style='font-family: Arial;'>Thank You</span>";
					
				}
				
				//die(print_r($list));
		
				$this->email->to($list); 
				//$this->email->to('ricky.alexander@bcs-logistics.co.id'); 
				
				if($ar['dept_id']!="D_18"){
					$sql4 = "SELECT DISTINCT c.`first_name`, c.email FROM audit_internal a
							INNER JOIN users_groups b ON a.`dept_id` = b.`access_group`
							INNER JOIN users c ON c.id = b.`user_id` and a.dept_id = 'D_18'";
							
					$query4 = $DB1->query($sql4);				
					
					if ($query4->num_rows() > 0) {
						foreach($query4->result_array() as $re){
							
							array_push($cc, $re['email']);
						}
						
					}
					
					$this->email->cc($cc); 
				}
				
				
				$this->email->message($msg); 
							
				$result = $this->email->send(); 
				
				$this->load->view('content');
				
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
